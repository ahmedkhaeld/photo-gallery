<?php include('includes/init.php'); ?>

<?php   
	if(!$session->get_signed_in()) 
    {
     redirect("login.php");
	}
?>

<?php

if(!empty($_GET['delete'])) 
{

	
	$photo = Photo::find_by_id($database, $_GET['delete']);
	
	if($photo) 
    {

		$photo->delete_photo();
		$session->message("{$photo->filename} has been deleted!");
		redirect("photos.php");


	} else 
    {

		redirect('photos.php');
	}

} else 
{

	redirect('photos.php');
}

?>