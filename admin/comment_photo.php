<?php include("includes/header.php"); ?>
<?php   
    if(!$session->get_signed_in()) {

        redirect("login.php");
    } 
?>
<?php 
    
    if(empty($_GET['id']))
    {
        redirect('photos.php');
    }

?>

<?php
    if(isset($_GET['delete'])) 
    {

        $comment = Comment::find_by_id($database,$_GET['delete']);

        if($comment) {
            
            $session->message("The comment with {$comment->id} has been deleted!");
            $comment->delete();
            
        }
    }
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
                    Comments
                </h1>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Body</th>
                            <th>For Photo</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            $comments=Comment::find_the_comments($database,$_GET['id']);
                            if($comments)
                            {
                                foreach($comments as $comment) {
                                    $photo = Photo::find_by_id($database,$comment->photo_id);
                                    $path = $photo->picture_path();

                                    echo "<tr>";
                                    echo "<td> {$comment->id} </td>";
                                    echo "<td> {$comment->author} </td>";
                                    echo "<td> {$comment->body} </td>";
                                    echo "<td><a href='../photo.php?view={$photo->id}'><img src='{$path}' height=120 width=200/></a></td>";
                                    echo "<td> <a href='comment_photo.php?delete=$comment->id'>Delete</a> </td>";
                                    echo "</tr>";
                                }
                            }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
     <!-- /.row -->

   </div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>