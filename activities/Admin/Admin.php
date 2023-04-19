<?php

namespace database;

class Admin
{
	protected string $currentDomain;
	protected string $basePath;
	
	function __construct()
	{
		$this->currentDomain = CURRENT_DOMAIN;
		$this->basePath = BASE_PATH;
	}
	
	
	protected function redirect($url)
	{
		header('Location : localhost/project/admin/category');
		exit;
	}
	
	protected function redirectBack($url)
	{
		header('Location : ' . $_SERVER['HTTP_REFERER']);
		exit;
	}
	
	protected function saveImage($image, $imagePath, $imageName = null)
	{
		if ($imageName) {
			$extension = explode('/', $imageName['type'])[1];
			$imageName = $imageName . '.' . $extension;
		} else {
			$extension = explode('/', $imageName['type'])[1];
			$imageName = date("Y-m-d-H-i-s") . '.' . $extension;
		}
		
		$imageTemp = $image['tmp_name'];
		$imagePath = 'public/' . $imagePath . '/';
		
		if (is_uploaded_file($imageTemp) && move_uploaded_file($imageTemp, $imagePath . $imageName)) {
			return $imagePath . $imageName;
		}
		
		return false;
	}
	
	
	protected function removeImage($path)
	{
		$path = trim($this->basePath, '/ ') . '/' . trim($path, '/ ');
		
		if (file_exists($path)) {
			unlink($path);
		}
	}
}
