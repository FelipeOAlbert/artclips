<?php

class Tipo_questao_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function get( $options = array() )
	{
		$this->db->from(DB_DEFAULT . '.question_type qt');
		
		if ( !empty($options['count']) )
			$query = (int) array_shift($this->db->select('(COUNT(a.id_answer)) AS quantidade', FALSE)->get()->result())->quantidade;
		else
			$query = $this->db->select('qt.id_type AS id_tipo, qt.description AS descricao')
							  ->order_by('qt.id_type ASC')
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
			$combo[$c->id_tipo] = $c->descricao;
			
		return $combo;
	}
}
