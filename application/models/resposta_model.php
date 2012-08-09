<?php

class Resposta_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function getPais( $ids )
	{
		if(is_array($ids))
			foreach($ids as $id)
				if(intval($id)>0) //pega o ultimo
					continue;
		else
			$id = $ids;	
		
		if(!isset($id) || intval($id)<=0)
			return false;
		
		$this->db->select('q.id_question AS questao, qn.id_questionnaire as questionnarie, qn.id_event as event');
		$this->db->where('a.id_answer', (int)$id);
		$query = $this->db->from(DB_DEFAULT . '.answer a')
					->join(DB_DEFAULT . '.question q', 'a.id_question = q.id_question')
					->join(DB_DEFAULT . '.questionnaire qn', 'q.id_questionnaire = qn.id_questionnaire')
					->get()->result_array();
					
		return $query;
	}
	
	function get( $options = array() )
	{
		if ( !empty($options['id_questao']) )
			$this->db->where('a.id_question', (int) $options['id_questao']);
		
		if ( !empty($options['id_resposta']) )
			$this->db->where('a.id_answer', (int) $options['id_resposta']);
		
		if ( isset($options['ativo']) )
			$this->db->where('a.active', (bool) $options['active']);
		else
			$this->db->where('a.active', TRUE);
		
		$this->db->from(DB_DEFAULT . '.answer a');
		
		if ( !empty($options['count']) )
			$query = (int) array_shift($this->db->select('(COUNT(a.id_answer)) AS quantidade', FALSE)->get()->result())->quantidade;
		else
			$query = $this->db->select('a.id_answer AS id_resposta, a.id_question AS id_questao, a.description AS descricao, a.position AS posicao, a.weight AS peso')
							  ->select('qnn.available AS bloqueado')
							  ->join(DB_DEFAULT . '.question q', 'q.id_question = a.id_question')
							  ->join(DB_DEFAULT . '.questionnaire qnn', 'qnn.id_questionnaire = q.id_questionnaire')
							  ->order_by('a.position ASC')
							  ->get()->result();
			
		return $query;
	}
	
	function get_by_id_questao( $id_questao )
	{
		return $this->get( array('id_questao' => (int) $id_questao) );
	}
	
	function conta_respostas_by_id_questao( $id_questao )
	{
		return $this->get(array('id_questao' => (int) $id_questao, 'count' => TRUE));
	}
	
	function get_by_id_resposta($id_resposta)
	{
		$id_resposta = (int) $id_resposta;
		if ( empty($id_resposta) )
			return array();
		
		return array_shift( $this->get( array('id_resposta' => $id_resposta) ) );
	}
	
	function get_maior_posicao( $options = array() )
	{
		if ( !empty($options['id_questao']) )
			$this->db->where('a.id_question', (int) $options['id_questao']);
			
		if ( !empty($options['id_resposta']) )
			$this->db->where('a.id_answer', (int) $options['id_resposta']);
		
		return (int) array_shift(
			$this->db->select('(MAX(a.position)) AS maior_posicao')
					 ->from(DB_DEFAULT . '.answer a')
					 ->get()->result()
		)->maior_posicao;
	}
	
	function insert($dados)
	{
	
		
		$position = $this->get_maior_posicao( array('id_questao' => (int) $dados['id_question']) );
		$id_respostas = array();		
		$contador = 0; //Conta bifurcadores

		if($dados['tipo_resp']=="texto"){
			foreach($dados['resposta_texto'] as $texto){
				if(trim($texto)==""){
					$contador++;
					continue;	
				}
				
				$this->db->set('id_question', (int) $dados['id_question']);
				$this->db->set('description', (string)$texto);
				$this->db->set('position', ( $position ++ ));
				
				if(isset($dados['caminho_resp_'.$contador]) && (int)$dados['caminho_resp_'.$contador]>0)
					$this->db->set('caminho', (int)$dados['caminho_resp_'.$contador]);
				
				if($this->db->insert(DB_DEFAULT . '.answer'))
					$id_respostas[] = $this->db->insert_id();
					
				$contador ++;
			}
		}
		return $id_respostas;
	}
	
	function delete($id_resposta)
	{
		$r = $this->db->set('active', 0)
					  ->where('id_answer', (int) $id_resposta)
					  ->update('answer');
		
		return (!empty($r)) ? TRUE : FALSE;
	}
	
	function update($dados)
	{
		$r = $this->db->where('id_answer', (int) $dados['id_answer'])
					  ->update('answer', $dados);
		
		return (!empty($r)) ? TRUE : FALSE;
	}
	
	function ordenar($ordem)
	{
		if ( isset($ordem[0]) )
			unset($ordem[0]);
		
		$this->db->trans_begin();
		
		try {
			foreach ($ordem as $posicao => $id_resposta)
				if (!$this->db->set('position', (int) $posicao)
							  ->where('id_answer', (int) $id_resposta)
							  ->update(DB_DEFAULT . '.answer') )
					throw new Exception('Ocorreu um erro. Por favor, tente novamente.');
					
			if ($this->db->trans_status() === FALSE)
				throw new Exception('Ocorreu um erro. Por favor, tente novamente.');
				
			
		} catch ( Exception $e ) {
			$this->db->trans_rollback();
			return FALSE;
			//return $e->getMessage();
		}
		
		$this->db->trans_commit();
		return TRUE;
	}
}
