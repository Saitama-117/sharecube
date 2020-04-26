
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("includes/login_module.php");
   $pageTitle = "Manage Users";  
   require_once("classes/Config.php");
   require_once("header.php");    
   

   
   

   $paper = new Paper();
   $submissions = '' ;
   $reviews = '';
   $archive = '';

   if ($_SESSION['myRole']=='admin' || $_SESSION['myRole']=='teamleader' )
   {
      $submissions = @$paper->getAllSubmitedPapers();
      $reviews = $paper->getAllPapersInReview();
      

   }
   if ($_SESSION['myRole']=='member' || $_SESSION['myRole']=='')
   {
      
      $submissions = $paper->SubmitedPapersByMember($_SESSION['myUserId']);
      $reviews = $paper->MemberAssignedPapersInReview($_SESSION['myUserId']);
      
      
   }

   $archive = $paper->ReviewedPapers();

   
   $totalSubmissions = @$submissions->num_rows;
   $totalPapersInReview = @$reviews->num_rows;
   $totalInArchive = $archive->num_rows;

    

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

                <!--Browse Header-->
                <div class="col-xs-12">
                    <h3 class="text-left price-headline" style="color:green;"><strong>Reviews</h3><strong>
                </div>

                
            </div>
                  
                  
            <br/>
            <div class="row">
               <div class='col-xs-12'>
                    <div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                              <!--<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" style="color:green"><strong>Submissions (<?php echo $totalSubmissions; ?>)</strong></a></li>-->
                              <li role="presentation" ><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"style="color:green"><strong>Reviews (<?php echo $totalPapersInReview; ?>)</strong></a></li><br/>
                              <!--<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"style="color:green"><strong>Archives (<?php echo $totalInArchive; ?>)</strong></a></li>-->
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                              <!--<div role="tabpanel" class="tab-pane active" id="home" style="color:green">
                              <br/>
                                  <div class='row'>
                                      <div class='col-xs-4' >
                                          <strong><big>Project Group</big></strong>    
                                      </div>
                                      <div class='col-xs-4'>
                                          <strong><big>Title</big></strong>
                                      </div>
                                      <div class='col-xs-4'>
                                          <strong><big>File</big></strong>
                                      </div>
                                  </div>
                                  <hr>remover-->
                                 <!-- <?php

                                       
                                        foreach($submissions as $row)
                                        {
                                          $datesubmitted = new DateTime($row['datesubmitted']);
                                          $datesubmitted = $datesubmitted->format('l jS F, Y');
                                  ?>
                                      <div class='row' >
                                          <div class='col-xs-4'>
                                              <?php 
                                                  echo "<i class='fa fa-folder-o'></i> <a href='#'>".$row['name']."</a><br/>";
                                                  echo "<small>Submitted on ".$datesubmitted."</small>"
                                              ?>
                                          </div>
                                          <div class='col-xs-4'>
                                                <?php
                                                    echo "<i class='fa fa-file-o'></i> <a href='FileInfo.php?pid=".$row['id']."'>".$row['title']."</a>";

                                                ?>
                                          </div>
                                          <div class='col-xs-4'>
                                                <?php
                                                    echo "<i class='fa fa-paperclip'></i> <a href='uploads/".$row['file']."'>".$row['title']."</a>";

                                                  ?>
                                          </div>
                                      </div>
                                      <hr>
                                  <?php 

                                        }

                                  ?>-->





                              </div>
                              <div role="tabpanel" class="tab-pane" id="profile">
                              <!-- In Reviews //-->
                              <br/>
                                  <div class="row" style="color:green">
                                      <div class="col-xs-4">
                                          <strong><big>Project Group</big></strong>
                                      </div>
                                      <div class="col-xs-5">
                                              <strong><big>Paper</big></strong>
                                      </div>
                                  </div>
              
                              <br/>   
              

                                <?php
                                      foreach($reviews as $res)
                                      {

                                          $paperid = $res['id'];

                                ?>
                                      <div class="row" style="color:green">
                                          <div class="col-xs-4">
                                                <i class='fa fa-folder-o'></i>
                                                <?php echo "<a href='projects.php'>".$res['name']."</a>";  ?>

                                          </div>
                                          <div class="col-xs-5">
                                                  <i class='fa fa-file-o'></i>
                                                  <?php echo "<a href='FileInfo.php?pid=".$res['id']."'>".$res['title']."</a>";
                                                  ?>
                                          </div>
                                          <div class="col-xs-3">
                                                
                                                  <?php
                                                     echo "<strong><big>
                                                              <a href='ReviewP.php?pid=".$res['id']."'>Review this Paper</a>
                                                           </big></strong>";
                                                  ?>
                                          </div>
                                          <div class="col-xs-12">
                                                    <h5><strong>Assigned Reviewers</strong></h5>
                                                    <ol>
                                                        <?php
                                                            $selReviewers = $paper->getReviewersToPaper($paperid);

                                                            foreach($selReviewers as $row)
                                                            {
                                                                $dateassigned = new DateTime($row['dateassigned']);
                                                                $dateassigned = $dateassigned->format('l jS F, Y');
                                                                echo "<li>".$row['lastname'].' '.$row['firstname']."  - <small>assigned on ".$dateassigned." &nbsp;&nbsp;&nbsp;<strong>(Duration: ".$row['duration']." days)</strong></small></li>";

                                                            }

                                                      ?>
                                                    </ol>

                                          </div>
                                      </div>
                                      <hr>
                                <?php 

                                      }

                                ?>
                                <br/>


                              <!-- end of reviews //-->
                              





                              </div>
                              
                            </div>

                          </div>
               </div><!-- end of col //-->
            </div><!-- end of row //-->
             
            
                          
    </div><!-- end of container //--> 

     
  

    </body>    
<br/><br/><br/><br/><br/>
<?php
   require_once("footer.php");

?>
