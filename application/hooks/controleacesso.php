<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ControleAcesso extends CI_Hooks{
	public $CI;
	public $usuario;
	public $paginas_sem_login = array();
	public $perfis = array();
	public $permissoes = array();

	function __construct() {
		parent::__construct();
		$this->CI =& get_instance();

		$this->usuario = $this->CI->phpsession->get('usuario');

		$this->carrega_paginas_sem_login();

		if($this->usuario){
			$this->carrega_perfis($this->usuario->id_usuario);
			$this->usuario->perfis = $this->perfis;
			
			$this->carrega_permissoes($this->usuario->id_usuario);
			$this->usuario->permissoes = $this->permissoes;
			
			$this->CI->phpsession->save('usuario', $this->usuario);
		}
		
	}

	public function index($params){
		$baseURL = $GLOBALS['CFG']->config['base_url'] . "index.php/";
		$routing =& load_class('Router');
		$class = $routing->fetch_class();
		$method = $routing->fetch_method();

		//$url = $class . "/" . $method;
		
		$uri_class =& load_class('URI');
		$url = $uri_class->uri_string();
		

		// Verifica se pode acessar a página sem estar logado
		if(!empty($this->paginas_sem_login[$class][$method]) || ($this->CI instanceof SkipAuth) )
			return true;
		else{
			// Se não estiver logado, redireciona para o login mantendo a url desejada
			if(!$this->usuario){
				header("location:{$baseURL}principal/login/" . $url); exit;
			}
			else{
				return true;
			}
		}
		header("location:{$baseURL}principal/nao_autorizado");
	}
	
	function carrega_paginas_sem_login(){
		$this->paginas_sem_login['principal']['login'] = true;
		$this->paginas_sem_login['principal']['logar'] = true;
		$this->paginas_sem_login['principal']['logout'] = true;
		$this->paginas_sem_login['principal']['nao_autorizado'] = true;
		$this->paginas_sem_login['chamados']['fechar_automaticamente'] = true;
		
		$this->paginas_sem_login['usuario']['cadastro']  = true;
		$this->paginas_sem_login['usuario']['cadastrar'] = true;
		$this->paginas_sem_login['endereco'] = true;
	}

	function carrega_permissoes($id_usuario){
		$this->CI->load->model('usuario_model', 'usuario');
		$permissoes_tmp = $this->CI->usuario->get_permissoes($id_usuario);

		foreach($permissoes_tmp as $p)
			$this->permissoes[$p->escopo][$p->acao] = $p->permissao;
	}
	
	function carrega_perfis($id_usuario){
		$this->CI->load->model('usuario_model', 'usuario');
		$perfis_tmp = $this->CI->usuario->get_perfis($id_usuario);

		foreach($perfis_tmp as $p)
			$this->perfis[$p->descricao] = $p->id_perfil;
	}
}

?>
