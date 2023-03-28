<?php


if(file_exists('../database.php')){
    include '../database.php';
} 
else{
    include 'php/database.php';
}

class Model extends Database{


    protected $table = "";

    protected $primaryKey = "id";

    public $query = "";

    public $statment = "";

    public $wheres= [];

    public $ordersby = [];
    
    public $from = "";

    public function all(Array $columns = null)
    {
        if($columns){
            $columns = implode(',' , $columns);
            $this->query = "SELECT $columns FROM $this->table ";
            return $this->read($this->query);
        }
        else{
            $this->query = "SELECT * FROM $this->table ";
            return $this->read($this->query);
        }
       
    }

    public function exists($column, $value, $differentTo = null, $whereClause = null){

        if($differentTo){
            $query = "SELECT count($this->primaryKey) as count FROM $this->table WHERE $column = '$value' and id != '$differentTo'";
            if($whereClause){
                $query = "SELECT count($this->primaryKey) as count FROM $this->table WHERE $column = '$value' 
                and id != '$differentTo' and $whereClause";
            }
        }
        else{
            $query = "SELECT count($this->primaryKey) as count FROM $this->table WHERE $column = '$value'";
        }
        $array = $this->readOne($query);
        return $array['count'] > 0;
    }

    public function existsIn($table, $column, $value, $differentTo = null){

        if($differentTo){
            $query = "SELECT count($this->primaryKey) as count FROM $table WHERE $column = '$value' and id != '$differentTo'";
        }
        else{
            $query = "SELECT count($this->primaryKey) as count FROM $table WHERE $column = '$value'";
        }
        $array = $this->readOne($query);
        return $array['count'] > 0;
    }


    public function select(Array $columns = null, $from = null)
    {
        if($columns){

            $columns = implode(',' , $columns);

            if($from){
                $this->query = "SELECT $columns FROM $from ";
            }
            else{
                $this->query = "SELECT $columns FROM $this->table ";
            }
            return $this;

        }
        else{

            if($from){
                $this->query = "SELECT * FROM $from ";
            }
            else{
                $this->query = "SELECT * FROM $this->table ";
            }
            return $this;

        }
    }

    public function rawQuery($query){

        $this->query = "$query";
        return $this;

    }

    function lastIdIn($table)
	{
		$this->query = "SELECT id FROM $table ORDER BY id DESC LIMIT 1";
        $result = $this->get();

        return $result[0]['id'];
	}


    public function rawStatment($statment){
        $this->statment = "$statment";
        return $this;
    }

    public function join($table, $column1, $operator, $column2)
    {
        $this->query .= " INNER JOIN $table ON $column1 $operator $column2 ";
        return $this;
    }

    public function leftJoin($table, $column1, $operator, $column2)
    {
        $this->query .= " LEFT JOIN $table ON $column1 $operator $column2 ";
        return $this;
    }

    public function rightJoin($table, $column1, $operator, $column2)
    {
        $this->query .= " RIGHT JOIN $table ON $column1 $operator $column2 ";
        return $this;
    }

    public function where($column, $operator, $value)
    {
        if(count($this->wheres) > 0 ){

            $this->query .= " AND $column $operator '$value' ";
            $this->statment .= " AND $column $operator '$value' ";
            array_push($this->wheres, $this->query);
            return $this;
        }
        else{
            $this->query .= " WHERE $column $operator '$value' ";
            $this->statment .= " WHERE $column $operator '$value'  ";
            array_push($this->wheres, $this->query);
            return $this;
        }
    }

    public function whereIs($column, $value){
        if(count($this->wheres) > 0 ){

            $this->query .= " AND $column is $value ";
            $this->statment .= " AND $column is $value ";
            array_push($this->wheres, $this->query);
            return $this;
        }
        else{
            $this->query .= " WHERE $column is $value ";
            $this->statment .= " WHERE $column is $value  ";
            array_push($this->wheres, $this->query);
            return $this;
        }
    }

    public function whereIsNot($column, $value){
        if(count($this->wheres) > 0 ){

            $this->query .= " AND $column is not $value ";
            $this->statment .= " AND $column is not $value ";
            array_push($this->wheres, $this->query);
            return $this;
        }
        else{
            $this->query .= " WHERE $column is not $value ";
            $this->statment .= " WHERE $column is not $value  ";
            array_push($this->wheres, $this->query);
            return $this;
        }
    }

    public function whereIn($column, $values){

        if(is_array($values)){
            $values = "'".implode("', '", $values). "'";
        }
        if(count($this->wheres) > 0 ){

            $this->query .= " AND $column in ($values) ";
            $this->statment .= " AND $column in ($values) ";
            array_push($this->wheres, $this->query);
            return $this;
        }
        else{
            $this->query .= " WHERE $column in ($values) ";
            $this->statment .= " WHERE $column in ($values) ";
            array_push($this->wheres, $this->query);
            return $this;
        }

    }

    public function orWhere($column, $operator, $value)
    {
        if(count($this->wheres) > 0 ){
            $this->query .= " OR $column $operator '$value' ";
            $this->statment .= " OR $column $operator '$value' ";
            array_push($this->wheres, $this->query);
            return $this;
        }
        else{
            $this->query .= " WHERE $column $operator '$value' ";
            array_push($this->wheres, $this->query);
            return $this;
        }
    }

    public function whereNot($column, $operator, $value)
    {
        if(count($this->wheres) > 0 ){
            $this->query .= " NOT $column $operator '$value' ";
            $this->statment .= " NOT $column $operator '$value' ";
            array_push($this->wheres, $this->query);
            return $this;
        }
        else{
            $this->query .= " WHERE NOT $column $operator '$value' ";
            array_push($this->wheres, $this->query);
            return $this;
        }
    }

    public function whereBetween($column, Array $array)
    {
        if(count($this->wheres) > 0 ){
            $this->query .= " $column BETWEEN $array[0] and $array[1] ";
            $this->statment .= " $column  BETWEEN $array[0] and $array[1] ";
            array_push($this->wheres, $this->query);
            return $this;
        }
        else{
            $this->query .= " WHERE $column BETWEEN $array[0] and $array[1] ";
            array_push($this->wheres, $this->query);
            return $this;
        }
    }

    public function insert(Array $array)
    {
        $columns = implode(', ',array_keys($array));
        $values = "'". implode("', '",array_values($array)) . "'";
        $this->statment = "INSERT INTO $this->table ($columns) VALUES ($values)";
        return $this;
    }

    public function update(Array $sets)
    {
        $conditions = [];
        foreach ($sets as $column => $value) {

            $conditions[] = "`{$column}` = '{$value}'";

        }
        $conditions = implode(',', $conditions);
        $this->statment = "UPDATE $this->table SET $conditions";
        return $this;

    }

    public function delete()
    {
        $this->statment = "DELETE FROM $this->table";
        return $this;

    }

    public function orderBy($column, $order)
    {

        if(count($this->ordersby) > 0){
            $this->query .= " ,$column $order";
            array_push($this->ordersby, $this->query);
            return $this;
        }
        else{
            $this->query .= " ORDER BY $column $order";
            array_push($this->ordersby, $this->query);
            return $this;
        }

    }

    public function groupBy($column)
    {
        $this->query .= " GROUP BY $column ";
        return $this;
    }

    public function limit($limit)
    {
        $this->query .= " LIMIT $limit ";
        return $this;
    }

    public function nextId(){


        $this->query = "SELECT AUTO_INCREMENT
        FROM  INFORMATION_SCHEMA.TABLES
        WHERE TABLE_SCHEMA = '" .$this->dbname ."' AND  TABLE_NAME   = '". $this->table."'";

        $result = $this->get();

        return $result[0]['AUTO_INCREMENT'];
               
    }

    public function nextIdIn($table){


        $this->query = "SELECT AUTO_INCREMENT
        FROM  INFORMATION_SCHEMA.TABLES
        WHERE TABLE_SCHEMA = '" .$this->dbname ."' AND  TABLE_NAME   = '". $table."'";

        $result = $this->get();

        return $result[0]['AUTO_INCREMENT'];
               
    }


    public function get()
    {
        return $this->read($this->query, function(){
            $this->wheres = [];
            $this->ordersby = [];
            $this->query = "";
        });
    }

    public function exec(){
        return $this->execute($this->statment, [], function(){
            $this->wheres = [];
            $this->ordersby = [];
            $this->statment = "";
        });
    }


}