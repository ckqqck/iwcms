<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Mobile extends CI_Controller {
	function __construct() {
		parent::__construct ();
	}
	function index() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/index.html");
		$this->load->view("mobile/footer.html");
	}
	function department() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/department.html");
		$this->load->view("mobile/footer.html");
	}
	function department2() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/department2.html");
		$this->load->view("mobile/footer.html");
	}
	function doctor() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/doctor.html");
		$this->load->view("mobile/footer.html");
	}
	function gallery() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/gallery.html");
		$this->load->view("mobile/footer.html");
	}
	
	function shop() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/shop.html");
		$this->load->view("mobile/footer.html");
	}
	function product_details() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/shop-product_details.html");
		$this->load->view("mobile/footer.html");
	}
	function shopping_cart() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/shopping-cart.html");
		$this->load->view("mobile/footer.html");
	}
	function checkout() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/shop-checkout.html");
		$this->load->view("mobile/footer.html");
	}
	function blog() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/blog.html");
		$this->load->view("mobile/footer.html");
	}
	function blog_single() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/blog_single.html");
		$this->load->view("mobile/footer.html");
	}
	function faq() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/faq.html");
		$this->load->view("mobile/footer.html");
	}
	function footer() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/footer_nav.html");
		$this->load->view("mobile/footer.html");
	}
	function w404() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/w404.html");
		$this->load->view("mobile/footer.html");
	}
	function testimonial() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/testimonial.html");
		$this->load->view("mobile/footer.html");
	}
	function pricing() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/pricing.html");
		$this->load->view("mobile/footer.html");
	}
	function contact() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/contact.html");
		$this->load->view("mobile/footer.html");
	}
	function login() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/login.html");
		$this->load->view("mobile/footer.html");
	}
	function register() {
		$this->load->view("mobile/header.html");
		$this->load->view("mobile/register.html");
		$this->load->view("mobile/footer.html");
	}

}