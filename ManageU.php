<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("includes/login_module.php");
   $pageTitle = "Manage Users";  
   require_once("classes/Config.php");
   require_once("header.php");    
     

    

?>
<body style="background: black">
    
        <br/> 
        <br/>
        <br/>
          
        <div class="container">
            <div class="col-xs-12 text-right" style="color:#c3c3c3">
                  <?php
                           $userRole = '';
                           if ($_SESSION['myRole']=='admin')
                           {
                              $userRole = 'Administrator';
                           }
                           else if ($_SESSION['myRole']=='teamleader')
                           {
                              $userRole = 'Team Leader';

                           }else if ($_SESSION['myRole']=='member' || $_SESSION['myRole']=='')
                           {
                              $userRole = 'Member';
                           }

                           echo "<strong>Welcome ".$_SESSION['myFirstname']."</strong><br>";
                           echo $userRole;
                    ?>
                </div>

            <div class="row">
                <div class="col-xs-12">
                    <h3 class="text-left price-headline" style="color:green;"><strong>Manage Users</strong></h3>
                </div>

                
            </div>
                  
                  
            <hr>
            <div class="row">
                <?php
                    $user = new User();
                    $allUsers = $user->getAllUsers();
                    foreach($allUsers as $row)
                    {
                      $id = $row['id'];
                      $name = $row['lastname'].' '.$row['firstname'];
                      $email = $row['email'];
                      $location = $row['location'];
                      $address = $row['address'];
                      $country = $row['country'];
                      $pwd = $row['password'];
                      $role = $row['role'];
                      $datecreated = new DateTime($row['datecreated']);
                      $datecreated = $datecreated->format('l jS F, Y');

                      $editUrl="<a href='EditP.php?id=".$id."'>Edit</a>";
                      $deleteUrl = "<a href='DelP.php?id=".$id."'>Delete</a>";
                      if ($role=='')
                      {
                        $role = 'member';
                      }

                      $memberLink = "<a href='Miembro.php?mp=aHR0cHM6Ly9haXJ2aWV3c3RvcmFnZS5ibG9iLmNvcmUud2luZG93cy5uZX-".$id."-QvYXZhdGFycy9hYzE4ZWNiNjZkN2ZiYTE4YzY3MTUxYzM3MDhiMmMzZQ'>".$name."</a>"

                ?>  
                      <div class="row" style="color:green">
                          <div class="col-xs-3">
                              <?php
                                  echo "<strong><i class='fa fa-user-o'></i> ".$memberLink."</strong><br/><small><i class='fa fa-map-marker'></i> ".$location."</small>";
                              ?>
                          </div>
                          <div class="col-xs-3">
                              <?php
                                  echo "<i class='fa fa-envelope-o'></i> ".$email;
                              ?>
                          </div>
                          <div class='col-xs-2'>
                              <?php
                                  echo "<i class='fa fa-tasks'></i> ".$role;
                              ?>
                          </div>
                          <div class="col-xs-4">
                              <?php
                                  echo "<small><i class='fa fa-calendar-o'></i> ".$datecreated."</small>";
                              ?>
                          </div>

                      </div>
                      <hr>

                <?php

                    }
                ?>

            </div>

             
            
                          
    </div><!-- end of container //--> 

     
  

    
</body>
<?php
   require_once("footer.php");

?>
