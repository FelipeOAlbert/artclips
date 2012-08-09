<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Licenca extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Licenca_model', 'licenca');
	}
	
	function index()
	{
		$this->template->show('licenca/index');
	}
	
	function lista()
	{
		$questionario_licenca = $this->licenca->get_questionario_licenca();
		
		$this->template->show('licenca/lista', array('questionario_licenca' => $questionario_licenca) );
	}
	
	function ativacao()
	{
		$this->load->model('Questionario_model', 'questionario');
		
		$licencas      = $this->licenca->get_combo_validade_valor( array(), '(selecione...)' );
		$questionarios = $this->questionario->get_combo( array( 'disponivel' => FALSE ), '(selecione...)' );
		
		$this->template->show('licenca/ativacao', array('licencas' => $licencas, 'questionarios' => $questionarios));
	}
	
	function ativar()
	{
		$retorno = array();
		$retorno['ok'] = false;
		
		$result = $this->licenca->ativar( (int) $this->input->post('id_licenca'), (int) $this->input->post('id_questionario') );
		
		if ( $result === TRUE ) {
			$retorno['ok']  = TRUE;
			$retorno['msg'] = 'Licen&ccedil;a ativada com sucesso!';
			
			$retorno['id_licenca']		= (int) $this->input->post('id_licenca');
			$retorno['id_questionario'] = (int) $this->input->post('id_questionario');
		} else {
			$retorno['msg'] = $result;
		}
		
		echo json_encode($retorno);
	}
	/*
	function teste()
	{
		$this->load->library('curl');
		
		$dados = array();
		$dados['email'] = 'suporte@lojamodelo.com.br';
		$dados['token'] = '95112EE828D94278BD394E91C4388F20';
		$dados['currency'] = 'BRL';
		$dados['itemId1'] = '0001';
		$dados['itemDescription1'] = 'Notebook Prata';
		$dados['itemAmount1'] = '24300.00';
		$dados['itemQuantity1'] = '1';
		$dados['itemWeight1'] = '1000';
		$dados['itemId2'] = '0002';
		$dados['itemDescription2'] = 'Notebook Rosa';
		$dados['itemAmount2'] = '25600.00';
		$dados['itemQuantity2'] = '2';
		$dados['itemWeight2'] = '750';
		$dados['reference'] = 'REF1234';
		$dados['senderName'] = 'Jose Comprador';
		$dados['senderAreaCode'] = '11';
		$dados['senderPhone'] = '56273440';
		$dados['senderEmail'] = 'comprador@uol.com.br';
		$dados['shippingType'] = '1';
		$dados['shippingAddressStreet'] = 'Av. Brig. Faria Lima';
		$dados['shippingAddressNumber'] = '1384';
		$dados['shippingAddressComplement'] = '5o andar';
		$dados['shippingAddressDistrict'] = 'Jardim Paulistano';
		$dados['shippingAddressPostalCode'] = '01452002';
		$dados['shippingAddressCity'] = 'Sao Paulo';
		$dados['shippingAddressState'] = 'SP';
		$dados['shippingAddressCountry'] = 'BRA';
		
		$this->curl->create( 'https://ws.pagseguro.uol.com.br/v2/checkout/' )
			//->curl_setopt( CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; UTF-8, ISO-8859-1') )
			->post( $dados, array(), TRUE );
		
		var_dump( $this->curl->execute() );
	}*/
}
?>
