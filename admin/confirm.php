<?php
// confirm.phpの中身は、ほとんどpost.phpに似ています。

session_start();
require_once('../funcs.php');
require_once('../common/head_parts.php');
require_once('../common/header_nav.php');
loginCheck();

// post受け取る
$jancode = $_SESSION['post']['jancode']= $_POST['jancode'];
$title = $_SESSION['post']['title']= $_POST['title'];
$maker = $_SESSION['post']['maker'] = $_POST['maker'];
$expirydate = $_SESSION['post']['expirydate'] = $_POST['expirydate'];
$price = $_SESSION['post']['price'] = $_POST['price'];
$quantity = $_SESSION['post']['quantity'] = $_POST['quantity'];
$content = $_SESSION['post']['content'] = $_POST['content'];

// 簡単なバリデーション処理。
if(trim($jancode) === '' || trim($title) === '' || trim($maker) === '' || trim($expirydate) === '' || trim($price) === '' || trim($quantity) === '' || trim($content) === '') {
    redirect('post.php?error=1');
}


// imgある場合
// var_dump($_FILES);
if ($_FILES['img']['name']) {
    $file_name = $_SESSION['post']['file_name']= $_POST['img']['name'];
    // 一時保存されているファイル内容を取得して、セッションに格納
    $image_data = $_SESSION['post']['image_data'] = file_get_contents($_FILES['img']['tmp_name']);
    // 一時保存されているファイルの種類を確認して、セッションにその種類に当てはまる特定のintを格納
    $image_type = $_SESSION['post']['image_type'] = exif_imagetype($_FILES['img']['tmp_name']);
} else {
    $image_data = $_SESSION['post']['image_data'] = '';
    $image_type = $_SESSION['post']['image_type'] = '';
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
    
    <!-- errorを受け取ったら、エラー文出力。 -->

    <form method="POST" action="register.php" enctype="multipart/form-data" class="mb-3">

    <div class="mb-3">
            <label for="jancode" class="form-label">JANコード</label>
            <input type="hidden"name="jancode" value="<?= $jancode ?>">
            <p><?= $jancode ?></p>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">商品名</label>
            <input type="hidden"name="title" value="<?= $title ?>">
            <p><?= $title ?></p>
        </div>

        <div class="mb-3">
            <label for="maker" class="form-label">製造者</label>
            <input type="hidden"name="maker" value="<?= $maker ?>">
            <p><?= $maker ?></p>
        </div>

        <div class="mb-3">
            <label for="expirydate" class="form-label">賞味期限</label>
            <input type="hidden"name="expirydate" value="<?= $expirydate ?>">
            <p><?= $expirydate ?></p>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">小売希望価格</label>
            <input type="hidden"name="price" value="<?= $price ?>">
            <p><?= $price ?></p>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">寄附数量</label>
            <input type="hidden"name="quantity" value="<?= $quantity ?>">
            <p><?= $quantity ?></p>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">商品紹介</label>
            <input type="hidden"name="content" value="<?= $content ?>">
            <div><?= nl2br($content) ?></div>
        </div>

        <?php if ($image_data) : ?>
            <div class="mb-3">
                <img src="image.php">
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">登録</button>
    </form>

    <a href="post.php?re-register=true">前の画面に戻る</a>
</body>
</html>
