<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Model
{
	public function signup($arr)
	{	
		$this->db->trans_start();
		$this->db->insert('users', $arr);
		$insert_id = $this->db->insert_id();
		$trans['amount'] = 100;
		$trans['sender_upi_id'] = 'Singup Bonus';
		$trans['receiver_id'] = $insert_id;
		$this->db->insert('trasanctions', $trans);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return true;
		}
	}

	public function userDetails()
	{
		$id = $this->session->userdata('user')->id;
		return $this->db->select('amount,email,id,created_at,name,upi_id')->where('id', $id)->get('users')->first_row();
	}

	public function getTransaction()
	{
		$id = $this->session->userdata('user')->id;
		$result = $this->db->query("select * from (SELECT users.name, trasanctions.* from trasanctions INNER join users on trasanctions.receiver_id = users.id where trasanctions.receiver_id = '$id' UNION SELECT users.name, trasanctions.* from trasanctions INNER join users on trasanctions.sender_id = users.id where trasanctions.sender_id = '$id') tmp order by tmp.created_at desc");
		return $result->result();
	}

	public function loginAction($arr)
	{
		$this->db->where("email", $arr['email']);
		$this->db->where("password", $arr['password']);
		$result = $this->db->get('users')->first_row();
		if ($result) {
			return $result;
		} else {
			return false;
		}
	}

	public function getUPI($arr)
	{
		return $this->db->select('name')->where('upi_id', $arr['upi'])->get('users')->first_row();
	}

	public function transferAmount($arr)
	{
		$id = $this->session->userdata('user')->id;
		$sender = $this->db->select('amount, upi_id')->where('id', $id)->get('users')->first_row();
		$upi = $this->db->select('id')->where('upi_id', $arr['upi'])->get('users')->first_row();
		if (!empty($upi) && $upi->id != $id) {
			if ($sender->amount >= $arr['amount']) {
				$insert['sender_id'] = $id;
				$insert['receiver_id'] = $upi->id;
				$insert['sender_upi_id'] = $sender->upi_id;
				$insert['amount'] = $arr['amount'];
				$insert['receiver_upi_id'] = $arr['upi'];
				$amount = $arr['amount'];
				$this->db->trans_start();
				$this->db->insert('trasanctions', $insert);
				$this->db->query("update users set amount = (amount-$amount) where id = '$id'");
				$this->db->query("update users set amount = (amount+$amount) where id = '$upi->id'");
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					return ['status' => true, 'message' => 'Successfully transfer..'];
				} else {
					$this->db->trans_commit();
					return ['status' => false, 'message' => 'Something Wrong..'];
				}
			} else {
				return ['status' => false, 'message' => 'Low balance..'];
			}
		} else {
			return ['status' => false, 'message' => 'You can not transfer yourself on UPI ID'];
		}
	}
}