<?php

class Questionnaire_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function get($options=array())
	{
		if(!empty($options['available']))
			$this->db->where('q.available', TRUE);
			
		if(!empty($options['active']))
			$this->db->where('q.active', $options['active']);
		else
			$this->db->where('q.active', TRUE);
			
		
		$tmp = $this->db->select('q.*')
						->from('questionnaire q')
						->get()->result();

		if(empty($options['complete']))
			return $tmp;
		else{
			$questionnaires = array();
			
			foreach($tmp as $q){
				$q->questions = $this->get_questions($q->id_questionnaire);
				
				$questionnaires[] = $q;
			}
		
			return $questionnaires;
		}
	}
	
	function simple_get()
	{
		if(!empty($options['available']))
			$this->db->where('q.available', TRUE);
			
		if(!empty($options['active']))
			$this->db->where('q.active', $options['active']);
		else
			$this->db->where('q.active', TRUE);
			
		
		$tmp = $this->db->select('q.id_questionnaire AS id_questionario, q.id_user AS id_usuario, q.nome')
						->from('questionnaire q')
						->get()->result();
	}
	
	function get_available($id_user)
	{
		if(empty($id_user))
			return FALSE;
		else
			return $this->get(array('available' => TRUE, 'complete' => TRUE));
	}
	
	function get_questions($id_questionnaire)
	{
		if(empty($id_questionnaire))
			return FALSE;
		else{
			$tmp = $this->db->from('question')->where('id_questionnaire', $id_questionnaire)->get()->result();
			$questions = array();
			
			foreach($tmp as $q){
				$q->answers = $this->get_answers($q->id_question);
				
				$questions[] = $q;
			}

			return $questions;
		}
	}
	
	function get_answers($id_question)
	{
		if(empty($id_question))
			return FALSE;
		else
			return $this->db->from('answer')->where('id_question', $id_question)->get()->result();
	}
	
	function get_question_by_id($id_question){
		return $this->db->from('question q')
						->where('q.id_question', $id_question)
						->get()->row();
	}
	
	function is_valid_answer($id_question=NULL, $id_answer){
		if($id_question)
			$this->db->where('q.id_question', $id_question);
	
		return $this->db->select('q.id_question')
						->from('question q')
						->join('answer a', 'q.id_question = a.id_question')
						->where('a.id_answer', $id_answer)
						->get()->row();
	}
	
	function insert($dados)
	{
		if ( isset($dados['available']) && !empty($dados['available']) )
			$this->db->set('available', TRUE);
		else
			$this->db->set('available', FALSE);
		
		$this->db->set('creation_date', 'now()', false);
		$this->db->set('name', $dados['name']);
		$this->db->set('active', TRUE);
		
		$usuario = $this->phpsession->get('usuario');
		if ($usuario)
			$this->db->set('id_user', (int) $usuario->id_usuario, false);
		
		if($this->db->insert(DB_DEFAULT . '.questionnaire')) {
			$id_questionario = $this->db->insert_id();

			return (int) $id_questionario;
		}
		else
			return false;
	}
}
