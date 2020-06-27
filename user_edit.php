<?php
// 送信データのチェック
// var_dump($_GET);
// exit();

// 関数ファイルの読み込み
include("functions.php");

// idの受け取り
$id = $_GET['id'];

// DB接続
$pdo = connect_to_db();

// データ取得SQL作成
$sql = '';
$sql = 'SELECT * FROM users_table WHERE id=:id';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は指定の11レコードを取得
  // fetch()関数でSQLで取得したレコードを取得できる
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($record);
  // exit();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー情報（編集画面）</title>
</head>

<body>
  <form action="user_update.php" method="POST">
    <fieldset>
      <legend>ユーザー情報（編集画面）</legend>
      <a href="user_read.php">一覧画面</a>
      <div>
        <!-- username: <input type="text" name="username"> -->
        username:<input type="text" name="username" value="<?= $record["username"] ?>">
      </div>
      <div>
        <!-- password: <input type="text" name="deadline"> -->
        password:<input type="text" name="password" value="<?= $record["password"] ?>">
      </div>

      <div>
        <!-- admin: <input type="checkbox" name="admin"> -->
        admin:<input type="checkbox" name="admin" value=" <?= $record["is_admin"] ?>">
      </div>
      <div>
        <!-- delete: <input type="checkbox" name="delete"> -->
        delete:<input type="checkbox" name="delete" value=" <?= $record["is_deleted"] ?>">
      </div>

      <!-- hidden -->
      <input type="hidden" name="id" value="<?= $record['id'] ?>">

      <div>
        <button>submit</button>
      </div>

    </fieldset>
  </form>

</body>

</html>