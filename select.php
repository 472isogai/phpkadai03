<?php
//1.  DB接続します
include("funcs.php"); // 外部ファイルを読み込む
$pdo = db_conn();
// try {
//   //ID:'root', Password: xamppは 空白 ''
//   $pdo = new PDO('mysql:dbname=gs_bookmark_table;charset=utf8;host=localhost', 'root', '');
// } catch (PDOException $e) {
//   exit('DBConnectError:' . $e->getMessage());
// }


//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bookmark_table");

// 保存ボタンを押すのに相当する
// 成功 = true 失敗 = falseが入る
$status = $stmt->execute();

// // SQL実行
// try {
//   $status = $stmt->execute();
// } catch (PDOException $e) {
//   exit('SQLError:' . $e->getMessage());
// }

//３．データ表示
if ($status == false) {
  //execute（SQL実行時にエラーがある場合）
  // $error = $stmt->errorInfo();
  // exit("ErrorQuery:" . $error[2]);
  sql_error($stmt); 
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ブックマーク表示</title>
  <!-- <link rel="stylesheet" href="css/range.css"> -->
  <link href="css/style.css" rel="stylesheet">
</head>



<body id="main">
  <header>
    <nav>
      <a href="index.php">ブックマーク登録</a>
    </nav>
  </header>

  <main>
    <div class="container">
      <h1>ブックマーク一覧</h1>
      <div class="bookmark-list">
        <!-- PHP でデータを取得し、以下の形式で表示する -->
        <?php while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
          <p>
            <?= htmlspecialchars($result['date'], ENT_QUOTES, 'UTF-8') ?> :
            <?= htmlspecialchars($result['book_name'], ENT_QUOTES, 'UTF-8') ?> -
            <?= htmlspecialchars($result['book_url'], ENT_QUOTES, 'UTF-8') ?> -
            <?= htmlspecialchars($result['book_comment'], ENT_QUOTES, 'UTF-8') ?>
            <a href="detail.php?id=<?= htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8') ?>">編集</a>
            <!-- <form method="GET" action="detail.php" class="action-form">
                <input type="hidden" name="id" value="<?= htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8') ?>">
                <input type="submit" value="更新">
            </form> -->
            <form method="POST" action="delete.php">
                <input type="hidden" name="id" value="<?= htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8') ?>">
                <input type="submit" value="削除">
            </form>
          </p>
        <?php endwhile; ?>
        <!-- 
              
        <div class="survey-card">
          <h2>山田 太郎</h2>
          <p class="email">yamada@example.com</p>
          <p class="content">アンケートの内容がここに表示されます。</p>
        </div>  -->
      </div>
    </div>
  </main>

</body>


</html>
