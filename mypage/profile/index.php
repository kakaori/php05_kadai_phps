<?php $title = 'プロフィール編集'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/header.php'); ?>
<?PHP
// LOGINチェック
$locationPage = "/match/login/";
if (!sschk()) {
    // ログインしていない場合の処理
    header("Location: $locationPage");
    exit;
}

$id = $_SESSION["userid"];

//1.　データベース接続
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM user_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$row = $stmt -> fetch();

// //404
// if (!$row) {
//     http_response_code(404);
//     include($_SERVER['DOCUMENT_ROOT'] . '/match/404.php');
//     exit();
//     $title = 'ページが見つかりません｜Match';
// }
// //403
// if ($_SESSION["userid"] != $row['userid']) {
//   http_response_code(403);
//   include($_SERVER['DOCUMENT_ROOT'] . '/match/register/update/403.php');
//   exit();
// }

?>
<!-- projects -->
<section class="bg-white dark:bg-gray-900">
    <div class="container px-6 py-10 mx-auto">
        <div class="lg:-mx-6 lg:flex justify-center">
            <div class="mt-8 lg:w-1/2 lg:px-6 lg:mt-0">

            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white lg:text-3xl">プロフィール編集</h1>

            <form method="post" action="/match/mypage/profile/update.php" enctype="multipart/form-data">

                <div>
                    <label for="image" class="block font-bold mt-8 text-gray-500 dark:text-gray-300">プロフィール画像</label>
                    <input name="upfile" type="file" accept="image/*" capture="camera" class="block w-full px-3 py-2 mt-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg file:bg-gray-200 file:text-gray-700 file:text-sm file:px-4 file:py-1 file:border-none file:rounded-full dark:file:bg-gray-800 dark:file:text-gray-200 dark:text-gray-300 placeholder-gray-400/70 dark:placeholder-gray-500 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:focus:border-blue-300" />
                </div>


                <label for="title" class="block font-bold mt-8 text-gray-500 dark:text-gray-300">お名前</label>
                <input name="title" type="text" value="<?= h($row["name"]) ?>" class="block  mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300" />

                <label for="title" class="block font-bold mt-8 text-gray-500 dark:text-gray-300">メールアドレス</label>
                <input name="title" type="text" value="<?= h($row["email"]) ?>" class="block  mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300" />

                <label for="title" class="block font-bold mt-8 text-gray-500 dark:text-gray-300">パスワード</label>
                <input name="title" type="text" class="block  mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300" />

                <label for="subtitle" class="block font-bold mt-8 text-gray-500 dark:text-gray-300">ニックネーム</label>
                <input name="subtitle" type="text" value="<?= h($row["nickname"]) ?>" class="block  mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300" />

                <label for="summary" class="block font-bold mt-8 text-gray-500 dark:text-gray-300">プロフィール</label>
                <textarea name="summary" class="block  mt-2 w-full  placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white px-4 h-32 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300"><?= h($row["profile"]) ?></textarea>


                <div class="mt-8 text-center">
                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                    <button class="px-12 py-4 text-center font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                    プロフィールを更新する
                    </button>
                </div>

            </form>

            </div>
        </div>
    </div>
</section>
<!-- end projects -->

<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/footer.php'); ?>