<?php
/**
 * Front Controller
 * Điểm vào duy nhất của ứng dụng
 */

// Autoload Composer
$autoloadPath = dirname(__DIR__) . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

// Load .env
$envPath = dirname(__DIR__);
if (file_exists($envPath . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($envPath);
    $dotenv->load();
}

// Load cấu hình
$appConfig = require dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/config/database.php';

// Cấu hình session
// [SECURITY FIX GTU-190626-01] Bật HttpOnly để JavaScript không thể đọc cookie session
// => Ngăn chặn kẻ tấn công dùng XSS để đánh cắp cookie qua document.cookie
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Lax');
session_name($appConfig['session']['name']);
session_start();

// [SECURITY FIX GTU-190626-01] Content Security Policy — Defense in depth
// Chặn inline script, chỉ cho phép script từ cùng origin
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net; img-src 'self' data: https:; connect-src 'self'; object-src 'none'; base-uri 'self'; form-action 'self';");
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Error handling
if ($appConfig['debug']) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Load helpers
require_once dirname(__DIR__) . '/app/Helpers/Session.php';
require_once dirname(__DIR__) . '/app/Helpers/View.php';
require_once dirname(__DIR__) . '/app/Helpers/Validator.php';
require_once dirname(__DIR__) . '/app/Helpers/Router.php';

// Load Models
require_once dirname(__DIR__) . '/app/Models/User.php';
require_once dirname(__DIR__) . '/app/Models/Game.php';
require_once dirname(__DIR__) . '/app/Models/GamePackage.php';
require_once dirname(__DIR__) . '/app/Models/Order.php';
require_once dirname(__DIR__) . '/app/Models/Transaction.php';

// Load Repositories
require_once dirname(__DIR__) . '/app/Repositories/UserRepository.php';
require_once dirname(__DIR__) . '/app/Repositories/GameRepository.php';
require_once dirname(__DIR__) . '/app/Repositories/PackageRepository.php';
require_once dirname(__DIR__) . '/app/Repositories/OrderRepository.php';
require_once dirname(__DIR__) . '/app/Repositories/TransactionRepository.php';
require_once dirname(__DIR__) . '/app/Repositories/ReportRepository.php';


// Load Services
require_once dirname(__DIR__) . '/app/Services/AuthService.php';
require_once dirname(__DIR__) . '/app/Services/GameService.php';
require_once dirname(__DIR__) . '/app/Services/OrderService.php';
require_once dirname(__DIR__) . '/app/Services/MomoService.php';

// Load Middleware
require_once dirname(__DIR__) . '/app/Middleware/AuthMiddleware.php';
require_once dirname(__DIR__) . '/app/Middleware/AdminMiddleware.php';

// Load Controllers
require_once dirname(__DIR__) . '/app/Controllers/AuthController.php';
require_once dirname(__DIR__) . '/app/Controllers/HomeController.php';
require_once dirname(__DIR__) . '/app/Controllers/DashboardController.php';
require_once dirname(__DIR__) . '/app/Controllers/TopupController.php';
require_once dirname(__DIR__) . '/app/Controllers/PaymentController.php';
require_once dirname(__DIR__) . '/app/Controllers/AdminController.php';

// Khởi tạo Router và load routes
$router = new \App\Helpers\Router();
require dirname(__DIR__) . '/routes/web.php';

// Lấy URL từ request
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$method = $_SERVER['REQUEST_METHOD'];

// Dispatch request
$router->dispatch($url, $method);
