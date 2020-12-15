<?php
require_once "./dbc.php";
$files = getALLfile();
?>

<?php
session_start(); // 必須！
check_session_id();
include('userdata_table.php');
$pdo = connect_to_db();

// データ取得SQL作成
$sql = 'SELECT * FROM users_table';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();
if ($status == false) {
  $error = $stmt->errorInfo();
  exit('sqlError:' . $error[2]);
} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $json = json_encode($result);
}
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
  <header class="header">
    <div><img src="" alt=""><?php echo $_SESSION["username"]; ?></div>
    <div class="headerbtn">Home</div>
    <div class="headerbtn">Search</div>
    <div class="headerbtn"><a href="logout.php">logout</a></div>
    <div class="headerbtn"><a href="userdata_read.php">Administrator</a></div>
  </header>

  <div class="upload">

    <div>
      <div class="form">
        <img src="" id="preview" class="preview">
        <form action="file_upload.php" method="post" enctype="multipart/form-data">
          <input type="file" name="image" id="file1" accept="image/*">
          <input type="submit" value="アップロード">
          <textarea name="caption" placeholder="キャプション" id="caption" cols="32" rows="10"></textarea>
        </form>
      </div>

      <!-- <button><a href="./userdata/userdata_edit.php">password変更</a></button> -->
    </div>

    <div class="img_box">
      <?php foreach ($files as $file) : ?>
        <div class="content">
          <button class="edit"><a href="edit.php?id=<?php echo $file['id'] ?>" class="edit_a">edit</a></button>
          <button class="delete"><a href="delete.php?id=<?php echo $file['id'] ?>" class="delete_a">×</a></button>
          <div class="img_text">
            <img src="<?php echo "{$file['file_path']}"; ?>" alt="" class="mainimg">
            <div class="username"><?php echo "{$file['userid']}"; ?></div>
            <img src="" alt="" class="usericon">
            <p><?php echo "{$file['description']}"; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <script>
    const file1 = document.getElementById('file1');
    const preview = document.getElementById('preview');

    file1.onchange = function(e) {
      var file = e.target.files[0];
      var blobUrl = window.URL.createObjectURL(file);
      preview.src = blobUrl;
    }
  </script>

  <script>
    const jsonData = <?= $json ?>;
    const user = `<?= $_SESSION["username"]; ?>`

    const no = document.getElementsByClassName('username');
    const icon = document.getElementsByClassName('usericon');
    const edit = document.getElementsByClassName('edit_a');
    const de = document.getElementsByClassName('delete_a');

    window.onload = onLoad;

    function onLoad() {
      for (let i = 0; i < no.length; i++) {
        // console.log(no[i].textContent);
        for (let n = 0; n < jsonData.length; n++) {
          // console.log(jsonData[n].username);
          if (jsonData[n].id == no[i].textContent) {
            no[i].textContent = jsonData[n].username;
            icon[i].src = jsonData[n].profile_image;
          }
        }
      }
    }
  </script>

</body>

</html>