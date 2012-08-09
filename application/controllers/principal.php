<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Usuario_model', 'usuario');
		$this->load->model('Perfil_model', 'perfil');
		$this->load->helper('string');
	}
	
	function login()
	{
		$this->phpsession->clear('usuario');

		$url = explode("/", $this->uri->uri_string());
		
		// Remove a parte que chama a class Principal
		unset($url[0]);
		//Remove a parte que chamada o método login
		unset($url[1]);
		
		// Remonta a url somente com os parametros de redirecionamento
		$url = site_url(implode($url, "/"));
		
		$this->template->show('login',  array("url"=>$url));

//		$this->load->view('login', array("url"=>$url) );
	}
	
	function logar($idCriado = false)
	{
		$retorno = array();
		$retorno['ok'] = FALSE;

		if($idCriado!=false && intval($idCriado)>0){
			$dados_user = $this->usuario->get(array('id_user'=>(int)$idCriado));
			$login = $dados_user[0]->email; 
			$senha = (isset($_SESSION['forceLogin']) && $_SESSION['forceLogin']!=false ? $_SESSION['forceLogin'] : false);
			$_SESSION['forceLogin'] = false;
		}else{
			$login = $this->input->post('login');
			$senha = md5($this->input->post('senha'));
		}
		
		$usuario = array_shift($this->usuario->get( array("login" =>$login, "password" => $senha ) ));

		if(!$usuario) {
			$retorno['msg'] = "Login ou senha inv&aacute;lidos!";
		}else{
			$retorno['ok'] = TRUE;
			$this->phpsession->save('usuario', $usuario);
			$this->usuario->logar_ultimo_acesso();
		}

		if($retorno['ok']==true){
			header("location:" . site_url('evento'));	
		}else{
			echo $retorno['msg'];
		}
	}
	
	function logout()
	{
		$usuario = $this->phpsession->get('usuario');
	
		$this->phpsession->clear('usuario');

		header("location:" . site_url('principal/login'));
	}
	
	function nao_autorizado()
	{
		$this->template->show('sem_permissao');
	}
}
?>
