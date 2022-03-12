<?php
require_once __DIR__ . '/functions.php';

session_start();

select_user_info($_SESSION['email']);
// 関数ファイルを読み込む

require_once __DIR__ . '/functions.php';
// require_once __DIR__ . '/db_function/db_function.php';


?>

<body>
    名前
    会社名
    
    <a href="index.php" class="btn link-btn">home</a>
</body>
