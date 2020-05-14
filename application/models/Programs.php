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

	


}
?>