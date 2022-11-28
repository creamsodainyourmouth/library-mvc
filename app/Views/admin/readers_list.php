<div class="Screen">

<div class="Sheet">
  <div class="Sheet__Title">Читатели</div>
  <div class="Sheet__Corpus">
    <ul class="Headers Sheet__Columns Sheet__Columns--ReadersList">
      <li>№</li>
      <li>Билет</li>
      <li>ФИО</li>
      <li>Адрес</li>
      <li>Телефон</li>
      <li>Взято книг</li>
    </ul>

    <ul class="Sheet__Data">
      <?php $i = 1; foreach ($readers as $reader): ?>
        <li class="Row Sheet__Columns Sheet__Columns--ReadersList">
          <div class="ReaderPerson__Counter">
            <?= $i ?>
          </div>
          <div class="ReaderPerson__LibCard">
            <?= $reader->lib_card ?>
          </div>
          <div class="ReaderPerson__FullName">
            <a class="ReaderPerson__Link" href="/admin/reader?lib_card=<?= $reader->lib_card ?>">
              <?= $reader->name . ' ' . $reader->surname ?></a>
          </div>
          <div class="ReaderPerson__Address">
            <?= $reader->address ?>
          </div>
          <div class="ReaderPerson__Phone">
            <?= $reader->number ?>
          </div>
          <div class="ReaderPerson__BooksCount">
            <?= $reader->orders_count ?>
          </div>
        </li>
      <?php ++$i; ?>
      <?php endforeach; ?>
    </ul>
  </div>

</div>


</div>