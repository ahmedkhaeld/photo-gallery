<?php 




class Db_object 
{
    protected static $db_table = 'users';
    protected static $db_table_fields = ['username', 'password', 'first_name', 'last_name'];


    public static function find_by_query(Database $database, $sql)
    {
        $result_set=$database->query($sql);
        $the_object_array=[];
        while($row=mysqli_fetch_array($result_set))
        {
            $the_object_array[]=static::instantiation($row);
        }
        return $the_object_array;
    }

    public static function find_all(Database $database) 
    {
        
        return static::find_by_query( $database, "SELECT * FROM " . static::$db_table. " ");

    }

    public static function find_by_id( Database $database, int $user_id)
    {
      
        $the_result_array=static::find_by_query( $database, "SELECT * FROM " . static::$db_table. " WHERE id = $user_id");
        return  !empty ($the_result_array)? array_shift($the_result_array): false;   
    }

    public static function instantiation(array $the_record)
    {
        // this a User object. attributes are class property
        $calling_class =get_called_class();
        $user_object=new $calling_class;
        foreach ($the_record as $the_attribute=> $value)
        {
            if ($user_object->has_the_attribute( $the_attribute))
            {
                $user_object->$the_attribute=$value;
            }
        }
        return $user_object;
    }

    private function has_the_attribute( $the_attribute)
    {
        $user_object_properties=get_object_vars($this);
         return array_key_exists($the_attribute,$user_object_properties);
    }

    protected function properties()
    {
        $properties=[];
        foreach(static::$db_table_fields as $db_field)
        {
            if(property_exists($this, $db_field))
            {
                $properties[$db_field]=$this->$db_field;
            }
        }
        return $properties;
    }

    protected function clean_properties(Database $database)
    {
        $clean_properties=[];
        foreach ($this->properties() as $key=>$value)
        {
            $clean_properties[$key]=$database->escape_string($value);
        }
      return  $clean_properties;
    }

    public function create(Database $database) 
    {

        $properties=$this->clean_properties($database);
        $sql="INSERT INTO " .static::$db_table . "(" .implode("," ,array_keys($properties)) .")";
        $sql.= " VALUES ('".     implode("','" ,array_values($properties)) ."')";
      
        if($database->query($sql)) 
        {
            $this->id=$database->pull_user_id();
            return true;
        }else
        {
            return false;
        }

    }

    public function save(Database $database)
    {
        return isset($this->id) ? $this->update($database)  : $this->create($database);
    }

    public function update(Database $database) 
    {
        $properties=$this->clean_properties($database);
        $properties_pairs=[];
        foreach($properties as $key=>$value)
        {
            $properties_pairs[]="{$key}='{$value}'";
        }
        $sql="UPDATE " .static::$db_table . " SET ";
        $sql.=implode(",",$properties_pairs);
        $sql.= " WHERE id=". $database->escape_string($this->id);
        $database->query($sql);
        return (mysqli_affected_rows($database->connection)==1) ? true : false;
    }

    public function delete($database)
    {
        $sql="DELETE FROM " .static::$db_table . " ";
        $sql.="WHERE id=". $database->escape_string($this->id);
        $sql.=" LIMIT 1";
        $database->query($sql);
        return (mysqli_affected_rows($database->connection)==1) ? true : false;

    } 







}

?>