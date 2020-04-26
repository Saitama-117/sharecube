<?php
require_once("classes/Config.php");

if (!isset($_GET['id']) || $_GET['id']=='')
{
	header("location:ManageP.php");
}

$projectid = $_GET['id'];

$project = new Project();
$project->deleteProject($projectid);
header("location:ManageP.php");

?>