<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("includes/login_module.php");
   $pageTitle = "Manage Project";  
   require_once("classes/Config.php");
   require_once("header.php");    
   
   
   

    

?>
 <body style="background:black">   

   

    

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
                    <h3 class="text-left price-headline" style="color:green;"><strong>Manage Project</h3></strong>
                </div>

                
            </div>
                  
                  
            <hr>
            <div class="row">
                <?php
                    $project = new Project();
                    $allProjects = $project->getAllProject();
                    foreach($allProjects as $row)
                    {
                      $id = $row['id'];
                      $name = $row['name'];
                      $code = $row['code'];
                      $datecreated = new DateTime($row['datecreated']);
                      $datecreated = $datecreated->format('l jS F, Y');

                      $editUrl="<a href='EditP.php?id=".$id."'>Edit</a>";
                      $deleteUrl = "<a href='DelP.php?id=".$id."'>Delete</a>";


                ?>  
                      <div class="row" style="color:gray">
                          <div class="col-xs-12">
                              <?php
                                echo "<strong></i> ".$name."</strong><br/><small><i class='fa fa-edit'></i> ".$editUrl." &nbsp; &nbsp;| &nbsp;&nbsp; <i class='fa fa-trash-o'></i> ".$deleteUrl."</small>";
                              ?>
                          </div>
                      </div>
                      <hr>

                <?php

                    }
                ?>

            </div>

             
            
                          
    </div><!-- end of container //--> 

     
  

 </br></br></br></br></br></br></br></br></br></br></br>   
 </body>
<?php
   require_once("footer.php");

?>
