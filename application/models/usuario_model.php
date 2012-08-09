<?php

class Usuario_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	function get($options=array()){
		if(isset($options['active']) && $options['active'])
			$this->db->where('u.active', $options['active']);
		else{
			if(!isset($options['todos']))
				$this->db->where('u.active', 1);
		}

		if(isset($options['id_user']) && $options['id_user'])
			$this->db->where('u.id_user', $options['id_user']);
		
		if(isset($options['name']) && $options['name'])
			$this->db->where('u.name', $options['name']);
			
		if(isset($options['login']) && $options['login'])
			$this->db->where('u.login', $options['login']);
			
		if(isset($options['password']) && $options['password'])
			$this->db->where('u.password', $options['password']);
			
		if(isset($options['email']) && $options['email'])
			$this->db->where('u.email', $options['email']);

		if(isset($options["not_id_user"]) && $options["not_id_user"])
			$this->db->where('id_user !=', $options["not_id_user"]);
			
		if(isset($options['id_profile']) && $options['id_profile'])
			$this->db->join('user_profile up', 'u.id_user = up.id_user AND up.id_profile = ' . $options['id_profile']);
			
		if(isset($options['profile']) && $options['profile']) {
			$this->db->join(DB_DEFAULT . '.user_profile up', 'u.id_user = up.id_user');
			$this->db->join(DB_DEFAULT . '.profile p', 'up.id_profile = p.id_profile AND p.description = "' . $options['profile'] . '"');
		}

		return $this->db->select('u.id_user AS id_usuario, u.name AS nome, u.email, u.login, u.password AS senha')
						->from(DB_DEFAULT . '.user u')
						->order_by('u.name', 'ASC')
						->get()->result();
	}
	
	function get_detalhes( $options = array() )
	{

		if(isset($options['id_usuario']) && $options['id_usuario'])
			$this->db->where('ud.id_user', $options['id_usuario']);

		return $this->db->select('ud.id_user AS id_usuario, ud.document AS documento, ud.birth_date AS data_nascimento, ud.last_name AS sobrenome')
						->from(DB_DEFAULT . '.user_detail ud')
						->get()->result();
	}
	
	function get_endereco( $options = array() )
	{
		if(isset($options['ativo']) && $options['ativo'])
			$this->db->where('ua.active', $options['ativo']);
		else{
			if(!isset($options['todos']))
				$this->db->where('ua.active', 1);
		}

		if(isset($options['id_usuario']) && $options['id_usuario'])
			$this->db->where('ua.id_user', $options['id_usuario']);

		return $this->db->select('ua.id_user AS id_usuario, ua.id_user_address AS id_usuario_endereco, ua.active AS ativo, ua.zip_code AS cep')
						->select('ua.street AS logradouro, ua.number AS numero, ua.complement AS complemento')
						->select('b.id_bairro, c.id_cidade, u.id_uf')
						->join(DB_ENDERECO . '.bairro b', 'ua.id_neighborhood = b.id_bairro')
						->join(DB_ENDERECO . '.cidade c', 'b.id_cidade = c.id_cidade')
						->join(DB_ENDERECO . '.uf u', 'c.id_uf = u.id_uf')
						->from(DB_DEFAULT . '.user_address ua')
						->get()->result();
	}
	
	function get_email_exists( $email )
	{
		
		$this->db->where('login', $email);
		$this->db->or_where('email', $email);

		return $this->db->select('id_user')
						->from(DB_DEFAULT . '.user')
						->get()->result();
	}
	
	function get_document_exists( $doc )
	{
		
		$this->db->where('document', $doc);
		return $this->db->select('id_user')
						->from(DB_DEFAULT . '.user_detail')
						->get()->result();
	}
	
	
	function get_telefone( $options = array() )
	{
		if(isset($options['ativo']) && $options['ativo'])
			$this->db->where('up.active', $options['ativo']);
		else{
			if(!isset($options['todos']))
				$this->db->where('up.active', 1);
		}

		if(isset($options['id_usuario']) && $options['id_usuario'])
			$this->db->where('up.id_user', $options['id_usuario']);

		return $this->db->select('up.id_user AS id_usuario, up.id_user_phone AS id_usuario_telefone, up.active AS ativo')
						->select('up.ddd, up.phone AS telefone')
						->from(DB_DEFAULT . '.user_phone up')
						->get()->result();
	}
	
	function get_perfis($id_usuario)
	{
		return $this->db->select('up.id_user AS id_usuario, up.id_profile AS id_perfil, p.description AS descricao')
						->from(DB_DEFAULT . '.user_profile up')
						->join(DB_DEFAULT . '.profile p', 'up.id_profile = p.id_profile')
						->where('up.id_user', (int) $id_usuario)
						->get()->result();
	}
	
	function get_permissoes($id_usuario)
	{
		return $this->db->select('u.login, pe.description AS descricao, p.scope AS escopo, p.action AS acao, pp.permission AS permissao')
						->from(DB_DEFAULT . '.permission p')
						->join(DB_DEFAULT . '.profile_permission pp', 'p.id_permission = pp.id_permission')
						->join(DB_DEFAULT . '.profile pe', 'pp.id_profile = pe.id_profile')
						->join(DB_DEFAULT . '.user_profile up', 'pe.id_profile = up.id_profile')
						->join(DB_DEFAULT . '.user u', 'up.id_user = u.id_user')
						->where('u.id_user', (int) $id_usuario)
						->get()->result();
	}
	
	function get_by_id_usuario($id_usuario)
	{
		$id_usuario = (int) $id_usuario;
		if ( !empty($id_usuario) )
			return array_shift( $this->get( array( 'id_user' => $id_usuario ) ) );
		
		return FALSE;
	}
	
	function get_detalhes_by_id_usuario($id_usuario)
	{
		$id_usuario = (int) $id_usuario;
		if ( !empty($id_usuario) )
			return array_shift( $this->get_detalhes( array( 'id_usuario' => $id_usuario ) ) );
		
		return FALSE;
	}
	
	function get_endereco_by_id_usuario($id_usuario)
	{
		$id_usuario = (int) $id_usuario;
		if ( !empty($id_usuario) )
			return array_shift( $this->get_endereco( array( 'id_usuario' => $id_usuario ) ) );
		
		return FALSE;
	}
	
	function get_telefone_by_id_usuario($id_usuario)
	{
		$id_usuario = (int) $id_usuario;
		if ( !empty($id_usuario) )
			return array_shift( $this->get_telefone( array( 'id_usuario' => $id_usuario ) ) );
		
		return FALSE;
	}
	
	function logar_ultimo_acesso()
	{
		$usuario = $this->phpsession->get('usuario');
		if ( empty($usuario) )
			return FALSE;
		
		$this->db->where('id_user', (int) $usuario->id_usuario)
				 ->set('last_ip', $_SERVER['REMOTE_ADDR'])
				 ->set('last_access', date('Y-m-d H:i:s'));
		
		if ( $this->db->update(DB_DEFAULT . '.user') )
			return TRUE;
		
		return FALSE;
	}
	
	function editar_senha($senha_atual, $senha_nova)
	{
		$usuario = $this->phpsession->get('usuario');
		
		if ( MD5($senha_atual) != $usuario->senha )
			return 'A senha atual informada est&aacute; incorreta.';
		
		if ( empty($senha_nova) )
			return 'A nova senha &eacute; inv&aacute;lida';
		
		$res = $this->db->set('password', MD5($senha_nova))
						->where('id_user', $usuario->id_usuario)
						->update(DB_DEFAULT . '.user');
		
		if ( !empty($res) ) {
			// Atualiza a SESSÃO
			$usuario->senha = MD5($senha_nova);
			$this->phpsession->save('usuario', $usuario);
			return TRUE;
		}
	}
	
	function editar_email($email_atual, $email_novo)
	{
		$usuario = $this->phpsession->get('usuario');
		
		if ( $email_atual != $usuario->email )
			return 'O e-mail atual informado est&aacute; incorreto.';
		
		if ( empty($email_novo) )
			return 'O novo e-mail &eacute; inv&aacute;lido';
		
		$res = $this->db->set('email', $email_novo)
						->set('login', $email_novo)
						->where('id_user', $usuario->id_usuario)
						->update(DB_DEFAULT . '.user');
		
		if ( !empty($res) ) {
			// Atualiza a SESSÃO
			$usuario->email = $email_novo;
			$usuario->login = $email_novo;
			$this->phpsession->save('usuario', $usuario);
			return TRUE;
		}
	}
	
	function insert($dados)
	{
		return $this->save($dados);
	}
	
	function update($dados)
	{
		return $this->save($dados);
	}
	
	function save($dados)
	{
		$id_usuario = 0;
		
		$usuario = $this->phpsession->get('usuario');
		
		$this->db->trans_begin();
		
		/*Atribuição de variavis*/
		$documento = (isset($dados['documento']) && trim($dados['documento'])!="" ?str_replace ( '-' , '' ,str_replace ( '/' , '' ,str_replace ( '.' , '' ,$dados['documento']) ) ) : false);
		$email = (isset($dados['email']) && trim($dados['email'])!="" ? $dados['email'] : false);
		
		$dados['address']['id_neighborhood'] = $_REQUEST['endereco_bairro'];
		$dados['address']['street'] = $_REQUEST['logradouro'];
		$dados['address']['number'] = $_REQUEST['numero'];
		$dados['address']['complement'] = $_REQUEST['complemento']; 
		$dados['address']['zip_code'] = $_REQUEST['cep']; 

		try {
			if ( empty($dados['nome']) )
				throw new Exception('Nome inv&aacute;lido.');
			
			$this->db->set('name',     $dados['nome']);
			
			if ( empty($usuario) ) {
			// Usuário não logado (os formulários de editar senha e e-mail são individuais)
			
				if ( $email==false || empty($dados['senha']) )
					throw new Exception('E-mail ou senha inv&aacute;lidos.');
				
				$this->db->set('email',    $email);
				$this->db->set('login',    $email);
				$this->db->set('password', MD5($dados['senha']));
			}
			
			$result = FALSE;
			
			if ( empty($usuario->id_usuario) ) {
				
				/*Valida o bixo pra ver se documento ou email constam*/
				$docExists = $this->get_document_exists($documento);
				if(isset($docExists[0]->id_user) && $docExists[0]->id_user!=0)
					throw new Exception('Documento já consta em nossa base de dados');
				
				$emailExists = $this->get_email_exists($email);
				if(isset($emailExists[0]->id_user) && $emailExists[0]->id_user!=0)
					throw new Exception('Email já consta em nossa base de dados');
				
				// INSERE NOVO USUARIO
				if( $this->db->insert(DB_DEFAULT . '.user') )
					$id_usuario = (int) $this->db->insert_id();

			} else {
				// ATUALIZA O USUARIO ATUAL
				if ( $this->db->where('id_user', (int) $usuario->id_usuario )->update(DB_DEFAULT . '.user') )
					$id_usuario = (int) $usuario->id_usuario;
			}
			
			if ( !empty($id_usuario) ) {

				// TELEFONE
				if ( !empty($dados['fone']) ) {
					$this->db->set('id_user',  $id_usuario)
							 ->set('phone', str_replace ( '-' , '' , $dados['fone']) )
							 ->set('ddd',   $dados['ddd']);
					
					$telefone = $this->get_telefone_by_id_usuario($id_usuario);
					
					if ( empty($telefone) ) {
						// INSERE O TELEFONE
						if ( !$this->db->insert(DB_DEFAULT . '.user_phone') )
							throw new Exception('Telefone inv&aacute;lido.');
					} else {
						// ATUALIZA O TELEFONE
						if ( !$this->db->where('id_user', (int) $id_usuario )->update(DB_DEFAULT . '.user_phone') )
							throw new Exception('Telefone inv&aacute;lido.');
					}
					
				} else {
					throw new Exception('Telefone inv&aacute;lido.');
				}
				
				
				// DETALHES DO USUARIO
				if ( $documento!=false && !empty($dados['sobrenome'])) {
					$this->db->set('id_user',    $id_usuario)
							 ->set('last_name',  $dados['sobrenome'])
							 ->set('birth_date', date_BR_to_EUA($dados['data_nascimento']) )
							 ->set('document',   $documento );
					
					$detalhe = $this->get_detalhes_by_id_usuario($id_usuario);
					
					if ( empty($detalhe) ) {
						// INSERE O TELEFONE
						if ( !$this->db->insert(DB_DEFAULT . '.user_detail') )
							throw new Exception('Por favor, verifica os campos.');
					} else {
						// ATUALIZA O TELEFONE
						if ( !$this->db->where('id_user', (int) $id_usuario )->update(DB_DEFAULT . '.user_detail') )
							throw new Exception('Por favor, verifica os campos.');
					}
				
				} else {
					throw new Exception('Por favor, verifica os campos.');
				}

				// ENDEREÇO

				if ( !empty($dados['address']) ) {
					$this->db->set('id_neighborhood', (int) $dados['address']['id_neighborhood'])
							 ->set('id_user',    $id_usuario)
							 ->set('street',     $dados['address']['street'])
							 ->set('number',     $dados['address']['number'])
							 ->set('complement', $dados['address']['complement'])
							 ->set('zip_code',   str_replace ( '-' , '' , $dados['address']['zip_code']) );
					
					$endereco = $this->get_endereco_by_id_usuario($id_usuario);
					
					if ( empty($endereco) ) {
						// INSERE O TELEFONE
						if ( !$this->db->insert(DB_DEFAULT . '.user_address') )
							throw new Exception('Endere&ccedil;o inv&aacute;lido.');
					} else {
						// ATUALIZA O TELEFONE
						if ( !$this->db->where('id_user', (int) $id_usuario )->update(DB_DEFAULT . '.user_address') )
							throw new Exception('Endere&ccedil;o inv&aacute;lido.');
					}
				
				} else {
					throw new Exception('Endere&ccedil;o inv&aacute;lido.');
				}
				
			} else {
				throw new Exception('Ocorreu um erro. Por favor, tente novamente.');
			}
			
			if($this->db->trans_status() === FALSE)
				throw new Exception('Ocorreu um erro. Por favor, tente novamente.');
			
		} catch (Exception $e) {
			$this->db->trans_rollback();
			return $e->getMessage();
		}
		
		$this->db->trans_commit();
		return (int) $id_usuario;
	}
}
?>
