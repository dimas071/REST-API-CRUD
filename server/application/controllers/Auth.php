<?php defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
use Firebase\JWT\JWT;

class Auth extends MY_Controller {

  private $kunci;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('User_m');
        $this->kunci = $this->config->item('thekey');
    }

    public function login_post()
    {
        $u = $this->post('username');
        $p = sha1($this->post('password'));

        $invalidLogin = ['status' => 'Invalid Login'];

        $q = array('username' => $u);
        $val = $this->User_m->get_user($q)->row();
        if($this->User_m->get_user($q)->num_rows() == 0){
          $this->response($invalidLogin, RestController::HTTP_NOT_FOUND);
        }

        if($p == $val->password){
          if(!empty($val->token)){
            if ($this->is_exp($val->token)){
              $output = array(
                  'status' => 'token expired, let\'s generate a new token'
              );
              $output['token'] = $this->generate_token(['id'=>$val->id, 'username'=>$u]);
              $val = $this->User_m->update_token($val->id, $output['token']);
              if($val)
                $this->set_response($output, RestController::HTTP_OK);

            }else {
              $output = array(
                  'status' => 'token not expired',
                  'token' => $val->token
              );
              $this->set_response($output, RestController::HTTP_OK);
            }
          }else{
            $output = array(
                'status' => 'token empty, let\'s generate a new token'
            );
            $output['token'] = $this->generate_token(['id'=>$val->id, 'username'=>$u]);
            $val = $this->User_m->update_token($val->id, $output['token']);
            if($val)
              $this->set_response($output, RestController::HTTP_OK);
          }
        }
        else {
            $this->set_response($invalidLogin, RestController::HTTP_NOT_FOUND);
        }
    }

    public function token_post()
    {
        $u = $this->post('username');
        $p = sha1($this->post('password'));

        $invalidLogin = ['status' => 'Invalid Login'];

        $q = array('username' => $u);
        $val = $this->User_m->get_user($q)->row();
        if($this->User_m->get_user($q)->num_rows() == 0){
          $this->response($invalidLogin, RestController::HTTP_NOT_FOUND);
        }

        if($p == $val->password){
          if(!empty($val->token)){
            if ($this->is_exp($val->token)){
              $output = ['token' => 'expired'];
              $this->set_response($output, RestController::HTTP_OK);
            } else{
              $output = ['token' => $val->token];
              $this->set_response($output, RestController::HTTP_OK);
            }
          } else{
            $output = ['token' => 'empty'];
            $this->set_response($output, RestController::HTTP_OK);
          }
        } else {
            $this->set_response($invalidLogin, RestController::HTTP_NOT_FOUND);
        }
    }

    private function is_exp($token){
      try {
        $decoded = JWT::decode($token, $this->kunci, array('HS256'));
        return false;
      } catch (Exception $e) {
          if($e->getMessage() === 'Expired token')
            return true;
      }
    }

    private function generate_token($data){
      $token['id'] = $data['id'];
      $token['user'] = $data['username'];
      $date = new DateTime();
      $token['iat'] = $date->getTimestamp();
      //$token['exp'] = $date->getTimestamp() + 60*60*5;
      $token['exp'] = $date->getTimestamp() + 60*60*5;
      return $output['token'] = JWT::encode($token,$this->kunci );
    }
}
