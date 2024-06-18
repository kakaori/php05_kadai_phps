<?php $title = 'Match'; ?>
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
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>


<!-- hero -->
<section class="bg-white dark:bg-gray-900">
    <div class="container px-6 py-16 mx-auto text-center">
        <div class="max-w-lg mx-auto">
            <h1 class="text-3xl font-semibold text-gray-800 dark:text-white lg:text-4xl">世界中の社会問題を解決する</h1>
            <p class="mt-6 text-gray-500 dark:text-gray-300">Matchは、起業家、中小企業、投資家のマッチングを支援することで<br>社会問題を解決します。</p>
        </div>
        <div class="flex justify-center mt-10">
            <img class="object-cover w-full h-96 rounded-xl lg:w-4/5" src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1632&q=80" />
        </div>
    </div>
</section>
<!-- end hero -->

<!-- projects -->
<section class="bg-white dark:bg-gray-900">
    <div class="container px-6 py-10 mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 capitalize lg:text-3xl dark:text-white">新着プロジェクト</h2>

        <!-- <div class="mt-8 lg:-mx-6 lg:flex lg:items-center">
            <img class="object-cover w-full lg:mx-6 lg:w-1/2 rounded-xl h-72 lg:h-96" src="https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80"alt="">

            <div class="mt-6 lg:w-1/2 lg:mt-0 lg:mx-6 ">
                <p class="text-sm text-blue-500 uppercase">category</p>

                <a href="#" class="block mt-4 text-2xl font-semibold text-gray-800 hover:underline dark:text-white">
                    All the features you want to know
                </a>

                <p class="mt-3 text-sm text-gray-500 dark:text-gray-300 md:text-sm">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure veritatis sint autem nesciunt,
                    laudantium quia tempore delect
                </p>

                <a href="/match/projects/detail/" class="inline-block mt-2 text-blue-500 underline hover:text-blue-400">Read more</a>

                <div class="flex items-center mt-6">
                    <img class="object-cover object-center w-10 h-10 rounded-full" src="https://images.unsplash.com/photo-1531590878845-12627191e687?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80" alt="">

                    <div class="mx-4">
                        <h1 class="text-sm text-gray-700 dark:text-gray-200">Amelia. Anderson</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Lead Developer</p>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="grid grid-cols-1 gap-8 mt-8 md:grid-cols-2 xl:grid-cols-3">
        <?php foreach($values as $v){ ?>
            <div>
                <a href="/match/projects/detail/?id=<?=h($v["id"])?>">
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
