<?php
class Endereco_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function get_endereco( $options )
	{
		if (isset($options['cep']))
			$this->db->where('e.cep', $options['cep']);
		
		return $this->db->select('b.nome AS bairro, b.id_bairro AS id_bairro, c.nome AS cidade, c.id_cidade AS id_cidade, u.id_uf AS uf, e.logradouro, e.complemento')
					->from(DB_ENDERECO . '.endereco e')
					->join(DB_ENDERECO . '.bairro b', 'b.id_bairro = e.id_bairro')
					->join(DB_ENDERECO . '.cidade c', 'c.id_cidade = e.id_cidade')
					->join(DB_ENDERECO . '.uf u', 'u.id_uf = e.id_uf')
					->get()->result();
	}
	
	function get_local( $options )
	{
		if (isset($options['id_bairro']) && !empty($options['id_bairro']))
			$this->db->where('b.id_bairro', $options['id_bairro']);
			
		if (isset($options['id_cidade']) && !empty($options['id_cidade']))
			$this->db->where('b.id_cidade', $options['id_cidade']);
			
		if (isset($options['id_uf']) && !empty($options['id_uf']))
			$this->db->where('b.id_uf', $options['id_uf']);
		
		return $this->db->select('b.id_bairro, b.nome AS nome_bairro, c.id_cidade, c.nome AS nome_cidade, u.id_uf')
						->from(DB_ENDERECO . '.bairro b')
						->join(DB_ENDERECO . '.cidade c', 'b.id_cidade = c.id_cidade')
						->join(DB_ENDERECO . '.uf u', 'c.id_uf = u.id_uf')
						->get()->result();
	}
	
	function get_bairro($options = array())
	{
		if (isset($options['id_cidade']))
			$this->db->where('b.id_cidade', $options['id_cidade']);
		
		return $this->db->select('b.id_bairro, b.nome')
					->from(DB_ENDERECO . '.bairro b')
					->order_by('b.nome ASC')
					->get()->result();
	}
	
	function get_cidade($options = array())
	{
		if (isset($options['id_uf']))
			$this->db->where('c.id_uf', $options['id_uf']);
		
		if (isset($options['id_cidade']))
			$this->db->where('c.id_cidade', $options['id_cidade']);
		
		return $this->db->select('c.id_cidade, c.nome, c.id_uf')
					->from(DB_ENDERECO . '.cidade c')
					->order_by('c.nome ASC')
					->get()->result();
	}
	
	function get_uf($options = array())
	{
		if (isset($options['id_pais']))
			$this->db->where('u.id_pais', $options['id_pais']);
		
		return $this->db->select('u.id_uf')
					->from(DB_ENDERECO . '.uf u')
					->order_by('u.id_uf ASC')
					->get()->result();
	}
	
	/*
	 ******************************** GET COMBO ********************************
	 */
	function get_combo_bairro($options = array(), $default = NULL)
	{
		$bairro = $this->get_bairro($options);
		
		$combo = array();
		
		if($default)
			$combo[] = $default;
			
		foreach($bairro as $b)
			$combo[$b->id_bairro] = $b->nome;
			
		return $combo;
	}
	
	function get_combo_cidade($options = array(), $default = NULL)
	{
		$uf = $this->get_cidade($options);
		
		$combo = array();
		
		if($default)
			$combo[] = $default;
			
		foreach($uf as $u)
			$combo[$u->id_cidade] = $u->nome;
			
		return $combo;
	}
	
	function get_combo_uf($options = array(), $default = NULL)
	{
		$uf = $this->get_uf($options);
		
		$combo = array();
		
		if($default)
			$combo[] = $default;
			
		foreach($uf as $u)
			$combo[$u->id_uf] = $u->id_uf;
			
		return $combo;
	}
	
	/*
	 ********************************* GET BY **********************************
	 */
	function get_by_cep( $cep )
	{
		$cep = trim( str_replace('-', '', $cep) );
		return array_shift( $this->get_endereco( array( 'cep' => $cep ) ) );
	}
	
	function get_id_uf_por_id_cidade( $id_cidade )
	{
		$cidade = $this->get_cidade( array( 'id_cidade' => $id_cidade ) );
		if (!empty($cidade))
			return array_shift( $cidade )->id_uf;
		else
			return NULL;
	}
	
	function get_nome_bairro_by_id_bairro( $id_bairro )
	{
		$bairro =  array_shift($this->get_local(array('id_bairro' => $id_bairro)));
		if ( isset($bairro->nome) )
			return $bairro->nome;
		
		return FALSE;
	}
	
	function get_nome_cidade_by_id_bairro( $id_bairro )
	{
		$cidade =  array_shift($this->get_local(array('id_bairro' => $id_bairro)));
		if ( isset($cidade->nome) )
			return $cidade->nome;
		
		return FALSE;
	}
	
	function get_id_uf_by_id_bairro( $id_bairro )
	{
		
		$uf =  array_shift($this->get_local(array('id_bairro' => $id_bairro)));
		if ( isset($uf->uf) )
			return $uf->uf;
		
		return FALSE;
	}
	
	function get_local_by_id_bairro( $id_bairro )
	{
		return array_shift($this->get_local(array('id_bairro' => $id_bairro)));
	}
}
