<?php

use App\QueryBuilder;

$db = new QueryBuilder;

$post = $db->getOne('posts', 5);

var_dump($post);
