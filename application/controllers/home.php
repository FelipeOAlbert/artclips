<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Usuario_model', 'usuario');
		$this->load->model('Perfil_model', 'perfil');
		$this->load->helper('string');
	}
	
	function index(){
		$this->template->show('login',  array("url"=>$url));
	}
}
?>
