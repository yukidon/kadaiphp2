<?php
session_start();
require_once('../funcs.php');
require_once('../common/head_parts.php');
require_once('../common/header_nav.php');

loginCheck();

$jancode = '';
$title = '';
$maker = '';
$expirydate = '';
$price = '';
$quantity = '';
$content = '';

if ($_SESSION['post']['jancode']) {
    $jancode = $_SESSION['post']['jancode'];
}
if ($_SESSION['post']['title']) {
    $title = $_SESSION['post']['title'];
}
if ($_SESSION['post']['maker']) {
    $maker = $_SESSION['post']['maker'];
}
if ($_SESSION['post']['expirydate']) {
    $expirydate = $_SESSION['post']['expirydate'];
}
if ($_SESSION['post']['price']) {
    $price = $_SESSION['post']['price'];
}
if ($_SESSION['post']['quantity']) {
    $quantity = $_SESSION['post']['quantity'];
}
if ($_SESSION['post']['content']) {
    $content = $_SESSION['post']['content'];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
<?= $head_parts ?>

    <title>商品管理</title>
</head>

<body>
<?= $header_nav ?>

    <!-- // もしURLパラメータがある場合 -->
    <?php if (isset($_GET['error'])) : ?>
        <p class="text-danger">エラーです</p>
    <?php endif ; ?>

    <form method="POST" action="confirm.php" enctype="multipart/form-data">

    <div class="mb-3">
            <label for="jancode" class="form-label">JANコード</label>
            <input type="text" class="form-control" name="jancode" id="jancode" aria-describedby="jancode" value="<?= $jancode ?>">
            <div id="emailHelp" class="form-text">※JANコードから、商品情報を呼び出しできます</div>
            </div>

        <div class="mb-3">
            <label for="title" class="form-label">商品名</label>
            <input type="text" class="form-control" name="title" id="title" aria-describedby="title" value="<?= $title ?>">
            <div id="emailHelp" class="form-text">※入力必須</div>
        </div>

        <div class="mb-3">
            <label for="maker" class="form-label">製造者</label>
            <input type="text" class="form-control" name="maker" id="maker" aria-describedby="maker" value="<?= $maker ?>">
            <div id="emailHelp" class="form-text">※入力必須</div>
        </div>

        <div class="mb-3">
            <label for="expirydate" class="form-label">賞味期限</label>
            <input type="date" class="form-control" name="expirydate" id="expirydate" aria-describedby="expirydate" value="<?= $expirydate ?>">
            <div id="emailHelp" class="form-text">※入力必須</div>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">小売希望価格</label>
            <input type="number" class="form-control" name="price" id="price" aria-describedby="price" value="<?= $price ?>">
            <div id="emailHelp" class="form-text">※寄附受取に必要なポイントを、小売希望価格に合わせて設定します</div>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">寄附数量</label>
            <input type="number" class="form-control" name="quantity" id="quantity" aria-describedby="quantity" value="<?= $quantity ?>">
            <div id="emailHelp" class="form-text">※入力必須</div>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">商品紹介</label>
            <textArea type="text" class="form-control" name="content" id="content" aria-describedby="content" rows="4" cols="40"><?= $content ?></textArea>
            <div id="emailHelp" class="form-text">※入力必須</div>
        </div>

        <div class="mb-3">
            <label for="`img" class="form-label">画像</label>
            <input type="file" class="form-control" name="img">
        </div>

        <button type="submit" class="btn btn-primary">投稿する</button>
    </form>
</body>
</html>
