<?php
// var_dump($_POST);
// exit();

session_start(); // セッションの開始
include('userdata_table.php');
$pdo = connect_to_db();
$username = $_POST['username'];
$password = $_POST['password'];


$sql = 'SELECT * FROM users_table
 WHERE username=:username
 AND password=:password
 AND is_deleted=0';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();


$val = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$val) {
  echo "<p>ログイン情報に誤りがあります．</p>";
  echo '<a href="login.php">login</a>';
  exit();
} else {
  $_SESSION = array();
  $_SESSION["session_id"] = session_id();
  $_SESSION["is_admin"] = $val["is_admin"];
  $_SESSION["username"] = $val["username"];
  $_SESSION["id"] = $val["id"];
  header("Location:upload_form.php");
  exit();
}
