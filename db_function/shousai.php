<?php

require_once __DIR__ . '/db_function.php';

//var_dump(display_order($_GET['order']));

//var_dump(create_community('tit',1,'tit','tit','tit','tit','tit'));

create_community_user(5,2);

echo 'search_community';

var_dump(search_community('5'));

