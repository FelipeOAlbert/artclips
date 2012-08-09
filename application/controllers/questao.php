<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questao extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Questao_model', 'questao');
	}
	
	function index($id_questionario = 0)
	{
		$this->load->model('Questionario_model', 'questionario');
		$questionario_bloqueado = $this->questionario->verifica_bloqueio($id_questionario);
		
		$this->load->model('tipo_questao_model', 'tipo_questao');
		$tipos = $this->tipo_questao->get_combo();
		
		$this->load->model('categoria_questao_model', 'categoria_questao');
		$categorias = $this->categoria_questao->get_combo();
		
		$todas_respostas = $this->questao->all_answers($id_questionario);
		
		$this->template->show('questao/index', array('id_questionario' => $id_questionario, 'questionario_bloqueado' => $questionario_bloqueado, 'tipos' => $tipos, 'categorias'=>$categorias, "respostas"=>$todas_respostas));
	}
	
	function lista($id_questionario = 0)
	{
		$questoes  = $this->questao->get_by_id_questionario( $id_questionario );
		$questionario_bloqueado = TRUE;
		
		if ( count($questoes) > 0 )
			$questionario_bloqueado = (int) $questoes[0]->bloqueado;
		
		$todas_respostas = $this->questao->all_answers($id_questionario);
		
		$visao = "";
		
		 /*() (Dennis >likes [d,c] >hates [j]) ||
 			*(d:Drinks) (c:Comics) (j:Jogging)
			*/
		
		for($x=0;$x<count($questoes);$x++){
			$now = $questoes[$x];
			$next = (isset($questoes[($x+1)]) ? $questoes[($x+1)] : false);

			if($next!=false){
				if(intval($now->num_questions_transition)>0)
					$visao .= "(".$now->id_questao.":{{<b>Transicao</b>}} > [".$next->id_questao."])||";
				else
					$visao .= "(".$now->id_questao.":".$now->descricao." > [".$next->id_questao."])||";

			}else{
				if(intval($now->num_questions_transition)>0)
					$visao .= "(".$now->id_questao.":{{<b>Transicao</b>}} > [novaQuestao]) ||(novaQuestao: {{<a href='#' id='novaQuestao' onclick='javascript: novaQuestao(event);'>NOVA QUESTAO</a>}})";
				else
					$visao .= "(".$now->id_questao.":".$now->descricao." > [novaQuestao])||(novaQuestao: {{<a href='#' id='novaQuestao' onclick='javascript: novaQuestao(event);'>NOVA QUESTAO</a>}})";
			}

		}

		$this->template->show('visao/template', array('visao'=>$visao, 'respostas'=>$todas_respostas,'questoes' => $questoes, 'id_questionario' => $id_questionario, 'questionario_bloqueado' => $questionario_bloqueado));


	}
	
	function edicao($id_questao = 0)
	{
		$questao = $this->questao->get_by_id_questao( (int) $id_questao);
		
		if ( empty($questao) )
			return FALSE;
		
		$this->load->model('tipo_questao_model', 'tipo_questao');
		$tipos = $this->tipo_questao->get_combo();
		
		$this->template->show('questao/editar', array('questao' => $questao, 'id_questao' => (int) $id_questao, 'tipos' => $tipos));
	}
	
	function editar()
	{
		$retorno = array();
		$retorno['ok'] = FALSE;

		$post = $this->input->post();
		
		if ($this->questao->update($post)) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Quest&atilde;o editada com sucesso!';
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel editar a quest&atilde;o!';
		}
		
		echo json_encode($retorno);
	}
	
	function novo($id_questionario = 0)
	{
		$this->load->model('tipo_questao_model', 'tipo_questao');
		$tipos = $this->tipo_questao->get_combo();
		
		$this->template->show('questao/novo', array('id_questionario' => $id_questionario, 'tipos' => $tipos));
	}
	
	function do_upload($nome_campo)
	{
		$config['upload_path']	= FCPATH.'uploads';
		$config['allowed_types']= 'gif|jpg|jpeg|png';
		$config['max_size']		= '2048';
		$config['max_width']	= '1500';
		$config['max_height']	= '1500';
		$config['encrypt_name']	= TRUE;
		
		$this->load->library('upload', $config);

		if(!$this->upload->do_upload($nome_campo)){
			return $this->upload->display_errors('', '');
		}else{
			$dados = $this->upload->data();
			return $dados;
		}
	}
	
	function adicionar()
	{
		$retorno = array();
		$retorno['ok'] = false;

		$post = $this->input->post();
		$post['img_questao'] = "";

		if(isset($_FILES['img_questao']['name']) && $_FILES['img_questao']['error']=="0"){
			$enviado = $this->do_upload('img_questao');
			if(is_string($enviado)){
				echo $enviado;
				exit;
			}else{
				$post['img_questao'] = serialize($enviado);
			}
		}

		if ($idQuestao = $this->questao->insert($post)) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Quest&atilde;o criada com sucesso!';
			
			if(isset($post['is_transition']) && intval($post['is_transition'])>=1){
				header("location:" . site_url('questao/index/'.$post['id_questionnaire']));
			}else{
				header("location:" . site_url('resposta/index/'.$idQuestao));
			}
		
			
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel criar a quest&atilde;o!';
		}
		
		echo json_encode($retorno);
	}
	
	function mudar_posicao($id_questao = 0, $posicao = 0)
	{
		$retorno = array();
		$retorno['ok'] = false;
		
		if ( $this->questao->mudar_posicao($id_questao, $posicao) ) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Quest&atilde;o criada com sucesso!';
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel mudar a posi&ccedil;&atilde;o!';
		}
		
		echo json_encode($retorno);
	}
	
	function excluir($id_questao = 0)
	{
		$retorno = array();
		$retorno['ok'] = FALSE;
		
		if ($this->questao->delete($id_questao)) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Quest&atilde;o apagada com sucesso!';
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel apagar a quest&atilde;o!';
		}
		
		echo json_encode($retorno);
	}
	
	function ordenar()
	{
		$retorno = array();
		$retorno['ok'] = FALSE;
		
		if ( $this->questao->ordenar($this->input->post('ordem')) ) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Quest&atilde;o movida com sucesso!';
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel mover a quest&atilde;o!';
		}
		
		echo json_encode($retorno);
	}
}
?>
