<?php

/**
 * [ここでやりたいこと]
 * 1. クエリパラメータの確認 = GETで取得している内容を確認する
 * 2. select.phpのPHP<?php ?>の中身をコピー、貼り付け
 * 3. SQL部分にwhereを追加
 * 4. データ取得の箇所を修正。
 */

// 1. GETを使ってURLパラメーターからid=●●の部分の情報をとってくることができる
// ?id=1
$id = $_GET['id']; //$idには=の右側のデータが入る


include("funcs.php"); // 外部ファイルを読み込む
$pdo = db_conn();

// try {
//     $db_name = 'gs_db_class3';    //データベース名
//     $db_id   = 'root';      //アカウント名
//     $db_pw   = '';      //パスワード：MAMPは'root'
//     $db_host = 'localhost'; //DBホスト
//     $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
// } catch (PDOException $e) {
//     exit('DB Connection Error:' . $e->getMessage());
// }

//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM gs_bookmark_table WHERE id = :id;');


$stmt->bindValue(':id', $id, PDO::PARAM_INT); // 数値の場合 PDO::PARAM_INT
$status = $stmt->execute();

//３．データ表示
$view = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
}

?>

<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ブックマーク登録</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Head[Start] -->
    <header>
        <nav>
            <a href="select.php">ブックマーク一覧</a>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- method, action, 各inputのnameを確認してください。  -->
    <form method="POST" action="update.php">
        <fieldset>
            
            <input type="hidden" name="id" value="<?= $id; ?>" />
            <?php while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                <legend>ブックマーク更新</legend>
                <label for="book_name">作品名</label>
                <input type="text" id="book_name" name="book_name" value="<?= $result['book_name']; ?>" required placeholder="書籍名を入力">

                <label for="book_url">URL</label>
                <input type="text" id="book_url" name="book_url" value="<?= $result['book_url']; ?>" required placeholder="書籍名のURLを入力">

                <label for="book_comment">感想</label>
                <textarea id="book_comment" name="book_comment" rows="4" value="" required placeholder="書籍を読んだ感想"><?= $result['book_comment']; ?></textarea>
            <?php endwhile; ?>
            <input type="submit" value="更新する">
        </fieldset>
    </form>
</body>

</html>