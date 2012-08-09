<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Validation Class
 */
class Validation {
	public function date($str, $format = DATETIME_BR){
		$CI =& get_instance();
		$CI->load->library('DateUtils');
		return $CI->dateutils->validate($str, $format);
	}

	public function dddtel($str){
		$value = preg_replace('/\s+/', '', $str);
		return strlen($value) > 9 && preg_match("/^\(?0?\d{2}\)?[\s-]?\d{3,4}-?\d{4}$/", $value);
	}

	public function tel($str){
		$value = preg_replace('/\s+/', '', $str);
		return preg_match("/^\d{3,4}-?\d{4}$/", $value);
	}

	public function cep($str){
		// Validação CRUA
		$value = preg_replace('/\s+/', '', $str);
		$valid = strlen($value) >= 8 && preg_match("/^\d{5}[-]?\d{3}/", $value);
		return !$valid;
	}

	public function prep_cpf($str){
		// retira todos os caracteres que nao sejam 0-9
		$str = preg_replace("/[^0-9]*/", "", $str);
		return sprintf("%03d.%03d.%03d-%02d",
			substr($str, 0, 3 ),
			substr($str, 3, 3 ),
			substr($str, 6, 3 ),
			substr($str, 9)
		);
	}

	public function prep_cnpj($str){
		// retira todos os caracteres que nao sejam 0-9
		$str = preg_replace("/[^0-9]*/", "", $str);
		return sprintf("%02d.%03d.%03d/%04d-%02d",
			substr($str, 0, 2 ),
			substr($str, 2, 3 ),
			substr($str, 5, 3 ),
			substr($str, 8, 4 ),
			substr($str, 12)
		);
	}


	public function cpf($str){
		// define os cpfs nulos
		$nulos = array(
			"12345678909",
			"11111111111",
			"22222222222",
			"33333333333",
			"44444444444",
			"55555555555",
			"66666666666",
			"77777777777",
			"88888888888",
			"99999999999",
			"00000000000"
		);
		
		// retira todos os caracteres que nao sejam 0-9

		$cpf = preg_replace("/[^0-9]*/", "", $str);

		// verifica se existe alguma letra
		if( !preg_match("/^[0-9.-]*$/", $str) ) return false;
		if (!(preg_match("/[0-9]*/",$cpf))) return false;

		// verifica se o cpf é inválido
		if( in_array($cpf, $nulos)) return false;
		if( strlen($cpf) < 11 ) return false;

		// calcula o penultimo digito verificador
		$acum=0;
		for($i=0; $i<9; $i++) {
			$acum+= $cpf[$i]*(10-$i);
		}

		$x=$acum % 11;
		$acum = ($x>1) ? (11 - $x) : 0;

		// verifica se o penultimo digito verificador é invalido
		if ($acum != $cpf[9]){ return false; }
		
		// calcula o ultimo digito verificador
		$acum=0;
		for ($i=0; $i<10; $i++){
			$acum+= $cpf[$i]*(11-$i);
		}

		$x=$acum % 11;
		$acum = ($x > 1) ? (11-$x) : 0;

		// verifica se o penultimo digito verificador é invalido
		if ( $acum != $cpf[10]) return false;
		return true;
	}

	public function cnpj($str){
		// valida o cnpj
		$cnpj = preg_replace ("@[./-]@", "", $str);
		if (strlen ($cnpj) <> 14 || !is_numeric ($cnpj)) return false;

		// inicia algumas variaveis necessárias
		$j = 5;
		$k = 6;
		$soma1 = "";
		$soma2 = "";
		
		// percorre os numeros
		for ($i = 0; $i < 13; $i++){
			$j = $j == 1 ? 9 : $j;
			$k = $k == 1 ? 9 : $k;
			$soma2 += ($cnpj{$i} * $k);
			if ($i < 12) $soma1 += ($cnpj{$i} * $j); 
			$k--; $j--; 
		} 
		
		// obtem os digitos
		$digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
		$digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11; 
		
		// valida
		$cnpjValido =  (($cnpj{12} == $digito1) and ($cnpj{13} == $digito2));
		
		// verifica se o cnpj é valido
		if(!$cnpjValido) return false;
		return true;
	}
}

