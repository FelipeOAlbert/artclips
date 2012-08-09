<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questionario extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Questionario_model', 'questionario');
	}
	
	function index($id_evento = 0)
	{
		$this->template->show('questionario/index', array('id_evento' => $id_evento));
	}
	
	function lista($id_evento = 0)
	{
		$questionarios = $this->questionario->get_by_id_evento( (int) $id_evento );
		$this->template->show('questionario/lista', array('questionarios' => $questionarios, 'id_evento' => $id_evento));
	}
	
	function edicao($id_questionario = 0)
	{
		$questionario = $this->questionario->get_by_id_questionario( (int) $id_questionario);
		
		if ( !empty($questionario) )
			$this->template->show('questionario/editar', array('questionario' => $questionario, 'id_questionario' => (int) $id_questionario));
	}
	
	function editar()
	{
		$retorno = array();
		$retorno['ok'] = FALSE;

		$post = $this->input->post();
		
		if ($this->questionario->update($post)) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Evento editado com sucesso!';
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel editar o evento!';
		}
		
		echo json_encode($retorno);
	}
	
	function novo($id_evento = 0)
	{
		$this->template->show('questionario/novo', array('id_evento' => $id_evento));
	}
	
	function adicionar()
	{
		$retorno = array();
		$retorno['ok'] = false;

		$post = $this->input->post();
		
		if ($idQuestionario = $this->questionario->insert($post)) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Question&aacute;rio criado com sucesso!';
			header("location:" . site_url('questao/index/'.$idQuestionario));
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel criar o question&aacute.rio!';
		}
		
		echo json_encode($retorno);
	}
	
	function excluir($id_questionario = 0)
	{
		$retorno = array();
		$retorno['ok'] = FALSE;
		
		if ($this->questionario->delete($id_questionario)) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Question&aacute;rio apagado com sucesso!';
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel apagar o question&aacute;rio!';
		}
		
		echo json_encode($retorno);
	}
	
	function duplicar($id_questionario_origem = 0, $id_evento_destino = 0)
	{
		$retorno = array();
		$retorno['ok'] = FALSE;
		
		$result = $this->questionario->duplicar($id_questionario_origem, $id_evento_destino);
		if ( $result === TRUE ) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Question&aacute;rio duplicado com sucesso!';
		} else {
			$retorno['msg'] = $result;
		}
		
		echo json_encode($retorno);
	}
}
?>
