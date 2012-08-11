<?php

class Report_model extends CI_Model {
	
    function __construct()
	{
		parent::__construct();
        
        $this->table = '';
	}
    
    // funcao para pegar todos os usuários cadastrados
    public final function get_users()
    {
        //Setando....
        $man    		= 0;
        $woman  		= 0;
        $data   		= array();
        $age 			= '';
		$age_18_25 		= 0;
        $age_26_32 		= 0;
        $age_33_40 		= 0;
        $age_41_50 		= 0;
        $age_51_plus 	= 0;        
        
        
        $this->db->select('user.name, user_detail.gender, user_detail.birth_date, user_profile.id_profile');
        $this->db->from('user');
        $this->db->join('user_detail', 'user_detail.id_user = user.id_user');
        $this->db->join('user_profile', 'user_profile.id_user = user.id_user');
        $this->db->where(array('user_profile.id_profile' => 2));
        $query = $this->db->get();
        
        if($query->num_rows > 0){
            
            $total = $query->num_rows;
            
            foreach($query->result_array() as $v){
                
                //calculando quantidade de homens - 1/ mulheres - 0
                switch($v['gender']){
                    case 0:
                        $woman++;
                    break;
                    
                    case 1:
                        $man++;
                    break;
                }
                
                //faixa de idades
                $age = born_date($v['birth_date']);
                
                if(isset($age)){
                    
					if($age >= 18 && $age <= 25){
                        $age_18_25++;
                    }
					
                    if($age >= 26 && $age <= 32){
						$age_26_32++;
                    }
                    
                    if($age >= 33 && $age <= 40){
                        $age_33_40++;
                    }
                    
                    if($age >= 41 && $age <= 50){
                        $age_41_50++;
                    }
                    
                    if($age >= 51){
                        $age_51_plus++;
                    }
                }
            }
            
            //montando array de saida
            // quant homem / mulher / porcent
            $data['quant_man']      = $man;
            $data['perc_man']       = round(($man / $total) * 100, 2);
            $data['quant_woman']    = $woman;
            $data['perc_woman']     = round(($woman / $total) * 100, 2);
            
            // quant range de idade / porcent
            $data['quant_age_18_25']        =  $age_18_25;
            $data['percent_age_18_25']      = round(($age_18_25 / $total) * 100, 2);
            $data['quant_age_26_32']        = $age_26_32;
            $data['percent_age_26_32']      = round(($age_26_32 / $total) * 100, 2);
            $data['quant_age_33_40']        = $age_33_40;
            $data['percent_age_33_40']      = round(($age_33_40 / $total) * 100, 2);
            $data['quant_age_41_50']        = $age_41_50;
            $data['percent_age_41_50']      = round(($age_41_50 / $total) * 100, 2);
            $data['quant_age_51_plus']      = $age_51_plus;
            $data['percent_age_51_plus']    = round(($age_51_plus / $total) * 100, 2);
            
            //quant de usuarios ( visitantes ) cadastrados
            $data['total'] = $total;
            
            return $data;
        }
        
        return false;
    }
    
	public final function getEventById($id = 0)
	{
		$query = $this->db->get_where('event', array('id_event' => $id));
		
		if($query->num_rows > 0){
			return $query->result_array();
		}
		
		return false;
	}
	
	public final function getQuestionnaireByEventId($id = 0)
	{
		$query = $this->db->get_where('questionnaire', array('id_event' => $id));
		
		if($query->num_rows > 0){
			return $query->result_array();
		}
		
		return false;
	}
	
	public final function getQuestionByQuestionnaire($id = 0)
	{
		$query = $this->db->get_where('question', array('id_questionnaire' => $id));
		
		if($query->num_rows > 0){
			return $query->result_array();
		}
		
		return false;
	}
	
	public final function getAnswerByQuestion($id = 0)
	{
		$query = $this->db->get_where('answer', array('id_question' => $id));
		
		if($query->num_rows > 0){
			return $query->result_array();
		}
		
		return false;
	}
	
	public final function getAnswerRespondentByAnswer($id = 0)
	{
		$query = $this->db->get_where('answer_respondent', array('answer_id' => $id));
		
		if($query->num_rows > 0){
			return $query->num_rows;
		}
		
		return 0;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public final function get_data_by_event($id_event = 0)
	{
		
		$data = array();
		
		#creio que esteja errado..... ao invez de buscar na tabela evento.... deve começar pela tabela de respostas
		
		$where = array(
						'event.active' 			=> 1,
						'questionnaire.active' 	=> 1,
						'question.active' 		=> 1,
						'event.id_event' 		=> $id_event
					   );
		
		$this->db->select('
							event.id_event,
							event.id_user,
							event.name AS event_name,
							questionnaire.id_questionnaire,
							questionnaire.name AS questionnaire_name,
							questionnaire.available,
							question.id_question,
							question.id_type,
							question.id_transicao,
							question.id_questao_pai,
							question.id_category,
							question.palavra_chave,
							question.img_questao,
							question.grafico,
							question.description
						  ');
		$this->db->from('event');
		
		$this->db->join('questionnaire', 'questionnaire.id_event = event.id_event');
		$this->db->join('question', 'question.id_questionnaire = questionnaire.id_questionnaire');
		
		$this->db->where($where);
		
		$query = $this->db->get();
		
		//echo $this->db->last_query();//die();
		
		//montar um array onde haverá apenas os dados das questões (montar as páginas de cada questão) e o nome do evento,
		//depois montar um array com as respostas dessas questões que irão montar os gráficos
		
		//montando dados das questões
		if($query->num_rows > 0){
			
			//printr($query->result_array());
			
			foreach($query->result_array() as $k=>$v){
				
				$data[$k]['event_name'] 			= $v['event_name'];
				$data[$k]['questionnaire_name'] 	= $v['questionnaire_name'];
				$data[$k]['question_name'] 			= $v['palavra_chave'];
				$data[$k]['img_questao'] 			= $v['img_questao'];
				$data[$k]['grafico'] 				= $v['grafico'];
				$data[$k]['description'] 			= $v['description'];
				
				////pegando as respostas dos users
				//
				//$this->db->select('answer.description');
				//$this->db->from('answer_respondent');
				//$this->db->join('answer', 'answer.id_answer = answer_respondent.answer_id');
				//$this->db->where(array('id_question'=> $v['id_question']));
				//
				//$query = $this->db->get();
				//echo $this->db->last_query();die();
				
				
			}
			
			//printr($data);
			
			return $data;
			
		}
		
		return false;
		
		
		
		
		
		//vai ter que ter o nome do evento
		// vai ter que ter o nome do gráfico (palavra chave)
	}
}