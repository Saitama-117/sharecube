<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("includes/login_module.php");
   $pageTitle = "Papers assigned awaiting review";  
   require_once("classes/Config.php");
   require_once("header.php");    
   
   
   $status='';   

   $paper = new Paper();
   $reviews = $paper->MemberAssignedPapersInReview($_SESSION['myUserId']);
   $numInReview = $reviews->num_rows;


   

    

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
                    <h3 class="text-left price-headline" style="color:green;"><strong>Assigned Papers Awaiting Review</strong></h3>
                </div>                
              </div>
              
              <br>     


              
              <div class="row"style="color:green">
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
                    <div class="row">
                        <div class="col-xs-4">
                              <i class='fa fa-folder-o'></i>
                              <?php echo "<a >".$res['name']."</a>";  ?>

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
              
              


              
             



              
                          
    </div><!-- end of container //--> 

     
  

    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/> 
</body>
<?php
   require_once("footer.php");

?>
