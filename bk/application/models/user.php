<?php
/**
 * Created by PhpStorm.
 * User: Rimshiane
 * Date: 11/24/2016
 * Time: 3:15 AM
 */


Class User extends CI_Model
{
    function login($username,$password)
    {
        $this -> db -> select('id, username, password');
        $this -> db -> from('gate_users');
        $this -> db -> where('username', $username);
        $this -> db -> where('password', MD5($password));
        $this -> db -> limit(1);

        $query = $this -> db -> get();

        if($query -> num_rows() == 1)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

}