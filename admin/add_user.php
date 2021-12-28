<?php include("includes/header.php"); ?>

<?php if(!$session->get_signed_in()) { redirect("login.php");} ?>


<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<?php include("includes/top_nav.php"); ?>
<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<?php include("includes/side_bar.php"); ?>
<!-- /.navbar-collapse -->
</nav>
<?php   //Unexpected end of file -> provjeriti
   $user = new User();
  if(isset($_POST['add_user'])) 
  {

    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['first_name']) && !empty($_POST['last_name']))
    {

        
        $user->username   = $_POST['username'];
        $user->first_name =$_POST['first_name'];
        $user->last_name  =$_POST['last_name'];
        $user->password   =$_POST['password'];

        if(!empty($_FILES['user_image'])) 
        {

            $user->set_file($_FILES['user_image']);
            $user->upload_user_image();
        }
        $session->message("The user {$user->username} has been added");
        $user->save($database);
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
                    Add User
                </h1>               
            </div>
        </div> <!-- /.row -->
            
        <div class="row">

             <form action="" method="post" enctype="multipart/form-data">
        
                <div class="col-md-6 col-md-offset-3">

                    

                    <div class="form-group">
                        <label for="username">Username:</label>
                            <input class="form-control" type="text" name="username">
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input class="form-control" type="password" name="password">
                    </div>

                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" class="form-control" name="first_name">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" class="form-control" name="last_name">
                    </div>

                    <div class="form-group">
                        <label for="user_image">User Image:</label>
                        <input type="file" name="user_image">
                    </div>

                    <input type="submit" class="btn btn-primary pull-right" name="add_user" value="Add User">

                </div> <!-- /.col-md-6 -->

            </form>

            </div> <!-- /.row -->

        </div> <!-- /.container-fluid -->
        

    </div> <!-- /#page-wrapper -->


<?php include("includes/footer.php"); ?>