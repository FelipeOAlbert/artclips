<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json extends CI_Controller implements SkipAuth {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Evento_model', 'evento');
		$this->load->model('Resposta_model', 'resposta');
		$this->load->model('Questionario_model', 'questionario');
		$this->load->model('Questao_model', 'questao');
		$this->load->library('zip');
	}
	
	

	function index($id_evento, $downZip = false)
	{
		/*Pega todos os eventos*/
		$id_evento = intval($id_evento);
		$geral = array();
		
		if(isset($id_evento) && intval($id_evento)>0){
			$eventos[] = $this->evento->get_by_id_evento( $id_evento );
			//pega user
			if(isset($eventos[0]->id_usuario) && intval($eventos[0]->id_usuario)>0)
				$this->phpsession->save("usuario",(object)array("id_usuario"=>3));
			else
				die();
		}else{
			die();
		}
		
		
		$evento =0;
		
		foreach($eventos as $ev){
			if($ev->id_evento>0){
				$geral['eventos'][$evento]['id'] = $ev->id_evento;
				$geral['eventos'][$evento]['nome'] = $ev->nome;
				$geral['eventos'][$evento]['data_criacao'] = $ev->data_criacao;
				$geral['eventos'][$evento]['hora_criacao'] = $ev->hora_criacao;

					/*Processa questionarios*/
					$geral['eventos'][$evento]['questionarios'] = array();
					$questionarios = $this->questionario->get_by_id_evento( (int) $ev->id_evento );
					$questionario=0;
					
					if($questionarios==false){
						$geral['eventos'][$evento]['questionarios'] = "";
						continue;	
					}
					foreach($questionarios as $qu){
						$geral['eventos'][$evento]['questionarios'][$questionario]['id'] = $qu->id_questionario;
						$geral['eventos'][$evento]['questionarios'][$questionario]['nome'] = $qu->nome;
						$geral['eventos'][$evento]['questionarios'][$questionario]['data_criacao'] = $qu->data_criacao;
						$geral['eventos'][$evento]['questionarios'][$questionario]['hora_criacao'] = $qu->hora_criacao;

							/*Processa Perguntas*/
							$geral['eventos'][$evento]['questionarios'][$questionario]['questoes'] = array();
							$questoes  = $this->questao->get_by_id_questionario( $qu->id_questionario );
							
							$questao = 0;
							foreach($questoes as $qt){
								$geral['eventos'][$evento]['questionarios'][$questionario]['questoes'][$questao]['id'] = $qt->id_questao;
								$geral['eventos'][$evento]['questionarios'][$questionario]['questoes'][$questao]['id_type'] = $qt->id_tipo;
								$geral['eventos'][$evento]['questionarios'][$questionario]['questoes'][$questao]['category'] = $qt->category;
								$geral['eventos'][$evento]['questionarios'][$questionario]['questoes'][$questao]['multiple answer'] = (intval($qt->id_tipo)==1?"1":"0");
								$geral['eventos'][$evento]['questionarios'][$questionario]['questoes'][$questao]['description'] = $qt->descricao;
								$geral['eventos'][$evento]['questionarios'][$questionario]['questoes'][$questao]['category'] = $qt->category;
								$imgPass = "";
								if(trim($qt->img_questao)!=""){
									$img = unserialize($qt->img_questao);
									if(isset($img['file_name'])){
										$imgPass = $img['file_name'];
										
										if($downZip == true)
										$this->zip->read_file($img['full_path']);
									}
								}
								$geral['eventos'][$evento]['questionarios'][$questionario]['questoes'][$questao]['img_questao'] = $imgPass;
								$geral['eventos'][$evento]['questionarios'][$questionario]['questoes'][$questao]['transition_content'] = $qt->transition;
								$geral['eventos'][$evento]['questionarios'][$questionario]['questoes'][$questao]['num_questions_transition'] = $qt->num_questions_transition;
	
									$arrTmp = $geral['eventos'][$evento]['questionarios'][$questionario]['questoes'][$questao]['answers'] = array();
									$answers = $this->resposta->get_by_id_questao( $qt->id_questao );
									$answer = 0;
									foreach($answers as $an){
										$arrTmp[$answer]['id'] = $an->id_resposta;
										$arrTmp[$answer]['description'] = $an->descricao;
										$arrTmp[$answer]['img_answer'] = "";//TODO: terminar
										
										$answer++;
									}
									$geral['eventos'][$evento]['questionarios'][$questionario]['questoes'][$questao]['answers'] = $arrTmp;

								$questao++;	
							}
							
						$questionario++;
					}

			}
			
			$evento++;
		}
		
		
		if($downZip == true){
			$this->zip->download(FCPATH.'uploads/eventosZip/photos_evento_'.$ev->id_evento.'.zip');
			$this->zip->download('photos_evento_'.$ev->id_evento.'.zip');
			die();
		}
		
		echo json_encode($geral);
	}

	function autenticar(){
		$this->load->model('Ipad_model', 'ipad');
		
		$retorno['response'] = FALSE;

		$post = $this->input->post();

		$event = $this->ipad->authIpad($post);
		
		if(count($event)>=1 && (isset($event[0]->id_evento) && intval($event[0]->id_evento)>0) ){
			/*Salva udId do evento*/
			$post['id_evento'] = $event[0]->id_evento;
			$post['id_ipad'] = $event[0]->id_ipad;
			
			if($this->ipad->checkAuthIpadNew($post)){
				$retorno['msg'] = "Já existe um ipad para este evento";
			}else{
				if($this->ipad->saveAuthIpadNew($post)){
					$retorno['response'] = TRUE;
					$retorno['active'] = site_url("json/index/".$event[0]->id_evento);
					$retorno['msg'] = "logado com sucesso";
				}else{
					$retorno['msg'] = "Erro ao logar";
				}
			}
			
		}else{
			$retorno['msg'] = "Login ou senha inválidos";
		}
		
		echo json_encode($retorno);
	}
	
}
?>
