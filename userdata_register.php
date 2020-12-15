<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録</title>
  <link rel="stylesheet" href="style.css">

</head>

<body>


  <form action="userdata_create.php" method="POST" enctype="multipart/form-data" class="userdata">
    <fieldset>
      <legend>ユーザー登録</legend>
      <div>
        name: <input type="text" name="username">
      </div>
      <div>
        password: <input type="password" name="password">
      </div>
      <div>
        mail: <input type="mail" name="mail">
      </div>
      <div>
        icon: <input type="file" name="icon" id="file1" accept="image/*">
      </div>
      <div>
        <button>登録</button>
      </div>
    </fieldset>
    <img src="" id="preview" class="iconpreview">
  </form>




  <script>
    const file1 = document.getElementById('file1');
    const preview = document.getElementById('preview');

    file1.onchange = function(e) {
      var file = e.target.files[0];
      var blobUrl = window.URL.createObjectURL(file);
      preview.src = blobUrl;
    }
  </script>


</body>

</html>