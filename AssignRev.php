<?php

if (!isset($_GET['pid']) || $_GET['pid']=='')
{
  header("location: Submited.php");
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("includes/login_module.php");
   $pageTitle = "Assign User to Project";  
   require_once("classes/Config.php");
   require_once("header.php");    
   
   
   $status='';

   $paperid = $_GET['pid'];
   $pageLink = "AssignRev.php?pid=".$paperid;
   $paper = new Paper();
   $paperInfo  = $paper->getPaperById($paperid);

   
   foreach($paperInfo as $result)
   {
      $paperTitle = $result["title"];
      $paperProject = $result['name'];
      $paperDesc = $result['description'];
      $paperFile = $result['file'];
      $paperUserId = $result['userid'];
      $paperSubmitedby = $result['lastname'].' '.$result['firstname'];
      $paperDate = new DateTime($result['datesubmitted']);
      $paperDate = $paperDate->format('l jS F, Y');
   }


   

  //Submit button to assign  paper to user
   if (isset($_POST['submitForm']))
   {
        $userid = $_POST['user'];
        $duration = $_POST['duration'];


        if ($paperid=='' || $userid=='' || $duration=='' )
        {
           $status='warning';
           $msg = "All fields are required to be filled before continuing.";
        }else
        {
            $dataArray = array("paperid"=>$paperid,"userid"=>$userid,"duration"=>$duration);
            $paper = new Paper();            
            $result = $paper->AssignReviewer($dataArray);
            $status = $result["status"];
            $msg = $result["msg"];
        }
   }

    

?>
<body style="background:black">  
        <br/><br/><br/>
  
        <div class="container">
            <div class="col-xs-12 text-right"style="color:#c3c3c3">
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
                    <h3 class="text-left price-headline" style="color:green;"><strong>Paper Title: <?php echo $paperTitle; ?></strong></h3>
                </div>

                
            </div>
                  
                  <!-- row 1 //-->
                  <br>
             
            <?php
                  require_once("functions/Alert.php");

            ?>
           

             <form name="uploadpaper" action="<?php echo $pageLink; ?>" method="post" enctype="multipart/form-data">     
              
              <div class="form-group row" style="color:#c3c3c3">
                  
                  <label for="Project Name"  class="col-xs-12 col-sm-2 col-form-label text-right">Select Reviewer</label>
                  
                  <div class="form-group col-xs-12 col-sm-5">
                      <select class="form-control" name="user">
                            <option></option>

                            <?php
                              $project = new User();
                              $result = $project->getAllUsers();
                              foreach ($result as $row)
                              {
                                $id = $row['id'];
                                $name =  $row['lastname'].' '.$row['firstname'];

                                

                            ?>
                            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                             

                            <?php

                              }

                            ?>   
                      </select>
                  </div>
              </div>

              <div class="form-group row" style="color:#c3c3c3">
            
                   <label for="Project Name" class="col-xs-12 col-sm-2 col-form-label text-right">Duration (in days)</label>
                      
                    <div class="col-xs-12 col-sm-4">
                        
                            <input  class="form-control" type="text" name="duration" value="15"/>                      
                    </div> 

              </div>
             
                            
              <div class="row" style="margin-top:10px;" >
                  
                  <div class="col-xs-2 col-sm-2">&nbsp;</div>
                  <div class="col-xs-10 col-sm-10">
                      <input style="background:gray" class="btn btn-primary" type="submit" name="submitForm" value="Assign Reviewer"/>
                  </div>
              </div>

              </form>

              <br/>
               <br>
              
              
              
              <div class="row">
                  <div class="col-xs-12">
                    <h4 class="text-left price-headline" style="color:green;font-weight:bold;">Assigned Reviewers</h4>
                </div>
                  <ol>
                <?php
                    $selReviewers = $paper->getReviewersToPaper($paperid);

                    foreach($selReviewers as $row)
                    {
                        $dateassigned = new DateTime($row['dateassigned']);
                        $dateassigned = $dateassigned->format('l jS F, Y');
                        echo "<li>".$row['lastname'].' '.$row['firstname']."  - <small>assigned on ".$dateassigned." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#'>Remove</a></small></li>";


                    }

                ?>
                  </ol>
              </div>
              <br/>
              <br>

            <!--
              <div class="row">
                  <div class="col-xs-12">
                    <h4 class="text-left price-headline" style="color:purple;font-weight:bold;">Paper Details</h4>
                </div>

              </div>
              <br/>
              <div class="row" >
                  <div class="col-xs-12">
                      <strong>Project Group</strong>
                        <?php 
                            echo "<br/><i class='fa fa-folder-o'></i> <a href='ManageP.php'>".$paperProject."</a><br/></br>"; 
                           
                        ?>
                  </div>

                  <div class="col-xs-12">
                      <strong>Paper Title</strong>
                        <?php 
                            echo "<br/><i class='fa fa-file-o'></i> <a href='Submited.php'>".$paperTitle."</a><br/><br/>"; 
                           
                        ?>
                  </div>
                  <div class="col-xs-12">
                        <strong>Description</strong>
                        <?php  
                            echo "<br/><i class='fa fa-comment-o'></i> ".$paperDesc."<br/><br/>";
                        ?>
                  </div>
                  <div class="col-xs-12">
                      <Strong>File</Strong>
                      <?php
                            echo "<br/><i class='fa fa-file-o'></i> <a target='_blank' href='uploads/".$paperFile."'>".$paperFile."</a><br/><br/>";              
                      ?>
                  </div>

                  <div class="col-xs-12">
                      <Strong>Submitted By</Strong>
                      <?php
                            echo "<br/><i class='fa fa-user-o'></i> <a target='_blank' ".$paperUserId."'>".$paperSubmitedby."</a><br/><br/>";              
                      ?>
                  </div>

                  <div class="col-xs-12">
                      <Strong>Date Submitted</Strong>
                      <?php
                            echo "<br/><i class='fa fa-calendar-o'></i> ".$paperDate."</a>";              
                      ?>
                  </div>


              </div>
             -->



              
                          
    </div><!-- end of container //--> 

     
  

    

<?php
   require_once("footer.php");

?>
