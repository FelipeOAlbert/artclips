<?php 
class Md_mosaico extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
 	function Md_mosaico()
    {
        parent::__construct();
    }
    
    private function valid_id_mosaico($id){
    	$get = $this->db->query("SELECT id FROM tb_mosaico WHERE id=".$id." LIMIT 1");
    	if ($get->num_rows() > 0){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    public function get_info($id){
    	if($this->valid_id_mosaico($id)){
    		$dados = $this->db->query("SELECT * FROM tb_mosaico WHERE id=".$id);
    		return $dados->row_array();
    	}else{
    		return false;
    	}
    }
}
?>