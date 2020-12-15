<?php
// var_dump($_GET);
// exit();
// 関数ファイル読み込み
include("userdata_table.php");
// 送信されたidをgetで受け取る
$id = $_GET['id'];
// DB接続&id名でテーブルから検索
$pdo = connect_to_db();
$sql = 'SELECT * FROM users_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
}



?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>パスワード変更</title>
</head>

<body>
  <form action="userdata_update.php" method="POST">
    <fieldset>
      <legend>パスワード変更</legend>
      <a href="Location:upload_form.php">一覧画面</a>
      <div>
        <p><?= $record["username"] ?></p>
      </div>
      <div>
        password: <input type="text" name="password" value="<?= $record['password'] ?>">
      </div>
      <div>
        <button>変更</button>
      </div>
      <input type="hidden" name="id" value="<?= $record['id'] ?>">
      <input type="hidden" name="username" value="<?= $record['username'] ?>">

    </fieldset>
  </form>

</body>

</html>