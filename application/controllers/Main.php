<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

    public function __construct() 
    {
		parent::__construct();
		$this->inquiry_choices = array(
			'Admission' => 'gpdilla@sdca.edu.ph',
			'Finance' => 'gpdilla@sdca.edu.ph',
			'Grades' => 'gpdilla@sdca.edu.ph',
			'Others' => 'gpdilla@sdca.edu.ph',
		);
		$this->load->library('email');
		$this->inputs = array();
		$this->message = array(
			'primary' => '',
			'secondary' => '',
		);
	}
	public function index()
	{
		$this->render('Form');
	}
	public function Done(){

		$this->render('MessagePage');

	}
	public function Inquire(){

		$this->form_validation->set_rules('fullname', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('studentoption', 'Student Education Level', 'required',
			array('required' => 'You must choose whether the concern is about an enrolled student')
		);
		$option = $this->input->post('studentoption');
		if($option == 1){
			$this->form_validation->set_rules('studentlevel', 'Student Level', 'required');
			$this->form_validation->set_rules('studentnumber', 'Student Number', 'required');
		}
		$this->form_validation->set_rules('concern[]', 'Concern Type', 'required');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('inquiry', 'Inquiry', 'required');

		if($this->form_validation->run() == TRUE){

			//Compile inputs
			$this->inputs['name'] = $this->input->post('fullname');
			$this->inputs['email'] = $this->input->post('email');
			$this->inputs['studentoption'] = $this->input->post('studentoption');
			$this->inputs['studentlevel'] = $this->inputs['studentoption'] == 1 ? $this->input->post('studentlevel') : 'N/A';
			$this->inputs['studentnumber'] = $this->inputs['studentoption'] == 1 ? $this->input->post('studentnumber') : 'N/A';
			$this->inputs['concernEmail'] = $this->inquiry_choices[$this->input->post('concern')[0]];
			$this->inputs['subject'] = $this->input->post('subject');
			$this->inputs['inquiry'] = $this->input->post('inquiry');
			//echo json_encode($this->inputs);
			//Save to database 

			//Email to concerned
			$mailStatus = $this->SendinquirynMail($this->inputs);

			if($mailStatus == 1){

				$this->message['primary'] = 'THANK YOU FOR SUBMITTING YOUR INQUIRY';
				$this->message['secondary'] = 'We\'re glad to hear form you! We\'ll reply through the email address you sent us';
				$this->session->set_flashdata('Message',$this->message);

			}else{
				
				$this->message['secondary'] = 'Failed to send inquiry, please try again';
				$this->session->set_flashdata('Message',$this->message);
			}
			redirect('Main/Done');

		}else{
			$this->message['secondary'] = validation_errors();
			$this->session->set_flashdata('Message',$this->message);
			redirect('Main/Done');
		}


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

		$this->email->initialize($config);

		$this->email->set_newline("\r\n");
	
		
		
		$this->email->from('webmailer@sdca.edu.ph', 'St. Dominic College of Asia');
		$this->email->to($inputs['concernEmail']); 
		$this->email->subject($inputs['subject']);
		$this->email->message('

			<b>Inquirer\'s Name:</b> '.$inputs['name'].'<br>
			<b>Inquirer\'s Email:</b> '.$inputs['email'].'<br>
			<hr>
			<b>Student Number:</b> '.$inputs['studentnumber'].'<br>
			<b>Student Ecducation Level:</b> '.$inputs['studentlevel'].'<br>
			<hr>
			<b>Inquiry:</b> <br> '.$inputs['inquiry'].'<br>
			<hr>
			<i>Dont reply on this email, thank you.</i>
			
		');
		if(!$this->email->send())
		{
			$mail_status == 0;
		}
		//echo $this->email->print_debugger(array('headers'));
		return $mail_status;
		//---Uncomment code below to debug---
		

	}
}
