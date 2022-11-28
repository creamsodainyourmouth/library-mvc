<div class="BooksList BooksList--General">
  <?php foreach ($books as $book): ?>
    <a class="BookCard BookCard--General" href="/book?id=<?= $book->id ?>">
      <div class="BookCard__Frame">
        <img class="BookCard__Cover" src="/<?= $book->cover_path ?>" alt="Book cover">
      </div>
      <div class="BookCard__Text">
        <h4 class="BookCard__Author"> <?= $book->first_name . ' ' . $book->last_name ?></h4>
        <h3 class="BookCard__Title"><?= $book->title ?></h3>
        <p class="BookCard__Edition">Издание: <?= $book->edition_title ?> <?= $book->edition_year ?></p>
        <p class="BookCard__ISBN">ISBN: <?= $book->isbn ?></p>
        <!--      <div class="BookCard__EditionYear"></div>-->
      </div>
    </a>
  <?php endforeach; ?>
</div>
