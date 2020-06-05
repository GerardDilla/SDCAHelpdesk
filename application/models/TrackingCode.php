<?php


class TrackingCode extends CI_Model{
	

	// STUDENT
	public function searchTrackingCode($Code)
	{	
		
		$this->db->where('TrackingCode',$Code);
		$result = $this->db->get('helpdeskinquiries');
		return $result;
	
	}
	public function verifyTrackingCode($Code)
	{	
		
		$this->db->where('TrackingCode',$Code);
		$this->db->where('Resolved',1);
		$result = $this->db->get('helpdeskinquiries');
		return $result->num_rows();
	
	}
	public function resolveInquiry($code,$input)
	{	
		$this->db->trans_start();
		$this->db->where('TrackingCode',$code);
		$this->db->update('helpdeskinquiries',$input);
		$this->db->trans_complete();
		return $this->db->trans_status();
		
	
	}
	
	


}
?>