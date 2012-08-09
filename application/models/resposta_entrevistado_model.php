<?php

class Resposta_entrevistado_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function get( $options = array() )
	{
		if ( ! empty($options['id_usuario']) )
		{
			$this->db->where('e.id_user', (int) $options['id_usuario']);
		}
		else
		{
			$this->db->where( 'e.id_user', (int) $this->phpsession->get( 'usuario' )->id_usuario );
		}
		
		if ( ! empty($options['id_evento']) )
		{
			$this->db->where('e.id_event', (int) $options['id_evento']);
		}
		
		if ( ! empty($options['id_questionario']) )
		{
			$this->db->where('qnn.id_questionnaire', (int) $options['id_questionario']);
		}
		
		if ( ! empty($options['id_questao']) )
		{
			$this->db->where('q.id_question', (int) $options['id_questao']);
		}
		
		if ( ! empty($options['id_resposta']) )
		{
			$this->db->where('a.id_answer', (int) $options['id_resposta']);
		}
		
		if ( ! empty($options['pesa_e_conta_entrevistado_por_resposta']) )
		{
			$this->db->select( 'SUM( COALESCE(a.weight, 0)) AS peso', FALSE );
			
			$options['conta_entrevistado_por_resposta'] = TRUE;
		}
		
		if ( ! empty($options['conta_entrevistado_por_resposta']) )
		{
			$this->db->select( 'a.position AS posicao' )
					 ->group_by( 'ar.id_answer' );
			
			$options['conta_entrevistado'] = TRUE;
		}
		
		if ( ! empty($options['conta_entrevistado']) )
		{
			$this->db->select( 'COUNT(DISTINCT ar.id_respondent ) AS quantidade' )
					 ->order_by( 'a.position' );
		}
		
		return $this->db->from( DB_DEFAULT . '.answer_respondent ar' )
						->join( DB_DEFAULT . '.answer a', 'a.id_answer = ar.id_answer' )
						->join( DB_DEFAULT . '.question q', 'q.id_question = a.id_question' )
						->join( DB_DEFAULT . '.questionnaire qnn', 'qnn.id_questionnaire = q.id_questionnaire' )
						->join( DB_DEFAULT . '.event e', 'e.id_event = qnn.id_event' )
						->get()->result();
	}
	
	function conta_entrevistados_por_id_questionario( $id_questionario )
	{
		$res = $this->get( array( 'id_questionario' => $id_questionario, 'conta_entrevistado' => TRUE ) );
		
		if ( ! empty( $res ) )
		{
			return array_shift( $res )->quantidade;
		}
		
		return FALSE;
	}
	
	function conta_entrevistado_por_resposta_por_id_questao( $id_questao )
	{
		$res = $this->get( array( 'id_questao' => $id_questao, 'conta_entrevistado_por_resposta' => TRUE ) );
		
		$dados =  array();
		
		if ( ! empty( $res ) )
		{
			foreach ( $res as $r )
			{
				$dados[ $r->posicao ] = $r->quantidade;
			}
		}
		
		return $dados;
	}
	
	function pesa_e_conta_entrevistado_por_resposta_por_id_questao( $id_questao )
	{
		$res = $this->get( array( 'id_questao' => $id_questao, 'pesa_e_conta_entrevistado_por_resposta' => TRUE ) );
		
		$dados =  array();
		
		if ( ! empty( $res ) )
		{
			foreach ( $res as $r )
			{
				$dados[ $r->posicao ] = (object) array( 'respostas' => $r->quantidade, 'peso' => $r->peso ) ;
			}
		}
		
		return $dados;
	}
}
