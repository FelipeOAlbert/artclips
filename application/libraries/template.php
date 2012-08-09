<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

define('DEFAULT_TEMPLATE' , 'template');
define('DEFAULT_DIRECTORY', '');

class Template {
	private $data;
	
	function __construct() {
		$this->clear();
	}
	function __isset($name) {
		return isset($this->data[$name]);
	}
	function __unset($name) {
		unset($this->data[$name]);
	}
	function __set($name, $value) {
		$this->data[$name] = $value;
	}
	function __get($name) {
		if (array_key_exists($name, $this->data))
			return $this->data[$name];
			
		/** cada propriedade chamada, define um diretorio */
		if ($this->data['directory'] == DEFAULT_DIRECTORY)
			$this->data['directory'] .= $name;
		else
			$this->data['directory'] .= '/' . $name;
		
		return $this;
		
		$trace = debug_backtrace();
		die("Propriedade indefinida via __get($name): no arquivo {$trace[0]['file']}, na linha {$trace[0]['line']}");
	}
	function __call($metodo, $parametros) {
		$view = NULL;
		$data = array();
		
		if (!count($parametros)) {
			/** Metodo sem parametros, define o template */
			$this->data['template'] = $metodo;
			return $this;
		}
		
		if (is_array($parametros[0])) {
			/** Se for array, significa o primeiro parâmetro são os DADOS
				então a VIEW é o nome do próprio método */
			$view	 = $metodo;
			$data	 = $parametros[0];
			$template = (isset($parametros[1])) ? $parametros[1] : $this->data['template'];
		 } else {
			/** Caso contrário, o primeiro parâmetro é o nome da VIEW */
			$view	  = $metodo . '/' . $parametros[0];
			
			$data	  = (isset($parametros[1])) ? $parametros[1] : array();
			$template = (isset($parametros[2])) ? $parametros[2] : $this->data['template'];
		}
		
		$this->show($view, $data, $template);
	}
	function show($view, $data = array(), $template = DEFAULT_TEMPLATE) {
		$CI = &get_instance();

		if ($this->data['template'] != DEFAULT_TEMPLATE && $template == DEFAULT_TEMPLATE)
			$template = $this->data['template'];
		
		if ($this->data['directory'] != DEFAULT_DIRECTORY)
			$view = $this->data['directory'] . '/' . $view;
		
		// converte tudo sempre em objetos
		if (is_array($data)) {
			$dados = array_merge($this->data, $data);
			$data = new stdClass();
			foreach ($dados as $key => $value)
				$data->$key = $value;
		} elseif(is_object($data))
			foreach ($this->data as $key => $value)
				$data->$key = $value;
		
		if ( !$CI->input->is_ajax_request() )
			$CI->load->view($template, array('view' => $view, 'dados' => $data));
		else
			$CI->load->view($view, $data);
		
		$this->clear();
	}
	private function clear(){
		$this->data = array();
		$this->data['template']  = DEFAULT_TEMPLATE;
		$this->data['directory'] = DEFAULT_DIRECTORY;
	}
}
?>
