<?php
    $util = new util;
    $avatar = new avatar;

    if ($util->isLoggedIn()) {
        header('Location: '.$this->dir);
    }

    $title = 'Login | Kaylios';
    $keywords = 'Kaylios, share and capture the moments of your career';
    $desc = 'Kaylios et you capture, follow and share';

    include 'include/header.php'; ?>

<div class="container login-container">
    <a href="signup" class="btn-primary">Need an account</a>
</div>

<div class="input-container">
    <div class="display-text">
        <span>Get started again</span>
    </div>
    <div class="sign-in">
        <form action="" class="login" method="post">

        </form>
    </div>
</div>
