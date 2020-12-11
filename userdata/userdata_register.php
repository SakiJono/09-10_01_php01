<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録</title>
</head>

<body>
  <form action="userdata_create.php" method="POST">
    <fieldset>
      <legend>ユーザー登録</legend>
      <div>
        name: <input type="text" name="username">
      </div>
      <div>
        password: <input type="password" name="password">
      </div>
      <div>
        <button>Login</button>
      </div>
    </fieldset>
  </form>

</body>

</html>