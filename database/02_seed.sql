-- ============================================
-- Game Top-up Portal - Seed Data
-- ============================================
SET NAMES utf8mb4;
CREATE DATABASE IF NOT EXISTS game_topup CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE game_topup;

-- =====================
-- Seed Users
-- Admin: admin / 123456
-- User:  user1 / 123456, user2 / 123456
-- =====================
INSERT INTO users (username, email, password_hash, full_name, role, balance) VALUES
('admin', 'admin@gametopup.vn', '$2y$10$Buc7kFRqHd5NqR5SOBBHjOabf.it9i7DlkQyYVQgogYZQErA0h2X2', 'Admin Hệ Thống', 'admin', 0),
('user1', 'user1@gmail.com', '$2y$10$Buc7kFRqHd5NqR5SOBBHjOabf.it9i7DlkQyYVQgogYZQErA0h2X2', 'Nguyễn Văn A', 'user', 500000),
('user2', 'user2@gmail.com', '$2y$10$Buc7kFRqHd5NqR5SOBBHjOabf.it9i7DlkQyYVQgogYZQErA0h2X2', 'Trần Thị B', 'user', 200000);
-- Mật khẩu hash cho "123456" (bcrypt)

-- =====================
-- Seed Games
-- =====================
INSERT INTO games (name, slug, image_url, description, status) VALUES
('Liên Quân Mobile', 'lien-quan-mobile', '/assets/images/games/lien-quan.png', 'Game MOBA 5v5 hàng đầu Việt Nam. Nạp Quân Huy để mua tướng và skin.', 'active'),
('Free Fire', 'free-fire', '/assets/images/games/free-fire.png', 'Game battle royale sinh tồn. Nạp Kim Cương để mua vật phẩm.', 'active'),
('Roblox', 'roblox', '/assets/images/games/roblox.png', 'Nền tảng game sáng tạo. Nạp Robux để trải nghiệm nhiều game hơn.', 'active'),
('Genshin Impact', 'genshin-impact', '/assets/images/games/genshin.png', 'Game RPG thế giới mở. Nạp Genesis Crystal để gacha nhân vật.', 'active'),
('PUBG Mobile', 'pubg-mobile', '/assets/images/games/pubg.png', 'Game battle royale hàng đầu. Nạp UC để mua skin và Royal Pass.', 'active');

-- =====================
-- Seed Game Packages
-- =====================

-- Liên Quân Mobile (game_id = 1)
INSERT INTO game_packages (game_id, name, diamonds, price, description) VALUES
(1, '60 Quân Huy', 60, 20000, 'Gói nạp 60 Quân Huy Liên Quân'),
(1, '150 Quân Huy', 150, 50000, 'Gói nạp 150 Quân Huy Liên Quân'),
(1, '325 Quân Huy', 325, 100000, 'Gói nạp 325 Quân Huy Liên Quân'),
(1, '900 Quân Huy', 900, 200000, 'Gói nạp 900 Quân Huy Liên Quân'),
(1, '2350 Quân Huy', 2350, 500000, 'Gói nạp 2350 Quân Huy Liên Quân');

-- Free Fire (game_id = 2)
INSERT INTO game_packages (game_id, name, diamonds, price, description) VALUES
(2, '100 Kim Cương', 100, 20000, 'Gói nạp 100 Kim Cương Free Fire'),
(2, '310 Kim Cương', 310, 50000, 'Gói nạp 310 Kim Cương Free Fire'),
(2, '520 Kim Cương', 520, 100000, 'Gói nạp 520 Kim Cương Free Fire'),
(2, '1060 Kim Cương', 1060, 200000, 'Gói nạp 1060 Kim Cương Free Fire'),
(2, '2180 Kim Cương', 2180, 500000, 'Gói nạp 2180 Kim Cương Free Fire');

-- Roblox (game_id = 3)
INSERT INTO game_packages (game_id, name, diamonds, price, description) VALUES
(3, '80 Robux', 80, 25000, 'Gói nạp 80 Robux'),
(3, '200 Robux', 200, 60000, 'Gói nạp 200 Robux'),
(3, '400 Robux', 400, 100000, 'Gói nạp 400 Robux'),
(3, '800 Robux', 800, 200000, 'Gói nạp 800 Robux'),
(3, '1700 Robux', 1700, 450000, 'Gói nạp 1700 Robux');

-- Genshin Impact (game_id = 4)
INSERT INTO game_packages (game_id, name, diamonds, price, description) VALUES
(4, '60 Genesis Crystal', 60, 22000, 'Gói nạp 60 Genesis Crystal'),
(4, '330 Genesis Crystal', 330, 110000, 'Gói nạp 330 Genesis Crystal'),
(4, '1090 Genesis Crystal', 1090, 350000, 'Gói nạp 1090 Genesis Crystal'),
(4, '2240 Genesis Crystal', 2240, 700000, 'Gói nạp 2240 Genesis Crystal'),
(4, '3880 Genesis Crystal', 3880, 1100000, 'Gói nạp 3880 Genesis Crystal');

-- PUBG Mobile (game_id = 5)
INSERT INTO game_packages (game_id, name, diamonds, price, description) VALUES
(5, '60 UC', 60, 22000, 'Gói nạp 60 UC PUBG Mobile'),
(5, '325 UC', 325, 110000, 'Gói nạp 325 UC PUBG Mobile'),
(5, '660 UC', 660, 220000, 'Gói nạp 660 UC PUBG Mobile'),
(5, '1800 UC', 1800, 550000, 'Gói nạp 1800 UC PUBG Mobile'),
(5, '3850 UC', 3850, 1100000, 'Gói nạp 3850 UC PUBG Mobile');
