<?php
$comment = $_GET['comment'];
?>

<!DOCTYPE html>
<html lang="ja">
<? include_once __DIR__ . '/header.html'; ?>
<link rel="stylesheet" href="complete_msg.css">

<body>
    <div class="complete_msg_wrapper">
        <h1><?= $comment ?>が完了しました</h1>
        <div class="mt-5 text-center">
            <a href="index.php" class="btn btn-primary">トップへ戻る</a><br>
        </div>
        <? include_once __DIR__ . '/js.html'; ?>
    </div>
</body>

</html>