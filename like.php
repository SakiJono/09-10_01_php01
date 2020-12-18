<?php
// var_dump($_GET);
// exit();

session_start();
include('dbc.php');
check_session_id();

$userid = $_SESSION["id"];;
$fileid = $_GET['file_id'];

$pdo = dbc();

$sql = 'SELECT COUNT(*) FROM like_table
 WHERE userid=:userid AND fileid=:fileid';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
$stmt->bindValue(':fileid', $fileid, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
  // エラー処理
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
} else {
  $like_count = $stmt->fetch(PDO::FETCH_COLUMN);
  // var_dump($like_count);
  // exit();

  if ($like_count != 0) {
    $sql = 'DELETE FROM like_table WHERE userid=:userid AND fileid=:fileid';
    
  } else {
    $sql = 'INSERT INTO like_table(id, userid, fileid, created_at) VALUES(NULL, :userid, :fileid, sysdate())';
  }
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
  $stmt->bindValue(':fileid', $fileid, PDO::PARAM_INT);
  $status = $stmt->execute();
  if ($status == false) {
    // エラー処理
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
  } else {
    header('Location:upload_form.php');
  }
}
