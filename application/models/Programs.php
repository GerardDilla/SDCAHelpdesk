<?php


class Programs extends CI_Model{
	

	// STUDENT
	public function ProgramList($School_ID)
	{	
		
		$this->db->where('P.School_ID',$School_ID);
		$this->db->join('Programs as P','H.Program = P.Program_ID');
		$result = $this->db->get('helpdeskprogram_choices as H');
		return $result->result_array();
	
	}
	public function DepartmentList(){

		$this->db->where('School_ID <>',0);
		$result = $this->db->get('School_Info');
		return $result->result_array();

	}
	public function getConcerns(){

		$result = $this->db->get('helpdesktopic');
		return $result->result_array();

	}
	public function getEmailMain($input){

		$this->db->where('Topic_ID',$input['concern']);
		$this->db->where('Category_ID',$input['studentlevel']);
		$this->db->where('Program_ID',$input['studentprogram']);
		$this->db->where('Type','Main');
		$this->db->where('valid',1);
		$this->db->limit(1);
		$result = $this->db->get('helpdeskemails');
		return $result->result_array();

	}
	public function getEmailCC($input){

		$this->db->where('Topic_ID',$input['concern']);
		$this->db->where('Category_ID',$input['studentlevel']);
		$this->db->where('Program_ID',$input['studentprogram']);
		$this->db->where('Type','CC');
		$this->db->where('valid',1);
		$this->db->limit(1);
		$result = $this->db->get('helpdeskemails');
		return $result->result_array();

	}

	


}
?>