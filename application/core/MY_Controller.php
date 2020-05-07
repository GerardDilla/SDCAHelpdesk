<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $template = array();
    public $data = array();
    public $middle = '';

	function __construct() {

        parent::__construct();
        
    }
	

    public function render($middleParam = '')
    {

        if ($middleParam == '')
        {
            $middleParam = $this->middle;
        }
        $this->template['header'] = $this->load->view('Header.php', $this->data, true);
        $this->template['middle'] = $this->load->view($middleParam, $this->data, true);
        $this->template['footer'] = $this->load->view('Footer.php', $this->data, true);
        $this->load->view('Layout', $this->template);

    }

		

	
	
	
	
	
}
?>