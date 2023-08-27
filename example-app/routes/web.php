<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpClient\HttpClient;   //changing headers ability

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::post('add', [scrap_controller::class,'data']);


Route::get('/', function () {
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
    

for ($x = 1; $x <= $pages_to_scrap; $x++) {
    $page_number++;
    echo $page_number;


// //Scrap title lists and links, clicks each and scraps information inside
$response = $httpClient->request('GET', 'https://www.kotobati.com/section/%D8%B1%D9%88%D8%A7%D9%8A%D8%A7%D8%AA?page=' . $page_number);
$response->filter('.info div div div h3 a')->each(function ($node) use ($httpClient){
    dump($node->text());
   // DB::insert('insert into users (id, name) values (?, ?)', [1, 'Marc']);

    try {
    $all = $httpClient->click($node->link())->filter('');
    $book_count = $all->filter('.info div .media-body ul li p')->eq(1)->text();
    dump($book_count);
    $book_lang = $all->filter('.info div .media-body ul li')->eq(1)->filter('p')->eq(1)->text();
    dump($book_lang);
    $book_size = $all->filter('.info div .media-body ul li')->eq(2)->filter('p')->eq(1)->text();
    dump($book_size);
    $file_type = $all->filter('.info div .media-body ul li')->eq(4)->filter('p')->eq(1)->text();
    dump($file_type);
    $book_download = $all->filter('.info .detail-box div .box-btn a')->eq(0)->attr('href');
    dump('https://www.kotobati.com' . $book_download);
    } catch(Exception $e) {
    };
     });

    }//belongs to for loop

    return view('welcome');
});