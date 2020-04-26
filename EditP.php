<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
   require_once("includes/login_module.php");
   $pageTitle = "Edit Project";  
   require_once("classes/Config.php");
   require_once("header.php");    
   require_once("AdminBar.php");
   
   if (!isset($_GET['id']) && $_GET['id']!='')
   {
      header("location:ManageP.php");
   }

   $projectid = $_GET['id'];
   $pageUrl = "EditP.php?id=".$projectid;

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
            $result = $project->updateproject($projectid,$longname,$shortname);
            $status = $result["status"];
            $msg = $result["msg"];

            
        }
   }


   $project = new Project();
   $aproject = $project->getProductById($projectid);

   foreach ($aproject as $row)
   {
     $name = $row['name'];
     $code = $row['code'];
   }

    

?>
<body style="background:black">    

    <br/><br/>

    


   
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <h3 class="text-left price-headline" style="color:green;">Edit Project</h3>
                </div>

                
            </div>
                  
                  <!-- row 1 //-->
                  <br>
             
            <?php
                  require_once("functions/Alert.php");

            ?>
           

             <form name="create_project" action="<?php echo $pageUrl; ?>" method="post">     
              <div class="form-group row">
            
                   <label for="Project Name" class="col-xs-12 col-sm-2 col-form-label text-right" style="color:#c3c3c3">Project Name</label>
                      
                    <div class="col-xs-12 col-sm-10">
                        
                            <input class="form-control" type="text" name="longname" value="<?php echo $name;?>" />                     
                    </div> 

              </div>
              <div class="form-group row">
                  
                  <label for="Project Short Name"  class="col-xs-12 col-sm-2 col-form-label text-right" style="color:#c3c3c3">Project Short Name</label>
                  
                  <div class="col-xs-12 col-sm-5">
                      <input class="form-control" type="text" name="shortname" value="<?php echo $code; ?>"/>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-xs-12 col-sm-2"></div>
                  <div class="col-xs-12 col-sm-10">
                      <input style="background:gray" class="btn btn-primary" type="submit" name="submitForm" value="Edit"/>
                  </div>
              </div>
              </form>
                          
    </div><!-- end of container //--> 

     
  

    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</body>
<?php
   require_once("footer.php");

?>
