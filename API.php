<?php

namespace postcodes_nu;


class API
{
    private $bearer;
    private $subscription;
    private $baseUrl = 'https://postcodes.nu/api/v1/postcode/';

    public function __construct($bearer, $subscription)
    {
        $this->bearer = $bearer;
        $this->subscription = $subscription;
    }

    public function exists($postcode)
    {
        $callUrl = $this->baseUrl . 'exists/' . $postcode;
        return $this->doGet($callUrl);
    }

    public function letters($postcode)
    {
        $callUrl = $this->baseUrl . $postcode . '/letters' ;
        return $this->doGet($callUrl);
    }

    public function housenumbers($postcode)
    {
        $callUrl = $this->baseUrl . $postcode . '/huisnummers' ;
        return $this->doGet($callUrl);
    }

    public function houseByPostcode($postcode, $housenumber, $housenumber_extension = '', $houseletter = '')
    {
        if($housenumber_extension == '' && $houseletter == '') $callUrl = $this->baseUrl . $postcode . '/' . $housenumber ;
        else if($houseletter == '') $callUrl = $this->baseUrl . $postcode . '/' . $housenumber . '/' . $housenumber_extension;
        else if($housenumber_extension == '') $callUrl = $this->baseUrl . $postcode . '/' . $housenumber . '//' . $houseletter;
        return $this->doGet($callUrl);
    }

    private function doGet($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           0 );
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json', 'Accept: application/json', 'X-Requested-With: XMLHttpRequest', "Authorization: Bearer $this->bearer", "abonnement-id: $this->subscription"));
        $result = curl_exec($ch);
        return json_decode($result, true);
    }

}
