<?php	

class Questao_model extends CI_Model {
	var $show_total_resp = false;
	
	function __construct()
	{
		parent::__construct();
		$this->show_total_resp = false;
	}
	
	
	function all_answers( $id_questionarie )
	{
		if(!isset($id_questionarie) || intval($id_questionarie)<=0)
			return false;
		
		$this->db->select('a.id_answer,a.id_alvo, a.description, a.caminho, q.id_question');
		$this->db->where('q.id_questionnaire', (int)$id_questionarie);
		$this->db->where('q.active', 1);
		
		$query = $this->db->from(DB_DEFAULT . '.question as q')
					->join(DB_DEFAULT . '.answer a', 'a.id_question= q.id_question')
					->get()->result_array();


		/*Reordena por id_question*/
		$questions = array();
		foreach($query as $resps){
			
			if(!isset($questions[$resps['id_question']]))
				$questions[$resps['id_question']] = array();
				
			$questions[$resps['id_question']] [] = array(
				'id_answer'		=> $resps['id_answer'],
				'id_alvo'		=> $resps['id_alvo'],	
				'description'	=> $resps['description'],
				'caminho'		=> $resps['caminho']);
		}
		
		return $questions;
	}
	
	function set($nome,$val){
		if(isset($this->{$nome})){
			$this->{$nome} = $val;
		}
	}
	
	function verifica_bloqueio($id_questao)
	{
		$questao = $this->get_by_id_questao($id_questao);
			if ( empty($questao) )
				return TRUE;
		
		return (int) $questao->bloqueado;
	}
	
	function get( $options = array() )
	{
		
		$offset_inicio = 0;
		$offset_limit  = 0;
		
		// Paginacao
		if ( ! empty( $options['resultados'] ) )
		{
			$offset_limit = (int) $options['resultados'];
		}
		
		if ( ! empty( $options['pagina'] ) )
		{
			$offset_inicio = (int) ( ( $options['pagina'] - 1 ) * $offset_limit );
		}
		
		if ( ! empty( $options['resultados'] ) )
		{
			$this->db->limit( $offset_limit, $offset_inicio );
		}
		
		// Por padrão, só busca informações que pertencem ao usuário logado
		if ( ! empty( $options['id_usuario'] ) )
		{
			$this->db->where( 'e.id_user', (int) $options['id_usuario'] );
		}
		else
		{
			$this->db->where( 'e.id_user', (int) $this->phpsession->get( 'usuario' )->id_usuario );
		}
		
	
		if ( !empty($options['id_questionario']) )
			$this->db->where('q.id_questionnaire', (int) $options['id_questionario']);
		
		if ( !empty($options['id_questao']) )
			$this->db->where('q.id_question', (int) $options['id_questao']);
		
		if ( isset($options['ativo']) )
			$this->db->where('q.active', (bool) $options['active']);
		else
			$this->db->where('q.active', TRUE);
		
		$this->db->from(DB_DEFAULT . '.question q');

		if( $this->show_total_resp == true ){
			$this->db->select('count(a.id_answer) AS total_resp');
			$this->db->join(DB_DEFAULT . '.answer a', 'a.id_question = q.id_question');
		} 
		
		if ( !empty($options['count']) )
			$query = (int) array_shift($this->db->select('(COUNT(q.id_question)) AS quantidade', FALSE)->get()->result())->quantidade;
		else
			$query =   $this->db->select('q.id_questionnaire AS id_questionario,q.bifurcar as bifurca,q.palavra_chave, q.id_question AS id_questao, q.id_type AS id_tipo, q.description AS descricao,q.img_questao,q.transition,q.num_questions_transition, q.position AS posicao, q.id_category AS category')
								->select('qnn.available AS bloqueado')
								/*->join(DB_DEFAULT . '.question_type qt', 'qt.id_type = q.id_type')*/
								->join(DB_DEFAULT . '.questionnaire qnn', 'qnn.id_questionnaire = q.id_questionnaire')
								->join(DB_DEFAULT . '.event e', 'e.id_event = qnn.id_event')
								->order_by('q.position ASC')
								->get()->result();
		return $query;
	}
	
	function get_by_id_questionario( $id_questionario, $resultados = 0, $pagina = 0 )
	{
		$id_questionario = (int) $id_questionario;
		
		if ( empty( $id_questionario ) )
		{
			return array();
		}
		
		return $this->get( array( 'id_questionario' => (int) $id_questionario, 'resultados' => (int) $resultados, 'pagina' => (int) $pagina ) );
	}
	
	function get_by_id_questao($id_questao)
	{
		$id_questao = (int) $id_questao;
		if ( empty($id_questao) )
			return array();
		
		return array_shift( $this->get( array('id_questao' => $id_questao) ) );
	}
	
	function get_id_tipo_by_id_questao($id_questao)
	{
		$questao = $this->get_by_id_questao($id_questao);
		
		if ( ! empty($questao) )
		{
			return (int) $questao->id_tipo;
		}
		
		return FALSE;
	}
	
	function conta_questoes_by_id_questionario( $id_questionario )
	{
		return $this->get(array('id_questionario' => (int) $id_questionario, 'count' => TRUE));
	}
	
	function get_position_by_id_questao( $id_questao )
	{
		$questao = $this->get( array('id_questao' => $id_questao) );
		if ( !empty($questao) )
			return (int) array_shift($questao)->posicao;
		
		return 0;
	}
	
	function get_maior_posicao( $options = array() )
	{
		if ( !empty($options['id_questionario']) )
			$this->db->where('q.id_questionnaire', (int) $options['id_questionario']);
		
		if ( !empty($options['id_questao']) )
			$this->db->where('q.id_question', (int) $options['id_questao']);
		
		return (int) array_shift(
			$this->db->select('(MAX(q.position)) AS maior_posicao')
					 ->from(DB_DEFAULT . '.question q')
					 ->get()->result()
		)->maior_posicao;
	}
	
	function conta_questao_por_id_questionario( $id_questionario )
	{
		$res = $this->db->select( 'COUNT(q.id_question) AS quantidade' )
						->from( DB_DEFAULT . '.question q' )
						->where( 'q.id_questionnaire', (int) $id_questionario )
						->get()->result();
		
		$quantidade = 0;
		
		if ( ! empty( $res ) )
		{
			$quantidade  =(int) array_shift( $res )->quantidade;
		}
		
		return $quantidade;
	}
	
	function insert($dados)
	{
		
				
		if(isset($dados['id_questao_pai']) && !empty($dados['id_questao_pai']))
			$this->db->set('id_questao_pai', $dados['id_questao_pai']);
		
		if(isset($dados['elm1']) && !empty($dados['elm1']))
			$this->db->set('transition', $dados['elm1']);
			
		if(isset($dados['num_questions_transition']) && !empty($dados['num_questions_transition']))
			$this->db->set('num_questions_transition', $dados['num_questions_transition']);
		
		//id_alvo
		$this->db->set('id_question', 0);
		$this->db->set('id_questionnaire', (int) $dados['id_questionnaire']);
		$this->db->set('id_type', (isset($dados['id_type']) && $dados['id_type']!=""?(int) $dados['id_type']:""));
		$this->db->set('id_category', (isset($dados['id_categoria']) && $dados['id_categoria']!=""?(int) $dados['id_categoria']:""));
		$this->db->set('description', (isset($dados['description']) && $dados['description']!=""?(string) $dados['description']:""));
		$this->db->set('bifurcar', (isset($dados['bifurcar']) && $dados['bifurcar']=="sim"?1:0) );
		
		$this->db->set('palavra_chave', ($dados['palavra_chave']!=""?$dados['palavra_chave']:"") );
		$this->db->set('img_questao', ($dados['img_questao']!=""?$dados['img_questao']:"") );
		
		
		$position = $this->get_maior_posicao( array('id_questionario' => (int) $dados['id_questionnaire']) );
		
		$this->db->set('position', ((int)$position + 1));
		
		$id_question = 0;
		
		if($this->db->insert(DB_DEFAULT . '.question')){
			$id_question = $this->db->insert_id();

			if(isset($dados['id_questao_pai']) && !empty($dados['id_questao_pai'])){
				//	1 ou 2 .. se nenhum é zero
				$idPai = $dados['id_questao_pai'];
				$alvo = (isset($dados['id_alvo']) && !empty($dados['id_alvo']) ? (string)$dados['id_alvo'] : "0");
				
				$this->db->query("UPDATE answer SET id_alvo='$id_question' WHERE id_question='$idPai' AND caminho='$alvo'");
			}
		}
			
		return (int) $id_question;
	}
	
	function get_id_questionario_by_id_questao( $id_questao )
	{
		$questao = $this->get( array('id_questao' => $id_questao) );
		if ( !empty($questao) )
			return (int) array_shift($questao)->id_questionario;
		
		return 0;
	}
	
	/*
	function mudar_posicao($id_questao = 0, $posicao_alvo = 0)
	{
		$this->db->trans_begin();
		
		$id_questao    = (int) $id_questao;
		$posicao_alvo  = (int) $posicao_alvo;
		
		if ( empty($posicao_alvo) || empty($id_questao) )
			return FALSE;
		
		$posicao_fonte = $this->get_position_by_id_questao( $id_questao );
		$maior_posicao = $this->get_maior_posicao( array('id_question' => $id_questao) );
		
		$id_questionario = $this->get_id_questionario_by_id_questao( $id_questao );
		
		if ($posicao_fonte < $posicao_alvo) {
			$this->db->where("(position BETWEEN " . ($posicao_fonte + 1) . " AND " . $posicao_alvo . ")");
			$this->db->set('position', 'position - 1', FALSE);
		}
		
		if ($posicao_fonte > $posicao_alvo) {
			$this->db->where("(position BETWEEN " . $posicao_alvo  . " AND " . ($posicao_fonte - 1) . ")");
			$this->db->set('position', 'position + 1', FALSE);
		}
		
		$this->db->where('id_questionnaire', $id_questionario);
		$r = $this->db->update('question');
		
		if (!empty($r))
			$r = $this->db->set('position', $posicao_alvo)->where('id_question', $id_questao)->update('question');
		
		
		if (empty($r)) {
			$this->db->trans_rollback();
			return FALSE;
		}
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}
	*/
	
	function delete($id_questao)
	{
		$r = $this->db->set('active', 0)
					  ->where('id_question', (int) $id_questao)
					  ->update('question');
		
		return (!empty($r)) ? TRUE : FALSE;
	}
	
	function update($dados)
	{
		$r = $this->db->where('id_question', (int) $dados['id_question'])
					  ->update('question', $dados);
		
		return (!empty($r)) ? TRUE : FALSE;
	}
	
	function ordenar($ordem)
	{
		if ( isset($ordem[0]) )
			unset($ordem[0]);
		
		$this->db->trans_begin();
		
		try {
			foreach ($ordem as $posicao => $id_questao)
				if (!$this->db->set('position', (int) $posicao)
							  ->where('id_question', (int) $id_questao)
							  ->update(DB_DEFAULT . '.question') )
					throw new Exception('Ocorreu um erro. Por favor, tente novamente.');
					
			if ($this->db->trans_status() === FALSE)
				throw new Exception('Ocorreu um erro. Por favor, tente novamente.');
				
			
		} catch ( Exception $e ) {
			$this->db->trans_rollback();
			return FALSE;
			//return $e->getMessage();
		}
		
		$this->db->trans_commit();
		return TRUE;
	}
}
