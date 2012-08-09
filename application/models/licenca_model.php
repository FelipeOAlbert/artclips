<?php
class Licenca_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function get( $options = array() )
	{
		if ( isset($options['ativo']) )
			$this->db->where('l.active', (bool) $options['ativo']);
		else
			$this->db->where('l.active', TRUE);
		
		return $this->db->select('l.id_license AS id_licenca, id_type_license AS id_tipo_licenca, l.validity AS validade, l.value AS valor, l.active AS ativo')
						->from(DB_DEFAULT . '.license l')
						->get()->result();
	}
	
	function get_questionario_licenca( $options = array() )
	{
		$this->db->from(DB_DEFAULT . '.license l')
				 ->join(DB_DEFAULT . '.questionnaire_license ql', 'ql.id_license = l.id_license')
				 ->join(DB_DEFAULT . '.questionnaire q', 'q.id_questionnaire = ql.id_questionnaire')
				 ->join(DB_DEFAULT . '.event e', 'q.id_event = e.id_event')
				 ->join(DB_DEFAULT . '.event_address ea', 'ea.id_event = e.id_event AND ea.active = TRUE')
				 ->join(DB_ENDERECO . '.bairro b', 'b.id_bairro = ea.id_neighborhood')
				 ->join(DB_ENDERECO . '.cidade c', 'c.id_cidade = b.id_cidade')
				 ->join(DB_ENDERECO . '.uf u', 'u.id_uf = c.id_uf')
				 ->order_by('ql.licensing_date DESC');
	
		if ( isset($options['expirado']) )
			$this->db->where('ql.expired', (bool) $options['expirado']);
		
		if ( !empty($options['id_questionario']) )
			$this->db->where('q.id_questionnaire', (int) $options['id_questionario']);
		
		if ( !empty($options['id_usuario']) )
			$this->db->where('e.id_user', (int) $options['id_usuario']);
		else {
			// Por padrão só pega questionários do usuario ativo
			$usuario = $this->phpsession->get('usuario');
			if ( !empty($usuario) )
				$this->db->where('e.id_user', (int) $usuario->id_usuario);
			else
				return FALSE;
		}
		
		return $this->db->select('l.id_license AS id_licenca, id_type_license AS id_tipo_licenca, l.validity AS validade, l.value AS valor, l.active AS ativo')
						->select('ql.licensing_date AS data_licenciamento, ql.expired AS expirado')
						->select('q.id_questionnaire AS id_questionario, q.name AS questionario')
						->select('e.name AS evento')
						
						// endereço do evento
						->select('ea.street AS logradouro, ea.number AS numero, ea.complement AS complemento, ea.zip_code AS cep')
						->select('u.id_uf AS uf, c.nome AS cidade, b.nome AS bairro')
						
						// datas da licença
						->select('DATE_FORMAT(ql.licensing_date, "%d/%m/%Y") AS data_licencimento_formatada', FALSE)
						->select('ADDDATE(ql.licensing_date, INTERVAL l.validity DAY) AS data_expiracao', FALSE)
						->select('( CASE WHEN l.validity > DATEDIFF(NOW(), ql.licensing_date) THEN l.validity - DATEDIFF(NOW(), ql.licensing_date) ELSE 0 END ) AS tempo_restante', FALSE)
						->select('DATE_FORMAT(ADDDATE(ql.licensing_date, INTERVAL l.validity DAY), "%d/%m/%Y") AS data_expiracao_formatada', FALSE)
						->get()->result();
	}
	
	function get_combo_validade_valor($options = array(), $default = NULL)
	{
		$licencas = $this->get($options);
		
		$combo = array();
		
		if($default)
			$combo[] = $default;
			
		foreach($licencas as $l) {
			if ($l->id_tipo_licenca == 1)
				// Licença por tempo
				$combo[$l->id_licenca] = convert_days_in_month_text($l->validade) . ' - R$ ' . money_EUA_to_BR($l->valor);
			else
				// Licença por quantidade
				$combo[$l->id_licenca] = $l->validade . ' entrevistas - R$ ' . money_EUA_to_BR($l->valor);
		}
		
		return $combo;
	}
	
	function ativar($id_licenca, $id_questionario)
	{
		$this->db->trans_begin();
		
		try {
			// Validação simples
			$id_licenca = (int) $id_licenca;
			$id_questionario = (int) $id_questionario;
			if ( empty($id_licenca) || empty($id_questionario) )
				throw new Exception('Dados inv&aacute;lidos.');
			
			// Verifica se o questionário é do usuário ativo
			$this->load->model('Questionario_model', 'questionario');
			$r = $this->questionario->get_by_id_questionario($id_questionario);
			if ( empty($r) )
				throw new Exception('Usu&aacute;rio n&atilde;o autenticado!');
			
			// busca outra licença ativa no mesmo questionário
			$r = $this->get_questionario_licenca( array( 'id_questionario' => $id_questionario, 'id_licenca' => $id_licenca, 'expirado' => FALSE ) );
			
			if ( !empty($r) )
				throw new Exception('O question&aacuterio j&aacute; possui uma licen&ccedil;a ativa.');
			
			// Insere a ativação
			if ( !$this->db->set('id_questionnaire', $id_questionario)->set('id_license', $id_licenca)->insert('questionnaire_license') )
				throw new Exception('N&atilde;o foi poss&iacute;vel ativar a licen&ccedil;a!');
			
			// Disponibiliza o questionário (ele fica bloqueado)
			if ( !$this->db->set('available', TRUE)->where('id_questionnaire', $id_questionario)->where('active', TRUE)->update('questionnaire') )
				throw new Exception('N&atilde;o foi poss&iacute;vel bloquear o questionário!');
			
			if($this->db->trans_status() === FALSE)
				throw new Exception('N&atilde;o foi poss&iacute;vel ativar a licen&ccedil;a!');
			
		} catch (Exception $e) {
			$this->db->trans_rollback();
			return $e->getMessage();
		}
		
		$this->db->trans_commit();
		return TRUE;
	}
}
