<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Endereco_model', 'endereco');
		$this->load->model('Usuario_model', 'usuario');
	}
	
	function index($id_questionario = 0)
	{
		$this->template->show('questao/index', array('id_questionario' => $id_questionario));
	}
	
	function edicao_senha()
	{
		$this->template->show('usuario/editar_senha');
	}
	
	function editar_senha()
	{
		$retorno = array();
		$retorno['ok'] = FALSE;

		$result = $this->usuario->editar_senha( $this->input->post('senha_atual'), $this->input->post('senha_nova') );
		
		if ( $result === TRUE ) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Senha alterada com sucesso!';
			
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel alterar a senha!';
			if ( is_string($result) )
				$retorno['msg'] .= '<br />' . $result;
		}

		echo json_encode($retorno);
	}
	
	function edicao_email()
	{
		$this->template->show('usuario/editar_email');
	}
	
	function editar_email()
	{
		$retorno = array();
		$retorno['ok'] = FALSE;

		$result = $this->usuario->editar_email( $this->input->post('email_atual'), $this->input->post('email_novo') );
		
		if ( $result === TRUE ) {
			$retorno['ok']  = TRUE;
			$retorno['msg'] = 'E-mail alterado com sucesso!';
			
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel alterar a e-mail!';
			if ( is_string($result) )
				$retorno['msg'] .= '<br />' . $result;
		}

		echo json_encode($retorno);
	}
	
	function cadastro()
	{
		$dados = array(
			'cadastro' => NULL,
			'endereco' => NULL,
			'telefone' => NULL,
		);
		
		$usuario = $this->phpsession->get('usuario');
		
		// Carrega os dados para edição
		if ( !empty($usuario->id_usuario) ) {
			$dados['usuario']  = $this->usuario->get_by_id_usuario( $usuario->id_usuario );
			$dados['endereco'] = $this->usuario->get_endereco_by_id_usuario( $usuario->id_usuario );
			$dados['telefone'] = $this->usuario->get_telefone_by_id_usuario( $usuario->id_usuario );
			$dados['detalhes'] = $this->usuario->get_detalhes_by_id_usuario( $usuario->id_usuario );
		}
		
		$this->template->show('usuario/cadastro', $dados);
	}
	
	function cadastrar()
	{
		$retorno = array();
		$retorno['ok'] = FALSE;

		$post = $this->input->post();
	
		$result = $this->usuario->insert($post);
		if ( !empty($result) && is_integer($result) ) {
			$retorno['ok'] = TRUE;
			
			if ( $this->phpsession->get('usuario') ){
				$retorno['msg'] = 'Conta editada com sucesso!';
			}else{
				$_SESSION['forceLogin'] = md5($post['senha']);
				header("location:" . site_url('principal/logar/'.$result));
			}
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel criar a conta!';
			if ( is_string($result) )
				$retorno['msg'] .= '<br />' . $result;
		}

		echo json_encode($retorno);
	}
}
?>
