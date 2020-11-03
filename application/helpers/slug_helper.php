<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('callApi')) {
    function callApi($linkApi, $method = "GET"){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $linkApi,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                "Authorization:".AUTHORIZATION_INTERNAL,
                "Content-Type:application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}