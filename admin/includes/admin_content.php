 
<div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Admin
            <small>Subheading</small>
        </h1>
        <?php 

        

        $user=User::find_user_by_id($database,6);
        // $user->username="hamo";
        // $user->udpate($database);
        $user->username="Aia ehab";
        $user->password="l1000times";
        $user->first_name="Aia";
        $user->last_name="Ehab";
        $user->update($database);
     


      
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