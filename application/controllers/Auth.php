<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * @author : Himanshu verma
	 * Auth controller.
	 *
	 */
	public function index()
	{
		$this->load->view('auth');
	}

	public function signupAction()
	{
		$this->form_validation->set_rules('name', 'name', 'required|trim');
		$this->form_validation->set_rules('email', 'email', 'required|trim|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'password', 'required|min_length[6]|trim');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'status_code' => 422, 'message' => $this->form_validation->error_array()]);
		} else {
			$arr['name'] = ucfirst($this->input->post('name', true));
			$arr['email'] = $this->input->post('email', true);
			$arr['password'] = md5($this->input->post('password', true));
			$arr['amount'] = 100;
			$arr['upi_id'] = $arr['email'];
			$result = $this->User->signup($arr);
			if ($result) {
				echo  json_encode(['status' => 'success', 'status_code' => 200, 'message' => "Successfully Signup.."]);
			} else {
				echo  json_encode(['status' => 'success', 'status_code' => 200, 'message' => "Something wrong.."]);
			}
		}
		
	}

	public function loginAction()
	{
		$this->form_validation->set_rules('email', 'email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'password', 'required|trim');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'status_code' => 422, 'message' => $this->form_validation->error_array()]);
		} else {
			$arr['email'] = $this->input->post('email', true);
			$arr['password'] = md5($this->input->post('password', true)); 
			$result = $this->User->loginAction($arr);
			if ($result !== false) {
				$this->session->set_userdata('user', $result);
				echo  json_encode(['status' => 'success', 'status_code' => 200, 'message' => "Login Successfully..."]);
			} else {
				echo  json_encode(['status' => 'success', 'status_code' => 401, 'message' => "<span style='color:red'>Invalid details...</span>"]);
			}
		}

	}

	public function logout()
	{
		$this->session->unset_userdata('user');
		redirect(base_url());
	}
}
