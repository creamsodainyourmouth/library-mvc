<?php
use app\Models\OrderedBook;
?>
<div class="Screen">
  <div class="Sheet__Title">Читатель</div>

  <ul class="Headers Sheet__Columns Sheet__Columns--DetailReaderSelf">
    <li>Билет</li>
    <li>ФИО</li>
    <li>Адрес</li>
    <li>Телефон</li>
    <li>Взято книг</li>
    <li>Просрочено</li>
  </ul>
<ul class="Row ReaderPerson Sheet__Columns Sheet__Columns--DetailReaderSelf">
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
      <?= $stats['sum'] ?>
    </li>
    <li class="ReaderPerson__ExpiredCount">
      <?= $stats[OrderedBook::OVERDUE_STATUS] ?>
    </li>
</ul>

<h2>Книги читателя: <?= $reader->lib_card ?></h2>
<form method="POST">
  <input type="hidden" name="lib_card" value="<?= $reader->lib_card ?>">
  <ul class="Headers Sheet__Columns Sheet__Columns--EditOrders">
    <li>№</li>
    <li>Автор</li>
    <li>Название</li>
    <li>Дата сдачи</li>
    <li>Статус книги</li>
  </ul>

  <?php $i = 1; foreach ($books as $book): ?>
  <ul class=Sheet__Data>
    <li class="Row BookItem Sheet__Columns Sheet__Columns--EditOrders">
      <div class="BookItem__Counter">
          <?= $i ?>
      </div>
      <div class="BookItem__Author">
          <?= $book->first_name . ' ' . $book->last_name ?>
      </div>
      <div class="BookItem__Title">
          <a class="BookItem__Link" href="/admin/book?id=<?= $book->book_id ?>"><?= $book->title ?></a>
      </div>
      <div class="BookItem__DeliveryDate">
          <input type="date" name="new_delivery_dates[<?= $book->order_id ?>]" value="<?= $book->delivery_date ?>">
      </div>
      <div class="BookItem__Status">
        <select name="new_statuses[<?= $book->order_id ?>]" id="status">
        <?php foreach ($statuses_options as $code => $value): ?>
          <option value="<?= $code ?>"
              <?php if ($code === $book->status): ?>selected<?php endif; ?>>
            <?= $value ?>
          </option>
        <?php endforeach; ?>
        </select>
      </div>
    </li>
  </ul>
  <?php ++$i; ?>
  <?php endforeach; ?>
  <div class="ToolBar Sheet__ToolBar">
    <span class="ToolBar__Hint">изменения</span>
    <button type="submit" name="save" value="save" class="Btn Sheet__Btn">Сохранить</button>
  </div>

</form>

</div>
