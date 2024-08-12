<?php

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

//1. detail.phpから送られてきたPOSTデータを受け取る
$book_name = $_POST['book_name'];
$book_url = $_POST['book_url'];
$book_comment = $_POST['book_comment'];
$id = $_POST['id'];// これ大事！ input type="hidden"


//2. DB接続します
include("funcs.php"); // 外部ファイルを読み込む
$pdo = db_conn();
// try {
// 		$db_name = 'gs_db_class3';//データベース名
//     $db_id   = 'root';//アカウント名
//     $db_pw   = '';//パスワード：XAMPPはパスワードなしでOK！
//     $db_host = 'localhost';//DBホスト
//     $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
// } catch (PDOException $e) {
//     exit('DBConnectError:' . $e->getMessage());
// }

//3. データ更新SQL作成
$stmt = $pdo->prepare('UPDATE gs_bookmark_table SET book_name = :book_name, book_url = :book_url, book_comment = :book_comment, date = sysdate() WHERE id = :id;');

// バインド変数を設定
$stmt->bindValue(':book_name', $book_name, PDO::PARAM_STR);// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':book_url', $book_url, PDO::PARAM_STR);// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':book_comment', $book_comment, PDO::PARAM_STR);// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':id', $id, PDO::PARAM_INT);// 数値の場合 PDO::PARAM_INT

//4. データ登録処理後
//SQL入力画面で実行ボタンを押すのと同じ
//＄statusには成功か失敗かの結果が入ります（true or false）
$status = $stmt->execute();// 実行

//４．データ登録処理後
// if($status === false){
    // //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    // //関数化
    // sql_error($stmt);
    
    // }else{
    // //５．select.phpへリダイレクト
    // //関数化
    // redirect("select.php");
    // }
    
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    header('Location: select.php');
    exit();
}