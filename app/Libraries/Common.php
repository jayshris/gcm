<?php
namespace App\Libraries;

use CodeIgniter\Model; 

class Common
{
    function getPincodeByCity($city){
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, 'https://api.postalpincode.in/postoffice/'.$city);
        $result = curl_exec($c);
        curl_close($c);
        return $result;
    }
}
