<?php
/**
 * Created by PhpStorm.
 * User: Tristan
 * Date: 4/5/2019
 * Time: 1:11 PM
 */

namespace postcodes_nu;


class Auth
{
    private $email;
    private $password;

    private $callURL = 'https://dev.postcodes.nu/api/auth/login';

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getBearer()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            $this->callURL );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     json_encode(['email'=>$this->email, 'password'=>$this->password]) );
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json', 'Accept: application/json', 'X-Requested-With: XMLHttpRequest'));
        $result = curl_exec($ch);
        $result = json_decode($result);
        if(isset($result->message)) throw new \Exception("Incorrect login");
        return ['bearer' => $result->access_token, 'expires_at' => $result->expires_at];
    }
}