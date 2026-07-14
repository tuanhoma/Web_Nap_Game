<?php

namespace App\Helpers;

/**
 * View Helper
 * Render PHP templates với layout hỗ trợ
 */
class View
{
    /**
     * Render view với layout
     *
     * @param string $view Đường dẫn view (ví dụ: 'auth/login')
     * @param array $data Dữ liệu truyền vào view
     * @param string $layout Layout sử dụng (mặc định: 'main')
     */
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        // Extract data thành biến
        extract($data);

        // Lấy đường dẫn file view (Path travesal)
        $viewPath = dirname(__DIR__, 2) . '/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo "View not found: {$view}";
            return;
        }

        // Render nội dung view vào buffer
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // Render layout với nội dung
        $layoutPath = dirname(__DIR__, 2) . '/views/layouts/' . $layout . '.php';

        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            echo $content;
        }
    }

    /**
     * Render view không có layout (cho AJAX, email...)
     */
    public static function renderPartial(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = dirname(__DIR__, 2) . '/views/' . $view . '.php';

        if (file_exists($viewPath)) {
            require $viewPath;
        }
    }

    /**
     * Escape HTML output để chống XSS
     */
    public static function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }

    /**
     * Format số tiền VNĐ
     */
    public static function money($amount): string
    {
        return number_format((float)$amount, 0, ',', '.') . ' VNĐ';
    }

    /**
     * Format ngày giờ
     */
    public static function datetime(?string $datetime): string
    {
        if (!$datetime) return '';
        return date('d/m/Y H:i', strtotime($datetime));
    }
}
