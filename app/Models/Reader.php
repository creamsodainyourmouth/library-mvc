<?php

namespace app\Models;

use core\Src\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

use Illuminate\Database\Capsule\Manager as DB;

class Reader extends Model
{
    use HasFactory;

    const ACTIVATED_READER = 1;
    const INACTIVATED_READER = 0;

    public $timestamps = false;

    protected $primaryKey = 'user_id';
    protected $attributes = [
        'is_activated' => false,
    ];

    // readers.lib_card property is AI

    protected $fillable = [
        'address',
        'user_id'
    ];

    /**
     * Activate reader's profile to order books.
     *
     * @param string $address
     * @param string $phone_number
     * @return void
     */
    public function activate_reader(string $address, string $phone_number)
    {
        $this->address = $address;
        $this->is_activated = true;
        $this->save();
        Phone::create([
            'number' => $phone_number,
            'user_id' => $this->user_id,
        ]);
    }

    public function is_activated(): bool
    {
        return $this->is_activated === 1;
    }



    public static function find_by_user_id(int $user_id): self
    {
        return self::find($user_id);
    }

    public function get_id(): int
    {
        return $this->id;
    }

    public function get_lib_card()
    {
        return $this->lib_card;
    }

    /**
     * Returns reader lib card by user_id.
     *
     * @param int $user_id
     * @return mixed|null
     */
    public static function get_lib_card_by_user_id(int $user_id)
    {
        return DB::table('readers')
            ->select('readers.lib_card')
            ->join('users', 'readers.user_id', '=', 'users.id')
            ->where('users.id', $user_id)
            ->value('readers.lib_card');
    }

    private static function readers_phones_orders_joins(): Builder
    {
        return DB::table('readers')
            ->join(
                'users', 'readers.user_id', '=', 'users.id'
            )
            ->join(
                'phones', 'users.id', '=', 'phones.user_id'
            )
            ->join(
                'ordered_books', 'readers.lib_card', '=', 'ordered_books.reader_lib_card'
            );
   }

    public function get_ordered_books(): array
    {
        $books = OrderedBook::ordered_books_joins()
            ->selectRaw('*')
            ->selectRaw('books_instances.id as book_id')
            ->where('reader_lib_card', $this->lib_card)
            ->where('status', '!=', OrderedBook::DELIVERED_STATUS)
            ->orderBy('books_instances.id', 'desc')
            ->get()
            ->toArray();
        OrderedBook::set_status_labels($books);
        return $books;
    }

    private static function get_ordered_books_of_reader(int $reader_lib_card): array
    {
        $ordered_books = OrderedBook::ordered_books_joins()
            ->select(self::admin_detail_reader_ordered_books_columns())
            ->where('reader_lib_card', $reader_lib_card)
            ->selectRaw('books_instances.id as book_id')
            ->get()
            ->toArray();
        OrderedBook::set_status_labels($ordered_books);
        return $ordered_books;
    }

    public static function get_editable_ordered_books_of_reader(int $reader_lib_card, array $editable_orders_ids): array
    {
        return OrderedBook::ordered_books_joins()
            ->select(self::admin_detail_reader_ordered_books_columns())
            ->where('reader_lib_card', $reader_lib_card)
            ->selectRaw('books_instances.id as book_id')
            ->whereIn('ordered_books.id', $editable_orders_ids)
            ->get()
            ->toArray();
    }


    /**
     * Return columns needed for admin readers list.
     *
     * @return string[]
     */
    // TODO: Potentially it is can be an Interface with general, detail, list columns
    // for different models.
    private static function general_readers_columns(): array
    {
        return [
            'readers.lib_card',
            'users.name',
            'users.surname',
            'phones.number'
        ];
    }

    private static function admin_readers_list_columns(): array
    {
        return array_merge(
            [
                'readers.address',
            ],
            self::general_readers_columns()
        );
    }

    /**
     * Returns columns for select statement of detail reader.
     *
     * @return array
     */
    private static function admin_detail_reader_columns(): array
    {
        // + columns with overdue books count
        return self::admin_readers_list_columns();
    }

    private static function admin_detail_reader_ordered_books_columns(): array
    {
        return array_merge([
            'ordered_books.issue_date',
            'ordered_books.delivery_date',
            'ordered_books.status',
            'ordered_books.id as order_id',
        ],
            BookInstance::bound_general_books_columns());
    }

    /**
     * Return statuses types count information orders of reader.
     *
     * @param int $reader_lib_card
     * @return array
     */
    public static function get_orders_statuses_of_reader(int $reader_lib_card): array
    {
        $statuses = DB::table('ordered_books')
            ->selectRaw('ordered_books.status as status_type, count(*) as book_instance_count')
            ->where('reader_lib_card', $reader_lib_card)
            ->groupBy('ordered_books.status')
            ->get()
            ->toArray();
        return OrderedBook::create_statuses_counters_from_table($statuses);
    }

    /**
     * Return statuses types count information orders of reader.
     * Instance version.
     *
     * @return array
     */
    public function get_orders_statuses(): array
    {
        return self::get_orders_statuses_of_reader($this->lib_card);
    }

    /**
     * Returns readers list for library administration.
     *
     * @return array
     */
    public static function get_admin_readers_list(): array
    {
        return self::readers_phones_orders_joins()
            ->select(...self::admin_readers_list_columns())
            ->selectRaw('count(*) as orders_count')
            ->groupBy(self::admin_readers_list_columns())
            ->get()
            ->toArray();
   }

    /**
     * Return detail information of reader only.
     *
     * @param int $reader_lib_card
     * @return mixed
     */
    public static function get_admin_detail_reader_only(int $reader_lib_card)
    {
        return self::readers_phones_orders_joins()
            ->select(self::admin_detail_reader_columns())
            ->where('readers.lib_card', $reader_lib_card)
            ->get()
            ->first();
    }

    /**
     * Returns extended information of reader for library administrator.
     * Includes statuses types orders count and ordered books of this reader.
     *
     * @param int $reader_lib_card
     * @return array
     */
    public static function get_admin_detail_reader(int $reader_lib_card): array
    {
        return [
            'reader' => self::get_admin_detail_reader_only($reader_lib_card),
            'statuses' => self::get_orders_statuses_of_reader($reader_lib_card),
            'ordered_books' => self::get_ordered_books_of_reader($reader_lib_card)
        ];
        
    }    
}