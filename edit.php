<?php
// var_dump($_GET);
// exit();
// 関数ファイル読み込み
include("dbc.php");
// 送信されたidをgetで受け取る
$id = $_GET['id'];
// DB接続&id名でテーブルから検索
$pdo = dbc();
$sql = 'SELECT * FROM file_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $file = $stmt->fetch(PDO::FETCH_ASSOC);
}



?>



<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>アップデート</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="img_text" style="width: 300px;">
    <img src="<?php echo "{$file['file_path']}"; ?>" alt="">
    <form action="update.php" method="post">
      <textarea name="caption" placeholder="" id="caption" cols="38" rows="10"><?php echo "{$file['description']}"; ?></textarea>
      <input type="submit" value="アップデート">
      <input type="hidden" name="id" value="<?= $file['id'] ?>">
    </form>
  </div>
</body>

</html>