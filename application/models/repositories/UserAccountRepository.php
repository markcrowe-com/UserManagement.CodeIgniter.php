<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Repository provides MySQL CRUD functionality for User Accounts
 */
class UserAccountRepository extends CI_Model
{
	function __construct()
	{
		$this->load->database();
		$this->load->model("schema/UserAccessWebExampleSchema");
		$this->load->model("schema/UserAccountSchema");//, null, "schema");
	}
	public function addUserAccount($userAccountValueArray)
	{
		$this->db->insert($this->UserAccessWebExampleSchema->UserAccount, $userAccountValueArray);
		return $this->db->affected_rows() == 1;
	}
	public function createPasswordHash($plainTextPassword)
	{
		return hash($this->schema->Password_Hash, $plainTextPassword);
	}
	public function deleteUserAccountById($userAccountId)
	{
		$this->db->where($this->UserAccountSchema->Id, $userAccountId);
		return $this->db->delete($this->UserManagementDatabaseSchema->UserAccount);
	}
	public function getUserAccountById($userAccountId)
	{
		$query = $this->db->get_where(
			$this->UserAccessWebExampleSchema->UserAccount,
			array($this->UserAccountSchema->Id => $userAccountId)
		);
		return $query->row();
	}
	public function getUserAccountByCredentials($username, $password)
	{
		$parameters = array(
			$this->UserAccountSchema->Username => $username,
			$this->UserAccountSchema->Password => $this->createPasswordHash($password)
		);
		//$password = $this->createPasswordHash($password);
		//$parameters = array( $username, $password);
		$query = $this->db->get_where($this->UserAccessWebExampleSchema->UserAccount, $parameters);
		return $query->row();
	}
	public function getUserAccounts()
	{
		$query = $this->db->get($this->UserAccessWebExampleSchema->UserAccount);
		return $query->result();
	}
	public function updateUserAccount($userAccountValueArray)
	{
		$this->db->where($this->UserAccountSchema->Id, $userAccountValueArray[$this->UserAccountSchema->Id]);
		return $this->db->update($this->UserAccessWebExampleSchema->UserAccount, $userAccountValueArray);
	}
}