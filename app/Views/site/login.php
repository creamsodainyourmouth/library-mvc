<h2>Авторизация</h2>
<h3><?= $message ?? ''; ?></h3>

<h3><?= app()->auth->user()->name ?? ''; ?></h3>


<?php if (!app()->auth::check()): ?>
<div class="Login">
<form method="POST" class="Form Login__Form">
    <div class="Form__Field Login__Field">
        <label for="email" class="Label Login__Label">Email</label>
        <input type="email" id="email" class="Form__Input Login__Input" name="email">
    </div>
    <div class="Form__Field  Login__Field Login__Field--Last">
        <label for="password" class="Label Login__Label">Пароль</label>
        <input type="password" id="password" class="Form__Input Login__Input" name="password">
    </div>
    <button type="submit" class="Btn BtnArrow Login__Btn">
        <span class="Btn__Text Btn__Text--Login">Войти</span>
    </button>
</form>
</div>

<?php endif; ?>

