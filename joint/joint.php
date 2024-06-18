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

$userid = $_SESSION["userid"];

//1.　POSTデータ取得
$projectsid  = $_POST['projectsid'];
$title       = $_POST['title'];
$description = $_POST['description'];
$embedded    = $_POST['embedded'];

$date = date('Y-m-d H:i:s');


//2.　データベース接続
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "INSERT INTO joint_table(userid,projectsid,title,description,embedded,indate)VALUES(:userid,:projectsid,:title,:description,:embedded,sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userid',      $userid,      PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':projectsid',  $projectsid,  PDO::PARAM_STR);
$stmt->bindValue(':title',       $title,       PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':embedded',    $embedded,    PDO::PARAM_STR);
$status = $stmt->execute();//SQL実行

//４．データ登録処理後
if($status==false){
    sql_error($stmt);
} else {
    redirect("/match/mypage/joint/");
}