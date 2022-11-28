<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Query\Builder;

class BookInstance extends Model
{
    const IN_USE_STATUS = 0;
    const EXPIRED_STATUS = 1;

    use HasFactory;

    public $timestamps = false;

    protected $table = 'books_instances';
    protected $fillable = [
        'isbn',
        'book_id',
        'edition_id',
        'edition_year',
        'is_new_edition',
        'edition_note',
        'cover_path'
    ];


    public static function book_instance_joins(): Builder
    {
        return DB::table('books')
            ->join('books_instances', 'books.id', '=', 'books_instances.book_id')
            ->join('editions', 'books_instances.edition_id', '=', 'editions.id')
            ->join('authors_books', 'books_instances.book_id', '=', 'authors_books.book_id')
            ->join('authors', 'authors_books.author_id', '=', 'authors.id');
    }

    public static function bound_general_books_columns(): array
    {
        return [
            'authors.first_name',
            'authors.middle_name',
            'authors.last_name',
            'books.title',
        ];
    }
    /**
     * Returns general books columns (without `is`) for different queries.
     * Columns with `id` are added manually in particular queries.
     *
     * @return string[]
     */
    public static function general_books_columns(): array
    {
        return array_merge([
            'editions.edition_title',
            'books_instances.edition_year',
            'books_instances.isbn',
            'books_instances.cover_path',
            'books_instances.id'
        ],
            self::bound_general_books_columns()
        );
    }

    /**
     * Returns columns books needed to general information about books in list
     * specified for library administrator.
     *
     * @return array
     */
    public static function admin_books_list_columns(): array
    {
        return array_merge(
            ['books_instances.is_new_edition',],
            self::general_books_columns()
        );
    }

    /**
     * Returns columns books needed to general information about books in list.
     *
     * @return string[]
     */
    public static function books_list_columns(): array
    {
        return self::general_books_columns();
    }

    /**
     * Returns columns books needed to detail information.
     *
     * @return array
     */
    public static function detail_book_columns(): array
    {
        return array_merge([
            'books.description',
            'books_instances.is_new_edition',
            'authors_books.author_id',
        ],
            self::general_books_columns()
        );
    }

    /**
     * Returns information about books in list specified for library admin.
     *
     * @return array
     */
    public static function get_admin_books_list(): array
    {
        return OrderedBook::ordered_books_joins()
            ->select(...self::admin_books_list_columns())
            ->selectRaw('count(*) as order_count, books_instances.id as book_id')
            ->where('ordered_books.status', '!=', OrderedBook::DELIVERED_STATUS)
            // ->where('ordered_books.status', '!=', OrderedBook::PREPARING_STATUS)
            ->groupBy(...self::admin_books_list_columns())
            ->groupByRaw('books_instances.id')
            ->get()
            ->toArray();
    }

    /**
     * Returns columns books needed to detail information about book
     * specified for library administrator.
     *
     * @return array
     */
    public static function admin_detail_book_columns(): array
    {
        return array_merge([
        ],
            self::admin_books_list_columns()
        );
    }

    /**
     * Returns readers columns needed to book detail information.
     *
     *
     * @return array
     */
    public static function admin_detail_book_readers_columns(): array
    {
        return [
            'users.name',
            'users.surname',
            'readers.lib_card',
            'ordered_books.issue_date',
            'ordered_books.delivery_date',
            'ordered_books.status',
            'ordered_books.id as order_id',
        ];
    }

    /**
     * Returns extended information about book specified for library administrator.
     * Includes status type count information and readers who order this instance book.
     *
     * @param int $book_instance_id
     * @return array
     */
    public static function get_admin_detail_book(int $book_instance_id): array
    {
        return [
            'book' => self::get_detail_only_book($book_instance_id),
            'statuses' => self::get_orders_statuses_of_book($book_instance_id),
            'readers' => self::get_related_readers_of_book($book_instance_id)
        ];
    }

    // TODO: Full name author
    /**
     * Returns information about books in list.
     *
     * @return array
     */
    public static function get_books_list(): array
    {
        return self::book_instance_joins()
            ->select(...self::books_list_columns())
            ->selectRaw('books_instances.id')
            ->get()
            ->toArray();
    }

    /**
     * Returns detail information for particular book.
     *
     * @param int $book_instance_id
     * @return mixed
     */
    public static function get_detail_book(int $book_instance_id)
    {
        return self::book_instance_joins()
            ->select(...self::detail_book_columns())
            ->where('books_instances.id', $book_instance_id)
            ->get()
            ->first();

    }

    /**
     * Returns related readers for book, that order it.
     * Except those who deliver book already.
     *
     * @param int $book_instance_id
     * @return array
     */
    public static function get_related_readers_of_book(int $book_instance_id): array
    {
        $readers =  self::books_readers_joins()
            ->select(...self::admin_detail_book_readers_columns())
            ->where('books_instances.id', $book_instance_id)
            ->get()
            ->toArray();
        OrderedBook::set_status_labels($readers);
        return $readers;
    }

    /**
     * Returns status types count information of orders instance book.
     *
     * @param int $book_instance_id
     * @return array
     */
    public static function get_orders_statuses_of_book(int $book_instance_id): array
    {
        $statuses = DB::table('ordered_books')
            ->selectRaw('ordered_books.status as status_type, count(*) as book_instance_count')
            ->where('book_instance_id', $book_instance_id)
            ->groupBy('ordered_books.status')
            ->get()
            ->toArray();
        return OrderedBook::create_statuses_counters_from_table($statuses);
    }



    /**
     * Return extended information about instance book only without readers.
     *
     * @param int $book_instance_id
     * @return mixed
     */
    private static function get_detail_only_book(int $book_instance_id)
    {
        return self::book_instance_joins()
            ->select(...self::admin_detail_book_columns())
            ->where('books_instances.id', '=', $book_instance_id)
            // ->where('ordered_books.status', '!=', OrderedBook::PREPARING_STATUS)
            ->get()
            ->first();
    }

    /**
     * Returns a query builder with joined tables needed to
     * retrieve book-readers information.
     *
     * @return Builder
     */
    public static function books_readers_joins(): Builder
    {
        return DB::table('books_instances')
            ->join(
                'ordered_books', 'books_instances.id', '=', 'ordered_books.book_instance_id'
            )
            ->join(
                'readers', 'ordered_books.reader_lib_card', '=', 'readers.lib_card'
            )
            ->join(
                'users', 'readers.user_id', '=', 'users.id'
            );
    }
}