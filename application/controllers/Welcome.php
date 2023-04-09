<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller 
{


	public function __construct()
    {

        parent::__construct();

        if ($this->session->userdata('user') == false)
        {
            redirect(base_url());
        }

    }

	public function index()
	{
		$this->load->view('home');
	}

	public function userDetails()
	{
		$result = $this->User->userDetails();
		if (!empty($result)) {
			echo  json_encode(['status' => 'success', 'status_code' => 200, 'message' => 'success', 'data' => $result]);
		} else {
			echo  json_encode(['status' => 'error', 'status_code' => 422, 'message' => "Something Wrong", 'data' => []]);
		}
	}

	public function getTransaction()
	{
		$result = $this->User->getTransaction();
		if (count($result) > 0) {
			echo  json_encode(['status' => 'success', 'status_code' => 200, 'message' => 'success', 'data' => $result]);
		} else {
			echo  json_encode(['status' => 'error', 'status_code' => 422, 'message' => "Something Wrong", 'data' => []]);
		}
	}

	public function getUPI()
	{
		$arr['upi'] = $this->input->post('upi', true);
		$result = $this->User->getUPI($arr);
		if (!empty($result)) {
			echo  json_encode(['status' => 'success', 'status_code' => 200, 'message' => 'success', 'data' => $result]);
		} else {
			echo  json_encode(['status' => 'error', 'status_code' => 422, 'message' => "Unknown UPI", 'data' => []]);
		}
	}

	public function transferAmount()
	{
		$this->form_validation->set_rules('upi', 'upi', 'required|trim');
		$this->form_validation->set_rules('amount', 'amount', 'required|trim');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'status_code' => 422, 'message' => "UPI ID and Amount is required.."]);
		} else {
			$arr['upi'] = $this->input->post('upi', true);
			$arr['amount'] = $this->input->post('amount', true);
			$result = $this->User->transferAmount($arr);
			if ($result['status'] === true) {
				echo  json_encode(['status' => 'success', 'status_code' => 200, 'message' => $result['message']]);
			} else {
				echo  json_encode(['status' => 'success', 'status_code' => 422, 'message' => $result['message']]);
			}
		}
	}

}
