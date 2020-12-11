<?php

require_once "./dbc.php";
$files = getALLfile();



?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>アップロードフォーム</title>
  <link rel="stylesheet" href="style.css?v">
</head>

<body>
  <div class="upload">

    <div class="form">
      <form action="file_upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image">
        <input type="submit" value="アップロード">
        <textarea name="caption" placeholder="キャプション" id="caption" cols="30" rows="10"></textarea>
      </form>
      <!-- <button><a href="./userdata/userdata_edit.php">password変更</a></button> -->
    </div>

    <div class="img_box">
      <?php foreach ($files as $file) : ?>
        <div class="content">
          <button class="edit"><a href="edit.php?id=<?php echo $file['id'] ?>">edit</a></button>
          <button class="delete"><a href="delete.php?id=<?php echo $file['id'] ?>">×</a></button>
          <div class="img_text">
            <img src="<?php echo "{$file['file_path']}"; ?>" alt="">
            <p><?php echo "{$file['description']}"; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</body>

</html>

<?php
// //ディレクトリ名
// $dir_path = "./images";
// if (is_dir($dir_path)) {
//   if (is_readable($dir_path)) { // ? ファイルが読み込み可能かどうか
//     $ch_dir = dir($dir_path); //ディレクトリクラス
//     //ディレクトリ内の画像を一覧表示
//     while (false !== ($file_name = $ch_dir->read())) {
//       $ln_path = $ch_dir->path . "/" . $file_name;
//       if (@getimagesize($ln_path)) { //画像かどうか？
//         echo "<a href = \"imgview.php?d=" . urlencode(mb_convert_encoding($ln_path, "UTF-8")) . "\" target = \"_blank\" >";
//         echo "<img src = \"" . $ln_path . "\" width=\"200\"></a> ";
//       }
//     }
//     $ch_dir->close();
//   } else {
//     echo "<p>" . htmlspecialchars($dir_path) . "は読み込みが許可されていません。";
//   }
// } else {
//   echo 'DIR 画像がないよ';
// }
?>