<?php

function dbc()
{
  $host = "localhost";
  $dbname = "file_db";
  $user = "root";
  $pass = "";

  $dns = "mysql:host=$host;dbname=$dbname;
  charset=utf8";


  try {
    $pdo = new PDO(
      $dns,
      $user,
      $pass,
      [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );

    return $pdo;
  } catch (PDOException $e) {
    exit($e->getMessage());
  }
}

/**
 * ファイルデータを保存
 * @param string $filename ファイル名
 * @param string $save_path 保存先のパス
 * @param string $caption 投稿の説明 ==$fileDate
 * @return bool $result
 */


function fileSave($filename, $save_path, $caption, $userid)
{
  $result = False;

  $sql = "INSERT INTO file_table (file_name,file_path,description,userid) VALUE(?,?,?,?)";

  try {
    $stmt = dbc()->prepare($sql);
    $stmt->bindValue(1, $filename);
    $stmt->bindValue(2, $save_path);
    $stmt->bindValue(3, $caption);
    $stmt->bindValue(4, $userid);
    $result = $stmt->execute();
    return $result;
  } catch (\Exception $e) {
    echo $e->getMessage();
    return $result;
  }
}


/**
 * ファイルデータを取得
 * @return array $fileData
 */

function getALLfile()
{
  $sql = "SELECT * FROM file_table ORDER BY id DESC";

  $fileData = dbc()->query($sql);

  return $fileData;
}

function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

// ログイン状態のチェック関数
function check_session_id()
{
  if (
    !isset($_SESSION['session_id']) || // session_idがない
    $_SESSION['session_id'] != session_id() // idが一致しない
  ) {
    header('Location: login.php'); // ログイン画面へ移動
  } else {
    session_regenerate_id(true); // セッションidの再生成
    $_SESSION['session_id'] = session_id(); // セッション変数上書き
  }
}
