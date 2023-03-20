<?php
namespace App\Http;
use http\Client\Request;

class GNews
{
    private  $apikey;
    private $url;

    public function __construct($apiKey)
    {
        $this->apikey = $apiKey;
        $this->url = "https://gnews.io/api/v4/search?q=example&token=$this->apikey&lang=en&country=us&max=5";

    }
    public function get_articles()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this -> url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $data['articles'];

           }

}
