<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Surveys extends REST_Controller implements SkipAuth
{
	function __construct()
	{
		parent::__construct();
	}
	
	function questionnaire_get(){
		$this->questionnaire();
	}
	
	function questionnaire_post(){
		$this->questionnaire();
	}
	
	function questionnaire()
	{
		$this->load->model('User_model', 'u');
		$this->load->model('Questionnaire_model', 'q');
		
		$login = $this->get('login');
		$password = $this->get('password');
		$action = $this->get('action');
	
		$user = $this->u->get_by_login($login, $password);
		
		if(empty($user))
		{
			$this->response(array('status' => false, 'error' => 'Permission denied'), 200);
		}
		else
		{
			switch( strtolower($action))
			{
				case 'download':
					$questionnaires = $this->q->get_available($user->id_user);
					$this->response(array('status' => true, 'questionnaires' => $questionnaires));
				break;

				case 'upload':

					$errors = array();
					$registrations = json_decode($this->post('registrations'));
				
					foreach($registrations as $r)
					{
						$errors_tmp = $this->check_registration($r);

						if(count($errors)>0){
							break;
						}

						if(!empty($r->answers)){
							foreach($r->answers as $a)
							{
								if(empty($a->id_answer))
								{
									$tmp = $this->q->get_question_by_id($a->id_question);
									
									if(empty($a->description))
									{
										$errors[] = "Empty answer!";
									}
									elseif(empty($tmp) || $tmp->id_type != 3)
									{
										$errors[] = "Invalid question! - id_question=" . $a->id_question;
									}
								}
								else
								{	
									$answer = $this->q->is_valid_answer($a->id_question, $a->id_answer);
									if(empty($answer))
									{
										$errors[] = "Invalid id_answer! - id_question=" . $a->id_question . " id_answer=" . $a->id_answer;
									}
								}
							}
						}
						$errors = array_merge($errors, $errors_tmp);
					}
					
					if(count($errors)==0)
					{
						$this->response(array('status' => true), 200);
					} 
					else
					{
						$this->response(array('status' => false, 'errors' => $errors), 200);
					}
				break;

				default : $this->response(array('status' => false, 'error' => 'Invalid action'), 200);
			}
		
			$this->response(array(), 200);
		}
	}

	function check_registration($r)
	{
		$errors = array();
		
		if(empty($r->name))
			$errors[] = 'Invalid name';
			
		if(empty($r->last_name))
			$errors[] = 'Invalid last name';
			
		if(empty($r->birthdate))
			$errors[] = 'Invalid birthdate';
			
		if(empty($r->gender) || ($r->gender!='male' && $r->gender!='female'))
			$errors[] = 'Invalid gender';
			
		if(empty($r->email))
			$errors[] = 'Invalid email';
			
		if(empty($r->marital_status))
			$errors[] = 'Invalid marital status';
			
		if(empty($r->rg))
			$errors[] = 'Invalid RG';
			
		if(empty($r->cpf))
			$errors[] = 'Invalid CPF';
			
		if(empty($r->home_street))
			$errors[] = 'Invalid home street';
			
		if(empty($r->home_number))
			$errors[] = 'Invalid home number';
			
		if(empty($r->home_state))
			$errors[] = 'Invalid home state';
			
		if(empty($r->home_city))
			$errors[] = 'Invalid home city';
			
		if(empty($r->home_neighborhood))
			$errors[] = 'Invalid home neighborhood';
			
		if(empty($r->home_country))
			$errors[] = 'Invalid home country';
			
		if(empty($r->home_city))
			$errors[] = 'Invalid home city';
			
		if(empty($r->home_postal_code))
			$errors[] = 'Invalid home postal code';
			
			
		return $errors;
	}
}

