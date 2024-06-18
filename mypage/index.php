<?php $title = 'マイページ'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/header.php'); ?>
<?php
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
$sql = "SELECT * FROM projects_table WHERE userid = :id AND life_flg = 0";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]

?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/mypage.php'); ?>

<!-- projects -->
<section class="bg-white dark:bg-gray-900">
    <div class="container px-6 py-10 mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 capitalize lg:text-3xl dark:text-white">投稿プロジェクト一覧</h2>

        <div class="grid grid-cols-1 gap-8 mt-8 md:grid-cols-2 xl:grid-cols-3">
        <?php foreach($values as $v){ ?>
            <div>
                <a href="/match/projects/detail/?id=<?=h($v["id"])?>">
                    <div class="relative">
                        <img class="object-cover object-center w-full h-64 rounded-lg lg:h-80" src="/match/upload/<?=h($v["upfile"])?>" alt="">
                    </div>

                    <h2 class="mt-6 text-xl font-semibold text-gray-800 dark:text-white">
                        <?=h($v["title"])?>
                    </h2>

                    <hr class="w-32 my-6 text-blue-500">

                    <p class="text-sm mb-2 text-gray-500 dark:text-gray-400">投稿日 <?=$v["indate"]?></p>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <?= mb_substr(h($v["summary"]),1,50,"UTF-8"). '...';?>
                    </p>
                </a>
                <div class="my-4">
                    <a href="/match/register/update/?id=<?=h($v["id"])?>" class="bg-white flex items-center text-gray-700 dark:text-gray-300 justify-center gap-x-3  text-sm sm:text-base  dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800 rounded-lg hover:bg-gray-100 duration-300 transition-colors border px-8 py-2.5">編集する</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- end projects -->

<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/cta_fund.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/footer.php'); ?>
