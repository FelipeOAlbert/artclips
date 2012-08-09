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
        $man    = 0;
        $woman  = 0;
        $data   = array();
        $age_18_25 = 0;
        $age_26_32 = 0;
        $age_33_40 = 0;
        $age_41_50 = 0;
        $age_51_plus = 0;
        
        $age = '';
        
        $this->db->select('user.name, user_detail.gender, user_detail.birth_date, user_profile.id_profile');
        $this->db->from('user');
        $this->db->join('user_detail', 'user_detail.id_user = user.id_user');
        $this->db->join('user_profile', 'user_profile.id_user = user.id_user');
        $this->db->where(array('user_profile.id_profile' => 2));
        $query = $this->db->get();
        
        //echo $this->db->last_query();
        
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
                    
                    if($age >= 26 && $age <= 32){
                        $age_18_25++;
                    }
                    
                    if($age >= 18 && $age <= 25){
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
    
}