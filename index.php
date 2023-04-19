<?php


session_start();

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

define('BASE_PATH', __DIR__);
define('CURRENT_DOMAIN', currentDomain() . '/project/');
define('DISPLAY_ERROR', true);
define('DB_HOST', 'localhost');
define('DB_NAME', 'project');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

require_once 'database/DataBase.php';
require_once 'database/CreateDB.php';
require_once 'activities/Admin/Admin.php';
require_once 'activities/Admin/Category.php';
//$db=new database\CreateDB();
//$db->run();
//routing system

function uri($reservedUrl, $class, $method, $requestMethod = 'GET')
{


//current url Array
	
	$currentUrl = explode('?', currentUrl())[0];
	$currentUrl = str_replace(CURRENT_DOMAIN, '', $currentUrl);
	$currentUrl = trim($currentUrl, '/');
	$currentUrlArray = explode('/', $currentUrl);
	$currentUrlArray = array_filter($currentUrlArray);


//reserved url Array
	
	$reservedUrl = trim($reservedUrl, '/');
	$reservedUrlArray = explode('/', $reservedUrl);
	$reservedUrlArray = array_filter($reservedUrlArray);
	
	
	if (sizeof($currentUrlArray) != sizeof($reservedUrlArray) || methodField() != $requestMethod) {
		
		
		return false;
		
	}
	
	$parameters = [];
	for ($key = 0; $key < sizeof($currentUrlArray); $key++) {
		
		if ($reservedUrlArray[$key][0] == "{" && $reservedUrlArray[$key][strlen([$key][0]) - 1] == "}") {
			
			array_push($parameters, $currentUrlArray[$key]);
			
			
		} elseif ($reservedUrlArray[$key] !== $currentUrlArray[$key]) {
			
			
			return false;
		}
		
		
	}
	
	
	if (methodField() == 'POST') {
		
		$request = isset($_FILES) ? array_merge($_POST, $_FILES) : $_POST;
		$parameters = array_merge([$request], $parameters);
	}
	
	$object = new $class;
	call_user_func_array(array($object, $method), $parameters);
	exit();
	
	
}


// admin/category/edit{4} reserverd
// admin/category/edit 4 current
//uri('public/category','create','index');


// helpers1

function protocol()
{
	
	if (stripos($_SERVER['SERVER_PROTOCOL'], 'https://') === true) {
		
		
		return 'https://';
	} else {
		
		
		return 'http://';
	}
	
	
}

function currentDomain()
{
	
	return protocol() . $_SERVER['HTTP_HOST'];
	
	
}

function asset($src)
{
	
	$domain = trim(CURRENT_DOMAIN, '/ ');
	$src = $domain . '/' . trim($src, '/');
	return $src;
	
	
}


function url($url)
{
	
	$domain = trim(CURRENT_DOMAIN, '/ ');
	$url = $domain . '/' . trim($url, '/');
	return $url;
	
	
}


function currentUrl()
{
	
	
	return currentDomain() . $_SERVER['REQUEST_URI'];
}


//helpers2

function methodField()
{
	
	
	return $_SERVER['REQUEST_METHOD'];
}


function displayError($displayError)
{
	// if ($displayError) {
	// 	ini_set('display_errors', 1);
	// 	ini_set('display_startup_errors', 1);
	// 	error_reporting(E_ALL);
	// } else {
	// 	ini_set('display_errors', 0);
	// 	ini_set('display_startup_errors', 0);
	// 	error_reporting(0);
	// }
}

displayError(DISPLAY_ERROR);


global $flashMessage;

if (isset($_SESSION['flash_message'])) {
	
	$flashMessage = $_SESSION['flash_message'];
	unset($_SESSION['flash_message']);
}


function flash($name, $value = null)
{
	if ($value === null) {
		global $flashMessage;
		$message = isset($flashMessage[$name]) ? $flashMessage[$name] : '';
		return $message;
	} else {
		$_SESSION['flash_message'][$name] = $value;
	}
	
}

function dd($var)
{
	
	echo '<pre>';
	var_dump($var);
	exit();
	
	
}

//category
uri('admin/category', 'Admin\Category', 'index');
uri('admin/category/create', 'Admin\Category', 'create');
uri('admin/category/store', 'Admin\Category', 'store', 'POST');
uri('admin/category/edit/{id}', 'Admin\Category', 'edit');
uri('admin/category/update/{id}', 'Admin\Category', 'update', 'POST');
uri('admin/category/delete/{id}', 'Admin\Category', 'delete');

echo '404-page not found';
