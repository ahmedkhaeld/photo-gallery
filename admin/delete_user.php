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

	
	$user = User::find_by_id($database, $_GET['delete']);
	
	if($user) 
    {
       $session->message("{ $user->username} has been deleted!");
		$user->delete_photo();
		redirect("users.php");
        

	} else 
    {

		redirect('users.php');
	}

} else 
{

	redirect('users.php');
}

?>