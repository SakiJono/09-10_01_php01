<?php

$file = $_FILES['image'];
var_dump($file);


// ファイル関連の取得 http://localhost/upload/upload_form.php
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];
$upload_dir = './images/';
$save_filename = date('YmdHis') . $filename;
$err_msgs = array();


//ファイルのバリデーション
// ファイルのサイズが1MB未満か
if ($filesize > 10048576 || $file_err == 2) {
  array_push($err_msgs, 'ファイルサイズが大きすぎます。');
  echo '<br>';
}

// 拡張子は画像形式か
$allow_ext = array('jpg', 'jpeg', 'png');
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);

if (!in_array(strtolower($file_ext), $allow_ext)) {
  array_push($err_msgs, '画像ファイルを添付してください。');
  echo '<br>';
}

if (count($err_msgs) === 0) {
  // ファイルはあるかどうか
  if (is_uploaded_file($tmp_path)) {
    if (move_uploaded_file($tmp_path, $upload_dir . $save_filename)) {
      echo $filename . 'を' . $upload_dir . 'アップしました。';
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

<a href="http://localhost/upload/upload_form.php">戻る</a>