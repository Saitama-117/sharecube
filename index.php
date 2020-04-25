<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  session_start();
  session_destroy();
  $pageTitle = "Home_Page";
  require_once("classes/Config.php");

  $msg = "";
  $status = "";
  $content = "";

  //check if cookie is set
  if (isset($_COOKIE['username']) && $_COOKIE['password'])
    {
    
    loginFunction($_COOKIE['username'],$_COOKIE['password']);
    }



  //Login form functionality
  if (isset($_POST['submitForm']))
   {
      $usernm = SanitizeField::clean($_POST['username']);
      $password = SanitizeField::clean($_POST['epassword']);    
    
      if ($usernm!="" && $password!="")
        {
          if (!empty($_POST['remember_me']))
            {
               setcookie("username",$usernm,time()+3600);
               setcookie("password",$password, time()+3600);
               //echo "Cookie set successfully";
            }
            else{
              //echo "Remember me is not set";
              setcookie("username",'');
              setcookie("password",'');
                }
          loginFunction($usernm,$password);
        }else
          {
            $status = "error";
            $msg = "Username and password is required to login.";
          }
    }   


  //Login function
  function loginFunction($username,$password)
  {
    $member = new Member();
    $dataArray = array("username"=>$username,"password"=>$password);
    $result =  $member->login($dataArray);

    if ($result['status']=="success")
      {
        session_start();
        $_SESSION['memberLogin'] = 'mtabernacle2019';
        $_SESSION['myUserId'] = $result["id"];
        $_SESSION['myLastname'] = $result["lastname"];
        $_SESSION['myFirstname'] = $result["firstname"];
        $_SESSION["myLocation"] = $result["location"];
        $_SESSION["myAddress"] = $result["address"];
        $_SESSION["myEmail"] = $result["email"];
        $_SESSION["myCountry"] = $result["country"];
        $_SESSION["myPhoto"] = $result["photo"];
        $_SESSION['myAboutme'] = $result['aboutme'];
        $_SESSION['myRole'] = $result['role'];

        header("location:BrowseFile.php");
      }
        else
        {
           $status = $result["status"];
           $msg = $result["message"];
        }

  }
//end of loginFunction

  require_once("header.php");
  require_once("GuestBar.php");
?>

    <section id="header">
      <div class="container">
        
        <div class="row">
            <div class="col-xs-12 col-sm-7 hidden-xs">
                <br/>
                <h1 style= color:green>Welcome to ShareCube<br/><small>Research Sharing App</small></h1>

                <img src="" style='width:100%;'/>

                <br/><br/>
                This web application aims to upload, identification, review, monitoring and tracking research papers among group members on a simple and easy way. Monitoring and tracking progress of papers taking in consideration report writing, review, editing by any group member. Sharing knowledge amount us.
                <br/><br/>
                

            </div>
            <div class="col-sm-5">
                <br/><br/>
                <h2 style=color:green>Enter your credential</h2>
                <br/>
            <!-- Login form //-->
            <?php
                  require_once("functions/Alert.php");

            ?>

<!--style-->
            <style>
              body {font-family: Arial, Helvetica, sans-serif; background: black;}

              /* Full-width input fields */
              #email, #epassword {
                width: 35%;
                padding: 10px 10px;
                margin: 10px 0;
                display: inline-block;
                border: 1px solid #ccc;
                box-sizing: border-box;
              }

              /* Set a style for all buttons */
              button {
                background-color: grey;
                color: white;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                cursor: pointer;
                width: 100%;
              }

              button:hover {
                opacity: 0.8;
              }

              /* Extra styles for the cancel button */
              .cancelbtn {
                width: auto;
                padding: 10px 18px;
                background-color: red;
              }

              .container {
                padding: 16px;
              }

              span.psw {
                right: 50px
                padding-top: 16px;
              }

              /* The Modal (background) */
              .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
                padding-top: 60px;
              }

              /* Modal Content/Box */
              .modal-content {
                background-color: #fefefe;
                margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
                border: 1px solid #888;
                width: 30%; /* Could be more or less, depending on screen size */
              }

              /* The Close Button (x) */
              .close {
                position: absolute;
                right: 25px;
                top: 0;
                color: red;
                font-size: 35px;
                font-weight: bold;
              }

              .close:hover,
              .close:focus {
                color: red;
                cursor: pointer;
              }

              /* Add Zoom Animation */
              .animate {
                -webkit-animation: animatezoom 0.6s;
                animation: animatezoom 0.6s
              }

              @-webkit-keyframes animatezoom {
                from {-webkit-transform: scale(0)} 
                to {-webkit-transform: scale(1)}
              }
                
              @keyframes animatezoom {
                from {transform: scale(0)} 
                to {transform: scale(1)}
              }

              /* Change styles for span and cancel button on extra small screens */
              @media screen and (max-width: 300px) {
                span.psw {
                  display: block;
                  float: none;
                }
                .cancelbtn {
                  width: 100%;
                }
              }
            </style>
<!--style finish-->

<!-- Login Botom-->
    <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>

      <div id="id01" class="modal">
                                          
        <form id="singin" class="modal-content animate" action="index.php" method="post">
        <div class="imgcontainer">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      </div>

      <div class="container">
        <div class="form-group">
          <label class="col-xs-12 control-label no-padding-right text-left" for="Username"> Username  </label>
          <div class="input-group">
          <div class="input-group-addon"><span class="fa fa-user-o"></span></div>
          <input type="text" class="form-control" id="email" name="username" placeholder="Please enter username">
        </div>
      </div>

      <label class="col-xs-12 control-label no-padding-right text-left" for="Password"> Password  </label>
      <div class="input-group">
        <div class="input-group-addon"><span class="fa fa-key"></div>
        <input type="password" class="form-control" name="epassword" id="epassword" placeholder="Please enter password">
      </div>
                                                
      <input type="submit" name="submitForm" class="btn btn-default" value="Login ">
      <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
      
      <!--</div>-->

      <div class="container" >
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        <span class="psw">Forgot <a href=mailto:burogi.god@gmail.com>password?</a></span>
      </div>
    </form>
      <!--</div>-->

      <script>
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) 
          {
            modal.style.display = "none";
          }
                                          }
      </script>
<!-- end of Login bottom //-->    
          </div> 
        </div>
      </div><!-- container //-->
    </section>
   
 <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

<?php
   require_once("footer.php");
?>
<script type="text/javascript" src="js/datetimelibrary.js"></script>
<script type="text/javascript" src="js/newsletter.js"></script>