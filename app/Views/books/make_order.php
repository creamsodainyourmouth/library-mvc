

<div class="BookOrder">
  <h2 class="BookOrder__Header">Сделать заказ</h2>

  <h4 class="BookGlass__Author"> <?= $book->first_name . ' ' . $book->last_name ?></h4>
  <h3 class="BookGlass__Title GlassItem"><?= $book->title ?></h3>
    <form method="POST" class="Form BookOrder__Form">
        <input type="hidden" name="book_isbn" value="<?= $book->isbn ?>">
        <input type="hidden" name="reader_lib_card" value="<?= $reader_lib_card ?>">
        <label for="issue_date">Дата выдачи</label>
        <input class="BookOrder__Date" required type="date" id="issue_date" name="issue_date">
        <label for="delivery_date">Дата сдачи</label>
        <input class="BookOrder__Date" required type="date" id="delivery_date" name="delivery_date">
        <button class="Btn Btn--Border BookOrder__Btn" type="submit">Заказать</button>
    </form>
</div>

