<?php
session_start();
require_once('../funcs.php');
loginCheck();

$jancode = $_POST['jancode'];
$title = $_POST['title'];
$maker = $_POST['maker'];
$expirydate = $_POST['expirydate'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$content  = $_POST['content'];
$img = '';

// 簡単なバリデーション処理追加。
// if(trim($jancode) === '' || trim($title) === '' || trim($maker) === '' || trim($expirydate) === '' || trim($price) === '' || trim($quantity) === '' || trim($content) === '') {
//     redirect('post.php?error=1');
// }


// imgがある場合↓追加
if ($_SESSION['post']['image_data']) {
    // 名前を一意にするため時間を加えている。
    $img = date('YmdHis') . '_' . $_SESSION['post']['file_name'];
}

if ($_SESSION['post']['image_data']) {
    file_put_contents('../images/' . $img, $_SESSION['post']['image_data']);
}

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO item_table(
                            jancode, title, maker, expirydate, price, quantity, content, img, date
                        )VALUES(
                            :jancode, :title, :maker, :expirydate, :price, :quantity, :content, :img, sysdate()
                        )');
$stmt->bindValue(':jancode', $jancode, PDO::PARAM_INT);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':maker', $maker, PDO::PARAM_STR);
$stmt->bindValue(':expirydate', $expirydate, PDO::PARAM_STR);
$stmt->bindValue(':price', $price, PDO::PARAM_INT);
$stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':img', $img, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if (!$status) {
    sql_error($stmt);
} else {
    $_SESSION['post'] = [] ;
    redirect('index.php');
}
