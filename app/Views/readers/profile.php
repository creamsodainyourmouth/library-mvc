<?php $title = 'Profile' ?>
<div class="Profile">
  <h2>Мои книги</h2>
  <div class="Profile__Person">
    <p>Читательский билет <?= $reader->lib_card ?></p>
    <span>&nbsp; — &nbsp; <?= $user->email ?></span>
  </div>
    <?php if (! $reader->is_activated()): ?>
        <?= include_template('readers/activate_reader') ?>
    <?php endif; ?>

  <div class="BooksList BooksList--My">

    <?php foreach ($books as $book): ?>
      <a class="BookCard BookCard--My" href="/book?id=<?= $book->book_id ?>">
        <div class="BookCard__Frame">
          <img class="BookCard__Cover" src="/<?= $book->cover_path ?>" alt="Book cover">
        </div>
        <div class="BookCard__Text">
          <h4 class="BookCard__Author"> <?= $book->first_name . ' ' . $book->last_name ?></h4>
          <h3 class="BookCard__Title"><?= $book->title ?></h3>
          <div class="BookCard__OrderData">
            <p>Дата выдачи: <?= $book->issue_date ?></p>
            <p>Дата сдачи: <?= $book->delivery_date ?></p>
            <p class="BookCard__MyStatus">Статус книги: <?= $book->status ?></p>
          </div>
          <!--      <div class="BookCard__EditionYear"></div>-->
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</div>




