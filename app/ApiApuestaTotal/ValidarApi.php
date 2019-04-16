<?php
/**
 * Created by PhpStorm.
 * User: Software3000
 * Date: 04/02/2019
 * Time: 15:12
 */

namespace App\ApiApuestaTotal;


class ValidarApi
{
    public $api_key;


    public function __construct()
    {
        $this->api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI3ODcxZGNlMWY2YjExMWU3ODBkNGI3ZGM4OTBkMWUzNjMwZjA2MjcwYWZiMDM1MzA2ZjVkOGY1NjBkZTJhZTE1NjE3ZDZiOWMwYTc1MGNjIn0.eyJhdWQiOiIxIiwianRpIjoiMjc4NzFkY2UxZjZiMTExZTc4MGQ0YjdkYzg5MGQxZTM2MzBmMDYyNzBhZmIwMzUzMDZmNWQ4ZjU2MGRlMmFlMTU2MTdkNmI5YzBhNzUwY2MiLCJpYXQiOjE1NDkzMDk0MDYsIm5iZiI6MTU0OTMwOTQwNiwiZXhwIjoxNTgwODQ1NDA2LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.NXx4UxwRW6adNjIW4V5SZ_M9c4J-MBsDWIkzh9FAUNq5DtayTCds3AmYq4CM8kfz7b-JFfnsdtph-twMplJCn4cVdNXmq2ieJ77OX5Kt9bUN0yCSpzaKiuXsDN4sugmJD9DtD9fdPAD-4O7qXmHPeuCHE4dio5bPF2SVSRnFgC9ZPdu66pRaQ-TNT3FyYzErIaq2zXAZomkQ-c2A4v4-IQqs9tuEuxM7xoPanNlQIBD0lzHk-vPRomBrju4ZKiGbDqNVURqJQoaN0g98pxXFSAfblGg0KZ-9JXmHEN_Td0iPmfZpPNi-FZNOIUm2SMIBzW2Ay4AUw_RB0Usb9Jjsh5VxHM80bHaMUC8glcl1HmWq3QqKdwP3q3Nias5YVHqz1IoD_0nu5Pv6UfnyR8r0ujqY0brQX4xxfz1r4RvPhv81LzRReDXXHmpT8tLObGiP4f7hzIEDdau0RkokVMNnVL0xsGBGUTNoRwksCVsiTGTNAx9nJPbRq-TKaztB8WmgwiJDgSbgBf5zTWQNRzSzKubrDsnvjVaanF_iS3xGacHO1INSwqSJvxwE--n6WkoekquPfbeyQA0XizaqT89W3-Rq60ebcLunT7JXGLXL7KpnSLrC6_8BxR87uejAEnkJG-O3mpyW6HSSxMzUQC8TKxj0RD2Llg9sDlBzhDwKwU8';
    }

    public function ValidarLoginTokenApi($Usuario, $password)
    {
        $curl = curl_init();
        curl_setopt_array($curl,
            array(
                CURLOPT_URL => "https://api.apuestatotal.com/v2/cajausers",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS =>
                    "usuario=" . $Usuario . "&password=" . $password,
                CURLOPT_ENCODING => "",
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Accept: application/json",
                    "Authorization: Bearer " . $this->api_key
                ),
            ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $response;
    }

    public function ListaTiendasTokenApi()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apuestatotal.com/v2/locales",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Bearer " . $this->api_key
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $response;
    }

    public function consultarLocal($unitId)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.apuestatotal.com/v2/locales/' . $unitId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $headers = array();
        $headers[] = 'Accept: application/json';
        //$headers[] = 'Authorization: Bearer '.$accessToken;
        $headers[] = 'Authorization: Bearer ' . $this->api_key;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $response;
    }

}