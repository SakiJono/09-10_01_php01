<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン画面</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <form action="login_act.php" method="POST" class="login">
    <fieldset>
      <legend>ログイン画面</legend>
      <div>
        user_id: <input type="text" name="username">
      </div>
      <div>
        password: <input type="text" name="password">
      </div>
      <div>
        <button>Login</button>
      </div>
      <a href="userdata_register.php">新規登録</a>
    </fieldset>
  </form>

</body>

</html>