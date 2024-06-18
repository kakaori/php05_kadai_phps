<?php $title = 'プロジェクト一覧'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/header.php'); ?>

<?PHP

//1.　データベース接続
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM projects_table WHERE life_flg = 0";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]

?>


<!-- projects -->
<section class="bg-white dark:bg-gray-900">
    <div class="container px-6 py-10 mx-auto">
        <div class="">
            <h1 class="text-2xl font-semibold text-gray-800 capitalize lg:text-3xl dark:text-white">社会問題解決プロジェクト</h1>
            <p class="mt-4 text-gray-500">
                中小企業と協業したい起業家、投資を受けたいプロジェクトを探せます。
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 mt-8 md:mt-16 md:grid-cols-2 xl:grid-cols-3">

            <?php foreach($values as $v){ ?>
            <div>
                <a href="/match/projects/detail/?id=<?=$v["id"]?>">
                    <div class="relative">
                        <img class="object-cover object-center w-full h-64 rounded-lg lg:h-80" src="/match/upload/<?=h($v["upfile"])?>" alt="">

                        <!-- ユーザー -->
                        <div class="absolute bottom-0 flex p-3 bg-white dark:bg-gray-900 ">
                            <img class="object-cover object-center w-10 h-10 rounded-full" src="/match/img/かおりん.jpeg" alt="">

                            <div class="mx-4">
                                <p class="text-sm text-gray-700 dark:text-gray-200">かおりん</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">スーパー起業家</p>
                            </div>
                        </div>
                        <!-- end ユーザー -->
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
            </div>
            <?php } ?>

        </div>
    </div>
</section>
<!-- end projects -->

<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/cta_fund.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/match/inc/footer.php'); ?>
