<h2>Регистрация</h2>
<h3><?= $message ?? ''; ?></h3>
<div class="Register Register--Night">
    <form method="POST" class="Form Register__Form">

<!--        TODO: Порядок полей, что мы об этом знаем?-->
        <div class="Form__Field Register__Field">
            <label for="name" class="Label Register__Label">Имя</label>
            <input type="text" autocomplete="off" id="name" class="Form__Input Register__Input" name="name">
        </div>
        <div class="Form__Field Register__Field">
            <label for="surname" class="Label Register__Label">Фамилия</label>
            <input type="text" autocomplete="off" id="surname" class="Form__Input Register__Input" name="surname">
        </div>
        <div class="Form__Field Register__Field">
            <label for="email" class="Label Register__Label">Email</label>
            <input type="email" autocomplete="off" id="email" class="Form__Input Register__Input" name="email">
        </div>
        <div class="Form__Field  Register__Field Register__Field--Last">
            <label for="password" class="Label Register__Label">Пароль</label>
            <input type="password" autocomplete="off" id="password" class="Form__Input Register__Input" name="password">
        </div>
        <button type="submit" class="Btn BtnArrow Register__Btn">
            <span class="Btn__Text Btn__Text--Register">Зарегистрироваться</span>
        </button>
    </form>
</div>
