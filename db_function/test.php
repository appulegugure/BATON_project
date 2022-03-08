<?php

require_once __DIR__ . '/db_function.php';

create_oreder(99,6,'kokokara','kokode',2,3,'kokokara','kokono');

$order_list = select_order_all_ALL();


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php foreach($order_list as $order): ?>
        <?=var_dump($order)?>
        <a href="shousai.php?order=<?=$order['id']?>">詳細入口</a>
        <hr>
    <?php endforeach; ?>
</body>
</html>