<?php

require "/vendor/autoload.php";
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpClient\HttpClient;   //changing headers ability

ini_set ( 'max_execution_time' , 300 ); 
    $httpClient = new \Goutte\Client(HttpClient::create(array(                     //everything past client( is for changing headers
        'headers' => array(
            'user-agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0', // will be forced using 'Symfony BrowserKit' in executing
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language' => 'en-US,en;q=0.5',
            'Referer' => 'http://yourtarget.url/',
            'Upgrade-Insecure-Requests' => '1',
            'Save-Data' => 'on',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'no-cache',
        ),
    )));
    $page_number = -1;
    $pages_to_scrap = 10;
    $httpClient->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0');  //for changing user agent and header
    $response = $httpClient->request('GET', 'https://www.kotobati.com/section/%D8%B1%D9%88%D8%A7%D9%8A%D8%A7%D8%AA?page=' . $page_number);
    
    $response->filter('')->each(function ($node) use ($httpClient){
        dump($node->text());
    });