<?php

class Users_model extends CI_Model {
	

	 public function __construct() {
        parent::__construct();   
		$active_language =  $this->session->userdata('language');
    }

	
	public function verify_user($username, $password){
		// NOTE: If we do multiple levels of permissions, it should be retrieved here from the users table. It would then be set in the userdata session.
		$q = $this->db->select('show_prices,user_name AS name ,user_email AS email,user_username AS username,user_id, password, salt')
					  ->where('isValidated',1)
					  ->where('isActive',1)
					  ->where('user_username',$username)
					  ->limit('1')
					  ->get('users');
		if($q->num_rows > 0){
			$user = $q->row();
			if($user->password == $this->encryptPassword($password,$user->salt)){	
				return $q->row();
			}
		}
		return false;
		
				
	}
	
	
	
	public function generateRandomPassword(){
		$pswd = '';
		$Chars_Len = 10;
		$Allowed_Chars ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
		for($i=0; $i<$Chars_Len; $i++){
			$pswd .= $Allowed_Chars[mt_rand(0,strlen($Allowed_Chars)-1)];
		}
		return $pswd;
	}
	
	public function generatePasswordSalt(){
		$Salt_Length = 21;// 18 would be secure as well.
		$Allowed_Chars ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$salt = '';
		for($i=0; $i<$Salt_Length; $i++){
			$salt .= $Allowed_Chars[mt_rand(0,strlen($Allowed_Chars)-1)];
		}
		return $salt;
	}
	
	public function encryptPassword($password,$salt){
		// DETAILS ABOUT THIS FORM OF PASSWORD ENCRYPTION HERE: http://www.gregboggs.com/php-blowfish-random-salted-passwords/
		CRYPT_BLOWFISH or die ('No Blowfish found. (controllers->users_model->encryptPassword)');
		//This string tells crypt to use blowfish for 5 rounds.
		$Blowfish_Pre = '$2a$05$';
		$Blowfish_End = '$';
	
		$bcrypt_salt = $Blowfish_Pre . trim($salt) . $Blowfish_End;		
		$hashed_password = crypt(trim($password), $bcrypt_salt);	
		return $hashed_password;
	}
	
	
	public function getUserByEmail($email){
		$q = $this->db->select('user_id, user_name, user_username')
					  ->where('user_email',$email)
					  ->limit('1')
					  ->get('users');
		return $q->row();
	}
	
	
	public function getLoggedInUser(){
		$id  = $this->session->userdata["userdata"]->user_id;
		$q = $this->db->select('*')
					  ->where('user_id',$id)
					  ->limit('1')
					  ->get('users');
		return $q->row();
	}
	
	
	public function forgotPassword_resetPassword($password,$email){
		
		$salt = $this->generatePasswordSalt();		
		$data = array(
               'password' => $this->encryptPassword($password,$salt),
               'salt' => $salt
            );
		$this->db->where('user_email', $email);
		$this->db->update('users', $data);
			
		return true;
	}
	
	
	public function createUser($data){
		$this->db->insert('users', $data);
		return $this->db->insert_id();
	}
	public function updateUser($user_id,$data){
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
		return $this->db->insert_id();
	}
	
	
}