<?php

namespace App\Services\Tripay;

class Tripay
{
    protected $apiKey;
    protected $privateKey;
    protected $merchantCode;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('tripay.tripay_api_key');
        $this->privateKey = config('tripay.tripay_private_key');
        $this->merchantCode = config('tripay.tripay_merchant_code');
        $this->apiUrl = config('tripay.tripay_api_url');
    }
}
