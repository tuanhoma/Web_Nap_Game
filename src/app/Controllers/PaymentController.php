<?php

namespace App\Controllers;

use App\Helpers\Session;
use App\Helpers\View;
use App\Services\MomoService;
use App\Services\OrderService;
use App\Services\GameService;

/**
 * PaymentController
 * Xử lý thanh toán MoMo: tạo payment, callback, IPN
 */
class PaymentController
{
    private MomoService $momoService;
    private OrderService $orderService;
    private GameService $gameService;

    public function __construct()
    {
        $this->momoService = new MomoService();
        $this->orderService = new OrderService();
        $this->gameService = new GameService();
    }

    /**
     * Tạo yêu cầu thanh toán và redirect sang MoMo
     */
    public function create(): void
    {
        // Verify CSRF
        if (!Session::verifyCsrfToken($_POST['_csrf_token'] ?? '')) {
            Session::flash('error', 'Phiên làm việc không hợp lệ.');
            header('Location: /topup');
            exit;
        }

        $packageId = (int)($_POST['package_id'] ?? 0);
        $userId = Session::getUserId();

        // Lấy thông tin gói nạp
        $package = $this->gameService->getPackageById($packageId);
        if (!$package) {
            Session::flash('error', 'Gói nạp không tồn tại.');
            header('Location: /topup');
            exit;
        }

        // Tạo order trong database
        $orderId = $this->orderService->createOrder($userId, $packageId, $package['price']);
        $order = $this->orderService->getOrderById($orderId);

        // Tạo thông tin thanh toán
        $orderInfo = "Nạp {$package['name']} - {$package['game_name']}";
        $amount = (int)$package['price'];

        // Gọi MoMo API tạo payment
        $response = $this->momoService->createPayment(
            $order['order_id_momo'],
            $order['request_id'],
            $amount,
            $orderInfo
        );

        // Kiểm tra response
        if (isset($response['resultCode']) && $response['resultCode'] == 0) {
            // Lưu payment URL
            $paymentUrl = $response['payUrl'] ?? '';
            if ($paymentUrl) {
                $this->orderService->updatePaymentUrl($orderId, $paymentUrl);
            }

            // Redirect sang trang thanh toán MoMo
            if (!empty($response['payUrl'])) {
                header('Location: ' . $response['payUrl']);
                exit;
            }

            // Nếu có QR code, hiển thị
            View::render('payment/qrcode', [
                'title' => 'Quét mã QR thanh toán',
                'qrCodeUrl' => $response['qrCodeUrl'] ?? '',
                'deeplink' => $response['deeplink'] ?? '',
                'order' => $order,
                'package' => $package,
            ]);
        } else {
            // Lỗi tạo payment
            $errorMessage = $response['message'] ?? 'Không thể tạo yêu cầu thanh toán.';
            error_log("MoMo Create Payment Error: " . json_encode($response));

            Session::flash('error', 'Lỗi thanh toán MoMo: ' . $errorMessage);
            header('Location: /topup');
            exit;
        }
    }

    /**
     * Xử lý callback từ MoMo (redirect URL)
     * Người dùng được redirect về đây sau khi thanh toán
     */
    public function callback(): void
    {
        $resultCode = (int)($_GET['resultCode'] ?? -1);
        $orderId = $_GET['orderId'] ?? '';
        $message = $_GET['message'] ?? '';

        if (empty($orderId)) {
            Session::flash('error', 'Không tìm thấy thông tin đơn hàng.');
            header('Location: /dashboard');
            exit;
        }

        $order = $this->orderService->getOrderByMomoId($orderId);

        if ($resultCode == 0) {
            // Thanh toán thành công
            $this->orderService->handlePaymentSuccess($orderId, $resultCode, $message);

            // Reload order
            $order = $this->orderService->getOrderByMomoId($orderId);

            View::render('payment/success', [
                'title' => 'Thanh toán thành công',
                'order' => $order,
                'transId' => $_GET['transId'] ?? '',
            ]);
        } else {
            // Thanh toán thất bại
            $this->orderService->handlePaymentFailed($orderId, $resultCode, $message);

            View::render('payment/failed', [
                'title' => 'Thanh toán thất bại',
                'order' => $order,
                'message' => $message,
                'resultCode' => $resultCode,
            ]);
        }
    }

    /**
     * Xử lý IPN (Instant Payment Notification) từ MoMo
     * MoMo gửi POST request tới URL này
     */
    public function ipn(): void
    {
        // Đọc dữ liệu từ MoMo
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        error_log("MoMo IPN received: " . $rawData);

        if (!$data) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid data']);
            return;
        }

        // Xác thực chữ ký
        if (!$this->momoService->verifySignature($data)) {
            error_log("MoMo IPN: Invalid signature");
            http_response_code(400);
            echo json_encode(['message' => 'Invalid signature']);
            return;
        }

        $orderId = $data['orderId'] ?? '';
        $resultCode = (int)($data['resultCode'] ?? -1);
        $message = $data['message'] ?? '';

        if ($resultCode == 0) {
            $this->orderService->handlePaymentSuccess($orderId, $resultCode, $message);
        } else {
            $this->orderService->handlePaymentFailed($orderId, $resultCode, $message);
        }

        // Trả về response cho MoMo
        http_response_code(204);
    }
}
