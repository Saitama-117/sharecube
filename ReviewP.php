<?php

if (!isset($_GET['pid']) || $_GET['pid']=='' )
{
   header("location:AwaitingFeed.php");
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("includes/login_module.php");
   $pageTitle = "Review Paper";  
   require_once("classes/Config.php");
   require_once("header.php");    
   
   

   $status='';

   $paperid = $_GET['pid'];
   $pageLink = "ReviewP.php?pid=".$paperid;
   $paper = new Paper();
   $paperinfo = $paper->getPaperById($paperid);

   foreach($paperinfo as $result)
   {
     $paperId = $result['id'];
     $paperTitle = $result['title'];
     $paperProject = $result['name'];
     $paperDescription = $result['description'];
     $paperFile = $result['file'];
     $paperDateSubmitted = $result['datesubmitted'];
     $paperStatus = $result['status'];
   }


   $projectid = '';
   $comment = '';
   $title = '';


   if (isset($_POST['submitForm']))
   {
        
        $comment = $_POST['comment'];

        
        if ($comment=='')
        {
           $status='warning';
           $msg = "Comment is required to submit a review.";
        }else
        {
            $dataArray = array("paperid"=>$paperid,"comment"=>$comment,"file"=>$_SESSION['uploadedFile'],"submitedby"=>$_SESSION['myUserId']);
            $paper = new Paper();            
            $result = $paper->submitReview($dataArray);
            $status = $result["status"];
            $msg = $result["msg"];

            $comment = '';
            unset($_SESSION['uploadedFile']);
        }
   }


   if (isset($_POST['uploadFile']))
   {
        $userid = $_SESSION['myUserId'];
        $comment = $_POST['comment'];        
       
   }

    

?>  
        <br/>
  
        <div class="container">
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

                           echo "<strong>Welcome ".$_SESSION['myLastname'].' '.$_SESSION['myFirstname']."</strong>,<br>";
                           echo $userRole;
                    ?>
                </div>

            <div class="row">
                <div class="col-xs-12">
                    <h3 class="text-left price-headline" style="color:purple;">Review Paper <small>(<?php echo $paperTitle;  ?>)</small></h3>
                </div>

                
            </div>
                  
                  <!-- row 1 //-->
                  <hr>
             
            <?php
                  require_once("functions/Alert.php");

            ?>
           

             <form name="uploadpaper" action="<?php echo $pageLink; ?>" method="post" enctype="multipart/form-data">     
              
              <div class="form-group row">
                  
                  <label for="Project Name"  class="col-xs-12 col-sm-2 col-form-label text-right">Title</label>
                  
                  <div class="col-xs-12 col-sm-7">
                        <i class='fa fa-file-o'></i> 
                          <?php 
                              echo "<a target='_blank' href='FileInfo.php?pid=".$paperId."'>".$paperTitle."</a> &nbsp;&nbsp;&nbsp;&nbsp;<small>[<strong>Project Group</strong> &nbsp;&nbsp;<i class='fa fa-folder-o'></i> ".$paperProject."]</small>"; 
                          ?>
                  </div>
              </div>

              
              <div class="form-group row">
                  
                  <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right">Comment</label>
                  
                  <div class="col-xs-12 col-sm-8">
                      <textarea class="form-control" cols="80" rows="5" name="comment"><?php echo  $comment; ?></textarea>
                  </div>
              </div>

              <div class="row">
                  <div class="col-xs-3"></div>
                  <div class="col-xs-9">
                      <?php
                          if (isset($_POST['uploadFile']))
                          {
                            echo "<strong>";
                            require_once("Carga.php");
                            echo "</strong><br/><br/>";

                          }                  
                      ?>
                  </div>
              </div>

              <div class="form-group row">
                  
                  <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right">Review File</label>
                  
                  <div class="col-xs-7 col-sm-5">
                      <input type="file" name="fileToUpload" >
                      <input type="submit" name="uploadFile" value="Upload File" class="btn btn-default btn-sm">
                  </div>
                  
              </div>
                            
              <div class="row" style="margin-top:10px;">
                  
                  <div class="col-xs-2 col-sm-2">&nbsp;</div>
                  <div class="col-xs-10 col-sm-10">
                      <input  class="btn btn-primary" type="submit" name="submitForm" value="Submit Review"/>
                  </div>
              </div>

              </form>

              <?php
                $paper = new Paper();
                $list = $paper->ReviewedPapersByMember($_SESSION['myUserId']);
                $totalPapers = $list->num_rows;
              ?>

              <br/><br/>
              <div class="row">
                  <div class="col-xs-12">
                    <h4 class="text-left price-headline" style="color:purple;font-weight:bold;">My Reviews (<?php echo $totalPapers; ?>)</h4>
                </div>

              </div>
              <div class="row" >
                  <div class="col-xs-4">
                        <strong><big>Project</big></strong>
                  </div>
                  <div class="col-xs-4">
                        <strong><big>Paper Title</big></strong>
                  </div>
                  <div class="col-xs-4">
                      <strong><big>File</big></strong>
                  </div>

              </div>
              <br/>
              <?php
                  
                  foreach($list as $row)
                  {
                    $datesubmitted = new DateTime($row['datesubmitted']);
                    $datesubmitted = $datesubmitted->format('l jS F, Y');
                    
              ?>
              <div class="row" >
                  <div class="col-xs-4">
                        <?php 
                            echo "<i class='fa fa-folder-o'></i> <a href='ManageP.php'>".$row['name']."</a><br/>"; 
                            echo "<small>Submitted on ".$datesubmitted."</small>";
                        ?>
                  </div>
                  <div class="col-xs-4">
                        <?php  
                            echo "<i class='fa fa-comment-o'></i> <a href='FileInfo.php?pid=".$row['paperid']."'>".$row['title']."</a>";
                        ?>
                  </div>
                  <div class="col-xs-4">
                      <?php
                            echo "<i class='fa fa-file-o'></i> <a target='_blank' href='uploads/".$row['file']."'>".$row['file']."</a>";              
                      ?>
                  </div>

              </div>
              <hr>



              <?php
                  }
              ?>
                          
    </div><!-- end of container //--> 

     
  

    

<?php
   require_once("footer.php");

?>
