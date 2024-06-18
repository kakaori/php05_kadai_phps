<?php $title = 'プロジェクト詳細'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/header.php'); ?>
<?PHP

$id = $_GET["id"];

//1.　データベース接続
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT projects_table.*, user_table.* FROM projects_table JOIN user_table ON projects_table.userid = user_table.id WHERE projects_table.id=:id";
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

?>

<!-- projects -->
<section class="max-w-screen-lg m-auto bg-white dark:bg-gray-900">
    <div class="container px-6 py-10 mx-auto">

        <h1 class="mt-6 text-2xl font-semibold text-gray-800 dark:text-white lg:text-3xl">
            <?= h($row["title"]) ?>
        </h1>

        <p class="mt-6 text-gray-500 dark:text-gray-400 ">
            <?= h($row["summary"]) ?>
        </p>
    
        <div class="py-10">
            <h1 class="text-2xl font-semibold text-gray-800 capitalize lg:text-3xl dark:text-white">サブタイトル</h1>
            <p class="mx-auto mt-4 text-gray-500">
                <?= h($row["description"]) ?>
            </p>
        </div>

        <?= $row["embedded"] ?>

        <div class="py-10">
            <h1 class="text-2xl font-semibold text-gray-800 capitalize lg:text-3xl dark:text-white">求めている技術</h1>
            <p class="mx-auto mt-4 text-gray-500">
                <?= h($row["want"]) ?>
            </p>
        </div>

        <p class="mt-6 text-gray-500 dark:text-gray-400 ">
            投稿日：<?= h($row["indate"]) ?>
        </p>

        <section class="bg-white dark:bg-gray-900">
            <div class="container flex flex-col items-center px-4 py-12 mx-auto text-center">
                <h2 class="text-2xl font-semibold tracking-tight text-gray-800 xl:text-3xl dark:text-white">
                    協業企業を求めています
                </h2>

                <p class="max-w-4xl mt-6 text-center text-gray-500 dark:text-gray-300">
                    技術提供や共同開発で、この社会問題を解決したい方
                </p>

                <div class="inline-flex w-full mt-6 sm:w-auto">
                    <a href="/match/joint/?id=<?=$id?>" class="inline-block mt-2 px-12 py-4 text-center font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                協業の提案をする
                    </a>
                </div>
            </div>
        </section>


        <!-- ユーザー -->
        <div class="my-4 px-8 py-4 bg-gray-50 rounded-lg shadow-md dark:bg-gray-800">
            <div class="mt-2">
                <p class="mt-2 text-gray-600 dark:text-gray-300"><?= h($row["profile"]) ?></p>
            </div>

            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center">
                    <img class="hidden object-cover w-10 h-10 mr-4 rounded-full sm:block" src="/match/img/かおりん.jpeg" alt="avatar">
                    <p><?= h($row["name"]) ?></p>
                </div>
            </div>
        </div>
        <!-- end ユーザー -->
    </div>

</section>
<!-- end projects -->

<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/cta_fund.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/footer.php'); ?>