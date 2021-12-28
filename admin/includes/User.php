<?php
class User extends Db_object 
{

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image;
    public $upload_directory="images";
    public $imgae_placeholder="https://picsum.photos/400/400";
    protected static $db_table = 'user';
    protected static $db_table_fields = ['username', 'password', 'first_name', 'last_name','user_image'];

   

    public static function verify_user(Database $database, $username, $password)
    {
        $username=$database->escape_string($username);
        $password=$database->escape_string($password);
        $sql = "SELECT * FROM " .self::$db_table. " WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";
        $the_result_array=self::find_by_query( $database, $sql);
        return  !empty ($the_result_array)? array_shift($the_result_array): false;   
    }

    public function image_path_placeholder()
    {
        return empty($this->user_image) ? $this->imgae_placeholder : $this->upload_directory.DS.$this->user_image;
    }

    public function upload_image($image) 
    {

        $image_tmp_name = $image['tmp_name'];
        $image_real_name = $image['name'];
        
        if(move_uploaded_file($image_tmp_name, SITE_ROOT.DS.$this->upload_directory.DS.$image_real_name)) 
        {
    
            return $this->user_image = $image_real_name;
        }
    }

    public function set_file($file)
    {
        if(empty($file) || !$file || !is_array($file))
        {
            $this->errors[]= "There was no file uploaded here";
            return false;
        }elseif($file['error'] !=0)
        {
            $this-> errors[]= $this-> upload_errors_array[$file['error']];
        }else
        {
            $this->user_image  = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type      =$file['type'];
            $this->size      =$file['size'];
        }

    }

    public function upload_user_image()
    {
       
        if(!empty($this->errors))
        {
            return false;
        }
        if(empty($this->user_image) || empty($this->tmp_path))
        {
            $this->errors[]= "The file was not available";
            return false;
        }
        $target_path=SITE_ROOT .DS . 'admin' .DS . $this->upload_directory .DS . $this->user_image;
        if(file_exists($target_path))
        {
            $this->errors[] = "The file {$this->user_image} already exists";
            return false;
        }
        if(move_uploaded_file($this->tmp_path, $target_path))
        {            
            unset($this->tmp_path);
        
        }else
        {
            $this->errors[] = "The folder does not have permissions";
            return false; 
        }

        
    }




    public function ajax_save_user_image($user_image, int $user_id, Database $database)
    {
        $user_image = $database->escape_string($user_image);
		$user_id = $database->escape_string($user_id);

		$this->user_image = $user_image;
		$this->id         = $user_id;

		$sql  = "UPDATE " . self::$db_table . " SET user_image = '{$this->user_image}' ";
		$sql .= " WHERE id = {$this->id} ";
		$update_image = $database->query($sql);

		
		echo $this->image_path_placeholder();

 
    }

    public function delete_photo() 
    {


		if($this->delete()) 
        {

			$target_path = SITE_ROOT.DS. 'admin' . DS . $this->upload_directory . DS . $this->user_image;

			return unlink($target_path) ? true : false;

		} else 
        {

			return false;

		}

	}


   




} // end of class
$user = new User();


?>