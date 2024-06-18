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
$summary     = $_POST['summary'];
$subtitle    = $_POST['subtitle'];
$description = $_POST['description'];
$embedded    = $_POST['embedded'];
$want        = $_POST['want'];

//id分を追加
$id = $_POST["id"];

//ファイルアップロード処理
// ファイルがアップロードされるディレクトリが存在しない可能性があるため、ディレクトリを作成する
$status = fileUpload("upfile","../../upload/"); //戻り値：ファイル名,1=NG,2=NG
if($status==1 || $status==2){
    $img ="アップロード失敗";
}else{
    $img = $status; //ファイル名
}

//2.　データベース接続
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "UPDATE projects_table SET title=:title, upfile=:upfile, summary=:summary, subtitle=:subtitle, description=:description, embedded=:embedded, want=:want WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title',       $title,       PDO::PARAM_STR);
$stmt->bindValue(':upfile',      $img,         PDO::PARAM_STR);
$stmt->bindValue(':summary',     $summary,     PDO::PARAM_STR);
$stmt->bindValue(':subtitle',    $subtitle,    PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':embedded',    $embedded,    PDO::PARAM_STR);
$stmt->bindValue(':want',        $want,        PDO::PARAM_STR);
$stmt->bindValue(':id',          $id,          PDO::PARAM_STR);
$status = $stmt->execute();//SQL実行


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
} else {
    redirect("/match/mypage/");
}