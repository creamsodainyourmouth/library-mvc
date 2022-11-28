<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;

class OrderedBook extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'book_instance_id',
        'reader_lib_card',
        'issue_date',
        'delivery_date'
    ];

    protected $attributes = [
      'status' => 0
    ];

    const AWAITING_STATUS = 0;
    const IN_USE_STATUS = 1;
    const DELIVERED_STATUS = 2;
    const OVERDUE_STATUS = 3;
    const PREPARING_STATUS = 4;

    const STATUS_LABELS = [
        self::AWAITING_STATUS => 'Ожидает',
        self::IN_USE_STATUS => 'На руках',
        self::OVERDUE_STATUS => 'Просрочена',
        self::PREPARING_STATUS => 'Готовится к выдаче',
        self::DELIVERED_STATUS => 'Сдана',
    ];


    /**
     * Create order book for reader.
     * 
     * @param int $book_instance_id
     * @param int $reader_lib_card
     * @param string $issue_date `dd-mm-yyyy` format
     * @param string $delivery_date `dd-mm-yyyy` format
     * @return void
     */
    public static function create_order(
        int $book_instance_id,
        int $reader_lib_card,
        string $issue_date,
        string $delivery_date
    ): void
    {
        self::create([
            'book_instance_id' => $book_instance_id,
            'reader_lib_card' => $reader_lib_card,
            'issue_date' => $issue_date,
            'delivery_date' => $delivery_date
        ]);
    }

    private static function statuses(): array
    {
        return [
            self::AWAITING_STATUS,
            self::IN_USE_STATUS,
            self::OVERDUE_STATUS,
            self::PREPARING_STATUS,
            self::DELIVERED_STATUS,
        ];
    }

    public static function get_statuses_labels(): array
    {
        return [
            self::AWAITING_STATUS => 'Ожидает читателя',
            self::IN_USE_STATUS => 'На руках',
            self::OVERDUE_STATUS => 'Просрочена',
            self::PREPARING_STATUS => 'Готовится к выдаче',
            self::DELIVERED_STATUS => 'Сдана',
        ];
    }

    /**
     * Set text-label value status property of StdClass objects in array instead code.
     *
     * @param array $items_with_status_property
     * @return void
     */
    public static function set_status_labels(array $items_with_status_property)
    {
        $statuses_labels = self::STATUS_LABELS;
        array_walk($items_with_status_property, function (&$item) use ($statuses_labels) {
            $item->status = $statuses_labels[$item->status];
        });
    }

    public static function create_statuses_counters_from_table(array $statuses_table): array
    {
        $statuses = array_fill_keys(self::statuses(), 0);
        foreach ($statuses_table as $status) {
            $statuses[$status->status_type] = $status->book_instance_count;
        }
        $statuses['sum'] = array_sum($statuses);
        return $statuses;
    }

    public static function ordered_books_joins(): Builder
    {
        return BookInstance::book_instance_joins()
            ->join(
            'ordered_books', 'books_instances.id', '=', 'ordered_books.book_instance_id'
            );
    }
}
