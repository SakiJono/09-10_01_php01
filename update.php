<?php
// var_dump($_POST);
// exit();
include("dbc.php");

$caption = $_POST['caption'];
$id = $_POST['id'];
// echo $caption;
// exit();


$pdo = dbc();

$sql = "UPDATE file_table SET description=:description WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':description', $caption, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常に実行された場合は一覧ページファイルに移動し，処理を実行する
  header("Location:upload_form.php");
  exit();
}
