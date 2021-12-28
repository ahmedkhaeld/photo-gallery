<?php include("includes/header.php"); ?>

<?php if(!$session->get_signed_in()) { redirect("login.php");} ?>


<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<?php include("includes/top_nav.php"); ?>
<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<?php include("includes/side_bar.php"); ?>
<!-- /.navbar-collapse -->
</nav>
<?php include("includes/modal.php"); ?>



<?php
  
    if(isset($_GET['edit'])) 
    {
        $user_id = $_GET['edit'];
        $user = User::find_by_id($database,$user_id);
        
        if(!$user) 
        { die("Error: " . $database->connection); }
    } else 
    {

        redirect("users.php");
    }

?>

<?php
  
    if(isset($_POST['update'])) 
    {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];

        $user->username = $username;
        $user->password = $password;
        $user->first_name = $first_name;
        $user->last_name = $last_name;

        if(empty($_FILES['user_image'])) 
        {
          $user->save($database); 
          redirect("users.php");
          $session->message("  {$username} has been updated !");

        
        }
        else
        {
          $user->set_file($_FILES['user_image']);
          $user->upload_user_image();
          $user->save($database);
          $session->message("  {$username} has been updated !");
          //   redirect("edit_user.php?edit={$user->id}");
          redirect("users.php");


        }
    
    } 

?>
 <div id="page-wrapper">


    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Edit User
                    <small> <?php echo $user->username; ?> </small>
                </h1>               
            </div>
        </div> <!-- /.row -->
            
         <div class="row">

            <form action="" method="post" enctype="multipart/form-data">
        
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="username">Username:</label>
                            <input class="form-control" type="text" name="username" value="<?php echo $user->username; ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="text" class="form-control" name="password" value="<?php echo $user->password; ?>">
                    </div>

                    <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" class="form-control" name="first_name" value="<?php echo $user->first_name; ?>">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" class="form-control" name="last_name" value="<?php echo $user->last_name; ?>">
                    </div>

                    <div class="form-group">
                        <label for="user_image">Change Image:</label>
                        <input type="file" name="user_image">
                    </div>

                    <div class="form-group">
                        <a id="user_id" class="btn btn-danger" href='users.php?delete=<?php echo $user_id; ?>'>Delete</a>
                        <input type="submit" class="btn btn-primary pull-right" name="update" value="Update User">
                    </div>

                </div> <!-- /.col-md-6 -->

            </form>
            <div class="col-md-4 col-md-offset-1 img-responsive user_image_box" style="max-height: 500px;">

                    <a href="#" data-toggle="modal" data-target="#photo-library"><img src="<?= $user->image_path_placeholder(); ?>" style='width: 100%; height: 250px'></a>

            </div>

        </div> <!-- /.row -->

    </div> <!-- /.container-fluid -->       

</div> <!-- /#page-wrapper -->



<?php include("includes/footer.php"); ?>




