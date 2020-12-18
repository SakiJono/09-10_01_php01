<?php

require_once "./dbc.php";

session_start(); // 必須！
check_session_id();
include('userdata_table.php');
$pdo = connect_to_db();
$userid = $_SESSION["id"];


$file = $_FILES['image'];


// ファイル関連の取得 http://localhost/upload/upload_form.php
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];
$upload_dir = './images/';
$save_filename = date('YmdHis') . $filename;
$err_msgs = array();
$save_path = $upload_dir . $save_filename;

// キャプションを取得
$caption = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_SPECIAL_CHARS);

//キャプションのバリデーション
if (empty($caption)) {
  array_push($err_msgs, 'キャプションを入力してください');
}

//140文字か
if (strlen($caption) > 140) {
  array_push($err_msgs, 'キャプションは140文字以内で入力してください');
}


//ファイルのバリデーション
// ファイルのサイズが1MB未満か
if ($filesize > 10048576 || $file_err == 2) {
  array_push($err_msgs, 'ファイルサイズが大きすぎます。');
}

// 拡張子は画像形式か
$allow_ext = array('jpg', 'jpeg', 'png');
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);

if (!in_array(strtolower($file_ext), $allow_ext)) {
  array_push($err_msgs, '画像ファイルを添付してください。');
}

if (count($err_msgs) === 0) {
  // ファイルはあるかどうか
  if (is_uploaded_file($tmp_path)) {
    if (move_uploaded_file($tmp_path, $save_path)) {
      // echo $filename . 'を' . $upload_dir . 'アップしました。';
      //DBに保存（ファイル名、ファイルパス、キャプション）
      $result = fileSave($filename, $save_path, $caption, $userid);

      if ($result) {
        // echo 'データベースに保存しました';
        header('Location:upload_form.php');
        exit();
      } else {
        echo 'データベースへの保存が失敗しました';
      }
    } else {
      echo 'ファイルが保存出来ませんでした。';
    }
  } else {
    echo 'ファイルが選択されていません。';
    echo '<br>';
  }
} else {
  foreach ($err_msgs as $msg) {
    echo $msg;
    echo '<br>';
  }
}

?>

<!-- <a href="http://localhost/upload/upload_form.php">戻る</a> -->