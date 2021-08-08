 
<div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Admin
            <small>Subheading</small>
        </h1>
        <?php 

        // $user->username="ahmedkhaled";
        // $user->password="ahmed";
        // $user->first_name="ahmed";
        // $user->last_name="khaled";
        // $user->create($database);

        // $update_user=User::find_user_by_id($database,3);
        // $update_user->last_name="al-saiedy";
        // $update_user->udpate($database);

        $user=User::find_user_by_id($database,1);
        $user->delete($database);


      
        ?>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Blank Page
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

</div>