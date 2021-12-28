<?php 

class Paginate 
{

	public $current_page;
	public $photos_per_page;
	public $photos_total_count;

	public function __construct (int $page = 1, int $photos_per_page = 4, int $photos_total_count = 10) 
    {

		$this->current_page = $page;
		$this->photos_per_page = $photos_per_page;
		$this->photos_total_count = $photos_total_count; 
	}

	public function next() 
    {

		return $this->current_page + 1;
	}

	public function previous() 
    {

		return $this->current_page - 1;
	}

	public function pages_total() 
    {

		return ceil($this->photos_total_count/$this->photos_per_page);
	}

	public function has_previous() 
    {

		return $this->previous() >= 1? true : false;
	}

	public function has_next() 
    {

		return $this->next() <= $this->pages_total()? true : false;
	}

	public function offset() 
    {

		return ($this->current_page - 1) * $this->photos_per_page;
	}
}//end of class


?>