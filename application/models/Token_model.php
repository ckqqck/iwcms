<?php
class Token_model extends CI_model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

 	function openid_exist($openid){
 		$this->db->where('openid', $openid);
		$query = $this->db->get('tbl_users');
 		return $query->num_rows();
 	}
 	function openid_select($openid){
 		$this->db->where('openid', $openid);
 		$query = $this->db->get('tbl_users');
 		return $query->result_array();
 	}
 	function openid_insert($data){

		$this->db->insert('tbl_users', $data);

		return $this->db->insert_id() ? $this->db->insert_id () : FALSE;
    }
 	function openid_update($where,$data){
		$this->db->update('tbl_users', $data, $where);
 	}


	function set($cachename,$data)
	{
		$this->db->where('cachename', $cachename);
		$query = $this->db->get('weixin_token');
		//echo $query->num_rows();
		//print_r($query);
		if($query->num_rows() < 1){
			$data = array_merge_recursive(array('cachename' => $cachename), $data);
			//$data['id'] = "1";
			$this->db->insert('weixin_token', $data);
		}else{

			$this->db->where('cachename', $cachename);
			$this->db->update('weixin_token', $data);
		}
	}
	function get($cachename)
	{
		$this->db->where('cachename', $cachename);
		$query = $this->db->get('weixin_token');
		return $query->result_array();
	}
	function remove($cachename)
	{
		$this->db->where('cachename', $cachename);
		$this->db->delete('weixin_token');
	}
}
