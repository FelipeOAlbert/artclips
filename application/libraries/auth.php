<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth {
	private $CI;
	private $usuario;
	
	function __construct(){
		$this->CI = &get_instance();
		
		$this->usuario = $this->CI->phpsession->get('usuario');
	}
	function verifica_permissao($escopo, $acao, $redirect = TRUE){
		// Se for administrador, retorna sempre true
		if($this->verifica_perfil('Administrador', FALSE))
			return true;
		else{
			$permissao = array_shift($this->CI->db->select('u.login, pe.description AS perfil, p.scope AS escopo, p.action AS acao, pp.permission AS permissao')
										->from(DB_DEFAULT . '.permission p')
										->join(DB_DEFAULT . '.profile_permission pp', 'p.id_permission = pp.id_permission')
										->join(DB_DEFAULT . '.profile pe', 'pp.id_profile = pe.id_profile')
										->join(DB_DEFAULT . '.user_profile up', 'pe.id_profile = up.id_profile')
										->join(DB_DEFAULT . '.user u', 'up.id_user = u.id_user')
										->where('u.id_user',  $this->usuario->id_usuario)
										->where('p.scope', $escopo)
										->where('p.action', $acao)
										->where('pp.permission', 1)
										->get()->result());

			if(!$permissao) {
				if($redirect)
					header("location:" . site_url('principal/nao_autorizado'));
				else
					return false;
			}
			else
				return true;
		}
	}

	function verifica_perfil($perfil, $redirect = TRUE) {
		$perfil = array_shift($this->CI->db->select('p.id_profile AS perfil, p.description AS descricao')
											->from(DB_DEFAULT . '.profile p')
											->join(DB_DEFAULT . '.user_profile up', 'p.id_profile = up.id_profile')
											->where('up.id_user', $this->usuario->id_usuario)
											->where('lower(p.description)', strtolower($perfil))
											->get()->result());
		
		if(!$perfil) {
			if($redirect)
				header("location:" . site_url('principal/nao_autorizado'));
			else
				return false;
		}
		else
			return true;
	}
	
	function verifica_perfil_com_admin($perfil, $redirect = true)
	{
		if ($this->verifica_perfil('Administrador', false))
			return true;
		
		return $this->verifica_perfil($perfil, $redirect);
	}
}
?>
