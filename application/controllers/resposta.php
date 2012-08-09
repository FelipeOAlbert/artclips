<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resposta extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Resposta_model', 'resposta');
		$this->load->model('Questao_model', 'questao');
		
	}
	
	function index($id_questao = 0)
	{
		$this->questao->set("show_total_resp",true);//Ativa exibir numero de respostas
		
		$this->load->model('Questao_model', 'questao');
		$questionario_bloqueado = $this->questao->verifica_bloqueio($id_questao);
		$tipo_questao = $this->questao->get_id_tipo_by_id_questao($id_questao);
		
		/*Questão*/
		$questao = $this->questao->get_by_id_questao($id_questao);
		$questao->img_questao = unserialize($questao->img_questao);
		
		/*Mas tem respostas já?*/
		if(isset($questao->total_resp) && intval($questao->total_resp)>0)
			$respostas = $this->resposta->get_by_id_questao($id_questao);
		else
			$respostas = false;

		
		$this->template->show('resposta/novo', 
			array(	'id_questao' => $id_questao, 
					'questionario_bloqueado' => $questionario_bloqueado, 
					'tipo_questao' => $tipo_questao,
					'questao' => $questao->descricao,
					'tipo' => $questao->id_tipo,
					'bifurca' => $questao->bifurca,
					'img' => $questao->img_questao,
					'total_resp' => $questao->total_resp,
				'respostas' => $respostas
			));
	}
	
	function lista($id_questao = 0)
	{
		$respostas = $this->resposta->get_by_id_questao( $id_questao );
		$questionario_bloqueado = TRUE;
		$tipo_questao = 0;
		
		if ( count($respostas) > 0 )
		{
			$questionario_bloqueado = (int) $respostas[0]->bloqueado;
			
			$this->load->model('Questao_model', 'questao');
			$tipo_questao = $this->questao->get_id_tipo_by_id_questao($id_questao);
		}
		$this->template->show('resposta/lista', array('respostas' => $respostas, 'id_questao' => $id_questao, 'questionario_bloqueado' => $questionario_bloqueado, 'tipo_questao' => $tipo_questao));
	}
	
	function edicao($id_resposta = 0)
	{
		$resposta = $this->resposta->get_by_id_resposta( (int) $id_resposta);
		
		if ( !empty($resposta) )
		{
			$this->load->model('Questao_model', 'questao');
			$tipo_questao = $this->questao->get_id_tipo_by_id_questao( $resposta->id_questao );
			
			$this->template->show('resposta/editar', array('resposta' => $resposta, 'id_resposta' => (int) $id_resposta, 'tipo_questao' => $tipo_questao));
		}
	}
	
	function editar()
	{
		$retorno = array();
		$retorno['ok'] = FALSE;

		$post = $this->input->post();
		
		if ($this->resposta->update($post)) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Evento criado com sucesso!';
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel criar o evento!';
		}
		
		echo json_encode($retorno);
	}
	
	function novo($id_questao = 0)
	{
		$this->template->show('resposta/novo', array('id_questao' => $id_questao));
	}
	
	function adicionar()
	{
		$retorno = array();
		$retorno['ok'] = false;
		
		$post = $this->input->post();

		$idResp = $this->resposta->insert($post);
		
		if (is_array($idResp) && count($idResp)>0){
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Resposta criada com sucesso!';
			
			$parentes = $this->resposta->getPais($idResp);
			$parentes = (isset($parentes[0]) && is_array($parentes[0]) ? $parentes[0] : false);
			if(isset($parentes['questionnarie'])){
				header("Location: ".site_url("questao/index/".$parentes['questionnarie']));
			}else{
				$retorno['msg'] = 'Resposta inserida com sucesso mas impossível de recuperar questionario';
			}
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel criar a resposta!';
		}
		
		echo json_encode($retorno);
	}
	
	function excluir($id_resposta = 0)
	{
		$retorno = array();
		$retorno['ok'] = FALSE;
		
		if ($this->resposta->delete($id_resposta)) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Resposta apagado com sucesso!';
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel apagar a resposta!';
		}
		
		echo json_encode($retorno);
	}
	
	function ordenar()
	{
		$retorno = array();
		$retorno['ok'] = FALSE;
		
		if ( $this->resposta->ordenar($this->input->post('ordem')) ) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Resposta movida com sucesso!';
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel mover a resposta!';
		}
		
		echo json_encode($retorno);
	}
}
?>
