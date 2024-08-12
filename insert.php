<?php

/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */

//1. POSTデータ取得
$book_name = $_POST['book_name']; // 書籍名を取得
$book_url = $_POST['book_url']; // 書籍のURLを取得
$book_comment = $_POST['book_comment']; // 内容を取得



//2. DB接続します
include("funcs.php"); // 外部ファイルを読み込む
$pdo = db_conn();
// try {
//   //ID:'root', Password: xamppは 空白 ''
//   $pdo = new PDO('mysql:dbname=gs_db_class;charset=utf8;host=localhost', 'root', '');
//   // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   // echo "接続成功";
// } catch (PDOException $e) {
//   exit('DBConnectError:' . $e->getMessage());
// }

//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO gs_bookmark_table(book_name, book_url, book_comment, date) VALUES(:book_name, :book_url, :book_comment, NOW())");

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':book_name', $book_name, PDO::PARAM_STR);
$stmt->bindValue(':book_url', $book_url, PDO::PARAM_STR);
$stmt->bindValue(':book_comment', $book_comment, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

// // SQL実行
// try {
//   $status = $stmt->execute();
// } catch (PDOException $e) {
//   exit('SQLError:' . $e->getMessage());
// }


//４．データ登録処理後
if ($status === false) {
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:' . $error[2]);
} else {
  //５．index.phpへリダイレクト
  header("Location: index.php");
  // exit();
}

?>