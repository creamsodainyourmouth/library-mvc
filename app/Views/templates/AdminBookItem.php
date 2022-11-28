<div class="Sheet__Ceil BookItem__Author">
    <?= $book->first_name . ' ' . $book->last_name ?>
</div>
<div class="Sheet__Ceil BookItem__Title">
    <a class="BookItem__Link" href="/admin/book?id=<?= $book->book_id ?>"><?= $book->title ?></a>
</div>
<div class="Sheet__Ceil BookItem__Edition">
    <?= $book->edition_title ?>
</div>
<div class="Sheet__Ceil BookItem__EditionYear">
    <?= $book->edition_year ?>
</div>
<div class="Sheet__Ceil BookItem__NewEdition">
    <?= $book->is_new_edition ?>
</div>
<div class="Sheet__Ceil BookItem__OrderCount">
    <?= $book->order_count ?>
</div>
