<?php

class Questionario_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
		
	}
	
	function verifica_bloqueio($id_questionario)
	{
		$questionario = $this->get_by_id_questionario($id_questionario);
		if ( empty($questionario) )
			return TRUE;
		
		return (int) $questionario->disponivel;
	}
	
	function get( $options = array() )
	{
		
		if ( isset($options['disponivel']) )
			$this->db->where('q.available', (bool) $options['disponivel']);
			
		if ( isset($options['ativo']) )
			$this->db->where('q.active', (bool) $options['ativo']);
		else
			$this->db->where('q.active', TRUE);
		
		if ( !empty($options['id_evento']) )
			$this->db->where('q.id_event', (int) $options['id_evento']);
		
		if ( !empty($options['id_questionario']) )
			$this->db->where('q.id_questionnaire', (int) $options['id_questionario']);
		
		if ( !empty($options['id_usuario']) )
			$this->db->join(DB_DEFAULT . '.event e', 'q.id_event = e.id_event AND e.id_user = ' . (int) $options['id_usuario']);
		else {
			// Por padrão só pega questionários do usuario ativo
			$usuario = $this->phpsession->get('usuario');
			if ( !empty($usuario) )
				$this->db->join(DB_DEFAULT . '.event e', 'q.id_event = e.id_event AND e.id_user = ' . (int) $usuario->id_usuario);
			else
				return FALSE;
		}
		
		if ( isset( $options['possui_respostas'] ) )
		{
			$this->db->join(DB_DEFAULT . '.question qt', 'q.id_questionnaire = qt.id_questionnaire')
					 ->join(DB_DEFAULT . '.answer a', 'a.id_question = qt.id_question')
					 ->join(DB_DEFAULT . '.answer_respondent ar', 'ar.id_answer = a.id_answer');
		}
		
		return $this->db->select('q.id_event AS id_evento, q.id_questionnaire AS id_questionario, q.name AS nome, q.available AS disponivel')
						->select('DATE_FORMAT(q.creation_date, "%d/%m/%y") AS data_criacao', FALSE)
						->select('DATE_FORMAT(q.creation_date, "%H:%i") AS hora_criacao', FALSE)
						->from(DB_DEFAULT . '.questionnaire q')
						->order_by('q.id_questionnaire DESC')
						->get()->result();
	}
	
	function get_by_id_evento($id_evento)
	{
		return $this->get( array('id_evento' => (int) $id_evento) );
	}
	
	function get_by_id_questionario($id_questionario)
	{
		if ( empty($id_questionario) )
			return array();
		
		return array_shift( $this->get( array('id_questionario' => $id_questionario) ) );
	}
	
	function get_id_evento_by_id_questionario($id_questionario)
	{
		if ( empty($id_questionario) )
			return FALSE;
		
		$questionario = $this->get_by_id_questionario($id_questionario);
		if ( empty($questionario) )
			return FALSE;
		
		return (int) $questionario->id_evento;
	}
	
	function get_combo_possui_respostas( $default = NULL )
	{
		return $this->get_combo( array( 'possui_respostas' => TRUE ), $default );
	}
	
	function get_combo($options = array(), $default = NULL)
	{
		$questionarios = $this->get($options);
		
		$combo = array();
		
		if($default)
			$combo[] = $default;
			
		foreach($questionarios as $q)
			$combo[$q->id_questionario] = $q->nome;
		
		return $combo;
	}
	
	function insert($dados)
	{
		if ( isset($dados['available']) && !empty($dados['available']) )
			$this->db->set('available', TRUE);
		else
			$this->db->set('available', FALSE);
		
		$this->db->set('id_event', (int) $dados['id_evento']);
		$this->db->set('creation_date', 'now()', false);
		$this->db->set('name', $dados['name']);
		$this->db->set('active', TRUE);
		
		if($this->db->insert(DB_DEFAULT . '.questionnaire')) {
			$id_questionario = $this->db->insert_id();

			return (int) $id_questionario;
		}
		else
			return FALSE;
	}
	
	function delete($id_questionario)
	{
		$r = $this->db->set('active', 0)
					  ->where('available', FALSE)
					  ->where('id_questionnaire', (int) $id_questionario)
					  ->update('questionnaire');
		
		return (!empty($r)) ? TRUE : FALSE;
	}
	
	function duplicar($id_questionario_origem, $id_evento_destino)
	{
		// * OBS: Start transaction do CodeIgniter não funciona corretamente com db->query()
		$this->db->query("START TRANSACTION");
		try {
			$usuario = $this->phpsession->get('usuario');
			if ( empty($usuario) )
				throw new Exception('Necess&aacute;rio efetuar o login primeiro.');
		
			$id_questionario_origem = (int) $id_questionario_origem;
			if ( empty($id_questionario_origem) )
				throw new Exception('Question&aacute;rio inv&acute;lido.');
			
			// Se NÃO houver evento de destino, pega o evento do próprio questionário
			$id_evento_destino = (int) $id_evento_destino;
			if ( empty($id_evento) )
				$id_evento = $this->get_id_evento_by_id_questionario($id_questionario_origem);
			if ( empty($id_evento) )
				throw new Exception('Evento inv&acute;lido.');
			
			$this->load->model('Evento_model', 'evento');
			// Verifica se o questionário de destino é do usuário ativo
			if ( !$this->evento->verifica_usuario($id_evento_destino) )
				throw new Exception('Autentica&ccedil;&atilde;o falhou.');
			
			// Duplica o questionário
			$query = $this->db->query(
					  " INSERT INTO questionnaire (id_event, name)("
					. " SELECT " . $id_evento_destino . ", CONCAT('(Cópia) ', q2.name) AS name FROM " . DB_DEFAULT . ".questionnaire q2"
					. " INNER JOIN " . DB_DEFAULT . ".questionnaire q3 ON q3.id_questionnaire = q2.id_questionnaire AND q2.id_questionnaire = " . $id_questionario_origem
					. " INNER JOIN " . DB_DEFAULT . ".event e ON e.id_event = q3.id_event AND e.id_user = " . (int) $usuario->id_usuario . ")"
					);
			
			if ( empty($query) )
				throw new Exception('N&atilde;o foi poss&iacute;vel duplicar o question&aacute;rio');
			
			$id_questionario_duplicado = (int) $this->db->insert_id();
			
			// Duplica as questões do questionário
			$query = $this->db->query(
					  "INSERT INTO question (id_questionnaire, id_type, description, position, active)"
					. "(SELECT " . $id_questionario_duplicado . ", q2.id_type, q2.description, q2.position, q2.active FROM " . DB_DEFAULT . ".question q2 WHERE q2.id_questionnaire = "
					. $id_questionario_origem . " AND active = 1" . ")"
					);
			
			if ( empty($query) )
				throw new Exception('N&atilde;o foi poss&iacute;vel duplicar as quest&otilde;es');
			
			// Duplica as respostas das questões
			$query = $this->db->query(
					  "INSERT INTO answer (id_question, description, position, weight, active) ("
					. "SELECT q2.id_question, a.description, a.position, a.weight, a.active FROM " . DB_DEFAULT . ".answer a "
					. "INNER JOIN " . DB_DEFAULT . ".question q ON a.id_question = q.id_question "
					. "INNER JOIN " . DB_DEFAULT . ".question q2 ON q.description = q2.description AND q.active = q2.active AND q.id_questionnaire = "
					. $id_questionario_origem . " AND q2.id_questionnaire = " . $id_questionario_duplicado . ")"
					);
			
			if ( empty($query) )
				throw new Exception('N&atilde;o foi poss&iacute;vel duplicar as respostas');
		
		} catch (Exception $e) {
			$this->db->query("ROLLBACK");
			return $e->getMessage();
		}
		
		$this->db->query("COMMIT");
		return TRUE;
		
	}
	
	function update($dados)
	{
		$r = $this->db->where('id_questionnaire', (int) $dados['id_questionnaire'])
					  ->where('available', FALSE)
					  ->update('questionnaire', $dados);
		
		return (!empty($r)) ? TRUE : FALSE;
	}
}
