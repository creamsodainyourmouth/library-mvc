<div class="BookGlass" href="/book?id=<?= $book->id ?>">
  <div class="BookGlass__Text">

    <h4 class="BookGlass__Author"> <?= $book->first_name . ' ' . $book->last_name ?></h4>
    <h3 class="BookGlass__Title GlassItem"><?= $book->title ?></h3>
    <p class="BookGlass__Annotation GlassItem"><strong>Аннотация: </strong><?= $book->description ?></p>
    <p class="BookGlass__Edition GlassItem"><strong>Издание: </strong> <?= $book->edition_title ?> <?= $book->edition_year ?></p>
    <p class="BookGlass__ISBN GlassItem"><strong>ISBN: </strong><?= $book->isbn ?></p>
    <a class="Btn Btn--Border BookGlass__OrderBtn" href="book/order?id=<?= $book->id?>">Сделать заказ</a>
    <!--      <div class="BookCard__EditionYear"></div>-->
  </div>
  <div class="BookGlass__Frame">
    <img class="Image BookGlass__Cover" src="/<?= $book->cover_path ?>" alt="Book cover">
  </div>
</div>
