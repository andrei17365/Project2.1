<?php

class Connection{
	public static function make($config){
	
   
    return new PDO(
        "{$config['connection']}; dbname={$config['db_name']}; charset={$config['charset']};",
        $config['db_user'],
        $config['db_password']);

    return $pdo;
	}
}

?>