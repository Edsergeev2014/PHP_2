<?php

function __autoload($classname){
	include_once("c/$classname.php");
}

$action = 'action_';
$action .= (isset($_GET['act'])) ? $_GET['act'] : 'index';

switch ($_GET['c'])
{
	case 'page':
		$controller = new C_User();
		break;
	default:
		$controller = new C_User();
}

$controller->Request($action);
