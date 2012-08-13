<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('envia_email'))
{
	function envia_email($assunto, $mensagem, $para=array(), $de_email="no-reply@revelaweb.com.br", $de_nome="RevelaWeb"){
		$CI = &get_instance();
	
		$config['mailtype'] = 'html';
		$CI->load->library('email', $config);
		$CI->email->set_newline("\r\n");
		
		$CI->email->from($de_email, $de_nome);
		$CI->email->reply_to($de_email, $de_nome);
		//$CI->email->to('luciano.px@gmail.com');
		$CI->email->to($para);
		
		$CI->email->subject($assunto);
		$CI->email->message($mensagem);

		return $CI->email->send();
	}
}

if ( ! function_exists('calculaIntervalo'))
{
	function calculaIntervalo($data1,$data2=false){
		$data_hora = explode(" ", $data1);
		$data = implode("-", array_reverse(explode("/", $data_hora[0]))) . " " . $data_hora[1];
		$data1 = strtotime($data);
	
		if(!$data2)
			$data2 = time();
		else{	
			$data_hora = explode(" ", $data2);
			$data = implode("-", array_reverse(explode("/", $data_hora[0]))) . " " . $data_hora[1];
			$data2 = strtotime($data);
		}
		
		$diferenca = abs($data2-$data1);

		 # Recupera os dias
		$dias  = floor($diferenca/86400);
		# Recupera as horas
		$horas = floor(($diferenca-($dias*86400))/3600);
		# Recupera os minutos
		$mins  = floor(($diferenca-($dias*86400)-($horas*3600))/60);
		# Recupera os segundos
		$segs  = floor($diferenca-($dias*86400)-($horas*3600)-($mins*60));
		
		# Monta o retorno no formato
		# 5d 10h 15m 20s
		# somente se os itens forem maior que zero
		$retorno  = "";
		$retorno .= ($dias>0)  ?  $dias . 'd ' : ""  ;
		$retorno .= ($dias>0 || $horas>0) ?  $horas . 'h ': ""  ;
		$retorno .= ($dias>0 || $horas>0 || $mins>0)  ?  $mins . 'm ' : ""  ;
		$retorno .= ($dias>0 || $horas>0 || $mins>0 || $segs>0)  ?  $segs . 's ' : ""  ;
		# Se o dia for maior que 3 fica vermelho
		if($dias > 3){
			return "<span style='color:red'>" . $retorno . "</span>";
		}
		else
			return $retorno;
	}
}

if ( ! function_exists('debug'))
{
	function debug($_value_debug = null, $_title_debug = null, $_title_size_debug = null, $_print_debug = true)
	{
		if ($_value_debug == null)
			$_value_debug = '';

		if ($_title_debug != null) {
			if ($_title_size_debug != null) {
				$_title_size_debug = (int) $_title_size_debug;
			
				if (! $_title_size_debug > 0)
					$_title_size_debug = 17;
			}
	
			echo"<SPAN style='font-size: $_title_size_debug;'><B>$_title_debug</B></SPAN>";
		}
		
		echo "<PRE>";
	
		if ($_print_debug) {
			print_r($_value_debug);
		} else {
			var_dump($value_debug);
		}
	
		echo "</PRE>";
	}
}

if ( ! function_exists('url_sistemas') )
{
	function url_sistemas($sistema=null){
		$url = array();
		$tmp = explode("/", base_url());
		
		for($i=0; $i<(count($tmp)-2); $i++){
			$url[] = $tmp[$i];
		}
		$url = implode("/", $url);
		
		return $url . "/" . $sistema;
	}
}

if ( ! function_exists('limita_texto') )
{
	function limita_texto($str, $caracteres, $busca = NULL) {
		
		if ( strlen($str) < $caracteres )
			return $str;
		
		$str   = (string) $str;
		$busca = (string) $busca;
		$caracteres = (int) $caracteres;
		
		$inicio = 0;
		$fim    = $caracteres;
		
		if ( !empty($busca) ) {
			$pos_inicial = strpos ($str, $busca);
			$pos_final   = FALSE;
			$diferenca   = FALSE;
			
			if ($pos_inicial !== FALSE)
				$pos_final   = $pos_inicial + strlen($busca);
			
			if ($pos_final !== FALSE)
				$diferenca = $pos_final - $pos_inicial;
			
			if ($diferenca) {
				if ($pos_final > $fim) {
					$inicio += $pos_final - $fim;
					$fim     = $pos_final;
				}
			}
		}
		
		$retorno = substr($str, $inicio, $fim);
		
		if (strlen($str) != $fim)
			$retorno .= '...';
		
		if ($inicio > 0)
			$retorno = '...' . $retorno;
		
		return $retorno;
	}
}

if ( ! function_exists('money_EUA_to_BR') )
{
	function money_EUA_to_BR($valor) {
		return
		str_replace(';', '.',
			str_replace('.', ',',
				str_replace(',', ';', number_format($valor, 2) ) ) );
	}
}

if ( ! function_exists('born_date') )
{
	function born_date($nascimento_br) {
		
		$hoje = date("Y-m-d"); //pega a data de hoje
		$aniv = explode("-", $nascimento_br); //separa a data de nascimento em array, utilizando o símbolo de - como separador
		$atual = explode("-", $hoje); //separa a data de hoje em array
		
		$idade = $atual[0] - $aniv[0];
		
		if($aniv[1] > $atual[1]) //verifica se o mês de nascimento é maior que o mês atual
		{
			$idade--; //tira um ano, já que ele não fez aniversário ainda
		}
		elseif($aniv[1] == $atual[1] && $aniv[0] > $atual[0]) //verifica se o dia de hoje é maior que o dia do aniversário
		{
			$idade--; //tira um ano se não fez aniversário ainda
		}
		
		return $idade; //retorna a idade da pessoa em anos
	}
}

if ( ! function_exists('data_select') )
{
	function data_select($selected, $rows)
	{
		foreach($rows as $row){
			if($row['id_event'] == $selected){
				print('<option value="'.$row['id_event'].'" selected="selected">'.$row['name'].'</option>');
			} else {
				print('<option value="'.$row['id_event'].'">'.$row['name'].'</option>');
			}
		}
		
		return true;
	}
}

?>
