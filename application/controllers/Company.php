<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->helper ( 'url' );
	}
	public function index()
	{
		$this->load->view('index/header.html');
		$this->load->view('index/index.html');
		$this->load->view('index/footer.html');
	}
	public function portfolio()
	{
		$this->load->view('index/header.html');
		$this->load->view('index/portfolio.html');
		$this->load->view('index/footer.html');
	}
	public function portfolio2()
	{
		$this->load->view('index/header.html');
		$this->load->view('index/portfolio2.html');
		$this->load->view('index/footer.html');
	}
	public function pricing_table()
	{
		$this->load->view('index/header.html');
		$this->load->view('index/pricing-table.html');
		$this->load->view('index/footer.html');
	}
	public function progress()
	{
		$this->load->view('index/header.html');
		$this->load->view('index/progress.html');
		$this->load->view('index/footer.html');
	}
	public function contact()
	{
		$this->load->view('index/header.html');
		$this->load->view('index/contact.html');
		$this->load->view('index/footer.html');
	}
}
