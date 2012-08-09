<?php

class Questao_imagem_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function get( $options = array() )
	{
		if ( !empty($options['id_questao']) )
			$this->db->where('iq.id_question', (int) $options['id_questao']);
		
		if ( isset($options['ativo']) )
			$this->db->where('iq.active', (bool) $options['active']);
		else
			$this->db->where('iq.active', TRUE);
		
		return $this->db->select('id_image_question AS id_imagem_questao, id_question AS id_questao, name AS nome, extension AS extensao')
						->select('size AS tamanho, width AS largura, height AS altura, active AS ativo')
						->order_by('iq.id_image_question DESC')
						->from(DB_DEFAULT . '.image_question iq')
						->get()->result();
	}
	
	function get_by_id_questao($id_questao)
	{
		return $this->get( array('id_questao' => $id_questao) );
	}
	
	function delete($id_imagem_questao)
	{
		$r = $this->db->set('active', 0)
					  ->where('id_image_question', (int) $id_imagem_questao)
					  ->update('image_question');
		
		return (!empty($r)) ? TRUE : FALSE;
	}
	
	function insert($dados)
	{
		$this->db->trans_begin();
		
		try {
			if ( empty($dados) )
				throw new Exception('Houve um erro na passagem de parametros.');
			
			if ( empty($dados['is_image']) )
				throw new Exception('O arquivo n&atilde;o &eacute; uma imagem v&aacute;lida.');
			
			if ( empty($dados['id_questao']) )
				throw new Exception('Nenhuma quest&atilde;o selecionada.');
			
			$dados['id_questao'] = (int) $dados['id_questao'];
			
			if ( empty($dados['id_questao']) )
				throw new Exception('Nenhuma quest&atilde;o selecionada.');
			
			$res = $this->db->set('id_question', $dados['id_questao'])
							->set('name', $dados['raw_name'])
							->set('extension', str_replace('.', '', $dados['file_ext']) )
							->set('size', $dados['file_size'] * 1024)
							->set('width', $dados['image_width'])
							->set('height', $dados['image_height'])
							->insert('image_question');
			
			if ( empty($res) )
				throw new Exception('Ocorreu um erro ao gravar os dados do arquivo.');
			
			if ($this->db->trans_status() === FALSE)
				throw new Exception('Ocorreu um erro. Por favor, tente novamente.');
			
		} catch ( Exception $e ) {
			$this->db->trans_rollback();
			return $e->getMessage();
		}
		
		$this->db->trans_commit();
		return TRUE;
	}
}
