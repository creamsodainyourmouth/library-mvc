<!doctype html>
<!--TODO: Change HTML notation to 2 spaces ident-->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/static/style.css">
  <script defer async type="module" src="/static/main.js"></script>
  <title><?= $title ?? "Document" ?></title>
</head>
<body>
<header class="Header">
  <div class="TopBar">
    <div class="Logo">
      <a class="Logo__Link" href="/"><h1>My Library</h1></a>
    </div>
    <div class="AccessPanel">
      <ul class="AccessLinks">
        <?php if (app()->auth::check()): ?>
          <li class="AccessLinks__Item">
            <a class="AccessLinks__Link" href="<?= app()->route->get_url('/profile') ?>">Мои книги</a>
          </li>
            <?php if (app()->auth::user()->isAdmin()): ?>
            <li class="AccessLinks__Item">
              <a class="AccessLinks__Link" href="/admin">Администратор</a>
            </li>
            <?php endif; ?>
          <li class="AccessLinks__Item">
            <a class="AccessLinks__Link" href="<?= app()->route->get_url('/logout') ?>">Выйти</a>
          </li>
        <?php else: ?>
          <li class="AccessLinks__Item">
            <a href="<?= app()->route->get_url('/login') ?>">Войти</a>
          </li>
          <li class="AccessLinks__Item">
            <a href="<?= app()->route->get_url('/signup') ?>">Зарегистрироваться</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
  <nav class="Menu">
    <ul class="Menu__List">
      <li class="Menu__Item"><a class="Menu__Link" href="/about">О библиотеке</a></li>
      <li class="Menu__Item"><a class="Menu__Link" href="/readers">Читателям</a></li>
      <li class="Menu__Item"><a class="Menu__Link" href="/events">Cобытия</a></li>
      <li class="Menu__Item"><a class="Menu__Link" href="/books">Книги</a></li>
      <li class="Menu__Item"><a class="Menu__Link" href="/editions">Издания</a></li>
        <?php if (app()->auth::user() && app()->auth::user()->isAdmin()): ?>
          <li class="Menu__AdminItem">
            <div class="Menu__Item Menu__Item--Admin"><a class="Menu__Link" href="/admin/books">Книги</a></div>
            <div class="Menu__Item Menu__Item--Admin"><a class="Menu__Link" href="/admin/readers">Читатели</a></div>
          </li>
        <?php endif; ?>

    </ul>
  </nav>
</header>
<main class="Content">
    <?= $content ?? ""; ?>
</main>
</body>
</html>
