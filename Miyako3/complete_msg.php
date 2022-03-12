<?php
$comment = $_GET['comment'];
?>

<!DOCTYPE html>
<html lang="ja">
<? include_once __DIR__ . '/header.html'; ?>

<body>
    <h1><?= $comment ?>が完了しました</h1>
    <a href="index.php" class="btn edit-btn">トップへ戻る</a><br>
    <? include_once __DIR__ . '/js.html'; ?>
</body>

</html>