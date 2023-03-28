<?php
class Database{
	
	private $dbh;
	protected $dbname;

	function __construct(){

		$env = include 'env.php';

		$this->dbname = $env['database'];
		
		$dsn = "mysql:host=" . $env['host'] . ";dbname=". $env['database'] .";charset=utf8mb4";
		$options = [
			PDO::ATTR_EMULATE_PREPARES   => false,
			PDO::ATTR_EMULATE_PREPARES => true,
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		];

		try {
			$this->dbh = new PDO($dsn, $env['user'],  $env['password'], $options);
		}
		catch(PDOException $e) {
			//header('Content-Type', 'application/json');
			require_once '../Utilities/Log.php';
			Log::save($e);
			echo json(
				[
					'status' => 'error',
					'data' => null,
					'message' => 'No se pudo establecer conexión, intentelo más tarde.'
				]
			, 500);
			die();
		}
	}


	function read($q, $callback= null){
		try{
			$sth = $this->dbh->prepare($q);
			$sth->execute();
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			$result = $sth->fetchAll();
			//$this->dbh = null;
			$result = json_encode($result);
			$obj = json_decode($result, true);
			if($callback){
				$callback();
			}
			return $obj;

		}
		catch(PDOException $e){
			require_once '../Utilities/Log.php';
			error_log('PDOException - ' . $e->getMessage(), 0);
			http_response_code(500);
			Log::save($e);
			echo json([
                'status' => 'error',
                'data' => null,
                'message' => $e->getMessage(),
            ], 404);
			die();
		}
	}

	function readOne($q){
		
		try{
			$sth = $this->dbh->prepare($q);
			$sth->execute();
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			$result = $sth->fetch();
			//$this->dbh = null;
			$result = json_encode($result);
			$obj = json_decode($result, true);
			return $obj;
		}
		catch(PDOException $e){
			require_once '../Utilities/Log.php';
			error_log('PDOException - ' . $e->getMessage(), 0);
			http_response_code(500);
			Log::save($e);
			echo json([
                'status' => 'error',
                'data' => null,
                'message' => $e->getMessage(),
            ], 404);
			die();
		}

	}

	function SelectNoClose($q){
		try{
			$sth = $this->dbh->prepare($q);
			$sth->execute();
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			$result = $sth->fetchAll();
			return $result;
		}
		catch(PDOException $e){
			require_once '../Utilities/Log.php';
			error_log('PDOException - ' . $e->getMessage(), 0);
			http_response_code(500);
			Log::save($e);
			echo json([
                'status' => 'error',
                'data' => null,
                'message' => $e->getMessage(),
            ], 404);
			die();
		}
	}

	function execute($q, $parametros, $callback= null){
		try	{
			$sth = $this->dbh->prepare($q);
			if($sth->execute($parametros)){
				if($callback){
					$callback();
				}
				return $sth->rowCount() > 0;
			}
			
		}
		catch(PDOException $e){
			require_once '../Utilities/Log.php';
			
			error_log('PDOException - ' . $e->getMessage(), 0);
			http_response_code(500);
			if ($e->errorInfo[1] == 1062) {
				Log::save($e);
				echo json([
					'status' => 'error',
					'data' => null,
					'message' => $e->getMessage(),
				], 404);
				die();
			} else {
				Log::save($e);
				throw $e;
			}
			return false;
		
		}
	}

	function lastId()
	{
		$id = $this->dbh->lastInsertId();
		return $id;
	}

	
	function existsData($table, $column, $value, $differentTo = null){

		try{
		
			if($differentTo){
				$sth = $this->dbh->prepare("SELECT * FROM " . $table . " WHERE " . $column . " = " . " '$value' and id != '$differentTo' ");

			}
			else{
				$sth = $this->dbh->prepare("SELECT * FROM " . $table . " WHERE " . $column . " = " . " '$value' ");
			}
			$sth->execute();
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			$count= count($sth->fetchAll());
			return $count > 0;
			
		}
		catch(PDOException $e){
			require_once '../Utilities/Log.php';
			error_log('PDOException - ' . $e->getMessage(), 0);
			http_response_code(500);
			Log::save($e);
			echo json([
				'status' => 'error',
				'data' => null,
				'message' => $e->getMessage(),
			], 404);
			die();
		}
	}
}
?>
