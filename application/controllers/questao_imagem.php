<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questao_imagem extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Questao_imagem_model', 'questao_imagem');
	}

	function index($id_questao = 0)
	{
		$this->template->show('questao_imagem/index', array('id_questao' => $id_questao));
	}
	
	function lista($id_questao = 0)
	{
		$imagens = $this->questao_imagem->get_by_id_questao( (int) $id_questao );
		
		$this->template->show('questao_imagem/lista', array('imagens' => $imagens, 'id_questao' => (int) $id_questao));
	}
	
	function novo($id_questao = 0)
	{
		$this->template->show('questao_imagem/novo', array('id_questao' => (int) $id_questao));
	}
	
	function carregar($id_questao = 0)
	{
		$retorno = array();
		$retorno['ok'] = FALSE;
		
		$result = $this->do_upload($id_questao);
		if ( $result === TRUE ) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Arquivo carregado com sucesso!';
		} else {
			if ( is_string($result) )
				$retorno['msg'] = $result;
			else
				$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel carregadar o arquivo!';
		}
		
		echo json_encode($retorno);
	}

	function do_upload($id_questao = 0)
	{
		$config['upload_path']	= './uploads/';
		$config['allowed_types']= 'gif|jpg|jpeg|png';
		$config['max_size']		= '2048';
		$config['max_width']	= '1024';
		$config['max_height']	= '768';
		$config['encrypt_name']	= TRUE;
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('questao_imagem')) {
			return $this->upload->display_errors('', '');
		}	else {
			$dados = $this->upload->data();
			$dados['id_questao'] = $id_questao;
			
			$result = $this->questao_imagem->insert( $dados );
			if ( $result === TRUE )
				return TRUE;
			
			return $result;
		}
	}
	
	function excluir($id_imagem_questao)
	{
		$retorno = array();
		$retorno['ok'] = FALSE;
		
		if ($this->questao_imagem->delete($id_imagem_questao)) {
			$retorno['ok'] = TRUE;
			$retorno['msg'] = 'Imagem apagada com sucesso!';
		} else {
			$retorno['msg'] = 'N&atilde;o foi poss&iacute;vel apagar a imagem!';
		}
		
		echo json_encode($retorno);
	}
}
?>
