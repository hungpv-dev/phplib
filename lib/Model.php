<?php
class Model extends ConnectDB
{
    private $sql = '';
    private $select = '*';
    private $table;
    private $where = '';
    private $params = [];
    private $join = '';
    private $limit = '';
    private $offset = '';
    private $orderBy = '';
    private $groupBy = '';
    private $stmt;
    public function __construct($table,$as = false){
        $this->table = $table;
        if($as){
            $this->table .= " AS $as";
        }
        self::connect();
    }

    public function table($table){
        $this->table = $table;
        return $this;
    }

    public function select($select){
        $this->select = $select;
        return $this;
    }

    public function count(){
        $this->select = "COUNT('*')";
        $this->limit = '';
        $this->offset = '';
        $model = $this->execute();
        return $model->fetchNum($model->stmt);
    }
        
    public function execute(){
        if(!$this->sql){
            $this->sql = "SELECT ".$this->select." FROM ".$this->table.$this->join.$this->where.$this->groupBy.$this->orderBy.$this->limit.$this->offset;
        }
        $stmt = parent::$connect->prepare($this->sql);
        $stmt->execute($this->params);
        $this->stmt = $stmt;
        $this->sql = '';
        return $this;
    }

    public function create($data){
        $filed = [];
        $col = [];
        foreach($data as $key => $value){
            $filed[] = "`$key`";
            $col[] = "?";
            $this->params[] = $value;
        }
        $filed = "(".implode(",", $filed).")";
        $col = "(".implode(",", $col).")";
        $this->sql = "INSERT INTO `".$this->table."` $filed VALUES $col";
        $this->execute();
        return $this->lastInsertedId();
    }
    public function update($id,$data){
        $filed = [];
        foreach($data as $key => $value){
            $filed[] = "`$key` = ?";
            $this->params[] = $value;
        }
        $filed = implode(",", $filed);
        $this->params[] = $id;
        $this->sql = "UPDATE `".$this->table."` SET $filed WHERE `".$this->table."`.`id` = ?";

        $this->execute();
        $this->params = [];
        $data = $this->find($id);
        return $data;
    }

    public function all(){
        $model = $this->execute();
        return $model->fetchAll($model->stmt);
    }
    public function where(...$where){
        if(count($where) == 3){
            $col = $where[0];
            $operator = $where[1];
            $value = $where[2];
        }else{
            $col = $where[0];
            $operator = '=';
            $value = $where[1];
        }
        $type = 'WHERE';
        if($this->where){
            $type = 'AND';
        }
        $this->params[] = $value;
        $this->where .= " $type $col $operator ?";
        return $this;
    }
    public function orWhere(...$where){
        if(count($where) == 3){
            $col = $where[0];
            $operator = $where[1];
            $value = $where[2];
        }else{
            $col = $where[0];
            $operator = '=';
            $value = $where[1];
        }
        $type = 'WHERE';
        if($this->where){
            $type = 'OR';
        }
        $this->params[] = $value;
        $this->where .= " $type $col $operator ?";
        return $this;
    }
    public function first(){
        $model = $this->execute();
        return $model->fetch($model->stmt);
    }
    public function get(){
        $model = $this->execute();
        return $model->fetchAll($model->stmt);
    }
    public function find($id){
        $this->where = " WHERE id = $id";
        $model = $this->execute();
        return $model->fetch($model->stmt);
    }

    public function destroy($id){
        $this->sql = "DELETE FROM `".$this->table."` WHERE id";
        if(is_array($id)){
            $cols = "(".implode(",", array_fill(0, count($id), "?")).")";
            $this->sql .= ' IN '.$cols;
            $this->params = $id;
        }else{
            $this->sql .= '= ?';
            $this->params = [$id];
        }
        return $this->execute();
    }

    public function delete(){
        $this->sql = "DELETE FROM `".$this->table."` ".$this->where;
        return $this->execute();
    }

    public function lastInsertedId(){
        $lastInsertId = parent::$connect->lastInsertId();
        $this->sql = "SELECT * FROM `".$this->table."` WHERE id = ?";
        $this->params = [$lastInsertId];
        $model = $this->execute();
        return $model->fetch($model->stmt);
    }

    public function fetchAll($stmt){
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    public function fetch($stmt){
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    public function fetchNum($stmt){
        $result = $stmt->fetch(PDO::FETCH_NUM);
        return (int)$result[0];
    }

    public function join($table,$col1, $col2, $operator = "="){
        $this->join .= " INNER JOIN ".$table." ON $col1 $operator $col2";
        return $this;
    }
    public function leftJoin($table,$col1, $col2, $operator = "="){
        $this->join .= " LEFT JOIN ".$table." ON $col1 $operator $col2";
        return $this;
    }
    public function rightJoin($table,$col1, $col2, $operator = "="){
        $this->join .= " RIGHT JOIN ".$table." ON $col1 $operator $col2";
        return $this;
    }
    public function limit($limit){
        $this->limit = " LIMIT $limit";
        return $this;
    }
    public function offset($offset){
        $this->offset = " OFFSET $offset";
        return $this;
    }
    public function orderBy($col, $type = 'ASC'){
        $this->orderBy = " ORDER BY $col $type";
        return $this;
    }
    public function whereIn($col, $ids){
        $values = "(".implode(",", array_fill(0, count($ids), "?")).")";
        $this->where .= " WHERE $col IN ".$values;
        $this->params = $ids;
        return $this;
    }
    public function whereNotIn($col, $ids){
        $values = "(".implode(",", array_fill(0, count($ids), "?")).")";
        $this->where .= " WHERE $col NOT IN ".$values;
        $this->params = $ids;
        return $this;
    }
    public function increment($col,$count){
        $this->sql = "UPDATE ".$this->table." SET $col=$col+$count ".$this->where;
        $stmt = $this->execute();
        $this->sql = "";
        $stmt = $this->execute();
        if(count($this->params) <= 1){
            return $stmt->fetch($this->stmt);
        }else{
            return $stmt->fetchAll($this->stmt);
        }
    }
    public function decrement($col,$count){
        $this->sql = "UPDATE ".$this->table." SET $col=$col-$count ".$this->where;
        $stmt = $this->execute();
        $this->sql = "";
        $stmt = $this->execute();
        if(count($this->params) <= 1){
            return $stmt->fetch($this->stmt);
        }else{
            return $stmt->fetchAll($this->stmt);
        }
    }
    public function orderByRand(){
        $this->orderBy = 'ORDER BY RAND()';
        return $this;
    }

    public function groupBy($group){
        $this->groupBy = ' GROUP BY '.$group;
        return $this;
    }
}


class ConnectDB{
    protected static $connect;
    public static function connect()
    {
        if (!isset(self::$connect)) { 
            $json = file_get_contents('config.json');
            $data = json_decode($json, true); 
            $dbConfig = $data['DB'];
            $hostname = $dbConfig['db_host'];
            $port = $dbConfig['db_port'];
            $user = $dbConfig['db_user'];
            $pass = $dbConfig['db_pass'];
            $db_name = $dbConfig['db_name'];
            $charset = $dbConfig['charset'];
            try {
                $options= [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                self::$connect = new PDO("mysql:host=$hostname;dbname=$db_name;port=$port;charset=$charset", $user, $pass, $options);
            } catch (Exception $e) {
                echo "connect failed" . $e->getMessage();
            }
        }
    }
}
