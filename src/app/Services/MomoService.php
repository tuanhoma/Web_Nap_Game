<?php

namespace App\Services;

/**
 * MomoService
 * Tích hợp MoMo Payment Sandbox API v2
 * Docs: https://developers.momo.vn/v3/docs/payment/api/wallet/onetime
 */
class MomoService
{
    private string $partnerCode;
    private string $accessKey;
    private string $secretKey;
    private string $apiEndpoint;
    private string $redirectUrl;
    private string $ipnUrl;

    public function __construct()
    {
        $config = require dirname(__DIR__, 2) . '/config/app.php';
        $momo = $config['momo'];

        $this->partnerCode = $momo['partner_code'];
        $this->accessKey = $momo['access_key'];
        $this->secretKey = $momo['secret_key'];
        $this->apiEndpoint = $momo['api_endpoint'];
        $this->redirectUrl = $momo['redirect_url'];
        $this->ipnUrl = $momo['ipn_url'];
    }

    /**
     * Tạo yêu cầu thanh toán MoMo
     *
     * @param string $orderId Mã đơn hàng
     * @param string $requestId Request ID duy nhất
     * @param int $amount Số tiền (VNĐ)
     * @param string $orderInfo Mô tả đơn hàng
     * @return array Response từ MoMo
     */
    public function createPayment(string $orderId, string $requestId, int $amount, string $orderInfo): array
    {
        $requestType = "payWithMethod";
        $extraData = "";
        $autoCapture = true;
        $lang = "vi";

        // Tạo chữ ký HMAC SHA256
        $rawSignature = "accessKey={$this->accessKey}"
            . "&amount={$amount}"
            . "&extraData={$extraData}"
            . "&ipnUrl={$this->ipnUrl}"
            . "&orderId={$orderId}"
            . "&orderInfo={$orderInfo}"
            . "&partnerCode={$this->partnerCode}"
            . "&redirectUrl={$this->redirectUrl}"
            . "&requestId={$requestId}"
            . "&requestType={$requestType}";

        $signature = hash_hmac('sha256', $rawSignature, $this->secretKey);

        // Dữ liệu gửi lên MoMo
        $requestBody = [
            'partnerCode' => $this->partnerCode,
            'partnerName' => 'Game Top-up Portal',
            'storeId' => 'GameTopupStore',
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $this->redirectUrl,
            'ipnUrl' => $this->ipnUrl,
            'lang' => $lang,
            'requestType' => $requestType,
            'autoCapture' => $autoCapture,
            'extraData' => $extraData,
            'signature' => $signature,
        ];

        // Gọi API MoMo
        $endpoint = $this->apiEndpoint . '/create';
        $response = $this->sendRequest($endpoint, $requestBody);

        return $response;
    }

    /**
     * Kiểm tra trạng thái giao dịch
     */
    public function queryTransaction(string $orderId, string $requestId): array
    {
        $rawSignature = "accessKey={$this->accessKey}"
            . "&orderId={$orderId}"
            . "&partnerCode={$this->partnerCode}"
            . "&requestId={$requestId}";

        $signature = hash_hmac('sha256', $rawSignature, $this->secretKey);

        $requestBody = [
            'partnerCode' => $this->partnerCode,
            'requestId' => $requestId,
            'orderId' => $orderId,
            'signature' => $signature,
            'lang' => 'vi',
        ];

        $endpoint = $this->apiEndpoint . '/query';
        return $this->sendRequest($endpoint, $requestBody);
    }

    /**
     * Xác thực chữ ký từ callback/IPN của MoMo
     */
    public function verifySignature(array $data): bool
    {
        $rawSignature = "accessKey={$this->accessKey}"
            . "&amount={$data['amount']}"
            . "&extraData={$data['extraData']}"
            . "&message={$data['message']}"
            . "&orderId={$data['orderId']}"
            . "&orderInfo={$data['orderInfo']}"
            . "&orderType={$data['orderType']}"
            . "&partnerCode={$data['partnerCode']}"
            . "&payType={$data['payType']}"
            . "&requestId={$data['requestId']}"
            . "&responseTime={$data['responseTime']}"
            . "&resultCode={$data['resultCode']}"
            . "&transId={$data['transId']}";

        $expectedSignature = hash_hmac('sha256', $rawSignature, $this->secretKey);

        return hash_equals($expectedSignature, $data['signature'] ?? '');
    }

    /**
     * Gửi HTTP request tới MoMo API
     */
    private function sendRequest(string $url, array $data): array
    {
        $jsonData = json_encode($data);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData),
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false, // Sandbox mode
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("MoMo API Error: {$error}");
            return ['resultCode' => -1, 'message' => 'Lỗi kết nối MoMo: ' . $error];
        }

        $response = json_decode($result, true);

        if (!$response) {
            error_log("MoMo API Invalid Response: {$result}");
            return ['resultCode' => -1, 'message' => 'Phản hồi không hợp lệ từ MoMo'];
        }

        // Log response để debug
        error_log("MoMo Response [{$httpCode}]: " . $result);

        return $response;
    }
}
