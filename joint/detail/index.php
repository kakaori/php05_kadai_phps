<?php $title = '協業提案詳細'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/header.php'); ?>
<?PHP

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

?>

<!-- joint -->
<section class="max-w-screen-lg m-auto bg-white dark:bg-gray-900">
    <div class="container px-6 py-10 mx-auto">

        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white lg:text-3xl">
            <?= h($row["title"]) ?>
        </h1>

        <p class="mt-6 text-gray-500 dark:text-gray-400 ">
            <?= h($row["description"]) ?>
        </p>
    
        <div class="py-10">
            <h1 class="text-2xl font-semibold text-gray-800 capitalize lg:text-3xl dark:text-white">サブタイトル</h1>
            <p class="mx-auto mt-4 text-gray-500">
                <?= h($row["description"]) ?>
            </p>
        </div>

        <?= $row["embedded"] ?>

        <p class="mt-6 text-gray-500 dark:text-gray-400 ">
            投稿日：<?= h($row["indate"]) ?>
        </p>

    </div>

</section>
<!-- end joint -->

<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/cta_fund.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/footer.php'); ?>