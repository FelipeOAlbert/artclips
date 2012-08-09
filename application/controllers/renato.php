<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Renato extends CI_Controller implements SkipAuth{

	public function usuario()
	{
		$dados = array(
			'cadastro' => NULL,
			'endereco' => NULL,
			'telefone' => NULL,
		);
		
		$usuario = $this->phpsession->get('usuario');
		
		// Carrega os dados para edição
		if ( !empty($usuario->id_usuario) ) {
			$dados['usuario']  = $this->usuario->get_by_id_usuario( $usuario->id_usuario );
			$dados['endereco'] = $this->usuario->get_endereco_by_id_usuario( $usuario->id_usuario );
			$dados['telefone'] = $this->usuario->get_telefone_by_id_usuario( $usuario->id_usuario );
			$dados['detalhes'] = $this->usuario->get_detalhes_by_id_usuario( $usuario->id_usuario );
		}
		
		$this->template->show('usuario/cadastro', $dados);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
