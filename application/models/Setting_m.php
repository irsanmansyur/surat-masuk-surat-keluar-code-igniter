<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting_m extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function get()
	{
		return $this->db->get("setting");
	}
}

/* End of file login_model.php */
/* Location: ./application/models/login_model.php */