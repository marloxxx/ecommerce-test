<?php

namespace App\Services\Tripay;

use GuzzleHttp\Client;

class TripayService extends Tripay
{
    private $headers;
    private $body;
    private $client;
    private $url;

    public function __construct()
    {
        parent::__construct();
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        $this->body = [];
        $this->client = new Client([
            'headers' => $this->headers,
        ]);
    }

    public function getPaymentChannels()
    {
        $this->url = $this->apiUrl . '/merchant/payment-channel';
        try {
            $response = $this->client->get($this->url);
            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function createTransaction($data)
    {
        $signature = hash_hmac('sha256', $this->merchantCode . $data['merchant_ref'] . $data['amount'], $this->privateKey);
        $this->url = $this->apiUrl . '/transaction/create';
        $this->body = [
            'method' => $data['method'],
            'merchant_ref' => $data['merchant_ref'],
            'amount' => $data['amount'],
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'order_items' => $data['order_items'],
            'callback_url' => $data['callback_url'],
            'return_url' => $data['return_url'],
            'expired_time' => $data['expired_time'],
            'signature' => $signature,
        ];
        try {
            $response = $this->client->post($this->url, [
                'json' => $this->body,
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function detailTransaction($reference)
    {
        $this->url = $this->apiUrl . '/transaction/detail?reference=' . $reference;
        try {
            $response = $this->client->get($this->url);
            return json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
