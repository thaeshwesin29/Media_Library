<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title><?= htmlspecialchars($pageTitle ?? 'Media Library') ?></title>

    <link rel="stylesheet" href="/css/style.css">
</head>

<body>

<div class="page-container">
<div class="content">

<header class="header">
    <div class="wrapper">

        <h1 class="logo">
            <a href="/index.php?page=home">
                <img src="/img/Brand-title.png" alt="Media Library">
            </a>
        </h1>

        <ul class="nav">

            <li class="<?= ($section === 'books') ? 'on' : '' ?>">
                <a href="/index.php?page=catalog&cat=books">
                    <img src="/img/book.png">
                    Books
                </a>
            </li>

            <li class="<?= ($section === 'movies') ? 'on' : '' ?>">
                <a href="/index.php?page=catalog&cat=movies">
                    <img src="/img/movie.png">
                    Movies
                </a>
            </li>

            <li class="<?= ($section === 'music') ? 'on' : '' ?>">
                <a href="/index.php?page=catalog&cat=music">
                    <img src="/img/music.png">
                    Music
                </a>
            </li>

            <li class="<?= ($section === 'suggest') ? 'on' : '' ?>">
                <a href="/index.php?page=suggest">
                    <img src="/img/suggestion.png">
                    Suggest
                </a>
            </li>

            <?php if (!empty($_SESSION['user'])): ?>

                <?php
                    // SAFE SUPPORT FOR DTO OR ARRAY
                    $user = $_SESSION['user'];

                    $userName = is_object($user)
                        ? ($user->name ?? 'User')
                        : ($user['name'] ?? 'User');
                ?>

                <li>
                    <span style="color:#fff;">
                        👤 <?= htmlspecialchars($userName) ?>
                    </span>
                </li>

                <li>
                    <a href="/index.php?page=logout">
                        Logout
                    </a>
                </li>

            <?php else: ?>

                <li>
                    <a href="/index.php?page=login">
                        Login
                    </a>
                </li>

                <li>
                    <a href="/index.php?page=register">
                        Register
                    </a>
                </li>

            <?php endif; ?>

        </ul>

    </div>
</header>

<?php if (empty($hideSearch)): ?>

<div class="search">
    <div class="wrapper">

        <form method="get" action="/index.php">

            <input type="hidden" name="page" value="catalog">

            <?php if (!empty($section)): ?>
                <input type="hidden"
                       name="cat"
                       value="<?= htmlspecialchars($section) ?>">
            <?php endif; ?>

            <label for="s">Search:</label>

            <input type="text" name="s" id="s">

            <input type="submit" value="Go">

        </form>

    </div>
</div>

<?php endif; ?>

<main id="content">