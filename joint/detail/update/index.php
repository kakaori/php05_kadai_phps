<?php $title = '協業提案編集'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/header.php'); ?>
<?PHP
// LOGINチェック
$locationPage = "/match/login/";
if (!sschk()) {
    // ログインしていない場合の処理
    header("Location: $locationPage");
    exit;
}

$id = $_GET["id"];

//1.　データベース接続
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM joint_table WHERE id=:id";
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

//404
if (!$row) {
    http_response_code(404);
    include($_SERVER['DOCUMENT_ROOT'] . '/match/404.php');
    exit();
    $title = 'ページが見つかりません｜Match';
}
//403
if ($_SESSION["userid"] != $row['userid']) {
  http_response_code(403);
  include($_SERVER['DOCUMENT_ROOT'] . '/match/register/update/403.php');
  exit();
}

?>
<!-- projects -->
<section class="bg-white dark:bg-gray-900">
    <div class="container px-6 py-10 mx-auto">
        <div class="lg:-mx-6 lg:flex justify-center">
            <div class="mt-8 lg:w-1/2 lg:px-6 lg:mt-0">

            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white lg:text-3xl">協業提案編集</h1>

            <form method="post" action="/match/joint/detail/update/update.php" enctype="multipart/form-data">

                <label for="title" class="block font-bold mt-8 text-gray-500 dark:text-gray-300">タイトル</label>
                <input name="title" type="text" value="<?= h($row["title"]) ?>" class="block  mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300" required />

                <label for="description" class="block font-bold mt-8 text-gray-500 dark:text-gray-300">提案内容</label>

                <textarea name="description" class="block  mt-2 w-full  placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white px-4 h-32 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300" required><?= h($row["description"]) ?></textarea>

                <label for="embedded" class="block font-bold mt-8 text-gray-500 dark:text-gray-300">提案資料の埋め込みコード</label>

                <textarea name="embedded" placeholder="提案資料の埋め込みコードを入力してください" class="block  mt-2 w-full  placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white px-4 h-32 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300"><?= h($row["embedded"]) ?></textarea>

                <div class="mt-8 text-center">
                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                    <button class="px-12 py-4 text-center font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                    協業提案を更新する
                    </button>
                </div>

            </form>

            <!-- deleteform - start -->
            <form id="deleteForm" action="/match/joint/detail/update/delete.php" method="post" class="mx-auto max-w-screen-md">
                <div class="mt-4">
                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                    <input type="hidden" name="life_flg" value="1">
                    <button class="px-6 py-4 text-center font-medium tracking-wide capitalize transition-colors duration-300 transform bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                    削除
                    </button>
                </div>
            </form>
            <!-- deleteform - end -->

            </div>
        </div>
    </div>
</section>
<!-- end projects -->

<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/footer.php'); ?>