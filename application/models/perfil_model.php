<?php
class Perfil_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	function get(){
		return $this->db->select('id_perfil, descricao')
						->from('perfil')
						->get()->result();
	}
	function getCombo($default=false){
		$perfis = $this->get();
		
		$combo_array = Array();
		
		if($default)
			$combo_array[] = $default;
		
		foreach($perfis as $p)
			$combo_array[$p->id_perfil] = $p->descricao;
	
		return $combo_array;
	}
}
?>
