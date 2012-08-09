<?php

class User_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	function get($options=array()){
		if(!empty($options['login']))
			$this->db->where('u.login', $options['login']);
		if(!empty($options['password']))
			$this->db->where('u.password', MD5($options['password']));

		if(!empty($options['id']))
			$this->db->where('u.id', MD5($options['id']));
			
		return $this->db->select('u.id_user, u.login, u.password, u.name, u.email, u.creation_date, INET_NTOA(u.last_ip) last_ip, DATE_FORMAT(u.last_access, "%d/%m/%y %H:%i") as last_access, u.active', FALSE)
					->from('user u')
					->get()->result();
	}
	function get_by_login($login, $password){
		if(empty($login) || empty($password))
			return FALSE;
		else
			return array_shift($this->get(array('login'=>$login, 'password'=>$password)));
	}
}
