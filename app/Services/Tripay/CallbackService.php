<?php

namespace App\Services\Tripay;

use App\Models\Payment;
use App\Models\Transaction;
use App\Services\Telegram\TelegramService;
use App\Notifications\AddBalanceNotification;

class CallbackService
{
    protected $apiKey;
    protected $privateKey;
    protected $merchantCode;
    protected $apiUrl;
    private $telegram;
    public function __construct()
    {
        $this->apiKey = config('tripay.tripay_api_key');
        $this->privateKey = config('tripay.tripay_private_key');
        $this->merchantCode = config('tripay.tripay_merchant_code');
        $this->apiUrl = config('tripay.tripay_api_url');
    }

    public function handle($payload, $callbackSignature)
    {
        $signature = hash_hmac('sha256', $payload, $this->privateKey);

        if ($signature !== $callbackSignature) {
            return false;
        }
        $data = json_decode($payload, true);

        $transaction = Payment::where('reference', $data['reference'])->first();
        $user = $transaction->user;
        if ($data['status'] == 'PAID') {
            $transaction->update([
                'status' => 'PAID',
            ]);
        } else if ($data['status'] == 'EXPIRED') {
            $transaction->update([
                'status' => 'EXPIRED',
            ]);
        } else if ($data['status'] == 'FAILED') {
            $transaction->update([
                'status' => 'FAILED',
            ]);
        }

        return true;
    }
}
