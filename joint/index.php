<?php $title = '協業提案入力'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/header.php'); ?>
<?PHP
// LOGINチェック
$locationPage = "/match/login/";
if (!sschk()) {
    // ログインしていない場合の処理
    header("Location: $locationPage");
    exit;
}

//プロジェクトid
$projectsid = $_GET["id"];

//1.　データベース接続
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM projects_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $projectsid, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
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
// if ($_SESSION["id"] != $row['userid']) {
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

            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white lg:text-3xl">協業提案の入力</h1>


            <!-- プロジェクト -->
            <div class="max-w-2xl mt-8 px-8 py-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="mt-2">
                    <p class="text-xl font-bold text-gray-700 dark:text-white hover:text-gray-600 dark:hover:text-gray-200 hover:underline"><?= h($row["title"]) ?></p>
                    <p class="mt-2 text-gray-600 dark:text-gray-300"><?= mb_substr(h($row["summary"]),1,50,"UTF-8"). '...'; ?></p>
                </div>
            </div>
            <!-- end プロジェクト -->


            <form method="post" action="/match/joint/joint.php" enctype="multipart/form-data">

                <label for="title" class="block font-bold mt-8 text-gray-500 dark:text-gray-300">タイトル</label>
                <input name="title" type="text" placeholder="提案タイトル" class="block  mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300" />

                <label for="description" class="block font-bold mt-8 text-gray-500 dark:text-gray-300">提案内容</label>
                <textarea name="description" placeholder="提案内容の説明" class="block  mt-2 w-full  placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white px-4 h-32 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300"></textarea>

                <label for="embedded" class="block font-bold mt-8 text-gray-500 dark:text-gray-300">提案資料の埋め込みコード</label>
                <textarea name="embedded" placeholder="提案資料の埋め込みコードを入力してください" class="block  mt-2 w-full  placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-gray-200 bg-white px-4 h-32 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300"></textarea>

                <div class="mt-8 text-center">
                    <input name="userid" type="hidden" value="<?= h($_SESSION['userid'])?>"/>
                    <input name="projectsid" type="hidden" value="<?= $projectsid ?>">
                    <button class="px-12 py-4 text-center font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                    協業提案を送信する
                    </button>
                </div>

            </form>
            
            </div>
        </div>
    </div>
</section>
<!-- end projects -->

<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/footer.php'); ?>