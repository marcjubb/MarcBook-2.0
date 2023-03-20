<?php

namespace App\Http;

use http\Client\Request;

class Facebook
{
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }
    public function store(Request $request)
    {
        $response = $this->apiKey->message()->send([
            'from' => config('services.facebook.from'),
            'text' => $request->input('text'),
            'to' => $request->input('recipient'),
        ]);


    }
}
