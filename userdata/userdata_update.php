<?php
// var_dump($_POST);
// exit();

$username = $_POST['username'];
$password = $_POST['password'];
$id = $_POST['id'];

include("userdata_table.php");
$pdo = connect_to_db();


$sql = "UPDATE users_table SET username=:username, password=:password,
 updated_at=sysdate() WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常に実行された場合は一覧ページファイルに移動し，処理を実行する
  header("Location:userdata_read.php");
  exit();
}
