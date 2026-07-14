# Game Top-up Portal (Cổng Nạp Game)

Dự án mô phỏng Cổng Nạp Game (Game Top-up Portal) sử dụng PHP 8.2 thuần, MySQL 8 và Docker. Tích hợp thanh toán trực tuyến qua ví MoMo (Sandbox).

## 🚀 Tính năng nổi bật

- **Kiến trúc MVC nhẹ**: Custom framework không dùng thư viện ngoài (trừ phpdotenv), cấu trúc rõ ràng (Controllers, Services, Repositories, Models).
- **Authentication**: Đăng ký, đăng nhập bảo mật bằng session và `password_hash`. Phân quyền User/Admin.
- **Tích hợp thanh toán MoMo**: Kết nối với MoMo Sandbox API v2 (Tạo thanh toán, Xử lý Callback & Webhook IPN, Xác thực chữ ký HMAC-SHA256).
- **UI/UX hiện đại**: Giao diện mang phong cách Gaming, dark theme với hiệu ứng Glassmorphism (Sử dụng Bootstrap 5 kết hợp Custom CSS).
- **Admin Panel**: Dashboard quản lý người dùng, giao dịch, và tạo thêm gói nạp game.

## 🛠 Yêu cầu hệ thống

- Docker
- Docker Compose

## ⚡ Hướng dẫn cài đặt & chạy

1. **Clone/Tải source code** về thư mục máy tính.
2. **Khởi chạy bằng Docker Compose**:
   Mở terminal tại thư mục gốc của project và chạy lệnh sau:
   ```bash
   docker compose up -d --build
   ```
   *Lần đầu tiên chạy, Docker sẽ build image và MySQL sẽ tự động khởi tạo database, import dữ liệu mẫu.*

3. **Truy cập ứng dụng**:
   - Trang chủ: http://localhost:8888
   - phpMyAdmin: http://localhost:8081 (User: `root` / Pass: `root_password`)

## 🔑 Tài khoản Demo

Database đã được tạo sẵn các tài khoản sau:

| Vai trò | Tên đăng nhập | Mật khẩu |
|---------|---------------|----------|
| **Admin** | `admin` | `123456` |
| **User** | `user1` | `123456` |
| **User** | `user2` | `123456` |

## 💳 Hướng dẫn test thanh toán MoMo

Ứng dụng đang cấu hình mặc định sử dụng môi trường thử nghiệm (Sandbox) của MoMo:
1. Đăng nhập bằng tài khoản **user1** hoặc tài khoản bạn mới tạo.
2. Vào phần **Nạp Game**, chọn 1 game bất kỳ (VD: Liên Quân Mobile).
3. Chọn gói nạp và bấm **Thanh toán qua MoMo**.
4. Ứng dụng sẽ chuyển hướng (redirect) bạn sang cổng thanh toán test của MoMo.
5. Tại đây, bạn sử dụng **Ứng dụng MoMo thật** trên điện thoại để quét mã QR thanh toán (Tài khoản MoMo của bạn sẽ **không bị trừ tiền thật** vì đây là Sandbox).
6. Sau khi thanh toán, MoMo sẽ gọi URL Callback để trả kết quả về web.
7. Vào Dashboard để kiểm tra số dư và lịch sử giao dịch.

> **Lưu ý về IPN (Webhook)**: Trên môi trường local (localhost), MoMo server không thể gửi POST request IPN trực tiếp đến localhost của bạn. Tuy nhiên, luồng thanh toán vẫn hoạt động bình thường nhờ cơ chế kiểm tra kết quả qua Redirect URL (Callback).

## 📂 Cấu trúc thư mục

```text
.
├── database/               # SQL script tạo bảng và chèn dữ liệu mẫu
├── docker-compose.yml      # Cấu hình các dịch vụ Docker (App, MySQL, PMA)
├── Dockerfile              # Dockerfile build PHP-Apache
├── .env                    # Biến môi trường
├── src/                    # Source code PHP
│   ├── app/
│   │   ├── Controllers/    # Xử lý HTTP request
│   │   ├── Helpers/        # Các hàm hỗ trợ (Router, View, Session, Validator)
│   │   ├── Middleware/     # Kiểm tra quyền truy cập (Auth, Admin)
│   │   ├── Models/         # Data structures
│   │   ├── Repositories/   # Giao tiếp với Database bằng PDO
│   │   └── Services/       # Business Logic (MoMoService, OrderService...)
│   ├── config/             # Cấu hình app, database
│   ├── public/             # Thư mục gốc web (DocumentRoot)
│   │   ├── index.php       # Front controller
│   │   └── assets/         # CSS, JS, Images
│   ├── routes/             # Định nghĩa web routes
│   └── views/              # View templates (PHP)
└── README.md
```

## 🔒 Bảo mật (Security)

Dự án áp dụng các biện pháp bảo mật cơ bản cho môi trường Web:
- **SQL Injection**: Sử dụng hoàn toàn **PDO Prepared Statements** trong tầng Repository.
- **XSS**: Escape HTML toàn bộ data trước khi in ra View thông qua helper `View::e()`.
- **CSRF**: Token CSRF được tạo và kiểm tra cho tất cả các request POST (Đăng nhập, đăng ký, thanh toán, tạo gói).
- **Mật khẩu**: Hash mật khẩu an toàn bằng hàm `password_hash()` mặc định của PHP.
