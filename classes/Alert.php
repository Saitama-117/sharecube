<?php

class Alert
{
	public function __construct()
	{
		
	}

	public static function display($heading,$msg,$err)
	{
		$panelClass = '';
		$icon = '';

		if ($err==true)
		{
			$panelClass = 'class="alert alert-danger"';
			$icon = "ace-icon fa fa-times";
		}
		else
		{
			$panelClass = 'class="alert alert-success"';
			$icon = "ace-icon fa fa-check";
		}

		

		$result = "<div $panelClass role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    						<span aria-hidden='true'>&times;</span>
  					</button>

  					<h4 class='alert-heading'><i class='".$icon."'></i> <strong>".$heading."</strong></h4>
  					<p>".$msg."</p><br/></div>";
		return $result;
	}

}

?>