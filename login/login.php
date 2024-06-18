<?php
session_start();

//POST値
$email = $_POST["email"];
$lpw   = $_POST["lpw"];

//1.  DB接続します
include($_SERVER['DOCUMENT_ROOT'] . '/match/func/function.php');
$pdo = db_conn();

//2. データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM user_table WHERE email=:email;");
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();//1レコードだけ取得する方法

//5.該当１レコードがあればSESSIONに値を代入
//入力したPasswordと暗号化されたPasswordを比較！[戻り値：true,false]
$pw = password_verify($lpw, $val["lpw"]); //$lpw = password_hash($lpw, PASSWORD_DEFAULT);   //パスワードハッシュ化
if($pw){ 
  //Login成功時
  $_SESSION["chk_ssid"] = session_id();
  $_SESSION["kanri_flg"] = $val['kanri_flg'];
  $_SESSION["life_flg"] = $val['life_flg'];
  $_SESSION["name"]     = $val['name'];
  $_SESSION["userid"]   = $val['id'];//ユーザーのID
  //Login成功時
  redirect("/match/mypage/");
}else{
  //Login失敗時
  redirect("/match/login/");
}