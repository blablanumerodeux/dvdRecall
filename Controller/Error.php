<?php
abstract class Controller_Error extends Controller_Template{

	public static function documentNotFound($title){
		header('HTTP/1.1 404 Not Found');
		header('Content-Type: text/html; charset=utf-8');
		include './Vues/header.tpl';
		include './Vues/error/404.tpl';
		include './Vues/footer.tpl';
	}
}

