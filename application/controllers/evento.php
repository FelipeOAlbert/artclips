<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evento extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Evento_model', 'evento');
	}
	
	function index()
	{
		$this->template->show('evento/index');
	}
	
	function lista()
	{
		$eventos = $this->evento->get_by_id_usuario( (int) $this->phpsession->get('usuario')->id_usuario );
		
		$this->template->show('evento/lista', array('eventos' => $eventos));
	}
	
	function edicao($id_evento = 0)
	{
		$evento = $this->evento->get_by_id_evento( (int) $id_evento);
		
		if ( !empty($evento) ) {
			$endereco = $this->evento->get_endereco_by_id_evento( (int) $id_evento );
			
			$this->template->show('evento/editar', array('evento' => $evento, 'id_evento' => (int) $id_evento, 'endereco' => $endereco));
		}
	}
	
	function editar($id_evento = 0)
	{
		$retorno = array();
		$retorno['ok'] = FALSE;

		$post = $this->input->post();
		
		$result = $this->evento->update($post);
		if ( !empty($result) && is_integer($result) ) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Evento editado com sucesso!';
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel editar o evento!';
			if ( is_string($result) )
				$retorno['msg'] .= '<br />' . $result;
		}
		
		echo json_encode($retorno);
	}
	
	function novo($id_evento = 0)
	{
		$this->template->show('evento/novo', array('id_evento' => $id_evento));
	}
	
	function adicionar()
	{

		$retorno = array();
		$retorno['ok'] = FALSE;

		$post = $this->input->post();
	
		$result = $this->evento->insert($post);
		
		if ( !empty($result) && is_integer($result) ) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Evento criado com sucesso!';
			header("location:" . site_url('questionario/index/'.$result));
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel criar o evento!';
			if ( is_string($result) )
				$retorno['msg'] .= '<br />' . $result;
		}
		
		echo json_encode($retorno);
	}
	
	function excluir($id_evento = 0)
	{
		$retorno = array();
		$retorno['ok'] = FALSE;
		
		if ($this->evento->delete($id_evento)) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Evento editado com sucesso!';
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel editar o evento!';
		}
		
		echo json_encode($retorno);
	}
	
	function selecionar($id_questionario = 0)
	{
		$id_usuario = 0;
		$usuario = $this->phpsession->get('usuario');
		if ( empty($usuario) )
			return FALSE;
		
		$id_usuario = $usuario->id_usuario;
		
		$this->load->model('Questionario_model', 'questionario');
		$id_evento = $this->questionario->get_id_evento_by_id_questionario($id_questionario);
		if ( empty($id_evento) )
			return FALSE;
		
		$eventos = $this->evento->get_combo( array('id_usuario' => $id_usuario) );
		
		$dados = array( 'eventos' => $eventos, 'default_evento' => $id_evento, 'id_questionario' => (int) $id_questionario );
		echo $this->load->view('evento/selecionar_evento', $dados, TRUE);
	}
}
?>
