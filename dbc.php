<?php

function dbc()
{
  $host = "localhost";
  $dbname = "file_db";
  $user = "root";
  $pass = "root";

  $dns = "mysql:host=$host;dbname=$dbname;
  charset=utf8";


  try {
    $pdo = new PDO(
      $dns,
      $user,
      $pass,
      [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
    echo '成功';
    return $pdo;
  } catch (PDOException $e) {
    exit($e->getMessage());
  }
}

dbc();
