<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('print_ag')){	
	function print_ag($data)
	{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die();
	}
}

function permission(){
	$CI =& get_instance();
    if (!$CI->session->userdata('user_login') && current_url() != base_url('auth')){
    	redirect('auth', 'refresh');
    }
    // else{
    // 	redirect(base_url(), 'refresh');
    // }
    return true;
}

if (!function_exists('sessUser')){	
	function sessUser()
	{
		$CI =& get_instance();
		return $CI->session->userdata('user_login');
		// return 'PERSYSH';
	}
}

if (!function_exists('sessGroup')){	
	function sessGroup()
	{
		$CI =& get_instance();
		return getValue('group_code', 'person', array('user_login'=>'where/'.sessUser()));
		// return 'PERSYSH';
	}
}

function getActiveEmp(){
	$CI =& get_instance();
	return $CI->db->where('dt_rsign', NULL, FALSE)->get('m_emp')->result();
}

function assets_url($data = null)
{
	return base_url('assets/'.$data);
}

function insertAll($table,$data) {
	$CI =& get_instance();
	$CI->load->database('default',TRUE);
	if(!$CI->db->insert($table,$data))
		return FALSE;
	$data["id"] = $CI->db->insert_id();
	return (object)$data;
}

function getPost(){
	$CI =& get_instance();
	$p = $CI->input->post();
	return $p;
}

function update($table,$data,$column,$where){
	$CI =& get_instance();
	$CI->load->database('default',TRUE);
	$CI->db->where($column,$where);
	return $CI->db->update($table,$data); 
}

if(!function_exists('lq'))
{
	function lq()
	{
		$CI =&get_instance();
		die($CI->db->last_query());
	}
}

if (!function_exists('toDate')){	
	function toDate($date)
	{
		if(!empty($date)){
			return date('Y-m-d', strtotime($date));
		}else{
			return '-';
		}
	}
}

if (!function_exists('toDateTime')){	
	function toDateTime($date)
	{
		return date('Y-m-d H:i', strtotime($date));
	}
}

if (!function_exists('toTime')){	
	function toTime($date)
	{
		if($date == '1970-01-01 07:00:00'){
			return '00:00';
		}
		elseif(!empty($date)){
			return date('H:i', strtotime($date));
		}
		else{
			return '-';
		}
	}
}

if (!function_exists('dateIndo')){	
	function dateIndo($date)
	{
		if($date != '0000-00-00')
			return date('d-M-Y', strtotime($date));
		else
			return '-';
	}
}

if (!function_exists('dateTimeIndo')){	
	function dateTimeIndo($date)
	{
		if($date != '0000-00-00 00:00:00')
			return date('d-M-Y H:i:s', strtotime($date));
		else
			return '-';
	}	
}

if(!function_exists('dateNow')){
	function dateNow()
	{
		return date('Y-m-d H:i:s');
	}
}

function getName($id){
	return getValue('NM_EMP', 'M_EMP', array('NO_EMP'=>'WHERE/'.$id));
}

if (!function_exists('GetValue')){
	function GetValue($field,$table,$filter=array(),$order=NULL)
	{
		$CI =& get_instance();
		$CI->db->select($field);
		foreach($filter as $key=> $value)
		{
			$exp = explode("/",$value);
			if(isset($exp[1]))
			{
				if($exp[0] == "where") $CI->db->where($key, $exp[1]);
				else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
				else if($exp[0] == "order") $CI->db->order_by($key, $exp[1]);
				else if($key == "limit") $CI->db->limit($exp[1], $exp[0]);
			}
			
			if($exp[0] == "group") $CI->db->group_by($key);
		}
		
		if($order) $CI->db->order_by($order);
		$q = $CI->db->get($table);
		foreach($q->result_array() as $r)
		{
			return $r[$field];
		}
		return 0;
	}
}

if (!function_exists('getAll')){
	function getAll($tbl,$filter=array(),$filter_where_in=array())
	{
		$CI =& get_instance();
		foreach($filter as $key=> $value)
		{
			// Multiple Like
			if(is_array($value))
			{
				$key = str_replace(" =","",$key);
				$like="";
				$v=0;
				foreach($value as $r=> $s)
				{
					$v++;
					$exp = explode("/",$s);
					if(isset($exp[1]))
					{
						if($exp[0] == "like")
						{
							if($key == "tanggal" || $key == "tahun")
							{
								$key = "tanggal";
								if(strlen($exp[1]) == 4)
								{
									if($v == 1) $like .= $key." LIKE '%".$exp[1]."-%' ";
									else $like .= " OR ".$key." LIKE '%".$exp[1]."-%' ";
								}
								else 
								{
									if($v == 1) $like .= $key." LIKE '%-".$exp[1]."-%' ";
									else $like .= " OR ".$key." LIKE '%-".$exp[1]."-%' ";
								}
							}
							else
							{
								if($v == 1) $like .= $key." LIKE '%".$exp[1]."%' ";
								else $like .= " OR ".$key." LIKE '%".$exp[1]."%' ";
							}
						}
					}
				}
				if($like) $CI->db->where("id > 0 AND ($like)");
				$exp[0]=$exp[1]="";
			}
			else $exp = explode("/",$value);
			
			if(isset($exp[1]))
			{
				if($exp[0] == "where") $CI->db->where($key, $exp[1]);
				else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
				else if($exp[0] == "or_like") $CI->db->or_like($key, $exp[1]);
				else if($exp[0] == "like_after") $CI->db->like($key, $exp[1], 'after');
				else if($exp[0] == "like_before") $CI->db->like($key, $exp[1], 'before');
				else if($exp[0] == "not_like") $CI->db->not_like($key, $exp[1]);
				else if($exp[0] == "not_like_after") $CI->db->not_like($key, $exp[1], 'after');
				else if($exp[0] == "not_like_before") $CI->db->not_like($key, $exp[1], 'before');
				else if($exp[0] == "wherebetween"){
					$xx=explode(',',$exp[1]);
				 $CI->db->where($key.' >=',$xx[0]);
				 $CI->db->where($key.' <=',$xx[1]);
				}
				else if($exp[0] == "order")
				{
					$key = str_replace("=","",$key);
					$CI->db->order_by($key, $exp[1]);
				}
				else if($key == "limit") $CI->db->limit($exp[1], $exp[0]);
			}
			else if($exp[0] == "where") $CI->db->where($key);
			
			if($exp[0] == "group") $CI->db->group_by($key);
		}
		
		foreach($filter_where_in as $key=> $value)
		{
			if(preg_match("/!=/", $key)) $CI->db->where_not_in(str_replace("!=","",$key), $value);
			else $CI->db->where_in($key, $value);
		}
		
		$q = $CI->db->get($tbl);
		//die($CI->db->last_query());
		
		return $q;
	}
}

if (!function_exists('GetAllSelect')){
	function GetAllSelect($tbl,$select,$filter=array(),$filter_where_in=array())
	{
		$CI =& get_instance();
		$CI->db->select($select);
		foreach($filter as $key=> $value)
		{
			// Multiple Like
			if(is_array($value))
			{
				$key = str_replace(" =","",$key);
				$like="";
				$v=0;
				foreach($value as $r=> $s)
				{
					$v++;
					$exp = explode("/",$s);
					if(isset($exp[1]))
					{
						if($exp[0] == "like")
						{
							if($key == "tanggal" || $key == "tahun")
							{
								$key = "tanggal";
								if(strlen($exp[1]) == 4)
								{
									if($v == 1) $like .= $key." LIKE '%".$exp[1]."-%' ";
									else $like .= " OR ".$key." LIKE '%".$exp[1]."-%' ";
								}
								else 
								{
									if($v == 1) $like .= $key." LIKE '%-".$exp[1]."-%' ";
									else $like .= " OR ".$key." LIKE '%-".$exp[1]."-%' ";
								}
							}
							else
							{
								if($v == 1) $like .= $key." LIKE '%".$exp[1]."%' ";
								else $like .= " OR ".$key." LIKE '%".$exp[1]."%' ";
							}
						}
					}
				}
				if($like) $CI->db->where("id > 0 AND ($like)");
				$exp[0]=$exp[1]="";
			}
			else $exp = explode("/",$value);
			
			if(isset($exp[1]))
			{
				if($exp[0] == "where") $CI->db->where($key, $exp[1]);
				else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
				else if($exp[0] == "like_after") $CI->db->like($key, $exp[1], 'after');
				else if($exp[0] == "like_before") $CI->db->like($key, $exp[1], 'before');
				else if($exp[0] == "not_like") $CI->db->not_like($key, $exp[1]);
				else if($exp[0] == "not_like_after") $CI->db->not_like($key, $exp[1], 'after');
				else if($exp[0] == "not_like_before") $CI->db->not_like($key, $exp[1], 'before');
				else if($exp[0] == "order")
				{
					$key = str_replace("=","",$key);
					$CI->db->order_by($key, $exp[1]);
				}
				else if($key == "limit") $CI->db->limit($exp[1], $exp[0]);
			}
			else if($exp[0] == "where") $CI->db->where($key);
			
			if($exp[0] == "group") $CI->db->group_by($key);
		}
		
		foreach($filter_where_in as $key=> $value)
		{
			$CI->db->where_in($key, $value);
		}
		
		$q = $CI->db->get($tbl);
		//die($CI->db->last_query());
		
		return $q;
	}
}
