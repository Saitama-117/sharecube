<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("includes/login_module.php");
   $pageTitle = "Create Project";  
   require_once("classes/Config.php");
   require_once("header.php");    
   //require_once("AdminBar.php");


   
   $status='';

   if (isset($_POST['submitForm']))
   {
        $longname = $_POST['longname'];
        $shortname = $_POST['shortname'];

        if ($longname=='' || $shortname=='')
        {
           $status='warning';
           $msg = "All fields are required to be filled before continuing.";
        }else
        {
            $project = new Project();
            $result = $project->createproject($longname,$shortname);
            $status = $result["status"];
            $msg = $result["msg"];
        }
   }

    

?>
    

   

    

<body style=background:black>
        <br/>
        <br/>
        <br/>
        
        <div class="container" >

            <div class="row" style="color:#c3c3c3">
                <div class="col-xs-12 text-right">
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

                <div class="col-xs-12">
                    <h3 class="text-left price-headline" style="color:green;"><strong>Create Project</h3></strong>
                </div>

                
            </div>
                  
                  <!-- row 1 //-->
                  <hr>
             
            <?php
                  require_once("functions/Alert.php");

            ?>
           

             <form name="create_project" action="CreateP.php" method="post">     
              <div class="form-group row">
            
                   <label style="color:gray" for="Project Name" class="col-xs-12 col-sm-2 col-form-label text-right"><strong>Project Name</label></strong>
                      
                    <div class="col-xs-12 col-sm-10">
                        
                            <input class="form-control" type="text" name="longname"/>                     
                    </div> 

              </div>
              <div class="form-group row">
                  
                  <label style="color:gray" for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right">Project Short Name</label>
                  
                  <div class="col-xs-12 col-sm-5">
                      <input class="form-control" type="text" name="shortname"/>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-xs-12 col-sm-2"></div>
                  <div class="col-xs-12 col-sm-10">
                      <input style="background:gray" class="btn btn-primary" type="submit" name="submitForm" value="Create"/>
                  </div>
              </div>
              </form>
                          
    </div><!-- end of container //--> 

     
  

 <br/><br/><br/><br/><br/><br/><br/><br/>   
</body>
<?php
   require_once("footer.php");

?>
