<?php
$comment = $_GET['comment'];
?>

<!DOCTYPE html>
<html lang="ja">
<? include_once __DIR__ . '/header.html'; ?>

<body>
    <div class="wrapper">
        <h1><?= $comment ?>が完了しました</h1>
        <div class="mt-5">
            <a href="index.php" class="btn btn-primary">トップへ戻る</a><br>
        </div>
        <? include_once __DIR__ . '/js.html'; ?>
    </div>
</body>

</html>