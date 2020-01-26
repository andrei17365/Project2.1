<?php


class QueryBuilder{

	protected $pdo;

	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function getOne($table, $data){
		$tags = array_keys($data);
		foreach ($tags as $tag) {
			$string .= $tag . '=:' . $tag . ',';
		}

		$tags = rtrim($string, ',');
		$sql = "SELECT * FROM {$table} WHERE {$tags}";
		$statement = $this->pdo->prepare($sql);
		$statement->execute($data);
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public function getAllCommentsWithNames(){
	    $sql = "SELECT 
	    comments.id, 
	    comments.text, 
	    comments.date, 
	    comments.hide, 	   
	    users.name, 	     
	    users.image 
	    FROM comments LEFT JOIN users 
	    ON users.id=comments.user_id 
	    ORDER BY comments.id DESC";

	    $statement = $this->pdo->prepare($sql);

	    $statement->execute();

	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

	    return $result;
	}

	public function create($table, $data){

		$keys = implode(',', array_keys($data));
		$tags = ":".implode(', :', array_keys($data));

		$sql = "INSERT INTO {$table} ({$keys}) VALUES ({$tags})";
		$statement = $this->pdo->prepare($sql);

		$statement->execute($data);
	}

	public function update($table, $data){

		$keys = array_keys($data);

		$string = '';

		foreach ($keys as $key) {
			$string .= $key . '=:' . $key . ',';
		}

		$keys = rtrim($string, ',');

		$sql = "UPDATE {$table} SET {$keys} WHERE id=:id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute($data);
	}


	public function delete($table, $id){
		$sql = "DELETE FROM {$table} WHERE id=:id";
		$statement = $this->pdo->prepare($sql);
		$statement->execute([
			'id' => $id
		]);
	}
}


?>