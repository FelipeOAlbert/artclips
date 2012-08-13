<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorio extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		
		$this->load->model('Report_model', 'report');
		$this->load->model('Evento_model', 'evento');
		$this->load->model('Questionario_model', 'questionario');
		$this->load->model('Resposta_model', 'resposta');
		$this->load->model('Resposta_entrevistado_model', 'resposta_entrevistado');
	}
	
	
	public final function index()
	{
		$data = array();
		
		$data['users'] = $this->report->get_users();
		
		//id do evento que provavelmente vai vim por sessão
		//dados do evento
		$data['event'] = $this->report->getEventById(4);
		
		//dados dos questionarios desse evento
		$data['questionnaire'] = $this->report->getQuestionnaireByEventId(4);
		
		if($data['questionnaire']){
			foreach($data['questionnaire'] as $k => $v){
				
				//pegando as questoes do questionario
				$data['questionnaire'][$k]['question'] = $this->report->getQuestionByQuestionnaire($v['id_questionnaire']);
				
				//pegando as respostas das questoes
				foreach($data['questionnaire'][$k]['question'] as $qqk => $qqv){
					$data['questionnaire'][$k]['question'][$qqk]['answer'] = $this->report->getAnswerByQuestion($qqv['id_question']);
					
					foreach($data['questionnaire'][$k]['question'][$qqk]['answer'] as $qqvak => $qqvav){
						$data['questionnaire'][$k]['question'][$qqk]['answer'][$qqvak]['quant'] = $this->report->getAnswerRespondentByAnswer($qqvav['id_answer']);
					}
				}
			}
		}
		
		$this->template->show('relatorio/index', $data);
		
	}
	
	public final function filter()
	{
		if($_POST){
			
			$filters 	= array();
			//$bradcrumb 	= array();
			
			$filters['start_date'] 	= date_BR_to_EUA($_POST['start_date']);
			$filters['end_date'] 	= date_BR_to_EUA($_POST['end_date']);
			$filters['event_id'] 	= $_POST['event_id'];
			
			$data['users'] = $this->report->get_users($filters);
			$data['event'] = $this->report->getEventById($filters['event_id']);
			
			//Montando Bradcrumb
			$data['bradcrumb']['event'] = 'Evento Selecionado > '. $data['event'][0]['name'];
			
			if(isset($_POST['start_date'])){
				$data['bradcrumb']['start_date'] = 'Início Pedíodo > '.$_POST['start_date'];
			}
			
			if(isset($_POST['end_date'])){
				$data['bradcrumb']['end_date'] = 'Fim Pedíodo > '.$_POST['end_date'];
			}
			
			//printr($bradcrumb);
			
			//dados dos questionarios desse evento
			$data['questionnaire'] = $this->report->getQuestionnaireByEventId($filters['event_id']);
			
			if($data['questionnaire']){
				foreach($data['questionnaire'] as $k => $v){
					
					//pegando as questoes do questionario
					$data['questionnaire'][$k]['question'] = $this->report->getQuestionByQuestionnaire($v['id_questionnaire']);
					
					//pegando as respostas das questoes
					foreach($data['questionnaire'][$k]['question'] as $qqk => $qqv){
						$data['questionnaire'][$k]['question'][$qqk]['answer'] = $this->report->getAnswerByQuestion($qqv['id_question']);
						
						foreach($data['questionnaire'][$k]['question'][$qqk]['answer'] as $qqvak => $qqvav){
							$data['questionnaire'][$k]['question'][$qqk]['answer'][$qqvak]['quant'] = $this->report->getAnswerRespondentByAnswer($qqvav['id_answer'], $filters);
						}
					}
				}
			}
			
			$data['show_data'] = true;
			
			//printr($data);
			
			$this->template->show('relatorio/filter', $data);
		}else{
			$data = array();
			
			$data['event'] = $this->report->getAllEvent();
			$data['show_data'] = false;
			
			$this->template->show('relatorio/filter', $data);
		}
	}
	
	//private function resposta_unica()
	//{
	//	
	//}
	//
	//private function grafico_questao_unica( $questao , $pagina = 1 )
	//{
	//	$this->load->model('Evento_model', 'evento');
	//	$this->load->model('Questionario_model', 'questionario');
	//	$this->load->model('Resposta_model', 'resposta');
	//	$this->load->model('Resposta_entrevistado_model', 'resposta_entrevistado');
	//	
	//	$dados['id_questionario']	= (int) $questao->id_questionario;
	//	$dados['pagina']			= (int) $pagina;
	//	
	//	if ($questao->id_tipo == QUEST_QUANTITATIVA)
	//	{
	//		$dados['grafico'] = $this->resposta_entrevistado->pesa_e_conta_entrevistado_por_resposta_por_id_questao( $questao->id_questao );
	//	}
	//	else
	//	{
	//		$dados['grafico'] = $this->resposta_entrevistado->conta_entrevistado_por_resposta_por_id_questao( $questao->id_questao );
	//	}
	//	
	//	$dados['quantidade_questoes']		= $this->questao->conta_questao_por_id_questionario( $questao->id_questionario );
	//	$dados['quantidade_entrevistados']	= $this->resposta_entrevistado->conta_entrevistados_por_id_questionario( $questao->id_questionario );
	//	
	//	$dados['evento']		= $this->evento->get_by_id_questionario( $questao->id_questionario );
	//	$dados['questionario']	= $this->questionario->get_by_id_questionario( $questao->id_questionario );
	//	$dados['questionarios']	= $this->questionario->get_combo_possui_respostas();
	//	$dados['questao']		= $questao;
	//	$dados['respostas']		= $this->resposta->get_by_id_questao( $questao->id_questao );
	//	
	//	$this->template->show( 'relatorio/questionario', $dados );
	//}
	//
	//private function grafico_questao_multipla_escolha( $questao , $pagina = 1 )
	//{
	//	$this->grafico_questao_unica( $questao , $pagina );
	//}
	//
	//private function grafico_questao_quantitativa( $questao , $pagina = 1 )
	//{
	//	$this->grafico_questao_unica( $questao , $pagina );
	//}
	//
	//private function grafico_questao_dissertativa( $questao , $pagina = 1 )
	//{
	//	$this->load->model('Questionario_model', 'questionario');
	//	
	//	$dados = array();
	//	
	//	$dados['pagina']				= (int) $pagina;
	//	$dados['questao']				= $questao;
	//	$dados['questionarios']			= $this->questionario->get_combo_possui_respostas();
	//	$dados['quantidade_questoes']	= $this->questao->conta_questao_por_id_questionario( $questao->id_questionario );
	//	$this->template->show( 'relatorio/questionario', $dados );
	//}
	//
	//private function selecionar_questionario()
	//{
	//	$this->load->model('Questionario_model', 'questionario');
	//
	//	$dados['questionarios'] = $this->questionario->get_combo_possui_respostas('(Selecione...)');
	//
	//	$this->template->show( 'relatorio/questionario', $dados );
	//}
	//
	//function questionario( $id_questionario = 0, $pagina = 1 )
	//{
	//	$id_questionario = (int) $id_questionario;
	//	$pagina = (int) $pagina;
	//	
	//	if ( empty( $id_questionario ) || empty( $pagina ) )
	//	{
	//		$this->selecionar_questionario();
	//	}
	//	else
	//	{
	//		$this->load->model('Questao_model', 'questao');
	//	
	//		$questao = array_shift( $this->questao->get_by_id_questionario( $id_questionario, 1, $pagina ) );
	//		
	//		if ( ! empty( $questao ) )
	//		{
	//			if ( $questao->id_tipo == QUEST_RESPOSTA_UNICA )
	//			{
	//				$this->grafico_questao_unica( $questao, $pagina );
	//			}
	//			else
	//			if ( $questao->id_tipo == QUEST_MULTIPLA_ESCOLHA )
	//			{
	//				$this->grafico_questao_multipla_escolha( $questao, $pagina );
	//			}
	//			else
	//			if ( $questao->id_tipo == QUEST_DISSERTATIVA )
	//			{
	//				$this->grafico_questao_dissertativa( $questao, $pagina );
	//			}
	//			else
	//			if ( $questao->id_tipo == QUEST_QUANTITATIVA )
	//			{
	//				$this->grafico_questao_quantitativa( $questao, $pagina );
	//			}
	//		}
	//	}
	//}
	/*
	function questao( $id_questao = 0 )
	{
		$this->load->model('Questao_model', 'questao');
		
		$this->template->show('questionario/index', array('id_evento' => $id_evento));
	}
	*/
}
?>
