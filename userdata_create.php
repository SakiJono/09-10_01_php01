<?php

// 送信確認
// var_dump($_FILES);
// exit();

// 項目入力のチェック
// 値が存在しないor空で送信されてきた場合はNGにする
if (
  !isset($_POST['username']) || $_POST['username'] == '' ||
  !isset($_POST['password']) || $_POST['password'] == '' ||
  !isset($_POST['mail']) || $_POST['mail'] == ''
) {
  // 項目が入力されていない場合はここでエラーを出力し，以降の処理を中止する
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

// 受け取ったデータを変数に入れる
$username = $_POST['username'];
$password = $_POST['password'];
$mail = $_POST['mail'];
$file = $_FILES['icon'];
$icon_name = basename($file['name']);
$icon_path = $file['tmp_name'];
$upload_dir = './iconimages/';


$save_icon = $upload_dir . $username . $icon_name;



// DB接続の設定
// DB名は`gsacf_x00_00`にする
include('userdata_table.php');
$pdo = connect_to_db();

// ユーザ存在有無確認
$sql = 'SELECT COUNT(*) FROM users_table WHERE username=:username';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$status = $stmt->execute();

// echo $status;
// exit();

if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}

if ($stmt->fetchColumn() > 0) {
  // user_idが1件以上該当した場合はエラーを表示して元のページに戻る
  // $count = $stmt->fetchColumn();
  echo "<p>すでに登録されているユーザです．</p>";
  echo '<a href="login.php">login</a>';
  exit();
}



// データ登録SQL作成
// `created_at`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する

$sql = 'INSERT INTO users_table(id, username, password, mail, profile_image, created_at, updated_at) VALUES(NULL, :username, :password, :mail, :profile_image, sysdate(), sysdate())';



// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->bindValue(':profile_image', $save_icon, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  if (is_uploaded_file($icon_path)) {
    move_uploaded_file($icon_path, $save_icon);
  }
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  header("Location:userdata_read.php");
  exit();
}
