<?php

class Evento_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function verifica_usuario($id_evento, $id_usuario = 0)
	{
		$id_usuario = (int) $id_usuario;
		// Pega o usuário ativo
		if ( empty($id_usuario) ) {
			$usuario = $this->phpsession->get('usuario');
			if ( empty($usuario) )
				return FALSE;
			
			$id_usuario = $usuario->id_usuario;
		}
		
		$evento = array_shift( $this->get( array('id_evento' => $id_evento, 'id_usuario' => $id_usuario) ) );
		if ( !empty($evento) )
			return  TRUE;
		
		return FALSE;
	}
	
	function get( $options = array() )
	{
		if ( isset($options['ativo']) )
			$this->db->where('e.active', (bool) $options['active']);
		else
			$this->db->where('e.active', TRUE);
		
		if ( !empty($options['id_usuario']) )
			$this->db->where('e.id_user', (int) $options['id_usuario']);
		
		if ( !empty($options['id_evento']) )
			$this->db->where('e.id_event', (int) $options['id_evento']);
		
		return $this->db->select('e.id_event AS id_evento, e.id_user AS id_usuario, e.name AS nome, e.active AS ativo')
						->select('DATE_FORMAT(e.creation_date, "%d/%m/%y") AS data_criacao', FALSE)
						->select('DATE_FORMAT(e.creation_date, "%H:%i") AS hora_criacao', FALSE)
						->from(DB_DEFAULT . '.event e')
						->order_by('e.id_event DESC')
						->get()->result();
	}
	
	function get_endereco( $options= array() )
	{
		if ( isset($options['ativo']) )
			$this->db->where('ea.active', (bool) $options['active']);
		else
			$this->db->where('ea.active', TRUE);
		
		if ( !empty($options['id_evento']) )
			$this->db->where('ea.id_event', (int) $options['id_evento']);
		
		if ( !empty($options['id_evento_endereco']) )
			$this->db->where('ea.id_event_address', (int) $options['id_evento_endereco']);
		
		if ( ! empty( $options['id_questionario'] ) )
		{
			$this->db->join( DB_DEFAULT . '.questionnaire qnn', 'qnn.id_event = e.id_event', 'LEFT' )
				 ->where( 'qnn.id_questionnaire', (int) $options['id_questionario'] )
				 ->group_by( 'e.id_event' );
		}
		
		return $this->db->select('ea.id_event AS id_evento, ea.id_event_address AS id_evento_endereco, ea.active AS ativo')
						->select('ea.street AS logradouro, ea.number AS numero, ea.complement AS complemento, ea.zip_code AS cep')
						->select('u.id_uf, c.id_cidade, b.id_bairro')
						->join(DB_ENDERECO . '.bairro b', 'b.id_bairro = ea.id_neighborhood')
						->join(DB_ENDERECO . '.cidade c', 'c.id_cidade = b.id_cidade')
						->join(DB_ENDERECO . '.uf u', 'u.id_uf = c.id_uf')
						->from(DB_DEFAULT . '.event_address ea')
						->get()->result();
	}
	
	function get_by_id_usuario($id_usuario)
	{
		$id_usuario = (int) $id_usuario;
		if ( empty($id_usuario) )
			return array();
		
		return $this->get( array('id_usuario' => (int) $id_usuario) );
	}
	
	function get_by_id_evento($id_evento)
	{
		$id_evento = (int) $id_evento;
		if ( empty($id_evento) )
			return FALSE;
		
		return array_shift( $this->get( array('id_evento' => $id_evento) ) );
	}
	
	function get_by_id_questionario( $id_questionario )
	{
		return array_shift( $this->get( array( 'id_questionario' => $id_questionario ) ) );
	}
	
	function get_endereco_by_id_evento($id_evento)
	{
		$id_evento = (int) $id_evento;
		if ( empty($id_evento) )
			return FALSE;
		
		return array_shift( $this->get_endereco( array('id_evento' => $id_evento) ) );
	}
	
	function insert($dados)
	{
		$id_evento = 0;

		if(isset($dados['nome']) && !isset($dados['name'])){
		 $dados['name'] = $dados['nome'];
		}
		$this->db->trans_begin();
		
		try {
			
			if ( empty($dados['name']) )
				throw new Exception('Nome do evento inv&aacute;lido.');
			
			$this->db->set('name', (string) $dados['name']);
			$this->db->set('creation_date', 'now()', false);
			
			$usuario = $this->phpsession->get('usuario');
			if ($usuario)
				$this->db->set('id_user', (int) $usuario->id_usuario);
			
			if ( $this->db->insert(DB_DEFAULT . '.event') ) {
				$id_evento = (int) $this->db->insert_id();

				// INSERE O ENDEREÇO
				if ( !empty($dados['cep']) ) {
					
					$this->db->set('id_neighborhood', (int) $dados['endereco_bairro']);
					$this->db->set('id_event',   $id_evento);
					$this->db->set('street',     $dados['logradouro']);
					$this->db->set('number',     $dados['numero']);
					$this->db->set('complement', $dados['complemento']);
					$this->db->set('zip_code',   str_replace ( '-' , '' , $dados['cep']) );
					
					if ( !$this->db->insert(DB_DEFAULT . '.event_address') )
						throw new Exception('Endere&ccedil;o inv&aacute;lido.');
				} else {
					throw new Exception('Endere&ccedil;o inv&aacute;lido.');
				}
				
				
				// INSERE O RESPONSAVEL
				if (	!empty($dados['nome_resp']) &&
						!empty($dados['tel_resp']) &&
						!empty($dados['email_resp']) &&
						!empty($dados['login_resp']) &&
						!empty($dados['senha_resp'])
					) {
					$this->db->set('id_event',   $id_evento);
					$this->db->set('nome',     $dados['nome_resp']);
					$this->db->set('tel',     $dados['tel_resp']);
					$this->db->set('email', $dados['email_resp']);
					$this->db->set('login', $dados['login_resp']);
					$this->db->set('senha', md5($dados['senha_resp']));
					
					if ( !$this->db->insert(DB_DEFAULT . '.event_resp') )
						throw new Exception('Respons&aacute;vel inv&aacute;lido.');
				} else {
					throw new Exception('Respons&aacute;vel inv&aacute;lido.');
				}
				
				
				// INSERE login Ipad
				if (	!empty($dados['login_ipad']) &&
						!empty($dados['senha_ipad'])
					) {
					$this->db->set('id_event',   $id_evento);
					$this->db->set('login_ipad',$dados['login_ipad']);
					$this->db->set('senha_ipad',md5($dados['senha_ipad']));
					
					if ( !$this->db->insert(DB_DEFAULT . '.event_ipad') )
						throw new Exception('Login/Senha ipad inv&aacute;lido.');
				} else {
					throw new Exception('Login/Senha ipad inv&aacute;lido.');
				}
				
			} else {
				throw new Exception('Ocorreu um erro.');
			}
			
			if($this->db->trans_status() === FALSE)
				throw new Exception('Ocorreu um erro.');
			
		} catch (Exception $e) {
			$this->db->trans_rollback();
			//return FALSE;
			return $e->getMessage();
		}
		
		$this->db->trans_commit();
		return (int) $id_evento;
	}
	
	function get_combo($options = array(), $default = NULL)
	{
		$eventos = $this->get($options);
		
		$combo = array();
		
		if($default)
			$combo[] = $default;
			
		foreach($eventos as $e)
			$combo[$e->id_evento] = $e->nome;
			
		return $combo;
	}
	
	function delete($id_evento)
	{
		$r = $this->db->set('active', 0)
					  ->where('id_event', (int) $id_evento)
					  ->update('event');
		
		return (!empty($r)) ? TRUE : FALSE;
	}
	
	function update($dados)
	{
		$this->db->trans_begin();
		
		try {
			$usuario = $this->phpsession->get('usuario');
			
			if ($usuario)
				$this->db->where('id_user', (int) $usuario->id_usuario);
			else
				throw new Exception('Necess&aacute;rio efetuaar o login.');
			
			if ( !empty($dados['name']) )
				$this->db->set('name', (string) $dados['name']);
			else
				throw new Exception('Nome do evento inv&aacute;lido.');
			
			if ( !empty($dados['id_event']) )
				$this->db->where('id_event', (int) $dados['id_event']);
			else
				throw new Exception('Evento inv&aacute;lido.');
			
			if ( $this->db->update(DB_DEFAULT . '.event') ) {

				// Busca o endereço. Se não existir, cria um.
				if ( !empty($dados['address']) ) {
				
					$this->db->set('id_neighborhood', (int) $dados['address']['id_neighborhood'])
							 ->set('street',     $dados['address']['street'])
							 ->set('number',     $dados['address']['number'])
							 ->set('complement', $dados['address']['complement'])
							 ->set('zip_code',   str_replace ( '-' , '' , $dados['address']['zip_code']) );
					
					$endereco = $this->get_endereco( array( 'id_evento' => (int) $dados['id_event'] ) );
					
					if ( empty($endereco) ) {
					// INSERE UM NOVO ENDEREÇO
						if ( !$this->db->set('id_event', (int) $dados['id_event'])->insert(DB_DEFAULT . '.event_address') )
							throw new Exception('N&atilde;o foi poss&iacute;vel adicionar o endereco.');
					} else
					// ATUALIZA O ENDEREÇO EXISTENTE
						if ( !$this->db->where('id_event', (int) $dados['id_event'])->update(DB_DEFAULT . '.event_address') )
							throw new Exception('N&atilde;o foi poss&iacute;vel atualizar o endereco.');
				} else {
					throw new Exception('Endere&ccedil;o inv&aacute;lido.');
				}
				
			} else {
				throw new Exception('Ocorreu um erro.');
			}
			
			if($this->db->trans_status() === FALSE)
				throw new Exception('Ocorreu um erro.');
			
		} catch (Exception $e) {
			$this->db->trans_rollback();
			//return FALSE;
			return $e->getMessage();
		}
		
		$this->db->trans_commit();
		return (int) $dados['id_event'];
	}
}
