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
$life_flg = $_POST['life_flg'];
//id分を追加
$id = $_POST["id"];

//2.　データベース接続
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "UPDATE projects_table SET life_flg=:life_flg WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':life_flg', $life_flg,    PDO::PARAM_INT);
$stmt->bindValue(':id',       $id,          PDO::PARAM_INT);
$status = $stmt->execute();//SQL実行


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
} else {
    redirect("/match/mypage/");
}