<?php
session_start();

require_once('../funcs.php');
loginCheck();

$id = $_POST['id'];
$jancode = $_POST['jancode'];
$title = $_POST['title'];
$maker = $_POST['maker'];
$expirydate = $_POST['expirydate'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$content = $_POST['content'];
$img = '';


// imgがある場合
if ($_FILES['img']['name']) {
    $fileName = $_FILES['img']['name'];
    $img = date('YmdHis') . '_' . $_FILES['img']['name'];
}


// 簡単なバリデーション処理。
if (trim($_POST['jancode']) === '') {
    $err[] = 'タイトルを確認してください。';
}

if (trim($_POST['title']) === '') {
    $err[] = 'タイトルを確認してください。';
}

if (trim($_POST['maker']) === '') {
    $err[] = 'タイトルを確認してください。';
}

if (trim($_POST['expirydate']) === '') {
    $err[] = 'タイトルを確認してください。';
}

if (trim($_POST['price']) === '') {
    $err[] = 'タイトルを確認してください。';
}

if (trim($_POST['quantity']) === '') {
    $err[] = 'タイトルを確認してください。';
}

if (trim($_POST['content']) === '') {
    $err[] = '内容を確認してください';
}

if (!empty($fileName)) {
    $check =  substr($fileName, -3);
    if ($check != 'jpg' && $check != 'gif' && $check != 'png') {
        $err[] = '画像データを確認してください。';
    }
}

// もしerr配列に何か入っている場合はエラーなので、redirect関数でindexに戻す。その際、GETでerrを渡す。
// if (count($err) > 0) {
//     redirect('post.php?error=1');
// }

/**
 * (1)$_FILES['img']['tmp_name']... 一時的にアップロードされたファイル
 * (2)'../picture/' . $image...写真を保存したい場所。先にフォルダを作成しておく。
 * (3)move_uploaded_fileで、（１）の写真を（２）に移動させる。
 */
if ($_FILES['img']['name']) {
    move_uploaded_file($_FILES['img']['tmp_name'], '../images/' . $img);
}


//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
if ($_FILES['img']['name']) {
    $stmt = $pdo->prepare('UPDATE item_table
                        SET
                            jancode = :jancode,
                            title = :title,
                            maker = :maker,
                            expirydate = :expirydate,
                            price = :price,
                            quantity = :quantity,
                            content = :content,
                            img = :img,
                            update_time = sysdate()
                        WHERE id = :id;');
    $stmt->bindValue(':jancode', $jancode, PDO::PARAM_STR);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':maker', $maker, PDO::PARAM_STR);
    $stmt->bindValue(':expirydate', $expirydate, PDO::PARAM_STR);
    $stmt->bindValue(':price', $price, PDO::PARAM_INT);
    $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->bindValue(':img', $img, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
} else {
    //  画像がない場合imgは省略する。
    $stmt = $pdo->prepare('UPDATE item_table
                        SET
                            jancode = :jancode,
                            title = :title,
                            maker = :maker,
                            expirydate = :expirydate,
                            price = :price,
                            quantity = :quantity,
                            content = :content,
                            update_time = sysdate()
                        WHERE id = :id;');
    $stmt->bindValue(':jancode', $jancode, PDO::PARAM_INT);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':maker', $maker, PDO::PARAM_STR);
    $stmt->bindValue(':expirydate', $expirydate, PDO::PARAM_STR);
    $stmt->bindValue(':price', $price, PDO::PARAM_INT);
    $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
}

$status = $stmt->execute(); //実行

//４．データ登録処理後
if (!$status) {
    sql_error($stmt);
} else {
    redirect('index.php');
}
