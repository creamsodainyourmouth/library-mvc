<?php
use app\Models\OrderedBook;
?>
<div class="Screen">
<div class="Sheet">
  <div class="Sheet__Title">
    <div class="BookCard BookCard--Admin">
      <div class="BookCard__Author"> <?= $book->first_name . ' ' . $book->last_name ?></div>
      <div class="BookCard__Frame">
        <img class="BookCard__Cover" src="/<?= $book->cover_path ?>" alt="Book cover">
      </div>
      <div class="BookCard__Title"><?= $book->title ?></div>
      <div class="BookCard__Edition"><?= $book->edition_title ?> <?= $book->edition_year ?></div>
<!--      <div class="BookCard__EditionYear"></div>-->
    </div>
  </div>

  <ul class="Headers Sheet__Columns Sheet__Columns--AdminDetailBookSelf">
    <li><?= OrderedBook::STATUS_LABELS[OrderedBook::PREPARING_STATUS] ?></li>
    <li><?= OrderedBook::STATUS_LABELS[OrderedBook::OVERDUE_STATUS] ?></li>
    <li><?= OrderedBook::STATUS_LABELS[OrderedBook::IN_USE_STATUS] ?></li>
    <li><?= OrderedBook::STATUS_LABELS[OrderedBook::AWAITING_STATUS] ?></li>
    <li>Всего</li>
  </ul>

  <div class="Sheet_Data">
    <ul class="Row Sheet__Columns Sheet__Columns--AdminDetailBookSelf">
      <li class="BookItem__PreparingStatus">
          <?= $statuses[OrderedBook::PREPARING_STATUS] ?>
      </li>
      <li class="BookItem__OverdueStatus">
          <?= $statuses[OrderedBook::OVERDUE_STATUS] ?>
      </li>
      <li class="BookItem__InUseStatus">
          <?= $statuses[OrderedBook::IN_USE_STATUS] ?>
      </li>
      <li class="BookItem__AwaitingStatus">
          <?= $statuses[OrderedBook::AWAITING_STATUS] ?>
      </li>
      <li class="BookItem__Sum">
          <?= $statuses['sum'] ?>
      </li>
    </ul>
  </div>

</div>

<div class="Sheet">
  <div class="Sheet__Title">Читатели, взявшие книгу</div>

  <ul class="Headers Sheet__Columns Sheet__Columns--AdminDetailBookReaders">
      <li>Билет</li>
      <li>ФИО</li>
      <li>Дата выдачи</li>
      <li>Дата сдачи</li>
      <li>Статус книги</li>
      <li></li>
  </ul>

  <ul class="Sheet__Data">
  <?php foreach ($readers as $reader): ?>
    <li class="Row Sheet__Columns Sheet__Columns--AdminDetailBookReaders">
      <div class="ReaderPerson__Author">
        <?= $reader->lib_card ?>
      </div>
      <div class="ReaderPerson__FullName">
        <a class="ReaderPerson__Link" href="/admin/reader?lib_card=<?= $reader->lib_card ?>">
            <?= $reader->name . ' ' . $reader->surname ?></a>
      </div>
      <div class="ReaderPerson__IssueDate">
        <?= $reader->issue_date ?>
      </div>
      <div class="ReaderPerson__DeliveryDate">
        <?= $reader->delivery_date ?>
      </div>
      <div class="ReaderPerson__Status">
        <?= $reader->status ?>
      </div>
      <div class="">
        <a class="BookItem__EditLink"
           href="/admin/reader/edit-orders?lib_card=<?= $reader->lib_card ?>&editable_orders[]=<?= $reader->order_id?>">
            Изменить
        </a>
      </div>
    </li>
  <?php endforeach; ?>
</ul>
</div>


</div>

