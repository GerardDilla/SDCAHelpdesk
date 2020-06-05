<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

    function __construct() 
    {

		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, OPTIONS');
		header('Access-Control-Request-Headers: Content-Type');

		parent::__construct();
		$this->inquiry_choices = array(

			'Admission' => 'hedadmission@sdca.edu.ph',
			'Admission_BED' => 'bedadmission@sdca.edu.ph',
			'Admission_SHS' => 'shsadmission@sdca.edu.ph',

			'Grade_Registrar' => 'registrar@sdca.edu.ph',
			'Grade_BED' => 'academicaffairs@sdca.edu.ph',
			'Grade_SHS' => 'shsinquiry@sdca.edu.ph',

			'Other_HED' => 'hedadmission@sdca.edu.ph',
			'Other_BED' => 'bedinquiry@sdca.edu.ph',
			'Other_SHS' => 'shsinquiry@sdca.edu.ph',
			
			'Finance' => array(
				'main' => 'accounting@sdca.edu.ph',
				'cc' => 'treasuryoffice@sdca.edu.ph'
			),

			'Documents' => 'registrar@sdca.edu.ph',
		);
		$this->load->library('email');
		$this->load->model('Programs');
		$this->load->model('TrackingCode');
		$this->inputs = array();
		$this->message = array(
			'primary' => '',
			'secondary' => '',
		);
		date_default_timezone_set('Asia/Manila');
		//echo date("Y-m-d H:i:s");
	}
	public function index(){

		$this->render('Form');

	}
	public function Done(){

		$this->render('MessagePage');

	}
	public function Inquire(){

		$this->form_validation->set_rules('fullname', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('contactnumber', 'Contact Number', 'required');
		$this->form_validation->set_rules('studentoption', 'Student Education Level', 'required',
			array('required' => 'You must choose whether the concern is about an enrolled student')
		);
		$option = $this->input->post('studentoption');
		if($option == 1){
			$this->form_validation->set_rules('studentlevel', 'Student Level', 'required');
			$this->form_validation->set_rules('studentnumber', 'Student Number', 'required');
			$studentlevel = $this->input->post('studentlevel');
			if($studentlevel == 2){
				$this->form_validation->set_rules('studentstrand', 'Student Strand', 'required');
			}
			if($studentlevel == 1){
				$this->form_validation->set_rules('studentdepartment', 'Student Department', 'required');
				$this->form_validation->set_rules('studentprogram', 'Student Program', 'required');
			}
		}

		$this->form_validation->set_rules('concern[]', 'Concern Type', 'required');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('inquiry', 'Inquiry', 'required');

		if($this->form_validation->run() == TRUE){

			//Compile inputs
			$this->inputs['name'] = $this->input->post('fullname');
			$this->inputs['email'] = $this->input->post('email');
			$this->inputs['contactnumber'] = $this->input->post('contactnumber');
			$this->inputs['studentoption'] = $this->input->post('studentoption');
			$this->inputs['studentlevel'] = $this->input->post('studentlevel');
			$this->inputs['studenteducation'] = $this->getLevel($this->inputs['studentlevel']);
			$this->inputs['studentnumber'] = $this->inputs['studentoption'] == 1 ? $this->input->post('studentnumber') : 'N/A';
			$this->inputs['studentstrand'] = $this->inputs['studentlevel'] == 2 ? $this->input->post('studentstrand') : 0;
			$this->inputs['studentprogram'] = $this->inputs['studentlevel'] == 1 ? $this->input->post('studentprogram') : 0;
			$this->inputs['studentprogram_name'] = $this->getProgram($this->inputs['studentprogram']);
			$this->inputs['studentdepartment'] = $this->inputs['studentoption'] == 1 && $this->inputs['studentlevel'] == 1 ? $this->input->post('studentdepartment') : 0;
			$this->inputs['subject'] = $this->input->post('subject');
			$this->inputs['inquiry'] = $this->input->post('inquiry');
			$this->inputs['concern'] = $this->input->post('concern')[0];
			$emails = $this->filterEmailConcerned($this->inputs);
			$this->inputs['concernEmail'] = $emails['Main'];
			$this->inputs['concernEmail_cc'] = $emails['CC'];
			$this->inputs['TrackingCode'] = $this->TrackingCode();
			$this->inputs['ResolveLink'] = base_url().'index.php/Main/Resolve/'.$this->inputs['TrackingCode'];
			
			//Save to database 
			$this->inputs['inquiryID'] = $this->SaveInquiry($this->inputs);
			if(!$this->inputs['inquiryID']){

				$this->message['secondary'] = 'Failed to send inquiry, please try again';
				$this->message['toggle'] = 'form';
				$this->session->set_flashdata('Message',$this->message);
				redirect('Main/Done');

			}

			//Email to concerned
			//Enable mailing when implementing
			$this->inputs['mailStatus'] = $this->SendinquirynMail($this->inputs);

			if($this->inputs['mailStatus'] == 1){

				//Remvoe debug message when implementing
				$this->message['primary'] = 'THANK YOU FOR SUBMITTING YOUR INQUIRY';
				$this->message['secondary'] = 'We\'re glad to hear form you! We\'ll reply through the email address you sent us';
				$this->message['toggle'] = 'form';
				$this->session->set_flashdata('Message',$this->message);

			}else{
				
				$this->message['secondary'] = 'Failed to send inquiry, please try again';
				$this->message['toggle'] = 'form';
				$this->session->set_flashdata('Message',$this->message);
			}

			//Update Status of inquiry
			$this->UpdateInquiry($this->inputs);
			
			//echo json_encode($this->inputs);
			redirect('Main/Done');

		}else{
			$this->message['secondary'] = validation_errors();
			$this->message['toggle'] = 'form';
			$this->session->set_flashdata('Message',$this->message);
			redirect('Main/Done');
		}


	}
	private function filterEmailConcerned($inputs = array()){


		$returndata = array(
			'Main' => '',
			'CC' => '',
		);
		if($inputs['concern'] != 5){
			$inputs['studentprogram'] = 0;
		}
		if($inputs['concern'] == 2){
			$inputs['studentlevel'] = 0;
		}
		if($inputs['concern'] == 4){
			$inputs['studentlevel'] = 0;
		}
		if($inputs['concern'] == 6){
			$inputs['studentlevel'] = 0;
		}

		$main_email = $this->Programs->getEmailMain($inputs);
		$cc_email = $this->Programs->getEmailCC($inputs);
		if($main_email){
			$returndata['Main'] = $main_email[0]['Email'];
		}
		if($cc_email){
			$returndata['CC'] = $cc_email[0]['Email'];
		}
		return $returndata;
	}
	private function SendinquirynMail($inputs){

		$mail_status = 1;
		//Using SMTP2GO // For local use

		//Server's SMTP config
		$config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'webmailer@sdca.edu.ph';
        //$config['smtp_pass']    = 'dgojehpfiftlzoqy';
		$config['smtp_pass']    = 'sdca2017';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html or text
		$config['validation'] = TRUE; // bool whether to validate email or not     
		
		$studentStrand = $inputs['studentstrand'] != '' ? "<b>Student Strand: </b>".$inputs['studentstrand'] : "";

		$this->email->initialize($config);

		$this->email->set_newline("\r\n");
		
		$this->email->from('webmailer@sdca.edu.ph', 'St. Dominic College of Asia');
		
		$this->email->to($inputs['concernEmail']); 
		if($inputs['concernEmail_cc'] != ''){
			$this->email->cc($inputs['concernEmail_cc']);
		}
		
		
		/* below are the test emails For testing*/
		/*
		//$this->email->to('jcjamir@sdca.edu.ph');
		//$this->email->to('gpdilla@sdca.edu.ph');
		if($inputs['concernEmail_cc'] != ''){
			$this->email->cc('gerarddilla@gmail.com');
		}
		*/
		
		$this->email->subject($inputs['subject']);
		/*
		$this->email->message('<br>
			<b>Inquirer\'s Name:</b> '.$inputs['name'].'<br>
			<b>Inquirer\'s Email:</b> '.$inputs['email'].'<br>
			<b>Inquirer\'s Contact Number:</b> '.$inputs['contactnumber'].'<br>
			<b>Tracking Code:</b> '.$inputs['TrackingCode'].'<br>
			<hr>
			<b>Student Number / Reference Number:</b> '.$inputs['studentnumber'].'<br>
			<b>Student Education Level:</b> '.$inputs['studenteducation'].'<br>
			'.$studentStrand.'
			<hr>
			<b>Inquiry:</b><br>'.$inputs['inquiry'].'<br>
			<hr>
			<a target="_blank" href="'.base_url().'index.php/Main/Resolve/'.$inputs['TrackingCode'].'">Mark as Resolved</a>
			<i>Dont reply on this email, thank you.</i>
		');
		*/
		$this->email->message($this->load->view('EmailFormat',$inputs,true));
		
		if(!$this->email->send())
		{
			$mail_status == 0;
		}
		//echo $this->email->print_debugger(array('headers'));
		return $mail_status;
		//---Uncomment code below to debug---
		

	}
	public function getDepartments(){
		
		$result = $this->Programs->DepartmentList();
		echo json_encode($result);
	}
	public function getPrograms(){
		
		$School_ID = $this->input->post('school_id');
		$result = $this->Programs->ProgramList($School_ID);
		echo json_encode($result);
	}
	public function getConcerns(){

		$returndata = array();
		$result = $this->Programs->getConcerns();
		foreach($result as $data){
			$returndata[$data['Topic']] = array(
				'ID' => $data['ID'],
				'Name' => $data['Topic'],
				'Icon' => $data['Icon'],
			);
		}
		echo json_encode($returndata);

	}
	public function getLevel($id = 0){

		$result = $this->Programs->getEducationLevel($id);
		if($result){
			return $result[0]['TopicCategory'];
		}else{
			return 'N/A';
		}

	}
	private function getProgram($program = 0){

		$result = $this->Programs->getProgramData($program);
		if($result){
			return $result[0]['Program_Name'];
		}else{
			return '';
		}

	}
	private function SaveInquiry($inputs){

		$insert = array(
			'InquirerName' => $inputs['name'],
			'InquirerEmail' => $inputs['email'],
			'ContactNumber' => $inputs['contactnumber'],
			'StudentNumber' => $inputs['studentnumber'],
			'StudentLevel' => $inputs['studentlevel'],
			'StudentDepartment' => $inputs['studentdepartment'],
			'StudentStrand' => $inputs['studentstrand'],
			'StudentProgram' => $inputs['studentprogram'],
			'InquirySubject' => $inputs['concern'],
			'Inquiry' => $inputs['inquiry'],
			'DateSubmitted' => date("Y-m-d H:i:s"),
			'TrackingCode' => $inputs['TrackingCode'],
			'Recipient' => $inputs['concernEmail'],
		);

		return $this->Programs->InsertInquiry($insert);

	}
	private function TrackingCode($limit = 15){

		$draft = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit));
		$result = $this->TrackingCode->searchTrackingCode($draft);
		if($result->num_rows() == 0){
			//$draft = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit));
			return $draft;

		}else{

			$available = 0;
			while($available == 0){

				$draft = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit));
				$result = $this->TrackingCode->searchTrackingCode($draft);
				if($result->num_rows() == 0){
					//$draft = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit));
					return $draft;
					$available = 1;

				}

			}

		}

		
		
	}
	private function UpdateInquiry($inputs){

		$update = array();

		if($inputs['mailStatus'] == 1){

			$update['Status'] = 'Successfully Sent to: '.$inputs['concernEmail'];
			if($inputs['concernEmail_cc'] != ''){
				$update['Status'] .= ' with '.$inputs['concernEmail_cc'].' as CC';
			}

		}else{

			$update['Status'] = 'Failed Sending to: '.$inputs['concernEmail'];
			if($inputs['concernEmail_cc'] != ''){
				$update['Status'] .= ' with '.$inputs['concernEmail_cc'].' as CC';
			}
		}

		return $this->Programs->UpdateInquiry($inputs['inquiryID'],$update);

	}
	public function Resolve($TrackerCode = ''){

		$result = $this->TrackingCode->verifyTrackingCode($TrackerCode);
		if($result > 0){

			$this->message['primary'] = 'This inquiry has already been resolved.';
			$this->message['secondary'] = '';
			$this->message['toggle'] = 'close';
			$this->session->set_flashdata('Message',$this->message);
			$this->render('MessagePage');

		}else{

			$input = array(
				'Resolved' => 1
			);
			$status = $this->TrackingCode->resolveInquiry($TrackerCode,$input);
			if($status == TRUE){

				$this->message['primary'] = 'Successfuly Resolved the inquiry, Thank you!';
				$this->message['secondary'] = '';
				$this->message['toggle'] = 'close';
				$this->session->set_flashdata('Message',$this->message);
				$this->render('MessagePage');

			}else{

				$this->message['primary'] = 'An Error occured while trying to resolve the inquiry, please try again';
				$this->message['secondary'] = '';
				$this->message['toggle'] = 'close';
				$this->session->set_flashdata('Message',$this->message);
				$this->render('MessagePage');

			}

		}

	}

}
