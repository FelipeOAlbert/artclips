<?php

class Categoria_questao_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function get( $options = array() )
	{
		$this->db->from(DB_DEFAULT . '.question_category qt');

		$query = $this->db->select('qt.id AS id, qt.description AS descricao')
						  ->order_by('qt.id ASC')
						  ->get()->result();
		
		return $query;
	}
	
	function get_combo($options = array(), $default = null)
	{
		$tipos = $this->get($options);
		
		$combo = array();
		
		if($default)
			$combo[] = $default;
			
		foreach($tipos as $c)
			$combo[$c->id] = $c->descricao;
			
		return $combo;
	}
}
