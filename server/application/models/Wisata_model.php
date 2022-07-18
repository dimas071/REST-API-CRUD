<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wisata_model extends CI_Model
{
    //variabel untuk url API
    //var $base_url = "http://localhost/json/rest/";
    var $API = array();

    function __construct()
    {
        parent::__construct();
        /*
        // url API wisata
        $this->API['read'] = $this->base_url."read.php";
        $this->API['read_limit'] = $this->base_url."read_limit.php";
        $this->API['create'] = $this->base_url."create.php";
        $this->API['update'] = $this->base_url."update.php";
        $this->API['delete'] = $this->base_url."delete.php";
        $this->API['total_rows']=$this->base_url."total_rows.php";
        */
        // -- tambahan token
        // endpoint API Rest Wisata dengan codeigniter dan token
        $this->API['read2'] = "http://localhost/json/server/wisata";
        $this->API['read_limit2'] = "http://localhost/json/server/wisata/read_limit";
        $this->API['create2'] = "http://localhost/json/server/wisata";
        $this->API['update2'] = "http://localhost/json/server/wisata";
        $this->API['delete2'] = "http://localhost/json/server/wisata";
        $this->API['total_rows2'] = "http://localhost/json/server/wisata/total_rows";
        $this->API['token'] = "http://localhost/json/server/auth/token";
        // -- akhir tambahan token
    }

    // get all
    function get_all()
    {
        // send request ke API server
        //$send = $this->curl($this->API['read'],"GET");
        $send = $this->curl($this->API['read2'], 1);
        // mengubah JSON menjadi array
        $data = json_decode($send);
        // return nilai
        return $data;
    }

    // get data by id
    function get_by_id($id)
    {
        // get parameter
        $data = array('id' => $id );
        // send request ke API server
        //$send = $this->curl($this->API['read'],"GET", $data);
        $send = $this->curl($this->API['read2'], 1, $data); // akses ke endpoint API Rest Codeigniter
        // mengubah JSON menjadi array
        $data = json_decode($send);
        // return nilai
        return $data[0];
    }

    // get total rows
    function total_rows($q = NULL) {
        // get parameter
        $data = NULL;
        if($q)
            $data = array('q' => $q );
        // send request ke API server
        //$send = $this->curl($this->API['total_rows'],"GET",$data);
        $send = $this->curl($this->API['total_rows2'], 1, $data);
        // mengubah JSON menjadi array
        $data = json_decode($send);
        // return nilai
        return $data->total_rows;
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        // get parameter
        $data = array(
            'limit' => $limit,
            'start' => $start,
            'q' => $q
        );
        // send request ke API server
        //$send = $this->curl($this->API['read_limit'],"GET",$data);
        $send = $this->curl($this->API['read_limit2'], 1, $data);
        // mengubah JSON menjadi array
        $data = json_decode($send);
        // return nilai
        return $data;
    }

    // insert data
    function insert($data)
    {
        // send request ke API server
        //$this->curl($this->API['create'],"POST",$data);
        $send = $this->curl($this->API['create2'], 2, $data);
        // mengubah JSON menjadi array
        $data = json_decode($send);
        // return nilai
        return $data;
    }

    // update data
    function update($id, $data)
    {

        // merge $id and $data
        $data['id'] = $id;
        // send request ke API server
        //$this->curl($this->API['update'],"POST",$data);
        $send = $this->curl($this->API['update2'], 3, $data);
        // mengubah JSON menjadi array
        $data = json_decode($send);
        // return nilai
        return $data;
    }

    // delete data
    function delete($id)
    {
        // get parameter
        $data = array('id' => $id );
        // send request ke API server
        //$this->curl($this->API['delete'],"GET",$data);
        $send = $this->curl($this->API['delete2'], 4, $data);
        // mengubah JSON menjadi array
        $data = json_decode($send);
        // return nilai
        return $data;
    }

    // tambahan token
    function token($user,$pass)
    {
        $data = array(
            'username' => $user,
            'password' => $pass
        );
        // send request ke API server
        $send = $this->curl($this->API['token'], 2, $data);
        $result = json_decode($send);
        // return nilai
        return $result->token;
    }
    // akhir tambahan token

    /* tambahan fungsi curl
    Allow method:
    1 = GET
    2 = POST
    3 = PUT
    4 = DELETE
    */
    function curl($url, $method, $data = NULL){
        // tambahan token
        $token = (isset($_COOKIE['ci_cookies'])) ? $_COOKIE['ci_cookies'] : '';
        $authorization = "Bearer ".$token;
        // akhir tambahan token
        $params = '';
        $ch = curl_init();
        switch($method) {
        	case 1:
          	if($data){
              $params = http_build_query($data);
              curl_setopt($ch, CURLOPT_URL, $url.'?'.$params);
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            }else{
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            }
        		break;
          case 2:
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
              curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          		break;
          case 3:
              $params = http_build_query($data);
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
              curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
              break;
          case 4:
              $params = http_build_query($data);
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
              curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
              break;
        	default:
        		  header("HTTP/1.0 405 Method Not Allowed");
        	    break;
        }
        // tambahan token
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Authorization:' . $authorization
        ));
        // akhir tambahan token
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
      }

	}

/* End of file Wisata_model.php */
/* Location: ./application/models/Wisata_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-04-15 21:32:15 */
/* http://harviacode.com */
