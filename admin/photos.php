<?php include("includes/header.php"); ?>
<?php   
if(!$session->get_signed_in()) 
{
    redirect("login.php"); 
}
?>
<?php
    $photos = Photo::find_all($database);
?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<!-- Brand and toggle get grouped for better mobile display -->
<?php include("includes/top_nav.php"); ?>

<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<?php include("includes/side_bar.php"); ?>
<!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">
<div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            PHOTOS
            <small></small>
        </h1>
        <p class="bg-success"><?php echo $message;?></p>

          
        <div class="col-md-12">
            <table class="table table-hover"> <!-- start of table-->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Size</th>
                        <th>Caption</th>
                        <th>Alternate text</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($photos as $photo): ?> 
                    <tr>
                        <td><?= $photo->id ?></td>
                        <td><img src="<?php echo $photo->picture_path(); ?>" height=120 width=200/>
                        <div class="pictures_link" style="padding-top: 2px;">
                        <?php   
                           echo " <a class='btn btn-primary' href='delete_photo.php?delete=$photo->id '>Delete</a>";
                           echo " <a class='btn btn-primary' href='edit_photo.php?edit=$photo->id ' >Edit</a>";
                           echo " <a class='btn btn-primary' href='../photo.php?id=$photo->id ' >View</a>";
                        ?>
                        </div>
                        <td><?=  $photo->filename;  ?>    </td>
                        <td><?=  $photo->title;     ?>    </td>
                        <td><?=  $photo->description; ?>  </td>
                        <td><?=  $photo->size;      ?>    </td>
                        <td><?=  $photo->caption;      ?>    </td>
                        <td><?=  $photo->alternate_text;      ?>    </td>
                        <td>
                            <a href="comment_photo.php?id=<?php echo $photo->id; ?>">
                            <?php
                              $comments=Comment::find_the_comments($database,$photo->id);
                              echo count($comments);   
                            ?></a>  
                        </td>
                        <td> </td>
                    </tr>  
                <?php endforeach;?>
                </tbody>
            </table>  <!-- End of table -->
        </div>
    </div>
<!-- /.row -->
</div>

    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
<?php include("includes/footer.php"); ?>