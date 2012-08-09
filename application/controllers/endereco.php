<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Endereco extends CI_Controller implements SkipAuth {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Endereco_model', 'endereco');
	}
	
	function dropdown_ufs($default_uf = 0, $default_cidade = 0, $default_bairro = 0)
	{
		$this->dropdown_ufs_por_pais( 1, $default_uf, $default_cidade, $default_bairro);
	}
	
	function dropdown_ufs_por_pais($id_pais = 0, $default_uf = 0, $default_cidade = 0, $default_bairro = 0)
	{
		$default = ( $default_uf == 0 ) ? '(selecione...)' : NULL;
		
		$dados = array(
			'ufs'            => $this->endereco->get_combo_uf( array('id_pais' => $id_pais), $default ),
			'default_uf'     => $default_uf,
			'default_cidade' => (int) $default_cidade,
			'default_bairro' => (int) $default_bairro
		);
		
		$this->load->view('endereco/ufs_dropdown', $dados);
	}
	
	function dropdown_cidades_por_uf($id_uf = 0, $default_cidade = 0, $default_bairro = 0)
	{
		$default = ( $default_cidade == 0 ) ? '(selecione...)' : NULL;
		
		$dados = array(
			'cidades'        => $this->endereco->get_combo_cidade( array('id_uf' => $id_uf), $default ),
			'default_cidade' => (int) $default_cidade,
			'default_bairro' => (int) $default_bairro
		);
		
		$this->load->view('endereco/cidades_dropdown', $dados);
	}
	
	function dropdown_bairros_por_cidade($id_cidade = 0, $default_bairro = 0)
	{
		$default = ( $default_bairro == 0 ) ? '(selecione...)' : NULL;
		
		$bairros = $this->endereco->get_combo_bairro( array('id_cidade' => $id_cidade), $default );
		$this->load->view('endereco/bairros_dropdown', array('bairros' => $bairros, 'default_bairro' => $default_bairro));
	}
	
	function buscar_endereco_por_cep($cep)
	{
		$retorno = array();
		$retorno['ok'] = false;
		
		$endereco = $this->endereco->get_by_cep( $cep );
		
		if ( !empty($endereco) ) {
			$retorno['logradouro']  = $endereco->logradouro;
			$retorno['complemento'] = $endereco->complemento;
			$retorno['id_bairro']   = $endereco->id_bairro;
			$retorno['id_cidade']   = $endereco->id_cidade;
			$retorno['uf']          = $endereco->uf;
			
			$retorno['ok']          = TRUE;
		} else {
			$retorno['msg'] = 'Cep n&atilde;o encontrado!<br />Por favor, entre com o endere&ccedil;o manualmente.';
		}

		echo json_encode($retorno);
	}
}
?>
