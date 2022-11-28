<?php
use app\Models\OrderedBook;
?>
<div class="Screen">

<div class="Sheet">
  <div class="Sheet__Title">Читатель</div>
    <ul class="Headers Sheet__Columns Sheet__Columns--DetailReaderSelf">
      <li>Билет</li>
      <li>ФИО</li>
      <li>Адрес</li>
      <li>Телефон</li>
      <li>Взято книг</li>
      <li>Просрочено</li>
    </ul>

  <div class="Sheet__Data">
    <ul class="Row Sheet__Columns Sheet__Columns--DetailReaderSelf">
      <li class="ReaderPerson__LibCard">
          <?= $reader->lib_card ?>
      </li>
      <li class="ReaderPerson__FullName">
          <?= $reader->name . ' ' . $reader->surname ?>
      </li>
      <li class="ReaderPerson__Address">
          <?= $reader->address ?>
      </li>
      <li class="ReaderPerson__Phone">
          <?= $reader->number ?>
      </li>
      <li class="ReaderPerson__BooksCount">
          <?= $statuses['sum'] ?>
      </li>
      <li class="ReaderPerson__ExpiredCount">
          <?= $statuses[OrderedBook::OVERDUE_STATUS] ?>
      </li>
    </ul>
  </div>

</div>

<div class="Sheet">
  <div class="Sheet__Title">Книги читателя <?= $reader->lib_card ?></div>
  <div class="Sheet__Corpus">
    <form method="POST" action="/admin/reader/edit-orders">
      <input type="hidden" name="lib_card" value="<?= $reader->lib_card ?>">
      <ul class="Headers Sheet__Columns Sheet__Columns--DetailReaderBooks">
        <li>№</li>
        <li>Автор</li>
        <li>Название</li>
        <li>Дата выдачи</li>
        <li>Дата сдачи</li>
        <li>Статус книги</li>
        <li>
          <label>
            <input class="Checkbox Checkbox--AllChecker" type="checkbox">
            <span class="Checkbox__text">Все</span>
          </label>
        </li>
        <li></li>
      </ul>
      <?php $i = 1; foreach ($books as $book): ?>
      <ul class="">
        <li class="Row BookItem Sheet__Columns Sheet__Columns--DetailReaderBooks">
          <div class="BookItem__Counter">
            <?= $i ?>
          </div>
          <div class="BookItem__Author">
            <?= $book->first_name . ' ' . $book->last_name ?>
          </div>
          <div class="BookItem__Title">
            <a class="BookItem__Link" href="/admin/book?id=<?= $book->book_id ?>"><?= $book->title ?></a>
          </div>
          <div class="BookItem__IssueDate">
            <?= $book->issue_date ?>
          </div>
          <div class="BookItem__DeliveryDate">
            <?= $book->delivery_date ?>
          </div>
          <div class="BookItem__Status">
            <?= $book->status ?>
          </div>
          <div class="BookItem__Select">
            <input class="Checkbox Ceil__Checkbox" type="checkbox" name="editable_orders[]" value="<?= $book->order_id ?>">
          </div>
          <div class="BookItem__Edit">
            <a class="BookItem__EditLink"
               href="/admin/reader/edit-orders?lib_card=<?= $reader->lib_card ?>&editable_orders[]=<?= $book->order_id?>">
                Изменить
            </a>
          </div>
        </li>
        <?php ++$i; ?>
        <?php endforeach; ?>
      </ul>
      <div class="ToolBar Sheet__ToolBar">
        <span class="ToolBar__Hint">отмеченное</span>
        <button class="Btn Sheet__Btn Btn--MassEdit">Изменить</button>
      </div>
    </form>
  </div>
</div>


</div>