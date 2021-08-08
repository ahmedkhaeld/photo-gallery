<?php
class User {

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    protected static $db_table = 'users';

    public static function find_this_query(Database $database, $sql){
        $result_set=$database->query($sql);
        $the_object_array=[];
        while($row=mysqli_fetch_array($result_set)){
            $the_object_array[]=self::instantiation($row);
        }
        return $the_object_array;
    }

    public static function verify_user(Database $database, $username, $password){
        $username=$database->escape_string($username);
        $password=$database->escape_string($password);
        $sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";
        $the_result_array=self::find_this_query( $database, $sql);
        return  !empty ($the_result_array)? array_shift($the_result_array): false;   
    }


    public static function find_all_users(Database $database) {
        
        return self::find_this_query( $database, "SELECT * FROM users");

    }

    public static function find_user_by_id( Database $database, int $user_id){
      
        $the_result_array=self::find_this_query( $database, "SELECT * FROM users WHERE id = $user_id");
        return  !empty ($the_result_array)? array_shift($the_result_array): false;   
    }


    public static function instantiation(array $the_record){
        // this a User object. attributes are class property
        $user_object=new self;
        foreach ($the_record as $the_attribute=> $value){
            if ($user_object->has_the_attribute( $the_attribute)){
                $user_object->$the_attribute=$value;
            }
        }
        return $user_object;
    }

    private function has_the_attribute( $the_attribute){
        $user_object_properties=get_object_vars($this);
         return array_key_exists($the_attribute,$user_object_properties);
    }

    public function create(Database $database) {
        $sql="INSERT INTO " .self::$db_table . " (username, password,first_name,last_name)";
        $sql.= " VALUES (' ";
        $sql.=$database->escape_string($this->username) . "','";
        $sql.=$database->escape_string($this->password) . "','";
        $sql.=$database->escape_string($this->first_name) . "','";
        $sql.=$database->escape_string($this->last_name) . "')";

        if($database->query($sql)) {
            $this->id=$database->pull_user_id();
            return true;
        }else{
            return false;
        }

    }

    public function save(Database $database){
        return isset($this->id) ? $this->udpate($database)  : $this->create($database);
    }

    public function udpate(Database $database) {
        $sql="UPDATE " .self::$db_table . " SET ";
        $sql.="username='".$database->escape_string($this->username)."',";
        $sql.="password='".$database->escape_string($this->password)."',";
        $sql.="first_name='".$database->escape_string($this->first_name)."',";
        $sql.="last_name='".$database->escape_string($this->last_name)."' ";
        $sql.= " WHERE id=". $database->escape_string($this->id);
        $database->query($sql);
        return (mysqli_affected_rows($database->connection)==1) ? true : false;
    }

    public function delete($database){
        $sql="DELETE FROM " .self::$db_table . " ";
        $sql.="WHERE id=". $database->escape_string($this->id);
        $sql.=" LIMIT 1";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection)==1) ? true : false;

    } 







    

 


























}
$user = new User();


?>