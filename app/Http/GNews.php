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
        $this->url = "https://gnews.io/api/v4/search?q=example&token=$this->apikey&lang=en&country=us&max=10";

    }
    public function pull()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this -> url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $data['articles'];

        //for ($i = 0; $i < count($articles); $i++) {
            // articles[i].title
            //echo "Title: " . $articles[$i]['title'] . "\n";
            // articles[i].description
           // echo "Description: " . $articles[$i]['description'] . "\n";
            // You can replace {property} below with any of the article properties returned by the API.
            // articles[i].{property}
            // echo $articles[$i]['{property}'] . "\n";

            // Delete this line to display all the articles returned by the request. Currently only the first article is displayed.
          //  break;
        //}
    }

}
