<div class="ActivateReader">
    <p>Заполните форму ниже, чтобы заказывать книги.</p>
    <form name="a" method="POST" class="Form ActivateReader__Form">
        <div class="Form__Field ActivateReader__Field">
            <label for="address" class="Form__Label ActivateReader__Label">Адрес</label>
            <input type="text" name="address" autocomplete="off" id="address" class="Form__Input ActivateReader__Input">
        </div>
        <div class="Form__Field ActivateReader__Field">
            <label for="phone" class="Form__Label ActivateReader__Label">Телефон</label>
            <input type="tel" name="phone" autocomplete="off" id="phone" class="Form__Input ActivateReader__Input">
        </div>
        <button type="submit" name="activate" value="activate" class="Btn BtnArrow ActivateReader__Btn">
          <span class="Btn__Text">Активировать профиль</span>
        </button>
    </form>
</div>
