<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class GetNetService
{
    protected $login;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->login = env('GETNET_LOGIN');
        $this->secretKey = env('GETNET_SECRET_KEY');
        $this->baseUrl = env('GETNET_BASE_URL');
    }

    public function request($data)
    {
        $nonce = base64_encode(random_bytes(16));
        $seed = (new \DateTime())->format(\DateTime::ATOM);
        $tranKey = base64_encode(hash('sha256', $nonce . $seed . $this->secretKey, true));

        $auth = [
            'login' => $this->login,
            'tranKey' => $tranKey,
            'nonce' => $nonce,
            'seed' => $seed
        ];

        $data['auth'] = $auth;

        $response = Http::post($this->baseUrl . '/api/session', $data);

        return $response;
    }
}
