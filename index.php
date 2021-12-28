<?php include("includes/header.php"); ?>

<!-- Navigation -->
<?php include("includes/navigation.php"); ?>

<?php 
$page=!empty($_GET['page']) ? (int)$_GET['page'] :1;
$photos_per_page=4;
$photos_total_count=Photo::count_all($database); 

$paginate=new Paginate($page,$photos_per_page,$photos_total_count);
$sql= "SELECT * FROM photo ";
$sql .= "LIMIT {$photos_per_page} ";
$sql .= "OFFSET {$paginate->offset()}";
$photos=Photo::find_by_query($database,$sql);

// $photos=Photo::find_all($database);
?> 

<div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-12">
        <div class="thumbnails row">
        <?php foreach($photos as $photo): ?>
                <div class="col-xs col-md-3">
                    <a href="photo.php?id=<?php echo $photo->id?>" class="thumbnail">
                        <img class="home_page_photo img-responsive" src="admin/<?php echo $photo->picture_path(); ?>" alt="">
                    </a>
                </div>   
           <?php endforeach; ?>
        </div>
        <div class="row">
            <ul class="pagination">
               <?php 
                    if($paginate-> pages_total() > 1)
                    {
                        if($paginate->has_next())
                        {
                            echo "<li class='next'><a href='index.php?page={$paginate->next()}'>NEXT</a></li>";
                        }

                        for($i = 1; $i <=$paginate->pages_total(); $i++)
                        {
                            if($i == $paginate->current_page)
                            {
                               echo "<li class='active'><a href='index.php?page={$i}'>{$i}</a></li>";
                            }else
                            {
                               echo "<li class='active'><a href='index.php?page={$i}'>{$i}</a></li>";
                                
                            }
                        }


               

                        if($paginate->has_previous())
                        {
                            echo "<li class='previous'><a href='index.php?page={$paginate->previous()}'>PREVIIOUS</a></li>";
                        }


                    }
 
                ?>
             
            </ul>
        </div>
    </div>
    <!-- Blog Sidebar Widgets Column -->
    <!-- <div class="col-md-4">  -->
        <?php   // include("includes/sidebar.php"); ?>
</div>
<!-- /.row -->

 <?php include("includes/footer.php"); ?>
