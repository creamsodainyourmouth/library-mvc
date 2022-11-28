<div class="Screen">

<div class="Sheet">
  <div class="Sheet__Title">Книги</div>

  <div class="Sheet__Corpus">
    <ul class="Headers Sheet__Columns Sheet__Columns--BooksList">
      <li class="Sheet__HeadersCeil">№</li>
      <li class="Sheet__HeadersCeil">Автор</li>
      <li class="Sheet__HeadersCeil">Название</li>
      <li class="Sheet__HeadersCeil">Издание</li>
      <li class="Sheet__HeadersCeil">Год</li>
      <li class="Sheet__HeadersCeil">Новое</li>
      <li class="Sheet__HeadersCeil Sheet__Ceil--Last">Взято</li>
    </ul>

    <ul class="Sheet__Data">
      <?php $i = 1; foreach ($books as $book): ?>
        <li class="Row Sheet__Columns Sheet__Columns--BooksList">
          <div class="BookItem__Counter">
            <?= $i ?>
          </div>
          <div class="BookItem__Author">
            <?= $book->first_name . ' ' . $book->last_name ?>
          </div>
          <div class="BookItem__Title">
            <a class="BookItem__Link" href="/admin/book?id=<?= $book->book_id ?>"><?= $book->title ?></a>
          </div>
          <div class="BookItem__Edition">
            <?= $book->edition_title ?>
          </div>
          <div class="BookItem__EditionYear">
            <?= $book->edition_year ?>
          </div>
          <div class="BookItem__NewEdition">
            <?= $book->is_new_edition ?>
          </div>
          <div class="Sheet__Ceil Sheet__Ceil--Last BookItem__OrderCount">
            <?= $book->order_count ?>
          </div>
        </li>
      <?php ++$i; ?>
      <?php endforeach; ?>
    </ul>
  </div>
</div>


</div>

