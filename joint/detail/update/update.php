<?php
session_start();

include($_SERVER['DOCUMENT_ROOT'] . '/match/func/function.php');

// LOGINチェック
$locationPage = "/match/login/";
if (!sschk()) {
    // ログインしていない場合の処理
    header("Location: $locationPage");
    exit;
}

//1.　POSTデータ取得
$userid      = $_POST['userid'];
$title       = $_POST['title'];
$description = $_POST['description'];
$embedded    = $_POST['embedded'];

//id分を追加
$id = $_POST["id"];


//2.　データベース接続
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "UPDATE joint_table SET title=:title, description=:description, embedded=:embedded WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title',       $title,       PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':embedded',    $embedded,    PDO::PARAM_STR);
$stmt->bindValue(':id',          $id,          PDO::PARAM_STR);
$status = $stmt->execute();//SQL実行


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
} else {
    redirect("/match/mypage/joint/");
}