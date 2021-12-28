<?php 

class Photo extends Db_object
{
    public $id;
    public $title;
    public $description;
    public $filename;
    public $caption;
    public $alternate_text; 
    public $type;
    public $size;
    protected static $db_table = 'photo';
    protected static $db_table_fields = ['id', 'title', 'description', 'filename', 'caption','alternate_text','type', 'size'];

    public $tmp_path;
    public $upload_directory="images";
    public $errors=array();
   


    // This is passing $_FilES['uploaded_file'] as an argument.
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
            $this->filename  = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type      =$file['type'];
            $this->size      =$file['size'];
        }

    }

    public function save($database)
    {
        if($this->id)
        {
            $this-> update($database) ;
        }else
        {
            if(!empty($this->errors))
            {
                return false;
            }
            if(empty($this->filename) || empty($this->tmp_path))
            {
                $this->errors[]= "The file was not available";
                return false;
            }
            $target_path=SITE_ROOT .DS . 'admin' .DS . $this->upload_directory .DS . $this->filename;
            if(file_exists($target_path))
            {
                $this->errors[] = "The file {$this->filename} already exists";
                return false;
            }
            if(move_uploaded_file($this->tmp_path, $target_path))
            {
                if($this->create($database))
                {
                    unset($this->tmp_path);
                    return true;
                }
            }else
            {
                $this->errors[] = "The folder does not have permissions";
                return false; 
            }

        }
    }

    public function picture_path() 
    {
		return $this->upload_directory."/".$this->filename;
	}

    public function delete_photo() 
    {

        if(unlink($this->upload_directory.DS.$this->filename)) {
        
            $this->delete();
            return redirect('photos.php');

        } else {

            return redirect('photos.php');
        }
    }


    public static function display_sidebar_data(Database $database,int $photo_id) 
    {

		$photo = Photo::find_by_id( $database,$photo_id);


		$output = "<a class='thumbnail' href='#'><img width='100' src='{$photo->picture_path()}' ></a> ";
		$output .= "<p>{$photo->filename}</p>";
		$output .= "<p>{$photo->type}</p>";
		$output .= "<p>{$photo->size}</p>";

		echo $output;


	}





}



?>