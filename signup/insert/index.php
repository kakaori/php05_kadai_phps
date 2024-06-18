<?php
// 完了画面に直接アクセスされた場合にリダイレクト
$locationPage = "/match/login/";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: $locationPage");
    exit;
}
?>

<?php $title = '新規登録完了'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/header.php'); ?>

<?php
//1.　POSTデータ取得
$name  = $_POST["name"];
$email  = $_POST["email"];
$lpw    = $_POST["lpw"];//password
$lpw    = password_hash($lpw, PASSWORD_DEFAULT);//パスワードハッシュ化

//2.　データベース接続
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "INSERT INTO user_table(name,email,lpw,indate)VALUES(:name,:email,:lpw,sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':email',$email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw'  ,$lpw,   PDO::PARAM_STR);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}

?>

<section class="bg-white dark:bg-gray-900">
    <div class="py-20 container flex items-center justify-center px-6 mx-auto">

        <div action="/match/signup/insert/" method="post" class="w-full max-w-md">
            <h1 class="mt-3 text-2xl font-semibold text-gray-800 capitalize sm:text-3xl dark:text-white">登録が完了しました</h1>

            <p class="mx-auto mt-4 text-gray-500">ログインしてプロフィールを登録してください。</p>

            <div class="mt-6">
                <a href="/match/login/" class="inline-block text-center w-full px-12 py-4 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                    ログインする
                </a>
            </div>
        </div>
    </div>
</section>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/footer.php'); ?>
