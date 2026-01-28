<?php

$loggedIn = $_SESSION['loggedIn'] ?? false;

?>

<!-- header blueprint -->
<header>
    <h1><a href="/leopi/index.php"><img src="<?= '/leopi/img/logo.png' ?>" alt="logo" id="logo">Leoπ</a></h1>
    <nav>
        <a href="/leopi/index.php">Welcome</a>
        <a href="/leopi/startpage/startpage.php">Startpage</a>
        <?php if ($loggedIn): ?>
            <a href="/leopi/inc/logout.php">Logout</a>
        <?php elseif (!$loggedIn): ?>
            <a href="/leopi/login/login.php">Login</a>
        <?php endif ?>
    </nav>
</header>