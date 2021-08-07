 
<div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Admin
            <small>Subheading</small>
        </h1>
        <?php 

        // $found_user=User::find_all_users($database);
        // while($row=mysqli_fetch_array($found_user)) {
        //     echo $row['username'];
        //     echo "<br/>" ;
        // }
        // $found_user=User::find_user_by_id($database, 2);
        // echo $found_user['username'];
    //    echo $user->id = $found_user['id'].'<br/>';
    //    echo $user->username = $found_user['username'].'<br/>';
    //    echo $user->password = $found_user['password'].'<br/>';
    //    echo $user->first_name = $found_user['first_name'].'<br/>';
    //    echo $user->last_name = $found_user['last_name'].'<br/>';

    $users=User::find_all_users($database);
    foreach($users as $user){
        echo $user->username.'<br/>';
    }
    echo '<br/>';
    $found_user=User::find_user_by_id($database, 2);
     echo $found_user->username;
        
      
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