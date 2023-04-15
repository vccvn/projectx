-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 25, 2021 lúc 04:40 PM
-- Phiên bản máy phục vụ: 10.4.13-MariaDB
-- Phiên bản PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `3dhub`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dynamic_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feature_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `dynamic_id`, `parent_id`, `name`, `type`, `slug`, `keywords`, `description`, `feature_image`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 'Outsourcing', 'project', 'outsourcing', NULL, NULL, NULL, 0, '2020-03-26 18:18:52', '2020-03-26 18:39:09'),
(2, 0, 0, 'Product', 'project', 'product', NULL, NULL, NULL, 0, '2020-03-26 18:37:50', '2020-03-26 18:38:12'),
(3, 3, 0, 'Tài liệu', 'post', 'tai-lieu', NULL, NULL, NULL, 0, '2020-05-02 02:59:42', '2020-06-05 22:40:27'),
(4, 3, 0, 'Công Nghệ', 'post', 'cong-nghe', NULL, NULL, NULL, 0, '2020-05-02 03:05:40', '2020-05-02 03:05:40'),
(5, 2, 0, 'Thiết kế website', 'post', 'thiet-ke-website', NULL, NULL, NULL, 0, '2020-06-01 04:21:12', '2020-06-21 04:51:11'),
(6, 2, 0, 'Web102', 'post', 'web102', NULL, NULL, NULL, 0, '2020-06-01 04:24:26', '2020-06-04 22:18:46'),
(7, 2, 0, 'Design', 'post', 'design', NULL, NULL, NULL, 0, '2020-06-18 21:45:54', '2020-06-21 05:24:21'),
(8, 2, 0, 'Thiết kế đồ họa', 'post', 'thiet-ke-do-hoa', NULL, NULL, NULL, 1, '2020-06-18 21:46:28', '2020-06-21 05:24:48'),
(9, 2, 0, 'Tiên miền và Hosting', 'post', 'tien-mien-va-hosting', NULL, NULL, NULL, 0, '2020-06-18 21:46:58', '2020-06-18 21:46:58'),
(10, 4, 0, 'Giới thiệu', 'post', 'gioi-thieu', NULL, NULL, NULL, 0, '2020-07-07 21:16:26', '2020-07-07 21:16:26'),
(11, 4, 0, 'CMS', 'post', 'cms', NULL, NULL, NULL, 0, '2020-07-09 22:00:42', '2020-07-09 22:00:42'),
(12, 5, 0, 'Giao diện 1-0-2', 'post', 'giao-dien-1-0-2', NULL, NULL, NULL, 0, '2020-07-28 15:06:35', '2020-07-28 22:17:06'),
(13, 5, 0, 'Blog', 'post', 'blog', NULL, NULL, NULL, 0, '2020-07-28 15:06:58', '2020-07-28 15:06:58'),
(14, 5, 0, 'Trang Cá Nhân', 'post', 'trang-ca-nhan', NULL, NULL, NULL, 0, '2020-07-28 15:07:25', '2020-07-28 15:07:25'),
(15, 5, 0, 'Web Công Ty', 'post', 'web-cong-ty', NULL, NULL, NULL, 0, '2020-07-28 15:07:59', '2020-07-28 15:11:02'),
(16, 5, 0, 'Trang Tin Tức', 'post', 'trang-tin-tuc', NULL, NULL, NULL, 0, '2020-07-28 15:08:27', '2020-07-28 15:08:27'),
(17, 5, 0, 'Trang Bán Hàng', 'post', 'trang-ban-hang', NULL, NULL, NULL, 0, '2020-07-28 15:09:12', '2020-07-28 15:09:12'),
(18, 0, 0, 'Nội thất', '3d', 'noi-that', NULL, NULL, NULL, 0, '2021-10-23 03:07:15', '2021-10-23 03:07:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_refs`
--

CREATE TABLE `category_refs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT 0,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'post',
  `ref_id` bigint(20) UNSIGNED DEFAULT 0,
  `author_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT 0,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` tinyint(1) DEFAULT 0,
  `approved_id` bigint(20) UNSIGNED DEFAULT 0,
  `privacy` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `parent_id`, `ref`, `ref_id`, `author_name`, `author_email`, `author_phone`, `author_website`, `author_id`, `message`, `approved`, `approved_id`, `privacy`, `created_at`, `updated_at`) VALUES
(1, 0, 'post', 8, 'Lê Ngọc Doãn', 'doanln16@gmail.com', NULL, NULL, 1, 'crazy-message-content', 1, 0, 'public', '2020-05-05 07:58:37', '2020-05-05 07:58:37'),
(2, 0, 'post', 8, 'Lê Ngọc Doãn', 'doanln16@gmail.com', NULL, NULL, 1, 'crazy-message-content', 1, 0, 'public', '2020-05-05 07:59:17', '2020-05-05 07:59:17'),
(3, 1, 'post', 8, 'Lê Ngọc Doãn', 'doanln16@gmail.com', NULL, NULL, 1, '<i class=\"fa fa-reply\"></i>', 1, 0, 'public', '2020-05-05 08:17:59', '2020-05-05 08:17:59'),
(4, 3, 'post', 8, 'Lê Ngọc Doãn', 'doanln16@gmail.com', NULL, NULL, 1, '4545', 1, 0, 'public', '2020-05-05 08:38:50', '2020-05-05 08:38:50'),
(5, 4, 'post', 8, 'Lê Ngọc Doãn', 'doanln16@gmail.com', NULL, NULL, 1, '&.reply-level-5{', 1, 0, 'public', '2020-05-05 09:13:16', '2020-05-05 09:13:16'),
(6, 0, 'post', 16, 'Lê Ngọc Doãn', 'doanln16@gmail.com', NULL, NULL, 1, ',\n    \'module_class\' => \'single\'', 1, 0, 'public', '2020-06-01 08:56:43', '2020-06-01 08:56:43'),
(7, 6, 'post', 16, 'T', 'doanln16@gmail.com', NULL, NULL, 0, 'Th', 1, 0, 'public', '2020-08-02 00:06:49', '2020-08-02 00:06:49'),
(8, 0, 'post', 33, 'Lê Ngọc Doãn', 'doanln16@gmail.com', NULL, NULL, 1, '12', 1, 0, 'public', '2020-09-29 03:41:42', '2020-09-29 03:41:42'),
(9, 0, 'project', 1, 'FidelRig', 'herbiejwwgorman@gmx.com', NULL, 'https://proverka.net', 0, 'MEET HOT LOCAL GIRLS TONIGHT WE GUARANTEE FREE SEX DATING IN YOUR CITY CLICK THE LINK: \r\n<a href=\"https://about.me/alexa.smith\">FREE SEX</a>', 1, 0, 'public', '2021-08-03 07:41:27', '2021-08-03 07:41:27'),
(10, 0, 'post', 8, 'Dannypip', 'temptest565914929@gmail.com', NULL, 'https://swiy.io/5dyc', 0, 'BTC may be the latest or last chance to get rich in this era. It will reach $200000 next year or the next year. \r\n \r\nThink about only $2 a few years ago. Come to the world\'s largest and safest virtual currency exchange to reduce the handling fee. Don\'t miss the most important opportunity in life \r\n \r\nhttps://hi.switchy.io/5dyf', 1, 0, 'public', '2021-09-13 10:11:19', '2021-09-13 10:11:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `components`
--

CREATE TABLE `components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'custom',
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` bigint(20) UNSIGNED DEFAULT 0,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inputs` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `components`
--

INSERT INTO `components` (`id`, `type`, `ref`, `ref_id`, `name`, `path`, `inputs`, `data`) VALUES
(1, 'blade', 'theme', 1, 'Banner quảng cáo (1248 x 130)', 'block-ads-wide', '{\"banner\":{\"type\":\"file\",\"label\":\"Banner\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"text\":{\"type\":\"text\",\"label\":\"Text\"},\"type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i qu\\u1ea3ng c\\u00e1o\",\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"},\"code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 qu\\u1ea3ng c\\u00e1o\"}}', '[]'),
(2, 'blade', 'theme', 1, 'Footer Column: Giới thiệu', 'footer-column-about', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"Gi\\u1edbi thi\\u1ec7u\"},\"about_content\":{\"type\":\"textarea\",\"label\":\"N\\u1ed9i dung\",\"className\":\"auto-height\"},\"show_logo\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb logo\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"show_text_logo\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb text logo\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"text_logo_primary\":{\"type\":\"text\",\"label\":\"Text Logo (ch\\u00ednh)\",\"value\":\"Tin T\\u1ee9c\"},\"text_logo_second\":{\"type\":\"text\",\"Label\":\"Text Logo (b\\u1ed5 xung)\",\"value\":\"24\\/7\"},\"highlight\":{\"type\":\"select\",\"label\":\"l\\u00e0m n\\u1ed5i b\\u1eadt\",\"data\":{\"none\":\"Kh\\u00f4ng\",\"primary\":\"Text ch\\u00ednh\",\"second\":\"Text ph\\u1ee5\",\"both\":\"T\\u1ea5t c\\u1ea3\"},\"default\":\"second\"},\"text_logo_slogan\":{\"type\":\"text\",\"Label\":\"Kh\\u1ea9u hi\\u1ec7u\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"}}', '[]'),
(3, 'blade', 'theme', 1, 'Footer Column: tin bài', 'footer-column-posts', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 \"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":4}}', '[]'),
(4, 'blade', 'theme', 1, 'Footer Column: Thẻ bài viết (tags)', 'footer-column-tags', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 \"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_tag_sortby_options\"},\"tag_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":4}}', '[]'),
(5, 'blade', 'theme', 1, 'Home: Lưới với tin đầu làm nổi bật', 'grid-first-large-thumbail', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1\",\"call\":\"get_number_options\",\"params\":[1,12]},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":4}}', '[]'),
(6, 'blade', 'theme', 1, 'Home: Banner quảng cáo (820 x 130)', 'home-ads-wide', '{\"banner\":{\"type\":\"file\",\"label\":\"Banner\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"text\":{\"type\":\"text\",\"label\":\"Text\"},\"type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i qu\\u1ea3ng c\\u00e1o\",\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"},\"code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 qu\\u1ea3ng c\\u00e1o\"}}', '[]'),
(7, 'blade', 'theme', 1, 'Home: Banner quảng cáo (1240 x 130)', 'home-bottom-ads', '{\"banner\":{\"type\":\"file\",\"label\":\"Banner\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"text\":{\"type\":\"text\",\"label\":\"Text\"},\"type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i qu\\u1ea3ng c\\u00e1o\",\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"},\"code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 qu\\u1ea3ng c\\u00e1o\"}}', '[]'),
(8, 'blade', 'theme', 1, 'Breaking news & Slider', 'home-breaking-and-slider', '{\"slider_sort_type\":{\"type\":\"crazyselect\",\"label\":\"Ki\\u1ec3u s\\u1eafp x\\u1ebfp tin trong ph\\u1ea7n slider news\",\"call\":\"get_post_sortby_options\",\"default\":1},\"slider_number_post\":{\"type\":\"crazyswlect\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng tin trong ph\\u1ea7n slider news\",\"data\":{\"4\":\"4 Tin (1 slider)\",\"8\":\"8 Tin (2 slider)\",\"12\":\"12 Tin (3 slider)\",\"16\":\"16 Tin (4 slider)\",\"20\":\"20 Tin (5 slider)\"},\"default\":16}}', '[]'),
(9, 'blade', 'theme', 1, 'Home: Tin bài dạng slider (Carousel)', 'home-carouse', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}', '[]'),
(10, 'blade', 'theme', 1, 'Home: Danh sách dạng lưới', 'home-grid-list', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1\",\"call\":\"get_number_options\",\"params\":[1,12]},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":4}}', '[]'),
(11, 'blade', 'theme', 1, 'Home: Lưới & sidebar (style 2)', 'home-grid-sidebar-style-2', '{\"first_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 1 (T\\u00f9y ch\\u1ecdn)\"},\"first_sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"first_bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 1\",\"call\":\"get_number_options\",\"params\":[1,12]},\"first_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"K\\u00eanh \\u0111\\u0103ng b\\u00e0i c\\u1ee7a m\\u1ee5c 1 (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"first_category_id\",\"required\":\"true\"},\"first_category_id\":{\"type\":\"crazyselect\",\"label\":\"Ch\\u1ee7 \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 1\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#first_dynamic_id\"},true],\"@label-type\":\"value\"},\"first_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp c\\u1ee7a m\\u1ee5c 1 \",\"call\":\"get_post_sortby_options\"},\"second_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 2 (T\\u00f9y ch\\u1ecdn)\"},\"second_sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"second_bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 2\",\"call\":\"get_number_options\",\"params\":[1,12]},\"second_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"K\\u00eanh \\u0111\\u0103ng b\\u00e0i c\\u1ee7a m\\u1ee5c 2 (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"second_category_id\",\"required\":\"true\"},\"second_category_id\":{\"type\":\"crazyselect\",\"label\":\"Ch\\u1ee7 \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 2\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#second_dynamic_id\"},true],\"@label-type\":\"value\"},\"second_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp c\\u1ee7a m\\u1ee5c 2 \",\"call\":\"get_post_sortby_options\"}}', '[]'),
(12, 'blade', 'theme', 1, 'Home: Lưới 2 mục & sidebar', 'home-grid-sidebar', '{\"first_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 1 (T\\u00f9y ch\\u1ecdn)\"},\"first_sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"first_bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 1\",\"call\":\"get_number_options\",\"params\":[1,12]},\"first_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"K\\u00eanh \\u0111\\u0103ng b\\u00e0i c\\u1ee7a m\\u1ee5c 1 (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"first_category_id\",\"required\":\"true\"},\"first_category_id\":{\"type\":\"crazyselect\",\"label\":\"Ch\\u1ee7 \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 1\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#first_dynamic_id\"},true],\"@label-type\":\"value\"},\"first_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp c\\u1ee7a m\\u1ee5c 1 \",\"call\":\"get_post_sortby_options\"},\"second_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 2 (T\\u00f9y ch\\u1ecdn)\"},\"second_sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"second_bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 2\",\"call\":\"get_number_options\",\"params\":[1,12]},\"second_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"K\\u00eanh \\u0111\\u0103ng b\\u00e0i c\\u1ee7a m\\u1ee5c 2 (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"second_category_id\",\"required\":\"true\"},\"second_category_id\":{\"type\":\"crazyselect\",\"label\":\"Ch\\u1ee7 \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 2\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#second_dynamic_id\"},true],\"@label-type\":\"value\"},\"second_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp c\\u1ee7a m\\u1ee5c 2 \",\"call\":\"get_post_sortby_options\"},\"sidebar_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a sidebar (T\\u00f9y ch\\u1ecdn)\"},\"sidebar_link\":{\"type\":\"text\",\"label\":\"Url (T\\u00f9y ch\\u1ecdn)\"},\"sidebar_bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a sidebar\",\"call\":\"get_number_options\",\"params\":[1,12]},\"sidebar_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"K\\u00eanh \\u0111\\u0103ng b\\u00e0i c\\u1ee7a sidebar (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"sidebar_category_id\",\"required\":\"true\"},\"sidebar_category_id\":{\"type\":\"crazyselect\",\"label\":\"Ch\\u1ee7 \\u0111\\u1ec1 c\\u1ee7a sidebar\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#sidebar_dynamic_id\"},true],\"@label-type\":\"value\"},\"sidebar_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp c\\u1ee7a sidebar \",\"call\":\"get_post_sortby_options\"},\"sidebar_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}', '[]'),
(13, 'blade', 'theme', 1, 'Home: Intro (Giới thiệu)', 'home-intro', '{\"image\":{\"type\":\"file\",\"label\":\"\\u1ea2nh\"},\"text\":{\"type\":\"textarea\",\"label\":\"Text\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"button_text\":{\"type\":\"text\",\"label\":\"Button Text\"}}', '{\"button_text\":\"Xem th\\u00eam\"}'),
(14, 'blade', 'theme', 1, 'Home: Danh sách & sidebar style 2', 'home-list-sidebar-2', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1\",\"call\":\"get_number_options\",\"params\":[1,12]},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":5},\"sidebar_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 sidebar (T\\u00f9y ch\\u1ecdn)\"},\"sidebar_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c \\u1edf sidebar (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"data-ref\":\"sidebar_category_id\",\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"sidebar_category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c \\u1edf sidebar\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#sidebar_dynamic_id\"},true],\"@label-type\":\"value\"},\"sidebar_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp \\u1edf sidebar\",\"call\":\"get_post_sortby_options\"},\"sidebar_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i \\u1edf sidebar\",\"min\":1,\"step\":1,\"default\":10},\"show_news_video\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb video m\\u1edbi nh\\u1ea5t\"}}', '{\"sidebar_title\":\"Tin m\\u1edbi nh\\u1ea5t\"}'),
(15, 'blade', 'theme', 1, 'Home: Danh sách & sidebar', 'home-list-sidebar', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1\",\"call\":\"get_number_options\",\"params\":[1,12,\"default\",\"default\"]},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":5},\"sidebar_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 sidebar (T\\u00f9y ch\\u1ecdn)\"},\"sidebar_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i \\u1edf sidebar\",\"min\":1,\"step\":1,\"default\":10},\"sidebar_banner\":{\"type\":\"file\",\"label\":\"Sidebar Banner\"},\"sidebar_link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"ads_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i qu\\u1ea3ng c\\u00e1o\",\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"},\"ads_code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 qu\\u1ea3ng c\\u00e1o\"}}', '{\"sidebar_title\":\"Tin m\\u1edbi nh\\u1ea5t\"}'),
(16, 'blade', 'theme', 1, 'Home: Danh sách & Menu danh mục', 'home-list-with-children-category', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1\",\"call\":\"get_number_options\",\"params\":[1,12]},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"children_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 danh m\\u1ee5c con\",\"min\":1,\"step\":1,\"default\":15},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":5},\"menu_type\":{\"type\":\"crazyselect\",\"label\":\"Ki\\u1ec3u menu\",\"data\":{\"children\":\"Danh m\\u1ee5c con\",\"menu\":\"Menu\"},\"default\":\"children\"},\"menu_id\":{\"type\":\"crazyselect\",\"label\":\"Menu\",\"call\":\"get_menu_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"]},\"sidebar_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 sidebar (T\\u00f9y ch\\u1ecdn)\"},\"sidebar_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i \\u1edf sidebar\",\"min\":1,\"step\":1,\"default\":10}}', '{\"sidebar_title\":\"Tin m\\u1edbi nh\\u1ea5t\"}'),
(17, 'blade', 'theme', 1, 'Home: Giói thiệu (Hình nền và text)', 'home-parallax', '{\"background\":{\"type\":\"file\",\"label\":\"\\u1ea2nh\"},\"medium_caption\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 tr\\u00ean (T\\u00f9y ch\\u1ecdn)\"},\"large_caption\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ch\\u00ednh\"},\"second_caption\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\"}}', '[]'),
(18, 'blade', 'theme', 1, 'Home: Tin bài dạng slider (Carousel Gallery)', 'home-post-gallery', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft trong ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"text\":{\"type\":\"text\",\"label\":\"Text c\\u1ee7a li\\u00ean k\\u1ebft trong ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"mark_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 b\\u00f4i m\\u00e0u (T\\u00f9y ch\\u1ecdn)\"},\"gallery_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 gallery (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}', '[]'),
(19, 'blade', 'theme', 1, 'Home: Quote - trính dẫn', 'home-quote', '{\"label\":{\"type\":\"text\",\"label\":\"Nh\\u00e3n (T\\u00f9y ch\\u1ecdn)\"},\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"description\":{\"type\":\"text\",\"label\":\"M\\u00f4 t\\u1ea3 ()\"},\"image\":{\"type\":\"file\",\"label\":\"\\u1ea2nh\"},\"button_text\":{\"type\":\"text\",\"label\":\"Button Text\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"}}', '{\"button_text\":\"Xem th\\u00eam\"}'),
(20, 'blade', 'theme', 1, 'Home: Video', 'home-videos', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 sidebar\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":3}}', '[]'),
(21, 'blade', 'theme', 1, 'Home: Parallax', 'parallax', '{\"sub_title_before\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 nh\\u1ecf (t\\u00f9y ch\\u1ecdn)\"},\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ch\\u00ednh\"},\"sub_title_after\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (t\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"},\"background\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"}}', '[]'),
(22, 'blade', 'theme', 1, 'Tin bài dạng slider (Carousel)', 'posts-carousel', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}', '[]'),
(23, 'blade', 'theme', 1, 'Sidebar: Banner quảng cáo (400 x __)', 'sidebar-ads', '{\"banner\":{\"type\":\"file\",\"label\":\"Banner\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"text\":{\"type\":\"text\",\"label\":\"Text\"},\"type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i qu\\u1ea3ng c\\u00e1o\",\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"},\"code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 qu\\u1ea3ng c\\u00e1o\"}}', '[]'),
(24, 'blade', 'theme', 1, 'Sidebar: Lịch', 'sidebar-calendar', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"lang\":{\"type\":\"radio\",\"label\":\"Ng\\u00f4n ng\\u1eef\",\"data\":{\"vi\":\"Ti\\u1ebfng Vi\\u1ec7t\",\"en\":\"Ti\\u1ebfng Anh\"},\"default\":\"vi\"}}', '[]'),
(25, 'blade', 'theme', 1, 'Sidebar: Đăng ký nhận tin', 'sidebar-newsletter', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"V\\u00ed d\\u1ee5: \\u0110\\u0103ng k\\u00fd theo d\\u00f5i\"},\"placeholder\":{\"type\":\"text\",\"label\":\"Placeholder (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"V\\u00ed d\\u1ee5: Nh\\u1eadp email c\\u1ee7a b\\u1ea1n\"},\"button\":{\"type\":\"text\",\"label\":\"N\\u00fat \\u0111\\u0103ng k\\u00fd\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"}}', '{\"title\":\"D\\u0103ng k\\u00fd nh\\u1eadn tin\",\"placeholder\":\"V\\u00ed d\\u1ee5: Nh\\u1eadp email c\\u1ee7a b\\u1ea1n\",\"button\":\"N\\u00fat \\u0111\\u0103ng k\\u00fd\"}'),
(26, 'blade', 'theme', 1, 'Sidebar: Danh sách tin bài (style 1)', 'sidebar-post-list-1', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"default\":\"Tin m\\u1edbi nh\\u1ea5t\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}', '[]'),
(27, 'blade', 'theme', 1, 'Sidebar: Liên kết mạng xã hội', 'sidebar-socials', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"V\\u00ed d\\u1ee5 k\\u1ebft n\\u1ed1i v\\u1edbi ch\\u00fang t\\u00f4i\"},\"facebook\":{\"type\":\"text\",\"label\":\"facebook (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"},\"twitter\":{\"type\":\"text\",\"label\":\"twitter (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"},\"youtube\":{\"type\":\"text\",\"label\":\"youtube (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"},\"linkedin\":{\"type\":\"text\",\"label\":\"Linkedin (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"},\"instagram\":{\"type\":\"text\",\"label\":\"instagram (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"},\"pinterest\":{\"type\":\"text\",\"label\":\"Pinterest (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"}}', '{\"title\":\"K\\u1ebft n\\u1ed1i v\\u1edbi ch\\u00fang t\\u00f4i\"}'),
(28, 'blade', 'theme', 1, 'Sidebar: Thông tin thời tiết', 'sidebar-weather', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"scale\":{\"type\":\"crazyselect\",\"label\":\"Thang nhi\\u1ec7u \\u0111\\u1ed9\",\"template\":\"crazyselect\",\"data\":{\"C\":\"\\u0110\\u1ed9 C\",\"F\":\"\\u0110\\u1ed9 F\"},\"required\":\"true\"},\"lat\":{\"type\":\"text\",\"label\":\"V\\u0129 \\u0111\\u1ed9 (latitude)\"},\"long\":{\"type\":\"text\",\"label\":\"V\\u0129 \\u0111\\u1ed9 (longitude)\"}}', '[]'),
(29, 'blade', 'theme', 1, 'Chi tiết tin: Tin lên quan', 'single-related-posts', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"select\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"data\":{\"3\":3,\"6\":6,\"9\":0,\"12\":12},\"default\":3}}', '[]'),
(30, 'blade', 'theme', 2, 'Gói dịch vụ (Package Item)', 'package-item', '{\"name\":{\"type\":\"text\",\"label\":\"T\\u00ean g\\u00f3i\",\"placeholder\":\"V\\u00ed d\\u1ee5: Tin t\\u1ee9c\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\",\"placeholder\":\"V\\u00ed d\\u1ee5: 1 n\\u0103m b\\u1ea3o h\\u00e0nh\\nMi\\u1ec3n ph\\u00ed hosting\\nNi\\u1ec5n ph\\u00ed t\\u00ean mi\\u1ec1n\\n...\"},\"price_text\":{\"type\":\"text\",\"label\":\"Gi\\u00e1\",\"value\":\"0\"},\"active\":{\"type\":\"switch\",\"label\":\"N\\u1ed5i b\\u1eadt\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"btn_text\":{\"type\":\"text\",\"label\":\"N\\u00fat xem th\\u00eam\",\"value\":\"\\u0110\\u0103ng k\\u00fd\"},\"class_name\":{\"type\":\"text\",\"label\":\"Class Name\",\"value\":\"col-md-6\"}}', '[]'),
(31, 'blade', 'theme', 2, 'Promo Item', 'promo-item', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"description\":{\"type\":\"text\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\"},\"icon\":{\"type\":\"text\",\"label\":\"Icon ClassName\",\"placeholder\":\"V\\u00ed d\\u1ee5: ti-vector\"}}', '[]'),
(32, 'blade', 'theme', 2, 'Dịch vụ (service item)', 'service-item', '{\"name\":{\"type\":\"text\",\"label\":\"T\\u00ean d\\u1ecbch v\\u1ee5\",\"placeholder\":\"V\\u00ed d\\u1ee5: thi\\u1ebft k\\u1ebf website\"},\"description\":{\"type\":\"text\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\",\"value\":\"\",\"placeholder\":\"\"},\"use_label\":{\"type\":\"switch\",\"label\":\"Th\\u00eam nh\\u00e3n\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\"},\"label_text\":{\"type\":\"text\",\"label\":\"Nh\\u00e3n\",\"value\":\"\",\"placeholder\":\"V\\u00ed d\\u1ee5 Good\"},\"label_class\":{\"type\":\"crazyselect\",\"label\":\"Lo\\u1ea1i nh\\u00e3n\",\"value\":\"success\",\"data\":{\"success\":\"Success (Xanh l\\u00e1)\",\"danger\":\"Danger (\\u0110\\u1ecf)\"}},\"icon\":{\"type\":\"text\",\"label\":\"Icon ClassName\",\"placeholder\":\"V\\u00ed d\\u1ee5: fa fa-bolt\",\"value\":\"fa fa-bolt\"}}', '[]'),
(33, 'blade', 'theme', 2, 'Thành viên trong nhóm (team member)', 'team-member', '{\"name\":{\"type\":\"text\",\"label\":\"T\\u00ean th\\u00e0nh vi\\u00ean\",\"placeholder\":\"V\\u00ed d\\u1ee5: Thi\\u1ec7n CH\"},\"avatar\":{\"type\":\"file\",\"label\":\"Avatar\"},\"job\":{\"type\":\"text\",\"label\":\"c\\u00f4ng vi\\u1ec7c (V\\u1ecb tr\\u00ed l\\u00e0m vi\\u1ec7c)\"},\"is_loader\":{\"type\":\"switch\",\"label\":\"Tr\\u01b0\\u1edfng nh\\u00f3m?\",\"value_type\":\"boolean\"}}', '[]'),
(34, 'blade', 'theme', 2, 'Thông tin phản hồi (Testimonial item)', 'testimonial-item', '{\"name\":{\"type\":\"text\",\"label\":\"t\\u00ean ng\\u01b0\\u1eddi ph\\u1ea3n h\\u1ed3i\",\"placeholder\":\"V\\u00ed d\\u1ee5: Nguy\\u1ec5n V\\u0103n A\"},\"image\":{\"type\":\"file\",\"label\":\"\\u00c3nh \\u0111\\u1ea1i di\\u1ec7n\"},\"job\":{\"type\":\"text\",\"label\":\"C\\u00f4ng vi\\u1ec7c\",\"placeholder\":\"V\\u00ed d\\u1ee5: CEO\"},\"content\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\",\"placeholder\":\"V\\u00ed d\\u1ee5: Very grateful to have found this app. D&L team did a fantastic job...\"}}', '[]'),
(35, 'blade', 'theme', 3, 'Footer: Giới thiệu', 'footer.about', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"Gi\\u1edbi thi\\u1ec7u\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"}}', '[]'),
(36, 'blade', 'theme', 3, 'Footer: Liên hệ', 'footer.contact', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"email\":{\"type\":\"text\",\"Label\":\"Email\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb m\\u1ee5c li\\u00ean h\\u1ec7\"},\"phone_number\":{\"type\":\"text\",\"Label\":\"S\\u1ed1 \\u0111i\\u1ec7n tho\\u1ea1i\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb m\\u1ee5c li\\u00ean h\\u1ec7\"},\"address\":{\"type\":\"text\",\"Label\":\"\\u0110\\u1ecba ch\\u1ec9\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb m\\u1ee5c li\\u00ean h\\u1ec7\"}}', '[]'),
(37, 'blade', 'theme', 3, 'Footer: Liên kết / menu', 'footer.limks', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"menu_id\":{\"type\":\"crazyselect\",\"label\":\"Menu\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"call\":\"get_menu_options\"}}', '[]'),
(38, 'blade', 'theme', 3, 'Footer: Danh sách bài viết', 'footer.possts', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":4}}', '[]'),
(39, 'blade', 'theme', 3, 'Home: banner > Style 1', 'home.banners.style-1', '{\"slider_id\":{\"type\":\"crazyselect\",\"label\":\"Slider\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"call\":\"get_slider_options\"},\"btn_text\":{\"type\":\"text\",\"label\":\"N\\u00fat b\\u1ea5m\",\"placeholder\":\"Ch\\u1eef s\\u1ebd \\u0111\\u01b0\\u1ee3c hi\\u1ec3n th\\u1ecb tr\\u00ean n\\u00fat xem th\\u00eam\"}}', '[]'),
(40, 'blade', 'theme', 3, 'Home: Giới thiệu', 'home.about.style-1', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"content\":{\"type\":\"textarea\",\"label\":\"Gi\\u1edbi thi\\u1ec7u\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"image\":{\"type\":\"file\",\"label\":\"\\u1ea2nh minh h\\u1ecda\"},\"youtube_url\":{\"type\":\"text\",\"label\":\"Video Youtube\"},\"services\":{\"type\":\"textarea\",\"label\":\"D\\u1ecbch v\\u1ee5 n\\u1edfi b\\u1eadt\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\\nM\\u1ed5i d\\u1ecbch v\\u1ee5 m\\u1ed9t d\\u00f2ng\",\"className\":\"auto-height\"}}', '[]'),
(41, 'blade', 'theme', 3, 'Home: Các dịch vụ (Service Area)', 'home.services.area', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"bg_default_color\":{\"type\":\"radio\",\"label\":\"M\\u00e0u c\\u00f3 s\\u1eb5n\",\"data\":{\"\":\"Kh\\u00f4ng\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}},\"bg_color\":{\"type\":\"text\",\"label\":\"M\\u00e3 m\\u00e0u (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"},\"bg_image\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"bg_position\":{\"type\":\"radio\",\"label\":\"V\\u1ecb tr\\u00ed \\u1ea3nh\",\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}},\"bg_half\":{\"type\":\"switch\",\"label\":\"Bg Half\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb m\\u1ed9t n\\u1eeda h\\u00ecnh n\\u1ec1n\",\"value_type\":\"boolean\"},\"advance\":{\"type\":\"checklist\",\"label\":\"N\\u00e2ng cao\",\"data\":{\"shadow\":\"shadow\",\"dark\":\"dark\",\"dark-hard\":\"dark-hard\",\"light\":\"light\",\"theme\":\"theme\",\"theme-hard\":\"theme-hard\"}},\"class_name\":{\"type\":\"text\",\"label\":\"Class (T\\u00f9y ch\\u1ecdn)\"}}', '[]'),
(42, 'blade', 'theme', 3, 'Home: Dịch vụ (Service Item)', 'home.services.item', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 \"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"link\":{\"type\":\"text\",\"label\":\"\\u0110\\u01b0\\u1eddng d\\u1eabn\"},\"icon\":{\"type\":\"text\",\"label\":\"Bi\\u1ec3u t\\u01b0\\u1ee3ng (ti-...)\",\"template\":\"iconpicker\"}}', '[]'),
(43, 'blade', 'theme', 3, 'Home: Facts', 'home.facts', '{\"fact_1\":{\"type\":\"textarea\",\"label\":\"Fact 1\",\"placeholder\":\"Ti\\u00eau \\u0111\\u1ec1 (ho\\u1eb7c s\\u1ed1)...\\nTi\\u00eau \\u0111\\u1ec1 ph\\u1ee5..\\nN\\u1ed9i dung... \",\"className\":\"auto-height\"},\"fact_2\":{\"type\":\"textarea\",\"label\":\"Fact 2\",\"placeholder\":\"Ti\\u00eau \\u0111\\u1ec1 (ho\\u1eb7c s\\u1ed1)...\\nTi\\u00eau \\u0111\\u1ec1 ph\\u1ee5..\\nN\\u1ed9i dung... \",\"className\":\"auto-height\"},\"line_1\":{\"type\":\"text\",\"label\":\"Ti\\u1ebfn tr\\u00ecnh 1\",\"placeholder\":\"Ti\\u00eau \\u0111\\u1ec1 = s\\u1ed1 (%)\"},\"line_2\":{\"type\":\"text\",\"label\":\"Ti\\u1ebfn tr\\u00ecnh 2\",\"placeholder\":\"Ti\\u00eau \\u0111\\u1ec1 = s\\u1ed1 (%)\"},\"line_3\":{\"type\":\"text\",\"label\":\"Ti\\u1ebfn tr\\u00ecnh 3\",\"placeholder\":\"Ti\\u00eau \\u0111\\u1ec1 = s\\u1ed1 (%)\"}}', '[]'),
(44, 'blade', 'theme', 3, 'Home: Portfolio', 'home.portfolio', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"D\\u1ef1 \\u00e1n\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"sorttype\":{\"type\":\"crazyselect\",\"label\":\"Ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_project_sortby_options\",\"value\":1},\"project_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":10}}', '[]'),
(45, 'blade', 'theme', 3, 'Home: Testimonials (area)', 'home.testimonials.area', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u danh s\\u00e1ch\",\"data\":{\"data\":\"Trong b\\u1ea3ng ph\\u1ea3n h\\u1ed3i\",\"custom\":\"Danh s\\u00e1ch t\\u00f9y bi\\u1ebfn\"},\"value\":\"custom\"},\"item_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":5},\"sort_type\":{\"type\":\"crazyselect\",\"label\":\"S\\u1eafp x\\u1ebfp\",\"data\":{\"id-ASC\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"id-DESC\":\"M\\u1edbi nh\\u1ea5t\",\"name-ASC\":\"h\\u1ee9 t\\u1ef1 b\\u1ea3ng ch\\u1ef1 c\\u00e1i\"},\"value\":\"id-ASC\"}}', '[]'),
(46, 'blade', 'theme', 3, 'Home: Testimonials Item', 'home.testimonials.item', '{\"name\":{\"type\":\"text\",\"label\":\"t\\u00ean ng\\u01b0\\u1eddi ph\\u1ea3n h\\u1ed3i\",\"placeholder\":\"V\\u00ed d\\u1ee5: Nguy\\u1ec5n V\\u0103n A\"},\"image\":{\"type\":\"file\",\"label\":\"\\u00c3nh \\u0111\\u1ea1i di\\u1ec7n\"},\"job\":{\"type\":\"text\",\"label\":\"C\\u00f4ng vi\\u1ec7c\",\"placeholder\":\"V\\u00ed d\\u1ee5: CEO\"},\"content\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\",\"placeholder\":\"V\\u00ed d\\u1ee5: Very grateful to have found this app. D&L team did a fantastic job...\"}}', '[]'),
(47, 'blade', 'theme', 3, 'Home: Team (area)', 'home.team.area', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"background\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u danh s\\u00e1ch\",\"data\":{\"data\":\"Trong b\\u1ea3ng Nh\\u00f3m\",\"custom\":\"Danh s\\u00e1ch t\\u00f9y bi\\u1ebfn\"},\"value\":\"custom\"},\"team_id\":{\"type\":\"crazyselect\",\"label\":\"Nh\\u00f3m\",\"call\":\"get_team_options\",\"params\":[[],\"Ch\\u1ecdn nh\\u00f3m\"]},\"item_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":4},\"sort_type\":{\"type\":\"crazyselect\",\"label\":\"S\\u1eafp x\\u1ebfp\",\"data\":{\"id-ASC\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"id-DESC\":\"M\\u1edbi nh\\u1ea5t\",\"users.name-ASC\":\"th\\u1ee9 t\\u1ef1 b\\u1ea3ng ch\\u1ef1 c\\u00e1i\",\"is_leader-DESC\":\"\\u01afu ti\\u00ean tr\\u01b0\\u1edfng nh\\u00f3m\",\"job-ASC\":\"C\\u00f4ng vi\\u1ec7c (A-z)\",\"rand()\":\"Ng\\u1eabu nhi\\u00ean\"},\"value\":\"id-ASC\"}}', '[]'),
(48, 'blade', 'theme', 3, 'Home: Team Member', 'home.team.item', '{\"name\":{\"type\":\"text\",\"label\":\"T\\u00ean th\\u00e0nh vi\\u00ean\",\"placeholder\":\"V\\u00ed d\\u1ee5: Thi\\u1ec7n CH\"},\"avatar\":{\"type\":\"file\",\"label\":\"Avatar\"},\"job\":{\"type\":\"text\",\"label\":\"c\\u00f4ng vi\\u1ec7c (V\\u1ecb tr\\u00ed l\\u00e0m vi\\u1ec7c)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft (T\\u00f9y ch\\u1ecdn)\"},\"is_loader\":{\"type\":\"switch\",\"label\":\"Tr\\u01b0\\u1edfng nh\\u00f3m?\",\"value_type\":\"boolean\"}}', '[]'),
(49, 'blade', 'theme', 3, 'Home: Mục liên hệ', 'home.contact.area', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"faq_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 FAQ (T\\u00f9y ch\\u1ecdn)\"}}', '[]'),
(50, 'blade', 'theme', 3, 'Home: Mục liên hệ - FAQ', 'home.contact.faq', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 \"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"}}', '[]'),
(51, 'blade', 'theme', 3, 'Home: Danh sách bài viết', 'home.posts', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"background\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":3}}', '[]'),
(52, 'blade', 'theme', 3, 'Home: Báo giá (area)', 'home.pricing.area', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"}}', '[]'),
(53, 'blade', 'theme', 3, 'Home: Báo giá (item)', 'home.pricing.item', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"placeholder\":\"V\\u00ed d\\u1ee5: Th\\u01b0\\u01a1ng m\\u1ea1i \\u0111i\\u1ec7n t\\u1eed\"},\"label\":{\"type\":\"text\",\"label\":\"Nh\\u00e3n (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"V\\u00ed d\\u1ee5: HOT\"},\"price_label\":{\"type\":\"text\",\"label\":\"Nh\\u00e3n gi\\u00e1 (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"V\\u00ed d\\u1ee5: Ch\\u1ec9 t\\u1eeb\",\"default\":\"Ch\\u1ec9 t\\u1eeb\"},\"price\":{\"type\":\"number\",\"label\":\"Gi\\u00e1\",\"default\":0,\"min\":0},\"unit\":{\"type\":\"text\",\"label\":\"\\u0110\\u01a1n v\\u1ecb ti\\u1ec1n\",\"placeholder\":\"V\\u00ed d\\u1ee5: VN\\u0110, $, ...\",\"default\":\"VN\\u0110\"},\"content\":{\"type\":\"textarea\",\"label\":\"N\\u1ed9i dung (danh s\\u00e1ch t\\u00ednh n\\u0103ng)\",\"placeholder\":\"V\\u00ed d\\u1ee5: [true] Mi\\u1ec3n ph\\u00ed hosting\\n[false] Gi\\u1edbi h\\u1ea1n t\\u00ean mi\\u1ec1n\",\"className\":\"auto-height\"},\"active\":{\"type\":\"switch\",\"label\":\"Active (k\\u00edch ho\\u1ea1t)\",\"value_type\":\"boolean\"},\"link\":{\"type\":\"text\",\"label\":\"Link \\u0111\\u0103ng k\\u00fd\",\"placeholder\":\"Nh\\u1eadp link\"}}', '[]'),
(54, 'blade', 'theme', 3, 'Sidebar: Danh mục', 'sidebar.categories', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"get_by_dynamic_active\":{\"type\":\"switch\",\"label\":\"\\u01afu ti\\u00ean m\\u1ee5c \\u0111ang xem\",\"value_type\":\"boolean\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"parent_id\"},\"parent_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c Cha\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_category_sortby_options\"}}', '[]');
INSERT INTO `components` (`id`, `type`, `ref`, `ref_id`, `name`, `path`, `inputs`, `data`) VALUES
(55, 'blade', 'theme', 3, 'Sidebar: Danh sách tin bài', 'sidebar.posts', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"default\":\"Tin m\\u1edbi nh\\u1ea5t\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}', '[]'),
(56, 'blade', 'theme', 3, 'Sidebar: Tìm kiếm', 'sidebar.search', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"default\":\"T\\u00ecm ki\\u1ebfm\"}}', '[]'),
(57, 'blade', 'theme', 3, 'Mạng xã hội', 'sidebar.social', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"facebook\":{\"type\":\"text\",\"label\":\"facebook (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c (M\\u1eb7c \\u0111\\u1ecbnh theo m\\u1ee5c social)\"},\"twitter\":{\"type\":\"text\",\"label\":\"twitter (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c (M\\u1eb7c \\u0111\\u1ecbnh theo m\\u1ee5c social)\"},\"youtube\":{\"type\":\"text\",\"label\":\"youtube (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c (M\\u1eb7c \\u0111\\u1ecbnh theo m\\u1ee5c social)\"},\"linkedin\":{\"type\":\"text\",\"label\":\"Linkedin (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c (M\\u1eb7c \\u0111\\u1ecbnh theo m\\u1ee5c social)\"},\"instagram\":{\"type\":\"text\",\"label\":\"instagram (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c (M\\u1eb7c \\u0111\\u1ecbnh theo m\\u1ee5c social)\"},\"pinterest\":{\"type\":\"text\",\"label\":\"Pinterest (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c (M\\u1eb7c \\u0111\\u1ecbnh theo m\\u1ee5c social)\"}}', '[]'),
(58, 'blade', 'theme', 3, 'Sidebar: Thẻ bài viết (tags)', 'sidebar.tags', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_tag_sortby_options\"},\"tag_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}', '[]'),
(59, 'blade', 'theme', 3, 'Project Sidebar: Danh mục Dự án', 'sidebar-project.categories', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_project_category_sortby_options\"}}', '[]'),
(60, 'blade', 'theme', 3, 'Home: Mục liên hệ', 'contacts.area', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"faq_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 FAQ (T\\u00f9y ch\\u1ecdn)\"}}', '[]'),
(61, 'blade', 'theme', 3, 'Mục liên hệ - FAQ', 'contacts.faq', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 \"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"}}', '[]'),
(62, 'blade', 'theme', 4, 'Các dịch vụ (service area)', 'services.area', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c \\u0111\\u0103ng d\\u1ecbch v\\u1ee5 (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft (t\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp li\\u00ean k\\u1ebft. (Kh\\u00f4ng b\\u1eaft bu\\u1ed9c)\"}}', '[]'),
(63, 'blade', 'theme', 4, 'Chi tiết dịch vụ (Service item)', 'services.item', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"url\":{\"type\":\"text\",\"label\":\"\\u0110\\u01b0\\u1eddng d\\u1eabn\",\"placeholder\":\"Nh\\u1eadp li\\u00ean k\\u1ebft\"},\"img_icon\":{\"type\":\"file\",\"label\":\"Icon (file \\u1ea3nh)\"},\"col_sm\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":\"6\"},\"col_lg\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4}}', '[]'),
(64, 'blade', 'theme', 4, 'Sidebar: Danh sách dự án', 'sidebar.projects', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"default\":\"C\\u00e1c d\\u1ef1 \\u00e1n\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_project_category_options\",\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_project_sortby_options\"},\"project_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 d\\u1ef1 \\u00e1n\",\"min\":1,\"step\":1,\"default\":10}}', '[]'),
(65, 'blade', 'theme', 4, 'Sidebar: Danh sách tin bài', 'sidebar.posts', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"default\":\"Tin m\\u1edbi nh\\u1ea5t\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}', '[]'),
(66, 'blade', 'theme', 4, 'Sidebar: Danh mục Dự án', 'sidebar.project-categories', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"parent_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c Cha\",\"template\":\"crazyselect\",\"call\":\"get_project_category_options\",\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_project_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10}}', '[]'),
(67, 'blade', 'theme', 4, 'Sidebar: Danh mục', 'sidebar.categories', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"get_by_dynamic_active\":{\"type\":\"switch\",\"label\":\"\\u01afu ti\\u00ean m\\u1ee5c \\u0111ang xem\",\"value_type\":\"boolean\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"parent_id\"},\"parent_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c Cha\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10}}', '[]'),
(68, 'blade', 'theme', 4, 'Sidebar: Thẻ bài viết (tags)', 'sidebar.tags', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_tag_sortby_options\"},\"tag_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}', '[]'),
(69, 'blade', 'theme', 4, 'Sidebar: Danh sách bình luận', 'sidebar.comments', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"placeholder\":\"V\\u00ed d\\u1ee5 comment m\\u1edbi nh\\u1ea5t\"},\"ref\":{\"type\":\"crazyselect\",\"label\":\"m\\u1ee5c l\\u1ea5y b\\u00ecnh lu\\u1eadn\",\"call\":\"get_comment_ref_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"number_comment\":{\"type\":\"number\",\"label\":\"S\\u1ed1 b\\u00ecnh lu\\u1eadn hi\\u1ec3n th\\u1ecb\",\"mim\":1,\"step\":1,\"max\":10}}', '{\"title\":\"B\\u00ecnh lu\\u1eadn m\\u1edbi nh\\u1ea5t\",\"number_comment\":5}'),
(70, 'blade', 'theme', 4, 'Help: Area', 'help.area', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"boder_bottom\":{\"type\":\"switch\",\"label\":\"Border\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb border bottom\"}}', '[]'),
(71, 'blade', 'theme', 4, 'Help: Item', 'help.item', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"link\":{\"type\":\"text\",\"label\":\"\\u0110\\u01b0\\u1eddng d\\u1eabn\",\"placeholder\":\"Nh\\u1eadp li\\u00ean k\\u1ebft\"}}', '[]'),
(72, 'blade', 'theme', 4, 'Dự án', 'projects', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"D\\u1ef1 \\u00e1n\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5\"},\"sorttype\":{\"type\":\"crazyselect\",\"label\":\"Ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_project_sortby_options\",\"value\":1},\"project_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":10}}', '[]'),
(73, 'blade', 'theme', 4, 'Mục Liên hệ', 'contacts', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"Li\\u00ean h\\u1ec7 ch\\u00fang t\\u00f4i\"},\"button_text\":{\"type\":\"text\",\"label\":\"N\\u00fat g\\u1eedi\",\"value\":\"G\\u1eedi li\\u00ean h\\u1ec7\"}}', '[]'),
(74, 'blade', 'theme', 4, 'Danh sách bài viết', 'posts', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":3},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft (t\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp li\\u00ean k\\u1ebft. (Kh\\u00f4ng b\\u1eaft bu\\u1ed9c)\"},\"bg_default_color\":{\"type\":\"radio\",\"label\":\"M\\u00e0u c\\u00f3 s\\u1eb5n\",\"data\":{\"\":\"Kh\\u00f4ng\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}},\"bg_color\":{\"type\":\"text\",\"label\":\"M\\u00e3 m\\u00e0u (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"},\"bg_image\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"bg_position\":{\"type\":\"radio\",\"label\":\"V\\u1ecb tr\\u00ed \\u1ea3nh\",\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}},\"bg_half\":{\"type\":\"switch\",\"label\":\"Bg Half\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb m\\u1ed9t n\\u1eeda h\\u00ecnh n\\u1ec1n\",\"value_type\":\"boolean\"},\"advance\":{\"type\":\"checklist\",\"label\":\"N\\u00e2ng cao\",\"data\":{\"shadow\":\"shadow\",\"dark\":\"dark\",\"dark-hard\":\"dark-hard\",\"light\":\"light\",\"theme\":\"theme\",\"theme-hard\":\"theme-hard\"}},\"class_name\":{\"type\":\"text\",\"label\":\"Class (T\\u00f9y ch\\u1ecdn)\"}}', '[]'),
(75, 'blade', 'theme', 4, 'Footer Widget: Đăng ký theo dõi', 'footer.subscribe', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u00e2u h\\u1ecfi (T\\u00f9y ch\\u1ecdn)\"},\"subscribe_button\":{\"type\":\"text\",\"label\":\"N\\u00fat \\u0110\\u0103ng k\\u00fd\"},\"col_sm\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":\"6\"},\"col_lg\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4}}', '[]'),
(76, 'blade', 'theme', 4, 'Footer Widget: Links', 'footer.links', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"placeholder\":\"v\\u00ed d\\u1ee5 Li\\u00ean k\\u1ebft\"},\"menu_id\":{\"type\":\"crazyselect\",\"label\":\"Menu\",\"call\":\"get_menu_options\"},\"col_sm\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":\"6\"},\"col_lg\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":3}}', '{\"menu_id\":0,\"title\":\"Li\\u00ean k\\u1ebft\"}'),
(77, 'blade', 'theme', 4, 'Thiết lập mục đăng bài', 'dynamic-settings', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 Thi\\u1ebft l\\u1eadp (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"select\",\"label\":\"M\\u1ee5c \\u0111\\u0103ng b\\u00e0i\",\"call\":\"get_dynamic_options\"},\"dynamic_type\":{\"type\":\"select\",\"label\":\"Lo\\u1ea1i m\\u1ee5c\",\"data\":{\"post\":\"Tin b\\u00e0i\",\"documentation\":\"T\\u00e0i li\\u1ec7u\",\"forum\":\"Forum\"}},\"mobile_menu_id\":{\"type\":\"select\",\"label\":\"Menu tr\\u00ean mobile\",\"call\":\"get_menu_options\"},\"sidebar_menu_id\":{\"type\":\"select\",\"label\":\"Menu cho t\\u00e0i li\\u1ec7u\",\"call\":\"get_menu_options\"},\"header_style\":{\"type\":\"radio\",\"label\":\"Header Style m\\u1eb7c \\u0111\\u1ecbnh\",\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\",\"3\":\"Style 3\"},\"default\":\"2\"},\"show_breadcrumb\":{\"type\":\"switch\",\"label\":\"Breadcrumb\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb breadcrumb\"},\"list_layout\":{\"type\":\"radio\",\"label\":\"Layout Danh s\\u00e1ch\",\"data\":{\"sidebar\":\"sidebar\",\"fullwidth\":\"fullwidth\"},\"default\":\"sidebar\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u Danh s\\u00e1ch\",\"data\":{\"list\":\"Danh s\\u00e1ch (list)\",\"grid\":\"L\\u01b0\\u1edbi (grid)\"},\"default\":\"grid\"},\"header_bg_default_color\":{\"type\":\"radio\",\"label\":\"M\\u00e0u c\\u00f3 s\\u1eb5n\",\"data\":{\"\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}},\"header_bg_color\":{\"type\":\"text\",\"label\":\"M\\u00e3 m\\u00e0u (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"},\"header_use_bg_image\":{\"type\":\"switch\",\"label\":\"S\\u1eed d\\u1ee5ng h\\u00ecnh n\\u1ec1n\",\"value_type\":\"boolean\",\"check_label\":\"C\\u00f3\"},\"header_bg_image\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"header_bg_position\":{\"type\":\"radio\",\"label\":\"V\\u1ecb tr\\u00ed \\u1ea3nh\",\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}},\"header_class_name\":{\"type\":\"text\",\"label\":\"Class (T\\u00f9y ch\\u1ecdn)\"},\"detail_use_feature_image\":{\"type\":\"switch\",\"label\":\"Header Image\",\"value_type\":\"boolean\",\"check_label\":\"S\\u1eed d\\u1ee5ng Feature Image l\\u00e0m h\\u00ecnh n\\u1ec1n Header\"},\"detail_hide_feature_image\":{\"type\":\"switch\",\"label\":\"Hide Feature Image\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n \\u1ea3nh n\\u1ed5i b\\u1eadt tr\\u00ean ph\\u1ea7n \\u0111\\u1ea7u n\\u1ed9i dung\"},\"detail_hide_meta\":{\"type\":\"switch\",\"label\":\"Hide Meta\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n th\\u00f4ng tin meta\"},\"detail_hide_related\":{\"type\":\"switch\",\"label\":\"Hide related\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n m\\u1ee5c li\\u00ean quan\"},\"detail_hide_comments\":{\"type\":\"switch\",\"label\":\"Hide Comments\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n ph\\u1ea7n b\\u00ecnh lu\\u1eadn\"}}', '[]'),
(78, 'blade', 'theme', 4, 'Phản hồi từ khách hàng - Testimonials area', 'testimonials.area', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"Ph\\u1ea3n h\\u1ed3i t\\u1eeb kh\\u00e1ch h\\u00e0ng\"},\"background\":{\"type\":\"file\",\"Label\":\"H\\u00ecnh n\\u1ec1n\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u danh s\\u00e1ch\",\"data\":{\"data\":\"Trong b\\u1ea3ng ph\\u1ea3n h\\u1ed3i\",\"custom\":\"Danh s\\u00e1ch t\\u00f9y bi\\u1ebfn\"},\"value\":\"custom\"},\"item_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":0},\"sort_type\":{\"type\":\"crazyselect\",\"label\":\"S\\u1eafp x\\u1ebfp\",\"data\":{\"id-ASC\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"id-DESC\":\"M\\u1edbi nh\\u1ea5t\",\"name-ASC\":\"h\\u1ee9 t\\u1ef1 b\\u1ea3ng ch\\u1ef1 c\\u00e1i\"},\"value\":\"id-ASC\"}}', '[]'),
(79, 'blade', 'theme', 4, 'Thông tin phản hồi (Testimonial item)', 'testimonials.item', '{\"name\":{\"type\":\"text\",\"label\":\"t\\u00ean ng\\u01b0\\u1eddi ph\\u1ea3n h\\u1ed3i\",\"placeholder\":\"V\\u00ed d\\u1ee5: Nguy\\u1ec5n V\\u0103n A\"},\"image\":{\"type\":\"file\",\"label\":\"\\u00c3nh \\u0111\\u1ea1i di\\u1ec7n\"},\"job\":{\"type\":\"text\",\"label\":\"C\\u00f4ng vi\\u1ec7c\",\"placeholder\":\"V\\u00ed d\\u1ee5: CEO\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft (t\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"V\\u00ed d\\u1ee5: http:\\/\\/www.facebook.com\\/LeNgocDoan\"},\"content\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\",\"className\":\"auto-height\",\"placeholder\":\"V\\u00ed d\\u1ee5: Very grateful to have found this app. D&L team did a fantastic job...\"}}', '[]'),
(80, 'blade', 'theme', 4, 'Bảng giá dịch vụ', 'service-pricing', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"service_id\":{\"type\":\"checklist\",\"label\":\"C\\u00e1c g\\u00f3i d\\u1ecbch v\\u1ee5\",\"call\":\"get_service_options\"},\"active_type\":{\"type\":\"select\",\"label\":\"K\\u00edch ho\\u1ea1t theo lo\\u1ea1i\",\"call\":\"get_service_package_type_options\"}}', '[]'),
(81, 'blade', 'theme', 4, 'Banner: Add service', 'banners.service-add', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"comment\":{\"type\":\"textarea\",\"label\":\"Ch\\u00fa th\\u00edch\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"create_button\":{\"type\":\"text\",\"label\":\"N\\u00fat kh\\u1edfi t\\u1ea1o\",\"placeholder\":\"V\\u00ed d\\u1ee5: T\\u1ea1o website\"}}', '[]'),
(82, 'blade', 'theme', 4, 'Quotes - Trích dẫn', 'quote', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"description\":{\"type\":\"textarea\",\"label\":\"N\\u1ed9i dung\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"show_quote\":{\"type\":\"switch\",\"label\":\"\\u0110\\u00e1nh d\\u1ea5u\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb \\u0110\\u00e1nh d\\u1ea5u tr\\u00edch d\\u1eabn\"},\"image\":{\"type\":\"file\",\"label\":\"\\u1ea2nh n\\u1ed5i b\\u1eadt\"},\"light_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ch\\u00ecm (T\\u00f9y ch\\u1ecdn)\"},\"show_author\":{\"type\":\"switch\",\"label\":\"t\\u00e1c gi\\u1ea3\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb Th\\u00f4ng tin t\\u00e1c gi\\u1ea3\"},\"author_name\":{\"type\":\"text\",\"label\":\"T\\u00ean\"},\"author_job\":{\"type\":\"text\",\"label\":\"C\\u00f4ng vi\\u1ec7c\"},\"author_link\":{\"type\":\"text\",\"label\":\"li\\u00ean k\\u1ebft (T\\u00f9y ch\\u1ecdn)\"}}', '[]'),
(83, 'blade', 'theme', 4, 'Home: Team (area)', 'team.area', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u danh s\\u00e1ch\",\"data\":{\"data\":\"Trong b\\u1ea3ng Nh\\u00f3m\",\"custom\":\"Danh s\\u00e1ch t\\u00f9y bi\\u1ebfn\"},\"value\":\"custom\"},\"team_id\":{\"type\":\"crazyselect\",\"label\":\"Nh\\u00f3m\",\"call\":\"get_team_options\",\"params\":[[],\"Ch\\u1ecdn nh\\u00f3m\"]},\"item_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":4},\"sort_type\":{\"type\":\"crazyselect\",\"label\":\"S\\u1eafp x\\u1ebfp\",\"data\":{\"id-ASC\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"id-DESC\":\"M\\u1edbi nh\\u1ea5t\",\"users.name-ASC\":\"th\\u1ee9 t\\u1ef1 b\\u1ea3ng ch\\u1ef1 c\\u00e1i\",\"is_leader-DESC\":\"\\u01afu ti\\u00ean tr\\u01b0\\u1edfng nh\\u00f3m\",\"job-ASC\":\"C\\u00f4ng vi\\u1ec7c (A-z)\",\"rand()\":\"Ng\\u1eabu nhi\\u00ean\"},\"value\":\"id-ASC\"},\"bg_default_color\":{\"type\":\"radio\",\"label\":\"M\\u00e0u c\\u00f3 s\\u1eb5n\",\"data\":{\"\":\"Kh\\u00f4ng\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}},\"bg_color\":{\"type\":\"text\",\"label\":\"M\\u00e3 m\\u00e0u (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"},\"bg_image\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"bg_position\":{\"type\":\"radio\",\"label\":\"V\\u1ecb tr\\u00ed \\u1ea3nh\",\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}},\"bg_half\":{\"type\":\"switch\",\"label\":\"Bg Half\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb m\\u1ed9t n\\u1eeda h\\u00ecnh n\\u1ec1n\",\"value_type\":\"boolean\"},\"advance\":{\"type\":\"checklist\",\"label\":\"N\\u00e2ng cao\",\"data\":{\"shadow\":\"shadow\",\"dark\":\"dark\",\"dark-hard\":\"dark-hard\",\"light\":\"light\",\"theme\":\"theme\",\"theme-hard\":\"theme-hard\"}},\"class_name\":{\"type\":\"text\",\"label\":\"Class (T\\u00f9y ch\\u1ecdn)\"}}', '[]'),
(84, 'blade', 'theme', 4, 'Home: Team Member', 'team.item', '{\"name\":{\"type\":\"text\",\"label\":\"T\\u00ean th\\u00e0nh vi\\u00ean\",\"placeholder\":\"V\\u00ed d\\u1ee5: Thi\\u1ec7n CH\"},\"avatar\":{\"type\":\"file\",\"label\":\"Avatar\"},\"job\":{\"type\":\"text\",\"label\":\"c\\u00f4ng vi\\u1ec7c (V\\u1ecb tr\\u00ed l\\u00e0m vi\\u1ec7c)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"is_loader\":{\"type\":\"switch\",\"label\":\"Tr\\u01b0\\u1edfng nh\\u00f3m?\",\"value_type\":\"boolean\"},\"facebook\":{\"type\":\"text\",\"label\":\"facebook (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"twitter\":{\"type\":\"text\",\"label\":\"twitter (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"youtube\":{\"type\":\"text\",\"label\":\"youtube (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"instagram\":{\"type\":\"text\",\"label\":\"instagram (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"linkedin\":{\"type\":\"text\",\"label\":\"Linkedin (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"pinterest\":{\"type\":\"text\",\"label\":\"Pinterest (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}}', '[]'),
(85, 'blade', 'theme', 4, 'Section', 'docs.section', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"content\":{\"type\":\"textarea\",\"label\":\"N\\u1ed9i dung\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"boder_bottom\":{\"type\":\"switch\",\"label\":\"Border\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb border bottom\"}}', '[]'),
(86, 'blade', 'theme', 4, 'Get Started', 'docs.get-started', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"boder_bottom\":{\"type\":\"switch\",\"label\":\"Border\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb border bottom\"}}', '[]'),
(87, 'blade', 'theme', 4, 'Tabs', 'docs.tabs.area', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"boder_bottom\":{\"type\":\"switch\",\"label\":\"Border\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb border bottom\"}}', '[]'),
(88, 'blade', 'theme', 4, 'Tab Item', 'docs.tabs.item', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"active\":{\"type\":\"switch\",\"label\":\"K\\u00edch ho\\u1ea1t\",\"value_type\":\"boolean\",\"check_label\":\"K\\u00edch ho\\u1ea1t hi\\u1ec3n th\\u1ecb tap m\\u1eb7c \\u0111\\u1ecbnh\"},\"content\":{\"type\":\"textarea\",\"label\":\"N\\u1ed9i dung (H\\u1ed7 tr\\u1ee3 HTML)\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"}}', '[]'),
(89, 'blade', 'theme', 4, 'Document Area', 'docs.docbody.area', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"boder_bottom\":{\"type\":\"switch\",\"label\":\"Border\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb border bottom\"}}', '[]'),
(90, 'blade', 'theme', 4, 'Document Item', 'docs.docbody.item', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"link\":{\"type\":\"text\",\"label\":\"\\u0110\\u01b0\\u1eddng d\\u1eabn\",\"placeholder\":\"Nh\\u1eadp li\\u00ean k\\u1ebft\"},\"img_icon\":{\"type\":\"file\",\"label\":\"Icon (file \\u1ea3nh)\"}}', '[]'),
(91, 'blade', 'theme', 4, 'Câu hỏi và đăng ký theo dõi', 'question-subcribe', '{\"question_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u00e2u h\\u1ecfi (T\\u00f9y ch\\u1ecdn)\"},\"question_description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 ph\\u1ea7n c\\u00e2u h\\u1ecfi\",\"placeholder\":\"M\\u00f4 t\\u1ea3 ph\\u1ea7n c\\u00e2u h\\u1ecfi. Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"subcribe_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 theo d\\u00f5i (T\\u00f9y ch\\u1ecdn)\"},\"subcribe_description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 theo d\\u00f5i\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"policy_link\":{\"type\":\"text\",\"label\":\"\\u0110\\u01b0\\u1eddng d\\u1eabn ch\\u00ednh s\\u00e1ch b\\u1ea3o m\\u1eadt\",\"placeholder\":\"Nh\\u1eadp li\\u00ean k\\u1ebft\"},\"boder_bottom\":{\"type\":\"switch\",\"label\":\"Border\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb border bottom\"}}', '[]'),
(92, 'blade', 'theme', 4, 'Banner: Search', 'banners.search', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"button_text\":{\"type\":\"text\",\"label\":\"N\\u00fat T\\u00ecm ki\\u1ebfm\",\"placeholder\":\"V\\u00ed d\\u1ee5: T\\u00ecm ki\\u1ebfm\"}}', '[]'),
(93, 'blade', 'theme', 4, 'Banner: Support', 'banners.support', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"button_text\":{\"type\":\"text\",\"label\":\"N\\u00fat T\\u00ecm ki\\u1ebfm\",\"placeholder\":\"V\\u00ed d\\u1ee5: T\\u00ecm ki\\u1ebfm\"}}', '[]'),
(94, 'blade', 'theme', 4, 'Nút gọi ngay', 'phone-ring', '{\"Hotline\":{\"type\":\"text\",\"Label\":\"Hotline\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp Li\\u00ean h\\u1ec7\"},\"call_text\":{\"type\":\"text\",\"Label\":\"Text m\\u1eddi g\\u1ecdi\",\"placeholder\":\"v\\u00ed d\\u1ee5: G\\u1ecdi \\u0111i\\u1ec7n tho\\u1ea1i\"}}', '[]'),
(95, 'blade', 'theme', 4, 'Banner: Slider', 'banners.slider', '{\"slider_id\":{\"type\":\"crazyselect\",\"label\":\"Slider\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"call\":\"get_slider_options\"},\"btn_text\":{\"type\":\"text\",\"label\":\"N\\u00fat b\\u1ea5m\",\"placeholder\":\"Ch\\u1eef s\\u1ebd \\u0111\\u01b0\\u1ee3c hi\\u1ec3n th\\u1ecb tr\\u00ean n\\u00fat xem th\\u00eam\"},\"address\":{\"type\":\"text\",\"Label\":\"\\u0110\\u1ecba ch\\u1ec9\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin li\\u00ean h\\u1ec7\"},\"phone_number\":{\"type\":\"text\",\"Label\":\"S\\u1ed1 \\u0111i\\u1ec7n tho\\u1ea1i\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin li\\u00ean h\\u1ec7\"},\"email\":{\"type\":\"text\",\"Label\":\"Email\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin li\\u00ean h\\u1ec7\"}}', '[]'),
(96, 'blade', 'theme', 4, 'services', 'services', '[]', '[]'),
(97, 'blade', 'theme', 4, 'Sidebar: Đăng ký theo dõi', 'sidebar.subcribe', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 theo d\\u00f5i\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"}}', '[]'),
(98, 'blade', 'theme', 4, 'settings/pages : viee', 'settings/pages.viee', '[]', '[]'),
(99, 'blade', 'theme', 4, 'Footer Widget: Danh sách bài viết', 'footer.posts', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":3},\"col_xs\":{\"type\":\"crazyselect\",\"label\":\"col (col-xs)\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":12},\"col_sm\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":12},\"col_md\":{\"type\":\"crazyselect\",\"label\":\"col-md\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":6},\"col_lg\":{\"type\":\"crazyselect\",\"label\":\"col-lg\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4},\"col_xl\":{\"type\":\"crazyselect\",\"label\":\"col-xl\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4}}', '[]'),
(100, 'blade', 'theme', 4, 'Footer Widget: About', 'footer.about', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u00e2u h\\u1ecfi (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"N\\u1ed9i dung\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"email\":{\"type\":\"text\",\"Label\":\"Email\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin li\\u00ean h\\u1ec7\"},\"phone_number\":{\"type\":\"text\",\"Label\":\"S\\u1ed1 \\u0111i\\u1ec7n tho\\u1ea1i\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin li\\u00ean h\\u1ec7\"},\"address\":{\"type\":\"text\",\"Label\":\"\\u0110\\u1ecba ch\\u1ec9\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin li\\u00ean h\\u1ec7\"},\"col_xs\":{\"type\":\"crazyselect\",\"label\":\"col (col-xs)\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":12},\"col_sm\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":12},\"col_md\":{\"type\":\"crazyselect\",\"label\":\"col-md\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":6},\"col_lg\":{\"type\":\"crazyselect\",\"label\":\"col-lg\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4},\"col_xl\":{\"type\":\"crazyselect\",\"label\":\"col-xl\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4}}', '[]'),
(101, 'blade', 'theme', 4, 'Footer Widget: Thẻ bài viết (tags)', 'footer.tags', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ea7n Tags\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_tag_sortby_options\"},\"tag_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10},\"social_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ea7n MXH\"},\"col_xs\":{\"type\":\"crazyselect\",\"label\":\"col (col-xs)\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":12},\"col_sm\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":12},\"col_md\":{\"type\":\"crazyselect\",\"label\":\"col-md\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":6},\"col_lg\":{\"type\":\"crazyselect\",\"label\":\"col-lg\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4},\"col_xl\":{\"type\":\"crazyselect\",\"label\":\"col-xl\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4}}', '[]'),
(102, 'blade', 'theme', 4, 'Home: Slider bài viết', 'home.post-slider', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":12}}', '[]'),
(103, 'blade', 'theme', 4, 'Home: Danh mục và tin bài', 'home.post-and-categories', '{\"cate_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"cate_parent_id\"},\"cate_parent_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c Cha\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#cate_dynamic_id\"},true],\"@label-type\":\"value\"},\"cate_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"list_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 list (T\\u00f9y ch\\u1ecdn)\"},\"list_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c tin b\\u00e0i \\u1edf list (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"list_category_id\",\"required\":\"true\"},\"list_category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c \\u1edf list (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#list_dynamic_id\"},true],\"@label-type\":\"value\"},\"list_group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c (trong list)\",\"value_type\":\"boolean\"},\"list_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp (trong list)\",\"call\":\"get_post_sortby_options\"},\"list_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i (trong list)\",\"min\":1,\"step\":1,\"default\":12}}', '[]'),
(104, 'blade', 'theme', 4, 'Home: Tab Grid (Style 5)', 'home.post-tabs.style-5', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"cate_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp Danh m\\u1ee5c\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c con\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":36}}', '[]'),
(105, 'blade', 'theme', 4, 'Home: Tab Slider (Style 3)', 'home.post-tabs.style-3', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"cate_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp Danh m\\u1ee5c\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c con\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":12}}', '[]'),
(106, 'blade', 'theme', 4, 'Home: Tab Trending Slider (Style 1)', 'home.post-tabs.style-1', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"cate_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp Danh m\\u1ee5c\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c con\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":12},\"sidebar_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 sidebar (T\\u00f9y ch\\u1ecdn)\"},\"sidebar_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c tin b\\u00e0i \\u1edf sidebar (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"sidebar_category_id\",\"required\":\"true\"},\"sidebar_category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c \\u1edf sidebar (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#sidebar_dynamic_id\"},true],\"@label-type\":\"value\"},\"sidebar_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp \\u1edf sidebar\",\"call\":\"get_post_sortby_options\"},\"sidebar_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i \\u1edf sidebar\",\"min\":1,\"step\":1,\"default\":5}}', '[]');
INSERT INTO `components` (`id`, `type`, `ref`, `ref_id`, `name`, `path`, `inputs`, `data`) VALUES
(107, 'blade', 'theme', 4, 'Home: Tab list Slider (Style 2)', 'home.post-tabs.style-2', '{\"slider_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 slider (T\\u00f9y ch\\u1ecdn)\"},\"slider_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c tin b\\u00e0i slider (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"slider_category_id\",\"required\":\"true\"},\"slider_category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c slider (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#slider_dynamic_id\"},true],\"@label-type\":\"value\"},\"slider_cate_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp Danh m\\u1ee5c\",\"call\":\"get_post_category_sortby_options\"},\"slider_cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c con\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"slider_group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"slider_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp slider\",\"call\":\"get_post_sortby_options\"},\"slider_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i slider\",\"min\":1,\"step\":1,\"default\":25},\"list_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 list (T\\u00f9y ch\\u1ecdn)\"},\"list_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c tin b\\u00e0i \\u1edf list (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"list_category_id\",\"required\":\"true\"},\"list_category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c \\u1edf list (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#list_dynamic_id\"},true],\"@label-type\":\"value\"},\"list_group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c (trong list)\",\"value_type\":\"boolean\"},\"list_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp (trong list)\",\"call\":\"get_post_sortby_options\"},\"list_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i (trong list)\",\"min\":1,\"step\":1,\"default\":25},\"social_show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb Li\\u00ean k\\u1ebft MXH\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb\"},\"social_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 social (T\\u00f9y ch\\u1ecdn)\"},\"cate_show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb Danhh m\\u1ee5c\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb\"},\"cate_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 Ph\\u1ea7n danh m\\u1ee5c (T\\u00f9y ch\\u1ecdn)\"},\"cate_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"cate_parent_id\"},\"cate_parent_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c Cha\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#cate_dynamic_id\"},true],\"@label-type\":\"value\"},\"cate_sort\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"newsletter_show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb \\u0111\\u0103ng k\\u00fd theo d\\u00f5i\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb\"},\"newsletter_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 m\\u1ee5c \\u0111\\u0103ng k\\u00fd (T\\u00f9y ch\\u1ecdn)\"},\"newsletter_description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 m\\u1ee5c \\u0111\\u0103ng k\\u00fd\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"newsletter_button\":{\"type\":\"text\",\"label\":\"N\\u00fat \\u0110\\u0103ng k\\u00fd\"}}', '[]'),
(108, 'blade', 'theme', 4, 'Home: Tab Slider (Style 4)', 'home.post-tabs.style-4', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"cate_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp Danh m\\u1ee5c\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c con\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":12}}', '[]'),
(109, 'blade', 'theme', 4, 'Home: Video Slider Style 1', 'home.videos.style-1', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":15}}', '[]'),
(110, 'blade', 'theme', 4, 'Home: Video Slider Style 2', 'home.videos.style-2', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":15}}', '[]'),
(111, 'blade', 'theme', 4, 'Home: Post Banner Slider', 'home.post-banner-slider', '{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":5}}', '[]');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone_number`, `address`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Lê Ngọc Doãn', 'doanln16@gmail.com', '0945786960', NULL, NULL, 'theme_asset', '2020-05-01 18:44:15', '2020-05-01 18:44:15'),
(2, 'Doãn Lê Ngọc', 'doanln16@gmail.com', '0945786960', NULL, NULL, '2222222222', '2020-05-01 18:58:19', '2020-05-01 18:58:19'),
(3, 'Doãn Lê Ngọc', 'doanln16@gmail.com', '0945786960', NULL, NULL, '21', '2020-05-27 15:49:46', '2020-05-27 15:49:46'),
(4, 'Doãn Lê Ngọc', 'doanln16@gmail.com', '0945786960', NULL, NULL, '10', '2020-05-28 09:09:37', '2020-05-28 09:09:37'),
(5, 'Lê Ngọc Doãn', 'doanln16@gmail.com', '0945786960', NULL, NULL, 'T', '2020-06-29 15:43:01', '2020-06-29 15:43:01'),
(6, 'Hieuvm', 'vuhieu2610@gmail.com', NULL, NULL, 'Chua kich hoat email', 'test', '2020-10-03 20:02:33', '2020-10-03 20:02:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_replies`
--

CREATE TABLE `contact_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contact_replies`
--

INSERT INTO `contact_replies` (`id`, `contact_id`, `user_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 4, 1, ', \"teams\"', '2020-06-25 21:17:40', '2020-06-25 21:17:40'),
(2, 6, 1, 'Đã kích hoạt rồi nhé', '2020-10-03 20:03:22', '2020-10-03 20:03:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `crazy_3d_item_refs`
--

CREATE TABLE `crazy_3d_item_refs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `__data__` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`__data__`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `crazy_3d_model_items`
--

CREATE TABLE `crazy_3d_model_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'untitiled',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `secret_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `download_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `__data__` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`__data__`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `crazy_3d_model_items`
--

INSERT INTO `crazy_3d_model_items` (`id`, `user_id`, `category_id`, `name`, `description`, `status`, `secret_id`, `type`, `path`, `file`, `download_url`, `zip_file`, `thumbnail`, `__data__`, `created_at`, `updated_at`) VALUES
(86, 1, 0, 'nissan', NULL, 'draft', '91ea70e215', 'gltf', 'http://127.0.0.1:8000/static/sources/models/91ea70e215/nissan/', 'scene.gltf', NULL, NULL, 'thumbnail.png', '{\"size\":{\"__isObject\":true,\"x\":53.36473846435547,\"y\":13.817140561935277,\"z\":23.226757049560547},\"load_options\":{\"useRoughnessMipmapper\":true,\"materialNeedsUpdate\":true},\"settings\":{\"__isObject\":true}}', '2021-10-24 08:41:31', '2021-10-24 08:42:13'),
(87, 1, 0, 'nissan', NULL, 'draft', 'c80d0930ff', 'gltf', 'http://127.0.0.1:8000/static/sources/models/c80d0930ff/nissan/', 'scene.gltf', NULL, NULL, 'thumbnail.png', '{\"size\":{\"__isObject\":true,\"x\":53.36473846435547,\"y\":13.817140561935277,\"z\":23.226757049560547},\"load_options\":{\"useRoughnessMipmapper\":true,\"materialNeedsUpdate\":true},\"settings\":{\"__isObject\":true}}', '2021-10-24 08:46:39', '2021-10-24 08:46:59'),
(88, 1, 0, 'nissan', NULL, 'published', '0feffc8c2f', 'gltf', 'http://127.0.0.1:8000/static/sources/models/0feffc8c2f/nissan/', 'scene.gltf', NULL, NULL, 'thumbnail.png', '{\"size\":{\"__isObject\":true,\"x\":53.36473846435547,\"y\":13.817140561935277,\"z\":23.226757049560547},\"load_options\":{\"useRoughnessMipmapper\":true,\"materialNeedsUpdate\":true},\"settings\":{\"__isObject\":true}}', '2021-10-24 08:51:31', '2021-10-24 08:53:06'),
(89, 1, 0, 'nlb', NULL, 'draft', '2d2dd8fc56', 'gltf', 'http://127.0.0.1:8000/static/sources/models/2d2dd8fc56/nlb/', 'test.gltf', NULL, NULL, 'thumbnail.png', '{\"size\":{\"__isObject\":true,\"x\":1.530919314,\"y\":0.42758763737563044,\"z\":1.530919314},\"load_options\":{\"useRoughnessMipmapper\":true,\"materialNeedsUpdate\":true},\"settings\":{\"__isObject\":true}}', '2021-10-24 08:59:52', '2021-10-24 08:59:58'),
(90, 1, 0, 'set20', NULL, 'draft', '71ff2f48fd', 'gltf', 'http://127.0.0.1:8000/static/sources/models/71ff2f48fd/set20/', 'scene.gltf', NULL, NULL, 'thumbnail.png', '{\"size\":{\"__isObject\":true,\"x\":0.1266659591802679,\"y\":0.41611233811423787,\"z\":0.2533657986},\"load_options\":{\"useRoughnessMipmapper\":true,\"materialNeedsUpdate\":true},\"settings\":{\"__isObject\":true}}', '2021-10-24 09:00:50', '2021-10-24 09:01:04'),
(91, 1, 0, 'set20', NULL, 'published', 'b86e86f6ef', 'gltf', 'http://127.0.0.1:8000/static/sources/models/b86e86f6ef/set20/', 'scene.gltf', NULL, NULL, 'thumbnail.png', '{\"size\":{\"__isObject\":true,\"x\":0.1266659591802679,\"y\":0.41611233811423787,\"z\":0.2533657986},\"load_options\":{\"useRoughnessMipmapper\":true,\"materialNeedsUpdate\":true},\"settings\":{\"__isObject\":true}}', '2021-10-24 09:06:53', '2021-10-24 09:08:12'),
(92, 1, 0, 'tet_hf', NULL, 'draft', '178123790d', 'gltf', 'http://127.0.0.1:8000/static/sources/models/178123790d/', 'scene.gltf', NULL, NULL, 'thumbnail.png', '{\"size\":{\"__isObject\":true,\"x\":3.999999985098839,\"y\":0.41482023894786835,\"z\":3.999999985098839},\"load_options\":{\"useRoughnessMipmapper\":true,\"materialNeedsUpdate\":true},\"settings\":{\"__isObject\":true}}', '2021-10-25 05:23:59', '2021-10-25 05:24:08'),
(93, 1, 0, 'tet_hf', NULL, 'draft', '0d56a8a1ce', 'gltf', 'http://127.0.0.1:8000/static/sources/models/0d56a8a1ce/', 'scene.gltf', NULL, NULL, NULL, '\"{\\\"size\\\":{\\\"__isObject\\\":true},\\\"load_options\\\":{\\\"useRoughnessMipmapper\\\":true,\\\"materialNeedsUpdate\\\":true},\\\"settings\\\":{\\\"__isObject\\\":true}}\"', '2021-10-25 08:05:21', '2021-10-25 08:05:21'),
(94, 1, 0, 'nissan', NULL, 'published', 'e85f9890d3', 'gltf', 'http://127.0.0.1:8000/static/sources/models/e85f9890d3/nissan/', 'scene.gltf', NULL, NULL, NULL, '\"{\\\"size\\\":{\\\"__isObject\\\":true},\\\"load_options\\\":{\\\"useRoughnessMipmapper\\\":true,\\\"materialNeedsUpdate\\\":true},\\\"settings\\\":{\\\"__isObject\\\":true}}\"', '2021-10-25 08:09:53', '2021-10-25 08:18:42'),
(95, 1, 0, 'nlb', NULL, 'draft', '36756dbc75', 'gltf', 'http://127.0.0.1:8000/static/sources/models/36756dbc75/nlb/', 'test.gltf', NULL, NULL, NULL, '\"{\\\"size\\\":{\\\"__isObject\\\":true},\\\"load_options\\\":{\\\"useRoughnessMipmapper\\\":true,\\\"materialNeedsUpdate\\\":true},\\\"settings\\\":{\\\"__isObject\\\":true}}\"', '2021-10-25 08:22:37', '2021-10-25 08:22:37'),
(96, 1, 0, '3cups2', NULL, 'draft', 'aa889985d5', 'gltf', 'http://127.0.0.1:8000/static/sources/models/aa889985d5/3cups2/', 'model.gltf', NULL, NULL, NULL, '\"{\\\"size\\\":{\\\"__isObject\\\":true},\\\"load_options\\\":{\\\"useRoughnessMipmapper\\\":true,\\\"materialNeedsUpdate\\\":true},\\\"settings\\\":{\\\"__isObject\\\":true}}\"', '2021-10-25 08:25:39', '2021-10-25 08:25:39'),
(97, 1, 0, '3cups2', NULL, 'draft', '3b607127d1', 'gltf', 'http://127.0.0.1:8000/static/sources/models/3b607127d1/3cups2/', 'model.gltf', NULL, NULL, NULL, '\"{\\\"size\\\":{\\\"__isObject\\\":true},\\\"load_options\\\":{\\\"useRoughnessMipmapper\\\":true,\\\"materialNeedsUpdate\\\":true},\\\"settings\\\":{\\\"__isObject\\\":true}}\"', '2021-10-25 08:27:51', '2021-10-25 08:27:51'),
(98, 1, 0, 'Flamingo', NULL, 'draft', '9eed4e5ef8', 'gltf', 'http://127.0.0.1:8000/static/sources/models/9eed4e5ef8/', 'Flamingo-61766ae42eb54.glb', NULL, NULL, 'thumbnail.png', '{\"size\":{\"__isObject\":true,\"x\":231.59999465942383,\"y\":416.10000133514404,\"z\":201.39999771118164},\"load_options\":{\"useRoughnessMipmapper\":true,\"materialNeedsUpdate\":true},\"settings\":{\"__isObject\":true}}', '2021-10-25 08:29:24', '2021-10-25 08:29:25'),
(99, 1, 0, 'ferrari', NULL, 'draft', 'c3d7bcd435', 'gltf', 'http://127.0.0.1:8000/static/sources/models/c3d7bcd435/', 'ferrari-61766bbf6c222.glb', NULL, NULL, 'thumbnail.png', '{\"size\":{\"__isObject\":true,\"x\":2.25709247589112,\"y\":1.236010696714791,\"z\":4.533591027837245},\"load_options\":{\"useRoughnessMipmapper\":true,\"materialNeedsUpdate\":true},\"settings\":{\"__isObject\":true}}', '2021-10-25 08:33:03', '2021-10-25 08:33:07'),
(100, 1, 0, 'Flamingo', NULL, 'draft', '4b7a16e5d3', 'gltf', 'http://127.0.0.1:8000/static/sources/models/4b7a16e5d3/', 'Flamingo-61766bd1da71c.glb', NULL, NULL, 'thumbnail.png', '{\"size\":{\"__isObject\":true,\"x\":231.59999465942383,\"y\":416.10000133514404,\"z\":201.39999771118164},\"load_options\":{\"useRoughnessMipmapper\":true,\"materialNeedsUpdate\":true},\"settings\":{\"__isObject\":true}}', '2021-10-25 08:33:21', '2021-10-25 08:33:22'),
(101, 1, 0, 'sprandi_shoe_sneakers_3d_scan', NULL, 'draft', 'fd692d15de', 'gltf', 'http://127.0.0.1:8000/static/sources/models/fd692d15de/sprandi_shoe_sneakers_3d_scan/', 'scene.gltf', NULL, NULL, 'thumbnail.png', '\"{\\\"size\\\":{\\\"x\\\":0.28747964784241287,\\\"y\\\":0.13195300847291958,\\\"z\\\":0.11482435133233831},\\\"load_options\\\":{\\\"useRoughnessMipmapper\\\":true,\\\"materialNeedsUpdate\\\":true},\\\"settings\\\":{\\\"__isObject\\\":true,\\\"meshes\\\":[{\\\"name\\\":\\\"mesh_0\\\",\\\"sid\\\":\\\"mesh_0_0\\\",\\\"index\\\":0,\\\"title\\\":\\\"mesh_0\\\",\\\"data\\\":[],\\\"editable\\\":[]}],\\\"props\\\":{\\\"castShadow\\\":true,\\\"receiveShadow\\\":true,\\\"rotation\\\":{\\\"x\\\":0,\\\"y\\\":0,\\\"z\\\":0},\\\"scale\\\":{\\\"x\\\":1,\\\"y\\\":1,\\\"z\\\":1}},\\\"options\\\":{\\\"pivot\\\":{\\\"x\\\":\\\"center\\\",\\\"y\\\":\\\"center\\\",\\\"z\\\":\\\"center\\\"}}}}\"', '2021-10-25 08:35:59', '2021-10-25 10:51:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `crazy_3d_projects`
--

CREATE TABLE `crazy_3d_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'untitiled',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `secret_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `__data__` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`__data__`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `crazy_3d_templates`
--

CREATE TABLE `crazy_3d_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'untitiled',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `secret_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `__data__` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`__data__`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dynamics`
--

CREATE TABLE `dynamics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feature_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'article',
  `use_category` tinyint(1) NOT NULL DEFAULT 0,
  `use_gallery` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dynamics`
--

INSERT INTO `dynamics` (`id`, `name`, `slug`, `description`, `content`, `keywords`, `feature_image`, `post_type`, `use_category`, `use_gallery`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Lê Ngọc Doãn', 'le-ngoc-doan', NULL, NULL, NULL, 'best-ways-to-come-up-with-company-goals-feature-5e6cadef74530.png', 'custom', 1, 0, 1, '2020-03-14 10:11:59', '2020-03-14 10:22:20'),
(2, 'Dịch vụ', 'dich-vu', 'Các dịch vụ hàng đầu của web 102', NULL, NULL, 'preview-large-preview-5e7797e85fc9e.png', 'article', 0, 0, 1, '2020-03-22 16:52:56', '2021-10-22 03:03:13'),
(3, 'Blog', 'blog', NULL, NULL, 'blog', NULL, 'custom', 1, 0, 0, '2020-05-02 02:55:55', '2020-05-02 02:55:55'),
(4, 'Tài liệu', 'docs', NULL, NULL, NULL, NULL, 'custom', 1, 0, 1, '2020-05-15 01:42:41', '2021-10-22 03:03:27'),
(5, 'Giao diện', 'giao-dien', NULL, NULL, NULL, NULL, 'custom', 1, 1, 1, '2020-07-28 15:05:19', '2021-10-22 03:03:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `email_tokens`
--

CREATE TABLE `email_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'confirm',
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` bigint(20) UNSIGNED DEFAULT 0,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `email_tokens`
--

INSERT INTO `email_tokens` (`id`, `email`, `type`, `ref`, `ref_id`, `token`, `code`, `expired_at`, `created_at`, `updated_at`) VALUES
(1, 'doanln1611@gmail.com', 'verify', 'account', 0, '5ebe0c6fc9193', '747927', '2020-05-16 10:28:47', '2020-05-15 03:28:47', '2020-05-15 03:28:47'),
(2, 'doanln1614@gmail.com', 'verify', 'account', 0, '5ebe112399657', '260757', '2020-05-16 10:48:51', '2020-05-15 03:48:51', '2020-05-15 03:48:51'),
(4, 'hoangtrungexpress@gmail.com', 'verify', 'account', 0, '5ecfe50f1f831', '285929', '2020-05-29 23:21:35', '2020-05-28 16:21:35', '2020-05-28 16:21:35'),
(5, 'hacker@gmail.com', 'verify', 'account', 0, '5ed07a505e20d', '638495', '2020-05-30 09:58:24', '2020-05-29 02:58:24', '2020-05-29 02:58:24'),
(7, 'aaa1@gmail.com', 'verify', 'account', 0, '5ed860a6cf86e', '564852', '2020-06-05 09:47:02', '2020-06-04 02:47:02', '2020-06-04 02:47:02'),
(8, 'lengocdoan.hb.2016@gmail.com', 'verify', 'account', 0, '5ed91116d3427', '142091', '2020-06-05 22:19:50', '2020-06-05 02:19:50', '2020-06-05 02:19:50'),
(9, 'tuanchiko1998@gmail.com', 'verify', 'account', 0, '5edb90c6068f7', '223476', '2020-06-07 19:49:10', '2020-06-06 23:49:10', '2020-06-06 23:49:10'),
(10, 'letung0003@gmail.com', 'verify', 'account', 0, '5edf198284edb', '428361', '2020-06-10 12:09:22', '2020-06-09 16:09:22', '2020-06-09 16:09:22'),
(11, 'test@gmail.com', 'verify', 'account', 0, '5edf24d4af4df', '812627', '2020-06-10 12:57:40', '2020-06-09 16:57:40', '2020-06-09 16:57:40'),
(12, 'manhhoang3151996@gmail.com', 'verify', 'account', 0, '5edf25293b644', '613867', '2020-06-10 12:59:05', '2020-06-09 16:59:05', '2020-06-09 16:59:05'),
(14, 'cute2x1a@gmail.com', 'verify', 'account', 0, '5edf50ee7bd7e', '205698', '2020-06-10 16:05:50', '2020-06-09 20:05:50', '2020-06-09 20:05:50'),
(15, 'vingroup@gmail.com', 'verify', 'account', 0, '5ee0e2e546dde', '425807', '2020-06-11 20:40:53', '2020-06-11 00:40:53', '2020-06-11 00:40:53'),
(16, 'hieup2047@gmail.com', 'verify', 'account', 0, '5ee30ace2bcb8', '430017', '2020-06-13 11:55:42', '2020-06-12 15:55:42', '2020-06-12 15:55:42'),
(17, 'vuthininhvvt@gmail.com', 'verify', 'account', 0, '5ee31f9ec2cf8', '553057', '2020-06-13 13:24:30', '2020-06-12 17:24:30', '2020-06-12 17:24:30'),
(19, 'b0y9x199x@gmail.com', 'verify', 'account', 0, '5ee6eaffd95b9', '830061', '2020-06-16 10:29:03', '2020-06-15 14:29:03', '2020-06-15 14:29:03'),
(21, 'nooffood09@gmail.com', 'verify', 'account', 0, '5f00adc7545c3', '388061', '2020-07-05 23:26:47', '2020-07-05 03:26:47', '2020-07-05 03:26:47'),
(24, 'doductientq@gmail.com', 'verify', 'account', 0, '5f06dcbbbbf50', '997974', '2020-07-10 16:00:43', '2020-07-09 20:00:43', '2020-07-09 20:00:43'),
(25, 'tunglvph07572@fpt.edu.vn', 'verify', 'account', 0, '5f0c7b77e66eb', '820883', '2020-07-14 22:19:19', '2020-07-14 02:19:19', '2020-07-14 02:19:19'),
(26, 'dbhlnmn@gmail.com', 'verify', 'account', 0, '5f1d77cdaa567', '789377', '2020-07-27 19:32:13', '2020-07-26 23:32:13', '2020-07-26 23:32:13'),
(27, 'quyet.ng2211@gmail.com', 'verify', 'account', 0, '5f1e9bc14588f', '580593', '2020-07-28 16:17:53', '2020-07-27 20:17:53', '2020-07-27 20:17:53'),
(29, 'lehau121212@gmail.com', 'verify', 'account', 0, '5f1edb1f959ef', '572561', '2020-07-28 20:48:15', '2020-07-28 00:48:15', '2020-07-28 00:48:15'),
(30, 'lequyet840500@gmail.com', 'verify', 'account', 0, '5f1edf7679d65', '485719', '2020-07-28 21:06:46', '2020-07-28 01:06:46', '2020-07-28 01:06:46'),
(31, 'queanh0712@gmail.com', 'verify', 'account', 0, '5f1f83151c965', '402394', '2020-07-29 08:44:53', '2020-07-28 12:44:53', '2020-07-28 12:44:53'),
(32, 'admin123@gmail.com', 'verify', 'account', 0, '5f26c567e3a8c', '871026', '2020-08-03 20:53:43', '2020-08-03 00:53:43', '2020-08-03 00:53:43'),
(33, 'nqh.one.of.a.kind@gmail.com', 'verify', 'account', 0, '5f27a96c167d4', '118489', '2020-08-04 13:06:36', '2020-08-03 17:06:36', '2020-08-03 17:06:36'),
(35, 'lawlaww7@gmail.com', 'verify', 'account', 0, '5f27a99f49823', '954607', '2020-08-04 13:07:27', '2020-08-03 17:07:27', '2020-08-03 17:07:27'),
(36, 'ochna1112@gmail.com', 'verify', 'account', 0, '5f27a9b0a2a62', '383550', '2020-08-04 13:07:44', '2020-08-03 17:07:44', '2020-08-03 17:07:44'),
(37, 'thong09x@gmail.com', 'verify', 'account', 0, '5f27a9ca9a0b3', '498046', '2020-08-04 13:08:10', '2020-08-03 17:08:10', '2020-08-03 17:08:10'),
(39, 'buiducquyen1901@gmail.com', 'verify', 'account', 0, '5f27a9d3b5869', '998266', '2020-08-04 13:08:19', '2020-08-03 17:08:19', '2020-08-03 17:08:19'),
(41, 'kyntph05775@fpt.edu.vn', 'verify', 'account', 0, '5f27a9f1b73d9', '916061', '2020-08-04 13:08:49', '2020-08-03 17:08:49', '2020-08-03 17:08:49'),
(42, 'datndph09982@fpt.edu.vn', 'verify', 'account', 0, '5f27a9f2d3764', '540539', '2020-08-04 13:08:50', '2020-08-03 17:08:50', '2020-08-03 17:08:50'),
(44, 'duydkph10118@fpt.edu.vn', 'verify', 'account', 0, '5f27aa060244a', '287648', '2020-08-04 13:09:10', '2020-08-03 17:09:10', '2020-08-03 17:09:10'),
(45, 'anhhnph09909@fpt.edu.vn', 'verify', 'account', 0, '5f27aa246b137', '847817', '2020-08-04 13:09:40', '2020-08-03 17:09:40', '2020-08-03 17:09:40'),
(46, 'cute0123@yahoo.com', 'verify', 'account', 0, '5f27aa3709663', '413816', '2020-08-04 13:09:59', '2020-08-03 17:09:59', '2020-08-03 17:09:59'),
(48, 'thong09x@gmail.com', 'reset-password', 'user', 31, '5f27aa59022b8', '769896', '2020-08-04 13:10:33', '2020-08-03 17:10:33', '2020-08-03 17:10:33'),
(50, 'quyenbdph10002@fpt.edu.vn', 'verify', 'account', 0, '5f27aae18be49', '721306', '2020-08-04 13:12:49', '2020-08-03 17:12:49', '2020-08-03 17:12:49'),
(52, 'thongthathu201@gmail.com', 'verify', 'account', 0, '5f27abada74fa', '911930', '2020-08-04 13:16:13', '2020-08-03 17:16:13', '2020-08-03 17:16:13'),
(53, 'tranquangdai2016@gmail.com', 'verify', 'account', 0, '5f27abb11b2b0', '704780', '2020-08-04 13:16:17', '2020-08-03 17:16:17', '2020-08-03 17:16:17'),
(56, 'tuandvph05029@fpt.edu.vn', 'verify', 'account', 0, '5f511575bf005', '244635', '2020-09-04 23:10:29', '2020-09-04 03:10:29', '2020-09-04 03:10:29'),
(58, 'tuandv211@gmail.com', 'verify', 'account', 0, '5f5a42587ebf3', '530564', '2020-09-11 22:12:24', '2020-09-11 02:12:24', '2020-09-11 02:12:24'),
(60, 'vuhieu2610@gmail.com', 'verify', 'account', 0, '5f7830c10eb8e', '162479', '2020-10-04 15:05:21', '2020-10-03 19:05:21', '2020-10-03 19:05:21'),
(61, 'snowbn98@gmail.com', 'verify', 'account', 0, '5f7831e6971e7', '788567', '2020-10-04 15:10:14', '2020-10-03 19:10:14', '2020-10-03 19:10:14'),
(68, 'doanle2016@outlook.com', 'verify', 'account', 0, '5f940b9a97e85', '791047', '2020-10-25 18:10:18', '2020-10-24 22:10:18', '2020-10-24 22:10:18'),
(70, 'tamntph09184@fpt.edu.vn', 'verify', 'account', 0, '5f9bbfcd48824', '560474', '2020-10-31 14:25:01', '2020-10-30 18:25:01', '2020-10-30 18:25:01'),
(79, 'tamntph09184@fpt.edu.vn', 'reset-password', NULL, 0, '5fc50c4245224', '604527', '2020-12-01 22:14:10', '2020-12-01 03:14:10', '2020-12-01 03:14:10'),
(81, 'tuandv311@gmail.com', 'verify', 'account', 0, '5fe7377ed1b80', '851432', '2020-12-27 20:15:42', '2020-12-27 01:15:42', '2020-12-27 01:15:42'),
(82, 'tranngocminh0305@icloud.com', 'verify', 'account', 0, '6023b8d6ac245', '138744', '2021-02-11 17:43:34', '2021-02-10 22:43:34', '2021-02-10 22:43:34'),
(86, 'quangsang.adv@gmail.com', 'verify', 'account', 0, '60782b1a635df', '708139', '2021-04-16 19:01:30', '2021-04-15 23:01:30', '2021-04-15 23:01:30'),
(87, 'nhoczuka49@gmail.com', 'verify', 'account', 0, '607831653d056', '816946', '2021-04-16 19:28:21', '2021-04-15 23:28:21', '2021-04-15 23:28:21'),
(88, 'aevs2534@gmail.com', 'verify', 'account', 0, '607f70dabd371', '597416', '2021-04-22 07:24:58', '2021-04-21 11:24:58', '2021-04-21 11:24:58'),
(89, 'letung150200@gmail.com', 'verify', 'account', 0, '6097dd5166a72', '165452', '2021-05-10 20:02:09', '2021-05-10 00:02:09', '2021-05-10 00:02:09'),
(90, 'letung150200@gmail.com', 'reset-password', 'user', 51, '6097dd80838af', '575356', '2021-05-10 20:02:56', '2021-05-10 00:02:56', '2021-05-10 00:02:56'),
(91, 'doanln19@gmail.com', 'verify', 'account', 0, '60fccb0e8271d', '101688', '2021-07-26 09:23:10', '2021-07-25 13:23:10', '2021-07-25 13:23:10'),
(92, 'ducpanda98@gmail.com', 'verify', 'account', 0, '615036a5ab8b0', '623533', '2021-09-27 16:00:21', '2021-09-26 09:00:21', '2021-09-26 09:00:21'),
(95, 'doanln16@gmail.com', 'reset-password', NULL, 0, '6170ddf8b577f', '513702', '2021-10-22 10:26:48', '2021-10-21 03:26:48', '2021-10-21 03:26:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `upload_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `sid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `privacy` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `folder_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `date_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_filename` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filetype` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mime` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` double(10,2) DEFAULT 0.00,
  `extension` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `files`
--

INSERT INTO `files` (`id`, `upload_by`, `sid`, `privacy`, `ref`, `ref_id`, `folder_id`, `date_path`, `filename`, `original_filename`, `filetype`, `mime`, `size`, `extension`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, '7b9c21adf2dea6ff6449291d028bc688', 'public', 'theme', 3, 0, '2020/04/30', 'webtmdt1-5eaae4a4bd932.jpg', 'webtmdt1.jpg', NULL, NULL, 76.29, 'jpg', NULL, NULL, '2020-04-30 14:45:56', '2020-04-30 14:45:56'),
(2, 1, 'fbe799f8fbfd6f77b1923cccd29ac294', 'public', 'project', 1, 0, '2020/04/30', '002-5e120ed917e4c-5eaaedd33a4e9.png', '002-5e120ed917e4c.png', NULL, NULL, 911.80, 'png', NULL, NULL, '2020-04-30 15:25:07', '2020-04-30 15:25:07'),
(3, 1, '98b07955c3e322874b55c046285ef854', 'public', 'project', 1, 0, '2020/04/30', '003-5e120ed91bfbb-5eaaedd34f9a7.png', '003-5e120ed91bfbb.png', NULL, NULL, 921.92, 'png', NULL, NULL, '2020-04-30 15:25:07', '2020-04-30 15:25:07'),
(4, 1, '53783743547723f7e1a9e00b1e017220', 'public', 'project', 1, 0, '2020/04/30', '004-5e120ed91f080-5eaaedd365d5b.png', '004-5e120ed91f080.png', NULL, NULL, 618.28, 'png', NULL, NULL, '2020-04-30 15:25:07', '2020-04-30 15:25:07'),
(5, 1, '8db766850716313285b191441c476bb2', 'public', 'project', 1, 0, '2020/04/30', '006-5e120ed92434a-5eaaedd372d69.png', '006-5e120ed92434a.png', NULL, NULL, 333.99, 'png', NULL, NULL, '2020-04-30 15:25:07', '2020-04-30 15:25:07'),
(6, 1, '1c93d832fe29dcdae204fc04fc818761', 'public', 'gallery', 0, 0, '2020/05/28', 'screencapture-moondental-vn-2020-05-28-17_18_14-5ecf9104dd9e9.png', 'screencapture-moondental-vn-2020-05-28-17_18_14.png', 'image', 'image/png', 5023.65, 'png', NULL, NULL, '2020-05-28 10:23:01', '2020-05-28 10:23:01'),
(13, 1, '28719f2bf3367fc4e5a1139db2136a25', 'public', 'theme', 4, 0, '2020/06/17', 'home2-large-5ee9016e44fa2.jpg', 'home2-large.jpg', NULL, NULL, 279.62, 'jpg', NULL, NULL, '2020-06-17 04:29:18', '2020-06-17 04:29:18'),
(14, 1, '58ed48df1ffe0b71f7a039fc6d4a4f35', 'public', 'theme', 4, 0, '2020/06/17', 'image-lightbox-5ee9016e47ff5.jpg', 'image-lightbox.jpg', NULL, NULL, 97.87, 'jpg', NULL, NULL, '2020-06-17 04:29:18', '2020-06-17 04:29:18'),
(15, 1, 'b0f3669dffdc8d25ba3eb05978201273', 'public', 'theme', 4, 0, '2020/06/17', 'img-large-5ee9016e4b70b.jpg', 'img-large.jpg', NULL, NULL, 98.97, 'jpg', NULL, NULL, '2020-06-17 04:29:18', '2020-06-17 04:29:18'),
(16, 1, 'a2ee8fa88c2e55788dd5ebb914918318', 'public', 'theme', 4, 0, '2020/06/17', 'img-pointer1-5ee9016e4f08c.jpg', 'img-pointer1.jpg', NULL, NULL, 98.97, 'jpg', NULL, NULL, '2020-06-17 04:29:18', '2020-06-17 04:29:18'),
(17, 1, 'fb588850f5e5beccb25ee3100ca682a9', 'public', 'theme', 4, 0, '2020/06/17', 'img-pointer2-5ee9016e54858.jpg', 'img-pointer2.jpg', NULL, NULL, 185.06, 'jpg', NULL, NULL, '2020-06-17 04:29:18', '2020-06-17 04:29:18'),
(18, 1, 'cfec00d3a09f0ca29b5754401f0105cb', 'public', 'theme', 4, 0, '2020/06/17', 'lightbox-preview-5ee9016e59f98.jpg', 'lightbox-preview.jpg', NULL, NULL, 225.36, 'jpg', NULL, NULL, '2020-06-17 04:29:18', '2020-06-17 04:29:18'),
(19, 1, '66c1fd99776d0832f5e55f610e53378c', 'public', 'gallery', 0, 0, '2020/06/21', '567675-how-to-get-started-with-wordpress-5eeecdf05676e.jpg', '567675-how-to-get-started-with-wordpress.jpg', 'image', 'image/jpeg', 48.48, 'jpg', NULL, NULL, '2020-06-21 14:03:12', '2020-06-21 14:03:12'),
(20, 1, '4bbc036f2a755c80f60685292d62c6ed', 'public', 'gallery', 0, 0, '2020/06/21', 'thiet-ke-web-wordpress-moi-linh-vuc-5eeecf484057e.jpg', 'thiet-ke-web-wordpress-moi-linh-vuc.jpg', 'image', 'image/jpeg', 180.59, 'jpg', NULL, NULL, '2020-06-21 14:08:56', '2020-06-21 14:08:56'),
(21, 1, '18c188349126330ac352d81015c18e58', 'public', 'gallery', 0, 0, '2020/06/21', 'screencapture-doanle-chinhlatoi-vn-2020-06-09-10_04_43-5eeede6da28da.png', 'screencapture-doanle-chinhlatoi-vn-2020-06-09-10_04_43.png', 'image', 'image/png', 301.20, 'png', NULL, NULL, '2020-06-21 15:13:33', '2020-06-21 15:13:33'),
(22, 1, 'da2afe798a2efc3fdbf87fd7ed117488', 'public', 'gallery', 0, 0, '2020/06/21', 'screencapture-doanle-chinhlatoi-vn-2020-06-09-10_02_51-5eeede6dd5be8.png', 'screencapture-doanle-chinhlatoi-vn-2020-06-09-10_02_51.png', 'image', 'image/png', 1061.99, 'png', NULL, NULL, '2020-06-21 15:13:33', '2020-06-21 15:13:33'),
(23, 1, '24a5e00a67b426aead2cf9fa28538878', 'public', 'gallery', 0, 0, '2020/06/21', 'screencapture-doanle-chinhlatoi-vn-2020-06-09-10_05_15-5eeede6e62a7c.png', 'screencapture-doanle-chinhlatoi-vn-2020-06-09-10_05_15.png', 'image', 'image/png', 228.59, 'png', NULL, NULL, '2020-06-21 15:13:34', '2020-06-21 15:13:34'),
(24, 1, '34794df057eeb68be609db18b5137a86', 'public', 'gallery', 0, 0, '2020/06/21', 'screencapture-doanle-chinhlatoi-vn-2020-06-09-10_06_08-5eeede6f0672d.png', 'screencapture-doanle-chinhlatoi-vn-2020-06-09-10_06_08.png', 'image', 'image/png', 220.94, 'png', NULL, NULL, '2020-06-21 15:13:35', '2020-06-21 15:13:35'),
(25, 1, '60009c6aaad9956731e6dbab37383b52', 'public', 'gallery', 0, 0, '2020/06/21', 'screencapture-doanle-chinhlatoi-vn-2020-06-09-10_05_38-5eeede6ee03ae.png', 'screencapture-doanle-chinhlatoi-vn-2020-06-09-10_05_38.png', 'image', 'image/png', 1372.05, 'png', NULL, NULL, '2020-06-21 15:13:35', '2020-06-21 15:13:35'),
(26, 1, 'd560878a1b51b2f49ad98b73a5c66658', 'public', 'gallery', 0, 0, '2020/06/21', 'screencapture-doanle-chinhlatoi-vn-2020-06-09-10_06_32-5eeede6f46138.png', 'screencapture-doanle-chinhlatoi-vn-2020-06-09-10_06_32.png', 'image', 'image/png', 133.57, 'png', NULL, NULL, '2020-06-21 15:13:35', '2020-06-21 15:13:35'),
(27, 1, '7c0efe723c770072dd0a7729a0a0105d', 'public', 'gallery', 0, 0, '2020/06/25', '3BF20230-1A54-4CFA-A994-42ED4F839F72-5ef4aab531eb3.jpeg', '3BF20230-1A54-4CFA-A994-42ED4F839F72.jpeg', 'image', 'image/jpeg', 4233.30, 'jpeg', NULL, NULL, '2020-06-26 00:46:29', '2020-06-26 00:46:29'),
(29, 1, 'e6fdf0a7ba372e30c5155d7e40113a17', 'public', 'project', 23, 0, '2020/07/07', 'screencapture-nooffood-vcc-vn-2020-07-07-17_45_10-5f045e3ad40d1.png', 'screencapture-nooffood-vcc-vn-2020-07-07-17_45_10.png', NULL, NULL, 2559.41, 'png', NULL, NULL, '2020-07-07 22:36:26', '2020-07-07 22:36:26'),
(30, 1, 'fef133e934d1fd282d3d450da0771432', 'public', 'project', 23, 0, '2020/07/07', 'screencapture-nooffood-vcc-vn-san-pham-2020-07-07-17_59_45-5f045e3ae34ab.png', 'screencapture-nooffood-vcc-vn-san-pham-2020-07-07-17_59_45.png', NULL, NULL, 1346.87, 'png', NULL, NULL, '2020-07-07 22:36:26', '2020-07-07 22:36:26'),
(31, 1, '1d7d37df5e65dd3d1c92f7ca35640532', 'public', 'project', 23, 0, '2020/07/07', 'screencapture-nooffood-vcc-vn-san-pham-com-rang-dua-bo-2x-html-2020-07-07-18_01_41-5f045e3aef45b.png', 'screencapture-nooffood-vcc-vn-san-pham-com-rang-dua-bo-2x-html-2020-07-07-18_01_41.png', NULL, NULL, 1269.67, 'png', NULL, NULL, '2020-07-07 22:36:26', '2020-07-07 22:36:26'),
(32, 1, 'd672aba541e2b9a518c4e521ca65bee9', 'public', 'project', 23, 0, '2020/07/07', 'screencapture-nooffood-vcc-vn-gio-hang-html-2020-07-07-18_03_05-5f045e3b02251.png', 'screencapture-nooffood-vcc-vn-gio-hang-html-2020-07-07-18_03_05.png', NULL, NULL, 849.63, 'png', NULL, NULL, '2020-07-07 22:36:27', '2020-07-07 22:36:27'),
(33, 1, 'fa3f00b38ef189cae88476b216bdbb9e', 'public', 'project', 23, 0, '2020/07/07', 'screencapture-nooffood-vcc-vn-2020-07-07-18_10_11-5f045e3b0445f.png', 'screencapture-nooffood-vcc-vn-2020-07-07-18_10_11.png', NULL, NULL, 274.21, 'png', NULL, NULL, '2020-07-07 22:36:27', '2020-07-07 22:36:27'),
(34, 1, 'd688b72a06c05daafb92e7f38a9f4763', 'public', 'project', 23, 0, '2020/07/07', 'screencapture-nooffood-vcc-vn-san-pham-2020-07-07-18_27_22-5f045e3b0bb7c.png', 'screencapture-nooffood-vcc-vn-san-pham-2020-07-07-18_27_22.png', NULL, NULL, 41.86, 'png', NULL, NULL, '2020-07-07 22:36:27', '2020-07-07 22:36:27'),
(35, 1, 'a7ff00445ef319ec0b047fcc169f457e', 'public', 'project', 23, 0, '2020/07/07', 'screencapture-nooffood-vcc-vn-san-pham-2020-07-07-18_29_10-5f045e3b0ec9a.png', 'screencapture-nooffood-vcc-vn-san-pham-2020-07-07-18_29_10.png', NULL, NULL, 73.29, 'png', NULL, NULL, '2020-07-07 22:36:27', '2020-07-07 22:36:27'),
(36, 1, '4a8f69d2bbe6be9b18c11273303e9fb9', 'public', 'project', 23, 0, '2020/07/07', 'screencapture-nooffood-vcc-vn-gio-hang-html-2020-07-07-18_31_06-5f045e3b11c73.png', 'screencapture-nooffood-vcc-vn-gio-hang-html-2020-07-07-18_31_06.png', NULL, NULL, 76.97, 'png', NULL, NULL, '2020-07-07 22:36:27', '2020-07-07 22:36:27'),
(37, 1, '3c916988f91e92dee1db7d57a886d91f', 'public', 'project', 23, 0, '2020/07/07', 'screencapture-nooffood-vcc-vn-thanh-toan-html-2020-07-07-18_04_06-5f045e3b168ae.png', 'screencapture-nooffood-vcc-vn-thanh-toan-html-2020-07-07-18_04_06.png', NULL, NULL, 832.48, 'png', NULL, NULL, '2020-07-07 22:36:27', '2020-07-07 22:36:27'),
(38, 1, '5ec37ece53f33cb484e93fce8d93c9ae', 'public', 'gallery', 0, 0, '2020/07/08', '0001.jpg-5f0531e975376.png', '0001.jpg.png', 'image', 'image/png', 695.61, 'png', NULL, NULL, '2020-07-08 13:39:37', '2020-07-08 13:39:37'),
(39, 1, '6b81cb666545031f5164e3c1246d22eb', 'public', 'gallery', 0, 0, '2020/07/08', '0002-5f0531f60f250.jpg', '0002.jpg', 'image', 'image/jpeg', 174.96, 'jpg', NULL, NULL, '2020-07-08 13:39:50', '2020-07-08 13:39:50'),
(40, 1, 'be9e6ed9c4018b27eda8a6891ff002ae', 'public', 'gallery', 0, 0, '2020/07/08', 'screencapture-nooffood-vcc-vn-2020-07-07-18_10_11-5f05320204a50.png', 'screencapture-nooffood-vcc-vn-2020-07-07-18_10_11.png', 'image', 'image/png', 274.21, 'png', NULL, NULL, '2020-07-08 13:40:02', '2020-07-08 13:40:02'),
(41, 1, '230afcd976bf26e43c2b08ac5bd6e910', 'public', 'gallery', 0, 0, '2020/07/08', '0004-5f0550d420706.png', '0004.png', 'image', 'image/png', 1105.64, 'png', NULL, NULL, '2020-07-08 15:51:32', '2020-07-08 15:51:32'),
(42, 1, '8927febe1ab19ed27802019a7f6ceab3', 'public', 'gallery', 0, 0, '2020/07/08', '0005-5f0589602460f.png', '0005.png', 'image', 'image/png', 674.86, 'png', NULL, NULL, '2020-07-08 19:52:48', '2020-07-08 19:52:48'),
(43, 1, '64bdf24395545953408ddbb9778188e5', 'public', 'gallery', 0, 0, '2020/07/08', '006-5f058e51a9224.png', '006.png', 'image', 'image/png', 956.40, 'png', NULL, NULL, '2020-07-08 20:13:53', '2020-07-08 20:13:53'),
(45, 1, '563b3f02bfb6a02ba96c4d2a36e5a8a5', 'public', 'gallery', 0, 0, '2020/07/09', '0008-5f06d6454875a.png', '0008.png', 'image', 'image/png', 1353.20, 'png', NULL, NULL, '2020-07-09 19:33:09', '2020-07-09 19:33:09'),
(46, 1, 'cade39249251045799090f1667954002', 'public', 'gallery', 0, 0, '2020/07/09', 'livestream-tren-sapo-go-5f06e7d73d66d.jpg', 'livestream-tren-sapo-go.jpg', 'image', 'image/jpeg', 58.71, 'jpg', NULL, NULL, '2020-07-09 20:48:07', '2020-07-09 20:48:07'),
(47, 1, '276f98036e4b7fed9f3ea8d71413baa1', 'public', 'gallery', 0, 0, '2020/07/09', 'livestream-tren-sapo-go-5f06e8107842d.png', 'livestream-tren-sapo-go.png', 'image', 'image/png', 275.59, 'png', NULL, NULL, '2020-07-09 20:49:04', '2020-07-09 20:49:04'),
(48, 1, 'f74c14a45c49c59c527128f7d5e75bcb', 'public', 'gallery', 0, 0, '2020/07/11', '0001-5f0932083cbd1.png', '0001.png', 'image', 'image/png', 40.76, 'png', NULL, NULL, '2020-07-11 14:29:12', '2020-07-11 14:29:12'),
(49, 1, '6a5601deab3cf77870565517c318c94a', 'public', 'gallery', 0, 0, '2020/07/11', '0002-5f0933df61854.png', '0002.png', 'image', 'image/png', 30.70, 'png', NULL, NULL, '2020-07-11 14:37:03', '2020-07-11 14:37:03'),
(50, 1, 'adaf179f239e0f130b99971c48c4d66b', 'public', 'gallery', 0, 0, '2020/07/11', '0003-5f09356516f94.png', '0003.png', 'image', 'image/png', 10.19, 'png', NULL, NULL, '2020-07-11 14:43:33', '2020-07-11 14:43:33'),
(51, 1, 'ed2448ea1aa28c86cb7f6cb7ec0ac25f', 'public', 'gallery', 0, 0, '2020/07/11', '0004-5f09362747503.png', '0004.png', 'image', 'image/png', 9.82, 'png', NULL, NULL, '2020-07-11 14:46:47', '2020-07-11 14:46:47'),
(52, 1, 'd75b13f967f22d444f57851dc9749fed', 'public', 'gallery', 0, 0, '2020/07/11', 'Laravel-MVC-model-MSA-Technosoft-5f098f0c51d2d.png', 'Laravel-MVC-model-MSA-Technosoft.png', 'image', 'image/png', 57.99, 'png', NULL, NULL, '2020-07-11 21:06:04', '2020-07-11 21:06:04'),
(53, 1, '330846ead14028d69370c166ef9fa0be', 'public', 'post', 32, 0, '2020/08/08', '08-5f2ec637b1717.png', '08.png', NULL, NULL, 336.77, 'png', NULL, NULL, '2020-08-09 02:35:19', '2020-08-09 02:35:19'),
(54, 1, '83f5caed124bf3a1b90d70a63476ee9a', 'public', 'post', 32, 0, '2020/08/08', '09-5f2ec637b5669.png', '09.png', NULL, NULL, 229.87, 'png', NULL, NULL, '2020-08-09 02:35:19', '2020-08-09 02:35:19'),
(55, 1, 'e0176d40b36c88b4a958e11493d64168', 'public', 'post', 32, 0, '2020/08/08', '10-5f2ec637b7dc5.png', '10.png', NULL, NULL, 200.32, 'png', NULL, NULL, '2020-08-09 02:35:19', '2020-08-09 02:35:19'),
(56, 1, '4fc9adc83d3f54f0f0d397956319b663', 'public', 'post', 32, 0, '2020/08/08', '11-5f2ec637be3ae.png', '11.png', NULL, NULL, 333.14, 'png', NULL, NULL, '2020-08-09 02:35:19', '2020-08-09 02:35:19'),
(57, 1, '2ec59f3c2610c2d41b580bbd09212004', 'public', 'post', 32, 0, '2020/08/08', '07-5f2ec637c346a.png', '07.png', NULL, NULL, 326.86, 'png', NULL, NULL, '2020-08-09 02:35:19', '2020-08-09 02:35:19'),
(58, 1, 'aaae7dfbe3a3c3614d67d339c9f42732', 'public', 'post', 32, 0, '2020/08/08', '05-5f2ec637c9b43.png', '05.png', NULL, NULL, 1357.10, 'png', NULL, NULL, '2020-08-09 02:35:19', '2020-08-09 02:35:19'),
(59, 1, 'e076b37c8a586fd75c534d859e61d285', 'public', 'post', 32, 0, '2020/08/08', '03-5f2ec637ce2ea.png', '03.png', NULL, NULL, 926.75, 'png', NULL, NULL, '2020-08-09 02:35:19', '2020-08-09 02:35:19'),
(60, 1, 'a0a73e0f00ee2402cb39a8b22d20344c', 'public', 'post', 32, 0, '2020/08/08', '02-5f2ec637d8a76.png', '02.png', NULL, NULL, 1661.60, 'png', NULL, NULL, '2020-08-09 02:35:19', '2020-08-09 02:35:19'),
(61, 1, 'ff78d842c70ef6a4db3059e2863c9f57', 'public', 'post', 32, 0, '2020/08/08', '04-5f2ec637dd060.png', '04.png', NULL, NULL, 1132.87, 'png', NULL, NULL, '2020-08-09 02:35:19', '2020-08-09 02:35:19'),
(62, 1, '70c154ae1d43dc094a296c16b5e96bc9', 'public', 'post', 32, 0, '2020/08/08', '06-5f2ec637e1775.png', '06.png', NULL, NULL, 1216.05, 'png', NULL, NULL, '2020-08-09 02:35:19', '2020-08-09 02:35:19'),
(63, 1, '3a1d995d6812e4d9001fd30b54519b21', 'public', 'gallery', 0, 0, '2020/08/08', '03-5f2ec7db23dea.png', '03.png', 'image', 'image/png', 926.75, 'png', NULL, NULL, '2020-08-09 02:42:19', '2020-08-09 02:42:19'),
(64, 1, '47e2ead3af50eeabc0553241d86b18be', 'public', 'gallery', 0, 0, '2020/08/08', '02-5f2ec7db2ab47.png', '02.png', 'image', 'image/png', 1661.60, 'png', NULL, NULL, '2020-08-09 02:42:19', '2020-08-09 02:42:19'),
(65, 1, '1202975eef90e449647ef3c9b77da2cb', 'public', 'gallery', 0, 0, '2020/08/08', '04-5f2ec7dc3f673.png', '04.png', 'image', 'image/png', 1132.87, 'png', NULL, NULL, '2020-08-09 02:42:20', '2020-08-09 02:42:20'),
(66, 1, 'efc8111fa275cbcfa594d8df7639ce39', 'public', 'gallery', 0, 0, '2020/08/08', '05-5f2ec7dc62de2.png', '05.png', 'image', 'image/png', 1357.10, 'png', NULL, NULL, '2020-08-09 02:42:20', '2020-08-09 02:42:20'),
(67, 1, 'c3a6d39ee53186a2e7c6452860f1e80b', 'public', 'gallery', 0, 0, '2020/08/08', '07-5f2ec7dd4a422.png', '07.png', 'image', 'image/png', 326.86, 'png', NULL, NULL, '2020-08-09 02:42:21', '2020-08-09 02:42:21'),
(68, 1, '747b46c8e306ed1f9c49786240f765c2', 'public', 'gallery', 0, 0, '2020/08/08', '06-5f2ec7dd47b44.png', '06.png', 'image', 'image/png', 1216.05, 'png', NULL, NULL, '2020-08-09 02:42:21', '2020-08-09 02:42:21'),
(69, 1, '6b09b52706c0ea844f58955d1fc72e88', 'public', 'gallery', 0, 0, '2020/08/08', '09-5f2ec7ddeeb18.png', '09.png', 'image', 'image/png', 229.87, 'png', NULL, NULL, '2020-08-09 02:42:22', '2020-08-09 02:42:22'),
(70, 1, 'a7e7abbc4b509acbc06f89a8eb429b85', 'public', 'gallery', 0, 0, '2020/08/08', '08-5f2ec7ddc7b65.png', '08.png', 'image', 'image/png', 336.77, 'png', NULL, NULL, '2020-08-09 02:42:22', '2020-08-09 02:42:22'),
(71, 1, 'd0afb8a579a6ba6a132be09a86f65491', 'public', 'gallery', 0, 0, '2020/08/08', '10-5f2ec7de70ea8.png', '10.png', 'image', 'image/png', 200.32, 'png', NULL, NULL, '2020-08-09 02:42:22', '2020-08-09 02:42:22'),
(72, 1, '55bae2c7569edf81d96d3b841f25e901', 'public', 'gallery', 0, 0, '2020/08/08', '11-5f2ec7de7f49b.png', '11.png', 'image', 'image/png', 333.14, 'png', NULL, NULL, '2020-08-09 02:42:22', '2020-08-09 02:42:22'),
(110, 1, '67c8044a441713c2ccd255a3c04c160c', 'public', 'transaction', 46, 0, '2021/10/07', 'img-large-615ec6046b7da.jpg', 'img-large-615ec6046b7da.jpg', 'image', 'image/jpeg', 98.97, 'jpg', NULL, NULL, '2021-10-07 10:03:48', '2021-10-07 10:03:48'),
(111, 1, '678fdac94afc3fb9f59cc211e4775c82', 'public', 'transaction', 47, 0, '2021/10/07', 'img-large-615ec7d9e1e1a.jpg', 'img-large-615ec7d9e1e1a.jpg', 'image', 'image/jpeg', 98.97, 'jpg', NULL, NULL, '2021-10-07 10:11:37', '2021-10-07 10:11:37'),
(112, 1, '485ed88739aca0c9d74bc53776de810b', 'public', 'transaction', 48, 0, '2021/10/07', 'img-large-615ec88c668b1.jpg', 'img-large-615ec88c668b1.jpg', 'image', 'image/jpeg', 98.97, 'jpg', NULL, NULL, '2021-10-07 10:14:36', '2021-10-07 10:14:36'),
(113, 1, 'c052064ab97b746509fe76343a21b5d6', 'public', 'gallery', 0, 0, '2021/10/21', '1-61712736dbcee.jpg', '1.jpg', 'image', 'image/jpeg', 5.28, 'jpg', NULL, NULL, '2021-10-21 08:39:19', '2021-10-21 08:39:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `html_areas`
--

CREATE TABLE `html_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'system',
  `ref_id` bigint(20) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `html_areas`
--

INSERT INTO `html_areas` (`id`, `name`, `slug`, `ref`, `ref_id`) VALUES
(1, 'Head (css Hoặc js)', 'head', 'default', 0),
(2, 'Top (js: GA, FB,...)', 'top', 'default', 0),
(3, 'Header', 'header', 'default', 0),
(4, 'Đầu nội dung', 'article_top', 'default', 0),
(5, 'Main', 'main', 'default', 0),
(6, 'Cuối nội dung', 'article_bottom', 'default', 0),
(7, 'Sidebar', 'sidebar', 'default', 0),
(8, 'Đầu sidebar', 'sidebar_top', 'default', 0),
(9, 'Cuối sidebar', 'sidebar_bottom', 'default', 0),
(10, 'Footer', 'footer', 'default', 0),
(11, 'Bottom (js)', 'bottom', 'default', 0),
(12, 'Tùy chỉnh (custom)', 'custom', 'default', 0),
(13, 'Promo Area', 'promos', 'theme', 2),
(14, 'Các dịch vụ', 'services', 'theme', 2),
(15, 'Danh sách khách hàng', 'clients', 'theme', 2),
(16, 'Danh sách phản hồi', 'testimonials', 'theme', 2),
(17, 'Gói dịch vụ tab 1', 'tab_1_packages', 'theme', 2),
(18, 'Gói dịch vụ tab 2', 'tab_2_packages', 'theme', 2),
(19, 'Gói dịch vụ tab 3', 'tab_3_packages', 'theme', 2),
(20, 'Nhóm làm việc', 'team_members', 'theme', 2),
(21, 'Footer', 'news_footer', 'theme', 1),
(22, 'News Sidebar', 'news_sidebar', 'theme', 1),
(23, 'Trang Chủ', 'home', 'theme', 1),
(24, 'Trang chi tiết bài viết', 'single_post', 'theme', 1),
(25, 'Trang chi tiết page', 'single_page', 'theme', 1),
(26, 'Trang Chủ', 'home', 'theme', 3),
(27, 'Dịch vụ trên trang chủ', 'home_services', 'theme', 3),
(28, 'Danh sách phản hồi', 'testimonials', 'theme', 3),
(29, 'Nhóm làm việc', 'team_members', 'theme', 3),
(30, 'Các câu hỏi thường gap96', 'contact_faq', 'theme', 3),
(31, 'Báo giá (trên trang chủ)', 'home_pricing', 'theme', 3),
(32, 'Post Sidebar', 'sidebar_post', 'theme', 3),
(33, 'Project Sidebar', 'sidebar_project', 'theme', 3),
(34, 'Page Sidebar', 'sidebar_page', 'theme', 3),
(35, 'Trang Chủ', 'home', 'theme', 4),
(36, 'Docs Left Sidebar', 'sidebar_docs_left', 'theme', 4),
(37, 'Docs Right Sidebar', 'sidebar_docs_right', 'theme', 4),
(38, 'Post Sidebar', 'sidebar_post', 'theme', 4),
(39, 'Project Sidebar', 'sidebar_project', 'theme', 4),
(40, 'Page Sidebar', 'sidebar_page', 'theme', 4),
(41, 'Trang Chủ Tài liệu', 'home_docs', 'theme', 4),
(42, 'Tài liệu - trang tin bài', 'post_docs', 'theme', 4),
(43, 'Dock Body', 'docbody', 'theme', 4),
(44, 'Docly Footer', 'docly_footer', 'theme', 4),
(45, 'Home Tabs', 'home_tabs', 'theme', 4),
(46, 'Help Area', 'help_area', 'theme', 4),
(47, 'Post Setting', 'post_settings', 'theme', 4),
(48, 'Home Services', 'home_services', 'theme', 4),
(49, 'Phản hồi từ khách  hàng', 'testimonials', 'theme', 4),
(50, 'Thành viên nhóm', 'team_members', 'theme', 4),
(51, 'Chân trang', 'body_bottom', 'theme', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `html_components`
--

CREATE TABLE `html_components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `component_id` bigint(20) UNSIGNED DEFAULT 0,
  `area_id` bigint(20) DEFAULT 0,
  `priority` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `html_components`
--

INSERT INTO `html_components` (`id`, `component_id`, `area_id`, `priority`, `data`) VALUES
(1, 35, 10, 1, '{\"title\":\"Gi\\u1edbi thi\\u1ec7u\",\"description\":\"Web 1-0-2 l\\u00e0 m\\u1ed9t n\\u1ec1n t\\u1ea3ng web n\\u01a1i ai ai c\\u0169ng c\\u00f3 th\\u1ec3 t\\u1ea1o n\\u00ean nh\\u1eefng \\u0111i\\u1ec1u tuy\\u1ec7t v\\u1eddi ch\\u1ec9 c\\u1ea7n c\\u00f3 1 \\u00fd t\\u01b0\\u1edfng \\u0111\\u1ed9c \\u0111\\u00e1o hay \\u0111i\\u00ean r\\u1ed3 nh\\u1ea5t\"}'),
(2, 37, 10, 2, '{\"title\":\"D\\u1ecbch v\\u1ee5\",\"menu_id\":\"5\"}'),
(3, 38, 10, 3, '{\"title\":null,\"dynamic_id\":\"0\",\"category_id\":\"0\",\"sorttype\":\"1\",\"post_number\":\"2\"}'),
(4, 36, 10, 4, '{\"title\":\"Li\\u00ean H\\u1ec7\",\"email\":\"doanln16@gmail.com\",\"phone_number\":\"0945786960\",\"address\":\"172, d\\u01b0\\u1eddng B\\u00e0 Tri\\u1ec7u, p. D\\u00e2n ch\\u1ee7, tp. H\\u00f2a B\\u00ecnh, t\\u1ec9nh H\\u00f2a B\\u00ecnh\"}'),
(5, 39, 26, 1, '{\"slider_id\":\"1\",\"btn_text\":\"Chi ti\\u1ebft\"}'),
(6, 40, 26, 2, '{\"title\":\"B\\u1ea1n ch\\u1ec9 c\\u1ea7n n\\u00eau ra nh\\u1eefng <strong>\\u00fd t\\u01b0\\u1edfng<\\/strong>, ph\\u1ea7n c\\u00f2n l\\u1ea1i \\u0111\\u1ec3 ch\\u00fang t\\u00f4i lo!\",\"content\":\"<strong>\\u0110\\u1eebng kinh doanh khi b\\u1ea1n ch\\u01b0a c\\u00f3 t\\u00ean mi\\u1ec1n!<\\/strong> - \\u0110\\u00f3 l\\u00e0 c\\u00e2u qu\\u1ea3ng c\\u00e1o c\\u1ee7a c\\u00e1c nh\\u00e0 \\u0111\\u0103ng k\\u00fd t\\u00ean mi\\u1ec1n. \\r\\nC\\u00f2n ch\\u00fang t\\u00f4i th\\u00ec th\\u1ea5y r\\u1eb1ng <strong>\\u0110\\u00e3 kinh doanh th\\u00ec n\\u00ean t\\u1ea1o m\\u1ed9t website<\\/strong>.\\r\\n\\r\\nH\\u00e3y b\\u1eaft \\u0111\\u1ea7u v\\u1edbi vi\\u1ec7c l\\u00ean \\u00fd t\\u01b0\\u1edfng v\\u00e0o t\\u1ea1o cho m\\u00ecnh m\\u1ed9t trang web ngay h\\u00f4m nay!\",\"image\":\"5e7b8c368d0af.png\",\"youtube_url\":\"https:\\/\\/www.youtube.com\\/watch?v=LtQmmTylJbc\",\"services\":\"Thi\\u1ebft k\\u1ebf website\\r\\nThi\\u1ebft k\\u1ebf logo\\r\\nCho thu\\u00ea t\\u00ean mi\\u1ec1n\\r\\nCho thu\\u00ea hosting\"}'),
(7, 41, 26, 3, '{\"title\":\"C\\u00e1c d\\u1ecbch v\\u1ee5\",\"description\":\"Ch\\u00fang t\\u00f4i lu\\u00f4n c\\u1ed1 g\\u1eafng mang \\u0111\\u1ebfn cho b\\u1ea1n nh\\u1eefng d\\u1ecbch v\\u1ee5 t\\u1ed1t nh\\u1ea5t tr\\u00ean chi ph\\u00ed m\\u00e0 b\\u1ea1n ph\\u1ea3i b\\u1ecf ra!\",\"bg_color\":null,\"bg_position\":null,\"bg_half\":null,\"class_name\":null,\"bg_default_color\":\"gray\",\"advance\":null}'),
(8, 42, 27, 1, '{\"title\":\"Thi\\u1ebft k\\u1ebf website\",\"description\":\"Giao di\\u1ec7n b\\u1eaft m\\u1eaft, nh\\u1eb9, chu\\u1ea9n SEO, th\\u00edch \\u1ee9ng tr\\u00ean m\\u1ecdi thi\\u1ebft b\\u1ecb\",\"link\":\"\\/\",\"icon\":\"ti-write\"}'),
(9, 42, 27, 3, '{\"title\":\"Thi\\u1ebft K\\u1ebf Logo\",\"description\":\"T\\u1ea1o n\\u00ean n\\u1ed9 nh\\u1eadn di\\u1ec7n th\\u01b0\\u01a1ng hi\\u1ec7u kh\\u00f4ng l\\u1eabn v\\u00e0o \\u0111\\u00e2u \\u0111\\u01b0\\u1ee3c\",\"link\":\"\\/\",\"icon\":\"ti-palette\"}'),
(10, 42, 27, 2, '{\"title\":\"Nh\\u1eadn di\\u1ec7n tr\\u00ean internet\",\"description\":\"Microsite \\u2013 Facebook Fanpage \\u2013 Banner ads \\u2013 Email marketing\",\"link\":\"\\/\",\"icon\":\"ti-world\"}'),
(11, 42, 27, 4, '{\"title\":\"Nh\\u1eadn di\\u1ec7n v\\u0103n ph\\u00f2ng\",\"description\":\"Name card \\u2013 Phong b\\u00ec th\\u01b0, ti\\u2013 Name card \\u2013 Phong b\\u00ec th\\u01b0, ti\\u00eau \\u0111\\u1ec1 th\\u01b0 \\u2013 H\\u00f3a \\u0111\\u01a1n...\",\"link\":\"\\/\",\"icon\":\"ti-home\"}'),
(12, 42, 27, 5, '{\"title\":\"SEO\",\"description\":\"T\\u1ed1i \\u01b0u h\\u00f3a cho c\\u00e1c c\\u00f4ng c\\u1ee5 t\\u00ecm ki\\u1ebfm, d\\u1ec5 d\\u00e0ng ti\\u1ebfp c\\u1eadn kh\\u00e1ch h\\u00e0ng\",\"link\":\"\\/\",\"icon\":\"ti-google\"}'),
(13, 42, 27, 6, '{\"title\":\"HOSTING GI\\u00c1 R\\u1eba\",\"description\":\"Cho thu\\u00ea hosting ch\\u1ea5t l\\u01b0\\u1ee3ng cao v\\u1edbi gi\\u00e1 c\\u1ea3 ph\\u1ea3i ch\\u0103ng nh\\u1ea5t\",\"link\":\"\\/\",\"icon\":\"ti-harddrives\"}'),
(14, 43, 26, 4, '{\"fact_1\":\"144\\r\\nD\\u1ef1 \\u00e1n \\r\\nL\\u00e0 s\\u1ed1 d\\u1ef1 \\u00e1n \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c tri\\u1ec3n khai v\\u00e0 th\\u00e0nh c\\u00f4ng\",\"fact_2\":\"42\\r\\nKh\\u00e1ch h\\u00e0ng\\r\\n92% Kh\\u00e1ch h\\u00e0ng ti\\u1ebfp t\\u1ee5c h\\u1ee3p t\\u00e1c l\\u00e2u d\\u00e0i\",\"line_1\":\"Thi\\u1ebft k\\u1ebf website = 95\",\"line_2\":\"Thi\\u1ebft k\\u1ebf logo = 58\",\"line_3\":\"D\\u1ecbch v\\u1ee5 hosting - t\\u00ean mi\\u1ec1n = 89\"}'),
(15, 44, 26, 7, '{\"title\":\"D\\u1ef1 \\u00e1n\",\"description\":\"M\\u1ed9t s\\u1ed1 d\\u1ef1 \\u00e1n \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c tri\\u1ec3n khai\",\"sorttype\":\"1\",\"project_number\":\"10\"}'),
(16, 45, 26, 6, '{\"title\":\"Ph\\u1ea3n h\\u1ed3i t\\u1eeb kh\\u00e1ch h\\u00e0ng\",\"description\":\"C\\u00e1c s\\u1ed1 kh\\u00e1ch h\\u00e0ng \\u0111\\u00e3 s\\u1eed d\\u1ee5ng v\\u00e0 g\\u1eedi \\u0111\\u00e1nh gi\\u00e1 t\\u00edch c\\u1ef1c v\\u1ec1 d\\u1ecbch v\\u1ee5 c\\u1ee7a ch\\u00fang t\\u00f4i.\",\"list_type\":\"custom\",\"item_number\":\"5\",\"sort_type\":\"id-ASC\"}'),
(17, 46, 28, 1, '{\"name\":\"T\\u00f9ng \\u0110K\",\"image\":\"5eaafbe0728dd.jpg\",\"job\":\"Gi\\u00e1m \\u0111\\u1ed1c XiaomiWorld.vn\",\"content\":\"T\\u00f4i r\\u1ea5t h\\u00e0i l\\u00f2ng v\\u1ec1 ch\\u1ea5t l\\u01b0\\u1ee3ng d\\u1ecbch v\\u1ee5 c\\u0169ng phong c\\u00e1ch l\\u00e0m vi\\u1ec7c c\\u1ee7a DH Team\"}'),
(18, 46, 28, 2, '{\"name\":\"Hi\\u1ec1n Tr\\u01b0\\u01a1ng\",\"image\":\"5eaafc3ba57c8.jpg\",\"job\":\"Ch\\u1ee7 ahop luxurysell.vn\",\"content\":\"Thi\\u1ebft k\\u1ebf \\u0111\\u1eb9p, nhanh ch\\u00f3ng. Gi\\u00e1 c\\u1ea3 h\\u1ee3p l\\u00fd. N\\u00f3i chung t\\u00f4i r\\u1ea5t h\\u00e0i l\\u00f2ng\"}'),
(19, 48, 29, 1, '{\"name\":\"L\\u00ea Ng\\u1ecdc Do\\u00e3n\",\"avatar\":\"5eab16ab65bcc.png\",\"job\":\"DEV\",\"description\":\"Middleton in objection discovery as agreeable. Edward thrown dining so he my around to.\",\"link\":\"#\",\"is_loader\":null}'),
(20, 48, 29, 2, '{\"name\":\"\\u0110o\\u00e0n Linh\",\"avatar\":\"5eab16e917fe3.png\",\"job\":\"Designer\",\"description\":\"Middleton in objection discovery as agreeable. Edward thrown dining so he my around to.\",\"link\":\"#\",\"is_loader\":null}'),
(21, 48, 29, 3, '{\"name\":\"V\\u0169 Minh Hi\\u1ebfu\",\"avatar\":\"5eab171a8408d.jpg\",\"job\":\"DEV\",\"description\":\"Middleton in objection discovery as agreeable. Edward thrown dining so he my around to.\",\"link\":\"#\",\"is_loader\":null}'),
(22, 47, 26, 8, '{\"title\":\"\\u0110\\u1ed9i ng\\u0169\",\"description\":\"C\\u00e1c th\\u00e0nh vi\\u00ean trong nh\\u00f3m ph\\u00e1t tri\\u1ec3n\",\"background\":\"\",\"list_type\":\"custom\",\"team_id\":\"0\",\"item_number\":\"4\",\"sort_type\":\"id-ASC\"}'),
(23, 49, 26, 9, '{\"title\":\"H\\u00e3y n\\u00f3i v\\u1ec1 \\u00fd t\\u01b0\\u1edfng c\\u1ee7a b\\u1ea1n\",\"description\":\"H\\u00e3y b\\u1eaft \\u0111\\u1ea7u v\\u1edbi vi\\u1ec7c l\\u00ean \\u00fd t\\u01b0\\u1edfng v\\u00e0o t\\u1ea1o cho m\\u00ecnh m\\u1ed9t trang web ngay h\\u00f4m nay!\",\"faq_title\":\"C\\u00e1c c\\u00e2u h\\u1ecfi th\\u01b0\\u1eddng g\\u1eb7p\"}'),
(24, 50, 30, 1, '{\"title\":\"\\u0110\\u0103ng k\\u00fd t\\u00e0i kho\\u00e0n nh\\u01b0 th\\u1ebf n\\u00e0o?\",\"description\":\"Middleton in objection discovery as agreeable. Edward thrown dining so he my around to.\"}'),
(25, 50, 30, 2, '{\"title\":\"C\\u00e1ch t\\u1ea1o nhanh m\\u1ed9t trang web\",\"description\":\"Middleton in objection discovery as agreeable. Edward thrown dining so he my around to.\"}'),
(26, 50, 30, 3, '{\"title\":\"L\\u00e0m sao \\u0111\\u1ec3 thay \\u0111\\u1ed5i giao di\\u1ec7n\",\"description\":\"Middleton in objection discovery as agreeable. Edward thrown dining so he my around to.\"}'),
(27, 50, 30, 4, '{\"title\":\"C\\u00e1ch t\\u1ef1 t\\u1ea1o giao di\\u1ec7n \\u0111\\u1ed9c \\u0111\\u00e1o\",\"description\":\"Middleton in objection discovery as agreeable. Edward thrown dining so he my around to.\"}'),
(28, 51, 26, 10, '{\"title\":\"Blog\",\"description\":null,\"dynamic_id\":\"3\",\"category_id\":\"0\",\"group_by_category\":null,\"sorttype\":\"1\",\"post_number\":\"3\"}'),
(29, 52, 26, 5, '{\"title\":\"B\\u1ea3ng gi\\u00e1\",\"description\":\"D\\u01b0\\u1edbi \\u0111\\u00e2y l\\u00e0 b\\u00e1o gi\\u00e1 m\\u1ed9t s\\u1ed1 d\\u1ecbch v\\u1ee5 c\\u1ee7a WEB102\"}'),
(30, 53, 31, 3, '{\"title\":\"Max\",\"label\":null,\"price\":\"10000000\",\"unit\":\"\\u0110\",\"content\":\"[t] Mi\\u1ec5n ph\\u00ed hosting\\r\\n[t] Mi\\u1ec5n ph\\u00ed t\\u00ean mi\\u1ec1n c\\u1ea5p 2\\r\\n[t] H\\u1ed7 tr\\u1ee3 tr\\u1ecf domain\\r\\n[t] H\\u1ed7 tr\\u1ee3 k\\u1ef9 thu\\u1eadt\\r\\n[t] Full t\\u00ednh n\\u0103ng\\r\\n[t] To\\u00e0n quy\\u1ec1n s\\u1eed d\\u1ee5ng m\\u00e3 ngu\\u1ed3n\",\"active\":null,\"link\":\"\\/services\\/add?service_id=5&package_id=16\",\"price_label\":\"Ch\\u1ec9 t\\u1eeb\"}'),
(31, 53, 31, 2, '{\"title\":\"Chuy\\u00ean Nghi\\u1ec7p\",\"label\":\"HOT\",\"price\":\"5000000\",\"unit\":\"\\u0110\",\"content\":\"[t] Mi\\u1ec5n ph\\u00ed hosting\\r\\n[t] Mi\\u1ec5n ph\\u00ed t\\u00ean mi\\u1ec1n c\\u1ea5p 2\\r\\n[t] H\\u1ed7 tr\\u1ee3 tr\\u1ecf domain\\r\\n[t] H\\u1ed7 tr\\u1ee3 k\\u1ef9 thu\\u1eadt\\r\\n[f] Full t\\u00ednh n\\u0103ng\\r\\n[f] To\\u00e0n quy\\u1ec1n s\\u1eed d\\u1ee5ng m\\u00e3 ngu\\u1ed3n\",\"active\":\"on\",\"link\":\"\\/services\\/add?service_id=4&package_id=12\",\"price_label\":\"Ch\\u1ec9 t\\u1eeb\"}'),
(32, 53, 31, 1, '{\"title\":\"WEB102\",\"label\":null,\"price\":\"0\",\"unit\":\"\\u0110\",\"content\":\"[t] Mi\\u1ec5n ph\\u00ed hosting\\r\\n[t] Mi\\u1ec5n ph\\u00ed t\\u00ean mi\\u1ec1n c\\u1ea5p 2\\r\\n[f] H\\u1ed7 tr\\u1ee3 tr\\u1ecf domain\\r\\n[f] H\\u1ed7 tr\\u1ee3 k\\u1ef9 thu\\u1eadt\\r\\n[f] Full t\\u00ednh n\\u0103ng\\r\\n[f] To\\u00e0n quy\\u1ec1n s\\u1eed d\\u1ee5ng m\\u00e3 ngu\\u1ed3n\",\"active\":null,\"link\":\"\\/services\\/add?service_id=1&package_id=2\",\"price_label\":\"Ch\\u1ec9 t\\u1eeb\"}'),
(33, 56, 32, 1, '{\"title\":\"T\\u00ecm ki\\u1ebfm\"}'),
(34, 54, 32, 2, '{\"title\":\"Danh m\\u1ee5c\",\"dynamic_id\":\"0\",\"parent_id\":\"0\",\"sorttype\":\"6\",\"get_by_dynamic_active\":\"on\"}'),
(35, 57, 32, 3, '{\"facebook\":null,\"twitter\":null,\"youtube\":null,\"linkedin\":null,\"instagram\":null,\"pinterest\":null,\"title\":\"MXH\"}'),
(36, 55, 32, 4, '{\"title\":\"Tin m\\u1edbi nh\\u1ea5t\",\"dynamic_id\":\"0\",\"category_id\":\"0\",\"content_type\":null,\"sorttype\":\"1\",\"post_number\":\"10\"}'),
(37, 58, 34, 1, '{\"title\":\"Th\\u1ebb\",\"sorttype\":\"1\",\"tag_number\":\"10\"}'),
(38, 56, 33, 1, '{\"title\":\"T\\u00ecm ki\\u1ebfm\"}'),
(39, 59, 33, 2, '{\"title\":\"Danh m\\u1ee5c\",\"sorttype\":\"6\"}'),
(40, 75, 44, 1, '{\"title\":null,\"subscribe_button\":\"\\u0110\\u0103ng k\\u00fd\",\"col_sm\":\"6\",\"col_lg\":\"4\"}'),
(41, 76, 44, 2, '{\"menu_id\":\"5\",\"title\":\"D\\u1ecbch v\\u1ee5\",\"col_sm\":\"6\",\"col_lg\":\"3\"}'),
(42, 76, 44, 3, '{\"menu_id\":\"9\",\"title\":\"Li\\u00ean H\\u1ec7\",\"col_sm\":\"6\",\"col_lg\":\"3\"}'),
(43, 76, 44, 4, '{\"menu_id\":\"8\",\"title\":\"Li\\u00ean k\\u1ebft\",\"col_sm\":\"6\",\"col_lg\":\"2\"}'),
(45, 82, 35, 2, '{\"title\":\"T\\u1ea1i sao b\\u1ea1n c\\u1ea7n ph\\u1ea3i c\\u00f3 <br> m\\u1ed9t website?\",\"description\":\"<strong>\\\"\\u0110\\u1eebng kinh doanh khi b\\u1ea1n ch\\u01b0a c\\u00f3 t\\u00ean mi\\u1ec1n!\\\"<\\/strong>\\r\\n - \\u0110\\u00f3 l\\u00e0 c\\u00e2u qu\\u1ea3ng c\\u00e1o c\\u1ee7a c\\u00e1c nh\\u00e0 \\u0111\\u0103ng k\\u00fd t\\u00ean mi\\u1ec1n.\\r\\n<br>\\r\\nC\\u00f2n ch\\u00fang t\\u00f4i th\\u00ec th\\u1ea5y r\\u1eb1ng:  <strong>\\u0110\\u00e3 kinh doanh th\\u00ec n\\u00ean t\\u1ea1o m\\u1ed9t website.<\\/strong>\\r\\n<br>\\r\\nH\\u00e3y b\\u1eaft \\u0111\\u1ea7u v\\u1edbi vi\\u1ec7c l\\u00ean \\u00fd t\\u01b0\\u1edfng v\\u00e0o t\\u1ea1o cho m\\u00ecnh m\\u1ed9t trang web ngay h\\u00f4m nay!\",\"show_quote\":null,\"image\":\"5ee90472bae39.png\",\"light_title\":\"WEB102\",\"show_author\":null,\"author_name\":null,\"author_job\":null,\"author_link\":null}'),
(46, 62, 35, 3, '{\"title\":\"D\\u1ecbch v\\u1ee5\",\"description\":\"Ch\\u00fang t\\u00f4i lu\\u00f4n c\\u1ed1 g\\u1eafng mang \\u0111\\u1ebfn cho b\\u1ea1n nh\\u1eefng d\\u1ecbch v\\u1ee5 t\\u1ed1t nh\\u1ea5t tr\\u00ean chi ph\\u00ed m\\u00e0 b\\u1ea1n ph\\u1ea3i b\\u1ecf ra!\",\"dynamic_id\":\"2\",\"link\":null}'),
(47, 78, 35, 4, '{\"title\":\"Ph\\u1ea3n h\\u1ed3i t\\u1eeb kh\\u00e1ch h\\u00e0ng\",\"background\":\"5ee906134e6c0.jpg\",\"list_type\":\"custom\",\"item_number\":\"0\",\"sort_type\":\"id-ASC\"}'),
(50, 83, 35, 7, '{\"title\":\"\\u0110\\u1ed9i ng\\u0169\",\"description\":\"C\\u00e1c th\\u00e0nh vi\\u00ean trong nh\\u00f3m ph\\u00e1t tri\\u1ec3n\",\"list_type\":\"custom\",\"team_id\":null,\"item_number\":\"4\",\"sort_type\":\"id-ASC\",\"bg_default_color\":\"theme-small\",\"bg_color\":null,\"bg_image\":\"5ee907615967d.jpg\",\"bg_position\":\"fixed\",\"bg_half\":\"on\",\"advance\":null,\"class_name\":null}'),
(51, 73, 35, 8, '{\"title\":\"Li\\u00ean h\\u1ec7 ch\\u00fang t\\u00f4i\",\"button_text\":\"G\\u1eedi li\\u00ean h\\u1ec7\"}'),
(52, 74, 35, 9, '{\"title\":\"Blog\",\"description\":null,\"dynamic_id\":\"3\",\"category_id\":\"0\",\"group_by_category\":null,\"sorttype\":\"1\",\"post_number\":\"3\",\"link\":null,\"bg_default_color\":null,\"bg_color\":null,\"bg_image\":\"\",\"bg_position\":null,\"bg_half\":null,\"advance\":null,\"class_name\":null}'),
(53, 63, 48, 1, '{\"title\":\"Trang tin t\\u1ee9c\",\"description\":\"G\\u00f3i d\\u1ecbch v\\u1ee5 chuy\\u00ean bi\\u1ec7t qu\\u1ea3n l\\u00fd trang tin t\\u1ee9c, crawl d\\u1eef li\\u1ec7u t\\u1ed5ng h\\u1ee3p\",\"url\":\"\\/dich-vu\\/goi-tin-tuc.html\",\"img_icon\":\"5ee90831eba76.png\",\"col_sm\":\"6\",\"col_lg\":\"4\"}'),
(55, 63, 48, 6, '{\"title\":\"Blog 1-0-2\",\"description\":\"D\\u1ecbch v\\u1ee5 t\\u1ea1o trang blog cho nh\\u1eefng ai th\\u00edch vi\\u1ebft l\\u00e1ch ho\\u1eb7c kh\\u1eb3ng \\u0111\\u1ecbnh c\\u00e1i t\\u00f4i\",\"url\":\"\\/dich-vu\\/goi-blog.html\",\"img_icon\":\"5ee90992a2f8d.png\",\"col_sm\":\"6\",\"col_lg\":\"4\"}'),
(56, 63, 48, 2, '{\"title\":\"Website b\\u00e1n h\\u00e0ng\",\"description\":\"D\\u1ecbch v\\u1ee5 t\\u1ea1o web b\\u00e1n h\\u00e0ng th\\u00e2n thi\\u1ec7n ti\\u1ebft ki\\u1ec7m chi ph\\u00ed, qu\\u1ea3n l\\u00fd d\\u1ec5 d\\u00e0ng\",\"url\":\"\\/dich-vu\\/goi-thuong-mai-dien-tu.html\",\"img_icon\":\"5ee90a213e6db.jpg\",\"col_sm\":\"6\",\"col_lg\":\"4\"}'),
(57, 63, 48, 3, '{\"title\":\"Website doanh nghi\\u1ec7p\",\"description\":\"G\\u00f3i d\\u1ecbch v\\u1ee5 t\\u1ea1o website gi\\u1edbi thi\\u1ec7u doanh nghi\\u1ec7p \\u0111\\u1ec3 marketing hi\\u1ec7u qu\\u1ea3\",\"url\":\"\\/dich-vu\\/goi-business.html\",\"img_icon\":\"5ee90a71f084c.jpg\",\"col_sm\":\"6\",\"col_lg\":\"4\"}'),
(58, 63, 48, 5, '{\"title\":\"Trang c\\u00e1 nh\\u00e2n\",\"description\":\"D\\u1ecbch v\\u1ee5 t\\u1ea1o trang h\\u1ed3 s\\u01a1 c\\u00e1 nh\\u00e2n, gi\\u1edbi thi\\u1ec7u b\\u1ea3n th\\u00e2n kinh nghi\\u1ec7m l\\u00e0m vi\\u1ec7c, CV online\",\"url\":\"\\/dich-vu\\/goi-trang-ca-nhan.html\",\"img_icon\":\"5ee90ac59095f.png\",\"col_sm\":\"6\",\"col_lg\":\"4\"}'),
(59, 79, 49, 1, '{\"name\":\"Hi\\u1ec1n Tr\\u01b0\\u01a1ng\",\"image\":\"5ee90bc25787d.jpg\",\"job\":\"Ch\\u1ee7 shop luxurysell.vn\",\"link\":null,\"content\":\"Thi\\u1ebft k\\u1ebf \\u0111\\u1eb9p, nhanh ch\\u00f3ng. Gi\\u00e1 c\\u1ea3 h\\u1ee3p l\\u00fd. N\\u00f3i chung t\\u00f4i r\\u1ea5t h\\u00e0i l\\u00f2ng\"}'),
(60, 84, 50, 1, '{\"name\":\"L\\u00ea Ng\\u1ecdc Do\\u00e3n\",\"avatar\":\"5ee90c2653cef.jpg\",\"job\":\"DEV\",\"description\":null,\"is_loader\":\"on\",\"facebook\":\"https:\\/\\/www.facebook.com\\/LeNgocDoan\",\"twitter\":\"https:\\/\\/twitter.com\\/NgocDoanLe\",\"youtube\":\"https:\\/\\/www.youtube.com\\/channel\\/UCIPikHMH4Br5xRWW_YIOOTw\",\"instagram\":null,\"linkedin\":null,\"pinterest\":null}'),
(61, 84, 50, 2, '{\"name\":\"Kh\\u00e1nh Linh\",\"avatar\":\"5ee90c92e9815.png\",\"job\":\"Designer\",\"description\":null,\"is_loader\":null,\"facebook\":\"https:\\/\\/www.facebook.com\\/lamlinhdesign\",\"twitter\":\"#\",\"youtube\":null,\"instagram\":null,\"linkedin\":null,\"pinterest\":null}'),
(62, 84, 50, 3, '{\"name\":\"V\\u0169 Minh Hi\\u1ebfu\",\"avatar\":\"5ee90cc5a6d30.jpg\",\"job\":\"DEV\",\"description\":null,\"is_loader\":null,\"facebook\":\"https:\\/\\/www.facebook.com\\/Minh.Hieu2610\",\"twitter\":null,\"youtube\":null,\"instagram\":null,\"linkedin\":null,\"pinterest\":null}'),
(63, 84, 50, 4, '{\"name\":\"Thi\\u00ean V\\u0169\",\"avatar\":\"5ee90d39326f4.jpg\",\"job\":\"Designer\",\"description\":null,\"is_loader\":null,\"facebook\":\"https:\\/\\/www.facebook.com\\/phamlananhvnn\",\"twitter\":null,\"youtube\":null,\"instagram\":null,\"linkedin\":null,\"pinterest\":null}'),
(64, 77, 47, 1, '{\"title\":\"Thi\\u1ebft l\\u1eadp t\\u00e0i li\\u1ec7u\",\"dynamic_id\":\"4\",\"dynamic_type\":\"documentation\",\"mobile_menu_id\":\"4\",\"sidebar_menu_id\":\"10\",\"header_style\":\"3\",\"show_breadcrumb\":\"on\",\"list_layout\":\"sidebar\",\"list_type\":\"grid\",\"header_bg_default_color\":null,\"header_bg_color\":null,\"header_use_bg_image\":null,\"header_bg_image\":\"\",\"header_bg_position\":null,\"header_class_name\":null,\"detail_use_feature_image\":null,\"detail_hide_feature_image\":null,\"detail_hide_related\":null,\"detail_hide_comments\":null}'),
(65, 67, 38, 1, '{\"title\":\"Danh m\\u1ee5c\",\"get_by_dynamic_active\":\"on\",\"dynamic_id\":null,\"parent_id\":\"0\",\"sorttype\":\"1\",\"cate_number\":\"10\"}'),
(66, 65, 38, 2, '{\"title\":\"M\\u1edbi nh\\u1ea5t\",\"dynamic_id\":null,\"category_id\":\"0\",\"content_type\":null,\"sorttype\":\"1\",\"post_number\":\"5\"}'),
(67, 69, 38, 3, '{\"title\":\"B\\u00ecnh lu\\u1eadn m\\u1edbi nh\\u1ea5t\",\"number_comment\":\"5\",\"ref\":null}'),
(68, 68, 38, 4, '{\"title\":\"Th\\u1ebb\",\"sorttype\":\"1\",\"tag_number\":\"10\"}'),
(69, 66, 39, 1, '{\"title\":\"Danh m\\u1ee5c\",\"parent_id\":\"0\",\"sorttype\":\"1\",\"cate_number\":\"10\"}'),
(70, 64, 39, 2, '{\"title\":\"C\\u00e1c d\\u1ef1 \\u00e1n\",\"category_id\":\"0\",\"sorttype\":\"1\",\"project_number\":\"5\"}'),
(71, 67, 40, 1, '{\"title\":null,\"get_by_dynamic_active\":null,\"dynamic_id\":null,\"parent_id\":\"0\",\"sorttype\":\"1\",\"cate_number\":\"5\"}'),
(72, 65, 40, 2, '{\"title\":\"M\\u1edbi nh\\u1ea5t\",\"dynamic_id\":null,\"category_id\":\"0\",\"content_type\":null,\"sorttype\":\"1\",\"post_number\":\"5\"}'),
(73, 68, 40, 3, '{\"title\":\"Th\\u1ebb\",\"sorttype\":\"1\",\"tag_number\":\"10\"}'),
(74, 77, 47, 2, '{\"title\":\"Thi\\u1ebft l\\u1eadp d\\u1ecbch v\\u1ee5\",\"dynamic_id\":\"2\",\"dynamic_type\":\"post\",\"mobile_menu_id\":\"4\",\"sidebar_menu_id\":\"4\",\"header_style\":\"2\",\"show_breadcrumb\":\"on\",\"list_layout\":\"sidebar\",\"list_type\":\"grid\",\"header_bg_default_color\":null,\"header_bg_color\":null,\"header_use_bg_image\":\"on\",\"header_bg_image\":\"5ee9e1cb60442.jpg\",\"header_bg_position\":\"cover\",\"header_class_name\":null,\"detail_use_feature_image\":\"on\",\"detail_hide_feature_image\":\"on\",\"detail_hide_related\":null,\"detail_hide_comments\":null,\"detail_hide_meta\":\"on\"}'),
(75, 94, 51, 1, '{\"Hotline\":null,\"call_text\":null}'),
(79, 77, 47, 3, '{\"title\":\"M\\u1ee5c Giao di\\u1ec7n\",\"dynamic_id\":\"5\",\"dynamic_type\":\"documentation\",\"mobile_menu_id\":\"11\",\"sidebar_menu_id\":\"11\",\"header_style\":\"3\",\"show_breadcrumb\":null,\"list_layout\":\"sidebar\",\"list_type\":\"grid\",\"header_bg_default_color\":\"theme\",\"header_bg_color\":null,\"header_use_bg_image\":null,\"header_bg_image\":\"\",\"header_bg_position\":null,\"header_class_name\":null,\"detail_use_feature_image\":null,\"detail_hide_feature_image\":null,\"detail_hide_meta\":null,\"detail_hide_related\":null,\"detail_hide_comments\":null}'),
(80, 63, 48, 4, '{\"title\":\"WordPress\",\"description\":\"t\\u1ea1o website WordPress \\u0111\\u01a1n gi\\u1ea3n trong 3 b\\u01b0\\u1edbc ch\\u1ec9 c\\u00f3 tr\\u00ean Web 1-0-2 (web102 .vcc.vn)\",\"url\":\"https:\\/\\/web102.vcc.vn\\/services\\/add?service_id=7\",\"img_icon\":\"5f71b4bfe6167.svg\",\"col_sm\":\"6\",\"col_lg\":\"4\"}'),
(81, 95, 35, 0, '{\"title\":\"B\\u1ea1n c\\u1ea7n t\\u1ea1o website?\",\"description\":\"H\\u00e3y ch\\u1ecdn m\\u1ed9t g\\u00f3i d\\u1ecbch v\\u1ee5 v\\u00e0 t\\u00ean mi\\u1ec1n b\\u1ea1n th\\u00edch nh\\u1ea5t.\",\"comment\":\"D\\u1ecbch v\\u1ee5 t\\u1ea1o website mi\\u1ec5n ph\\u00ed h\\u00e0ng \\u0111\\u1ea7u Vi\\u1ec7t Nam\\r\\n<br \\/><br \\/>\\r\\nM\\u1ed9t s\\u1ea3n ph\\u1ea9m c\\u1ee7a VCC Team\\r\\n<br \\/><br \\/>\\r\\nWebsite: https:\\/\\/vcc.vn\\r\\n<br \\/><br \\/>\",\"create_button\":\"Kh\\u1edfi t\\u1ea1o\",\"slider_id\":\"1\",\"btn_text\":\"Chi ti\\u1ebft\",\"address\":\"72 ngo 102, Truong Chinh, Dong Da\",\"phone_number\":\"0945786960\",\"email\":\"doanln16@gmail.com\"}');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `html_embeds`
--

CREATE TABLE `html_embeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `html_embeds`
--

INSERT INTO `html_embeds` (`id`, `area_id`, `label`, `slug`, `code`, `priority`, `status`) VALUES
(2, 1, 'css', 'css', '<style>.theme_doc_item img{max-width:52px;}</style>', 2, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'Menu',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `ref_id` bigint(20) DEFAULT 0,
  `priority` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_main` tinyint(1) DEFAULT 0,
  `positions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `depth` int(10) UNSIGNED DEFAULT 4
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `menus`
--

INSERT INTO `menus` (`id`, `name`, `slug`, `type`, `ref_id`, `priority`, `is_main`, `positions`, `depth`) VALUES
(4, 'Menu Chính', 'menu-chinh', 'default', 0, 1, 0, ' primary,', 3),
(5, 'Dịch vụ', 'dich-vu', 'default', 2, 4, 0, ' custom,', 1),
(7, 'Extra', 'extra', 'default', 2, 6, 0, ' custom,', 4),
(8, 'Liên kết hữu ích', 'lien-ket-huu-ich', 'default', 2, 4, 0, NULL, 4),
(9, 'Liên hệ', 'lien-he', 'default', 2, 5, 0, NULL, 4),
(10, 'Menu Tài liệu', 'menu-tai-lieu', 'default', 2, 6, 0, ' docsleft,', 4),
(11, 'Menu mục giao diện', 'menu-muc-giao-dien', 'default', 2, 7, 0, NULL, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT 0,
  `priority` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` bigint(20) UNSIGNED DEFAULT 0,
  `sub_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `props` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `parent_id`, `priority`, `type`, `ref`, `ref_id`, `sub_type`, `props`) VALUES
(22, 5, 0, 0, 'url', NULL, 0, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"Thi\\u1ebft k\\u1ebf website\",\"url\":\"#service\",\"target\":\"none\",\"show_submenu\":\"show\"}'),
(23, 5, 0, 0, 'url', NULL, 0, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"SEO\",\"url\":\"#service\",\"target\":\"none\",\"show_submenu\":\"show\"}'),
(24, 5, 0, 0, 'url', NULL, 0, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"Thi\\u1ebft k\\u1ebf logo\",\"url\":\"#team\",\"target\":\"none\",\"show_submenu\":\"show\"}'),
(25, 5, 0, 0, 'url', NULL, 0, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"Hosting\",\"url\":\"\\/\",\"target\":\"none\",\"show_submenu\":\"show\"}'),
(26, 4, 0, 1, 'page', 'page', 10, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"page_id\":\"10\",\"target\":\"none\",\"show_submenu\":\"show\",\"text\":\"Gi\\u1edbi thi\\u1ec7u\"}'),
(40, 7, 0, 0, 'url', NULL, 0, 'default', '{\"link_class\":null,\"active_key\":null,\"text\":null,\"url\":\"#\",\"target\":\"none\",\"show_submenu\":\"show\",\"icon\":\"fa fa-search\",\"class\":\"search\"}'),
(41, 7, 0, 0, 'route', NULL, 0, 'default', '{\"icon\":null,\"link_class\":null,\"active_key\":null,\"text\":\"T\\u1ea1o website\",\"route\":\"client.services.add\",\"target\":\"none\",\"show_submenu\":\"show\",\"class\":\"quote-btn\"}'),
(42, 8, 0, 0, 'route', NULL, 0, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"Trang ch\\u1ee7\",\"route\":\"home\",\"target\":\"none\",\"show_submenu\":\"show\"}'),
(43, 8, 0, 0, 'url', NULL, 0, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"Xiaomiworld.vn\",\"url\":\"https:\\/\\/xiaomiworld.vn\\/\",\"target\":\"_blank\",\"show_submenu\":\"show\"}'),
(44, 8, 0, 0, 'url', NULL, 0, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"Moon Dental Studio\",\"url\":\"http:\\/\\/moondental.vn\\/\",\"target\":\"_blank\",\"show_submenu\":\"show\"}'),
(45, 9, 0, 0, 'url', NULL, 0, 'default', '{\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"0945786960\",\"url\":\"tel:+84945786960\",\"target\":\"_blank\",\"show_submenu\":\"show\",\"icon\":\"fa fa-phone\"}'),
(46, 9, 0, 0, 'url', NULL, 0, 'default', '{\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"doanln16@gmail.com\",\"url\":\"mailto:doanln16@gmail.com\",\"target\":\"none\",\"show_submenu\":\"show\",\"icon\":\"fa fa-envelope\"}'),
(47, 9, 0, 0, 'url', NULL, 0, 'default', '{\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"fb.me\\/LeNgocDoan\",\"url\":\"https:\\/\\/www.facebook.com?LeNgocDoan\",\"target\":\"_blank\",\"show_submenu\":\"show\",\"icon\":\"fab fa-facebook\"}'),
(48, 9, 0, 0, 'url', NULL, 0, 'default', '{\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"172 B\\u00e0 Tri\\u1ec7u, Tp. H\\u00f2a B\\u00ecnh\",\"url\":\"#\",\"target\":\"none\",\"show_submenu\":\"show\",\"icon\":\"fa fa-map-marker\"}'),
(57, 10, 0, 1, 'post_category', 'post_category', 10, 'default', '{\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"Gi\\u1edbi thi\\u1ec7u\",\"post_category_id\":\"10\",\"target\":\"none\",\"show_submenu\":\"show\",\"icon\":\"fa fa-hashtag\",\"dynamic_id\":4}'),
(60, 10, 57, 1, 'post', 'post', 22, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"post_id\":\"22\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":4,\"text\":\"M\\u1edf \\u0111\\u1ea7u\"}'),
(61, 4, 0, 6, 'route', NULL, 0, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"T\\u00e0i kho\\u1ea3n\",\"route\":\"client.account\",\"target\":\"none\",\"show_submenu\":\"show\"}'),
(64, 10, 57, 2, 'post', 'post', 24, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"post_id\":\"24\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":4,\"text\":\"\\u0110\\u0103ng k\\u00fd website\"}'),
(65, 10, 0, 2, 'post_category', 'post_category', 11, 'default', '{\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"CMS\",\"post_category_id\":\"11\",\"target\":\"none\",\"show_submenu\":\"show\",\"icon\":\"fab fa-laravel\",\"dynamic_id\":4}'),
(66, 10, 65, 1, 'post', 'post', 25, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"post_id\":\"25\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":4,\"text\":\"C\\u00e0i \\u0111\\u1eb7t\"}'),
(67, 10, 65, 2, 'post', 'post', 27, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"post_id\":\"27\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":4,\"text\":\"Kh\\u1edfi ch\\u1ea1y\"}'),
(68, 10, 65, 3, 'post', 'post', 28, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"C\\u1ea5u tr\\u00fac th\\u01b0 m\\u1ee5c\",\"post_id\":\"28\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":4}'),
(69, 10, 65, 4, 'post', 'post', 29, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"post_id\":\"29\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":4,\"text\":\"Life Cycle\"}'),
(70, 4, 0, 2, 'dynamic', 'dynamic', 2, 'custom', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"D\\u1ecbch v\\u1ee5\",\"dynamic_id\":\"2\",\"target\":\"none\",\"show_submenu\":\"show\"}'),
(71, 4, 70, 7, 'post', 'post', 12, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"G\\u00f3i Ti\\u00eau Chu\\u1ea9n\",\"post_id\":\"12\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":2}'),
(72, 4, 70, 5, 'post', 'post', 13, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"Trang Blog\",\"post_id\":\"13\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":2}'),
(73, 4, 70, 4, 'post', 'post', 14, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"Trang C\\u00e1 nh\\u00e2n\",\"post_id\":\"14\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":2}'),
(74, 4, 70, 3, 'post', 'post', 15, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"Website Doanh Nghi\\u1ec7p\",\"post_id\":\"15\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":2}'),
(75, 4, 70, 2, 'post', 'post', 16, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"Trang Tin T\\u1ee9c\",\"post_id\":\"16\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":2}'),
(76, 4, 70, 1, 'post', 'post', 17, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"text\":\"Trang B\\u00e1n H\\u00e0ng\",\"post_id\":\"17\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":2}'),
(77, 4, 0, 3, 'dynamic', 'dynamic', 4, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"dynamic_id\":\"4\",\"target\":\"none\",\"show_submenu\":\"show\",\"text\":\"T\\u00e0i li\\u1ec7u\"}'),
(78, 4, 0, 5, 'dynamic', 'dynamic', 3, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"dynamic_id\":\"3\",\"target\":\"none\",\"show_submenu\":\"show\",\"text\":\"Blog\"}'),
(79, 10, 65, 5, 'post', 'post', 30, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"post_id\":\"30\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":4,\"text\":\"Controller\"}'),
(81, 4, 0, 4, 'dynamic', 'dynamic', 5, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"dynamic_id\":\"5\",\"target\":\"none\",\"show_submenu\":\"show\",\"text\":\"Giao di\\u1ec7n\"}'),
(82, 11, 0, 0, 'post', 'post', 31, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"post_id\":\"31\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":5,\"text\":\"Gi\\u1edbi thi\\u1ec7u\"}'),
(83, 11, 0, 0, 'post_category', 'post_category', 12, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"post_category_id\":\"12\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":5,\"text\":\"Giao di\\u1ec7n 1-0-2\"}'),
(84, 11, 0, 0, 'post_category', 'post_category', 14, 'default', '{\"icon\":null,\"class\":null,\"active_key\":null,\"post_category_id\":\"14\",\"target\":\"none\",\"link_class\":\"faxebook\",\"show_submenu\":\"show\",\"dynamic_id\":5,\"text\":\"Trang C\\u00e1 Nh\\u00e2n\"}'),
(85, 11, 0, 0, 'post_category', 'post_category', 15, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"post_category_id\":\"15\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":5,\"text\":\"Web C\\u00f4ng Ty\"}'),
(86, 11, 0, 0, 'post_category', 'post_category', 16, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"post_category_id\":\"16\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":5,\"text\":\"Trang Tin T\\u1ee9c\"}'),
(87, 11, 0, 0, 'post_category', 'post_category', 17, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"post_category_id\":\"17\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":5,\"text\":\"Trang B\\u00e1n H\\u00e0ng\"}'),
(88, 4, 70, 6, 'post', 'post', 33, 'default', '{\"icon\":null,\"class\":null,\"link_class\":null,\"active_key\":null,\"post_id\":\"33\",\"target\":\"none\",\"show_submenu\":\"show\",\"dynamic_id\":2,\"text\":\"WordPress 1-0-2\"}');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `metadatas`
--

CREATE TABLE `metadatas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'data',
  `ref_id` bigint(20) UNSIGNED DEFAULT 0,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'name',
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `metadatas`
--

INSERT INTO `metadatas` (`id`, `ref`, `ref_id`, `name`, `value`) VALUES
(1, 'theme', 1, 'components', '[{\"path\":\"block-ads-wide\",\"name\":\"Banner qu\\u1ea3ng c\\u00e1o (1248 x 130)\",\"inputs\":{\"banner\":{\"type\":\"file\",\"label\":\"Banner\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"text\":{\"type\":\"text\",\"label\":\"Text\"},\"type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i qu\\u1ea3ng c\\u00e1o\",\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"},\"code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 qu\\u1ea3ng c\\u00e1o\"}}},{\"path\":\"footer-column-about\",\"name\":\"Footer Column: Gi\\u1edbi thi\\u1ec7u\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"Gi\\u1edbi thi\\u1ec7u\"},\"about_content\":{\"type\":\"textarea\",\"label\":\"N\\u1ed9i dung\",\"className\":\"auto-height\"},\"show_logo\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb logo\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"show_text_logo\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb text logo\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"text_logo_primary\":{\"type\":\"text\",\"label\":\"Text Logo (ch\\u00ednh)\",\"value\":\"Tin T\\u1ee9c\"},\"text_logo_second\":{\"type\":\"text\",\"Label\":\"Text Logo (b\\u1ed5 xung)\",\"value\":\"24\\/7\"},\"highlight\":{\"type\":\"select\",\"label\":\"l\\u00e0m n\\u1ed5i b\\u1eadt\",\"data\":{\"none\":\"Kh\\u00f4ng\",\"primary\":\"Text ch\\u00ednh\",\"second\":\"Text ph\\u1ee5\",\"both\":\"T\\u1ea5t c\\u1ea3\"},\"default\":\"second\"},\"text_logo_slogan\":{\"type\":\"text\",\"Label\":\"Kh\\u1ea9u hi\\u1ec7u\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"}}},{\"path\":\"footer-column-posts\",\"name\":\"Footer Column: tin b\\u00e0i\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 \"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":4}}},{\"path\":\"footer-column-tags\",\"name\":\"Footer Column: Th\\u1ebb b\\u00e0i vi\\u1ebft (tags)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 \"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_tag_sortby_options\"},\"tag_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":4}}},{\"path\":\"grid-first-large-thumbail\",\"name\":\"Home: L\\u01b0\\u1edbi v\\u1edbi tin \\u0111\\u1ea7u l\\u00e0m n\\u1ed5i b\\u1eadt\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1\",\"call\":\"get_number_options\",\"params\":[1,12]},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":4}}},{\"path\":\"home-ads-wide\",\"name\":\"Home: Banner qu\\u1ea3ng c\\u00e1o (820 x 130)\",\"inputs\":{\"banner\":{\"type\":\"file\",\"label\":\"Banner\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"text\":{\"type\":\"text\",\"label\":\"Text\"},\"type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i qu\\u1ea3ng c\\u00e1o\",\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"},\"code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 qu\\u1ea3ng c\\u00e1o\"}}},{\"path\":\"home-bottom-ads\",\"name\":\"Home: Banner qu\\u1ea3ng c\\u00e1o (1240 x 130)\",\"inputs\":{\"banner\":{\"type\":\"file\",\"label\":\"Banner\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"text\":{\"type\":\"text\",\"label\":\"Text\"},\"type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i qu\\u1ea3ng c\\u00e1o\",\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"},\"code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 qu\\u1ea3ng c\\u00e1o\"}}},{\"path\":\"home-breaking-and-slider\",\"name\":\"Breaking news & Slider\",\"inputs\":{\"slider_sort_type\":{\"type\":\"crazyselect\",\"label\":\"Ki\\u1ec3u s\\u1eafp x\\u1ebfp tin trong ph\\u1ea7n slider news\",\"call\":\"get_post_sortby_options\",\"default\":1},\"slider_number_post\":{\"type\":\"crazyswlect\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng tin trong ph\\u1ea7n slider news\",\"data\":{\"4\":\"4 Tin (1 slider)\",\"8\":\"8 Tin (2 slider)\",\"12\":\"12 Tin (3 slider)\",\"16\":\"16 Tin (4 slider)\",\"20\":\"20 Tin (5 slider)\"},\"default\":16}}},{\"path\":\"home-carouse\",\"name\":\"Home: Tin b\\u00e0i d\\u1ea1ng slider (Carousel)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}},{\"path\":\"home-grid-list\",\"name\":\"Home: Danh s\\u00e1ch d\\u1ea1ng l\\u01b0\\u1edbi\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1\",\"call\":\"get_number_options\",\"params\":[1,12]},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":4}}},{\"path\":\"home-grid-sidebar-style-2\",\"name\":\"Home: L\\u01b0\\u1edbi & sidebar (style 2)\",\"inputs\":{\"first_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 1 (T\\u00f9y ch\\u1ecdn)\"},\"first_sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"first_bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 1\",\"call\":\"get_number_options\",\"params\":[1,12]},\"first_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"K\\u00eanh \\u0111\\u0103ng b\\u00e0i c\\u1ee7a m\\u1ee5c 1 (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"first_category_id\",\"required\":\"true\"},\"first_category_id\":{\"type\":\"crazyselect\",\"label\":\"Ch\\u1ee7 \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 1\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#first_dynamic_id\"},true],\"@label-type\":\"value\"},\"first_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp c\\u1ee7a m\\u1ee5c 1 \",\"call\":\"get_post_sortby_options\"},\"second_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 2 (T\\u00f9y ch\\u1ecdn)\"},\"second_sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"second_bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 2\",\"call\":\"get_number_options\",\"params\":[1,12]},\"second_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"K\\u00eanh \\u0111\\u0103ng b\\u00e0i c\\u1ee7a m\\u1ee5c 2 (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"second_category_id\",\"required\":\"true\"},\"second_category_id\":{\"type\":\"crazyselect\",\"label\":\"Ch\\u1ee7 \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 2\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#second_dynamic_id\"},true],\"@label-type\":\"value\"},\"second_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp c\\u1ee7a m\\u1ee5c 2 \",\"call\":\"get_post_sortby_options\"}}},{\"path\":\"home-grid-sidebar\",\"name\":\"Home: L\\u01b0\\u1edbi 2 m\\u1ee5c & sidebar\",\"inputs\":{\"first_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 1 (T\\u00f9y ch\\u1ecdn)\"},\"first_sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"first_bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 1\",\"call\":\"get_number_options\",\"params\":[1,12]},\"first_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"K\\u00eanh \\u0111\\u0103ng b\\u00e0i c\\u1ee7a m\\u1ee5c 1 (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"first_category_id\",\"required\":\"true\"},\"first_category_id\":{\"type\":\"crazyselect\",\"label\":\"Ch\\u1ee7 \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 1\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#first_dynamic_id\"},true],\"@label-type\":\"value\"},\"first_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp c\\u1ee7a m\\u1ee5c 1 \",\"call\":\"get_post_sortby_options\"},\"second_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 2 (T\\u00f9y ch\\u1ecdn)\"},\"second_sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"second_bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 2\",\"call\":\"get_number_options\",\"params\":[1,12]},\"second_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"K\\u00eanh \\u0111\\u0103ng b\\u00e0i c\\u1ee7a m\\u1ee5c 2 (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"second_category_id\",\"required\":\"true\"},\"second_category_id\":{\"type\":\"crazyselect\",\"label\":\"Ch\\u1ee7 \\u0111\\u1ec1 c\\u1ee7a m\\u1ee5c 2\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#second_dynamic_id\"},true],\"@label-type\":\"value\"},\"second_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp c\\u1ee7a m\\u1ee5c 2 \",\"call\":\"get_post_sortby_options\"},\"sidebar_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a sidebar (T\\u00f9y ch\\u1ecdn)\"},\"sidebar_link\":{\"type\":\"text\",\"label\":\"Url (T\\u00f9y ch\\u1ecdn)\"},\"sidebar_bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1 c\\u1ee7a sidebar\",\"call\":\"get_number_options\",\"params\":[1,12]},\"sidebar_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"K\\u00eanh \\u0111\\u0103ng b\\u00e0i c\\u1ee7a sidebar (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"sidebar_category_id\",\"required\":\"true\"},\"sidebar_category_id\":{\"type\":\"crazyselect\",\"label\":\"Ch\\u1ee7 \\u0111\\u1ec1 c\\u1ee7a sidebar\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#sidebar_dynamic_id\"},true],\"@label-type\":\"value\"},\"sidebar_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp c\\u1ee7a sidebar \",\"call\":\"get_post_sortby_options\"},\"sidebar_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}},{\"path\":\"home-intro\",\"name\":\"Home: Intro (Gi\\u1edbi thi\\u1ec7u)\",\"inputs\":{\"image\":{\"type\":\"file\",\"label\":\"\\u1ea2nh\"},\"text\":{\"type\":\"textarea\",\"label\":\"Text\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"button_text\":{\"type\":\"text\",\"label\":\"Button Text\"}},\"data\":{\"button_text\":\"Xem th\\u00eam\"}},{\"path\":\"home-list-sidebar-2\",\"name\":\"Home: Danh s\\u00e1ch & sidebar style 2\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1\",\"call\":\"get_number_options\",\"params\":[1,12]},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":5},\"sidebar_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 sidebar (T\\u00f9y ch\\u1ecdn)\"},\"sidebar_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c \\u1edf sidebar (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"data-ref\":\"sidebar_category_id\",\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"sidebar_category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c \\u1edf sidebar\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#sidebar_dynamic_id\"},true],\"@label-type\":\"value\"},\"sidebar_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp \\u1edf sidebar\",\"call\":\"get_post_sortby_options\"},\"sidebar_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i \\u1edf sidebar\",\"min\":1,\"step\":1,\"default\":10},\"show_news_video\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb video m\\u1edbi nh\\u1ea5t\"}},\"data\":{\"sidebar_title\":\"Tin m\\u1edbi nh\\u1ea5t\"}},{\"path\":\"home-list-sidebar\",\"name\":\"Home: Danh s\\u00e1ch & sidebar\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1\",\"call\":\"get_number_options\",\"params\":[1,12,\"default\",\"default\"]},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":5},\"sidebar_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 sidebar (T\\u00f9y ch\\u1ecdn)\"},\"sidebar_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i \\u1edf sidebar\",\"min\":1,\"step\":1,\"default\":10},\"sidebar_banner\":{\"type\":\"file\",\"label\":\"Sidebar Banner\"},\"sidebar_link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"ads_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i qu\\u1ea3ng c\\u00e1o\",\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"},\"ads_code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 qu\\u1ea3ng c\\u00e1o\"}},\"data\":{\"sidebar_title\":\"Tin m\\u1edbi nh\\u1ea5t\"}},{\"path\":\"home-list-with-children-category\",\"name\":\"Home: Danh s\\u00e1ch & Menu danh m\\u1ee5c\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"bg_style\":{\"type\":\"crazyselect\",\"label\":\"N\\u1ec1n ti\\u00eau \\u0111\\u1ec1\",\"call\":\"get_number_options\",\"params\":[1,12]},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"children_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 danh m\\u1ee5c con\",\"min\":1,\"step\":1,\"default\":15},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":5},\"menu_type\":{\"type\":\"crazyselect\",\"label\":\"Ki\\u1ec3u menu\",\"data\":{\"children\":\"Danh m\\u1ee5c con\",\"menu\":\"Menu\"},\"default\":\"children\"},\"menu_id\":{\"type\":\"crazyselect\",\"label\":\"Menu\",\"call\":\"get_menu_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"]},\"sidebar_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 sidebar (T\\u00f9y ch\\u1ecdn)\"},\"sidebar_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i \\u1edf sidebar\",\"min\":1,\"step\":1,\"default\":10}},\"data\":{\"sidebar_title\":\"Tin m\\u1edbi nh\\u1ea5t\"}},{\"path\":\"home-parallax\",\"name\":\"Home: Gi\\u00f3i thi\\u1ec7u (H\\u00ecnh n\\u1ec1n v\\u00e0 text)\",\"inputs\":{\"background\":{\"type\":\"file\",\"label\":\"\\u1ea2nh\"},\"medium_caption\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 tr\\u00ean (T\\u00f9y ch\\u1ecdn)\"},\"large_caption\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ch\\u00ednh\"},\"second_caption\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\"}}},{\"path\":\"home-post-gallery\",\"name\":\"Home: Tin b\\u00e0i d\\u1ea1ng slider (Carousel Gallery)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft trong ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"text\":{\"type\":\"text\",\"label\":\"Text c\\u1ee7a li\\u00ean k\\u1ebft trong ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"mark_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 b\\u00f4i m\\u00e0u (T\\u00f9y ch\\u1ecdn)\"},\"gallery_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 gallery (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}},{\"path\":\"home-quote\",\"name\":\"Home: Quote - tr\\u00ednh d\\u1eabn\",\"inputs\":{\"label\":{\"type\":\"text\",\"label\":\"Nh\\u00e3n (T\\u00f9y ch\\u1ecdn)\"},\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"description\":{\"type\":\"text\",\"label\":\"M\\u00f4 t\\u1ea3 ()\"},\"image\":{\"type\":\"file\",\"label\":\"\\u1ea2nh\"},\"button_text\":{\"type\":\"text\",\"label\":\"Button Text\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"}},\"data\":{\"button_text\":\"Xem th\\u00eam\"}},{\"path\":\"home-videos\",\"name\":\"Home: Video\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 sidebar\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":3}}},{\"path\":\"parallax\",\"name\":\"Home: Parallax\",\"inputs\":{\"sub_title_before\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 nh\\u1ecf (t\\u00f9y ch\\u1ecdn)\"},\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ch\\u00ednh\"},\"sub_title_after\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (t\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"},\"background\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"}}},{\"path\":\"posts-carousel\",\"name\":\"Tin b\\u00e0i d\\u1ea1ng slider (Carousel)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}},{\"path\":\"sidebar-ads\",\"name\":\"Sidebar: Banner qu\\u1ea3ng c\\u00e1o (400 x __)\",\"inputs\":{\"banner\":{\"type\":\"file\",\"label\":\"Banner\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"text\":{\"type\":\"text\",\"label\":\"Text\"},\"type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i qu\\u1ea3ng c\\u00e1o\",\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"},\"code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 qu\\u1ea3ng c\\u00e1o\"}}},{\"path\":\"sidebar-calendar\",\"name\":\"Sidebar: L\\u1ecbch\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"lang\":{\"type\":\"radio\",\"label\":\"Ng\\u00f4n ng\\u1eef\",\"data\":{\"vi\":\"Ti\\u1ebfng Vi\\u1ec7t\",\"en\":\"Ti\\u1ebfng Anh\"},\"default\":\"vi\"}}},{\"path\":\"sidebar-newsletter\",\"name\":\"Sidebar: \\u0110\\u0103ng k\\u00fd nh\\u1eadn tin\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"V\\u00ed d\\u1ee5: \\u0110\\u0103ng k\\u00fd theo d\\u00f5i\"},\"placeholder\":{\"type\":\"text\",\"label\":\"Placeholder (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"V\\u00ed d\\u1ee5: Nh\\u1eadp email c\\u1ee7a b\\u1ea1n\"},\"button\":{\"type\":\"text\",\"label\":\"N\\u00fat \\u0111\\u0103ng k\\u00fd\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"}},\"data\":{\"title\":\"D\\u0103ng k\\u00fd nh\\u1eadn tin\",\"placeholder\":\"V\\u00ed d\\u1ee5: Nh\\u1eadp email c\\u1ee7a b\\u1ea1n\",\"button\":\"N\\u00fat \\u0111\\u0103ng k\\u00fd\"}},{\"path\":\"sidebar-post-list-1\",\"name\":\"Sidebar: Danh s\\u00e1ch tin b\\u00e0i (style 1)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"default\":\"Tin m\\u1edbi nh\\u1ea5t\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}}},{\"path\":\"sidebar-socials\",\"name\":\"Sidebar: Li\\u00ean k\\u1ebft m\\u1ea1ng x\\u00e3 h\\u1ed9i\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"V\\u00ed d\\u1ee5 k\\u1ebft n\\u1ed1i v\\u1edbi ch\\u00fang t\\u00f4i\"},\"facebook\":{\"type\":\"text\",\"label\":\"facebook (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"},\"twitter\":{\"type\":\"text\",\"label\":\"twitter (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"},\"youtube\":{\"type\":\"text\",\"label\":\"youtube (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"},\"linkedin\":{\"type\":\"text\",\"label\":\"Linkedin (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"},\"instagram\":{\"type\":\"text\",\"label\":\"instagram (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"},\"pinterest\":{\"type\":\"text\",\"label\":\"Pinterest (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y theo m\\u1ee5c li\\u00ean h\\u1ec7 h\\u1ecdc th\\u00f4ng tin website\"}},\"data\":{\"title\":\"K\\u1ebft n\\u1ed1i v\\u1edbi ch\\u00fang t\\u00f4i\"}},{\"path\":\"sidebar-weather\",\"name\":\"Sidebar: Th\\u00f4ng tin th\\u1eddi ti\\u1ebft\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"scale\":{\"type\":\"crazyselect\",\"label\":\"Thang nhi\\u1ec7u \\u0111\\u1ed9\",\"template\":\"crazyselect\",\"data\":{\"C\":\"\\u0110\\u1ed9 C\",\"F\":\"\\u0110\\u1ed9 F\"},\"required\":\"true\"},\"lat\":{\"type\":\"text\",\"label\":\"V\\u0129 \\u0111\\u1ed9 (latitude)\"},\"long\":{\"type\":\"text\",\"label\":\"V\\u0129 \\u0111\\u1ed9 (longitude)\"}}},{\"path\":\"single-related-posts\",\"name\":\"Chi ti\\u1ebft tin: Tin l\\u00ean quan\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5 (T\\u00f9y ch\\u1ecdn)\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"select\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"data\":{\"3\":3,\"6\":6,\"9\":0,\"12\":12},\"default\":3}}}]'),
(2, 'theme', 1, 'options', '{\"title\":\"247 News\",\"groups\":{\"styling\":{\"label\":\"Styling\",\"inputs\":{\"color\":{\"type\":\"colorselect\",\"label\":\"M\\u00e0u ch\\u1ee7 d\\u1ea1o\",\"@colors\":{\"red\":{\"text\":\"\\u0110\\u1ecf\",\"color\":\"#e4000d\",\"value\":\"red\"},\"blue\":{\"text\":\"Xanh da tr\\u1eddi\",\"color\":\"#53b1ff\",\"value\":\"blue\"},\"dark-blue\":{\"text\":\"Xanh da tr\\u1eddi \\u0110\\u1eadm\",\"color\":\"#00469a\",\"value\":\"dark-blue\"},\"green\":{\"text\":\"Xanh l\\u00e1\",\"color\":\"#4cb050\",\"value\":\"green\"},\"orange\":{\"text\":\"Cam\",\"color\":\"#fb8c00\",\"value\":\"orange\"},\"deep-orange\":{\"text\":\"Cam \\u0111\\u1ecf\",\"color\":\"#ff4011\",\"value\":\"deep-orange\"},\"turquoise\":{\"text\":\"Xanh san h\\u00f4\",\"color\":\"#39c9bb\",\"value\":\"turquoise\"},\"pink\":{\"text\":\"H\\u1ed3ng\",\"color\":\"#ea0253\",\"value\":\"pink\"},\"purple\":{\"text\":\"T\\u00edm\",\"color\":\"#6441a5\",\"value\":\"purple\"},\"slate\":{\"text\":\"X\\u00e1m l\\u00f4ng chu\\u1ed9t\",\"color\":\"#64666c\",\"value\":\"slate\"}},\"value\":\"blue\"},\"show_pageloader\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb page loader\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true}}},\"header\":{\"label\":\"Header\",\"inputs\":{\"show_text_logo\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb text logo\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"text_logo_primary\":{\"type\":\"text\",\"label\":\"Text Logo (ch\\u00ednh)\",\"value\":\"Tin T\\u1ee9c\"},\"text_logo_second\":{\"type\":\"text\",\"Label\":\"Text Logo (b\\u1ed5 xung)\",\"value\":\"24\\/7\"},\"highlight\":{\"type\":\"select\",\"label\":\"l\\u00e0m n\\u1ed5i b\\u1eadt\",\"data\":{\"none\":\"Kh\\u00f4ng\",\"primary\":\"Text ch\\u00ednh\",\"second\":\"Text ph\\u1ee5\",\"both\":\"T\\u1ea5t c\\u1ea3\"}},\"text_logo_slogan\":{\"type\":\"text\",\"Label\":\"Kh\\u1ea9u hi\\u1ec7u\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"},\"show_banner\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb banner qu\\u1ea3ng c\\u00e1o\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"banner_image\":{\"type\":\"file\",\"label\":\"Banner 720 x 90\",\"template\":\"cropit\",\"data-width\":720,\"data-height\":90},\"banner_alt\":{\"type\":\"text\",\"label\":\"Ch\\u00fa th\\u00edch banner\"},\"banner_link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"ads_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i qu\\u1ea3ng c\\u00e1o\",\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"},\"ads_code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\",\"placeholder\":\"Nhap76 m\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"show_datetime\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb th\\u1eddi gian\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"datetime_lang\":{\"type\":\"radio\",\"label\":\"Ng\\u00f4n ng\\u1eef\",\"data\":{\"vi\":\"Ti\\u1ebfng Vi\\u1ec7t\",\"en\":\"Ti\\u1ebfng Anh\"},\"value\":\"vi\"},\"date_format\":{\"type\":\"text\",\"label\":\"\\u0110\\u1ecbnh d\\u1ea1ng ng\\u00e0y th\\u00e1ng\",\"placeholder\":\"v\\u00ed d\\u1ee5: w, d\\/m\\/y\",\"comment\":\"trong \\u0111\\u00f3: %w l\\u00e0 ng\\u00e0y trong tu\\u1ea7n, %d l\\u00e0 ng\\u00e0y trong th\\u00e1ng, %m l\\u00e0 th\\u00e1ng b\\u00e0ng s\\u1ed1, %M l\\u00e0 th\\u00e1ng b\\u00e0ng t\\u00ean, %yy l\\u00e0 n\\u0103m\",\"value\":\"%w, ng\\u00e0y %d $M %y\"}},\"config\":{\"name\":\"Header\",\"layout_type\":\"single\",\"form_groups\":{\"logos\":{\"title\":\"Logo\",\"inputs\":[\"show_text_logo\",\"text_logo_primary\",\"text_logo_second\",\"highlight\",\"text_logo_slogan\"]},\"banner\":{\"title\":\"Banner qu\\u1ea3ng c\\u00e1o\",\"inputs\":[\"show_banner\",\"banner_image\",\"banner_alt\",\"banner_link\",\"ads_type\",\"ads_code\"]},\"datetime\":{\"title\":\"Ng\\u00e0y th\\u00e1ng\",\"inputs\":[\"show_datetime\",\"datetime_lang\",\"date_format\"]}}}},\"footer\":{\"label\":\"Footer\",\"inputs\":{\"news_footer\":{\"type\":\"area\",\"label\":\"footer Widget\",\"value\":\"news_footer\"},\"copyright\":{\"type\":\"text\",\"label\":\"Copyright\"},\"facebook\":{\"type\":\"text\",\"label\":\"Facebook\",\"placeholder\":\"Li\\u00ean k\\u1ebft Facebook\"},\"twitter\":{\"type\":\"text\",\"label\":\"Twitter\",\"placeholder\":\"Li\\u00ean k\\u1ebft Twitter\"},\"linkedin\":{\"type\":\"text\",\"label\":\"LinkedIn\",\"placeholder\":\"Li\\u00ean k\\u1ebft LinkedIn\"},\"youtube\":{\"type\":\"text\",\"label\":\"Youtube\",\"placeholder\":\"Li\\u00ean k\\u1ebft Youtube\"}}},\"sidebar\":{\"label\":\"Sidebar\",\"inputs\":{\"widgets\":{\"type\":\"area\",\"label\":\"Widgets\",\"value\":\"news_sidebar\"}}},\"home\":{\"label\":\"Trang ch\\u1ee7\",\"inputs\":{\"sections\":{\"type\":\"area\",\"label\":\"C\\u00e1c m\\u1ee5c xu\\u1ea5t hi\\u1ec7n tr\\u00ean trang ch\\u1ee7\",\"value\":\"home\"}}},\"contacts\":{\"label\":\"Li\\u00ean h\\u1ec7\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 gi\\u1edbi thi\\u1ec7u (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 (T\\u00f9y ch\\u1ecdn)\"},\"show_map\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb B\\u1ea3n \\u0111\\u1ed3\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\"},\"place\":{\"type\":\"text\",\"label\":\"T\\u00ean \\u0111\\u1ecba \\u0111i\\u1ec3m\"},\"lat\":{\"type\":\"text\",\"label\":\"V\\u0129 \\u0111\\u1ed9 (latitude)\"},\"long\":{\"type\":\"text\",\"label\":\"V\\u0129 \\u0111\\u1ed9 (longitude)\"},\"map_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i b\\u1ea3n \\u0111\\u1ed3\",\"data\":{\"lib\":\"D\\u00f9ng th\\u01b0 vi\\u1ec7n\",\"code\":\"D\\u00f9ng m\\u00e3 nh\\u00fang\"},\"default\":\"lib\"},\"map_code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 nh\\u00fang b\\u1ea3n \\u0111\\u1ed3\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 M\\u00e3 nh\\u00fang\"},\"email\":{\"type\":\"text\",\"Label\":\"Email\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"},\"phone_number\":{\"type\":\"text\",\"Label\":\"S\\u1ed1 \\u0111i\\u1ec7n tho\\u1ea1i\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"},\"address\":{\"type\":\"text\",\"Label\":\"\\u0110\\u1ecba ch\\u1ec9\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"},\"facebook\":{\"type\":\"text\",\"label\":\"facebook (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"twitter\":{\"type\":\"text\",\"label\":\"twitter (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"youtube\":{\"type\":\"text\",\"label\":\"youtube (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"linkedin\":{\"type\":\"text\",\"label\":\"Linkedin (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"instagram\":{\"type\":\"text\",\"label\":\"instagram (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"pinterest\":{\"type\":\"text\",\"label\":\"Pinterest (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}},\"config\":{\"name\":\"Th\\u00f4ng tin trang li\\u00ean h\\u1ec7\",\"layout_type\":\"single\",\"form_groups\":[{\"title\":\"Trang li\\u00ean h\\u1ec7\",\"inputs\":[\"title\",\"description\",\"show_map\",\"place\",\"lat\",\"long\",\"map_type\",\"map_code\"]},{\"title\":\"Th\\u00f4ng tin li\\u00ean h\\u1ec7\",\"inputs\":[\"address\",\"phone_number\",\"email\"]},{\"title\":\"Li\\u00ean k\\u1ebft m\\u1ea1ng x\\u00e3 h\\u1ed9i\",\"inputs\":[\"facebook\",\"twitter\",\"youtube\",\"linkedin\",\"instagram\",\"pinterest\",\"tumblr\"]}]}},\"single\":{\"label\":\"Chi ti\\u1ebft tin\",\"inputs\":{\"show_banner\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb banner qu\\u1ea3ng c\\u00e1o\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"banner_image\":{\"type\":\"file\",\"label\":\"Banner 1248 x 130\"},\"banner_alt\":{\"type\":\"text\",\"label\":\"Ch\\u00fa th\\u00edch banner\"},\"banner_link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"ads_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i qu\\u1ea3ng c\\u00e1o\",\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"},\"ads_code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"show_related_url\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb link c\\u00e1c tin b\\u00e0i li\\u00ean quan\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"single_post\":{\"type\":\"area\",\"label\":\"C\\u00e1c m\\u1ee5c b\\u1ed5 xung\",\"value\":\"single_post\"}}},\"page\":{\"label\":\"Chi ti\\u1ebft Page\",\"inputs\":{\"single_page\":{\"type\":\"area\",\"label\":\"C\\u00e1c m\\u1ee5c b\\u1ed5 xung\",\"value\":\"single_post\"}}}}}'),
(3, 'theme', 1, 'areas', '{\"news_footer\":\"Footer\",\"news_sidebar\":\"News Sidebar\",\"home\":\"Trang Ch\\u1ee7\",\"single_post\":\"Trang chi ti\\u1ebft b\\u00e0i vi\\u1ebft\",\"single_page\":\"Trang chi ti\\u1ebft page\"}'),
(4, 'theme', 1, 'layout', '{\"news_footer\":[{\"component\":\"footer-column-about\",\"data\":{\"title\":\"Gi\\u1edbi thi\\u1ec7u\",\"show_logo\":1,\"show_text_logo\":1}},{\"component\":\"footer-column-posts\",\"data\":{\"title\":\"Tin m\\u1edbi nh\\u1ea5t\",\"post_number\":4}},{\"component\":\"footer-column-posts\",\"data\":{\"title\":\"Ng\\u1eabu nhi\\u00ean\",\"post_number\":4,\"shorttype\":\"rand()\"}},{\"component\":\"footer-column-tags\",\"data\":{\"title\":\"Tags\",\"tag_number\":16,\"shorttype\":\"popuular\"}}],\"home\":[{\"component\":\"home-breaking-and-slider\",\"data\":{\"slider_sort_type\":1,\"slider_number_post\":16}},{\"component\":\"home-grid-list\",\"data\":{\"title\":\"Tin t\\u1ee9c\",\"sub_title\":\"n\\u1ed5i b\\u1eadt\",\"bg_style\":\"default\",\"sorttype\":\"rand()\",\"post_number\":4}},{\"component\":\"home-list-sidebar\",\"data\":{\"title\":\"Tin t\\u1ee9c\",\"sub_title\":\"m\\u1edbi nh\\u1ea5t\",\"bg_style\":4,\"sorttype\":1,\"post_number\":5,\"sidebar_title\":\"Tin m\\u1edbi nh\\u1ea5t\",\"sidebar_post_number\":20}},{\"component\":\"home-videos\",\"data\":{\"title\":\"Video\",\"sorttype\":1,\"post_number\":3}}],\"news_sidebar\":[{\"component\":\"sidebar-ads\",\"data\":[]},{\"component\":\"sidebar-post-list-1\",\"data\":{\"title\":\"Tin m\\u1edbi\",\"sorttype\":1,\"post_number\":20}},{\"component\":\"sidebar-calendar\",\"data\":{\"title\":\"L\\u1ecbch\",\"lang\":\"vi\"}},{\"component\":\"sidebar-weather\",\"data\":{\"title\":\"Th\\u1eddi ti\\u1ebft\",\"scale\":\"C\",\"lat\":\"\",\"long\":\"\"}},{\"component\":\"sidebar-newsletter\",\"data\":{\"title\":\"D\\u0103ng k\\u00fd nh\\u1eadn tin\",\"placeholder\":\"V\\u00ed d\\u1ee5: Nh\\u1eadp email c\\u1ee7a b\\u1ea1n\",\"button\":\"N\\u00fat \\u0111\\u0103ng k\\u00fd\"}},{\"component\":\"sidebar-socials\",\"data\":{\"title\":\"K\\u1ebft n\\u1ed1i v\\u1edbi ch\\u00fang t\\u00f4i\",\"facebook\":\"#\",\"twitter\":\"#\",\"youtube\":\"#\",\"instagram\":\"#\"}}],\"single_post\":[{\"component\":\"single-related\",\"data\":{\"post_number\":3}},{\"component\":\"block-ads-wide\",\"data\":[]}]}'),
(5, 'theme', 1, 'menus', '{\"positions\":{\"topleft\":\"Top Left\",\"topright\":\"Top Right\"},\"menus\":{\"topleft\":{\"name\":\"Li\\u00ean h\\u1ec7\",\"type\":\"theme\",\"depth\":1,\"positions\":[\"topleft\"],\"items\":[{\"type\":\"url\",\"text\":\"\",\"url\":\"#\",\"link_class\":\"faxebook\",\"icon\":\"fa fa-facebook\"},{\"type\":\"url\",\"text\":\"\",\"url\":\"#\",\"link_class\":\"twitter\",\"icon\":\"fa fa-twitter\"},{\"type\":\"url\",\"text\":\"\",\"url\":\"#\",\"link_class\":\"youtube\",\"icon\":\"fa fa-youtube\"},{\"type\":\"url\",\"text\":\"\",\"url\":\"#\",\"link_class\":\"linkedin\",\"icon\":\"fa fa-linkedin\"},{\"type\":\"url\",\"text\":\"\",\"url\":\"#\",\"link_class\":\"instagram\",\"icon\":\"fa fa-instagram\"},{\"type\":\"url\",\"text\":\"(+84) 945.786.960\",\"url\":\"tel:0945786960\",\"class\":\"address\",\"icon\":\"fa fa-phone\"},{\"type\":\"url\",\"text\":\"doanln16@gmail.com\",\"url\":\"mailto:doanln16@gmail.com\",\"class\":\"address\",\"icon\":\"fa fa-envelope-o\"}]},\"topright\":{\"name\":\"Top Right\",\"type\":\"theme\",\"depth\":1,\"positions\":[\"topright\"],\"items\":[{\"type\":\"url\",\"text\":\"\",\"url\":\"#\",\"class\":\"contact\",\"icon\":\"fa fa-map-marker fa-i\"},{\"type\":\"url\",\"text\":\"\",\"url\":\"#\",\"class\":\"about\",\"icon\":\"fa fa-user fa-i\"}]}}}'),
(6, 'data', 0, 'theme_active_list', '[1,2,3,4]'),
(7, 'theme', 2, 'components', '[{\"path\":\"package-item\",\"name\":\"G\\u00f3i d\\u1ecbch v\\u1ee5 (Package Item)\",\"inputs\":{\"name\":{\"type\":\"text\",\"label\":\"T\\u00ean g\\u00f3i\",\"placeholder\":\"V\\u00ed d\\u1ee5: Tin t\\u1ee9c\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\",\"placeholder\":\"V\\u00ed d\\u1ee5: 1 n\\u0103m b\\u1ea3o h\\u00e0nh\\nMi\\u1ec3n ph\\u00ed hosting\\nNi\\u1ec5n ph\\u00ed t\\u00ean mi\\u1ec1n\\n...\"},\"price_text\":{\"type\":\"text\",\"label\":\"Gi\\u00e1\",\"value\":\"0\"},\"active\":{\"type\":\"switch\",\"label\":\"N\\u1ed5i b\\u1eadt\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft\"},\"btn_text\":{\"type\":\"text\",\"label\":\"N\\u00fat xem th\\u00eam\",\"value\":\"\\u0110\\u0103ng k\\u00fd\"},\"class_name\":{\"type\":\"text\",\"label\":\"Class Name\",\"value\":\"col-md-6\"}}},{\"path\":\"promo-item\",\"name\":\"Promo Item\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"description\":{\"type\":\"text\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\"},\"icon\":{\"type\":\"text\",\"label\":\"Icon ClassName\",\"placeholder\":\"V\\u00ed d\\u1ee5: ti-vector\"}}},{\"path\":\"service-item\",\"name\":\"D\\u1ecbch v\\u1ee5 (service item)\",\"inputs\":{\"name\":{\"type\":\"text\",\"label\":\"T\\u00ean d\\u1ecbch v\\u1ee5\",\"placeholder\":\"V\\u00ed d\\u1ee5: thi\\u1ebft k\\u1ebf website\"},\"description\":{\"type\":\"text\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\",\"value\":\"\",\"placeholder\":\"\"},\"use_label\":{\"type\":\"switch\",\"label\":\"Th\\u00eam nh\\u00e3n\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\"},\"label_text\":{\"type\":\"text\",\"label\":\"Nh\\u00e3n\",\"value\":\"\",\"placeholder\":\"V\\u00ed d\\u1ee5 Good\"},\"label_class\":{\"type\":\"crazyselect\",\"label\":\"Lo\\u1ea1i nh\\u00e3n\",\"value\":\"success\",\"data\":{\"success\":\"Success (Xanh l\\u00e1)\",\"danger\":\"Danger (\\u0110\\u1ecf)\"}},\"icon\":{\"type\":\"text\",\"label\":\"Icon ClassName\",\"placeholder\":\"V\\u00ed d\\u1ee5: fa fa-bolt\",\"value\":\"fa fa-bolt\"}}},{\"path\":\"team-member\",\"name\":\"Th\\u00e0nh vi\\u00ean trong nh\\u00f3m (team member)\",\"inputs\":{\"name\":{\"type\":\"text\",\"label\":\"T\\u00ean th\\u00e0nh vi\\u00ean\",\"placeholder\":\"V\\u00ed d\\u1ee5: Thi\\u1ec7n CH\"},\"avatar\":{\"type\":\"file\",\"label\":\"Avatar\"},\"job\":{\"type\":\"text\",\"label\":\"c\\u00f4ng vi\\u1ec7c (V\\u1ecb tr\\u00ed l\\u00e0m vi\\u1ec7c)\"},\"is_loader\":{\"type\":\"switch\",\"label\":\"Tr\\u01b0\\u1edfng nh\\u00f3m?\",\"value_type\":\"boolean\"}}},{\"path\":\"testimonial-item\",\"name\":\"Th\\u00f4ng tin ph\\u1ea3n h\\u1ed3i (Testimonial item)\",\"inputs\":{\"name\":{\"type\":\"text\",\"label\":\"t\\u00ean ng\\u01b0\\u1eddi ph\\u1ea3n h\\u1ed3i\",\"placeholder\":\"V\\u00ed d\\u1ee5: Nguy\\u1ec5n V\\u0103n A\"},\"image\":{\"type\":\"file\",\"label\":\"\\u00c3nh \\u0111\\u1ea1i di\\u1ec7n\"},\"job\":{\"type\":\"text\",\"label\":\"C\\u00f4ng vi\\u1ec7c\",\"placeholder\":\"V\\u00ed d\\u1ee5: CEO\"},\"content\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\",\"placeholder\":\"V\\u00ed d\\u1ee5: Very grateful to have found this app. D&L team did a fantastic job...\"}},\"data\":[]}]');
INSERT INTO `metadatas` (`id`, `ref`, `ref_id`, `name`, `value`) VALUES
(8, 'theme', 2, 'options', '{\"title\":\"Bize\",\"groups\":{\"hero\":{\"label\":\"Banner\",\"inputs\":{\"show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb Text Slider (hero) \",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"background\":{\"type\":\"file\",\"Label\":\"H\\u00ecnh n\\u1ec1n\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 tr\\u00ean\",\"value\":\"Connecting to the future\"},\"static_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 t\\u0129nh\",\"value\":\"We are\"},\"typed_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 \\u0111\\u1ed9ng (typed text)\",\"value\":\"Web Developer, Web Designer\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"value\":\"Our work is the presentation of our capabilities. Professionally myocardinate\\n high standards in infrastructures and focused solutions. Completely actualize\\n multifunctional best practices\",\"placeholder\":\"Nh\\u1eadp m\\u00f4 t\\u1ea3\"},\"button_link\":{\"type\":\"text\",\"label\":\"Button Link\",\"value\":\"#service\"},\"button_text\":{\"type\":\"text\",\"label\":\"Button Text\",\"value\":\"Our Services\"}}},\"promo\":{\"label\":\"Promo\",\"inputs\":{\"show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb promo \",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"extra_class\":{\"type\":\"text\",\"label\":\"Extra class\",\"value\":\"\",\"placeholder\":\"V\\u00ed d\\u1ee5: bg-gray\"},\"promos\":{\"type\":\"area\",\"label\":\"Promo Items\",\"value\":\"promos\"}}},\"about\":{\"label\":\"Gi\\u1edbi thi\\u1ec7u\",\"inputs\":{\"show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb ph\\u1ea7n gi\\u1edbi thi\\u1ec7u \",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"section_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 section\",\"value\":\"Gi\\u1edbi thi\\u1ec7u\"},\"page_id\":{\"type\":\"crazyselect\",\"label\":\"Trang gi\\u1edbi thi\\u1ec7u (t\\u00f9y ch\\u1ecdn)\",\"call\":\"get_page_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"]},\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 gi\\u1edbi thi\\u1ec7u\",\"value\":\"\\u0110\\u00f4i n\\u00e9t v\\u1ec1 ch\\u00fang t\\u00f4i\"},\"description\":{\"type\":\"ckeditor\",\"label\":\"N\\u1ed9i dung Gi\\u1edbi thi\\u1ec7u\",\"height\":\"200\"},\"image\":{\"type\":\"file\",\"label\":\"\\u1ea2nh minh h\\u1ecda\"}}},\"services\":{\"label\":\"D\\u1ecbch v\\u1ee5\",\"inputs\":{\"show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb ph\\u1ea7n d\\u1ecbch v\\u1ee5 \",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 nh\\u1ecf (t\\u00f9y ch\\u1ecdn)\",\"value\":\"\"},\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"D\\u1ecbch v\\u1ee5\"},\"services\":{\"type\":\"area\",\"label\":\"C\\u00e1c d\\u1ecbch v\\u1ee5\",\"value\":\"services\"}}},\"projects\":{\"label\":\"D\\u1ef1 \\u00e1n\",\"inputs\":{\"show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb m\\u1ee5c D\\u1ef1 \\u00e1n\",\"props\":{\"check_label\":\"C\\u00f3\"},\"value_type\":\"boolean\",\"value\":true},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5\"},\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"D\\u1ef1 \\u00e1n\"},\"sorttype\":{\"type\":\"crazyselect\",\"label\":\"Ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_project_sortby_options\",\"value\":1},\"project_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":10}}},\"pricing\":{\"label\":\"B\\u00e1o gi\\u00e1\",\"inputs\":{\"show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb trang B\\u00e1o gi\\u00e1\",\"props\":{\"check_label\":\"C\\u00f3\"},\"value_type\":\"boolean\",\"value\":true},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5\"},\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"B\\u1ea3ng gi\\u00e1\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 \"},\"layout\":{\"type\":\"crazyselect\",\"label\":\"Layout\",\"data\":{\"1\":\"4 \\/ 7\",\"2\":\"4 \\/ 8\",\"3\":\"3 \\/ 8\",\"4\":\"3 \\/ 9\"},\"value\":1},\"tab_active\":{\"type\":\"radio\",\"label\":\"Tab k\\u00edch ho\\u1ea1t\",\"data\":{\"1\":\"Tab 1\",\"2\":\"Tab 2\",\"3\":\"Tab 3\"}},\"tab_1_show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb Tab 1\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\",\"value\":true},\"tab_1_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 tab 1\",\"value\":\"Basic\"},\"tab_1_packages\":{\"type\":\"area\",\"label\":\"C\\u00e1c g\\u00f3i trong tab 1\",\"value\":\"tab_1_packages\"},\"tab_2_show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb Tab 2\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\"},\"tab_2_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 tab 2\",\"value\":\"\"},\"tab_2_packages\":{\"type\":\"area\",\"label\":\"C\\u00e1c g\\u00f3i trong tab 2\",\"value\":\"tab_2_packages\"},\"tab_3_show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb Tab 3\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\"},\"tab_3_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 tab 3\"},\"tab_3_packages\":{\"type\":\"area\",\"label\":\"C\\u00e1c g\\u00f3i trong tab 3\",\"value\":\"tab_3_packages\"}}},\"testimonials\":{\"label\":\"Testimonials\",\"inputs\":{\"show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb Testimonials\",\"value_type\":\"boolean\",\"value\":true},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5\"},\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"Ph\\u1ea3n h\\u1ed3i t\\u1eeb kh\\u00e1ch h\\u00e0ng\"},\"background\":{\"type\":\"file\",\"Label\":\"H\\u00ecnh n\\u1ec1n\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u danh s\\u00e1ch\",\"props\":{\"data\":{\"data\":\"Trong b\\u1ea3ng ph\\u1ea3n h\\u1ed3i\",\"custom\":\"Danh s\\u00e1ch t\\u00f9y bi\\u1ebfn\"}},\"value\":\"custom\"},\"item_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":0},\"sort_type\":{\"type\":\"crazyselect\",\"label\":\"S\\u1eafp x\\u1ebfp\",\"props\":{\"data\":{\"id-ASC\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"id-DESC\":\"M\\u1edbi nh\\u1ea5t\",\"name-ASC\":\"h\\u1ee9 t\\u1ef1 b\\u1ea3ng ch\\u1ef1 c\\u00e1i\"}},\"value\":\"id-ASC\"},\"testimonials\":{\"type\":\"area\",\"label\":\"Danh s\\u00e1ch ph\\u1ea3n h\\u1ed3i t\\u00f9y bi\\u1ebfn\",\"value\":\"testimonials\",\"props\":{\"@title-by\":\"name\"}}}},\"team\":{\"label\":\"Team\",\"inputs\":{\"show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb Nh\\u00f3m l\\u00e0m vi\\u1ec7c\",\"value_type\":\"boolean\",\"value\":true},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5\"},\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"Team\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u danh s\\u00e1ch\",\"props\":{\"data\":{\"data\":\"Trong b\\u1ea3ng Nh\\u00f3m\",\"custom\":\"Danh s\\u00e1ch t\\u00f9y bi\\u1ebfn\"}},\"value\":\"custom\"},\"team_id\":{\"type\":\"crazyselect\",\"label\":\"Nh\\u00f3m\",\"call\":\"get_team_options\",\"params\":[[],\"Ch\\u1ecdn nh\\u00f3m\"]},\"item_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":4},\"sort_type\":{\"type\":\"crazyselect\",\"label\":\"S\\u1eafp x\\u1ebfp\",\"props\":{\"data\":{\"id-ASC\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"id-DESC\":\"M\\u1edbi nh\\u1ea5t\",\"users.name-ASC\":\"th\\u1ee9 t\\u1ef1 b\\u1ea3ng ch\\u1ef1 c\\u00e1i\",\"is_leader-DESC\":\"\\u01afu ti\\u00ean tr\\u01b0\\u1edfng nh\\u00f3m\",\"job-ASC\":\"C\\u00f4ng vi\\u1ec7c (A-z)\",\"rand()\":\"Ng\\u1eabu nhi\\u00ean\"}},\"value\":\"id-ASC\"},\"members\":{\"type\":\"area\",\"label\":\"Danh s\\u00e1ch th\\u00e0nh vi\\u00ean t\\u00f9y bi\\u1ebfn\",\"value\":\"team_members\",\"props\":{\"@title-by\":\"name\"}}}},\"contact\":{\"label\":\"Li\\u00ean h\\u1ec7\",\"inputs\":{\"show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb m\\u1ee5c li\\u00ean h\\u1ec7\",\"props\":{\"check_label\":\"C\\u00f3\"},\"value_type\":\"boolean\",\"value\":true},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5\"},\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"D\\u1ef1 \\u00e1n\"},\"button_text\":{\"type\":\"text\",\"label\":\"N\\u00fat g\\u1eedi\",\"value\":\"G\\u1eedi li\\u00ean h\\u1ec7\"},\"project_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":10}}},\"footer\":{\"label\":\"Footer\",\"inputs\":{\"copyright\":{\"type\":\"text\",\"label\":\"Tuy\\u00ean b\\u1ed1 b\\u1ea3n quy\\u1ec1n\"},\"show_socials\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb MXH\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\"},\"facebook\":{\"type\":\"text\",\"label\":\"Facebook\",\"placeholder\":\"Li\\u00ean k\\u1ebft Facebook\"},\"twitter\":{\"type\":\"text\",\"label\":\"Twitter\",\"placeholder\":\"Li\\u00ean k\\u1ebft Twitter\"},\"linkedin\":{\"type\":\"text\",\"label\":\"LinkedIn\",\"placeholder\":\"Li\\u00ean k\\u1ebft LinkedIn\"},\"youtube\":{\"type\":\"text\",\"label\":\"Youtube\",\"placeholder\":\"Li\\u00ean k\\u1ebft Youtube\"}}}}}'),
(9, 'theme', 2, 'areas', '{\"promos\":\"Promo Area\",\"services\":\"C\\u00e1c d\\u1ecbch v\\u1ee5\",\"clients\":\"Danh s\\u00e1ch kh\\u00e1ch h\\u00e0ng\",\"testimonials\":\"Danh s\\u00e1ch ph\\u1ea3n h\\u1ed3i\",\"tab_1_packages\":\"G\\u00f3i d\\u1ecbch v\\u1ee5 tab 1\",\"tab_2_packages\":\"G\\u00f3i d\\u1ecbch v\\u1ee5 tab 2\",\"tab_3_packages\":\"G\\u00f3i d\\u1ecbch v\\u1ee5 tab 3\",\"team_members\":\"Nh\\u00f3m l\\u00e0m vi\\u1ec7c\"}'),
(10, 'theme', 2, 'layout', '[]'),
(11, 'theme', 2, 'menus', '{\"positions\":{\"bize\":\"Bize\"},\"menus\":{\"bize\":{\"name\":\"Menu Bize\",\"type\":\"theme\",\"positions\":[\"primary\",\"bize\"],\"items\":[{\"text\":\"Home\",\"type\":\"url\",\"url\":\"#main\"},{\"text\":\"Gi\\u1edbi thi\\u1ec7u\",\"type\":\"url\",\"url\":\"#about\"},{\"text\":\"D\\u1ecbch v\\u1ee5\",\"type\":\"url\",\"url\":\"#service\"},{\"text\":\"C\\u00e1c d\\u1ef1 \\u00e1n\",\"type\":\"url\",\"url\":\"#work\"},{\"text\":\"Nh\\u00f3m l\\u00e0m vi\\u1ec7c\",\"type\":\"url\",\"url\":\"#team\"},{\"text\":\"Li\\u00ean h\\u1ec7\",\"type\":\"url\",\"url\":\"#contact\"}]}}}'),
(12, 'dynamic', 1, 'default_fields', '[\"title\",\"slug\",\"description\",\"content_type\",\"content\",\"gallery\",\"video_url\",\"source\",\"feature_image\",\"meta_title\",\"meta_description\",\"keywords\",\"tags\",\"privacy\"]'),
(13, 'dynamic', 1, 'advance_props', '[]'),
(14, 'dynamic', 1, 'custom_slug', '0'),
(15, 'dynamic', 1, 'prop_inputs', '[]'),
(16, 'dynamic', 1, 'form_config', '{\"name\":\"Th\\u00f4ng tin L\\u00ea Ng\\u1ecdc Do\\u00e3n\",\"layout_type\":\"column\",\"form_groups\":[{\"title\":\"Th\\u00f4ng tin c\\u01a1 b\\u1ea3n\",\"class\":\"col-12 col-lg-7\",\"inputs\":[\"title\",\"slug\",\"category_id\",\"description\"]},{\"title\":\"\\u1ea2nh v\\u00e0 ri\\u00eang t\\u01b0\",\"class\":\"col-12 col-lg-5\",\"inputs\":[\"feature_image\"]},{\"title\":\"Th\\u00f4ng tim chi ti\\u1ebft\",\"class\":\"col-12\",\"inputs\":[\"content\",\"content_type\",\"video_url\",\"gallery\",\"source\"]},{\"title\":\"Th\\u00f4ng tim SEO\",\"class\":\"col-12 col-lg-6\",\"inputs\":[\"meta_title\",\"meta_description\",\"keywords\"]},{\"title\":\"\",\"class\":\"col-12 col-lg-6\",\"inputs\":[\"tags\",\"privacy\"]}]}'),
(17, 'theme', 3, 'components', '{\"sidebar.social\":{\"name\":\"M\\u1ea1ng x\\u00e3 h\\u1ed9i\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"facebook\":{\"type\":\"text\",\"label\":\"facebook (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c (M\\u1eb7c \\u0111\\u1ecbnh theo m\\u1ee5c social)\"},\"twitter\":{\"type\":\"text\",\"label\":\"twitter (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c (M\\u1eb7c \\u0111\\u1ecbnh theo m\\u1ee5c social)\"},\"youtube\":{\"type\":\"text\",\"label\":\"youtube (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c (M\\u1eb7c \\u0111\\u1ecbnh theo m\\u1ee5c social)\"},\"linkedin\":{\"type\":\"text\",\"label\":\"Linkedin (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c (M\\u1eb7c \\u0111\\u1ecbnh theo m\\u1ee5c social)\"},\"instagram\":{\"type\":\"text\",\"label\":\"instagram (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c (M\\u1eb7c \\u0111\\u1ecbnh theo m\\u1ee5c social)\"},\"pinterest\":{\"type\":\"text\",\"label\":\"Pinterest (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c (M\\u1eb7c \\u0111\\u1ecbnh theo m\\u1ee5c social)\"}},\"path\":\"sidebar.social\"},\"sidebar.search\":{\"name\":\"Sidebar: T\\u00ecm ki\\u1ebfm\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"default\":\"T\\u00ecm ki\\u1ebfm\"}},\"path\":\"sidebar.search\"},\"sidebar.posts\":{\"name\":\"Sidebar: Danh s\\u00e1ch tin b\\u00e0i\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"default\":\"Tin m\\u1edbi nh\\u1ea5t\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}},\"path\":\"sidebar.posts\"},\"sidebar.categories\":{\"name\":\"Sidebar: Danh m\\u1ee5c\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"get_by_dynamic_active\":{\"type\":\"switch\",\"label\":\"\\u01afu ti\\u00ean m\\u1ee5c \\u0111ang xem\",\"value_type\":\"boolean\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"parent_id\"},\"parent_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c Cha\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_category_sortby_options\"}},\"path\":\"sidebar.categories\"},\"sidebar.tags\":{\"name\":\"Sidebar: Th\\u1ebb b\\u00e0i vi\\u1ebft (tags)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_tag_sortby_options\"},\"tag_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}},\"path\":\"sidebar.tags\"},\"contacts.area\":{\"name\":\"Home: M\\u1ee5c li\\u00ean h\\u1ec7\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"faq_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 FAQ (T\\u00f9y ch\\u1ecdn)\"}},\"path\":\"contacts.area\"},\"contacts.faq\":{\"name\":\"M\\u1ee5c li\\u00ean h\\u1ec7 - FAQ\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 \"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"}},\"path\":\"contacts.faq\"},\"footer.limks\":{\"name\":\"Footer: Li\\u00ean k\\u1ebft \\/ menu\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"menu_id\":{\"type\":\"crazyselect\",\"label\":\"Menu\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"call\":\"get_menu_options\"}},\"path\":\"footer.limks\"},\"footer.possts\":{\"name\":\"Footer: Danh s\\u00e1ch b\\u00e0i vi\\u1ebft\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":4}},\"path\":\"footer.possts\"},\"footer.about\":{\"name\":\"Footer: Gi\\u1edbi thi\\u1ec7u\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"Gi\\u1edbi thi\\u1ec7u\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"}},\"path\":\"footer.about\"},\"footer.contact\":{\"name\":\"Footer: Li\\u00ean h\\u1ec7\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"email\":{\"type\":\"text\",\"Label\":\"Email\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb m\\u1ee5c li\\u00ean h\\u1ec7\"},\"phone_number\":{\"type\":\"text\",\"Label\":\"S\\u1ed1 \\u0111i\\u1ec7n tho\\u1ea1i\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb m\\u1ee5c li\\u00ean h\\u1ec7\"},\"address\":{\"type\":\"text\",\"Label\":\"\\u0110\\u1ecba ch\\u1ec9\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb m\\u1ee5c li\\u00ean h\\u1ec7\"}},\"path\":\"footer.contact\"},\"sidebar-project.categories\":{\"name\":\"Project Sidebar: Danh m\\u1ee5c D\\u1ef1 \\u00e1n\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_project_category_sortby_options\"}},\"path\":\"sidebar-project.categories\"},\"home.services.area\":{\"name\":\"Home: C\\u00e1c d\\u1ecbch v\\u1ee5 (Service Area)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"bg_default_color\":{\"type\":\"radio\",\"label\":\"M\\u00e0u c\\u00f3 s\\u1eb5n\",\"data\":{\"\":\"Kh\\u00f4ng\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}},\"bg_color\":{\"type\":\"text\",\"label\":\"M\\u00e3 m\\u00e0u (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"},\"bg_image\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"bg_position\":{\"type\":\"radio\",\"label\":\"V\\u1ecb tr\\u00ed \\u1ea3nh\",\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}},\"bg_half\":{\"type\":\"switch\",\"label\":\"Bg Half\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb m\\u1ed9t n\\u1eeda h\\u00ecnh n\\u1ec1n\",\"value_type\":\"boolean\"},\"advance\":{\"type\":\"checklist\",\"label\":\"N\\u00e2ng cao\",\"data\":{\"shadow\":\"shadow\",\"dark\":\"dark\",\"dark-hard\":\"dark-hard\",\"light\":\"light\",\"theme\":\"theme\",\"theme-hard\":\"theme-hard\"}},\"class_name\":{\"type\":\"text\",\"label\":\"Class (T\\u00f9y ch\\u1ecdn)\"}},\"path\":\"home.services.area\"},\"home.services.item\":{\"name\":\"Home: D\\u1ecbch v\\u1ee5 (Service Item)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 \"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"link\":{\"type\":\"text\",\"label\":\"\\u0110\\u01b0\\u1eddng d\\u1eabn\"},\"icon\":{\"type\":\"text\",\"label\":\"Bi\\u1ec3u t\\u01b0\\u1ee3ng (ti-...)\",\"template\":\"iconpicker\"}},\"path\":\"home.services.item\"},\"home.posts\":{\"name\":\"Home: Danh s\\u00e1ch b\\u00e0i vi\\u1ebft\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"background\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":3}},\"path\":\"home.posts\"},\"home.about.style-1\":{\"name\":\"Home: Gi\\u1edbi thi\\u1ec7u\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"content\":{\"type\":\"textarea\",\"label\":\"Gi\\u1edbi thi\\u1ec7u\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"image\":{\"type\":\"file\",\"label\":\"\\u1ea2nh minh h\\u1ecda\"},\"youtube_url\":{\"type\":\"text\",\"label\":\"Video Youtube\"},\"services\":{\"type\":\"textarea\",\"label\":\"D\\u1ecbch v\\u1ee5 n\\u1edfi b\\u1eadt\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\\nM\\u1ed5i d\\u1ecbch v\\u1ee5 m\\u1ed9t d\\u00f2ng\",\"className\":\"auto-height\"}},\"path\":\"home.about.style-1\"},\"home.testimonials.area\":{\"name\":\"Home: Testimonials (area)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u danh s\\u00e1ch\",\"data\":{\"data\":\"Trong b\\u1ea3ng ph\\u1ea3n h\\u1ed3i\",\"custom\":\"Danh s\\u00e1ch t\\u00f9y bi\\u1ebfn\"},\"value\":\"custom\"},\"item_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":5},\"sort_type\":{\"type\":\"crazyselect\",\"label\":\"S\\u1eafp x\\u1ebfp\",\"data\":{\"id-ASC\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"id-DESC\":\"M\\u1edbi nh\\u1ea5t\",\"name-ASC\":\"h\\u1ee9 t\\u1ef1 b\\u1ea3ng ch\\u1ef1 c\\u00e1i\"},\"value\":\"id-ASC\"}},\"path\":\"home.testimonials.area\"},\"home.testimonials.item\":{\"name\":\"Home: Testimonials Item\",\"inputs\":{\"name\":{\"type\":\"text\",\"label\":\"t\\u00ean ng\\u01b0\\u1eddi ph\\u1ea3n h\\u1ed3i\",\"placeholder\":\"V\\u00ed d\\u1ee5: Nguy\\u1ec5n V\\u0103n A\"},\"image\":{\"type\":\"file\",\"label\":\"\\u00c3nh \\u0111\\u1ea1i di\\u1ec7n\"},\"job\":{\"type\":\"text\",\"label\":\"C\\u00f4ng vi\\u1ec7c\",\"placeholder\":\"V\\u00ed d\\u1ee5: CEO\"},\"content\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\",\"placeholder\":\"V\\u00ed d\\u1ee5: Very grateful to have found this app. D&L team did a fantastic job...\"}},\"path\":\"home.testimonials.item\"},\"home.pricing.area\":{\"name\":\"Home: B\\u00e1o gi\\u00e1 (area)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"}},\"path\":\"home.pricing.area\"},\"home.pricing.item\":{\"name\":\"Home: B\\u00e1o gi\\u00e1 (item)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"placeholder\":\"V\\u00ed d\\u1ee5: Th\\u01b0\\u01a1ng m\\u1ea1i \\u0111i\\u1ec7n t\\u1eed\"},\"label\":{\"type\":\"text\",\"label\":\"Nh\\u00e3n (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"V\\u00ed d\\u1ee5: HOT\"},\"price_label\":{\"type\":\"text\",\"label\":\"Nh\\u00e3n gi\\u00e1 (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"V\\u00ed d\\u1ee5: Ch\\u1ec9 t\\u1eeb\",\"default\":\"Ch\\u1ec9 t\\u1eeb\"},\"price\":{\"type\":\"number\",\"label\":\"Gi\\u00e1\",\"default\":0,\"min\":0},\"unit\":{\"type\":\"text\",\"label\":\"\\u0110\\u01a1n v\\u1ecb ti\\u1ec1n\",\"placeholder\":\"V\\u00ed d\\u1ee5: VN\\u0110, $, ...\",\"default\":\"VN\\u0110\"},\"content\":{\"type\":\"textarea\",\"label\":\"N\\u1ed9i dung (danh s\\u00e1ch t\\u00ednh n\\u0103ng)\",\"placeholder\":\"V\\u00ed d\\u1ee5: [true] Mi\\u1ec3n ph\\u00ed hosting\\n[false] Gi\\u1edbi h\\u1ea1n t\\u00ean mi\\u1ec1n\",\"className\":\"auto-height\"},\"active\":{\"type\":\"switch\",\"label\":\"Active (k\\u00edch ho\\u1ea1t)\",\"value_type\":\"boolean\"},\"link\":{\"type\":\"text\",\"label\":\"Link \\u0111\\u0103ng k\\u00fd\",\"placeholder\":\"Nh\\u1eadp link\"}},\"path\":\"home.pricing.item\"},\"home.contact.area\":{\"name\":\"Home: M\\u1ee5c li\\u00ean h\\u1ec7\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"faq_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 FAQ (T\\u00f9y ch\\u1ecdn)\"}},\"path\":\"home.contact.area\"},\"home.contact.faq\":{\"name\":\"Home: M\\u1ee5c li\\u00ean h\\u1ec7 - FAQ\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 \"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"}},\"path\":\"home.contact.faq\"},\"home.portfolio\":{\"name\":\"Home: Portfolio\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"D\\u1ef1 \\u00e1n\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"sorttype\":{\"type\":\"crazyselect\",\"label\":\"Ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_project_sortby_options\",\"value\":1},\"project_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":10}},\"path\":\"home.portfolio\"},\"home.facts\":{\"name\":\"Home: Facts\",\"inputs\":{\"fact_1\":{\"type\":\"textarea\",\"label\":\"Fact 1\",\"placeholder\":\"Ti\\u00eau \\u0111\\u1ec1 (ho\\u1eb7c s\\u1ed1)...\\nTi\\u00eau \\u0111\\u1ec1 ph\\u1ee5..\\nN\\u1ed9i dung... \",\"className\":\"auto-height\"},\"fact_2\":{\"type\":\"textarea\",\"label\":\"Fact 2\",\"placeholder\":\"Ti\\u00eau \\u0111\\u1ec1 (ho\\u1eb7c s\\u1ed1)...\\nTi\\u00eau \\u0111\\u1ec1 ph\\u1ee5..\\nN\\u1ed9i dung... \",\"className\":\"auto-height\"},\"line_1\":{\"type\":\"text\",\"label\":\"Ti\\u1ebfn tr\\u00ecnh 1\",\"placeholder\":\"Ti\\u00eau \\u0111\\u1ec1 = s\\u1ed1 (%)\"},\"line_2\":{\"type\":\"text\",\"label\":\"Ti\\u1ebfn tr\\u00ecnh 2\",\"placeholder\":\"Ti\\u00eau \\u0111\\u1ec1 = s\\u1ed1 (%)\"},\"line_3\":{\"type\":\"text\",\"label\":\"Ti\\u1ebfn tr\\u00ecnh 3\",\"placeholder\":\"Ti\\u00eau \\u0111\\u1ec1 = s\\u1ed1 (%)\"}},\"path\":\"home.facts\"},\"home.banners.style-1\":{\"name\":\"Home: banner > Style 1\",\"inputs\":{\"slider_id\":{\"type\":\"crazyselect\",\"label\":\"Slider\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"call\":\"get_slider_options\"},\"btn_text\":{\"type\":\"text\",\"label\":\"N\\u00fat b\\u1ea5m\",\"placeholder\":\"Ch\\u1eef s\\u1ebd \\u0111\\u01b0\\u1ee3c hi\\u1ec3n th\\u1ecb tr\\u00ean n\\u00fat xem th\\u00eam\"}},\"path\":\"home.banners.style-1\"},\"home.team.area\":{\"name\":\"Home: Team (area)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"background\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u danh s\\u00e1ch\",\"data\":{\"data\":\"Trong b\\u1ea3ng Nh\\u00f3m\",\"custom\":\"Danh s\\u00e1ch t\\u00f9y bi\\u1ebfn\"},\"value\":\"custom\"},\"team_id\":{\"type\":\"crazyselect\",\"label\":\"Nh\\u00f3m\",\"call\":\"get_team_options\",\"params\":[[],\"Ch\\u1ecdn nh\\u00f3m\"]},\"item_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":4},\"sort_type\":{\"type\":\"crazyselect\",\"label\":\"S\\u1eafp x\\u1ebfp\",\"data\":{\"id-ASC\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"id-DESC\":\"M\\u1edbi nh\\u1ea5t\",\"users.name-ASC\":\"th\\u1ee9 t\\u1ef1 b\\u1ea3ng ch\\u1ef1 c\\u00e1i\",\"is_leader-DESC\":\"\\u01afu ti\\u00ean tr\\u01b0\\u1edfng nh\\u00f3m\",\"job-ASC\":\"C\\u00f4ng vi\\u1ec7c (A-z)\",\"rand()\":\"Ng\\u1eabu nhi\\u00ean\"},\"value\":\"id-ASC\"}},\"path\":\"home.team.area\"},\"home.team.item\":{\"name\":\"Home: Team Member\",\"inputs\":{\"name\":{\"type\":\"text\",\"label\":\"T\\u00ean th\\u00e0nh vi\\u00ean\",\"placeholder\":\"V\\u00ed d\\u1ee5: Thi\\u1ec7n CH\"},\"avatar\":{\"type\":\"file\",\"label\":\"Avatar\"},\"job\":{\"type\":\"text\",\"label\":\"c\\u00f4ng vi\\u1ec7c (V\\u1ecb tr\\u00ed l\\u00e0m vi\\u1ec7c)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft (T\\u00f9y ch\\u1ecdn)\"},\"is_loader\":{\"type\":\"switch\",\"label\":\"Tr\\u01b0\\u1edfng nh\\u00f3m?\",\"value_type\":\"boolean\"}},\"path\":\"home.team.item\"}}'),
(18, 'theme', 3, 'options', '{\"title\":\"Bunas\",\"groups\":{\"header\":{\"label\":\"Header\",\"inputs\":{\"show_top\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb text trung t\\u00e2m\",\"check_label\":\"C\\u00f3\",\"value_type\":\"boolean\"},\"logo\":{\"type\":\"file\",\"label\":\"Logo\"},\"logo_light\":{\"type\":\"file\",\"label\":\"Logo Tr\\u1eafng (light)\"},\"page_header_background\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n \\u0111\\u1ea7u trang m\\u1eb7c \\u0111\\u1ecbnh (T\\u00f9y ch\\u1ecdn)\"},\"page_header_padding_y\":{\"type\":\"number\",\"label\":\"C\\u0103n tr\\u00ean d\\u01b0\\u1edbi \\u0111\\u1ea7u trang (px)\",\"default\":\"160\"},\"page_header_breadcrumb_bottom\":{\"type\":\"number\",\"label\":\"breakcrumb position-Bottom (px)\",\"default\":\"-180\"}}},\"footer\":{\"label\":\"Footer\",\"inputs\":{\"footer\":{\"type\":\"area\",\"label\":\"footer Widget\",\"value\":\"footer\"},\"copyright\":{\"type\":\"text\",\"label\":\"Copyright\"}}},\"sidebar\":{\"label\":\"Sidebar\",\"inputs\":{\"widgets\":{\"type\":\"area\",\"label\":\"Post sidebar Widgets\",\"value\":\"sidebar_post\"},\"project_widgets\":{\"type\":\"area\",\"label\":\"project sidebar Widgets\",\"value\":\"sidebar_project\"},\"page_widgets\":{\"type\":\"area\",\"label\":\"page sidebar Widgets\",\"value\":\"sidebar_page\",\"default\":\"sidebar_page\"}}},\"home\":{\"label\":\"Trang ch\\u1ee7\",\"inputs\":{\"home\":{\"type\":\"area\",\"label\":\"Th\\u00e0nh ph\\u00e0n trang ch\\u1ee7\",\"value\":\"home\",\"@title-by\":\"title\"},\"home_services\":{\"type\":\"area\",\"label\":\"Danh s\\u00e1ch d\\u1ecbch v\\u1ee5\",\"value\":\"home_services\",\"@title-by\":\"title\"},\"testimonials\":{\"type\":\"area\",\"label\":\"Danh s\\u00e1ch ph\\u1ea3n h\\u1ed3i t\\u00f9y bi\\u1ebfn\",\"value\":\"testimonials\",\"@title-by\":\"name\"},\"members\":{\"type\":\"area\",\"label\":\"Danh s\\u00e1ch th\\u00e0nh vi\\u00ean t\\u00f9y bi\\u1ebfn\",\"value\":\"team_members\",\"@title-by\":\"name\"},\"contact_faq\":{\"type\":\"area\",\"label\":\"C\\u00e1c C\\u00e2u h\\u1ecfi th\\u01b0\\u1eddng g\\u1eb7p\",\"value\":\"contact_faq\",\"@title-by\":\"title\"},\"home_pricing\":{\"type\":\"area\",\"label\":\"b\\u00e1o gi\\u00e1 C\\u00e1c g\\u00f3i d\\u1ecbch v\\u1ee5\",\"value\":\"home_pricing\",\"@title-by\":\"title\"}}},\"contacts\":{\"label\":\"Li\\u00ean h\\u1ec7\",\"inputs\":{\"page_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 Trang li\\u00ean h\\u1ec7\",\"value\":\"Li\\u00ean h\\u1ec7\"},\"page_description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 r\\u1ea3 trang li\\u00ean h\\u1ec7\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"},\"email\":{\"type\":\"text\",\"Label\":\"Email\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"},\"phone_number\":{\"type\":\"text\",\"Label\":\"S\\u1ed1 \\u0111i\\u1ec7n tho\\u1ea1i\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"},\"address\":{\"type\":\"text\",\"Label\":\"\\u0110\\u1ecba ch\\u1ec9\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"},\"form_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 Form li\\u00ean h\\u1ec7\",\"value\":\"H\\u00e3y n\\u00f3i v\\u1ec1 nh\\u1eefng \\u00fd t\\u01b0\\u1edfng c\\u1ee7a b\\u1ea1n\"},\"form_description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 r\\u1ea3 \\/ Gi\\u1edbi thi\\u1ec7u\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"},\"button_text\":{\"type\":\"text\",\"label\":\"N\\u00fat g\\u1eedi\",\"value\":\"G\\u1eedi li\\u00ean h\\u1ec7\"},\"map_code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 nh\\u00fang b\\u1ea3n \\u0111\\u1ed3\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 M\\u00e3 nh\\u00fang\"},\"faq_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 FAQ (T\\u00f9y ch\\u1ecdn)\"},\"contact_faq\":{\"type\":\"area\",\"label\":\"C\\u00e1c C\\u00e2u h\\u1ecfi th\\u01b0\\u1eddng g\\u1eb7p\",\"value\":\"contact_faq\",\"@title-by\":\"title\"}}},\"socials\":{\"label\":\"MXH\",\"inputs\":{\"facebook\":{\"type\":\"text\",\"label\":\"facebook (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"twitter\":{\"type\":\"text\",\"label\":\"twitter (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"youtube\":{\"type\":\"text\",\"label\":\"youtube (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"linkedin\":{\"type\":\"text\",\"label\":\"Linkedin (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"instagram\":{\"type\":\"text\",\"label\":\"instagram (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"pinterest\":{\"type\":\"text\",\"label\":\"Pinterest (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}}},\"posts\":{\"label\":\"B\\u00e0i vi\\u1ebft\",\"inputs\":{\"page_header_background\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n \\u0111\\u1ea7u trang m\\u1eb7c \\u0111\\u1ecbnh (T\\u00f9y ch\\u1ecdn)\"}}},\"pages\":{\"label\":\"Trang\",\"inputs\":{\"page_header_background\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n \\u0111\\u1ea7u trang m\\u1eb7c \\u0111\\u1ecbnh (T\\u00f9y ch\\u1ecdn)\"}}},\"projects\":{\"label\":\"D\\u1ef1 \\u00e1n\",\"inputs\":{\"page_header_background\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n \\u0111\\u1ea7u trang m\\u1eb7c \\u0111\\u1ecbnh (T\\u00f9y ch\\u1ecdn)\"}}},\"search\":{\"label\":\"Search\",\"inputs\":{\"page_header_background\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n \\u0111\\u1ea7u trang m\\u1eb7c \\u0111\\u1ecbnh (T\\u00f9y ch\\u1ecdn)\"},\"page_header_padding_y\":{\"type\":\"number\",\"label\":\"C\\u0103n tr\\u00ean d\\u01b0\\u1edbi \\u0111\\u1ea7u trang (px)\",\"default\":\"160\"},\"page_header_breakcrumb_bottom\":{\"type\":\"number\",\"label\":\"Link position-Bottom (px)\",\"default\":\"-180\"}}},\"forms\":{\"label\":\"Forms\",\"inputs\":{\"logo\":{\"type\":\"file\",\"label\":\"Logo\"},\"logo_light\":{\"type\":\"file\",\"label\":\"Logo Tr\\u1eafng (light)\"},\"register_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 m\\u1ee5c \\u0111\\u0103ng k\\u00fd\",\"value\":\"\\u0110\\u0103ng k\\u00fd \\u0111\\u1ec3 nh\\u1eadn t\\u00e0i kho\\u1ea3n d\\u00f9ng th\\u1eed mi\\u1ec3n ph\\u00ed\"},\"register_description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 r\\u1ea3 m\\u1ee5c \\u0111\\u0103ng k\\u00fd\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"}}}}}'),
(19, 'theme', 3, 'areas', '{\"home\":\"Trang Ch\\u1ee7\",\"home_services\":\"D\\u1ecbch v\\u1ee5 tr\\u00ean trang ch\\u1ee7\",\"testimonials\":\"Danh s\\u00e1ch ph\\u1ea3n h\\u1ed3i\",\"team_members\":\"Nh\\u00f3m l\\u00e0m vi\\u1ec7c\",\"contact_faq\":\"C\\u00e1c c\\u00e2u h\\u1ecfi th\\u01b0\\u1eddng g\\u1eb7p\",\"home_pricing\":\"B\\u00e1o gi\\u00e1 (tr\\u00ean trang ch\\u1ee7)\",\"sidebar_post\":\"Post Sidebar\",\"sidebar_project\":\"Project Sidebar\",\"sidebar_page\":\"Page Sidebar\"}'),
(20, 'theme', 3, 'layout', '[]'),
(21, 'theme', 3, 'menus', '{\"positions\":{\"extra\":\"Extra\"}}'),
(22, 'dynamic', 2, 'default_fields', '[\"title\",\"slug\",\"description\",\"content_type\",\"content\",\"feature_image\",\"meta_title\",\"meta_description\",\"keywords\",\"tags\",\"privacy\"]'),
(23, 'dynamic', 2, 'advance_props', '[{\"name\":\"service_id\",\"type\":\"select\",\"label\":\"G\\u00f3i d\\u1ecbch v\\u1ee5\",\"validate\":null,\"prop_list\":[{\"key\":\"call\",\"value\":\"get_service_options\"},{\"key\":\"params\",\"value\":\"@[[], \\\"Ch\\u1ecdn m\\u1ed9t\\\"]\"}]}]'),
(24, 'dynamic', 2, 'custom_slug', '0'),
(25, 'dynamic', 2, 'prop_inputs', '{\"service_id\":{\"name\":\"service_id\",\"type\":\"select\",\"label\":\"G\\u00f3i d\\u1ecbch v\\u1ee5\",\"validate\":null,\"call\":\"get_service_options\",\"params\":\"@[[], \\\"Ch\\u1ecdn m\\u1ed9t\\\"]\"}}'),
(26, 'dynamic', 2, 'form_config', '{\"name\":\"Th\\u00f4ng tin D\\u1ecbch v\\u1ee5\",\"layout_type\":\"column\",\"form_groups\":[{\"title\":\"Th\\u00f4ng tin c\\u01a1 b\\u1ea3n\",\"class\":\"col-12 col-lg-7\",\"inputs\":[\"title\",\"slug\",\"category_id\",\"service_id\",\"description\"]},{\"title\":\"\\u1ea2nh v\\u00e0 ri\\u00eang t\\u01b0\",\"class\":\"col-12 col-lg-5\",\"inputs\":[\"feature_image\"]},{\"title\":\"Th\\u00f4ng tin chi ti\\u1ebft\",\"class\":\"col-12\",\"inputs\":[\"content\",\"content_type\"]},{\"title\":\"Th\\u00f4ng tin SEO\",\"class\":\"col-12 col-lg-6\",\"inputs\":[\"meta_title\",\"meta_description\",\"keywords\"]},{\"title\":null,\"class\":\"col-12 col-lg-6\",\"inputs\":[\"tags\",\"privacy\"]}]}'),
(27, 'project', 1, 'custom_slug', NULL),
(28, 'project', 1, 'client_id', '0'),
(29, 'project', 1, 'website', NULL),
(30, 'project', 1, 'link', NULL),
(31, 'project', 1, 'feature_image_keep_original', NULL),
(32, 'project', 1, 'og_image_width', '400'),
(33, 'project', 1, 'og_image_height', '400'),
(34, 'project', 2, 'custom_slug', NULL),
(35, 'project', 2, 'client_id', '0'),
(36, 'project', 2, 'website', NULL),
(37, 'project', 2, 'link', NULL),
(38, 'project', 2, 'feature_image_keep_original', NULL),
(39, 'project', 2, 'og_image_width', '400'),
(40, 'project', 2, 'og_image_height', '400'),
(41, 'project', 3, 'custom_slug', NULL),
(42, 'project', 3, 'client_id', '0'),
(43, 'project', 3, 'website', NULL),
(44, 'project', 3, 'link', NULL),
(45, 'project', 3, 'feature_image_keep_original', NULL),
(46, 'project', 3, 'og_image_width', '400'),
(47, 'project', 3, 'og_image_height', '400'),
(48, 'project', 4, 'custom_slug', NULL),
(49, 'project', 4, 'client_id', '0'),
(50, 'project', 4, 'website', NULL),
(51, 'project', 4, 'link', NULL),
(52, 'project', 4, 'feature_image_keep_original', NULL),
(53, 'project', 4, 'og_image_width', '400'),
(54, 'project', 4, 'og_image_height', '400'),
(55, 'project', 5, 'custom_slug', NULL),
(56, 'project', 5, 'client_id', '0'),
(57, 'project', 5, 'website', NULL),
(58, 'project', 5, 'link', NULL),
(59, 'project', 5, 'feature_image_keep_original', NULL),
(60, 'project', 5, 'og_image_width', '400'),
(61, 'project', 5, 'og_image_height', '400'),
(62, 'project', 6, 'custom_slug', NULL),
(63, 'project', 6, 'client_id', '0'),
(64, 'project', 6, 'website', NULL),
(65, 'project', 6, 'link', NULL),
(66, 'project', 6, 'feature_image_keep_original', NULL),
(67, 'project', 6, 'og_image_width', '400'),
(68, 'project', 6, 'og_image_height', '400'),
(69, 'dynamic', 3, 'default_fields', '[\"title\",\"slug\",\"description\",\"content_type\",\"content\",\"gallery\",\"video_url\",\"source\",\"feature_image\",\"meta_title\",\"meta_description\",\"keywords\",\"tags\",\"privacy\"]'),
(70, 'dynamic', 3, 'advance_props', '[]'),
(71, 'dynamic', 3, 'custom_slug', '0'),
(72, 'dynamic', 3, 'prop_inputs', '[]'),
(73, 'dynamic', 3, 'form_config', '{\"name\":\"Th\\u00f4ng tin Blog\",\"layout_type\":\"column\",\"form_groups\":[{\"title\":\"Th\\u00f4ng tin c\\u01a1 b\\u1ea3n\",\"class\":\"col-12 col-lg-7\",\"inputs\":[\"title\",\"slug\",\"category_id\",\"description\"]},{\"title\":\"\\u1ea2nh v\\u00e0 ri\\u00eang t\\u01b0\",\"class\":\"col-12 col-lg-5\",\"inputs\":[\"feature_image\"]},{\"title\":\"Th\\u00f4ng tin chi ti\\u1ebft\",\"class\":\"col-12\",\"inputs\":[\"content\",\"content_type\",\"video_url\",\"gallery\",\"source\"]},{\"title\":\"Th\\u00f4ng tin SEO\",\"class\":\"col-12 col-lg-6\",\"inputs\":[\"meta_title\",\"meta_description\",\"keywords\"]},{\"title\":null,\"class\":\"col-12 col-lg-6\",\"inputs\":[\"tags\",\"privacy\"]}]}'),
(74, 'post', 7, 'custom_slug', NULL),
(75, 'post', 7, 'meta_title', NULL),
(76, 'post', 7, 'meta_description', NULL),
(77, 'post', 7, 'feature_image_keep_original', NULL),
(78, 'post', 7, 'og_image_width', '600'),
(79, 'post', 7, 'og_image_height', '315'),
(80, 'post', 8, 'custom_slug', NULL),
(81, 'post', 8, 'meta_title', NULL),
(82, 'post', 8, 'meta_description', NULL),
(83, 'post', 8, 'feature_image_keep_original', NULL),
(84, 'post', 8, 'og_image_width', '600'),
(85, 'post', 8, 'og_image_height', '315'),
(86, 'post', 9, 'custom_slug', NULL),
(87, 'post', 9, 'meta_title', NULL),
(88, 'post', 9, 'meta_description', NULL),
(89, 'post', 9, 'feature_image_keep_original', NULL),
(90, 'post', 9, 'og_image_width', '600'),
(91, 'post', 9, 'og_image_height', '315'),
(92, 'page', 10, 'custom_slug', NULL),
(93, 'page', 10, 'meta_title', NULL),
(94, 'page', 10, 'meta_description', NULL),
(95, 'page', 10, 'feature_image_keep_original', NULL),
(96, 'page', 10, 'og_image_width', '400'),
(97, 'page', 10, 'og_image_height', '300'),
(98, 'dynamic', 4, 'default_fields', '[\"title\",\"slug\",\"description\",\"content_type\",\"content\",\"gallery\",\"video_url\",\"source\",\"feature_image\",\"meta_title\",\"meta_description\",\"keywords\",\"tags\",\"privacy\"]'),
(99, 'dynamic', 4, 'advance_props', '[{\"name\":\"bookmark\",\"type\":\"textarea\",\"label\":\"\\u0110\\u00e1nh d\\u1ea5u trang\",\"validate\":null}]'),
(100, 'dynamic', 4, 'custom_slug', 'on'),
(101, 'dynamic', 4, 'prop_inputs', '{\"bookmark\":{\"name\":\"bookmark\",\"type\":\"textarea\",\"label\":\"\\u0110\\u00e1nh d\\u1ea5u trang\",\"validate\":null}}'),
(102, 'dynamic', 4, 'form_config', '{\"name\":\"Th\\u00f4ng tin T\\u00e0i li\\u1ec7u\",\"layout_type\":\"column\",\"form_groups\":[{\"title\":\"Th\\u00f4ng tin c\\u01a1 b\\u1ea3n\",\"class\":\"col-12 col-lg-7\",\"inputs\":[\"title\",\"slug\",\"category_id\",\"description\"]},{\"title\":\"\\u1ea2nh v\\u00e0 ri\\u00eang t\\u01b0\",\"class\":\"col-12 col-lg-5\",\"inputs\":[\"feature_image\"]},{\"title\":\"Th\\u00f4ng tin chi ti\\u1ebft\",\"class\":\"col-12\",\"inputs\":[\"content\",\"content_type\",\"bookmark\",\"video_url\",\"gallery\",\"source\"]},{\"title\":\"Th\\u00f4ng tin SEO\",\"class\":\"col-12 col-lg-6\",\"inputs\":[\"meta_title\",\"meta_description\",\"keywords\"]},{\"title\":null,\"class\":\"col-12 col-lg-6\",\"inputs\":[\"tags\",\"privacy\"]}]}'),
(103, 'project', 11, 'custom_slug', NULL),
(104, 'project', 11, 'client_id', NULL),
(105, 'project', 11, 'website', NULL),
(106, 'project', 11, 'link', NULL),
(107, 'project', 11, 'feature_image_keep_original', NULL),
(108, 'project', 11, 'og_image_width', '400'),
(109, 'project', 11, 'og_image_height', '400'),
(110, 'post', 12, 'custom_slug', NULL),
(111, 'post', 12, 'meta_title', 'Dịch vụ tạo website miễn phí hosting và tên miền | Web 1-0-2 | VCC.VN'),
(112, 'post', 12, 'meta_description', NULL),
(113, 'post', 12, 'feature_image_keep_original', NULL),
(114, 'post', 12, 'service_id', '1'),
(115, 'post', 12, 'og_image_width', '600'),
(116, 'post', 12, 'og_image_height', '315'),
(117, 'post', 13, 'custom_slug', NULL),
(118, 'post', 13, 'meta_title', 'Dịch vụ tạo blog cá nhân miễn phí hosting và tên miền | Web 1-0-2 | VCC.VN'),
(119, 'post', 13, 'meta_description', NULL),
(120, 'post', 13, 'feature_image_keep_original', NULL),
(121, 'post', 13, 'service_id', '2'),
(122, 'post', 13, 'og_image_width', '276'),
(123, 'post', 13, 'og_image_height', '276'),
(124, 'post', 14, 'custom_slug', NULL),
(125, 'post', 14, 'meta_title', 'Dịch vụ tạo trang cá nhân, CV online miễn phí hosting và tên miền | Web 1-0-2 | VCC.VN'),
(126, 'post', 14, 'meta_description', NULL),
(127, 'post', 14, 'feature_image_keep_original', NULL),
(128, 'post', 14, 'service_id', '3'),
(129, 'post', 14, 'og_image_width', '276'),
(130, 'post', 14, 'og_image_height', '276'),
(131, 'post', 15, 'custom_slug', NULL),
(132, 'post', 15, 'meta_title', 'Dịch vụ tạo website doanh nghiệp miễn phí hosting và tên miền | Web 1-0-2 | VCC.VN'),
(133, 'post', 15, 'meta_description', NULL),
(134, 'post', 15, 'feature_image_keep_original', NULL),
(135, 'post', 15, 'service_id', '4'),
(136, 'post', 15, 'og_image_width', '600'),
(137, 'post', 15, 'og_image_height', '315'),
(138, 'post', 16, 'custom_slug', NULL),
(139, 'post', 16, 'meta_title', NULL),
(140, 'post', 16, 'meta_description', NULL),
(141, 'post', 16, 'feature_image_keep_original', NULL),
(142, 'post', 16, 'service_id', '5'),
(143, 'post', 16, 'og_image_width', '276'),
(144, 'post', 16, 'og_image_height', '276'),
(145, 'post', 17, 'custom_slug', NULL),
(146, 'post', 17, 'meta_title', 'Dịch vụ tạo trang web bán hàng miễn phí với hệ thống Web 1-0-2 | VCC.VN'),
(147, 'post', 17, 'meta_description', NULL),
(148, 'post', 17, 'feature_image_keep_original', NULL),
(149, 'post', 17, 'service_id', '6'),
(150, 'post', 17, 'og_image_width', '276'),
(151, 'post', 17, 'og_image_height', '276'),
(152, 'user_services', 1, 'domain', 'chinhlatoi.vn'),
(153, 'user_services', 1, 'subdomain', '124055'),
(154, 'user_services', 1, 'alias_domain', NULL),
(155, 'user_services', 2, 'domain', 'chinhlatoi.vn'),
(156, 'user_services', 2, 'subdomain', 'doandt'),
(157, 'user_services', 2, 'alias_domain', NULL),
(158, 'user_services', 3, 'domain', 'chinhlatoi.com'),
(159, 'user_services', 3, 'subdomain', '12345'),
(160, 'user_services', 3, 'alias_domain', 'moondental1.vn'),
(161, 'user_services', 4, 'domain', 'chinhlatoi.com'),
(162, 'user_services', 4, 'subdomain', 'mua123'),
(163, 'user_services', 4, 'alias_domain', NULL),
(164, 'user_services', 5, 'domain', 'chinhlatoi.vn'),
(165, 'user_services', 5, 'subdomain', '123456'),
(166, 'user_services', 5, 'alias_domain', NULL),
(167, 'user_services', 6, 'domain', 'vcc.vn'),
(168, 'user_services', 6, 'subdomain', 'doanln12'),
(169, 'user_services', 6, 'alias_domain', NULL),
(170, 'user_services', 7, 'domain', 'chinhlatoi.vn'),
(171, 'user_services', 7, 'subdomain', '3455'),
(172, 'user_services', 7, 'alias_domain', NULL),
(173, 'user_services', 8, 'domain', 'chinhlatoi.vn'),
(174, 'user_services', 8, 'subdomain', '12356'),
(175, 'user_services', 8, 'alias_domain', NULL),
(176, 'user_services', 9, 'domain', 'chinhlatoi.vn'),
(177, 'user_services', 9, 'subdomain', 'doanlnc'),
(178, 'user_services', 9, 'alias_domain', NULL),
(179, 'user_services', 10, 'domain', 'vcc.vn'),
(180, 'user_services', 10, 'subdomain', 'hieuvm'),
(181, 'user_services', 10, 'alias_domain', NULL),
(182, 'user_services', 11, 'domain', 'chinhlatoi.com'),
(183, 'user_services', 11, 'subdomain', 'doanln1'),
(184, 'user_services', 11, 'alias_domain', NULL),
(185, 'user_services', 12, 'domain', 'chinhlatoi.vn'),
(186, 'user_services', 12, 'subdomain', 'ledoan'),
(187, 'user_services', 12, 'alias_domain', NULL),
(188, 'user_services', 13, 'domain', 'vcc.vn'),
(189, 'user_services', 13, 'subdomain', 'trangdinh'),
(190, 'user_services', 13, 'alias_domain', NULL),
(191, 'post', 18, 'custom_slug', NULL),
(192, 'post', 18, 'meta_title', NULL),
(193, 'post', 18, 'meta_description', NULL),
(194, 'post', 18, 'feature_image_keep_original', NULL),
(195, 'post', 18, 'og_image_width', '276'),
(196, 'post', 18, 'og_image_height', '276'),
(197, 'user_services', 14, 'domain', 'chinhlatoi.com'),
(198, 'user_services', 14, 'subdomain', 'anhtuan'),
(199, 'user_services', 14, 'alias_domain', NULL),
(200, 'user_services', 15, 'domain', 'chinhlatoi.vn');
INSERT INTO `metadatas` (`id`, `ref`, `ref_id`, `name`, `value`) VALUES
(201, 'user_services', 15, 'subdomain', 'lengocdoan'),
(202, 'user_services', 15, 'alias_domain', NULL),
(203, 'user_services', 16, 'domain', 'chinhlatoi.vn'),
(204, 'user_services', 16, 'subdomain', 'doanln16'),
(205, 'user_services', 16, 'alias_domain', NULL),
(206, 'user_services', 17, 'domain', 'chinhlatoi.vn'),
(207, 'user_services', 17, 'subdomain', 'levantung'),
(208, 'user_services', 17, 'alias_domain', NULL),
(209, 'user_services', 18, 'domain', 'vcc.vn'),
(210, 'user_services', 18, 'subdomain', 'hoang'),
(211, 'user_services', 18, 'alias_domain', NULL),
(212, 'user_services', 19, 'domain', 'chinhlatoi.vn'),
(213, 'user_services', 19, 'subdomain', 'tungle'),
(214, 'user_services', 19, 'alias_domain', NULL),
(215, 'user_services', 20, 'domain', 'vcc.vn'),
(216, 'user_services', 20, 'subdomain', 'tiennv'),
(217, 'user_services', 20, 'alias_domain', NULL);
INSERT INTO `metadatas` (`id`, `ref`, `ref_id`, `name`, `value`) VALUES
(218, 'theme', 4, 'components', '{\"banners.search\":{\"name\":\"Banner: Search\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"button_text\":{\"type\":\"text\",\"label\":\"N\\u00fat T\\u00ecm ki\\u1ebfm\",\"placeholder\":\"V\\u00ed d\\u1ee5: T\\u00ecm ki\\u1ebfm\"}},\"path\":\"banners.search\"},\"banners.service-add\":{\"name\":\"Banner: Add service\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"comment\":{\"type\":\"textarea\",\"label\":\"Ch\\u00fa th\\u00edch\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"create_button\":{\"type\":\"text\",\"label\":\"N\\u00fat kh\\u1edfi t\\u1ea1o\",\"placeholder\":\"V\\u00ed d\\u1ee5: T\\u1ea1o website\"}},\"path\":\"banners.service-add\"},\"banners.slider\":{\"name\":\"Banner: Slider\",\"inputs\":{\"slider_id\":{\"type\":\"crazyselect\",\"label\":\"Slider\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"call\":\"get_slider_options\"},\"btn_text\":{\"type\":\"text\",\"label\":\"N\\u00fat b\\u1ea5m\",\"placeholder\":\"Ch\\u1eef s\\u1ebd \\u0111\\u01b0\\u1ee3c hi\\u1ec3n th\\u1ecb tr\\u00ean n\\u00fat xem th\\u00eam\"},\"address\":{\"type\":\"text\",\"Label\":\"\\u0110\\u1ecba ch\\u1ec9\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin li\\u00ean h\\u1ec7\"},\"phone_number\":{\"type\":\"text\",\"Label\":\"S\\u1ed1 \\u0111i\\u1ec7n tho\\u1ea1i\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin li\\u00ean h\\u1ec7\"},\"email\":{\"type\":\"text\",\"Label\":\"Email\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin li\\u00ean h\\u1ec7\"}},\"path\":\"banners.slider\"},\"banners.support\":{\"name\":\"Banner: Support\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"button_text\":{\"type\":\"text\",\"label\":\"N\\u00fat T\\u00ecm ki\\u1ebfm\",\"placeholder\":\"V\\u00ed d\\u1ee5: T\\u00ecm ki\\u1ebfm\"}},\"path\":\"banners.support\"},\"contacts\":{\"name\":\"M\\u1ee5c Li\\u00ean h\\u1ec7\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"Li\\u00ean h\\u1ec7 ch\\u00fang t\\u00f4i\"},\"button_text\":{\"type\":\"text\",\"label\":\"N\\u00fat g\\u1eedi\",\"value\":\"G\\u1eedi li\\u00ean h\\u1ec7\"}},\"path\":\"contacts\"},\"docs.docbody.area\":{\"name\":\"Document Area\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"boder_bottom\":{\"type\":\"switch\",\"label\":\"Border\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb border bottom\"}},\"path\":\"docs.docbody.area\"},\"docs.docbody.item\":{\"name\":\"Document Item\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"link\":{\"type\":\"text\",\"label\":\"\\u0110\\u01b0\\u1eddng d\\u1eabn\",\"placeholder\":\"Nh\\u1eadp li\\u00ean k\\u1ebft\"},\"img_icon\":{\"type\":\"file\",\"label\":\"Icon (file \\u1ea3nh)\"}},\"path\":\"docs.docbody.item\"},\"docs.get-started\":{\"name\":\"Get Started\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"boder_bottom\":{\"type\":\"switch\",\"label\":\"Border\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb border bottom\"}},\"path\":\"docs.get-started\"},\"docs.section\":{\"name\":\"Section\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"content\":{\"type\":\"textarea\",\"label\":\"N\\u1ed9i dung\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"boder_bottom\":{\"type\":\"switch\",\"label\":\"Border\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb border bottom\"}},\"path\":\"docs.section\"},\"docs.tabs.area\":{\"name\":\"Tabs\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"boder_bottom\":{\"type\":\"switch\",\"label\":\"Border\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb border bottom\"}},\"path\":\"docs.tabs.area\"},\"docs.tabs.item\":{\"name\":\"Tab Item\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"active\":{\"type\":\"switch\",\"label\":\"K\\u00edch ho\\u1ea1t\",\"value_type\":\"boolean\",\"check_label\":\"K\\u00edch ho\\u1ea1t hi\\u1ec3n th\\u1ecb tap m\\u1eb7c \\u0111\\u1ecbnh\"},\"content\":{\"type\":\"textarea\",\"label\":\"N\\u1ed9i dung (H\\u1ed7 tr\\u1ee3 HTML)\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"}},\"path\":\"docs.tabs.item\"},\"dynamic-settings\":{\"name\":\"Thi\\u1ebft l\\u1eadp m\\u1ee5c \\u0111\\u0103ng b\\u00e0i\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 Thi\\u1ebft l\\u1eadp (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"select\",\"label\":\"M\\u1ee5c \\u0111\\u0103ng b\\u00e0i\",\"call\":\"get_dynamic_options\"},\"dynamic_type\":{\"type\":\"select\",\"label\":\"Lo\\u1ea1i m\\u1ee5c\",\"data\":{\"post\":\"Tin b\\u00e0i\",\"documentation\":\"T\\u00e0i li\\u1ec7u\",\"forum\":\"Forum\"}},\"mobile_menu_id\":{\"type\":\"select\",\"label\":\"Menu tr\\u00ean mobile\",\"call\":\"get_menu_options\"},\"sidebar_menu_id\":{\"type\":\"select\",\"label\":\"Menu cho t\\u00e0i li\\u1ec7u\",\"call\":\"get_menu_options\"},\"header_style\":{\"type\":\"radio\",\"label\":\"Header Style m\\u1eb7c \\u0111\\u1ecbnh\",\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\",\"3\":\"Style 3\"},\"default\":\"2\"},\"show_breadcrumb\":{\"type\":\"switch\",\"label\":\"Breadcrumb\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb breadcrumb\"},\"list_layout\":{\"type\":\"radio\",\"label\":\"Layout Danh s\\u00e1ch\",\"data\":{\"sidebar\":\"sidebar\",\"fullwidth\":\"fullwidth\"},\"default\":\"sidebar\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u Danh s\\u00e1ch\",\"data\":{\"list\":\"Danh s\\u00e1ch (list)\",\"grid\":\"L\\u01b0\\u1edbi (grid)\"},\"default\":\"grid\"},\"header_bg_default_color\":{\"type\":\"radio\",\"label\":\"M\\u00e0u c\\u00f3 s\\u1eb5n\",\"data\":{\"\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}},\"header_bg_color\":{\"type\":\"text\",\"label\":\"M\\u00e3 m\\u00e0u (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"},\"header_use_bg_image\":{\"type\":\"switch\",\"label\":\"S\\u1eed d\\u1ee5ng h\\u00ecnh n\\u1ec1n\",\"value_type\":\"boolean\",\"check_label\":\"C\\u00f3\"},\"header_bg_image\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"header_bg_position\":{\"type\":\"radio\",\"label\":\"V\\u1ecb tr\\u00ed \\u1ea3nh\",\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}},\"header_class_name\":{\"type\":\"text\",\"label\":\"Class (T\\u00f9y ch\\u1ecdn)\"},\"detail_use_feature_image\":{\"type\":\"switch\",\"label\":\"Header Image\",\"value_type\":\"boolean\",\"check_label\":\"S\\u1eed d\\u1ee5ng Feature Image l\\u00e0m h\\u00ecnh n\\u1ec1n Header\"},\"detail_hide_feature_image\":{\"type\":\"switch\",\"label\":\"Hide Feature Image\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n \\u1ea3nh n\\u1ed5i b\\u1eadt tr\\u00ean ph\\u1ea7n \\u0111\\u1ea7u n\\u1ed9i dung\"},\"detail_hide_meta\":{\"type\":\"switch\",\"label\":\"Hide Meta\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n th\\u00f4ng tin meta\"},\"detail_hide_related\":{\"type\":\"switch\",\"label\":\"Hide related\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n m\\u1ee5c li\\u00ean quan\"},\"detail_hide_comments\":{\"type\":\"switch\",\"label\":\"Hide Comments\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n ph\\u1ea7n b\\u00ecnh lu\\u1eadn\"}},\"config\":{\"name\":\"Thi\\u1ebft l\\u1eadp m\\u1ee5c \\u0111\\u0103ng b\\u00e0i\",\"layout_type\":\"single\",\"form_groups\":{\"general\":{\"title\":\"Thi\\u1ebft l\\u1eadp chung\",\"inputs\":[\"title\",\"dynamic_id\",\"dynamic_type\",\"list_layout\",\"list_type\"]},\"page_header\":{\"title\":\"Thi\\u1ebft l\\u1eadp Page Header\",\"inputs\":[\"header_style\",\"show_breadcrumb\",\"header_bg_default_color\",\"header_bg_color\",\"header_use_bg_image\",\"header_bg_image\",\"header_bg_position\",\"header_class_name\"]},\"detail\":{\"title\":\"Thi\\u1ebft l\\u1eadp Trang chi ti\\u1ebft \",\"inputs\":[\"detail_use_feature_image\",\"detail_hide_feature_image\",\"detail_hide_meta\",\"detail_hide_related\",\"detail_hide_comments\"]}}},\"path\":\"dynamic-settings\"},\"footer.about\":{\"name\":\"Footer Widget: About\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u00e2u h\\u1ecfi (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"N\\u1ed9i dung\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"email\":{\"type\":\"text\",\"Label\":\"Email\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin li\\u00ean h\\u1ec7\"},\"phone_number\":{\"type\":\"text\",\"Label\":\"S\\u1ed1 \\u0111i\\u1ec7n tho\\u1ea1i\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin li\\u00ean h\\u1ec7\"},\"address\":{\"type\":\"text\",\"Label\":\"\\u0110\\u1ecba ch\\u1ec9\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin li\\u00ean h\\u1ec7\"},\"col_xs\":{\"type\":\"crazyselect\",\"label\":\"col (col-xs)\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":12},\"col_sm\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":12},\"col_md\":{\"type\":\"crazyselect\",\"label\":\"col-md\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":6},\"col_lg\":{\"type\":\"crazyselect\",\"label\":\"col-lg\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4},\"col_xl\":{\"type\":\"crazyselect\",\"label\":\"col-xl\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4}},\"path\":\"footer.about\"},\"footer.links\":{\"name\":\"Footer Widget: Links\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"placeholder\":\"v\\u00ed d\\u1ee5 Li\\u00ean k\\u1ebft\"},\"menu_id\":{\"type\":\"crazyselect\",\"label\":\"Menu\",\"call\":\"get_menu_options\"},\"col_sm\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":\"6\"},\"col_lg\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":3}},\"data\":{\"menu_id\":0,\"title\":\"Li\\u00ean k\\u1ebft\"},\"path\":\"footer.links\"},\"footer.posts\":{\"name\":\"Footer Widget: Danh s\\u00e1ch b\\u00e0i vi\\u1ebft\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":3},\"col_xs\":{\"type\":\"crazyselect\",\"label\":\"col (col-xs)\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":12},\"col_sm\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":12},\"col_md\":{\"type\":\"crazyselect\",\"label\":\"col-md\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":6},\"col_lg\":{\"type\":\"crazyselect\",\"label\":\"col-lg\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4},\"col_xl\":{\"type\":\"crazyselect\",\"label\":\"col-xl\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4}},\"path\":\"footer.posts\"},\"footer.subscribe\":{\"name\":\"Footer Widget: \\u0110\\u0103ng k\\u00fd theo d\\u00f5i\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u00e2u h\\u1ecfi (T\\u00f9y ch\\u1ecdn)\"},\"subscribe_button\":{\"type\":\"text\",\"label\":\"N\\u00fat \\u0110\\u0103ng k\\u00fd\"},\"col_sm\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":\"6\"},\"col_lg\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4}},\"path\":\"footer.subscribe\"},\"footer.tags\":{\"name\":\"Footer Widget: Th\\u1ebb b\\u00e0i vi\\u1ebft (tags)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ea7n Tags\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_tag_sortby_options\"},\"tag_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10},\"social_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ea7n MXH\"},\"col_xs\":{\"type\":\"crazyselect\",\"label\":\"col (col-xs)\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":12},\"col_sm\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":12},\"col_md\":{\"type\":\"crazyselect\",\"label\":\"col-md\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":6},\"col_lg\":{\"type\":\"crazyselect\",\"label\":\"col-lg\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4},\"col_xl\":{\"type\":\"crazyselect\",\"label\":\"col-xl\",\"data\":{\"\":\"Kh\\u00f4ng\",\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4}},\"path\":\"footer.tags\"},\"help.area\":{\"name\":\"Help: Area\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"boder_bottom\":{\"type\":\"switch\",\"label\":\"Border\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb border bottom\"}},\"path\":\"help.area\"},\"help.item\":{\"name\":\"Help: Item\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"link\":{\"type\":\"text\",\"label\":\"\\u0110\\u01b0\\u1eddng d\\u1eabn\",\"placeholder\":\"Nh\\u1eadp li\\u00ean k\\u1ebft\"}},\"path\":\"help.item\"},\"home.post-and-categories\":{\"name\":\"Home: Danh m\\u1ee5c v\\u00e0 tin b\\u00e0i\",\"inputs\":{\"cate_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"cate_parent_id\"},\"cate_parent_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c Cha\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#cate_dynamic_id\"},true],\"@label-type\":\"value\"},\"cate_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"list_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 list (T\\u00f9y ch\\u1ecdn)\"},\"list_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c tin b\\u00e0i \\u1edf list (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"list_category_id\",\"required\":\"true\"},\"list_category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c \\u1edf list (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#list_dynamic_id\"},true],\"@label-type\":\"value\"},\"list_group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c (trong list)\",\"value_type\":\"boolean\"},\"list_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp (trong list)\",\"call\":\"get_post_sortby_options\"},\"list_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i (trong list)\",\"min\":1,\"step\":1,\"default\":12}},\"path\":\"home.post-and-categories\"},\"home.post-banner-slider\":{\"name\":\"Home: Post Banner Slider\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":5}},\"path\":\"home.post-banner-slider\"},\"home.post-slider\":{\"name\":\"Home: Slider b\\u00e0i vi\\u1ebft\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":12}},\"path\":\"home.post-slider\"},\"home.post-tabs.style-1\":{\"name\":\"Home: Tab Trending Slider (Style 1)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"cate_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp Danh m\\u1ee5c\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c con\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":12},\"sidebar_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 sidebar (T\\u00f9y ch\\u1ecdn)\"},\"sidebar_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c tin b\\u00e0i \\u1edf sidebar (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"sidebar_category_id\",\"required\":\"true\"},\"sidebar_category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c \\u1edf sidebar (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#sidebar_dynamic_id\"},true],\"@label-type\":\"value\"},\"sidebar_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp \\u1edf sidebar\",\"call\":\"get_post_sortby_options\"},\"sidebar_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i \\u1edf sidebar\",\"min\":1,\"step\":1,\"default\":5}},\"path\":\"home.post-tabs.style-1\"},\"home.post-tabs.style-2\":{\"name\":\"Home: Tab list Slider (Style 2)\",\"inputs\":{\"slider_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 slider (T\\u00f9y ch\\u1ecdn)\"},\"slider_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c tin b\\u00e0i slider (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"slider_category_id\",\"required\":\"true\"},\"slider_category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c slider (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#slider_dynamic_id\"},true],\"@label-type\":\"value\"},\"slider_cate_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp Danh m\\u1ee5c\",\"call\":\"get_post_category_sortby_options\"},\"slider_cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c con\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"slider_group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"slider_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp slider\",\"call\":\"get_post_sortby_options\"},\"slider_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i slider\",\"min\":1,\"step\":1,\"default\":25},\"list_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 list (T\\u00f9y ch\\u1ecdn)\"},\"list_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c tin b\\u00e0i \\u1edf list (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"list_category_id\",\"required\":\"true\"},\"list_category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c \\u1edf list (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#list_dynamic_id\"},true],\"@label-type\":\"value\"},\"list_group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c (trong list)\",\"value_type\":\"boolean\"},\"list_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp (trong list)\",\"call\":\"get_post_sortby_options\"},\"list_post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i (trong list)\",\"min\":1,\"step\":1,\"default\":25},\"social_show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb Li\\u00ean k\\u1ebft MXH\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb\"},\"social_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 social (T\\u00f9y ch\\u1ecdn)\"},\"cate_show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb Danhh m\\u1ee5c\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb\"},\"cate_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 Ph\\u1ea7n danh m\\u1ee5c (T\\u00f9y ch\\u1ecdn)\"},\"cate_dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"cate_parent_id\"},\"cate_parent_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c Cha\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#cate_dynamic_id\"},true],\"@label-type\":\"value\"},\"cate_sort\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"newsletter_show\":{\"type\":\"switch\",\"label\":\"Hi\\u1ec3n th\\u1ecb \\u0111\\u0103ng k\\u00fd theo d\\u00f5i\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb\"},\"newsletter_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 m\\u1ee5c \\u0111\\u0103ng k\\u00fd (T\\u00f9y ch\\u1ecdn)\"},\"newsletter_description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 m\\u1ee5c \\u0111\\u0103ng k\\u00fd\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"newsletter_button\":{\"type\":\"text\",\"label\":\"N\\u00fat \\u0110\\u0103ng k\\u00fd\"}},\"path\":\"home.post-tabs.style-2\"},\"home.post-tabs.style-3\":{\"name\":\"Home: Tab Slider (Style 3)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"cate_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp Danh m\\u1ee5c\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c con\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":12}},\"path\":\"home.post-tabs.style-3\"},\"home.post-tabs.style-4\":{\"name\":\"Home: Tab Slider (Style 4)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"cate_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp Danh m\\u1ee5c\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c con\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":12}},\"path\":\"home.post-tabs.style-4\"},\"home.post-tabs.style-5\":{\"name\":\"Home: Tab Grid (Style 5)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"cate_sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp Danh m\\u1ee5c\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c con\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":36}},\"path\":\"home.post-tabs.style-5\"},\"home.videos.style-1\":{\"name\":\"Home: Video Slider Style 1\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":15}},\"path\":\"home.videos.style-1\"},\"home.videos.style-2\":{\"name\":\"Home: Video Slider Style 2\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":15}},\"path\":\"home.videos.style-2\"},\"phone-ring\":{\"name\":\"N\\u00fat g\\u1ecdi ngay\",\"inputs\":{\"Hotline\":{\"type\":\"text\",\"Label\":\"Hotline\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp Li\\u00ean h\\u1ec7\"},\"call_text\":{\"type\":\"text\",\"Label\":\"Text m\\u1eddi g\\u1ecdi\",\"placeholder\":\"v\\u00ed d\\u1ee5: G\\u1ecdi \\u0111i\\u1ec7n tho\\u1ea1i\"}},\"path\":\"phone-ring\"},\"posts\":{\"name\":\"Danh s\\u00e1ch b\\u00e0i vi\\u1ebft\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"group_by_category\":{\"type\":\"switch\",\"label\":\"Nh\\u00f3m theo danh m\\u1ee5c\",\"value_type\":\"boolean\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":3},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft (t\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp li\\u00ean k\\u1ebft. (Kh\\u00f4ng b\\u1eaft bu\\u1ed9c)\"},\"bg_default_color\":{\"type\":\"radio\",\"label\":\"M\\u00e0u c\\u00f3 s\\u1eb5n\",\"data\":{\"\":\"Kh\\u00f4ng\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}},\"bg_color\":{\"type\":\"text\",\"label\":\"M\\u00e3 m\\u00e0u (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"},\"bg_image\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"bg_position\":{\"type\":\"radio\",\"label\":\"V\\u1ecb tr\\u00ed \\u1ea3nh\",\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}},\"bg_half\":{\"type\":\"switch\",\"label\":\"Bg Half\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb m\\u1ed9t n\\u1eeda h\\u00ecnh n\\u1ec1n\",\"value_type\":\"boolean\"},\"advance\":{\"type\":\"checklist\",\"label\":\"N\\u00e2ng cao\",\"data\":{\"shadow\":\"shadow\",\"dark\":\"dark\",\"dark-hard\":\"dark-hard\",\"light\":\"light\",\"theme\":\"theme\",\"theme-hard\":\"theme-hard\"}},\"class_name\":{\"type\":\"text\",\"label\":\"Class (T\\u00f9y ch\\u1ecdn)\"}},\"path\":\"posts\"},\"projects\":{\"name\":\"D\\u1ef1 \\u00e1n\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"D\\u1ef1 \\u00e1n\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5\"},\"sorttype\":{\"type\":\"crazyselect\",\"label\":\"Ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_project_sortby_options\",\"value\":1},\"project_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":10}},\"path\":\"projects\"},\"question-subcribe\":{\"name\":\"C\\u00e2u h\\u1ecfi v\\u00e0 \\u0111\\u0103ng k\\u00fd theo d\\u00f5i\",\"inputs\":{\"question_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 c\\u00e2u h\\u1ecfi (T\\u00f9y ch\\u1ecdn)\"},\"question_description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 ph\\u1ea7n c\\u00e2u h\\u1ecfi\",\"placeholder\":\"M\\u00f4 t\\u1ea3 ph\\u1ea7n c\\u00e2u h\\u1ecfi. Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"subcribe_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 theo d\\u00f5i (T\\u00f9y ch\\u1ecdn)\"},\"subcribe_description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 theo d\\u00f5i\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"policy_link\":{\"type\":\"text\",\"label\":\"\\u0110\\u01b0\\u1eddng d\\u1eabn ch\\u00ednh s\\u00e1ch b\\u1ea3o m\\u1eadt\",\"placeholder\":\"Nh\\u1eadp li\\u00ean k\\u1ebft\"},\"boder_bottom\":{\"type\":\"switch\",\"label\":\"Border\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb border bottom\"}},\"path\":\"question-subcribe\"},\"quote\":{\"name\":\"Quotes - Tr\\u00edch d\\u1eabn\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"description\":{\"type\":\"textarea\",\"label\":\"N\\u1ed9i dung\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"show_quote\":{\"type\":\"switch\",\"label\":\"\\u0110\\u00e1nh d\\u1ea5u\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb \\u0110\\u00e1nh d\\u1ea5u tr\\u00edch d\\u1eabn\"},\"image\":{\"type\":\"file\",\"label\":\"\\u1ea2nh n\\u1ed5i b\\u1eadt\"},\"light_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ch\\u00ecm (T\\u00f9y ch\\u1ecdn)\"},\"show_author\":{\"type\":\"switch\",\"label\":\"t\\u00e1c gi\\u1ea3\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb Th\\u00f4ng tin t\\u00e1c gi\\u1ea3\"},\"author_name\":{\"type\":\"text\",\"label\":\"T\\u00ean\"},\"author_job\":{\"type\":\"text\",\"label\":\"C\\u00f4ng vi\\u1ec7c\"},\"author_link\":{\"type\":\"text\",\"label\":\"li\\u00ean k\\u1ebft (T\\u00f9y ch\\u1ecdn)\"}},\"path\":\"quote\"},\"service-pricing\":{\"name\":\"B\\u1ea3ng gi\\u00e1 d\\u1ecbch v\\u1ee5\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"sub_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 ph\\u1ee5\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"service_id\":{\"type\":\"checklist\",\"label\":\"C\\u00e1c g\\u00f3i d\\u1ecbch v\\u1ee5\",\"call\":\"get_service_options\"},\"active_type\":{\"type\":\"select\",\"label\":\"K\\u00edch ho\\u1ea1t theo lo\\u1ea1i\",\"call\":\"get_service_package_type_options\"}},\"path\":\"service-pricing\"},\"services\":{\"path\":\"services\",\"name\":\"services\"},\"services.area\":{\"name\":\"C\\u00e1c d\\u1ecbch v\\u1ee5 (service area)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c \\u0111\\u0103ng d\\u1ecbch v\\u1ee5 (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft (t\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp li\\u00ean k\\u1ebft. (Kh\\u00f4ng b\\u1eaft bu\\u1ed9c)\"}},\"path\":\"services.area\"},\"services.item\":{\"name\":\"Chi ti\\u1ebft d\\u1ecbch v\\u1ee5 (Service item)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"url\":{\"type\":\"text\",\"label\":\"\\u0110\\u01b0\\u1eddng d\\u1eabn\",\"placeholder\":\"Nh\\u1eadp li\\u00ean k\\u1ebft\"},\"img_icon\":{\"type\":\"file\",\"label\":\"Icon (file \\u1ea3nh)\"},\"col_sm\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":\"6\"},\"col_lg\":{\"type\":\"crazyselect\",\"label\":\"col-sm\",\"data\":{\"1\":\"1 \\/ 12\",\"2\":\"2 \\/ 12\",\"3\":\"3 \\/ 12\",\"4\":\"4 \\/ 12\",\"5\":\"5 \\/ 12\",\"6\":\"6 \\/ 12\",\"7\":\"7 \\/ 12\",\"8\":\"8 \\/ 12\",\"9\":\"9 \\/ 12\",\"10\":\"10 \\/ 12\",\"11\":\"11 \\/ 12\",\"12\":\"12 \\/ 12\"},\"default\":4}},\"path\":\"services.item\"},\"settings\\/pages.viee\":{\"path\":\"settings\\/pages.viee\",\"name\":\"settings\\/pages : viee\"},\"sidebar.categories\":{\"name\":\"Sidebar: Danh m\\u1ee5c\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"get_by_dynamic_active\":{\"type\":\"switch\",\"label\":\"\\u01afu ti\\u00ean m\\u1ee5c \\u0111ang xem\",\"value_type\":\"boolean\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"data-ref\":\"parent_id\"},\"parent_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c Cha\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10}},\"path\":\"sidebar.categories\"},\"sidebar.comments\":{\"name\":\"Sidebar: Danh s\\u00e1ch b\\u00ecnh lu\\u1eadn\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"placeholder\":\"V\\u00ed d\\u1ee5 comment m\\u1edbi nh\\u1ea5t\"},\"ref\":{\"type\":\"crazyselect\",\"label\":\"m\\u1ee5c l\\u1ea5y b\\u00ecnh lu\\u1eadn\",\"call\":\"get_comment_ref_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"number_comment\":{\"type\":\"number\",\"label\":\"S\\u1ed1 b\\u00ecnh lu\\u1eadn hi\\u1ec3n th\\u1ecb\",\"mim\":1,\"step\":1,\"max\":10}},\"data\":{\"title\":\"B\\u00ecnh lu\\u1eadn m\\u1edbi nh\\u1ea5t\",\"number_comment\":5},\"path\":\"sidebar.comments\"},\"sidebar.posts\":{\"name\":\"Sidebar: Danh s\\u00e1ch tin b\\u00e0i\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"default\":\"Tin m\\u1edbi nh\\u1ea5t\"},\"dynamic_id\":{\"type\":\"crazyselect\",\"label\":\"M\\u1ee5c (t\\u00f9y ch\\u1ecdn)\",\"template\":\"crazyselect\",\"call\":\"get_dynamic_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"],\"@change\":\"Crazy.posts.changeDynamicID\",\"required\":\"true\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_post_category_options\",\"params\":[{\"dynamic_id\":\"#dynamic_id\"},true],\"@label-type\":\"value\"},\"content_type\":{\"type\":\"radio\",\"label\":\"Lo\\u1ea1i n\\u1ed9i dung\",\"call\":\"get_content_type_options\",\"params\":[\"T\\u1ea5t c\\u1ea3\"]},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_post_sortby_options\"},\"post_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}},\"path\":\"sidebar.posts\"},\"sidebar.project-categories\":{\"name\":\"Sidebar: Danh m\\u1ee5c D\\u1ef1 \\u00e1n\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"parent_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c Cha\",\"template\":\"crazyselect\",\"call\":\"get_project_category_options\",\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_project_category_sortby_options\"},\"cate_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng danh m\\u1ee5c\",\"min\":1,\"step\":1,\"valudate\":\"number|min:1\",\"default\":10}},\"path\":\"sidebar.project-categories\"},\"sidebar.projects\":{\"name\":\"Sidebar: Danh s\\u00e1ch d\\u1ef1 \\u00e1n\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\",\"default\":\"C\\u00e1c d\\u1ef1 \\u00e1n\"},\"category_id\":{\"type\":\"crazyselect\",\"label\":\"Danh m\\u1ee5c\",\"template\":\"crazyselect\",\"call\":\"get_project_category_options\",\"@label-type\":\"value\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_project_sortby_options\"},\"project_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 d\\u1ef1 \\u00e1n\",\"min\":1,\"step\":1,\"default\":10}},\"path\":\"sidebar.projects\"},\"sidebar.subcribe\":{\"name\":\"Sidebar: \\u0110\\u0103ng k\\u00fd theo d\\u00f5i\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 theo d\\u00f5i\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"}},\"path\":\"sidebar.subcribe\"},\"sidebar.tags\":{\"name\":\"Sidebar: Th\\u1ebb b\\u00e0i vi\\u1ebft (tags)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\"},\"sorttype\":{\"type\":\"select\",\"label\":\"ki\\u1ec3u s\\u1eafp x\\u1ebfp\",\"call\":\"get_tag_sortby_options\"},\"tag_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 tin b\\u00e0i\",\"min\":1,\"step\":1,\"default\":10}},\"path\":\"sidebar.tags\"},\"team.area\":{\"name\":\"Home: Team (area)\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u danh s\\u00e1ch\",\"data\":{\"data\":\"Trong b\\u1ea3ng Nh\\u00f3m\",\"custom\":\"Danh s\\u00e1ch t\\u00f9y bi\\u1ebfn\"},\"value\":\"custom\"},\"team_id\":{\"type\":\"crazyselect\",\"label\":\"Nh\\u00f3m\",\"call\":\"get_team_options\",\"params\":[[],\"Ch\\u1ecdn nh\\u00f3m\"]},\"item_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":4},\"sort_type\":{\"type\":\"crazyselect\",\"label\":\"S\\u1eafp x\\u1ebfp\",\"data\":{\"id-ASC\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"id-DESC\":\"M\\u1edbi nh\\u1ea5t\",\"users.name-ASC\":\"th\\u1ee9 t\\u1ef1 b\\u1ea3ng ch\\u1ef1 c\\u00e1i\",\"is_leader-DESC\":\"\\u01afu ti\\u00ean tr\\u01b0\\u1edfng nh\\u00f3m\",\"job-ASC\":\"C\\u00f4ng vi\\u1ec7c (A-z)\",\"rand()\":\"Ng\\u1eabu nhi\\u00ean\"},\"value\":\"id-ASC\"},\"bg_default_color\":{\"type\":\"radio\",\"label\":\"M\\u00e0u c\\u00f3 s\\u1eb5n\",\"data\":{\"\":\"Kh\\u00f4ng\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}},\"bg_color\":{\"type\":\"text\",\"label\":\"M\\u00e3 m\\u00e0u (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"},\"bg_image\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"bg_position\":{\"type\":\"radio\",\"label\":\"V\\u1ecb tr\\u00ed \\u1ea3nh\",\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}},\"bg_half\":{\"type\":\"switch\",\"label\":\"Bg Half\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb m\\u1ed9t n\\u1eeda h\\u00ecnh n\\u1ec1n\",\"value_type\":\"boolean\"},\"advance\":{\"type\":\"checklist\",\"label\":\"N\\u00e2ng cao\",\"data\":{\"shadow\":\"shadow\",\"dark\":\"dark\",\"dark-hard\":\"dark-hard\",\"light\":\"light\",\"theme\":\"theme\",\"theme-hard\":\"theme-hard\"}},\"class_name\":{\"type\":\"text\",\"label\":\"Class (T\\u00f9y ch\\u1ecdn)\"}},\"path\":\"team.area\"},\"team.item\":{\"name\":\"Home: Team Member\",\"inputs\":{\"name\":{\"type\":\"text\",\"label\":\"T\\u00ean th\\u00e0nh vi\\u00ean\",\"placeholder\":\"V\\u00ed d\\u1ee5: Thi\\u1ec7n CH\"},\"avatar\":{\"type\":\"file\",\"label\":\"Avatar\"},\"job\":{\"type\":\"text\",\"label\":\"c\\u00f4ng vi\\u1ec7c (V\\u1ecb tr\\u00ed l\\u00e0m vi\\u1ec7c)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3...\",\"className\":\"auto-height\"},\"is_loader\":{\"type\":\"switch\",\"label\":\"Tr\\u01b0\\u1edfng nh\\u00f3m?\",\"value_type\":\"boolean\"},\"facebook\":{\"type\":\"text\",\"label\":\"facebook (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"twitter\":{\"type\":\"text\",\"label\":\"twitter (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"youtube\":{\"type\":\"text\",\"label\":\"youtube (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"instagram\":{\"type\":\"text\",\"label\":\"instagram (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"linkedin\":{\"type\":\"text\",\"label\":\"Linkedin (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"pinterest\":{\"type\":\"text\",\"label\":\"Pinterest (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}},\"path\":\"team.item\"},\"testimonials.area\":{\"name\":\"Ph\\u1ea3n h\\u1ed3i t\\u1eeb kh\\u00e1ch h\\u00e0ng - Testimonials area\",\"inputs\":{\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1\",\"value\":\"Ph\\u1ea3n h\\u1ed3i t\\u1eeb kh\\u00e1ch h\\u00e0ng\"},\"background\":{\"type\":\"file\",\"Label\":\"H\\u00ecnh n\\u1ec1n\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u danh s\\u00e1ch\",\"data\":{\"data\":\"Trong b\\u1ea3ng ph\\u1ea3n h\\u1ed3i\",\"custom\":\"Danh s\\u00e1ch t\\u00f9y bi\\u1ebfn\"},\"value\":\"custom\"},\"item_number\":{\"type\":\"number\",\"label\":\"S\\u1ed1 l\\u01b0\\u1ee3ng\",\"value\":0},\"sort_type\":{\"type\":\"crazyselect\",\"label\":\"S\\u1eafp x\\u1ebfp\",\"data\":{\"id-ASC\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"id-DESC\":\"M\\u1edbi nh\\u1ea5t\",\"name-ASC\":\"h\\u1ee9 t\\u1ef1 b\\u1ea3ng ch\\u1ef1 c\\u00e1i\"},\"value\":\"id-ASC\"}},\"path\":\"testimonials.area\"},\"testimonials.item\":{\"name\":\"Th\\u00f4ng tin ph\\u1ea3n h\\u1ed3i (Testimonial item)\",\"inputs\":{\"name\":{\"type\":\"text\",\"label\":\"t\\u00ean ng\\u01b0\\u1eddi ph\\u1ea3n h\\u1ed3i\",\"placeholder\":\"V\\u00ed d\\u1ee5: Nguy\\u1ec5n V\\u0103n A\"},\"image\":{\"type\":\"file\",\"label\":\"\\u00c3nh \\u0111\\u1ea1i di\\u1ec7n\"},\"job\":{\"type\":\"text\",\"label\":\"C\\u00f4ng vi\\u1ec7c\",\"placeholder\":\"V\\u00ed d\\u1ee5: CEO\"},\"link\":{\"type\":\"text\",\"label\":\"Li\\u00ean k\\u1ebft (t\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"V\\u00ed d\\u1ee5: http:\\/\\/www.facebook.com\\/LeNgocDoan\"},\"content\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3 ng\\u1eafn\",\"className\":\"auto-height\",\"placeholder\":\"V\\u00ed d\\u1ee5: Very grateful to have found this app. D&L team did a fantastic job...\"}},\"data\":[],\"path\":\"testimonials.item\"}}');
INSERT INTO `metadatas` (`id`, `ref`, `ref_id`, `name`, `value`) VALUES
(219, 'theme', 4, 'options', '{\"title\":\"Docly\",\"groups\":{\"header\":{\"label\":\"Header\",\"inputs\":{\"default_style\":{\"type\":\"radio\",\"label\":\"Style m\\u1eb7c \\u0111\\u1ecbnh\",\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\"},\"default\":\"1\"},\"logo\":{\"type\":\"file\",\"label\":\"Logo\"},\"logo_light\":{\"type\":\"file\",\"label\":\"Logo Tr\\u1eafng (light)\"},\"nav_1_show_button\":{\"type\":\"switch\",\"label\":\"N\\u00fat \\u0111\\u1eb7c bi\\u1ec7t\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb n\\u00fat b\\u1ea5m d\\u1eabn t\\u1edbi url n\\u00e0o \\u0111\\u00f3\"},\"nav_1_button_url\":{\"type\":\"text\",\"label\":\"\\u0110\\u01b0\\u1eddng d\\u1eabn\"},\"nav_1_button_text\":{\"type\":\"text\",\"label\":\"Text hi\\u1ec3n th\\u0129\"},\"nav_2_show_button\":{\"type\":\"switch\",\"label\":\"N\\u00fat \\u0111\\u1eb7c bi\\u1ec7t\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb n\\u00fat b\\u1ea5m d\\u1eabn t\\u1edbi url n\\u00e0o \\u0111\\u00f3\"},\"nav_2_button_url\":{\"type\":\"text\",\"label\":\"\\u0110\\u01b0\\u1eddng d\\u1eabn\"},\"nav_2_button_text\":{\"type\":\"text\",\"label\":\"Text hi\\u1ec3n th\\u0129\"}},\"config\":{\"name\":\"Thi\\u1ebft l\\u1eadp Header\",\"layout_type\":\"list\",\"form_groups\":{\"general\":{\"title\":\"Thi\\u1ebft l\\u1eadp chung cho header\",\"inputs\":[\"default_style\",\"logo\",\"logo_light\"]},\"nav_1\":{\"title\":\"Nav Style 1\",\"inputs\":[\"nav_1_show_button\",\"nav_1_button_url\",\"nav_1_button_text\"]},\"nav_2\":{\"title\":\"Nav Style 2\",\"inputs\":[\"nav_2_show_button\",\"nav_2_button_url\",\"nav_2_button_text\"]}}}},\"footer\":{\"label\":\"Footer\",\"inputs\":{\"copyright\":{\"type\":\"textarea\",\"label\":\"Copyright\"},\"widgets\":{\"type\":\"area\",\"label\":\"Widget\",\"value\":\"docly_footer\",\"@title-by\":\"title\"},\"body_bottom\":{\"type\":\"area\",\"label\":\"Ch\\u00e2n trang\",\"value\":\"body_bottom\",\"@title-by\":\"title\"}}},\"sidebar\":{\"label\":\"Sidebar\",\"inputs\":{\"docs_left_widgets\":{\"type\":\"area\",\"label\":\"Document Left Sidebar Widgets\",\"value\":\"sidebar_docs_left\"},\"docs_right_widgets\":{\"type\":\"area\",\"label\":\"Document Right Sidebar Widgets\",\"value\":\"sidebar_docs_right\"},\"post_sidebar_widgets\":{\"type\":\"area\",\"label\":\"Post Sidebar Widgets\",\"value\":\"sidebar_post\"},\"project_sidebar_widgets\":{\"type\":\"area\",\"label\":\"Project Sidebar Widgets\",\"value\":\"sidebar_project\"},\"page_sidebar_widgets\":{\"type\":\"area\",\"label\":\"Page Sidebar Widgets\",\"value\":\"sidebar_page\"}}},\"home\":{\"label\":\"Trang ch\\u1ee7\",\"inputs\":{\"home\":{\"type\":\"area\",\"label\":\"Th\\u00e0nh ph\\u00e0n trang ch\\u1ee7\",\"value\":\"home\",\"@title-by\":\"title\"},\"home_services\":{\"type\":\"area\",\"label\":\"Danh s\\u00e1ch d\\u1ecbch v\\u1ee5\",\"value\":\"home_services\",\"@title-by\":\"title\"},\"testimonials\":{\"type\":\"area\",\"label\":\"Danh s\\u00e1ch ph\\u1ea3n h\\u1ed3i t\\u00f9y bi\\u1ebfn\",\"value\":\"testimonials\",\"props\":{\"@title-by\":\"name\"}},\"members\":{\"type\":\"area\",\"label\":\"Danh s\\u00e1ch th\\u00e0nh vi\\u00ean t\\u00f9y bi\\u1ebfn\",\"value\":\"team_members\",\"@title-by\":\"name\"}},\"config\":{\"layout_type\":\"single\",\"form_groups\":{\"home\":{\"title\":\"Thi\\u1ebft l\\u1eadp trang ch\\u1ee7 m\\u1eb7c \\u0111\\u1ecbnh\",\"inputs\":[\"home\",\"home_services\",\"testimonials\",\"members\"]}}}},\"posts\":{\"label\":\"B\\u00e0i vi\\u1ebft\",\"inputs\":{\"header_style\":{\"type\":\"radio\",\"label\":\"Header Style m\\u1eb7c \\u0111\\u1ecbnh\",\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\"},\"default\":\"2\"},\"show_breadcrumb\":{\"type\":\"switch\",\"label\":\"Breadcrumb\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb breadcrumb\"},\"list_layout\":{\"type\":\"radio\",\"label\":\"Layout Danh s\\u00e1ch\",\"data\":{\"sidebar\":\"sidebar\",\"fullwidth\":\"fullwidth\"},\"default\":\"sidebar\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u Danh s\\u00e1ch\",\"data\":{\"list\":\"Danh s\\u00e1ch (list)\",\"grid\":\"L\\u01b0\\u1edbi (grid)\"},\"default\":\"grid\"},\"header_bg_default_color\":{\"type\":\"radio\",\"label\":\"M\\u00e0u c\\u00f3 s\\u1eb5n\",\"data\":{\"\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}},\"header_bg_color\":{\"type\":\"text\",\"label\":\"M\\u00e3 m\\u00e0u (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"},\"header_use_bg_image\":{\"type\":\"switch\",\"label\":\"S\\u1eed d\\u1ee5ng h\\u00ecnh n\\u1ec1n\",\"value_type\":\"boolean\",\"check_label\":\"C\\u00f3\"},\"header_bg_image\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"header_bg_position\":{\"type\":\"radio\",\"label\":\"V\\u1ecb tr\\u00ed \\u1ea3nh\",\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}},\"header_class_name\":{\"type\":\"text\",\"label\":\"Class (T\\u00f9y ch\\u1ecdn)\"},\"detail_use_feature_image\":{\"type\":\"switch\",\"label\":\"Header Image\",\"value_type\":\"boolean\",\"check_label\":\"S\\u1eed d\\u1ee5ng Feature Image l\\u00e0m h\\u00ecnh n\\u1ec1n Header\"},\"detail_hide_feature_image\":{\"type\":\"switch\",\"label\":\"Hide Feature Image\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n \\u1ea3nh n\\u1ed5i b\\u1eadt tr\\u00ean ph\\u1ea7n \\u0111\\u1ea7u n\\u1ed9i dung\"},\"detail_hide_meta\":{\"type\":\"switch\",\"label\":\"Hide Meta\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n th\\u00f4ng tin meta\"},\"detail_hide_related\":{\"type\":\"switch\",\"label\":\"Hide related\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n m\\u1ee5c li\\u00ean quan\"},\"detail_hide_comments\":{\"type\":\"switch\",\"label\":\"Hide Comments\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n ph\\u1ea7n b\\u00ecnh lu\\u1eadn\"},\"post_settings\":{\"type\":\"area\",\"label\":\"M\\u1ee5c d\\u01b0\\u1ee3c thi\\u1ebft l\\u1eadp\",\"value\":\"post_settings\",\"@title-by\":\"title\"}},\"config\":{\"name\":\"Thi\\u1ebft l\\u1eadp m\\u1ee5c \\u0111\\u0103ng b\\u00e0i\",\"layout_type\":\"single\",\"form_groups\":{\"page_header\":{\"title\":\"Thi\\u1ebft l\\u1eadp Page Header\",\"inputs\":[\"header_style\",\"show_breadcrumb\",\"header_bg_default_color\",\"header_bg_color\",\"header_use_bg_image\",\"header_bg_image\",\"header_bg_position\",\"header_class_name\"]},\"general\":{\"title\":\"Thi\\u1ebft l\\u1eadp chung\",\"inputs\":[\"list_layout\",\"list_type\"]},\"post_settings\":{\"title\":\"Thi\\u1ebft l\\u1eadp cho t\\u1eebng m\\u1ee5c\",\"className\":\"mt-3 pt-2 border-top\",\"inputs\":[\"post_settings\"]},\"detail\":{\"title\":\"Thi\\u1ebft l\\u1eadp Trang chi ti\\u1ebft \",\"inputs\":[\"detail_use_feature_image\",\"detail_hide_feature_image\",\"detail_hide_meta\",\"detail_hide_related\",\"detail_hide_comments\"]}}},\"data\":{\"show_breadcrumb\":true,\"list_layout\":\"sidebar\",\"list_type\":\"grid\"}},\"projects\":{\"label\":\"D\\u1ef1 \\u00e1n\",\"inputs\":{\"header_style\":{\"type\":\"radio\",\"label\":\"Header Style m\\u1eb7c \\u0111\\u1ecbnh\",\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\"},\"default\":\"2\"},\"show_breadcrumb\":{\"type\":\"switch\",\"label\":\"Breadcrumb\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb breadcrumb\"},\"list_layout\":{\"type\":\"radio\",\"label\":\"Layout Danh s\\u00e1ch\",\"data\":{\"sidebar\":\"sidebar\",\"fullwidth\":\"fullwidth\"},\"default\":\"sidebar\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u Danh s\\u00e1ch\",\"data\":{\"list\":\"Danh s\\u00e1ch (list)\",\"grid\":\"L\\u01b0\\u1edbi (grid)\"},\"default\":\"grid\"},\"header_bg_default_color\":{\"type\":\"radio\",\"label\":\"M\\u00e0u c\\u00f3 s\\u1eb5n\",\"data\":{\"\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}},\"header_bg_color\":{\"type\":\"text\",\"label\":\"M\\u00e3 m\\u00e0u (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"},\"header_use_bg_image\":{\"type\":\"switch\",\"label\":\"S\\u1eed d\\u1ee5ng h\\u00ecnh n\\u1ec1n\",\"value_type\":\"boolean\",\"check_label\":\"C\\u00f3\"},\"header_bg_image\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"header_bg_position\":{\"type\":\"radio\",\"label\":\"V\\u1ecb tr\\u00ed \\u1ea3nh\",\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}},\"header_class_name\":{\"type\":\"text\",\"label\":\"Class (T\\u00f9y ch\\u1ecdn)\"}},\"config\":{\"name\":\"Thi\\u1ebft l\\u1eadp m\\u1ee5c \\u0111\\u0103ng b\\u00e0i\",\"layout_type\":\"single\",\"form_groups\":{\"general\":{\"title\":\"Thi\\u1ebft l\\u1eadp chung\",\"inputs\":[\"list_layout\",\"list_type\"]},\"page_header\":{\"title\":\"Thi\\u1ebft l\\u1eadp Page Header\",\"inputs\":[\"header_style\",\"show_breadcrumb\",\"header_bg_default_color\",\"header_bg_color\",\"header_use_bg_image\",\"header_bg_image\",\"header_bg_position\",\"header_class_name\"]}}},\"data\":{\"show_breadcrumb\":true,\"list_layout\":\"sidebar\",\"list_type\":\"grid\"}},\"services\":{\"label\":\"D\\u1ecbch v\\u1ee5\",\"inputs\":{\"header_style\":{\"type\":\"radio\",\"label\":\"Header Style m\\u1eb7c \\u0111\\u1ecbnh\",\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\"},\"default\":\"2\"},\"show_breadcrumb\":{\"type\":\"switch\",\"label\":\"Breadcrumb\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb breadcrumb\"},\"header_align_center\":{\"type\":\"switch\",\"label\":\"Align Center\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb ch\\u00ednh gi\\u1eefa\"},\"header_bg_default_color\":{\"type\":\"radio\",\"label\":\"M\\u00e0u c\\u00f3 s\\u1eb5n\",\"data\":{\"\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}},\"header_bg_color\":{\"type\":\"text\",\"label\":\"M\\u00e3 m\\u00e0u (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"},\"header_use_bg_image\":{\"type\":\"switch\",\"label\":\"S\\u1eed d\\u1ee5ng h\\u00ecnh n\\u1ec1n\",\"value_type\":\"boolean\",\"check_label\":\"C\\u00f3\"},\"header_bg_image\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"header_bg_position\":{\"type\":\"radio\",\"label\":\"V\\u1ecb tr\\u00ed \\u1ea3nh\",\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}},\"header_class_name\":{\"type\":\"text\",\"label\":\"Class (T\\u00f9y ch\\u1ecdn)\"}}},\"pages\":{\"label\":\"Trang\",\"inputs\":{\"header_style\":{\"type\":\"radio\",\"label\":\"Header Style m\\u1eb7c \\u0111\\u1ecbnh\",\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\"},\"default\":\"2\"},\"show_breadcrumb\":{\"type\":\"switch\",\"label\":\"Breadcrumb\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb breadcrumb\"},\"list_layout\":{\"type\":\"radio\",\"label\":\"Layout Danh s\\u00e1ch\",\"data\":{\"sidebar\":\"sidebar\",\"fullwidth\":\"fullwidth\"},\"default\":\"sidebar\"},\"list_type\":{\"type\":\"radio\",\"label\":\"Ki\\u1ec3u Danh s\\u00e1ch\",\"data\":{\"list\":\"Danh s\\u00e1ch (list)\",\"grid\":\"L\\u01b0\\u1edbi (grid)\"},\"default\":\"grid\"},\"header_align_center\":{\"type\":\"switch\",\"label\":\"Align Center\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb ch\\u00ednh gi\\u1eefa\"},\"header_hide_author\":{\"type\":\"switch\",\"label\":\"\\u1ea8n t\\u00e1c gi\\u1ea3\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n \\/ kh\\u00f4ng hi\\u1ec3n th\\u1ecb th\\u00f4ng tin t\\u00e1c gi\\u1ea3\"},\"header_bg_default_color\":{\"type\":\"radio\",\"label\":\"M\\u00e0u c\\u00f3 s\\u1eb5n\",\"data\":{\"\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}},\"header_bg_color\":{\"type\":\"text\",\"label\":\"M\\u00e3 m\\u00e0u (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"},\"header_use_bg_image\":{\"type\":\"switch\",\"label\":\"S\\u1eed d\\u1ee5ng h\\u00ecnh n\\u1ec1n\",\"value_type\":\"boolean\",\"check_label\":\"C\\u00f3\"},\"header_bg_image\":{\"type\":\"file\",\"label\":\"H\\u00ecnh n\\u1ec1n (T\\u00f9y ch\\u1ecdn)\"},\"header_bg_position\":{\"type\":\"radio\",\"label\":\"V\\u1ecb tr\\u00ed \\u1ea3nh\",\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}},\"header_class_name\":{\"type\":\"text\",\"label\":\"Class (T\\u00f9y ch\\u1ecdn)\"},\"detail_use_feature_image\":{\"type\":\"switch\",\"label\":\"Header Image\",\"value_type\":\"boolean\",\"check_label\":\"S\\u1eed d\\u1ee5ng Feature Image l\\u00e0m h\\u00ecnh n\\u1ec1n Header\"},\"detail_hide_feature_image\":{\"type\":\"switch\",\"label\":\"Hide Feature Image\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n \\u1ea3nh n\\u1ed5i b\\u1eadt tr\\u00ean ph\\u1ea7n \\u0111\\u1ea7u n\\u1ed9i dung\"},\"detail_hide_related\":{\"type\":\"switch\",\"label\":\"Hide related\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n m\\u1ee5c li\\u00ean quan\"},\"detail_hide_comments\":{\"type\":\"switch\",\"label\":\"Hide Comments\",\"value_type\":\"boolean\",\"check_label\":\"\\u1ea8n ph\\u1ea7n b\\u00ecnh lu\\u1eadn\"}},\"config\":{\"name\":\"Thi\\u1ebft l\\u1eadp m\\u1ee5c \\u0111\\u0103ng b\\u00e0i\",\"layout_type\":\"single\",\"form_groups\":{\"general\":{\"title\":\"Thi\\u1ebft l\\u1eadp chung\",\"inputs\":[\"list_layout\",\"list_type\"]},\"page_header\":{\"title\":\"Thi\\u1ebft l\\u1eadp Page Header\",\"inputs\":[\"header_style\",\"show_breadcrumb\",\"header_align_center\",\"header_hide_author\",\"header_bg_default_color\",\"header_bg_color\",\"header_use_bg_image\",\"header_bg_image\",\"header_bg_position\",\"header_class_name\"]},\"detail\":{\"title\":\"Thi\\u1ebft l\\u1eadp Trang chi ti\\u1ebft \",\"inputs\":[\"detail_use_feature_image\",\"detail_hide_feature_image\",\"detail_hide_related\",\"detail_hide_comments\"]}}},\"data\":{\"show_breadcrumb\":true,\"list_layout\":\"sidebar\",\"list_type\":\"grid\"}},\"documentation\":{\"label\":\"T\\u00e0i li\\u1ec7u\",\"inputs\":{\"home\":{\"type\":\"area\",\"label\":\"Home Widgets\",\"value\":\"home_docs\"},\"post_docs\":{\"type\":\"area\",\"label\":\"Post Widgets\",\"value\":\"post_docs\"},\"left_widgets\":{\"type\":\"area\",\"label\":\"Left Sidebar Widgets\",\"value\":\"sidebar_docs_left\"},\"right_widgets\":{\"type\":\"area\",\"label\":\"Right Sidebar Widgets\",\"value\":\"sidebar_docs_right\"}}},\"auth\":{\"label\":\"Auth\",\"inputs\":{\"logo\":{\"type\":\"file\",\"label\":\"Logo\"},\"logo_light\":{\"type\":\"file\",\"label\":\"Logo Tr\\u1eafng (light)\"},\"register_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 m\\u1ee5c \\u0111\\u0103ng k\\u00fd\",\"value\":\"\\u0110\\u0103ng k\\u00fd \\u0111\\u1ec3 nh\\u1eadn t\\u00e0i kho\\u1ea3n d\\u00f9ng th\\u1eed mi\\u1ec3n ph\\u00ed\"},\"register_description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 r\\u1ea3 m\\u1ee5c \\u0111\\u0103ng k\\u00fd\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"}}},\"contacts\":{\"label\":\"Li\\u00ean h\\u1ec7\",\"inputs\":{\"page_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 Trang li\\u00ean h\\u1ec7\",\"value\":\"Li\\u00ean h\\u1ec7\"},\"page_description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 r\\u1ea3 trang li\\u00ean h\\u1ec7\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"},\"header_style\":{\"type\":\"radio\",\"label\":\"Header Style m\\u1eb7c \\u0111\\u1ecbnh\",\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\"},\"default\":\"2\"},\"show_breadcrumb\":{\"type\":\"switch\",\"label\":\"Breadcrumb\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb breadcrumb\"},\"email\":{\"type\":\"text\",\"Label\":\"Email\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"},\"phone_number\":{\"type\":\"text\",\"Label\":\"S\\u1ed1 \\u0111i\\u1ec7n tho\\u1ea1i\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"},\"address\":{\"type\":\"text\",\"Label\":\"\\u0110\\u1ecba ch\\u1ec9\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"},\"form_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 Form li\\u00ean h\\u1ec7\",\"value\":\"H\\u00e3y n\\u00f3i v\\u1ec1 nh\\u1eefng \\u00fd t\\u01b0\\u1edfng c\\u1ee7a b\\u1ea1n\"},\"form_description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 r\\u1ea3 \\/ Gi\\u1edbi thi\\u1ec7u\",\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"},\"button_text\":{\"type\":\"text\",\"label\":\"N\\u00fat g\\u1eedi\",\"value\":\"G\\u1eedi li\\u00ean h\\u1ec7\"},\"map_code\":{\"type\":\"textarea\",\"label\":\"M\\u00e3 nh\\u00fang b\\u1ea3n \\u0111\\u1ed3\",\"placeholder\":\"Nh\\u1eadp m\\u00e3 M\\u00e3 nh\\u00fang\"},\"faq_title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 FAQ (T\\u00f9y ch\\u1ecdn)\"},\"contact_faq\":{\"type\":\"area\",\"label\":\"C\\u00e1c C\\u00e2u h\\u1ecfi th\\u01b0\\u1eddng g\\u1eb7p\",\"value\":\"contact_faq\",\"@title-by\":\"title\"}}},\"socials\":{\"label\":\"MXH\",\"inputs\":{\"facebook\":{\"type\":\"text\",\"label\":\"facebook (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"twitter\":{\"type\":\"text\",\"label\":\"twitter (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"youtube\":{\"type\":\"text\",\"label\":\"youtube (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"linkedin\":{\"type\":\"text\",\"label\":\"Linkedin (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"instagram\":{\"type\":\"text\",\"label\":\"instagram (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"},\"pinterest\":{\"type\":\"text\",\"label\":\"Pinterest (T\\u00f9y ch\\u1ecdn)\",\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}}},\"preloader\":{\"label\":\"PreLoader\",\"inputs\":{\"show\":{\"type\":\"switch\",\"label\":\"Show\",\"value_type\":\"boolean\",\"check_label\":\"Hi\\u1ec3n th\\u1ecb Pre Loader\"},\"logo\":{\"type\":\"file\",\"label\":\"Logo\"},\"text\":{\"type\":\"text\",\"label\":\"Text Logo\",\"placeholder\":\"S\\u1eed d\\u1ee7ng th\\u1ebb <span> \\u0111\\u1ec3 in d\\u1eadm\"},\"title\":{\"type\":\"text\",\"label\":\"Ti\\u00eau \\u0111\\u1ec1 (T\\u00f9y ch\\u1ecdn)\"},\"description\":{\"type\":\"textarea\",\"label\":\"M\\u00f4 t\\u1ea3\",\"placeholder\":\"Danh s\\u00e1ch nh\\u0103n c\\u00e1ch nhau b\\u1eb1ng d\\u1ea5u ch\\u1ea5m ph\\u1ea9y (;) ho\\u1eb7c xu\\u1ed1ng d\\u00f2ng\",\"className\":\"auto-height\"}}}}}'),
(220, 'theme', 4, 'areas', '{\"home\":\"Trang Ch\\u1ee7\",\"sidebar_docs_left\":\"Docs Left Sidebar\",\"sidebar_docs_right\":\"Docs Right Sidebar\",\"sidebar_post\":\"Post Sidebar\",\"sidebar_project\":\"Project Sidebar\",\"sidebar_page\":\"Page Sidebar\",\"home_docs\":\"Trang Ch\\u1ee7 T\\u00e0i li\\u1ec7u\",\"post_docs\":\"T\\u00e0i li\\u1ec7u - trang tin b\\u00e0i\",\"docbody\":\"Dock Body\",\"docly_footer\":\"Docly Footer\",\"home_tabs\":\"Home Tabs\",\"help_area\":\"Help Area\",\"post_settings\":\"Post Setting\",\"home_services\":\"Home Services\",\"testimonials\":\"Ph\\u1ea3n h\\u1ed3i t\\u1eeb kh\\u00e1ch  h\\u00e0ng\",\"team_members\":\"Th\\u00e0nh vi\\u00ean nh\\u00f3m\",\"body_bottom\":\"Ch\\u00e2n trang\"}'),
(221, 'theme', 4, 'layout', '[]'),
(222, 'theme', 4, 'menus', '{\"positions\":{\"docsleft\":\"Document Left Sidebar\"}}'),
(223, 'post', 19, 'custom_slug', NULL),
(224, 'post', 19, 'meta_title', NULL),
(225, 'post', 19, 'meta_description', 'Web 1-0-2 - Thiết kế website wordpress chuẩn SEO - Nhanh - Tiết kiệm chi phí - liên hệ: 0945786960.'),
(226, 'post', 19, 'feature_image_keep_original', NULL),
(227, 'post', 19, 'service_id', NULL),
(228, 'post', 19, 'og_image_width', '315'),
(229, 'post', 19, 'og_image_height', '276'),
(230, 'post', 20, 'custom_slug', NULL),
(231, 'post', 20, 'meta_title', NULL),
(232, 'post', 20, 'meta_description', 'Thiết kế giao diện cho trên nền tảng web102 chuẩn SEO, nhanh chóng . Liên hệ 0945786960.'),
(233, 'post', 20, 'feature_image_keep_original', NULL),
(234, 'post', 20, 'service_id', NULL),
(235, 'post', 20, 'og_image_width', '276'),
(236, 'post', 20, 'og_image_height', '276'),
(237, 'post', 21, 'custom_slug', NULL),
(238, 'post', 21, 'meta_title', NULL),
(239, 'post', 21, 'meta_description', NULL),
(240, 'post', 21, 'feature_image_keep_original', NULL),
(241, 'post', 21, 'service_id', NULL),
(242, 'post', 21, 'og_image_width', '276'),
(243, 'post', 21, 'og_image_height', '276'),
(244, 'user_services', 21, 'domain', 'vcc.vn'),
(245, 'user_services', 21, 'subdomain', 'nooffoof'),
(246, 'user_services', 21, 'alias_domain', NULL),
(247, 'post', 22, 'custom_slug', NULL),
(248, 'post', 22, 'meta_title', NULL),
(249, 'post', 22, 'meta_description', NULL),
(250, 'post', 22, 'feature_image_keep_original', NULL),
(251, 'post', 22, 'og_image_width', '276'),
(252, 'post', 22, 'og_image_height', '276'),
(253, 'post', 22, 'bookmark', NULL),
(254, 'project', 23, 'custom_slug', NULL),
(255, 'project', 23, 'client_id', NULL),
(256, 'project', 23, 'website', NULL),
(257, 'project', 23, 'link', NULL),
(258, 'project', 23, 'feature_image_keep_original', NULL),
(259, 'project', 23, 'og_image_width', '400'),
(260, 'project', 23, 'og_image_height', '400'),
(261, 'user_services', 22, 'domain', 'chinhlatoi.vn'),
(262, 'user_services', 22, 'subdomain', 'shopme'),
(263, 'user_services', 22, 'alias_domain', 'shopme.com'),
(264, 'post', 24, 'custom_slug', NULL),
(265, 'post', 24, 'meta_title', NULL),
(266, 'post', 24, 'meta_description', NULL),
(267, 'post', 24, 'feature_image_keep_original', NULL),
(268, 'post', 24, 'bookmark', NULL),
(269, 'post', 24, 'og_image_width', '276'),
(270, 'post', 24, 'og_image_height', '276'),
(271, 'post', 25, 'custom_slug', NULL),
(272, 'post', 25, 'meta_title', NULL),
(273, 'post', 25, 'meta_description', NULL),
(274, 'post', 25, 'feature_image_keep_original', NULL),
(275, 'post', 25, 'bookmark', 'require: Yêu cầu hệ thống\r\nInstalling: Cài đặt'),
(276, 'post', 25, 'og_image_width', '276'),
(277, 'post', 25, 'og_image_height', '276'),
(284, 'post', 27, 'custom_slug', NULL),
(285, 'post', 27, 'meta_title', NULL),
(286, 'post', 27, 'meta_description', NULL),
(287, 'post', 27, 'feature_image_keep_original', NULL),
(288, 'post', 27, 'bookmark', 'phpartisan: Lệnh php artisan\r\nsuggest: Mẹo thiết lập server ảo'),
(289, 'post', 27, 'og_image_width', '276'),
(290, 'post', 27, 'og_image_height', '276'),
(291, 'post', 28, 'custom_slug', NULL),
(292, 'post', 28, 'meta_title', NULL),
(293, 'post', 28, 'meta_description', NULL),
(294, 'post', 28, 'feature_image_keep_original', NULL),
(295, 'post', 28, 'bookmark', 'project-structure: Cấu trúc CMS\r\napp-structure: Cấu trúc thư mục app\r\njson-structure: Cấu trúc thư mục json\r\nview-structure: Cấu trúc sơ lược views'),
(296, 'post', 28, 'og_image_width', '276'),
(297, 'post', 28, 'og_image_height', '276'),
(298, 'post', 29, 'custom_slug', NULL),
(299, 'post', 29, 'meta_title', NULL),
(300, 'post', 29, 'meta_description', NULL),
(301, 'post', 29, 'feature_image_keep_original', NULL),
(302, 'post', 29, 'bookmark', NULL),
(303, 'post', 29, 'og_image_width', '414'),
(304, 'post', 29, 'og_image_height', '276'),
(305, 'user_services', 23, 'domain', 'vcc.vn'),
(306, 'user_services', 23, 'subdomain', 'bayerntimes'),
(307, 'user_services', 23, 'alias_domain', NULL),
(308, 'user_services', 24, 'domain', 'chinhlatoi.vn'),
(309, 'user_services', 24, 'subdomain', 'doan'),
(310, 'user_services', 24, 'alias_domain', NULL),
(311, 'user_services', 25, 'domain', 'chinhlatoi.vn'),
(312, 'user_services', 25, 'subdomain', 'ngocdoan'),
(313, 'user_services', 25, 'alias_domain', NULL),
(314, 'user_services', 26, 'domain', 'vcc.vn'),
(315, 'user_services', 26, 'subdomain', 'chimere'),
(316, 'user_services', 26, 'alias_domain', 'chimere.com.vn'),
(317, 'user_services', 27, 'domain', 'vcc.vn'),
(318, 'user_services', 27, 'subdomain', 'haule'),
(319, 'user_services', 27, 'alias_domain', 'haule.vcc.vn'),
(320, 'user_services', 28, 'domain', 'chinhlatoi.com'),
(321, 'user_services', 28, 'subdomain', 'technology24h'),
(322, 'user_services', 28, 'alias_domain', 'technology24h.com.vn'),
(323, 'user_services', 29, 'domain', 'chinhlatoi.vn'),
(324, 'user_services', 29, 'subdomain', 'meganestrore'),
(325, 'user_services', 29, 'alias_domain', 'meganestore.com.vn'),
(326, 'dynamic', 5, 'default_fields', '[\"title\",\"slug\",\"description\",\"content_type\",\"content\",\"gallery\",\"video_url\",\"source\",\"feature_image\",\"meta_title\",\"meta_description\",\"keywords\",\"tags\",\"privacy\"]'),
(327, 'dynamic', 5, 'advance_props', '[{\"name\":\"bookmark\",\"type\":\"textarea\",\"label\":\"Bookmark\",\"validate\":null,\"prop_list\":[{\"key\":\"className\",\"value\":\"auto-height\"}]}]'),
(328, 'dynamic', 5, 'custom_slug', '0'),
(329, 'dynamic', 5, 'prop_inputs', '{\"bookmark\":{\"name\":\"bookmark\",\"type\":\"textarea\",\"label\":\"Bookmark\",\"validate\":null,\"className\":\"auto-height\"}}'),
(330, 'dynamic', 5, 'form_config', '{\"name\":\"Th\\u00f4ng tin Giao di\\u1ec7n\",\"layout_type\":\"column\",\"form_groups\":[{\"title\":\"Th\\u00f4ng tin c\\u01a1 b\\u1ea3n\",\"class\":\"col-12 col-lg-7\",\"inputs\":[\"title\",\"slug\",\"category_id\",\"description\"]},{\"title\":\"\\u1ea2nh v\\u00e0 ri\\u00eang t\\u01b0\",\"class\":\"col-12 col-lg-5\",\"inputs\":[\"feature_image\"]},{\"title\":\"Th\\u00f4ng tin chi ti\\u1ebft\",\"class\":\"col-12\",\"inputs\":[\"content\",\"content_type\",\"video_url\",\"gallery\",\"source\",\"bookmark\"]},{\"title\":\"Th\\u00f4ng tin SEO\",\"class\":\"col-12 col-lg-6\",\"inputs\":[\"meta_title\",\"meta_description\",\"keywords\"]},{\"title\":null,\"class\":\"col-12 col-lg-6\",\"inputs\":[\"tags\",\"privacy\"]}]}'),
(331, 'post', 30, 'custom_slug', NULL),
(332, 'post', 30, 'meta_title', NULL),
(333, 'post', 30, 'meta_description', NULL),
(334, 'post', 30, 'feature_image_keep_original', NULL),
(335, 'post', 30, 'bookmark', 'base-controller: Base Controller\r\nadmin-controller: Admin Controller\r\nproject-controller: - Project Controller\r\ncrud-methods: - CRUD Event Methods\r\nclient-controller: Client Controller\r\nproduct-controller: - Product Controller'),
(336, 'post', 30, 'og_image_width', '276'),
(337, 'post', 30, 'og_image_height', '276'),
(338, 'post', 31, 'custom_slug', NULL),
(339, 'post', 31, 'meta_title', NULL),
(340, 'post', 31, 'meta_description', NULL),
(341, 'post', 31, 'feature_image_keep_original', NULL),
(342, 'post', 31, 'bookmark', 'structure:Cấu trúc thư mục\r\nvariable: Biến hệ thống\r\noptions:  - $options\r\nsiteinfo:  - $siteinfo\r\nhtml:  - $html\r\nhelper: -  $helper\r\nothervars: Một số biến khác'),
(343, 'post', 31, 'og_image_width', '276'),
(344, 'post', 31, 'og_image_height', '276'),
(345, 'user_services', 30, 'domain', 'chinhlatoi.com'),
(346, 'user_services', 30, 'subdomain', 'hdshop'),
(347, 'user_services', 30, 'alias_domain', 'hdshop.com.vn'),
(348, 'user_services', 31, 'domain', 'vcc.vn'),
(349, 'user_services', 31, 'subdomain', 'timikids'),
(350, 'user_services', 31, 'alias_domain', NULL),
(351, 'user_services', 32, 'domain', 'chinhlatoi.vn'),
(352, 'user_services', 32, 'subdomain', 'anhhtph10133'),
(353, 'user_services', 32, 'alias_domain', NULL),
(354, 'user_services', 33, 'domain', 'chinhlatoi.com'),
(355, 'user_services', 33, 'subdomain', 'hdstore'),
(356, 'user_services', 33, 'alias_domain', NULL),
(357, 'user_services', 34, 'domain', 'chinhlatoi.vn'),
(358, 'user_services', 34, 'subdomain', 'nhomtronhoc'),
(359, 'user_services', 34, 'alias_domain', NULL),
(360, 'user_services', 35, 'domain', 'vcc.vn'),
(361, 'user_services', 35, 'subdomain', 'adidass'),
(362, 'user_services', 35, 'alias_domain', NULL),
(363, 'user_services', 36, 'domain', 'vcc.vn'),
(364, 'user_services', 36, 'subdomain', 'phukiengame'),
(365, 'user_services', 36, 'alias_domain', NULL),
(366, 'user_services', 37, 'domain', 'vcc.vn'),
(367, 'user_services', 37, 'subdomain', 'donghothongminh'),
(368, 'user_services', 37, 'alias_domain', 'donghothongminh.com.vn'),
(369, 'post', 32, 'custom_slug', NULL),
(370, 'post', 32, 'meta_title', NULL),
(371, 'post', 32, 'meta_description', NULL),
(372, 'post', 32, 'feature_image_keep_original', NULL),
(373, 'post', 32, 'bookmark', NULL),
(374, 'post', 32, 'og_image_width', '276'),
(375, 'post', 32, 'og_image_height', '276'),
(376, 'user_services', 38, 'domain', 'chinhlatoi.vn'),
(377, 'user_services', 38, 'subdomain', 'nguoinoitieng'),
(378, 'user_services', 38, 'alias_domain', NULL),
(379, 'user_services', 39, 'domain', 'vcc.vn'),
(380, 'user_services', 39, 'subdomain', 'doanln'),
(381, 'user_services', 39, 'alias_domain', NULL),
(382, 'user_services', 40, 'domain', 'vcc.vn'),
(383, 'user_services', 40, 'subdomain', 'tester2'),
(384, 'user_services', 40, 'alias_domain', NULL),
(385, 'user_services', 41, 'domain', 'vcc.vn'),
(386, 'user_services', 41, 'subdomain', 'wordpress'),
(387, 'user_services', 41, 'alias_domain', NULL),
(388, 'user_services', 42, 'domain', 'chinhlatoi.vn'),
(389, 'user_services', 42, 'subdomain', 'doanwp'),
(390, 'user_services', 42, 'alias_domain', NULL),
(391, 'user_services', 43, 'domain', 'chinhlatoi.com'),
(392, 'user_services', 43, 'subdomain', 'doan'),
(393, 'user_services', 43, 'alias_domain', NULL),
(394, 'user_services', 44, 'domain', 'chinhlatoi.vn'),
(395, 'user_services', 44, 'subdomain', 'doandz'),
(396, 'user_services', 44, 'alias_domain', NULL),
(397, 'post', 33, 'custom_slug', NULL),
(398, 'post', 33, 'meta_title', NULL),
(399, 'post', 33, 'meta_description', 'WordPress 1-0-2 0 - Tạo website chuẩn SEO nhanh chóng - Tiết kiệm chi phí.\r\nChỉ với vài thao tác chuột đơn giản là bạn đã có thể tạo ra một trang web bán hàng chuẩn SEO'),
(400, 'post', 33, 'feature_image_keep_original', NULL),
(401, 'post', 33, 'service_id', '7'),
(402, 'post', 33, 'og_image_width', '276'),
(403, 'post', 33, 'og_image_height', '276'),
(404, 'user_services', 45, 'domain', 'vcc.vn'),
(405, 'user_services', 45, 'subdomain', 'doanaz'),
(406, 'user_services', 45, 'alias_domain', NULL),
(407, 'user_services', 46, 'domain', 'vcc.vn'),
(408, 'user_services', 46, 'subdomain', 'demowp'),
(409, 'user_services', 46, 'alias_domain', NULL),
(410, 'user_services', 47, 'domain', 'chinhlatoi.vn'),
(411, 'user_services', 47, 'subdomain', 'hieu'),
(412, 'user_services', 47, 'alias_domain', NULL),
(413, 'user_services', 48, 'domain', 'vcc.vn'),
(414, 'user_services', 48, 'subdomain', 'doanle'),
(415, 'user_services', 48, 'alias_domain', NULL),
(416, 'user_services', 49, 'domain', 'vcc.vn'),
(417, 'user_services', 49, 'subdomain', 'doan101'),
(418, 'user_services', 49, 'alias_domain', NULL),
(419, 'user_services', 50, 'domain', 'chinhlatoi.com'),
(420, 'user_services', 50, 'subdomain', '002'),
(421, 'user_services', 50, 'alias_domain', NULL),
(422, 'user_services', 51, 'domain', 'chinhlatoi.com'),
(423, 'user_services', 51, 'subdomain', '123456'),
(424, 'user_services', 51, 'alias_domain', NULL),
(425, 'user_services', 52, 'domain', 'chinhlatoi.vn'),
(426, 'user_services', 52, 'subdomain', 'ddd'),
(427, 'user_services', 52, 'alias_domain', NULL),
(428, 'user_services', 52, 'email', 'doanle2016.12@outlook.com'),
(429, 'user_services', 52, 'password', '123456'),
(430, 'user_services', 53, 'domain', 'chinhlatoi.vn'),
(431, 'user_services', 53, 'subdomain', 'doanln1992'),
(432, 'user_services', 53, 'alias_domain', NULL),
(433, 'user_services', 53, 'email', 'doanln1992@gmail.com'),
(434, 'user_services', 53, 'password', '123456'),
(435, 'user_services', 53, 'web_type', 'default'),
(436, 'user_services', 53, 'account_type', NULL),
(437, 'user_services', 53, 'name', 'Lê Ngọc Doãn'),
(438, 'user_services', 54, 'domain', 'chinhlatoi.vn'),
(439, 'user_services', 54, 'subdomain', 'doanln1992'),
(440, 'user_services', 54, 'alias_domain', NULL),
(441, 'user_services', 54, 'email', 'doanln1992@gmail.com'),
(442, 'user_services', 54, 'password', '123456'),
(443, 'user_services', 54, 'web_type', 'default'),
(444, 'user_services', 54, 'account_type', NULL),
(445, 'user_services', 54, 'name', 'Lê Ngọc Doãn'),
(446, 'user_services', 55, 'domain', 'chinhlatoi.vn'),
(447, 'user_services', 55, 'subdomain', 'd92'),
(448, 'user_services', 55, 'alias_domain', NULL),
(449, 'user_services', 55, 'email', 'doanln1992.2@gmail.com'),
(450, 'user_services', 55, 'password', '123456'),
(451, 'user_services', 55, 'web_type', 'blog'),
(452, 'user_services', 55, 'account_type', NULL),
(453, 'user_services', 55, 'name', 'Lê Ngọc Doãn'),
(454, 'user_services', 56, 'domain', 'chinhlatoi.vn'),
(455, 'user_services', 56, 'subdomain', 'dln2'),
(456, 'user_services', 56, 'alias_domain', NULL),
(457, 'user_services', 56, 'email', 'doanln1992.4@gmail.com'),
(458, 'user_services', 56, 'password', '123456'),
(459, 'user_services', 56, 'web_type', 'personal'),
(460, 'user_services', 56, 'account_type', NULL),
(461, 'user_services', 56, 'name', 'Lê Ngọc Doãn'),
(462, 'user_services', 57, 'domain', 'chinhlatoi.vn'),
(463, 'user_services', 57, 'subdomain', 'tests123'),
(464, 'user_services', 57, 'alias_domain', NULL),
(465, 'user_services', 57, 'email', 'doanln1992.5@gmail.com'),
(466, 'user_services', 57, 'password', '123456'),
(467, 'user_services', 57, 'web_type', 'default'),
(468, 'user_services', 57, 'account_type', NULL),
(469, 'user_services', 57, 'name', 'Lê Ngọc Doãn'),
(470, 'user_services', 58, 'domain', 'chinhlatoi.vn'),
(471, 'user_services', 58, 'subdomain', 'test65'),
(472, 'user_services', 58, 'alias_domain', NULL),
(473, 'user_services', 58, 'email', 'doanln1992.6@gmail.com'),
(474, 'user_services', 58, 'password', '123456'),
(475, 'user_services', 58, 'web_type', 'business'),
(476, 'user_services', 58, 'account_type', NULL),
(477, 'user_services', 58, 'name', 'Lê Ngọc Doãn'),
(478, 'user_services', 59, 'domain', 'chinhlatoi.vn'),
(479, 'user_services', 59, 'subdomain', 't102'),
(480, 'user_services', 59, 'alias_domain', NULL),
(481, 'user_services', 59, 'email', 'doanle2016.4@outlook.com'),
(482, 'user_services', 59, 'password', '123456'),
(483, 'user_services', 59, 'web_type', 'wordpress'),
(484, 'user_services', 59, 'account_type', NULL),
(485, 'user_services', 59, 'name', 'Lê Ngọc Doãn'),
(486, 'user_services', 60, 'domain', 'chinhlatoi.vn'),
(487, 'user_services', 60, 'subdomain', 'ooo'),
(488, 'user_services', 60, 'alias_domain', NULL),
(489, 'user_services', 60, 'email', 'doanle2016.11@outlook.com'),
(490, 'user_services', 60, 'password', '123456'),
(491, 'user_services', 60, 'web_type', 'wordpress'),
(492, 'user_services', 60, 'account_type', NULL),
(493, 'user_services', 60, 'name', 'Lê Ngọc Doãn'),
(494, 'user_services', 61, 'domain', 'chinhlatoi.vn'),
(495, 'user_services', 61, 'subdomain', 'zxcvbn'),
(496, 'user_services', 61, 'alias_domain', NULL),
(497, 'user_services', 61, 'email', 'doanle2016.12@outlook.com'),
(498, 'user_services', 61, 'password', '123456'),
(499, 'user_services', 61, 'web_type', 'wordpress'),
(500, 'user_services', 61, 'account_type', NULL),
(501, 'user_services', 61, 'name', 'Lê Ngọc Doãn'),
(502, 'user_services', 62, 'domain', 'chinhlatoi.vn'),
(503, 'user_services', 62, 'subdomain', '010'),
(504, 'user_services', 62, 'alias_domain', NULL),
(505, 'user_services', 62, 'email', 'doanle201402@outlook.com'),
(506, 'user_services', 62, 'password', '123456'),
(507, 'user_services', 62, 'web_type', 'wordpress'),
(508, 'user_services', 62, 'account_type', NULL),
(509, 'user_services', 62, 'name', 'Lê Ngọc Doãn'),
(510, 'user_services', 63, 'domain', 'chinhlatoi.vn'),
(511, 'user_services', 63, 'subdomain', '003'),
(512, 'user_services', 63, 'alias_domain', NULL),
(513, 'user_services', 63, 'email', 'doanle2016.13@outlook.com'),
(514, 'user_services', 63, 'password', '123456'),
(515, 'user_services', 63, 'web_type', 'wordpress'),
(516, 'user_services', 63, 'account_type', NULL),
(517, 'user_services', 63, 'name', 'Lê Ngọc Doãn'),
(518, 'user_services', 64, 'domain', 'chinhlatoi.vn'),
(519, 'user_services', 64, 'subdomain', 'doanln19pp'),
(520, 'user_services', 64, 'alias_domain', NULL),
(521, 'user_services', 64, 'email', 'doanln19pp6@gmail.com'),
(522, 'user_services', 64, 'password', '123456'),
(523, 'user_services', 64, 'web_type', 'wordpress'),
(524, 'user_services', 64, 'account_type', NULL),
(525, 'user_services', 64, 'name', 'Lê Ngọc Doãn'),
(526, 'user_services', 65, 'domain', 'chinhlatoi.vn'),
(527, 'user_services', 65, 'subdomain', 'doanln19ppl'),
(528, 'user_services', 65, 'alias_domain', NULL),
(529, 'user_services', 65, 'email', 'doanln19ppl6@gmail.com'),
(530, 'user_services', 65, 'password', '123456'),
(531, 'user_services', 65, 'web_type', 'wordpress'),
(532, 'user_services', 65, 'account_type', NULL),
(533, 'user_services', 65, 'name', 'Lê Ngọc Doãn'),
(534, 'user_services', 66, 'domain', 'vcc.vn'),
(535, 'user_services', 66, 'subdomain', 'Mywedding'),
(536, 'user_services', 66, 'alias_domain', 'Mywedding.com.vn'),
(537, 'user_services', 67, 'domain', 'chinhlatoi.vn'),
(538, 'user_services', 67, 'subdomain', 'shoplongbosci'),
(539, 'user_services', 67, 'alias_domain', NULL),
(540, 'user_services', 68, 'domain', 'chinhlatoi.vn'),
(541, 'user_services', 68, 'subdomain', 'domain'),
(542, 'user_services', 68, 'alias_domain', 'domain.com.vn'),
(543, 'user_services', 69, 'domain', 'chinhlatoi.vn'),
(544, 'user_services', 69, 'subdomain', 'demo11'),
(545, 'user_services', 69, 'alias_domain', NULL),
(546, 'user_services', 69, 'email', 'demo11@gmail.com'),
(547, 'user_services', 69, 'password', '123456'),
(548, 'user_services', 69, 'web_type', 'business'),
(549, 'user_services', 69, 'account_type', NULL),
(550, 'user_services', 69, 'name', 'Lê Ngọc Doãn'),
(551, 'user_services', 70, 'domain', 'fpoly.vn'),
(552, 'user_services', 70, 'subdomain', 'tam'),
(553, 'user_services', 70, 'alias_domain', NULL),
(554, 'user_services', 70, 'email', 'doanln161@gmail.com'),
(555, 'user_services', 70, 'password', 'Doan.Fpoly'),
(556, 'user_services', 70, 'web_type', 'wordpress'),
(557, 'user_services', 70, 'account_type', NULL),
(558, 'user_services', 70, 'name', 'Lê Ngọc Doãn'),
(559, 'user_services', 71, 'domain', 'fpoly.vn'),
(560, 'user_services', 71, 'subdomain', 'tam'),
(561, 'user_services', 71, 'alias_domain', NULL),
(562, 'user_services', 71, 'email', 'doanln162@gmail.com'),
(563, 'user_services', 71, 'password', 'Doan.Fpoly'),
(564, 'user_services', 71, 'web_type', 'wordpress'),
(565, 'user_services', 71, 'account_type', NULL),
(566, 'user_services', 71, 'name', 'Lê Ngọc Doãn'),
(567, 'user_services', 72, 'domain', 'fpoly.vn'),
(568, 'user_services', 72, 'subdomain', 'nooffoof'),
(569, 'user_services', 72, 'alias_domain', NULL),
(570, 'user_services', 72, 'email', 'doanln1621@gmail.com'),
(571, 'user_services', 72, 'password', 'Doan.Fpoly'),
(572, 'user_services', 72, 'web_type', 'wordpress'),
(573, 'user_services', 72, 'account_type', NULL),
(574, 'user_services', 72, 'name', 'Lê Ngọc Doãn'),
(575, 'user_services', 73, 'domain', 'fpoly.vn'),
(576, 'user_services', 73, 'subdomain', 'test'),
(577, 'user_services', 73, 'alias_domain', NULL),
(578, 'user_services', 73, 'email', 'doanln160@gmail.com'),
(579, 'user_services', 73, 'password', 'Doan.Fpoly'),
(580, 'user_services', 73, 'web_type', 'wordpress'),
(581, 'user_services', 73, 'account_type', NULL),
(582, 'user_services', 73, 'name', 'Lê Ngọc Doãn'),
(583, 'user_services', 74, 'domain', 'fpoly.vn'),
(584, 'user_services', 74, 'subdomain', 'demo'),
(585, 'user_services', 74, 'alias_domain', NULL),
(586, 'user_services', 74, 'email', 'doanln161@gmail.com'),
(587, 'user_services', 74, 'password', 'Doan.Fpoly'),
(588, 'user_services', 74, 'web_type', 'wordpress'),
(589, 'user_services', 74, 'account_type', NULL),
(590, 'user_services', 74, 'name', 'Lê Ngọc Doãn'),
(591, 'user_services', 75, 'domain', 'fpoly.vn'),
(592, 'user_services', 75, 'subdomain', 'op'),
(593, 'user_services', 75, 'alias_domain', NULL),
(594, 'user_services', 76, 'domain', 'fpoly.vn'),
(595, 'user_services', 76, 'subdomain', 'tam'),
(596, 'user_services', 76, 'alias_domain', NULL),
(597, 'user_services', 77, 'domain', 'fpoly.vn'),
(598, 'user_services', 77, 'subdomain', 'demo'),
(599, 'user_services', 77, 'alias_domain', NULL),
(600, 'user_services', 77, 'email', 'doanln1621@gmail.com'),
(601, 'user_services', 77, 'password', 'Doan.Fpoly'),
(602, 'user_services', 77, 'web_type', 'wordpress'),
(603, 'user_services', 77, 'account_type', 'pro'),
(604, 'user_services', 77, 'name', 'Lê Ngọc Doãn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_03_02_102714_create_email_tokens_table', 1),
(4, '2019_03_02_103421_create_metadatas_table', 1),
(5, '2019_03_29_174347_create_notices_table', 1),
(6, '2019_03_29_174510_create_user_notices_table', 1),
(7, '2019_04_05_094037_create_themes_table', 1),
(8, '2019_04_09_150339_create_permission_modules_table', 1),
(9, '2019_04_09_151002_create_permission_roles_table', 1),
(10, '2019_04_09_151028_create_permission_module_roles_table', 1),
(11, '2019_04_09_151052_create_permission_user_roles_table', 1),
(12, '2019_04_14_084914_create_dynamics_table', 1),
(13, '2019_04_14_085134_create_categories_table', 1),
(14, '2019_04_14_085248_create_posts_table', 1),
(15, '2019_04_17_082353_create_files_table', 1),
(16, '2019_04_28_100816_create_tags_table', 1),
(17, '2019_04_28_101017_create_tag_refs_table', 1),
(18, '2019_06_24_172715_create_transactions_table', 1),
(19, '2019_07_15_080241_create_contacts_table', 1),
(20, '2019_07_15_081024_create_contact_replies_table', 1),
(21, '2019_07_15_175449_create_subcribes_table', 1),
(22, '2019_07_15_235748_create_jobs_table', 1),
(23, '2019_07_16_002911_create_failed_jobs_table', 1),
(24, '2019_07_23_174639_create_sliders_table', 1),
(25, '2019_07_23_181110_create_slider_items_table', 1),
(26, '2019_07_31_101312_create_options_table', 1),
(27, '2019_07_31_173240_create_option_groups_table', 1),
(28, '2019_07_31_173526_create_option_datas_table', 1),
(29, '2019_08_10_150630_create_menus_table', 1),
(30, '2019_08_10_151408_create_menu_items_table', 1),
(31, '2019_08_16_101122_create_html_areas_table', 1),
(32, '2019_08_16_152505_create_html_embeds_table', 1),
(33, '2019_08_24_091126_create_components_table', 1),
(34, '2019_08_25_165401_create_html_components_table', 1),
(35, '2019_09_13_122300_create_comments_table', 1),
(36, '2020_02_12_093859_create_post_views_table', 1),
(52, '2021_10_21_122239_create_category_refs_table', 2),
(53, '2021_10_21_122717_create_crazy_3d_model_items_table', 2),
(54, '2021_10_21_123037_create_crazy_3d_templates_table', 2),
(55, '2021_10_21_123749_create_crazy_3d_projects_table', 2),
(56, '2021_10_21_123953_create_crazy_3d_item_refs_table', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notices`
--

CREATE TABLE `notices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT 0,
  `to_id` bigint(20) DEFAULT 0,
  `to_group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'personal',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'Bạn có thông báo mới',
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` bigint(20) UNSIGNED DEFAULT 0,
  `seen` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `options`
--

CREATE TABLE `options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'Options',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'option',
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'base',
  `ref_id` bigint(20) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `options`
--

INSERT INTO `options` (`id`, `title`, `slug`, `ref`, `ref_id`) VALUES
(1, 'Thiết lập', 'settings', NULL, 0),
(2, '247 News', '247-news', 'theme', 1),
(3, 'Bize', 'bize', 'theme', 2),
(4, 'Bunas', 'bunas', 'theme', 3),
(5, 'Docly', 'docly', 'theme', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `option_datas`
--

CREATE TABLE `option_datas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'option_name',
  `label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Option Name',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `value_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(10) UNSIGNED DEFAULT 12,
  `props` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `can_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `option_datas`
--

INSERT INTO `option_datas` (`id`, `group_id`, `name`, `label`, `type`, `value_type`, `value`, `priority`, `props`, `can_delete`) VALUES
(1, 1, 'cache_data_time', 'Thời gian lưu cache của Dữ liệu từ DB', 'number', 'number', '0', 3, '[]', 0),
(2, 1, 'cache_view_time', 'Thời gian lưu cache của view', 'number', 'number', '0', 4, '[]', 0),
(3, 1, 'send_mail_notification', 'Gửi mail thông báo', 'checkbox', 'boolean', '1', 5, '{\"template\":\"switch\"}', 0),
(4, 1, 'mail_notification', 'Email nhận thông báo', 'email', 'text', 'doanln16@gmail.com', 6, '[]', 0),
(5, 2, 'site_name', 'Tên trang web', 'text', 'text', 'Web 1-0-2', 1, '[]', 0),
(6, 2, 'slogan', 'Khẩu hiệu', 'text', 'text', 'Nghĩ lớn - Làm lớn', 2, '[]', 0),
(7, 2, 'title', 'Tiêu đề trang', 'text', 'text', 'Web 1-0-2 | VCC.VN', 3, '[]', 0),
(8, 2, 'logo', 'Logo', 'file', 'text', 'logo.png', 4, '[]', 0),
(9, 2, 'web_image', 'Hình ảnh đại diện cho web', 'file', 'text', 'web_image.png', 10, '[]', 0),
(10, 2, 'favicon', 'Biệu tượng cho trang web', 'file', 'text', 'favicon.png', 11, '[]', 0),
(11, 2, 'meta_title', 'Tiêu đề seo', 'text', 'text', 'Web 1-0-2', 12, '[]', 0),
(12, 2, 'meta_description', 'Mô tả website', 'textarea', 'text', 'Web102 - Đã kinh doanh thì nên tạo một website..\r\nHãy bắt đầu với việc lên ý tưởng vào tạo cho mình một trang web ngay hôm nay!', 13, '[]', 0),
(13, 2, 'keywords', 'Từ khóa', 'text', 'text', 'Web 1-0-2, vcc.vn', 14, '[]', 0),
(14, 2, 'email', 'Địa chỉ email', 'email', 'text', 'doanln16@gmail.com', 15, '[]', 0),
(15, 2, 'phone_number', 'Số điện thoại', 'tel', 'text', '0945786960', 16, '[]', 0),
(16, 2, 'address', 'Địa chỉ', 'text', 'text', '172, đường Bà Triệu, p. Dân Chủ tp. Hòa Bình, tỉnh Hòa Bình', 17, '[]', 0),
(17, 2, 'facebook', 'Facebook', 'text', 'text', 'https://www.facebook.com/thegioivuong', 18, NULL, 1),
(18, 19, 'decimals', 'Số ký tự thập phân', 'number', 'number', '0', 1, '[]', 0),
(19, 19, 'decimal_poiter', 'Ký tự ngăn cách phẩn thập phân', 'select', 'text', ',', 2, '{\"data\":{\",\":\"\\u0110\\u1ea5u ph\\u1ea9y (.)\",\".\":\"\\u0110\\u1ea5u ch\\u1ea5m (.)\"}}', 0),
(20, 19, 'thousands_sep', 'Ký tự ngăn cách hàng nghìn', 'select', 'text', '.', 3, '{\"data\":{\".\":\"\\u0110\\u1ea5u ch\\u1ea5m (.)\",\",\":\"\\u0110\\u1ea5u ph\\u1ea9y (.)\"}}', 0),
(21, 19, 'currency_type', 'Loại tiền tệ', 'text', 'text', 'Đ', 4, '[]', 0),
(22, 19, 'currency_position', 'Vị trí đơn vị tiền', 'select', 'text', 'right', 5, '{\"data\":{\"left\":\"Tr\\u00e1i\",\"right\":\"Ph\\u1ea3i\"}}', 0),
(23, 29, 'bank_account_number', 'Số tài khoản', 'text', 'text', '45510000802371', 1, '[]', 0),
(24, 29, 'bank_account_owner', 'Chủ tài khoản', 'text', 'text', 'Lê Ngọc Doãn', 2, '[]', 0),
(25, 29, 'bank_name', 'Tên ngân hàng', 'text', 'text', 'BIDV', 3, '[]', 0),
(26, 29, 'bank_branch', 'Chi nhánh', 'text', 'text', 'Hòa Bình', 4, '[]', 0),
(27, 30, 'mail_driver', 'Mail Drive', 'text', 'text', 'smtp', 1, '{\"placeholder\":\"V\\u00ed d\\u1ee5: smtp\"}', 0),
(28, 30, 'mail_host', 'Mail host', 'text', 'text', 'smtp.gmail.com', 2, '{\"placeholder\":\"V\\u00ed d\\u1ee5: smtp.gmail.com\"}', 0),
(29, 30, 'mail_post', 'Mail Port', 'number', 'text', '587', 3, '{\"placeholder\":\"V\\u00ed d\\u1ee5: 587\"}', 0),
(30, 30, 'mail_encryption', 'Chuẩn mã hóa', 'text', 'text', 'tls', 4, '{\"placeholder\":\"V\\u00ed d\\u1ee5: tls\"}', 0),
(31, 30, 'mail_username', 'Tài khoản đăng nhập mail', 'text', 'text', 'developer.vcc@gmail.com', 5, '{\"placeholder\":\"V\\u00ed d\\u1ee5: example@domain.com\"}', 0),
(32, 30, 'mail_password', 'Mật khẩu', 'password', 'text', 'DH.Tech.2020', 6, '{\"placeholder\":\"Nh\\u1eadp m\\u1eadt kh\\u1ea9u \\u0111\\u0103ng nh\\u1eadp email\"}', 0),
(33, 30, 'mail_from_address', 'Email gửi đi (fake)', 'text', 'text', 'support@webhay.vcc.vn', 7, '{\"placeholder\":\"V\\u00ed d\\u1ee5: example@domain.com\"}', 0),
(34, 30, 'mail_from_name', 'Tên người gửi', 'text', 'text', 'WebHay', 8, '{\"placeholder\":\"V\\u00ed d\\u1ee5: Nguy\\u1ec5n V\\u0103n A ho\\u1eb7c t\\u00ean c\\u00f4ng ty\"}', 0),
(35, 2, 'mobile_logo', 'Mobile Logo', 'file', 'text', 'mobile_logo.png', 5, '[]', 0),
(36, 2, 'footer_logo', 'Footer Logo', 'file', 'text', 'footer_logo.png', 6, '[]', 0),
(37, 63, 'post_per_page', 'Số lượng bài viết hiển thị trên một trang', 'number', 'number', '12', 0, '{\"min\":1}', 0),
(38, 63, 'page_per_page', 'Số lượng trang con hiển thị trên một trang', 'number', 'number', '12', 0, '{\"min\":1}', 0),
(39, 63, 'product_per_page', 'Số lượng sản phẩm hiển thị trên một trang', 'number', 'number', '12', 0, '{\"min\":1}', 0),
(40, 63, 'project_per_page', 'Số lượng dự án hiển thị trên một trang', 'number', 'number', '10', 0, '{\"min\":1}', 0),
(41, 63, 'result_per_page', 'Số lượng kết quả tìm kiếm hiển thị trên một trang', 'number', 'number', '10', 0, '{\"min\":1}', 0),
(42, 63, 'post_show_list_type', 'Ưu tiên hiển thị trong các mục bài viết', 'radio', 'text', 'post', 0, '{\"data\":{\"post\":\"T\\u1ea5t c\\u1ea3 tin b\\u00e0i\",\"category\":\"Danh m\\u1ee5c ho\\u1eb7c danh m\\u1ee5c con\"}}', 0),
(43, 259, 'facebook', 'Facebook JS SDK', 'textarea', 'text', '<div id=\"fb-root\"></div>\r\n            <script>(function(d, s, id) {\r\n              var js, fjs = d.getElementsByTagName(s)[0];\r\n              if (d.getElementById(id)) return;\r\n              js = d.createElement(s); js.id = id;\r\n              js.src = \"https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0\";\r\n              fjs.parentNode.insertBefore(js, fjs);\r\n            }(document, \'script\', \'facebook-jssdk\'));</script>', 1, '{\"placeholder\":\"M\\u00e3 SDK t\\u1eeb \\u1ee9ng d\\u1ee5ng c\\u1ee7a b\\u1ea1n\",\"className\":\"auto-height\"}', 0),
(44, 259, 'twitter', 'Twitter JS SDK', 'textarea', 'text', '<script>window.twttr = (function(d, s, id) {\r\n                var js, fjs = d.getElementsByTagName(s)[0],\r\n                  t = window.twttr || {};\r\n                if (d.getElementById(id)) return t;\r\n                js = d.createElement(s);\r\n                js.id = id;\r\n                js.src = \"https://platform.twitter.com/widgets.js\";\r\n                fjs.parentNode.insertBefore(js, fjs);\r\n              \r\n                t._e = [];\r\n                t.ready = function(f) {\r\n                  t._e.push(f);\r\n                };\r\n              \r\n                return t;\r\n              }(document, \"script\", \"twitter-wjs\"));</script>', 2, '{\"placeholder\":\"M\\u00e3 SDK t\\u1eeb \\u1ee9ng d\\u1ee5ng c\\u1ee7a b\\u1ea1n\",\"className\":\"auto-height\"}', 0),
(45, 260, 'show_mode', 'Ưu tiên hiển thị', 'radio', 'text', 'posts', 1, '{\"data\":{\"posts\":\"T\\u1ea5t c\\u1ea3 tin b\\u00e0i\",\"categories\":\"Danh m\\u1ee5c ho\\u1eb7c danh m\\u1ee5c con\"}}', 0),
(46, 260, 'per_page', 'Số bài viết hiển thị trên một trang', 'number', 'number', '12', 2, '{\"min\":1}', 0),
(47, 260, 'comment_approve_request', 'Duyệt bình luận', 'checkbox', 'boolean', NULL, 3, '{\"template\":\"switch\"}', 0),
(48, 261, 'per_page', 'Số sản phẩm hiển thị trên một trang', 'number', 'number', '12', 1, '{\"min\":1}', 0),
(49, 261, 'comment_approve_request', 'Duyệt bình luận', 'checkbox', 'boolean', NULL, 2, '{\"template\":\"switch\"}', 0),
(50, 261, 'review_approve_request', 'Đánh giá luận', 'checkbox', 'boolean', NULL, 3, '{\"template\":\"switch\"}', 0),
(51, 262, 'show_mode', 'Ưu tiên hiển thị', 'radio', 'text', 'posts', 1, '{\"data\":{\"projects\":\"T\\u1ea5t c\\u1ea3 d\\u1ef1 \\u00e1n\",\"categories\":\"Danh m\\u1ee5c ho\\u1eb7c danh m\\u1ee5c con\"}}', 0),
(52, 262, 'per_page', 'Số Dự án hiển thị trên một trang', 'number', 'number', '12', 2, '{\"min\":1}', 0),
(53, 262, 'comment_approve_request', 'Duyệt bình luận', 'checkbox', 'boolean', NULL, 3, '{\"template\":\"switch\"}', 0),
(54, 1, 'theme_id', 'theme_id', 'hidden', 'number', '4', 7, '[]', 0),
(55, 263, 'web_type', 'web_type', 'hidden', 'text', 'default', 1, '[]', 0),
(56, 263, 'theme_id', 'theme_id', 'hidden', 'number', '1', 2, '[]', 0),
(57, 264, 'color', 'Màu chủ dạo', 'colorselect', 'text', 'orange', 1, '{\"@colors\":{\"red\":{\"text\":\"\\u0110\\u1ecf\",\"color\":\"#e4000d\",\"value\":\"red\"},\"blue\":{\"text\":\"Xanh da tr\\u1eddi\",\"color\":\"#53b1ff\",\"value\":\"blue\"},\"dark-blue\":{\"text\":\"Xanh da tr\\u1eddi \\u0110\\u1eadm\",\"color\":\"#00469a\",\"value\":\"dark-blue\"},\"green\":{\"text\":\"Xanh l\\u00e1\",\"color\":\"#4cb050\",\"value\":\"green\"},\"orange\":{\"text\":\"Cam\",\"color\":\"#fb8c00\",\"value\":\"orange\"},\"deep-orange\":{\"text\":\"Cam \\u0111\\u1ecf\",\"color\":\"#ff4011\",\"value\":\"deep-orange\"},\"turquoise\":{\"text\":\"Xanh san h\\u00f4\",\"color\":\"#39c9bb\",\"value\":\"turquoise\"},\"pink\":{\"text\":\"H\\u1ed3ng\",\"color\":\"#ea0253\",\"value\":\"pink\"},\"purple\":{\"text\":\"T\\u00edm\",\"color\":\"#6441a5\",\"value\":\"purple\"},\"slate\":{\"text\":\"X\\u00e1m l\\u00f4ng chu\\u1ed9t\",\"color\":\"#64666c\",\"value\":\"slate\"}}}', 0),
(58, 264, 'show_pageloader', 'Hiển thị page loader', 'switch', 'boolean', '1', 2, '{\"check_label\":\"C\\u00f3\"}', 0),
(59, 265, 'show_text_logo', 'Hiển thị text logo', 'switch', 'boolean', '1', 1, '{\"check_label\":\"C\\u00f3\"}', 0),
(60, 265, 'text_logo_primary', 'Text Logo (chính)', 'text', 'text', 'Tin Tức', 2, '[]', 0),
(61, 265, 'text_logo_second', 'text_logo_second', 'text', 'text', '24/7', 3, '{\"Label\":\"Text Logo (b\\u1ed5 xung)\"}', 0),
(62, 265, 'highlight', 'làm nổi bật', 'select', 'text', NULL, 4, '{\"data\":{\"none\":\"Kh\\u00f4ng\",\"primary\":\"Text ch\\u00ednh\",\"second\":\"Text ph\\u1ee5\",\"both\":\"T\\u1ea5t c\\u1ea3\"}}', 0),
(63, 265, 'text_logo_slogan', 'text_logo_slogan', 'text', 'text', NULL, 5, '{\"Label\":\"Kh\\u1ea9u hi\\u1ec7u\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"}', 0),
(64, 265, 'show_banner', 'Hiển thị banner quảng cáo', 'switch', 'boolean', '1', 6, '{\"check_label\":\"C\\u00f3\"}', 0),
(65, 265, 'banner_image', 'Banner 720 x 90', 'file', 'text', NULL, 7, '{\"template\":\"cropit\",\"data-width\":720,\"data-height\":90}', 0),
(66, 265, 'banner_alt', 'Chú thích banner', 'text', 'text', NULL, 8, '[]', 0),
(67, 265, 'banner_link', 'Liên kết', 'text', 'text', NULL, 9, '[]', 0),
(68, 265, 'ads_type', 'Loại quảng cáo', 'radio', 'text', NULL, 10, '{\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"}', 0),
(69, 265, 'ads_code', 'Mã quảng cáo', 'textarea', 'text', NULL, 11, '{\"placeholder\":\"Nhap76 m\\u00e3 qu\\u1ea3ng c\\u00e1o\"}', 0),
(70, 265, 'show_datetime', 'Hiển thị thời gian', 'switch', 'boolean', '1', 12, '{\"check_label\":\"C\\u00f3\"}', 0),
(71, 265, 'datetime_lang', 'Ngôn ngữ', 'radio', 'text', 'vi', 13, '{\"data\":{\"vi\":\"Ti\\u1ebfng Vi\\u1ec7t\",\"en\":\"Ti\\u1ebfng Anh\"}}', 0),
(72, 265, 'date_format', 'Định dạng ngày tháng', 'text', 'text', '%w, ngày %d $M %y', 14, '{\"placeholder\":\"v\\u00ed d\\u1ee5: w, d\\/m\\/y\",\"comment\":\"trong \\u0111\\u00f3: %w l\\u00e0 ng\\u00e0y trong tu\\u1ea7n, %d l\\u00e0 ng\\u00e0y trong th\\u00e1ng, %m l\\u00e0 th\\u00e1ng b\\u00e0ng s\\u1ed1, %M l\\u00e0 th\\u00e1ng b\\u00e0ng t\\u00ean, %yy l\\u00e0 n\\u0103m\"}', 0),
(73, 266, 'news_footer', 'footer Widget', 'area', 'text', 'news_footer', 1, '[]', 0),
(74, 266, 'copyright', 'Copyright', 'text', 'text', NULL, 2, '[]', 0),
(75, 266, 'facebook', 'Facebook', 'text', 'text', NULL, 3, '{\"placeholder\":\"Li\\u00ean k\\u1ebft Facebook\"}', 0),
(76, 266, 'twitter', 'Twitter', 'text', 'text', NULL, 4, '{\"placeholder\":\"Li\\u00ean k\\u1ebft Twitter\"}', 0),
(77, 266, 'linkedin', 'LinkedIn', 'text', 'text', NULL, 5, '{\"placeholder\":\"Li\\u00ean k\\u1ebft LinkedIn\"}', 0),
(78, 266, 'youtube', 'Youtube', 'text', 'text', NULL, 6, '{\"placeholder\":\"Li\\u00ean k\\u1ebft Youtube\"}', 0),
(79, 267, 'widgets', 'Widgets', 'area', 'text', 'news_sidebar', 1, '[]', 0),
(80, 268, 'sections', 'Các mục xuất hiện trên trang chủ', 'area', 'text', 'home', 1, '[]', 0),
(81, 269, 'title', 'Tiêu đề giới thiệu (Tùy chọn)', 'text', 'text', NULL, 1, '[]', 0),
(82, 269, 'description', 'Mô tả (Tùy chọn)', 'textarea', 'text', NULL, 2, '[]', 0),
(83, 269, 'show_map', 'Hiển thị Bản đồ', 'switch', 'boolean', NULL, 3, '{\"check_label\":\"C\\u00f3\"}', 0),
(84, 269, 'place', 'Tên địa điểm', 'text', 'text', NULL, 4, '[]', 0),
(85, 269, 'lat', 'Vĩ độ (latitude)', 'text', 'text', NULL, 5, '[]', 0),
(86, 269, 'long', 'Vĩ độ (longitude)', 'text', 'text', NULL, 6, '[]', 0),
(87, 269, 'map_type', 'Loại bản đồ', 'radio', 'text', NULL, 7, '{\"data\":{\"lib\":\"D\\u00f9ng th\\u01b0 vi\\u1ec7n\",\"code\":\"D\\u00f9ng m\\u00e3 nh\\u00fang\"},\"default\":\"lib\"}', 0),
(88, 269, 'map_code', 'Mã nhúng bản đồ', 'textarea', 'text', NULL, 8, '{\"placeholder\":\"Nh\\u1eadp m\\u00e3 M\\u00e3 nh\\u00fang\"}', 0),
(89, 269, 'email', 'email', 'text', 'text', NULL, 9, '{\"Label\":\"Email\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"}', 0),
(90, 269, 'phone_number', 'phone_number', 'text', 'text', NULL, 10, '{\"Label\":\"S\\u1ed1 \\u0111i\\u1ec7n tho\\u1ea1i\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"}', 0),
(91, 269, 'address', 'address', 'text', 'text', NULL, 11, '{\"Label\":\"\\u0110\\u1ecba ch\\u1ec9\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"}', 0),
(92, 269, 'facebook', 'facebook (Tùy chọn)', 'text', 'text', NULL, 12, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(93, 269, 'twitter', 'twitter (Tùy chọn)', 'text', 'text', NULL, 13, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(94, 269, 'youtube', 'youtube (Tùy chọn)', 'text', 'text', NULL, 14, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(95, 269, 'linkedin', 'Linkedin (Tùy chọn)', 'text', 'text', NULL, 15, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(96, 269, 'instagram', 'instagram (Tùy chọn)', 'text', 'text', NULL, 16, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(97, 269, 'pinterest', 'Pinterest (Tùy chọn)', 'text', 'text', NULL, 17, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(98, 270, 'show_banner', 'Hiển thị banner quảng cáo', 'switch', 'boolean', '1', 1, '{\"check_label\":\"C\\u00f3\"}', 0),
(99, 270, 'banner_image', 'Banner 1248 x 130', 'file', 'text', NULL, 2, '[]', 0),
(100, 270, 'banner_alt', 'Chú thích banner', 'text', 'text', NULL, 3, '[]', 0),
(101, 270, 'banner_link', 'Liên kết', 'text', 'text', NULL, 4, '[]', 0),
(102, 270, 'ads_type', 'Loại quảng cáo', 'radio', 'text', NULL, 5, '{\"data\":{\"banner\":\"Banner\",\"code\":\"M\\u00e3 qu\\u1ea3ng c\\u00e1o\"},\"default\":\"banner\"}', 0),
(103, 270, 'ads_code', 'Mã quảng cáo', 'textarea', 'text', NULL, 6, '{\"placeholder\":\"Nh\\u1eadp m\\u00e3 qu\\u1ea3ng c\\u00e1o\"}', 0),
(104, 270, 'show_related_url', 'Hiển thị link các tin bài liên quan', 'switch', 'boolean', '1', 7, '{\"check_label\":\"C\\u00f3\"}', 0),
(105, 270, 'single_post', 'Các mục bổ xung', 'area', 'text', 'single_post', 8, '[]', 0),
(106, 271, 'single_page', 'Các mục bổ xung', 'area', 'text', 'single_post', 1, '[]', 0),
(107, 272, 'show', 'Hiển thị Text Slider (hero) ', 'switch', 'boolean', '1', 1, '{\"check_label\":\"C\\u00f3\"}', 0),
(108, 272, 'background', 'background', 'file', 'text', NULL, 2, '{\"Label\":\"H\\u00ecnh n\\u1ec1n\"}', 0),
(109, 272, 'sub_title', 'Tiêu đề trên', 'text', 'text', 'Connecting to the future', 3, '[]', 0),
(110, 272, 'static_title', 'Tiêu đề tĩnh', 'text', 'text', 'We are', 4, '[]', 0),
(111, 272, 'typed_title', 'Tiêu đề động (typed text)', 'text', 'text', 'Web Developer, Web Designer', 5, '[]', 0),
(112, 272, 'description', 'Mô tả', 'textarea', 'text', 'Our work is the presentation of our capabilities. Professionally myocardinate\n high standards in infrastructures and focused solutions. Completely actualize\n multifunctional best practices', 6, '{\"placeholder\":\"Nh\\u1eadp m\\u00f4 t\\u1ea3\"}', 0),
(113, 272, 'button_link', 'Button Link', 'text', 'text', '#service', 7, '[]', 0),
(114, 272, 'button_text', 'Button Text', 'text', 'text', 'Our Services', 8, '[]', 0),
(115, 273, 'show', 'Hiển thị promo ', 'switch', 'boolean', '1', 1, '{\"check_label\":\"C\\u00f3\"}', 0),
(116, 273, 'extra_class', 'Extra class', 'text', 'text', '', 2, '{\"placeholder\":\"V\\u00ed d\\u1ee5: bg-gray\"}', 0),
(117, 273, 'promos', 'Promo Items', 'area', 'text', 'promos', 3, '[]', 0),
(118, 274, 'show', 'Hiển thị phần giới thiệu ', 'switch', 'boolean', '1', 1, '{\"check_label\":\"C\\u00f3\"}', 0),
(119, 274, 'section_title', 'Tiêu đề section', 'text', 'text', 'Giới thiệu', 2, '[]', 0),
(120, 274, 'page_id', 'Trang giới thiệu (tùy chọn)', 'crazyselect', 'text', NULL, 3, '{\"call\":\"get_page_options\",\"params\":[[],\"Ch\\u1ecdn m\\u1ed9t\"]}', 0),
(121, 274, 'title', 'Tiêu đề giới thiệu', 'text', 'text', 'Đôi nét về chúng tôi', 4, '[]', 0),
(122, 274, 'description', 'Nội dung Giới thiệu', 'ckeditor', 'text', NULL, 5, '{\"height\":\"200\"}', 0),
(123, 274, 'image', 'Ảnh minh họa', 'file', 'text', NULL, 6, '[]', 0),
(124, 275, 'show', 'Hiển thị phần dịch vụ ', 'switch', 'boolean', '1', 1, '{\"check_label\":\"C\\u00f3\"}', 0),
(125, 275, 'sub_title', 'Tiêu đề nhỏ (tùy chọn)', 'text', 'text', '', 2, '[]', 0),
(126, 275, 'title', 'Tiêu đề', 'text', 'text', 'Dịch vụ', 3, '[]', 0),
(127, 275, 'services', 'Các dịch vụ', 'area', 'text', 'services', 4, '[]', 0),
(128, 276, 'show', 'Hiển thị mục Dự án', 'switch', 'boolean', '1', 1, '{\"check_label\":\"C\\u00f3\"}', 0),
(129, 276, 'sub_title', 'Tiêu đề phụ', 'text', 'text', NULL, 2, '[]', 0),
(130, 276, 'title', 'Tiêu đề', 'text', 'text', 'Dự án', 3, '[]', 0),
(131, 276, 'sorttype', 'Kiểu sắp xếp', 'crazyselect', 'text', '1', 4, '{\"call\":\"get_project_sortby_options\"}', 0),
(132, 276, 'project_number', 'Số lượng', 'number', 'text', '10', 5, '[]', 0),
(133, 277, 'show', 'Hiển thị trang Báo giá', 'switch', 'boolean', '1', 1, '{\"check_label\":\"C\\u00f3\"}', 0),
(134, 277, 'sub_title', 'Tiêu đề phụ', 'text', 'text', NULL, 2, '[]', 0),
(135, 277, 'title', 'Tiêu đề', 'text', 'text', 'Bảng giá', 3, '[]', 0),
(136, 277, 'description', 'Mô tả ', 'textarea', 'text', NULL, 4, '[]', 0),
(137, 277, 'layout', 'Layout', 'crazyselect', 'text', '1', 5, '{\"data\":{\"1\":\"4 \\/ 7\",\"2\":\"4 \\/ 8\",\"3\":\"3 \\/ 8\",\"4\":\"3 \\/ 9\"}}', 0),
(138, 277, 'tab_active', 'Tab kích hoạt', 'radio', 'text', NULL, 6, '{\"data\":{\"1\":\"Tab 1\",\"2\":\"Tab 2\",\"3\":\"Tab 3\"}}', 0),
(139, 277, 'tab_1_show', 'Hiển thị Tab 1', 'switch', 'boolean', '1', 7, '{\"check_label\":\"C\\u00f3\"}', 0),
(140, 277, 'tab_1_title', 'Tiêu đề tab 1', 'text', 'text', 'Basic', 8, '[]', 0),
(141, 277, 'tab_1_packages', 'Các gói trong tab 1', 'area', 'text', 'tab_1_packages', 9, '[]', 0),
(142, 277, 'tab_2_show', 'Hiển thị Tab 2', 'switch', 'boolean', NULL, 10, '{\"check_label\":\"C\\u00f3\"}', 0),
(143, 277, 'tab_2_title', 'Tiêu đề tab 2', 'text', 'text', '', 11, '[]', 0),
(144, 277, 'tab_2_packages', 'Các gói trong tab 2', 'area', 'text', 'tab_2_packages', 12, '[]', 0),
(145, 277, 'tab_3_show', 'Hiển thị Tab 3', 'switch', 'boolean', NULL, 13, '{\"check_label\":\"C\\u00f3\"}', 0),
(146, 277, 'tab_3_title', 'Tiêu đề tab 3', 'text', 'text', NULL, 14, '[]', 0),
(147, 277, 'tab_3_packages', 'Các gói trong tab 3', 'area', 'text', 'tab_3_packages', 15, '[]', 0),
(148, 278, 'show', 'Hiển thị Testimonials', 'switch', 'boolean', '1', 1, '[]', 0),
(149, 278, 'sub_title', 'Tiêu đề phụ', 'text', 'text', NULL, 2, '[]', 0),
(150, 278, 'title', 'Tiêu đề', 'text', 'text', 'Phản hồi từ khách hàng', 3, '[]', 0),
(151, 278, 'background', 'background', 'file', 'text', NULL, 4, '{\"Label\":\"H\\u00ecnh n\\u1ec1n\"}', 0),
(152, 278, 'list_type', 'Kiểu danh sách', 'radio', 'text', 'custom', 5, '{\"data\":{\"data\":\"Trong b\\u1ea3ng ph\\u1ea3n h\\u1ed3i\",\"custom\":\"Danh s\\u00e1ch t\\u00f9y bi\\u1ebfn\"}}', 0),
(153, 278, 'item_number', 'Số lượng', 'number', 'text', '0', 6, '[]', 0),
(154, 278, 'sort_type', 'Sắp xếp', 'crazyselect', 'text', 'id-ASC', 7, '{\"data\":{\"id-ASC\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"id-DESC\":\"M\\u1edbi nh\\u1ea5t\",\"name-ASC\":\"h\\u1ee9 t\\u1ef1 b\\u1ea3ng ch\\u1ef1 c\\u00e1i\"}}', 0),
(155, 278, 'testimonials', 'Danh sách phản hồi tùy biến', 'area', 'text', 'testimonials', 8, '{\"@title-by\":\"name\"}', 0),
(156, 279, 'show', 'Hiển thị Nhóm làm việc', 'switch', 'boolean', '1', 1, '[]', 0),
(157, 279, 'sub_title', 'Tiêu đề phụ', 'text', 'text', NULL, 2, '[]', 0),
(158, 279, 'title', 'Tiêu đề', 'text', 'text', 'Team', 3, '[]', 0),
(159, 279, 'list_type', 'Kiểu danh sách', 'radio', 'text', 'custom', 4, '{\"data\":{\"data\":\"Trong b\\u1ea3ng Nh\\u00f3m\",\"custom\":\"Danh s\\u00e1ch t\\u00f9y bi\\u1ebfn\"}}', 0),
(160, 279, 'team_id', 'Nhóm', 'crazyselect', 'text', NULL, 5, '{\"call\":\"get_team_options\",\"params\":[[],\"Ch\\u1ecdn nh\\u00f3m\"]}', 0),
(161, 279, 'item_number', 'Số lượng', 'number', 'text', '4', 6, '[]', 0),
(162, 279, 'sort_type', 'Sắp xếp', 'crazyselect', 'text', 'id-ASC', 7, '{\"data\":{\"id-ASC\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"id-DESC\":\"M\\u1edbi nh\\u1ea5t\",\"users.name-ASC\":\"th\\u1ee9 t\\u1ef1 b\\u1ea3ng ch\\u1ef1 c\\u00e1i\",\"is_leader-DESC\":\"\\u01afu ti\\u00ean tr\\u01b0\\u1edfng nh\\u00f3m\",\"job-ASC\":\"C\\u00f4ng vi\\u1ec7c (A-z)\",\"rand()\":\"Ng\\u1eabu nhi\\u00ean\"}}', 0),
(163, 279, 'members', 'Danh sách thành viên tùy biến', 'area', 'text', 'team_members', 8, '{\"@title-by\":\"name\"}', 0),
(164, 280, 'show', 'Hiển thị mục liên hệ', 'switch', 'boolean', '1', 1, '{\"check_label\":\"C\\u00f3\"}', 0),
(165, 280, 'sub_title', 'Tiêu đề phụ', 'text', 'text', NULL, 2, '[]', 0),
(166, 280, 'title', 'Tiêu đề', 'text', 'text', 'Dự án', 3, '[]', 0),
(167, 280, 'button_text', 'Nút gửi', 'text', 'text', 'Gửi liên hệ', 4, '[]', 0),
(168, 280, 'project_number', 'Số lượng', 'number', 'text', '10', 5, '[]', 0),
(169, 281, 'copyright', 'Tuyên bố bản quyền', 'text', 'text', NULL, 1, '[]', 0),
(170, 281, 'show_socials', 'Hiển thị MXH', 'switch', 'boolean', NULL, 2, '{\"check_label\":\"C\\u00f3\"}', 0),
(171, 281, 'facebook', 'Facebook', 'text', 'text', NULL, 3, '{\"placeholder\":\"Li\\u00ean k\\u1ebft Facebook\"}', 0),
(172, 281, 'twitter', 'Twitter', 'text', 'text', NULL, 4, '{\"placeholder\":\"Li\\u00ean k\\u1ebft Twitter\"}', 0),
(173, 281, 'linkedin', 'LinkedIn', 'text', 'text', NULL, 5, '{\"placeholder\":\"Li\\u00ean k\\u1ebft LinkedIn\"}', 0),
(174, 281, 'youtube', 'Youtube', 'text', 'text', NULL, 6, '{\"placeholder\":\"Li\\u00ean k\\u1ebft Youtube\"}', 0),
(175, 1, 'web_type', 'Loại web', 'radio', 'text', 'business', 2, '{\"required\":\"true\",\"template\":\"checklist\",\"call\":\"get_system_config\",\"params\":[\"web_type_list\"]}', 0),
(176, 282, 'show_top', 'Hiển thị text trung tâm', 'switch', 'boolean', '0', 1, '{\"check_label\":\"C\\u00f3\"}', 0),
(177, 283, 'footer', 'footer Widget', 'area', 'text', 'footer', 1, '[]', 0),
(178, 283, 'copyright', 'Copyright', 'text', 'text', NULL, 2, '[]', 0),
(179, 284, 'widgets', 'Post sidebar Widgets', 'area', 'text', 'sidebar_post', 1, '[]', 0),
(180, 286, 'page_title', 'Tiêu đề Trang liên hệ', 'text', 'text', 'Liên hệ', 1, '[]', 0),
(181, 286, 'page_description', 'Mô rả trang liên hệ', 'textarea', 'text', NULL, 2, '{\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"}', 0),
(182, 286, 'email', 'email', 'text', 'text', 'doanln16@gmail.com', 3, '{\"Label\":\"Email\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"}', 0),
(183, 286, 'phone_number', 'phone_number', 'text', 'text', '0945786960', 4, '{\"Label\":\"S\\u1ed1 \\u0111i\\u1ec7n tho\\u1ea1i\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"}', 0),
(184, 286, 'address', 'address', 'text', 'text', '172, đường Bà Triệu, tp. Hòa Bình', 5, '{\"Label\":\"\\u0110\\u1ecba ch\\u1ec9\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"}', 0),
(185, 286, 'form_title', 'Tiêu đề Form liên hệ', 'text', 'text', 'Hãy nói về những ý tưởng của bạn', 6, '[]', 0),
(186, 286, 'form_description', 'Mô rả / Giới thiệu', 'textarea', 'text', NULL, 7, '{\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"}', 0),
(187, 286, 'button_text', 'Nút gửi', 'text', 'text', 'Gửi liên hệ', 8, '[]', 0),
(188, 286, 'map_code', 'Mã nhúng bản đồ', 'textarea', 'text', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7460.325174749554!2d105.34500953207903!3d20.784709252940647!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31346b301d6dc449%3A0xd79703248d7378cb!2zMTcyIELDoCBUcmnhu4d1LCBDaMSDbSBNw6F0LCBIw7JhIELDrG5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1589342330149!5m2!1svi!2s\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0;\" allowfullscreen=\"\" aria-hidden=\"false\" tabindex=\"0\"></iframe>', 9, '{\"placeholder\":\"Nh\\u1eadp m\\u00e3 M\\u00e3 nh\\u00fang\"}', 0),
(189, 287, 'facebook', 'facebook (Tùy chọn)', 'text', 'text', 'https://www.facebook.com/LeNgocDoan', 1, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(190, 287, 'twitter', 'twitter (Tùy chọn)', 'text', 'text', 'https://twitter.com/NgocDoanLe', 2, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(191, 287, 'youtube', 'youtube (Tùy chọn)', 'text', 'text', 'https://www.youtube.com/channel/UCIPikHMH4Br5xRWW_YIOOTw', 3, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(192, 287, 'linkedin', 'Linkedin (Tùy chọn)', 'text', 'text', NULL, 4, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(193, 287, 'instagram', 'instagram (Tùy chọn)', 'text', 'text', NULL, 5, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(194, 287, 'pinterest', 'Pinterest (Tùy chọn)', 'text', 'text', NULL, 6, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(195, 282, 'logo_light', 'Logo Trắng (light)', 'file', 'text', 'logo_light.png', 3, '[]', 0),
(196, 282, 'logo', 'Logo', 'file', 'text', 'logo.png', 2, '[]', 0),
(197, 285, 'home', 'Thành phàn trang chủ', 'area', 'text', 'home', 1, '{\"@title-by\":\"title\"}', 0),
(198, 285, 'home_services', 'Danh sách dịch vụ', 'area', 'text', 'home_services', 2, '{\"@title-by\":\"title\"}', 0),
(199, 285, 'testimonials', 'Danh sách phản hồi tùy biến', 'area', 'text', 'testimonials', 3, '{\"@title-by\":\"name\"}', 0),
(200, 285, 'members', 'Danh sách thành viên tùy biến', 'area', 'text', 'team_members', 4, '{\"@title-by\":\"name\"}', 0),
(201, 285, 'contact_faq', 'Các Câu hỏi thường gặp', 'area', 'text', 'contact_faq', 5, '{\"@title-by\":\"title\"}', 0),
(202, 285, 'home_pricing', 'báo giá Các gói dịch vụ', 'area', 'text', 'home_pricing', 6, '{\"@title-by\":\"title\"}', 0),
(203, 282, 'page_header_background', 'Hình nền đầu trang mặc định (Tùy chọn)', 'file', 'text', NULL, 4, '[]', 0),
(204, 282, 'page_header_padding_y', 'Căn trên dưới đầu trang (px)', 'number', 'text', '100', 5, '{\"default\":\"160\"}', 0),
(205, 282, 'page_header_breakcrumb_bottom', 'breakcrumb position-Bottom (px)', 'number', 'text', '-125', 6, '{\"default\":\"-180\"}', 0),
(206, 288, 'page_header_background', 'Hình nền đầu trang mặc định (Tùy chọn)', 'file', 'text', NULL, 1, '[]', 0),
(207, 289, 'page_header_background', 'Hình nền đầu trang mặc định (Tùy chọn)', 'file', 'text', NULL, 1, '[]', 0),
(208, 290, 'page_header_background', 'Hình nền đầu trang mặc định (Tùy chọn)', 'file', 'text', NULL, 1, '[]', 0),
(209, 291, 'page_header_background', 'Hình nền đầu trang mặc định (Tùy chọn)', 'file', 'text', NULL, 1, '[]', 0),
(210, 291, 'page_header_padding_y', 'Căn trên dưới đầu trang (px)', 'number', 'text', NULL, 2, '{\"default\":\"160\"}', 0),
(211, 291, 'page_header_breakcrumb_bottom', 'Link position-Bottom (px)', 'number', 'text', NULL, 3, '{\"default\":\"-180\"}', 0),
(212, 282, 'page_header_breadcrumb_bottom', 'breakcrumb position-Bottom (px)', 'number', 'text', '-125', 6, '{\"default\":\"-180\"}', 0),
(213, 284, 'project_widgets', 'project sidebar Widgets', 'area', 'text', 'sidebar_project', 2, '[]', 0),
(214, 284, 'page_widgets', 'page sidebar Widgets', 'area', 'text', 'sidebar_page', 3, '{\"default\":\"sidebar_page\"}', 0),
(215, 286, 'faq_title', 'Tiêu đề FAQ (Tùy chọn)', 'text', 'text', NULL, 10, '[]', 0),
(216, 286, 'contact_faq', 'Các Câu hỏi thường gặp', 'area', 'text', 'contact_faq', 11, '{\"@title-by\":\"title\"}', 0),
(217, 292, 'logo', 'Logo', 'file', 'text', NULL, 1, '[]', 0),
(218, 292, 'logo_light', 'Logo Trắng (light)', 'file', 'text', NULL, 2, '[]', 0),
(219, 292, 'register_title', 'Tiêu đề mục đăng ký', 'text', 'text', 'Đăng ký để nhận tài khoản dùng thử miển phí', 3, '[]', 0),
(220, 292, 'register_description', 'Mô rả mục đăng ký', 'textarea', 'text', 'Bạn chỉ cần nêu ra những ý tưởng, phần còn lại để chúng tôi lo!', 4, '{\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"}', 0),
(221, 2, 'admin_page_logo', 'Logo trang admin', 'file', 'text', 'admin_page_logo.png', 7, NULL, 1),
(222, 2, 'admin_login_logo', 'Logo trang login', 'file', 'text', 'admin_login_logo.png', 8, NULL, 1),
(223, 293, 'default_style', 'Style mặc định', 'radio', 'text', '1', 1, '{\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\"},\"default\":\"1\"}', 0),
(224, 293, 'logo', 'Logo', 'file', 'text', 'logo.png', 2, '[]', 0),
(225, 293, 'logo_light', 'Logo Trắng (light)', 'file', 'text', 'logo_light.png', 3, '[]', 0),
(226, 293, 'nav_1_show_button', 'Nút đặc biệt', 'switch', 'boolean', '0', 4, '{\"check_label\":\"Hi\\u1ec3n th\\u1ecb n\\u00fat b\\u1ea5m d\\u1eabn t\\u1edbi url n\\u00e0o \\u0111\\u00f3\"}', 0),
(227, 293, 'nav_1_button_url', 'Đường dẫn', 'text', 'text', NULL, 5, '[]', 0),
(228, 293, 'nav_1_button_text', 'Text hiển thĩ', 'text', 'text', 'Dùng thử', 6, '[]', 0),
(229, 293, 'nav_2_show_button', 'Nút đặc biệt', 'switch', 'boolean', '0', 7, '{\"check_label\":\"Hi\\u1ec3n th\\u1ecb n\\u00fat b\\u1ea5m d\\u1eabn t\\u1edbi url n\\u00e0o \\u0111\\u00f3\"}', 0),
(230, 293, 'nav_2_button_url', 'Đường dẫn', 'text', 'text', NULL, 8, '[]', 0),
(231, 293, 'nav_2_button_text', 'Text hiển thĩ', 'text', 'text', 'Dùng thử', 9, '[]', 0),
(232, 294, 'copyright', 'Copyright', 'textarea', 'text', NULL, 1, '[]', 0),
(233, 294, 'widgets', 'Widget', 'area', 'text', 'docly_footer', 2, '{\"@title-by\":\"title\"}', 0),
(234, 295, 'docs_left_widgets', 'Document Left Sidebar Widgets', 'area', 'text', 'sidebar_docs_left', 1, '[]', 0),
(235, 295, 'docs_right_widgets', 'Document Right Sidebar Widgets', 'area', 'text', 'sidebar_docs_right', 2, '[]', 0),
(236, 295, 'post_sidebar_widgets', 'Post Sidebar Widgets', 'area', 'text', 'sidebar_post', 3, '[]', 0),
(237, 295, 'project_sidebar_widgets', 'Project Sidebar Widgets', 'area', 'text', 'sidebar_project', 4, '[]', 0),
(238, 295, 'page_sidebar_widgets', 'Page Sidebar Widgets', 'area', 'text', 'sidebar_page', 5, '[]', 0),
(239, 296, 'home', 'Thành phàn trang chủ', 'area', 'text', 'home', 1, '{\"@title-by\":\"title\"}', 0),
(240, 296, 'home_services', 'Danh sách dịch vụ', 'area', 'text', 'home_services', 2, '{\"@title-by\":\"title\"}', 0),
(241, 296, 'testimonials', 'Danh sách phản hồi tùy biến', 'area', 'text', 'testimonials', 3, '{\"@title-by\":\"name\"}', 0),
(242, 296, 'members', 'Danh sách thành viên tùy biến', 'area', 'text', 'team_members', 4, '{\"@title-by\":\"name\"}', 0),
(243, 297, 'header_style', 'Header Style mặc định', 'radio', 'text', '2', 1, '{\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\"},\"default\":\"2\"}', 0),
(244, 297, 'show_breadcrumb', 'Breadcrumb', 'switch', 'boolean', '1', 2, '{\"check_label\":\"Hi\\u1ec3n th\\u1ecb breadcrumb\"}', 0),
(245, 297, 'list_layout', 'Layout Danh sách', 'radio', 'text', 'sidebar', 3, '{\"data\":{\"sidebar\":\"sidebar\",\"fullwidth\":\"fullwidth\"},\"default\":\"sidebar\"}', 0),
(246, 297, 'list_type', 'Kiểu Danh sách', 'radio', 'text', 'grid', 4, '{\"data\":{\"list\":\"Danh s\\u00e1ch (list)\",\"grid\":\"L\\u01b0\\u1edbi (grid)\"},\"default\":\"grid\"}', 0),
(247, 297, 'header_bg_default_color', 'Màu có sẵn', 'radio', 'text', NULL, 5, '{\"data\":{\"\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}}', 0),
(248, 297, 'header_bg_color', 'Mã màu (Tùy chọn)', 'text', 'text', NULL, 6, '{\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"}', 0),
(249, 297, 'header_use_bg_image', 'Sử dụng hình nền', 'switch', 'boolean', '1', 7, '{\"check_label\":\"C\\u00f3\"}', 0),
(250, 297, 'header_bg_image', 'Hình nền (Tùy chọn)', 'file', 'text', 'header_bg_image.jpg', 8, '[]', 0),
(251, 297, 'header_bg_position', 'Vị trí ảnh', 'radio', 'text', 'fixed', 9, '{\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}}', 0),
(252, 297, 'header_class_name', 'Class (Tùy chọn)', 'text', 'text', NULL, 10, '[]', 0),
(253, 297, 'detail_use_feature_image', 'Header Image', 'switch', 'boolean', '0', 11, '{\"check_label\":\"S\\u1eed d\\u1ee5ng Feature Image l\\u00e0m h\\u00ecnh n\\u1ec1n Header\"}', 0),
(254, 297, 'detail_hide_feature_image', 'Hide Feature Image', 'switch', 'boolean', '0', 12, '{\"check_label\":\"\\u1ea8n \\u1ea3nh n\\u1ed5i b\\u1eadt tr\\u00ean ph\\u1ea7n \\u0111\\u1ea7u n\\u1ed9i dung\"}', 0),
(255, 297, 'detail_hide_related', 'Hide related', 'switch', 'boolean', '0', 14, '{\"check_label\":\"\\u1ea8n m\\u1ee5c li\\u00ean quan\"}', 0),
(256, 297, 'detail_hide_comments', 'Hide Comments', 'switch', 'boolean', '0', 15, '{\"check_label\":\"\\u1ea8n ph\\u1ea7n b\\u00ecnh lu\\u1eadn\"}', 0),
(257, 297, 'post_settings', 'Mục dược thiết lập', 'area', 'text', 'post_settings', 16, '{\"@title-by\":\"title\"}', 0),
(258, 298, 'header_style', 'Header Style mặc định', 'radio', 'text', '2', 1, '{\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\"},\"default\":\"2\"}', 0),
(259, 298, 'show_breadcrumb', 'Breadcrumb', 'switch', 'boolean', '1', 2, '{\"check_label\":\"Hi\\u1ec3n th\\u1ecb breadcrumb\"}', 0),
(260, 298, 'list_layout', 'Layout Danh sách', 'radio', 'text', 'sidebar', 3, '{\"data\":{\"sidebar\":\"sidebar\",\"fullwidth\":\"fullwidth\"},\"default\":\"sidebar\"}', 0),
(261, 298, 'list_type', 'Kiểu Danh sách', 'radio', 'text', 'grid', 4, '{\"data\":{\"list\":\"Danh s\\u00e1ch (list)\",\"grid\":\"L\\u01b0\\u1edbi (grid)\"},\"default\":\"grid\"}', 0),
(262, 298, 'header_bg_default_color', 'Màu có sẵn', 'radio', 'text', NULL, 5, '{\"data\":{\"\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}}', 0),
(263, 298, 'header_bg_color', 'Mã màu (Tùy chọn)', 'text', 'text', NULL, 6, '{\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"}', 0),
(264, 298, 'header_use_bg_image', 'Sử dụng hình nền', 'switch', 'boolean', '1', 7, '{\"check_label\":\"C\\u00f3\"}', 0),
(265, 298, 'header_bg_image', 'Hình nền (Tùy chọn)', 'file', 'text', 'header_bg_image.jpg', 8, '[]', 0),
(266, 298, 'header_bg_position', 'Vị trí ảnh', 'radio', 'text', 'fixed', 9, '{\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}}', 0),
(267, 298, 'header_class_name', 'Class (Tùy chọn)', 'text', 'text', NULL, 10, '[]', 0),
(268, 299, 'header_style', 'Header Style mặc định', 'radio', 'text', '2', 1, '{\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\"},\"default\":\"2\"}', 0),
(269, 299, 'show_breadcrumb', 'Breadcrumb', 'switch', 'boolean', '1', 2, '{\"check_label\":\"Hi\\u1ec3n th\\u1ecb breadcrumb\"}', 0),
(270, 299, 'header_align_center', 'Align Center', 'switch', 'boolean', '1', 3, '{\"check_label\":\"Hi\\u1ec3n th\\u1ecb ch\\u00ednh gi\\u1eefa\"}', 0),
(271, 299, 'header_hide_author', 'Ẩn tác giả', 'switch', 'boolean', '1', 4, '{\"check_label\":\"\\u1ea8n \\/ kh\\u00f4ng hi\\u1ec3n th\\u1ecb th\\u00f4ng tin t\\u00e1c gi\\u1ea3\"}', 0),
(272, 299, 'header_bg_default_color', 'Màu có sẵn', 'radio', 'text', 'theme', 4, '{\"data\":{\"\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}}', 0),
(273, 299, 'header_bg_color', 'Mã màu (Tùy chọn)', 'text', 'text', NULL, 5, '{\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"}', 0),
(274, 299, 'header_use_bg_image', 'Sử dụng hình nền', 'switch', 'boolean', '0', 6, '{\"check_label\":\"C\\u00f3\"}', 0),
(275, 299, 'header_bg_image', 'Hình nền (Tùy chọn)', 'file', 'text', NULL, 7, '[]', 0),
(276, 299, 'header_bg_position', 'Vị trí ảnh', 'radio', 'text', NULL, 8, '{\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}}', 0),
(277, 299, 'header_class_name', 'Class (Tùy chọn)', 'text', 'text', NULL, 9, '[]', 0),
(278, 300, 'header_style', 'Header Style mặc định', 'radio', 'text', '2', 1, '{\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\"},\"default\":\"2\"}', 0),
(279, 300, 'show_breadcrumb', 'Breadcrumb', 'switch', 'boolean', '1', 2, '{\"check_label\":\"Hi\\u1ec3n th\\u1ecb breadcrumb\"}', 0),
(280, 300, 'list_layout', 'Layout Danh sách', 'radio', 'text', 'sidebar', 3, '{\"data\":{\"sidebar\":\"sidebar\",\"fullwidth\":\"fullwidth\"},\"default\":\"sidebar\"}', 0),
(281, 300, 'list_type', 'Kiểu Danh sách', 'radio', 'text', 'grid', 4, '{\"data\":{\"list\":\"Danh s\\u00e1ch (list)\",\"grid\":\"L\\u01b0\\u1edbi (grid)\"},\"default\":\"grid\"}', 0),
(282, 300, 'header_align_center', 'Align Center', 'switch', 'boolean', '1', 5, '{\"check_label\":\"Hi\\u1ec3n th\\u1ecb ch\\u00ednh gi\\u1eefa\"}', 0),
(283, 300, 'header_hide_author', 'Ẩn tác giả', 'switch', 'boolean', '1', 6, '{\"check_label\":\"\\u1ea8n \\/ kh\\u00f4ng hi\\u1ec3n th\\u1ecb th\\u00f4ng tin t\\u00e1c gi\\u1ea3\"}', 0),
(284, 300, 'header_bg_default_color', 'Màu có sẵn', 'radio', 'text', NULL, 7, '{\"data\":{\"\":\"M\\u1eb7c \\u0111\\u1ecbnh\",\"gray\":\"Gray\",\"light\":\"Light\",\"theme-small\":\"Theme Small\",\"theme\":\"Theme\"}}', 0),
(285, 300, 'header_bg_color', 'Mã màu (Tùy chọn)', 'text', 'text', NULL, 8, '{\"placeholder\":\"Nh\\u1eadp m\\u00e3 m\\u00e0u...\"}', 0),
(286, 300, 'header_use_bg_image', 'Sử dụng hình nền', 'switch', 'boolean', '1', 9, '{\"check_label\":\"C\\u00f3\"}', 0),
(287, 300, 'header_bg_image', 'Hình nền (Tùy chọn)', 'file', 'text', 'header_bg_image.jpg', 10, '[]', 0),
(288, 300, 'header_bg_position', 'Vị trí ảnh', 'radio', 'text', 'fixed', 11, '{\"data\":{\"\":\"Kh\\u00f4ng\",\"cover\":\"cover\",\"contain\":\"contain\",\"fixed\":\"fixed\"}}', 0),
(289, 300, 'header_class_name', 'Class (Tùy chọn)', 'text', 'text', NULL, 12, '[]', 0),
(290, 300, 'detail_use_feature_image', 'Header Image', 'switch', 'boolean', '1', 13, '{\"check_label\":\"S\\u1eed d\\u1ee5ng Feature Image l\\u00e0m h\\u00ecnh n\\u1ec1n Header\"}', 0),
(291, 300, 'detail_hide_feature_image', 'Hide Feature Image', 'switch', 'boolean', '1', 14, '{\"check_label\":\"\\u1ea8n \\u1ea3nh n\\u1ed5i b\\u1eadt tr\\u00ean ph\\u1ea7n \\u0111\\u1ea7u n\\u1ed9i dung\"}', 0),
(292, 300, 'detail_hide_related', 'Hide related', 'switch', 'boolean', '1', 15, '{\"check_label\":\"\\u1ea8n m\\u1ee5c li\\u00ean quan\"}', 0),
(293, 300, 'detail_hide_comments', 'Hide Comments', 'switch', 'boolean', '0', 16, '{\"check_label\":\"\\u1ea8n ph\\u1ea7n b\\u00ecnh lu\\u1eadn\"}', 0),
(294, 301, 'home', 'Home Widgets', 'area', 'text', 'home_docs', 1, '[]', 0),
(295, 301, 'post_docs', 'Post Widgets', 'area', 'text', 'post_docs', 2, '[]', 0),
(296, 301, 'left_widgets', 'Left Sidebar Widgets', 'area', 'text', 'sidebar_docs_left', 3, '[]', 0),
(297, 301, 'right_widgets', 'Right Sidebar Widgets', 'area', 'text', 'sidebar_docs_right', 4, '[]', 0),
(298, 302, 'logo', 'Logo', 'file', 'text', NULL, 1, '[]', 0),
(299, 302, 'logo_light', 'Logo Trắng (light)', 'file', 'text', NULL, 2, '[]', 0),
(300, 302, 'register_title', 'Tiêu đề mục đăng ký', 'text', 'text', 'Đăng ký để nhận tài khoản trải nghiệm miển phí', 3, '[]', 0),
(301, 302, 'register_description', 'Mô rả mục đăng ký', 'textarea', 'text', NULL, 4, '{\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"}', 0),
(302, 303, 'page_title', 'Tiêu đề Trang liên hệ', 'text', 'text', 'Liên hệ', 1, '[]', 0),
(303, 303, 'page_description', 'Mô rả trang liên hệ', 'textarea', 'text', NULL, 2, '{\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"}', 0),
(304, 303, 'header_style', 'Header Style mặc định', 'radio', 'text', '2', 3, '{\"data\":{\"1\":\"Style 1\",\"2\":\"Style 2\"},\"default\":\"2\"}', 0),
(305, 303, 'show_breadcrumb', 'Breadcrumb', 'switch', 'boolean', '1', 4, '{\"check_label\":\"Hi\\u1ec3n th\\u1ecb breadcrumb\"}', 0),
(306, 303, 'email', 'email', 'text', 'text', 'doanln16@gmail.com', 5, '{\"Label\":\"Email\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"}', 0),
(307, 303, 'phone_number', 'phone_number', 'text', 'text', '0945786960', 6, '{\"Label\":\"S\\u1ed1 \\u0111i\\u1ec7n tho\\u1ea1i\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"}', 0),
(308, 303, 'address', 'address', 'text', 'text', '172, Đường Bà Triệu, Phường Chăm Mát, Thành Phó Hòa Bình, Tỉnh Hòa Bình', 7, '{\"Label\":\"\\u0110\\u1ecba ch\\u1ec9\",\"placeholder\":\"M\\u1eb7c d\\u1ecbnh s\\u1ebd l\\u1ea5y t\\u1eeb thi\\u1ebft l\\u1eadp th\\u00f4ng tin wwbsite\"}', 0),
(309, 303, 'form_title', 'Tiêu đề Form liên hệ', 'text', 'text', 'Hãy nói về những ý tưởng của bạn', 8, '[]', 0),
(310, 303, 'form_description', 'Mô rả / Giới thiệu', 'textarea', 'text', NULL, 9, '{\"placeholder\":\"Vi\\u1ebft g\\u00ec \\u0111\\u00f3\"}', 0),
(311, 303, 'button_text', 'Nút gửi', 'text', 'text', 'Gửi liên hệ', 10, '[]', 0),
(312, 303, 'map_code', 'Mã nhúng bản đồ', 'textarea', 'text', NULL, 11, '{\"placeholder\":\"Nh\\u1eadp m\\u00e3 M\\u00e3 nh\\u00fang\"}', 0),
(313, 303, 'faq_title', 'Tiêu đề FAQ (Tùy chọn)', 'text', 'text', NULL, 12, '[]', 0),
(314, 303, 'contact_faq', 'Các Câu hỏi thường gặp', 'area', 'text', 'contact_faq', 13, '{\"@title-by\":\"title\"}', 0),
(315, 304, 'facebook', 'facebook (Tùy chọn)', 'text', 'text', 'https://www.facebook.com/LeNgocDoan', 1, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(316, 304, 'twitter', 'twitter (Tùy chọn)', 'text', 'text', 'https://twitter.com/NgocDoanLe', 2, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(317, 304, 'youtube', 'youtube (Tùy chọn)', 'text', 'text', 'https://www.youtube.com/channel/UCIPikHMH4Br5xRWW_YIOOTw', 3, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(318, 304, 'linkedin', 'Linkedin (Tùy chọn)', 'text', 'text', NULL, 4, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(319, 304, 'instagram', 'instagram (Tùy chọn)', 'text', 'text', NULL, 5, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(320, 304, 'pinterest', 'Pinterest (Tùy chọn)', 'text', 'text', NULL, 6, '{\"placeholder\":\"Kh\\u00f4ng b\\u1eaft bu\\u1ed9c\"}', 0),
(321, 305, 'show', 'Show', 'switch', 'boolean', '1', 1, '{\"check_label\":\"Hi\\u1ec3n th\\u1ecb Pre Loader\"}', 0),
(322, 305, 'logo', 'Logo', 'file', 'text', 'logo.png', 2, '[]', 0),
(323, 305, 'text', 'Text Logo', 'text', 'text', 'WEB<span>102</span>', 3, '{\"placeholder\":\"S\\u1eed d\\u1ee7ng th\\u1ebb <span> \\u0111\\u1ec3 in d\\u1eadm\"}', 0),
(324, 305, 'title', 'Tiêu đề (Tùy chọn)', 'text', 'text', 'Có thể bạn chưa biết', 4, '[]', 0),
(325, 305, 'description', 'Mô tả', 'textarea', 'text', 'Nếu bạn muốn kinh doanh thì cách tốt nhất để tiếp cận nhiều khách hàng hơn đó là tạo một website', 5, '{\"placeholder\":\"Danh s\\u00e1ch nh\\u0103n c\\u00e1ch nhau b\\u1eb1ng d\\u1ea5u ch\\u1ea5m ph\\u1ea9y (;) ho\\u1eb7c xu\\u1ed1ng d\\u00f2ng\",\"className\":\"auto-height\"}', 0),
(326, 294, 'body_bottom', 'Chân trang', 'area', 'text', 'body_bottom', 3, '{\"@title-by\":\"title\"}', 0),
(327, 1, 'secure_redirect', 'Điều hướng HTTPS', 'switch', 'boolean', '0', 1, NULL, 1),
(328, 297, 'detail_hide_meta', 'Hide Meta', 'switch', 'boolean', NULL, 13, '{\"check_label\":\"\\u1ea8n th\\u00f4ng tin meta\"}', 0),
(329, 1, 'secret_key', 'Secret  Key', 'text', 'text', 'vcc068f81deebe4903f', 12, NULL, 1),
(330, 1, 'client_key', 'Client Key', 'text', 'text', 'vcccf44812a77205cfe0649530e9ac3d976', 12, NULL, 1),
(331, 1, 'domain_list', 'Danh sách tên miền (ngăn cách bằng dấu phẩy)', 'text', 'text', NULL, 12, NULL, 1),
(332, 2, 'fe_logo', 'Frontend Logo', 'file', 'text', 'fe_logo.png', 9, NULL, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `option_groups`
--

CREATE TABLE `option_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'settings',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'settings',
  `config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `option_groups`
--

INSERT INTO `option_groups` (`id`, `option_id`, `label`, `slug`, `config`) VALUES
(1, 1, 'Cài đặt hệ thống', 'system', NULL),
(2, 1, 'Thông tin website', 'siteinfo', NULL),
(19, 1, 'Thiết lập cửa hàng', 'ecommerce', NULL),
(29, 1, 'Thiết lập thanh toán', 'payments', NULL),
(30, 1, 'Thiết lập Email', 'mailer', NULL),
(63, 1, 'Thiết lập hiển thị', 'display', NULL),
(259, 1, 'Javascript SDK', 'jssdk', NULL),
(260, 1, 'Thiết lập tin bài', 'posts', NULL),
(261, 1, 'Thiết lập trang Sản phẩm', 'products', NULL),
(262, 1, 'Thiết lập trang Dự án', 'projects', NULL),
(263, 1, 'Web Setting', 'websettings', NULL),
(264, 2, 'Styling', 'styling', '[]'),
(265, 2, 'Header', 'header', '{\"name\":\"Header\",\"layout_type\":\"single\",\"form_groups\":{\"logos\":{\"title\":\"Logo\",\"inputs\":[\"show_text_logo\",\"text_logo_primary\",\"text_logo_second\",\"highlight\",\"text_logo_slogan\"]},\"banner\":{\"title\":\"Banner qu\\u1ea3ng c\\u00e1o\",\"inputs\":[\"show_banner\",\"banner_image\",\"banner_alt\",\"banner_link\",\"ads_type\",\"ads_code\"]},\"datetime\":{\"title\":\"Ng\\u00e0y th\\u00e1ng\",\"inputs\":[\"show_datetime\",\"datetime_lang\",\"date_format\"]}}}'),
(266, 2, 'Footer', 'footer', '[]'),
(267, 2, 'Sidebar', 'sidebar', '[]'),
(268, 2, 'Trang chủ', 'home', '[]'),
(269, 2, 'Liên hệ', 'contacts', '{\"name\":\"Th\\u00f4ng tin trang li\\u00ean h\\u1ec7\",\"layout_type\":\"single\",\"form_groups\":[{\"title\":\"Trang li\\u00ean h\\u1ec7\",\"inputs\":[\"title\",\"description\",\"show_map\",\"place\",\"lat\",\"long\",\"map_type\",\"map_code\"]},{\"title\":\"Th\\u00f4ng tin li\\u00ean h\\u1ec7\",\"inputs\":[\"address\",\"phone_number\",\"email\"]},{\"title\":\"Li\\u00ean k\\u1ebft m\\u1ea1ng x\\u00e3 h\\u1ed9i\",\"inputs\":[\"facebook\",\"twitter\",\"youtube\",\"linkedin\",\"instagram\",\"pinterest\",\"tumblr\"]}]}'),
(270, 2, 'Chi tiết tin', 'single', '[]'),
(271, 2, 'Chi tiết Page', 'page', '[]'),
(272, 3, 'Banner', 'hero', '[]'),
(273, 3, 'Promo', 'promo', '[]'),
(274, 3, 'Giới thiệu', 'about', '[]'),
(275, 3, 'Dịch vụ', 'services', '[]'),
(276, 3, 'Dự án', 'projects', '[]'),
(277, 3, 'Báo giá', 'pricing', '[]'),
(278, 3, 'Testimonials', 'testimonials', '[]'),
(279, 3, 'Team', 'team', '[]'),
(280, 3, 'Liên hệ', 'contact', '[]'),
(281, 3, 'Footer', 'footer', '[]'),
(282, 4, 'Header', 'header', '[]'),
(283, 4, 'Footer', 'footer', '[]'),
(284, 4, 'Sidebar', 'sidebar', '[]'),
(285, 4, 'Trang chủ', 'home', '[]'),
(286, 4, 'Liên hệ', 'contacts', '[]'),
(287, 4, 'MXH', 'socials', '[]'),
(288, 4, 'Bài viết', 'posts', '[]'),
(289, 4, 'Trang', 'pages', '[]'),
(290, 4, 'Dự án', 'projects', '[]'),
(291, 4, 'Search', 'search', '[]'),
(292, 4, 'Forms', 'forms', '[]'),
(293, 5, 'Header', 'header', '{\"name\":\"Thi\\u1ebft l\\u1eadp Header\",\"layout_type\":\"list\",\"form_groups\":{\"general\":{\"title\":\"Thi\\u1ebft l\\u1eadp chung cho header\",\"inputs\":[\"default_style\",\"logo\",\"logo_light\"]},\"nav_1\":{\"title\":\"Nav Style 1\",\"inputs\":[\"nav_1_show_button\",\"nav_1_button_url\",\"nav_1_button_text\"]},\"nav_2\":{\"title\":\"Nav Style 2\",\"inputs\":[\"nav_2_show_button\",\"nav_2_button_url\",\"nav_2_button_text\"]}}}'),
(294, 5, 'Footer', 'footer', '[]'),
(295, 5, 'Sidebar', 'sidebar', '[]'),
(296, 5, 'Trang chủ', 'home', '{\"layout_type\":\"single\",\"form_groups\":{\"home\":{\"title\":\"Thi\\u1ebft l\\u1eadp trang ch\\u1ee7 m\\u1eb7c \\u0111\\u1ecbnh\",\"inputs\":[\"home\",\"home_services\",\"testimonials\",\"members\"]}}}'),
(297, 5, 'Bài viết', 'posts', '{\"name\":\"Thi\\u1ebft l\\u1eadp m\\u1ee5c \\u0111\\u0103ng b\\u00e0i\",\"layout_type\":\"single\",\"form_groups\":{\"page_header\":{\"title\":\"Thi\\u1ebft l\\u1eadp Page Header\",\"inputs\":[\"header_style\",\"show_breadcrumb\",\"header_bg_default_color\",\"header_bg_color\",\"header_use_bg_image\",\"header_bg_image\",\"header_bg_position\",\"header_class_name\"]},\"general\":{\"title\":\"Thi\\u1ebft l\\u1eadp chung\",\"inputs\":[\"list_layout\",\"list_type\"]},\"post_settings\":{\"title\":\"Thi\\u1ebft l\\u1eadp cho t\\u1eebng m\\u1ee5c\",\"className\":\"mt-3 pt-2 border-top\",\"inputs\":[\"post_settings\"]},\"detail\":{\"title\":\"Thi\\u1ebft l\\u1eadp Trang chi ti\\u1ebft \",\"inputs\":[\"detail_use_feature_image\",\"detail_hide_feature_image\",\"detail_hide_meta\",\"detail_hide_related\",\"detail_hide_comments\"]}}}'),
(298, 5, 'Dự án', 'projects', '{\"name\":\"Thi\\u1ebft l\\u1eadp m\\u1ee5c \\u0111\\u0103ng b\\u00e0i\",\"layout_type\":\"single\",\"form_groups\":{\"general\":{\"title\":\"Thi\\u1ebft l\\u1eadp chung\",\"inputs\":[\"list_layout\",\"list_type\"]},\"page_header\":{\"title\":\"Thi\\u1ebft l\\u1eadp Page Header\",\"inputs\":[\"header_style\",\"show_breadcrumb\",\"header_bg_default_color\",\"header_bg_color\",\"header_use_bg_image\",\"header_bg_image\",\"header_bg_position\",\"header_class_name\"]}}}'),
(299, 5, 'Dịch vụ', 'services', '[]'),
(300, 5, 'Trang', 'pages', '{\"name\":\"Thi\\u1ebft l\\u1eadp m\\u1ee5c \\u0111\\u0103ng b\\u00e0i\",\"layout_type\":\"single\",\"form_groups\":{\"general\":{\"title\":\"Thi\\u1ebft l\\u1eadp chung\",\"inputs\":[\"list_layout\",\"list_type\"]},\"page_header\":{\"title\":\"Thi\\u1ebft l\\u1eadp Page Header\",\"inputs\":[\"header_style\",\"show_breadcrumb\",\"header_align_center\",\"header_hide_author\",\"header_bg_default_color\",\"header_bg_color\",\"header_use_bg_image\",\"header_bg_image\",\"header_bg_position\",\"header_class_name\"]},\"detail\":{\"title\":\"Thi\\u1ebft l\\u1eadp Trang chi ti\\u1ebft \",\"inputs\":[\"detail_use_feature_image\",\"detail_hide_feature_image\",\"detail_hide_related\",\"detail_hide_comments\"]}}}'),
(301, 5, 'Tài liệu', 'documentation', '[]'),
(302, 5, 'Auth', 'auth', '[]'),
(303, 5, 'Liên hệ', 'contacts', '[]'),
(304, 5, 'MXH', 'socials', '[]'),
(305, 5, 'PreLoader', 'preloader', '[]');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `method`, `description`, `config`, `priority`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'vnpay', 'cod', 'vnpay', '[]', 0, 1, 1, '2020-10-26 14:38:52', '2020-10-26 20:49:26'),
(2, 'VN Pay', 'vnpay', 'test', '{\"TmnCode\":\"1245\",\"HashSecret\":\"445574\"}', 0, 1, 1, '2020-10-26 15:36:29', '2020-10-26 20:49:58'),
(3, 'Thanh toán chuyển khoản', 'transfer', NULL, '{\"account_name\":\"Nguy\\u1ec5n V\\u0103n A\",\"account_number\":\"101010140441\",\"bank_name\":\"TPBank\",\"sort_code\":\"sass\",\"iban\":null,\"bic\":null}', 0, 1, 1, '2020-10-26 19:34:26', '2020-10-26 20:50:38'),
(4, 'Thanh toán tiền mặt', 'cod', 'Bạn chỉ phải thanh toán khi nhận được đơn hàng', '{\"id\":\"4\"}', 0, 0, 0, '2020-10-26 20:50:07', '2020-12-01 23:25:20'),
(5, 'VN Pay', 'vnpay', 'VN Pay', '{\"id\":\"5\",\"TmnCode\":\"DVCFWAGQ\",\"HashSecret\":\"DGBLPXTJBUTLJNPQTNKXCYDXQGGLPVQE\"}', 1, 1, 0, '2020-10-26 20:50:23', '2020-10-29 04:55:37'),
(6, 'Thanh toán chuyển khoản', 'transfer', 'test', '{\"id\":\"6\",\"account_name\":\"Nguy\\u1ec5n V\\u0103n A\",\"account_number\":\"101010140441\",\"bank_name\":\"TPBank\",\"sort_code\":\"sass\",\"iban\":null,\"bic\":null}', 1, 1, 0, '2020-10-26 20:50:56', '2020-12-01 16:20:54'),
(7, 'Thanh toán qua ATM', 'atm', 'Thanh toán ATM thông qua VN Pay', '{\"TmnCode\":\"DVCFWAGQ\",\"HashSecret\":\"DGBLPXTJBUTLJNPQTNKXCYDXQGGLPVQE\"}', 2, 0, 0, '2020-12-01 16:20:43', '2021-09-20 19:39:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permission_modules`
--

CREATE TABLE `permission_modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `permission_modules`
--

INSERT INTO `permission_modules` (`id`, `type`, `name`, `parent_id`, `ref`, `description`, `created_at`, `updated_at`) VALUES
(1, 'prefix', 'Trang quản trị', 0, 'admin', NULL, '2020-03-14 08:23:53', '2020-03-14 08:23:53'),
(2, 'prefix', 'Quản lý user', 0, 'admin/users', NULL, '2020-03-14 08:29:06', '2020-03-14 08:29:06'),
(3, 'prefix', 'Quản lý phân quyền: Quyền truy cập', 0, 'admin/permissions/roles', NULL, '2020-03-14 08:30:21', '2020-03-14 08:30:21'),
(4, 'prefix', 'Quản lý phân quyền: Module', 0, 'admin/permissions/modules', NULL, '2020-03-14 08:34:00', '2020-03-14 08:34:00'),
(5, 'prefix', 'Quản lý trang', 0, 'admin/pages', NULL, '2020-03-14 08:41:40', '2020-03-14 08:41:40'),
(6, 'prefix', 'Quản lý nội dung', 0, 'admin/dynamics', NULL, '2020-03-14 08:42:45', '2020-03-14 08:42:45'),
(7, 'prefix', 'Quản lý giao diện', 0, 'admin/themes', NULL, '2020-03-14 08:43:29', '2020-03-14 08:43:29'),
(8, 'prefix', 'Quản lý thiết lập', 0, 'admin/settings', NULL, '2020-03-14 09:06:11', '2020-03-14 09:06:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permission_module_roles`
--

CREATE TABLE `permission_module_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `permission_module_roles`
--

INSERT INTO `permission_module_roles` (`id`, `module_id`, `role_id`) VALUES
(2, 2, 1),
(3, 1, 2),
(4, 3, 1),
(5, 4, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permission_roles`
--

CREATE TABLE `permission_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `handle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'redirect',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `permission_roles`
--

INSERT INTO `permission_roles` (`id`, `name`, `level`, `description`, `handle`, `return_type`, `created_at`, `updated_at`) VALUES
(1, 'Quyền quản trị', 3, NULL, NULL, 'redirect', '2020-03-14 08:13:55', '2020-03-14 08:13:55'),
(2, 'Quyền truy cập', 1, NULL, NULL, 'redirect', '2020-03-14 08:14:15', '2020-03-14 08:14:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permission_user_roles`
--

CREATE TABLE `permission_user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `permission_user_roles`
--

INSERT INTO `permission_user_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 8, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `dynamic_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `category_map` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `content_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feature_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `privacy` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `dynamic_id`, `parent_id`, `category_id`, `category_map`, `type`, `content_type`, `title`, `slug`, `keywords`, `description`, `content`, `feature_image`, `views`, `privacy`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 0, 2, ' 2,', 'project', 'text', 'Mua Gì đây', 'mua-gi-day', NULL, 'Trang web bán hàng demo dịch vụ của DoanLN - DH Team', '<p>Hệ thống được x&acirc;y dựng tr&ecirc;n nền tảng PHP kết hợp sử dụng framework Laravel cho tốc độ xử l&yacute; nhanh, mạnh mẽ v&agrave; bảo mật. Hệ thống quản l&yacute; sản phẩm, đơn h&agrave;ng được thiết kế để tối ưu cho trang b&aacute;n h&agrave;ng - Thương mại điện tử</p>', '000-5e120ed904999-5eaaedd17ff65.png', 0, 'public', 0, '2020-04-30 15:25:06', '2020-05-28 10:04:52'),
(2, 1, 0, 0, 1, ' 1,', 'project', 'text', 'Hoàng Trung Express', 'hoang-trung-express', NULL, 'Trang web quản lý nhà xe, tra cứu lịch trình, thông tin giá vé...', '<div class=\"biz-project-popup-text\">\r\n<p>Hệ thống được x&acirc;y dựng tr&ecirc;n nền tảng PHP kết hợp sử dụng framework Laravel cho tốc độ xử l&yacute; nhanh, mạnh mẽ v&agrave; bảo mật</p>\r\n</div>\r\n<div class=\"project-meta\">&nbsp;</div>', 'hoang-trung-5e120a18d113d-5eaaefb052e33.png', 0, 'public', 0, '2020-04-30 15:32:25', '2020-05-28 10:05:10'),
(3, 1, 0, 0, 1, ' 1,', 'project', 'text', 'An Lộc Phát', 'an-loc-phat', NULL, 'Website chính thức của AN LOC PHAT INTERNATIONAL, JSC.', '<p>Hệ thống được x&acirc;y dựng tr&ecirc;n nền tảng PHP kết hợp sử dụng framework Laravel cho tốc độ xử l&yacute; nhanh, mạnh mẽ v&agrave; bảo mật</p>', 'hoang-trung-5e120a18d113d-5eaaf06357ded.png', 0, 'public', 0, '2020-04-30 15:36:03', '2020-05-28 10:13:52'),
(4, 1, 0, 0, 1, ' 1,', 'project', 'text', 'Laptop Xiaomi', 'laptop-xiaomi', NULL, 'Website chính thức chuyên bán laptop và các sản phẩm của Xiaomi tại Việt Nam.', '<div class=\"biz-project-popup-text\">\r\n<p>Được ph&aacute;t triển v&agrave; sử dụng CMS Wordpress, trang web c&oacute; c&aacute;c dặc t&iacute;nh dễ d&agrave;ng sử dụng v&agrave; th&acirc;n tiện với người d&ugrave;ng,bộ c&ocirc;ng cũ quản l&yacute; mạnh mẽ</p>\r\n</div>\r\n<div class=\"project-meta\">&nbsp;</div>', 'laptop-gio-hang-5e120809eba32-5eaaf10d863f7.png', 0, 'public', 0, '2020-04-30 15:38:53', '2020-05-28 10:14:22'),
(5, 1, 0, 0, 1, ' 1,', 'project', 'text', 'Xiaomi Ninh Bình', 'xiaomi-ninh-binh', NULL, 'Trang web Chuyên Điện Thoại – Phụ Kiện – Thiết bị thông minh Xiaomi chính hãng – Giao hàng nhanh toàn quốc.', '<p>Được ph&aacute;t triển v&agrave; sử dụng CMS Wordpress, trang web c&oacute; c&aacute;c dặc t&iacute;nh dễ d&agrave;ng sử dụng v&agrave; th&acirc;n tiện với người d&ugrave;ng,bộ c&ocirc;ng cũ quản l&yacute; mạnh mẽ</p>', 'xiao-mi-nb-2-5e1206bebcaf8-5eaaf1ce2f00f.png', 0, 'public', 0, '2020-04-30 15:42:06', '2020-05-28 10:14:33'),
(6, 1, 0, 0, 1, ' 1,', 'project', 'text', 'Trồng Trọt Công Nghệ Cao', 'trong-trot-cong-nghe-cao', NULL, 'Trồng Trọt Công nghệ Cao là bộ phận trực thuộc Công ty cổ phần Nông nghiệp và Thực phẩm Agricook, tiền thân là Trung Tâm Công Nghệ, Môi Trường và Tài Nguyên (CTER).', '<p>Trồng Trọt C&ocirc;ng nghệ Cao l&agrave; bộ phận trực thuộc C&ocirc;ng ty cổ phần N&ocirc;ng nghiệp v&agrave; Thực phẩm Agricook, tiền th&acirc;n l&agrave; Trung T&acirc;m C&ocirc;ng Nghệ, M&ocirc;i Trường v&agrave; T&agrave;i Nguy&ecirc;n (CTER).<br /><br />Trang web được ph&aacute;t triển dựa tr&ecirc;n nền tảng PHP v&agrave; sử dụng Framework Laravel</p>', 'untitled-5e1201c220269-5eaaf22e95696.png', 0, 'public', 0, '2020-04-30 15:43:42', '2020-05-28 10:14:45'),
(7, 1, 3, 0, 3, ' 3,', 'post', 'text', 'Điều giúp iPhone SE 2020 rẻ, camera đơn vẫn chụp đẹp', 'dieu-giup-iphone-se-2020-re-camera-don-van-chup-dep', NULL, 'Dù trang bị cảm biến máy ảnh giống như iPhone 8, iPhone SE lại được Apple ưu ái về mặt phần mềm và hiện đại hơn rất nhiều.', NULL, 'screenshot-4-5eace350c6882.png', 0, 'public', 1, '2020-05-02 03:04:49', '2020-06-05 22:32:44'),
(8, 1, 3, 0, 4, ' 4,', 'post', 'text', 'CÔNG NGHỆ  Laptop cũ của bạn sắp chạy mượt hơn', 'cong-nghe-laptop-cu-cua-ban-sap-chay-muot-hon', NULL, 'Một vấn đề \"kinh điển\" khiến laptop chạy chậm sẽ được khắc phục trong bản cập nhật Windows dự kiến phát hành vào tháng sau.', NULL, 'z23729042020-5eace3c4280f0.jpg', 0, 'public', 0, '2020-05-02 03:06:44', '2020-05-02 03:06:44'),
(9, 1, 3, 0, 4, ' 4,', 'post', 'text', 'Google tìm ra rất nhiều lỗ hổng của Apple', 'google-tim-ra-rat-nhieu-lo-hong-cua-apple', NULL, 'Nhóm chuyên tìm lỗi Project Zero của Google đã phát hiện loạt lỗ hổng bảo mật “zero-click” trên iPhone và các sản phẩm phần cứng nhà Táo.', NULL, 'maxresdefault-5eace425a8749.jpg', 0, 'public', 0, '2020-05-02 03:08:21', '2020-05-02 03:08:21'),
(10, 1, 0, 0, 0, NULL, 'page', 'text', 'Giới thiệu', 'gioi-thieu', NULL, 'Không phải chỉ vì miếng cơm manh áo, chúng tôi làm web vì tình yêu và đam mê cùng với khao khát thể hiện bãn thân. Với chiết lý: Dám nghĩ - dám làm, Dám ước mơ và dám thực hiện. Chúng tôi luôn cố gắng để mang đến bạn những dịch vụ tốt nhất với giá cả phải chăng nhất.', '<h2>Ch&uacute;ng t&ocirc;i (\"VCC Corp\") l&agrave; ai? Web 1-0-2 l&agrave; g&igrave;?</h2>\r\n<h5>Trước khi tr&agrave; lời c&acirc;u hỏi đ&oacute; ch&uacute;ng ta h&atilde;y t&igrave;m hiểu một ch&uacute;t về tầm quan tr&ocirc;ng của website đối với c&aacute; nh&acirc;n v&agrave; doanh nghiệp trong thời đại 4.0</h5>\r\n<p>Ng&agrave;y n&agrave;y tất cả c&aacute;c th&ocirc;ng tin ch&uacute;ng ta tiếp nhận hằng ng&agrave;y như&nbsp; tin tức, t&agrave;i liệu học tập, video giải tr&iacute;, đến cả c&aacute;c sản phẩm đều dược lưu trự v&agrave; tr&igrave;nh b&agrave;y tr&ecirc;n c&aacute;c website. Bởi v&igrave; một l&yacute; do đơn giản l&agrave; website được lưu trự tr&ecirc;n kh&ocirc;ng gian mạng qua đ&oacute; ai cũng c&oacute; thể tiếp cận, t&igrave;m hiểu.</p>\r\n<p>V&igrave; lẽ đ&oacute; n&ecirc;n c&aacute;c c&ocirc;ng ty, doanh nghiệp d&ugrave; kinh doanh trong bất cứ lĩnh vực n&agrave;o cũng cần c&oacute; một website để giới thiệu về m&igrave;nh cũng như để kh&aacute;ch h&agrave;ng c&oacute; thể t&igrave;m hiểu th&ocirc;ng tin một c&aacute;ch ch&iacute;nh thống. Ngo&agrave;i ra trong kinh doanh n&oacute;i chung v&agrave; buốn b&aacute;n c&aacute;c mặt h&agrave;ng n&oacute;i ri&ecirc;ng đ&ocirc;i khi ch&uacute;ng ta chỉ cần c&oacute; một website l&agrave; c&oacute; thể b&aacute;n h&agrave;ng m&agrave; kh&ocirc;ng cần tốn qu&aacute; nhiều chi ph&iacute; thu&ecirc; mặt bằng đ&aacute;t đỏ. Th&ecirc;m nữa&nbsp;nếu ch&uacute;ng ta l&agrave;m tốt việc tối ưu h&oacute;a cho c&aacute;c c&ocirc;ng cụ t&igrave;m kiếm - SEO, ch&uacute;ng ta c&oacute; thể&nbsp; tiết kiệm rất nhiều chi ph&iacute; quảng b&aacute; để tiếp cận kh&aacute;ch h&agrave;ng tiềm năng.&nbsp;</p>\r\n<p style=\"text-align: center;\"><img src=\"/static/files/2020/07/08/0005-5f0589602460f.png\" alt=\"0005.png\" width=\"554\" /><br />Trang web b&aacute;n h&agrave;ng</p>\r\n<p>Đối với c&aacute; nh&acirc;n cũng vậy! Nhất l&agrave; khi bạn l&agrave; một người gi&agrave;u cảm x&uacute;c, th&iacute;ch viết l&aacute;ch th&igrave; một trang blog với bạn sẽ thật sự hữu &iacute;ch. C&ograve;n nếu bạn l&agrave;&nbsp;người l&agrave;m b&ecirc;n lập tr&igrave;nh hay thiết kế đồ họa th&igrave; bạn lại c&agrave;ng cần c&oacute; một website c&aacute; nh&acirc;nđể&igrave; c&oacute; thể dễ dạng show ra c&aacute;c sản phẩm của m&igrave;nh cho kh&aacute;ch h&agrave;ng qua đ&oacute; c&oacute; thể nang cao độ tin cậy cũng như độ chuy&ecirc;n nghiệp của bạn.</p>\r\n<p style=\"text-align: center;\"><img src=\"/static/files/2020/07/08/006-5f058e51a9224.png\" alt=\"006.png\" width=\"555\" /><br />Trang Portfolio - CV Online</p>\r\n<p>Tuy nhi&ecirc;n việc để c&oacute; được trang web chất lượng, đ&aacute;p ứng&nbsp; được c&aacute;c nhu cầu cho c&aacute; nh&acirc;n hay doanh nghiệp của bạn cũng sẽ gặp phải c&aacute;c kh&oacute; khăn như chi ph&iacute; ban đầu đ&ocirc;i khi kh&aacute; lớn nếu web bạn y&ecirc;u cầu những chức năng đặc biệt, ph&iacute; duy tr&igrave; hằng năm, đ&oacute; l&agrave; c&ograve;n chưa kể chi ph&iacute; bạn bỏ ra để thu&ecirc; đội ngũ SEO l&ecirc;n top Google, hoặc chi ph&iacute; cho c&aacute;c chiến dịch chạy quảng c&aacute;o, ...</p>\r\n<h3>Đ&oacute; l&agrave; l&uacute;c ch&uacute;ng t&ocirc;i bước ra &aacute;nh s&aacute;ng với một sứ mệnh thi&ecirc;ng li&ecirc;ng...</h3>\r\n<p>Cũng l&agrave; một doanh nghiệp kinh doanh dịch vụ <strong>Web</strong> v&agrave; <strong>Design</strong>, ch&uacute;ng t&ocirc;i hiểu r&otilde; c&aacute;c kh&oacute; khăn bạn c&oacute; thể gặp phải trong những bước đi đầu ti&ecirc;n tr&ecirc;n con đường kinh doanh n&ecirc;n ch&uacute;ng t&ocirc;i đ&atilde; ph&aacute;t triển một hệ thống website với sứ mệnh gi&uacute;p bạn bước thật vững từ khi xuất ph&aacute;t với chi ph&iacute; phải chăng nhất hoặc ho&agrave;n to&agrave;n miển ph&iacute;.</p>\r\n<h3>V&agrave; Web 1-0-2 ra đời từ sứ mệnh ấy!</h3>\r\n<p>Web&nbsp; 1-0-2 l&agrave; sự kết hợp giữa <a href=\"/docs/mo-dau.html\" target=\"_blank\" rel=\"noopener\"><strong>Crazy Laravel CMS</strong></a> v&agrave; hệ thống quản l&yacute; domain-hosting để tạo ra một hệ thống cho ph&eacute;p người d&ugrave;ng c&oacute; thể tạo ra những trang web theo &yacute; m&igrave;nh chỉ trong v&agrave;i ph&uacute;t.&nbsp;</p>\r\n<p>Hệ thống Web 1-0-2 được ph&acirc;n loại theo c&aacute;c ch&uacute;c năng v&agrave; mục d&iacute;ch sử dụng như:</p>\r\n<ul style=\"list-style-type: circle;\">\r\n<li><a href=\"/dich-vu/goi-blog.html\">Blog</a></li>\r\n<li><a href=\"/dich-vu/goi-trang-ca-nhan.html\">Portfolio</a></li>\r\n<li><a href=\"/dich-vu/goi-business.html\">Giới thiệu doanh nghiệp</a></li>\r\n<li><a href=\"/dich-vu/goi-tin-tuc.html\">Tin tức</a></li>\r\n<li><a href=\"/dich-vu/goi-thuong-mai-dien-tu.html\">B&aacute;n h&agrave;ng</a></li>\r\n</ul>\r\n<p>Với hệ thống ph&acirc;n loại như vậy c&ugrave;ng với việc thay thế giao diện v&agrave; t&ugrave;y biến dễ d&agrave;ng ch&uacute;ng t&ocirc;i hy vọng rằng c&aacute;c bạn - Những kh&aacute;ch h&agrave;ng th&acirc;n thiết của ch&uacute;ng sẽ c&oacute; được nền m&oacute;ng thật vững chắc để x&acirc;y dựng l&ecirc;n những đoanh nghiệp ti&ecirc;u biểu hoặc chỉ đơn giản l&agrave; gi&uacute;p bạn show ra một profile thật chuy&ecirc;n nghiệp.</p>\r\n<h3>V&agrave; nhiều hơn thế nữa...</h3>\r\n<p>Ngo&agrave;i dịch vụ Web&nbsp; 1-0-2 ch&uacute;ng t&ocirc;i c&ograve;n c&oacute; c&aacute;c dịch vụ kh&aacute;c gi&uacute;p định vị thương hiệu của bạn như <strong><a href=\"https://www.vcc.vn/dich-vu/thiet-ke-logo.html\" target=\"_blank\" rel=\"noopener\">Thiết kế logo</a></strong>, <a href=\"https://www.vcc.vn/dich-vu.html\"><strong>Nhận diện thương hiệu</strong></a>, thiết kế quảng c&aacute;o, ...</p>\r\n<p>Với sứ mệnh được trao ch&uacute;ng t&ocirc;i biết rằng chừng ấy vẫn chưa đủ, v&agrave; ch&uacute;ng t&ocirc;i sẽ tiếp tục cố gắng d369 hoản thiện bản th&acirc;n cũng như mang đến cho bạn những điều tuyệt vời hơn nữa!</p>\r\n<p>&nbsp;</p>', 'skills-for-web-designer-5e11ae6fa777d-5ebdf582c02ab.jpg', 0, 'public', 0, '2020-05-15 01:30:23', '2020-07-28 22:08:43'),
(11, 1, 0, 0, 2, ' 2,', 'project', 'text', 'Moon Dental Studio', 'moon-dental-studio', NULL, 'Hệ thống Nha khoa thẩm mỹ Uy tín hàng đầu Việt Nam', '<p>Hệ thống Nha khoa thẩm mỹ Uy t&iacute;n h&agrave;ng đầu Việt Nam</p>\r\n<p><img src=\"/static/files/2020/05/28/screencapture-moondental-vn-2020-05-28-17_18_14-5ecf9104dd9e9.png\" alt=\"screencapture-moondental-vn-2020-05-28-17_18_14.png\" /></p>', 'screencapture-moondental-vn-2020-05-28-17-18-14-5ecf91178d350.png', 0, 'public', 0, '2020-05-28 10:23:19', '2020-05-28 10:23:19'),
(12, 1, 2, 0, 6, ' 6,', 'post', 'text', 'Gói tiêu chuẩn', 'goi-tieu-chuan', NULL, 'Gói dịch vụ web trọn gói tiêu chuẩn là một trong các gói nhỏ của dịch vụ web 1-0-2 bao gồm miễn phí và trả phí phù hợp với từng nhu cầu của khách hàng, bao gồm Hosting và tên miền', '<p>G&oacute;i dịch vụ web trọn g&oacute;i ti&ecirc;u chuẩn bao gồm Hosting v&agrave; t&ecirc;n miền.&nbsp;</p>\r\n<p>L&agrave; một trong c&aacute;c g&oacute;i nhỏ của dịch vụ web 1-0-2 bao gồm miễn ph&iacute; v&agrave; trả ph&iacute; ph&ugrave; hợp với từng nhu cầu của kh&aacute;ch h&agrave;ng. G&oacute;i n&agrave;y ph&ugrave; hợp cho nhu cầu sử dụng như một trang tin tức hoặc blog, đơn giản, lược bỏ bớt c&aacute;c t&iacute;nh năng chuy&ecirc;n s&acirc;u để ggiup1 kh&aacute;ch h&agrave;ng c&oacute; một trang web d&aacute;p ứng nhanh v&agrave; gọn g&agrave;ng.</p>\r\n<p>{$pricing_table}</p>', 'unnamed-5ed4861f994ea.png', 0, 'public', 0, '2020-06-01 04:37:51', '2020-07-17 03:51:08'),
(13, 1, 2, 0, 6, ' 6,', 'post', 'text', 'Gói Blog', 'goi-blog', NULL, 'Dịch vụ tạo trang blog cá nhân là một trong các gói nhỏ của dịch vụ web 1-0-2 bao gồm miễn phí và trả phí phù hợp với từng nhu cầu của khách hàng, bao gồm Hosting và tên miền', '<p>Dịch vụ tạo trang blog c&aacute; nh&acirc;n l&agrave; một trong c&aacute;c g&oacute;i nhỏ của dịch vụ web 1-0-2 bao gồm miễn ph&iacute; v&agrave; trả ph&iacute; ph&ugrave; hợp với từng nhu cầu của kh&aacute;ch h&agrave;ng, bao gồm Hosting v&agrave; t&ecirc;n miền</p>\r\n<p>{$pricing_table}</p>', 'aaaa-5ed487d673458.jpg', 0, 'public', 0, '2020-06-01 04:45:10', '2020-07-09 13:19:04'),
(14, 1, 2, 0, 6, ' 6,', 'post', 'text', 'Gói Trang Cá nhân', 'goi-trang-ca-nhan', NULL, 'Gói dịch vụ web Trang cá nhân. nơi lưu trữ các thông tin như là một CV Online, bao gồm Hosting và tên miền. ', '<p>G&oacute;i dịch vụ web Trang c&aacute; nh&acirc;n. nơi lưu trữ c&aacute;c th&ocirc;ng tin như l&agrave; một CV Online,&nbsp;bao gồm Hosting v&agrave; t&ecirc;n miền.&nbsp;</p>\r\n<p><img src=\"/static/files/2020/07/08/006-5f058e51a9224.png\" alt=\"006.png\" /></p>\r\n<p>L&agrave; một trong c&aacute;c g&oacute;i nhỏ của dịch vụ web 1-0-2 bao gồm miễn ph&iacute; v&agrave; trả ph&iacute; ph&ugrave; hợp với từng nhu cầu của kh&aacute;ch h&agrave;ng. G&oacute;i n&agrave;y ph&ugrave; hợp nhất cho những người l&agrave;m b&ecirc;n lập tr&igrave;nh hay thiết kế đồ họa v&igrave; c&oacute; thể dễ dạng show ra c&aacute;c sản phẩm của m&igrave;nh cho kh&aacute;ch h&agrave;ng qua đ&oacute; c&oacute; thể nang cao độ tin cậy cũng như độ chuy&ecirc;n nghiệp của bạn</p>\r\n<p>{$pricing_table}</p>\r\n<p>&nbsp;</p>', 'portfolio-la-gi-01-24-5ed4b418b0e87.jpg', 0, 'public', 0, '2020-06-01 07:54:00', '2020-07-09 13:28:51'),
(15, 1, 2, 0, 6, ' 6,', 'post', 'text', 'Gói Business', 'goi-business', NULL, 'Gói dịch vụ web giới thiệu doanh nghiệp là một trong các gói nhỏ của dịch vụ web 1-0-2 bao gồm miễn phí và trả phí phù hợp với từng nhu cầu của khách hàng, bao gồm Hosting và tên miền', '<h2>Tạo sao doanh nghiệp n&ecirc;n c&oacute; một website?</h2>\r\n<p>Khi muốn tiếp cận được nhiều kh&aacute;ch h&agrave;ng cũng như tăng độ uy t&iacute;n, tin cậy th&igrave; doanh nghiệp n&ecirc;n c&oacute; một website để giới thiệu về m&igrave;nh cũng như để kh&aacute;ch h&agrave;ng c&oacute; thể t&igrave;m hiểu th&ocirc;ng tin một c&aacute;ch ch&iacute;nh thống. Ngo&agrave;i ra website tiết kiệm rất nhiều chi ph&iacute; quảng b&aacute; để tiếp cận kh&aacute;ch h&agrave;ng tiềm năng nếu ch&uacute;ng ta l&agrave;m tốt việc Tối ưu h&oacute;a cho c&aacute;c c&ocirc;ng cụ t&igrave;m kiếm - SEO.</p>\r\n<h2>Tạo trang web cho doanh nghiệp miễn ph&iacute; với hệ thống web 1-0-2</h2>\r\n<p><img src=\"/static/files/2020/07/09/0008-5f06d6454875a.png\" alt=\"0008.png\" /></p>\r\n<p>G&oacute;i dịch vụ web giới thiệu doanh nghiệp l&agrave; một trong c&aacute;c g&oacute;i nhỏ của dịch vụ web 1-0-2 sẽ gi&uacute;p bản l&agrave;m hầu hết những c&ocirc;ng việc đ&oacute;! G&oacute;i dịch vụ bao&nbsp; bao gồm miễn ph&iacute; v&agrave; trả ph&iacute; ph&ugrave; hợp với từng nhu cầu của kh&aacute;ch h&agrave;ng.</p>\r\n<p>{$pricing_table}</p>\r\n<p>Bạn đ&atilde; c&oacute; &yacute; tưởng cho website của bạn chưa? H&atilde;y li&ecirc;n hệ ch&uacute;ng để được tư vấn miễn ph&iacute; nhe!</p>\r\n<p>Số điện thoại: 094.578.6960</p>\r\n<p>Email: <a href=\"mailto:doanln16@gmail.com\">doanln16@gmail.com</a></p>\r\n<p>Facebook: <a href=\"https://fb.me/LeNgocDoan\">https://fb.me/LeNgocDoan</a></p>\r\n<p>Hoặc sử dụng mục<a href=\"/lien-he.html\"> li&ecirc;n hệ</a></p>', 'business-corporate-website-inspiration-web-design-ui-07-5ed4bdec5447e.png', 0, 'public', 0, '2020-06-01 08:35:56', '2020-07-09 20:43:07'),
(16, 1, 2, 0, 6, ' 6,', 'post', 'text', 'Gói tin tức', 'goi-tin-tuc', NULL, 'Trang tin tức với các công cụ hỗ trợ chuyên biệt', '<p>G&oacute;i tin tức l&agrave; một g&oacute;i nhỏ trong c&aacute;c dịch vụ web nột kh&ocirc;ng hai (Web 1-0-2) với c&aacute;c chức năng chuy&ecirc;n biệt gi&uacute;p bạn quản l&yacute; trang web hiệu quả.</p>\r\n<p>&nbsp;</p>\r\n<p>{$pricing_table}</p>', 'google-news-t-5ed4bf58de3cb.jpg', 0, 'public', 0, '2020-06-01 08:42:01', '2020-08-14 19:35:24'),
(17, 1, 2, 0, 6, ' 6,', 'post', 'text', 'Gói Thương mại điện tử', 'goi-thuong-mai-dien-tu', NULL, 'Gói dịch vụ Thương mại điện tử là một trong các gói nhỏ của dịch vụ web 1-0-2 bao gồm miễn phí và trả phí phù hợp với từng nhu cầu của khách hàng, bao gồm Hosting và tên miền với các tính năng và công cụ hỗ trợ cho Thương mại điện tử', '<h2>Tại sao n&ecirc;n sử dụng hệ thống web 1-0-2 để b&aacute;n h&agrave;ng?</h2>\r\n<p>&nbsp;Ng&agrave;y nay việc b&aacute;n h&agrave;ng online kh&ocirc;ng c&ograve;n l&agrave; điều g&igrave; qu&aacute; xa lạ với ch&uacute;ng ta. Từ livestream tr&ecirc;n facebook đến tạo một gian h&agrave;ng tr&ecirc;n c&aacute;c trang thương mại điện tử lớn, hoặc tạo một trang web b&aacute;n h&agrave;ng cho ri&ecirc;ng m&igrave;nh.</p>\r\n<p>Mỗi một h&igrave;nh thức đề c&oacute; những ưu điểm ri&ecirc;ng t&ugrave;y v&agrave;o đối tượng kh&aacute;ch h&agrave;ng bạn muốn tiếp cận. &Yacute; tưởng kết hợp nhiều h&igrave;nh thức c&oacute; vẻ cũng kh&ocirc;ng tồi phải kh&ocirc;ng?</p>\r\n<figure><img src=\"/static/files/2020/07/09/livestream-tren-sapo-go-5f06e8107842d.png\" alt=\"livestream-tren-sapo-go.png\" />\r\n<figcaption></figcaption>\r\n</figure>\r\n<p>Tuy nhi&ecirc;n ch&uacute;ng cũng c&oacute; những nhược đi&ecirc;m cố hữu. Chẳng hạn như kh&ocirc;ng phải ai cũng bết livestream h&agrave;ng giờ tr&ecirc;n fb để b&aacute;n h&agrave;ng; Đăng sản phẩm l&ecirc;n gian h&agrave;ng tr&ecirc;n c&aacute;c trang thương mại điện tử th&igrave; sẽ phải chịu sự cạnh tranh khốc liệt với c&aacute;c sản phẩm tương tự của c&aacute;c gian h&agrave;ng kh&aacute;c; Việc tạo một trang web của ri&ecirc;ng bạn cũng sẽ gặp phải c&aacute;c kh&oacute; khăn như chi ph&iacute; ban đầu đ&ocirc;i khi kh&aacute; lớn nếu web bạn y&ecirc;u cầu những chức năng đặc biệt, ph&iacute; duy tr&igrave; hằng năm, đ&oacute; l&agrave; c&ograve;n chưa kể chi ph&iacute; bạn bỏ ra để thu&ecirc; đội ngũ SEO l&ecirc;n top Google, hoặc chi ph&iacute; cho c&aacute;c chiến dịch chạy quảng c&aacute;o, ...</p>\r\n<p>Cũng l&agrave; một doanh nghiệp kinh doanh dịch vụ, ch&uacute;ng t&ocirc;i hiểu r&otilde; c&aacute;c kh&oacute; khăn bạn c&oacute; thể gặp phải trong những bước đi đầu ti&ecirc;n tr&ecirc;n con đường kinh doanh n&ecirc;n ch&uacute;ng t&ocirc;i đ&atilde; ph&aacute;t triển một hệ thống website nhằm gi&uacute;p bạn bước thật vững từ khi xuất ph&aacute;t với chi ph&iacute; phải chăng nhất hoặc ho&agrave;n to&agrave;n miển ph&iacute;.</p>\r\n<p>&nbsp;</p>\r\n<h2>Chi ph&iacute; cho một trang web b&aacute;n h&agrave;ng tr&ecirc;n hệ thống Web 1-0-2 l&agrave; bao nhi&ecirc;u?</h2>\r\n<p>G&oacute;i dịch vụ Thương mại điện tử l&agrave; một trong c&aacute;c g&oacute;i nhỏ của dịch vụ web 1-0-2 c&oacute; thể miễn ph&iacute; v&agrave; trả ph&iacute; ph&ugrave; hợp với từng nhu cầu của kh&aacute;ch h&agrave;ng, bao gồm Hosting v&agrave; t&ecirc;n miền với c&aacute;c t&iacute;nh năng v&agrave; c&ocirc;ng cụ hỗ trợ cho Thương mại điện tử</p>\r\n<p style=\"text-align: center;\"><img style=\"background-color: #ffffff; color: #626262;\" src=\"/static/files/2020/07/08/0005-5f0589602460f.png\" alt=\"0005.png\" />Một trong những giao diện web b&aacute;n h&agrave;ng tr&ecirc;n hệ thống web 1-0-2</p>\r\n<p>&nbsp;</p>\r\n<p>Dưới đ&acirc;y l&agrave; bảng gi&aacute; dịch vụ web thương mại điện tử tr&ecirc;n hệ thống <strong>Web 1-0-2</strong></p>\r\n<p>{$pricing_table}</p>\r\n<p>Bạn đ&atilde; chọn được một g&oacute;i dịch vụ ph&ugrave; hợp với m&igrave;nh chưa?/ Hoặc nếu c&oacute; một &yacute; tưởng kh&aacute;c hay cần tư vấn, h&atilde;y li&ecirc;n hệ với ch&uacute;ng t&ocirc;i theo th&ocirc;ng tin b&ecirc;n dưới</p>\r\n<p>Số điện thoại: 094.578.6960</p>\r\n<p>Email: <a href=\"mailto:doanln16@gmail.com\">doanln16@gmail.com</a></p>\r\n<p>Facebook: <a href=\"https://fb.me/LeNgocDoan\">https://fb.me/LeNgocDoan</a></p>\r\n<p>Hoặc sử dụng mục<a href=\"/lien-he.html\"> li&ecirc;n hệ</a></p>', 'ecommerce-01-5ed4c0125b385.png', 0, 'public', 0, '2020-06-01 08:45:06', '2020-07-12 11:23:20'),
(18, 1, 3, 0, 4, ' 4,', 'post', 'text', 'MacBook Pro 16 inch bất ngờ giảm giá 300 USD trên Amazon', 'macbook-pro-16-inch-bat-ngo-giam-gia-300-usd-tren-amazon', NULL, 'Amazon khó tiếp tục duy trì mức giá cũ trong bối cảnh tác động cắt giảm chi tiêu của người dùng sau khi hứng chịu đại dịch Covid-19. Theo đó, nhà bán lẻ trực tuyến một lần nữa chào bán máy tính xách tay cao cấp MacBook Pro 16 inch của Apple với mức giá 2.100 USD, tương đương mức giảm 300 USD.', '<form id=\"frmCreateOrder\" action=\"https://sandbox.vnpayment.vn/button/websrc.html\" method=\"POST\" target=\"_top\"><input name=\"cmd\" type=\"hidden\" value=\"pay\" /> <input name=\"hosted_button_id\" type=\"hidden\" value=\"qn0yqGgdd1\" /> <input name=\"hosted_button_token\" type=\"hidden\" value=\"245bdcd28195cdda1645a3c49f7cc5f74d5e057b46e421f53a40a0b3295f698f\" /> <img class=\"btnPopup\" src=\"https://sandbox.vnpayment.vn/button/Images/paynow-1.png\" alt=\"VNPAY - Thanh toan online\" border=\"0\" /></form>\r\n<p><a href=\"http://preview.pagedemo.me/5f980419f9267577b3d301c0\">http://preview.pagedemo.me/5f980419f9267577b3d301c0</a></p>', 'macbookpro16-ycan-5eda2fce5c762.jpg', 0, 'public', 0, '2020-06-05 22:43:10', '2020-11-01 19:32:52'),
(19, 1, 2, 0, 5, ' 5,', 'post', 'text', 'Thiết Kế Website WordPress 1-0-2', 'thiet-ke-website-wordpress-1-0-2', NULL, 'Bạn muốn tìm được một đơn vị thiết kế web lâu năm có kinh nghiệm và chuyên môn về WordPress. Thật tuyệt vời! Web 1-0-2 hoàn toàn có thể đáp ứng được mọi yêu cầu của bạn', '<p><strong>Ng&agrave;y nay c&aacute;c website chạy tr&ecirc;n nền tảng wordpress được kh&aacute;ch h&agrave;ng tin tưởng sử dụng bởi hệ quản trị dễ sử dụng. Th&ecirc;m v&agrave;o đ&oacute; bố cục code web wordpress ho&agrave;n to&agrave;n th&acirc;n thiện với c&ocirc;ng cụ t&igrave;m kiếm google. Dễ d&agrave;ng ph&aacute;t triển SEO top website.</strong></p>\r\n<p><strong>Với nhu cầu sử dụng cao, quy tr&igrave;nh tạo ra website wordpress được tối ưu dẫn đến chi ph&iacute; thiết kế thấp. Tại Web 1-0-2 ch&uacute;ng t&ocirc;i c&oacute; chu tr&igrave;nh thiết kế website chi tiết v&agrave; cực tối ưu. Nhằm giảm tối đa chi ph&iacute; thiết kếwebsite cho qu&yacute; kh&aacute;ch h&agrave;ng.</strong></p>\r\n<h3><span id=\"Khi_nao_ban_nen_su_dung_code_thuan_de_thiet_ke_web\" class=\"ez-toc-section\"></span><strong>Khi n&agrave;o bạn n&ecirc;n sử dụng code thuần để thiết kế web</strong></h3>\r\n<p>Việc sử dụng code thuần l&agrave; ho&agrave;n to&agrave;n ph&ugrave; hợp cho những hệ thống website lớn ( lớn rất lớn bạn nh&eacute; ). Bởi ưu điểm của việc thiết kế web n&agrave;y l&agrave; khả năng mở rộng chức năng của website. T&ocirc;i lấy một v&iacute; dụ c&aacute;c đơn vị đang sử dụng code thuần cho website của m&igrave;nh như:&nbsp;kidsplaza,&nbsp;vingroup&hellip; C&aacute;c đơn vị n&agrave;y c&oacute; đội ngũ code ri&ecirc;ng cho doanh nghiệp của m&igrave;nh. N&ecirc;n việc quản trị hệ thống từ đầu, cũng như ph&aacute;t triển hệ thống website l&agrave; ho&agrave;n to&agrave;n khả thi v&agrave; tiện dụng.</p>\r\n<p>Nếu đơn vị bạn kh&ocirc;ng sở hữu ri&ecirc;ng đội code cho doanh nghiệp m&igrave;nh th&igrave; bạn h&atilde;y thực sự c&acirc;n nhắc khi sử dụng website code thuần. Bởi lẽ mỗi cấu tr&uacute;c website l&agrave; ho&agrave;n to&agrave;n kh&aacute;c nhau, việc thu&ecirc; một đơn vị thứ 3 mở rộng ph&aacute;t triển website dẫn đến rất nhiều rủi ro v&agrave; kh&oacute; khăn. Hơn nữa chi ph&iacute; để triển khai 1 website code thuần l&agrave; lớn gấp nhiều lần website wordpress hay web102. Nhưng ở đ&acirc;y m&igrave;nh đang đề cập đến wordpress.</p>\r\n<h3><span id=\"Tai_sao_nen_chon_wordpress_de_thiet_ke_website\" class=\"ez-toc-section\"></span><strong>Tại sao n&ecirc;n chọn wordpress để thiết kế website</strong></h3>\r\n<p>Đến đ&acirc;y c&aacute;c bạn chắc hẳn đ&atilde; c&oacute; c&acirc;u trả lời cho m&igrave;nh rồi phải kh&ocirc;ng n&agrave;o. Thiế kế Website wordpress ho&agrave;n to&agrave;n đảm bảo cho bạn được mọi y&ecirc;u cầu về t&iacute;nh thẩm mỹ, bảo mật, chức năng&hellip; Điều tuyệt vời hơn nữa gi&aacute; thiết kế website wordpress hiện nay rất rẻ.</p>\r\n<h2><span id=\"Doanh_nghiep_ban_co_nen_thiet_ke_website_wordpress\" class=\"ez-toc-section\"></span><strong>Doanh nghiệp bạn c&oacute; n&ecirc;n thiết kế website wordpress?</strong></h2>\r\n<p>Đ&acirc;y l&agrave; c&acirc;u hỏi m&agrave; rất nhiều bạn quan t&acirc;m phải kh&ocirc;ng n&agrave;o? Rất nhiều chủ doanh nghiệp khi li&ecirc;n hệ với Ngọc Thắng đều c&oacute; chung thắc mắc; với quy m&ocirc; v&agrave; mong muốn ph&aacute;t triển hệ thống website liệu nền tảng wordpress c&oacute; ph&ugrave; hợp hay kh&ocirc;ng. C&ugrave;ng Ngọc Thắng ph&acirc;n t&iacute;ch để c&oacute; c&acirc;u trả lời ngay b&acirc;y giờ bạn nh&eacute;.</p>\r\n<p>Hiện nay c&aacute;c website chạy tr&ecirc;n nền tảng WordPress được code rất ho&agrave;n chỉnh, chạy mượt m&agrave;, bảo mật tốt, được cập nhật c&aacute;c bản v&aacute; lỗi thường xuy&ecirc;n. Ngo&agrave;i ra wordpress sở hữu&nbsp;kho giao diện, plugin miễn ph&iacute; v&ocirc; c&ugrave;ng phong ph&uacute;, khả năng mở rộng v&agrave; ph&aacute;t triển cực tốt.&nbsp; Đ&aacute;p ứng được hầu hết c&aacute;c mong muốn cần c&oacute; cho 1 hệ thống website chuy&ecirc;n nghiệp.</p>\r\n<p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"/static/files/2020/06/21/567675-how-to-get-started-with-wordpress-5eeecdf05676e.jpg\" alt=\"Dịch vụ thiết kế website wordpress\" width=\"810\" height=\"456\" /></p>\r\n<p>&nbsp;</p>\r\n<p style=\"color: #626262;\">Một điểm hết sức quan trọng l&agrave; giao diện quản trị của wordpress rất dễ sử dụng v&agrave; quản trị tốt. Điều n&agrave;y đ&aacute;p ứng tốt nhu cầu của c&aacute;c doanh nghiệp; để c&oacute; thể cho nhiều nh&acirc;n vi&ecirc;n c&oacute; thể quản trị v&agrave; chăm s&oacute;c website. Với những l&yacute; do tr&ecirc;n c&aacute;c website wordpress ho&agrave;n to&agrave;n ph&ugrave; hợp với doanh nghiệp bạn.</p>\r\n<p>&nbsp;</p>\r\n<h2><strong>Dịch vụ thiết kế website WordPress cho mọi ng&agrave;nh nghề</strong></h2>\r\n<p>&ndash; Thiết kế website giới thiệu c&ocirc;ng ty / doanh nghiệp.</p>\r\n<p>&ndash; Website b&aacute;n h&agrave;ng chuy&ecirc;n nghiệp tr&ecirc;n nền tảng wordpress.</p>\r\n<p>&ndash; Lựa chọn thiết kế website wordpress cho nh&agrave; h&agrave;ng &ndash; Kh&aacute;ch sạn.</p>\r\n<p>&ndash; Thiết kế web wordpress mảng du lịch.</p>\r\n<p>&ndash;&nbsp;Thiết kế website mảng ph&aacute;p luật.</p>\r\n<p>&ndash; Website wordpress chuy&ecirc;n nghiệp cho ph&ograve;ng kh&aacute;m.</p>\r\n<p>&ndash; Thiết kế web bất động sản tối ưu tr&ecirc;n nền tảng wordpress&hellip;.</p>\r\n<p>Li&ecirc;n hệ ngay với Ngọc Thắng &ndash; ch&uacute;ng t&ocirc;i sẵn s&agrave;ng tư vấn cho qu&yacute; kh&aacute;ch h&agrave;ng mẫu giao diện đẹp nhất cho lĩnh vực của bạn.</p>\r\n<figure id=\"attachment_3942\" class=\"wp-caption aligncenter\" style=\"text-align: center;\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"/static/files/2020/06/21/thiet-ke-web-wordpress-moi-linh-vuc-5eeecf484057e.jpg\" alt=\"thiet-ke-web-wordpress-moi-linh-vuc.jpg\" /><br />\r\n<figcaption class=\"wp-caption-text\"><em>Ngọc Thắng thiết kế web mọi ng&agrave;nh nghề</em></figcaption>\r\n</figure>\r\n<h2><strong>Kh&aacute;ch h&agrave;ng cần chuẩn bị g&igrave; trước khi thiết kế website?</strong></h2>\r\n<p>&ndash; X&aacute;c lập định hướng ph&aacute;t triển cho website: lựa chọn phương hướng v&agrave; l&ecirc;n Plan chi tiết chiến lược x&acirc;y dựng website để website ph&aacute;t triển tốt nhất.</p>\r\n<p>&ndash; Lựa chọn t&ecirc;n miền: bước n&agrave;y rất quan trọng kh&aacute;ch h&agrave;ng thường hay lựa chọn t&ecirc;n miền theo từ kh&oacute;a sản phẩm. Hoặc lựa chọn t&ecirc;n miền website theo t&ecirc;n thương hiệu.</p>\r\n<p>&ndash; Chuẩn bị đầy đủ th&ocirc;ng tin: Kh&aacute;ch h&agrave;ng cần cung cấp đầy đủ th&ocirc;ng tin về: Địa chỉ, hotline, email, t&ecirc;n miền, logo&hellip;</p>\r\n<p>&ndash; Chuẩn bị h&igrave;nh ảnh sản phẩm: lựa chọn những h&igrave;nh ảnh sắc n&eacute;t, đẹp để đưa l&ecirc;n website.</p>\r\n<p>&ndash; Tham khảo trước c&aacute;c mẫu website tr&ecirc;n internet để c&oacute; c&aacute;i nh&igrave;n đầy đủ hơn về website cũng như những t&iacute;nh năng bạn cần c&oacute; cho website của m&igrave;nh. Tại Ngọc Thắng ch&uacute;ng t&ocirc;i c&oacute; rất nhiều mẫu website với đa dạng ng&agrave;nh nghề lĩnh vực.</p>\r\n<p>Li&ecirc;n hệ ngay với Ch&uacute;ng t&ocirc;i &ndash; đội ngũ nh&acirc;n vi&ecirc;n kỹ thuật thiết kế web wordpress chuy&ecirc;n nghiệp sẵn s&agrave;ng tư vấn giải đ&aacute;p mọi thắc mắc gi&uacute;p bạn ho&agrave;n to&agrave;n miễn ph&iacute;.</p>\r\n<p>&nbsp;</p>', 'cach-cai-theme-wordpress-va-bo-suu-tap-theme-mien-phi-tot-nhat-1200x900-5eeed5d72bff8.png', 0, 'public', 1, '2020-06-21 05:45:23', '2020-07-15 21:18:04'),
(20, 1, 2, 0, 5, ' 5,', 'post', 'text', 'Thiết kế Website 1-0-2', 'thiet-ke-website-1-0-2', NULL, 'Thiết kế website 1-0-2 - Thiết kế giao diện chuẩn SEO, gọn nhẹ, thích ứng trên nhiều thiết bị, dễ dàng tùy biến. Liên hệ: SĐT: 0945786960 - Email: doanln15@gmail.com', '<h2>Thiế kế website 1-0-2 l&agrave; g&igrave;?</h2>\r\n<p>Ng&agrave;y n&agrave;y tất cả c&aacute;c th&ocirc;ng tin, tin tức, t&agrave;i liệu học tập, c&aacute;c sản phẩm đều dược lưu trự v&agrave; tr&igrave;nh b&agrave;y tr&ecirc;n c&aacute;c website. Bởi website được lưu trự tr&ecirc;n kh&ocirc;ng gian mạng qua đ&oacute; ai cũng c&oacute; thể tiếp cận, t&igrave;m hiểu. V&igrave; lẽ đ&oacute; n&ecirc;n c&aacute;c c&ocirc;ng ty, doanh nghiệp d&ugrave; kinh doanh trong bất cứ lĩnh vực n&agrave;o cũng cần c&oacute; một website để quảng b&aacute; sản phẩm, dịch vụ của m&igrave;nh.</p>\r\n<p>Nhưng l&agrave;m thế n&agrave;o để trang web của m&igrave;nh c&oacute; thể xuất hiện tr&ecirc;n top Google th&ugrave;i lại l&agrave; một vấn đề kh&aacute;c. C&oacute; rất nhiều c&aacute;ch để xuất hiện tr&ecirc;n top google v&agrave; một trong số đ&oacute; l&agrave; đầu tư cho c&aacute;c chiến dịch quảng c&aacute;o. thật sự th&igrave; việc n&agrave;y rất tốn k&eacute;m nhưng đ&ocirc;i khi vẫn kh&ocirc;ng đạt kết quả như mong đợi. Nguy&ecirc;n nh&acirc;n th&igrave; c&oacute; rất nhiều, nhưng một trong số đ&oacute; l&agrave; website được thiết kế chưa hợp l&yacute;, nội dung chưa tốt n&ecirc;n sau mỗi chiến dịch mọi chuyện lại trở về như cũ, &iacute;t người tiếp cận.</p>\r\n<p>Biết được nhu cầu đ&oacute;, Web102 đ&atilde; đưa ra rất nhiều dịch vụ trong đ&oacute; đặt biệt l&agrave; dịch vụ thiết kế website, nhằm gi&uacute;p kh&aacute;ch h&agrave;ng bước thật vững ngay những bước đi đầu ti&ecirc;n với dịch vụ thiết kế website 1-0-2 đảm bảo theo chuẩn SEO, tối ưu cho c&aacute;c thiết bị v&agrave; c&ocirc;ng cụ t&igrave;m kiếm</p>\r\n<h2>Dấu ấn ri&ecirc;ng của bạn</h2>\r\n<p>D&ugrave; bạn đang hoạt dộng trong bất cứ lĩnh vực n&agrave;o n&agrave;o, Web102 đều hỗ trợ bạn x&acirc;y dựng website kinh doanh, quản l&yacute; tập trung v&agrave; marketing online một c&aacute;ch hiệu quả nhất.</p>\r\n<p>Dưới đ&acirc;y l&agrave; một v&agrave;i mẫu giao diện phổ biến tr&ecirc;n hệ thống web102</p>\r\n<h3>B&aacute;n h&agrave;ng:&nbsp;</h3>\r\n<p style=\"text-align: center;\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"/static/files/2020/07/08/0001.jpg-5f0531e975376.png\" alt=\"0001.jpg.png\" />Một trong những giao diện b&aacute;n h&agrave;ng tr&ecirc;n hệ thống Web102</p>\r\n<p style=\"text-align: center;\"><img src=\"/static/files/2020/07/08/0002-5f0531f60f250.jpg\" alt=\"0002.jpg\" />Phi&ecirc;n bản cho diện thoại</p>\r\n<p style=\"text-align: center;\"><img src=\"/static/files/2020/07/08/0005-5f0589602460f.png\" alt=\"0005.png\" /><br />Một giao giện khac</p>\r\n<h3>Trang tin tức</h3>\r\n<p style=\"text-align: center;\"><img src=\"/static/files/2020/07/08/0004-5f0550d420706.png\" alt=\"0004.png\" />Tin tức 247</p>\r\n<p>&nbsp;</p>\r\n<h2>Trang web giới thiệu doanh nghiệp</h2>\r\n<p style=\"text-align: center;\"><img src=\"/static/files/2020/07/09/0008-5f06d6454875a.png\" alt=\"0008.png\" /><br />Một trong những giao diện web cho doanh nghiệp</p>\r\n<h2>Trang Portfolio - Hồ sơ c&aacute; nh&acirc;n - CV online</h2>\r\n<p style=\"text-align: center;\"><img src=\"/static/files/2020/07/08/006-5f058e51a9224.png\" alt=\"006.png\" /><br />VCard - CV Online</p>\r\n<p>&nbsp;</p>\r\n<p>V&agrave; c&ograve;n rất nhiều những giao diện theo từng lĩnh vực v&agrave; mục d&iacute;ch kh&aacute;c nữa</p>\r\n<p>H&atilde;y li&ecirc;n hệ với ch&uacute;ng t&ocirc;i để c&oacute; được một ttrang web ph&ugrave; hợp với nhu cầu v&agrave; chuẩn SEO</p>\r\n<p>Mọi chi tiết xin vui l&ograve;ng li&ecirc;n hệ:</p>\r\n<p>Số điện thoại: 094.578.6960</p>\r\n<p>Email: <a href=\"mailto:doanln16@gmail.com\">doanln16@gmail.com</a></p>\r\n<p>Facebook: <a href=\"https://fb.me/LeNgocDoan\">https://fb.me/LeNgocDoan</a></p>\r\n<p>Hoặc sử dụng mục<a href=\"/lien-he.html\"> li&ecirc;n hệ</a></p>', 'cong-ty-thiet-ke-website-nef-5eeedecf61817.jpg', 0, 'public', 1, '2020-06-21 15:15:11', '2020-07-15 21:18:04'),
(21, 8, 2, 0, 7, ' 7,', 'post', 'text', 'Thiết kế Logo', 'thiet-ke-logo', 'Thiết kế Logo', NULL, '<p>Logo được biết đến l&agrave; h&igrave;nh ảnh đại diện của mỗi doanh nghiệp ở đ&oacute; thể hiện c&aacute; t&iacute;nh, sự kh&aacute;c biệt, đặc trưng của mỗi doanh nghiệp . Một Logo cần đ&aacute;p ứng rất nhiều ti&ecirc;u ch&iacute; như m&agrave;u sắc, bố cục, ph&ocirc;ng chữ v&agrave; hơn hết phải truyền tải được th&ocirc;ng điệp của doanh nghiệp hướng đến tương lai. Th&ocirc;ng thường Logo bao gồm chữ v&agrave; h&igrave;nh ảnh, nội dung cần c&ocirc; đọng, ngắn gọn v&agrave; mang t&iacute;nh thẩm mỹ, gắn liền với qu&aacute; tr&igrave;nh hoạt động của c&ocirc;ng ty. Logo l&agrave; một trong những yếu tố then chốt dẫn trong việc tạo dấu ấn trong l&ograve;ng kh&aacute;ch h&agrave;ng. C&oacute; thể khẳng định rằng Logo v&ocirc; c&ugrave;ng quan trọng, đ&oacute; c&ograve;n l&agrave; biểu tượng mang linh hồn của tổ chức, c&ocirc;ng ty.</p>\r\n<p>Nếu bạn đang ấp ủ một thiết kế hay ho, h&atilde;y chia sẻ &yacute; tưởng đ&oacute; với Web 1-0-2 để nhận được th&ocirc;ng tin tư vấn&nbsp;<a href=\"/lien-he.html\"><strong>tại đ&acirc;y</strong></a> bạn nh&eacute;!</p>', '1200x630wa-5ef4ca86ae910.png', 0, 'public', 1, '2020-06-26 03:02:14', '2020-07-15 21:18:04'),
(22, 1, 4, 0, 10, ' 10,', 'post', 'text', 'Mở đầu', 'mo-dau', NULL, NULL, '<p>Crazy Laravel l&agrave; một CMS được ph&aacute;t triển tr&ecirc;n ng&ocirc;n ngũ PHP v&agrave; sừ dụng framework Laravel, t&iacute;ch hợp c&aacute;c chức năng với nhu cầu sử dụng kh&aacute;c nhau như b&aacute;n h&agrave;ng, tin tức, blog, giới thiệu c&ocirc;ng ty,...</p>\r\n<p>Web&nbsp; 1-0-2 l&agrave; sự kết hợp giữa Crazy Laravel v&agrave; hệ thống quản l&yacute; domain-hosting để tạo ra một hệ thống cho ph&eacute;p người d&ugrave;ng c&oacute; thể tạo ra những trang web theo &yacute; m&igrave;nh chỉ trong v&agrave;i ph&uacute;t.</p>\r\n<p>Tất cả những g&igrave; bạn cần chỉ l&agrave; một &yacute; tưởng c&aacute;c vấn để c&ograve;n lại đ&atilde; c&oacute; ch&uacute;ng t&ocirc;i lo!</p>\r\n<p>Bạn đ&atilde; c&oacute; &yacute; tưởng rồi chứ? Bắt đầu th&ocirc;i!</p>', NULL, 0, 'public', 0, '2020-07-07 21:33:04', '2020-07-10 02:05:21'),
(23, 1, 0, 0, 2, ' 2,', 'project', 'text', 'Noof Food', 'noof-food', NULL, 'Trang web blog, bán hàng ẩm thực', '<p>Trang web chuy&ecirc;n về ẩm thực</p>', 'screencapture-nooffood-vcc-vn-2020-07-07-17-45-10-5f045e3a59e1a.png', 0, 'public', 0, '2020-07-07 22:36:26', '2020-07-08 04:12:20'),
(24, 1, 4, 0, 10, ' 10,', 'post', 'text', 'Đăng ký website', 'dang-ky-website', NULL, 'Hướng dẫn các bước tạo một website trên hệ thống', '<p>Chỉ với v&agrave;i bước đ&acirc;n giản bạn đ&atilde; c&oacute; thể tạo ra một trang web theo &yacute; m&igrave;nh rồi. H&atilde;y l&agrave;m theo c&aacute;c bước sau nh&eacute;</p>\r\n<h4>Bước 1:&nbsp;</h4>\r\n<p>Tr&ecirc;n thanh điều hướng bạn nhấn v&agrave;o \"T&agrave;i khoản\". ở bước n&agrave;y nếu chưa đăng nhập hệ thống sẽ gi&uacute;p bạn chuyển hướng đến trang đăng nhập.</p>\r\n<p>&nbsp;</p>\r\n<h4>Bước 2:</h4>\r\n<p>Tại trang t&agrave;i khoản, bạn nhấn v&agrave;o \"th&ecirc;m dịch vụ\" ở phần sidebar b&ecirc;n tr&aacute;i</p>\r\n<p>&nbsp;</p>\r\n<h4>Bước 3:&nbsp;</h4>\r\n<p>Chọn dịch vụ, g&oacute;i, sau đ&oacute; nhập đầy đủ c&aacute;c th&ocirc;ng tin bắt buộc, sau đ&oacute; nhấn n&uacute;t \"Th&ecirc;m dịch vụ\"</p>\r\n<p>&nbsp;</p>\r\n<h4>Bước 4:</h4>\r\n<p>Tiến h&agrave;nh thanh to&aacute;n nếu bạn chọn c&aacute;c g&oacute;i&nbsp; dịch vụ n&acirc;ng cao</p>\r\n<p>&nbsp;</p>\r\n<p>Ch&uacute;c c&aacute;c bạn th&agrave;nh c&ocirc;ng!</p>', NULL, 0, 'public', 0, '2020-07-09 21:50:02', '2020-07-09 21:57:32'),
(25, 1, 4, 0, 11, ' 11,', 'post', 'text', 'Cài đặt', 'cai-dat', NULL, NULL, '<h4 id=\"require\" class=\"c_head\"># Y&ecirc;u cầu hệ thống</h4>\r\n<p>V&igrave; được ph&aacute;t triển tr&ecirc;n nền tảng PHP n&ecirc;n Web 1-0-2 CMS (hay Crazy Laravel) y&ecirc;u cầu hệ thống tối thiểu như sau:&nbsp;</p>\r\n<ul>\r\n<li>PHP &gt;= 7.2.5</li>\r\n<li>BCMath PHP Extension</li>\r\n<li>Ctype PHP Extension</li>\r\n<li>Fileinfo PHP extension</li>\r\n<li>JSON PHP Extension</li>\r\n<li>Mbstring PHP Extension</li>\r\n<li>OpenSSL PHP Extension</li>\r\n<li>PDO PHP Extension</li>\r\n<li>Tokenizer PHP Extension</li>\r\n<li>XML PHP Extension</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<h4 id=\"Installing\" class=\"c_head\"># C&agrave;i đặt CMS&nbsp;</h4>\r\n<p><strong>Bước 1: Clone Project</strong></p>\r\n<p>Sữ dụng git command</p>\r\n<pre>git clone <a href=\"https://github.com/vccvn/cms.git\">https://github.com/vccvn/cms.git</a></pre>\r\n<p>&nbsp;</p>\r\n<p><strong>Bước 2: C&agrave;i đặt c&aacute;c thư viện th&ocirc;ng qua composer</strong></p>\r\n<p>C&agrave;i đặt th&ocirc;ng qua lệnh composer:</p>\r\n<pre>composer install</pre>\r\n<p>Bước 3: Sửa file .env</p>\r\n<p>Nếu chưa c&oacute; file .env th&igrave; đổi t&ecirc;n file .env.example th&agrave;nh .env, sau đ&oacute; chỉnh sửa lại c&aacute;c th&ocirc;ng tin như database, mail</p>\r\n<div class=\"highlight\">\r\n<p><strong>Database:</strong></p>\r\n<pre><code class=\"language-html\" data-lang=\"php\">\r\nDB_CONNECTION=mysql\r\nDB_HOST=127.0.0.1\r\nDB_PORT=3306\r\nDB_DATABASE=database\r\nDB_USERNAME=root\r\nDB_PASSWORD=\r\n</code></pre>\r\n<p>&nbsp;</p>\r\n<p><strong>Mailer:</strong></p>\r\n<pre><code class=\"language-php\" data-lang=\"php\">\r\nMAIL_DRIVER=smtp\r\nMAIL_HOST=smtp.gmail.com\r\nMAIL_PORT=587\r\nMAIL_USERNAME=test@gmail.com\r\nMAIL_PASSWORD=Light&gt;=2025\r\nMAIL_ENCRYPTION=tls\r\n\r\nMAIL_FROM_ADDRESS=test@gmail.com\r\nMAIL_FROM_NAME=LightServices\r\n\r\n</code></pre>\r\n</div>\r\n<p>&nbsp;</p>', NULL, 0, 'public', 0, '2020-07-09 22:19:05', '2020-07-11 20:45:08'),
(27, 1, 4, 0, 11, ' 11,', 'post', 'text', 'Khởi chạy', 'khoi-chay', NULL, NULL, '<p>CMS n&agrave;y sử dụng laravel n&ecirc;n khi dự server ch&uacute;ng ta cũng sử dụng c&aacute;c lệnh của laravel</p>\r\n<h4><a id=\"phpartisan\"></a>php artisan</h4>\r\n<p>Chạy với cổng mặc định 8000:</p>\r\n<p><code>php artisan serve</code></p>\r\n<p>l&ecirc;nh n&agrave;y sẽ build cho ch&uacute;ng ta một server với địa chỉ: <a href=\"http://localhost:8000\">http://localhost:8000</a></p>\r\n<p>Ngo&agrave;i ra ch&uacute;ng ta c&ograve;n c&oacute; thể t&ugrave;y biến cổng với tham số --port</p>\r\n<p>v&iacute; dụ:</p>\r\n<p><code>php artisan serve --port=3000</code></p>\r\n<p>lệnh n&agrave;y sẽ dựng một server với cổng 300: <a href=\"http://localhost:3000\">http://localhost:3000</a></p>\r\n<p>&nbsp;</p>\r\n<h4><a id=\"suggest\"></a>Mẹo nhỏ tr&ecirc;n Windows nếu bạn c&agrave;i Xampp</h4>\r\n<p>C&aacute;c bạn ho&agrave;n to&agrave;n c&oacute; thể thiết lập một server ảo để chạy ứng dụng m&agrave; kh&ocirc;ng cần chạy lệnh php artisan v&agrave; cũng kh&ocirc;ng cần nh&eacute;t hết ứng dụng v&agrave;o thư mục htdocs của Xampp b&agrave;ng c&aacute;ch l&agrave;m theo c&aacute;c bước sau:</p>\r\n<h5>Bước 1:</h5>\r\n<p>v&agrave;o thư mục:&nbsp; <strong>C:\\Windows\\System32\\drivers\\etc</strong> sau đ&oacute; copy file hosts ra desktop hoặc đ&acirc;u đ&oacute; m&agrave; sau n&agrave;y bạn c&oacute; thể dễ d&agrave;ng chỉnh sửa.</p>\r\n<figure><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"/static/files/2020/07/11/0001-5f0932083cbd1.png\" alt=\"0001.png\" width=\"579\" height=\"378\" />\r\n<figcaption></figcaption>\r\n</figure>\r\n<h5>Bước 2:&nbsp;</h5>\r\n<p>Chỉnh sửa file host v&agrave; th&ecirc;m v&agrave;o cuối d&ograve;ng nội dung như sau:</p>\r\n<p>127.0.0.1&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;domain.com</p>\r\n<p>trong đ&oacute; 127.0.0.1 l&agrave; địa chỉ nỗi bộ của server (m&aacute;y t&iacute;nh của bạn), cỏn domain.com l&agrave; t&ecirc;n miền bất kỳ</p>\r\n<figure style=\"text-align: center;\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"/static/files/2020/07/11/0002-5f0933df61854.png\" alt=\"0002.png\" width=\"557\" height=\"339\" />\r\n<figcaption></figcaption>\r\n<figcaption>trỏ t&ecirc;n miền về địa chỉ m&aacute;y t&iacute;nh của bạn (local)</figcaption>\r\n</figure>\r\n<h5>Bước 3:</h5>\r\n<p>Copy file host trở lại thư mục:&nbsp; <strong>C:\\Windows\\System32\\drivers\\etc</strong></p>\r\n<figure style=\"text-align: center;\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"/static/files/2020/07/11/0003-5f09356516f94.png\" alt=\"0003.png\" />\r\n<figcaption></figcaption>\r\n<figcaption>Bước n&agrave;y hệ thống sẽ hỏi c&oacute; muốn thay thế hay kh&ocirc;ng? Chọn thay thế</figcaption>\r\n</figure>\r\n<p style=\"text-align: center;\">&nbsp;</p>\r\n<figure style=\"text-align: center;\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"/static/files/2020/07/11/0004-5f09362747503.png\" alt=\"0004.png\" />\r\n<figcaption></figcaption>\r\n<figcaption>Continue</figcaption>\r\n</figure>\r\n<h5>Bước 4:&nbsp;</h5>\r\n<p>V&agrave;o thư mux5 config của Xampp c&oacute; dạng như sau:&nbsp;<strong> D:\\xampp\\apache\\conf\\extra</strong></p>\r\n<p>Sau đ&oacute; chỉnh sửa file <strong>httpd-vhost.conf </strong>V&agrave; th&ecirc;m v&agrave;o nội dung sau:</p>\r\n<pre class=\"language-markup\"><code>&lt;VirtualHost *:80&gt;\r\n    ServerAdmin webmaster@webhay.com\r\n    ServerName webhay.com\r\n    ServerAlias www.webhay.com\r\n    DocumentRoot D:/doanln/webhay/public\r\n    \r\n    &lt;Directory D:/doanln/webhay/public&gt;\r\n        Options Indexes FollowSymLinks\r\n        AllowOverride All\r\n        Require all granted\r\n        DirectoryIndex index.php index.pl index.cgi index.html index.xhtml $\r\n    &lt;/Directory&gt;\r\n\r\n    ErrorLog \"logs/webhay.com-error.log\"\r\n    CustomLog \"logs/webhay.com-access.log\" common\r\n&lt;/VirtualHost&gt;</code></pre>\r\n<p>Trong đ&oacute;:</p>\r\n<p><strong>ServerName</strong> l&agrave; th&ocirc;ng tin t&ecirc;n miềncủa bạn. ở&nbsp; l&aacute;y v&iacute; dụ l&agrave; webhay.com</p>\r\n<p><strong>DocumentRoot</strong> l&agrave; dừng dẫn đến thư mục chứa file index của project cụa thể trong laravel sẽ chứa trong thư mục public c&ograve;n c&aacute;c cms như l&agrave; wordpress th&igrave; ch&iacute;nh l&agrave; thư mục project lu&ocirc;n</p>\r\n<p><strong>&lt;Directory&gt;</strong> cũng c&oacute; đừng dẫn giống DocumentRoot</p>\r\n<p>C&aacute;c th&ocirc;ng số kh&aacute;c cứ copy v&agrave; thay thế th&ocirc;i!</p>\r\n<p>Sau đ&oacute; chạy lại xam l&agrave; bạn c&oacute; thể chay project th&ocirc;ng qua server ảo m&agrave; kh&ocirc;ng cần chạy lệnh php artisan server rồi!</p>', NULL, 0, 'public', 0, '2020-07-11 15:06:59', '2020-07-11 15:35:02');
INSERT INTO `posts` (`id`, `author_id`, `dynamic_id`, `parent_id`, `category_id`, `category_map`, `type`, `content_type`, `title`, `slug`, `keywords`, `description`, `content`, `feature_image`, `views`, `privacy`, `deleted`, `created_at`, `updated_at`) VALUES
(28, 1, 4, 0, 11, ' 11,', 'post', 'text', 'Cấu trúc thư mục', 'cau-truc-thu-muc', NULL, NULL, '<p>L&agrave; một CMS ph&aacute;t triển bằng laravel n&ecirc;n cấu cấu tr&uacute;c cũng gần giống laravel. Ở đ&acirc;y chỉ đưa ra một số điểm kh&aacute;c biệt cũng l&agrave; quan trọng cho CMS. C&aacute;c bạn c&oacute; thể t&igrave;m hiểu th&ecirc;m laravel <a href=\"https://laravel.com/docs/7.x/structure\" target=\"_blank\" rel=\"noopener\">tại đ&acirc;y</a>!</p>\r\n<h5><a id=\"project-structure\"></a>1. Cấu tr&uacute;c project (cms)</h5>\r\n<pre class=\"snippet\"><code class=\"language-html\" data-lang=\"css\">\r\nproject/\r\n├── <a title=\"Cấu tr&uacute;c thư mục app\" href=\"#app-structure\">app/</a>             // thư mục chứa code logic\r\n├── boostrap/        // thư mục hệ thống\r\n├── config/	         // thư mục chưa file cấu h&igrave;nh\r\n├── database/        // thư mục cơ sở dữ liệu dạng code\r\n├── helpers/         // thư mục chứa c&aacute;c h&agrave;m hỗ trợ\r\n├── <a title=\"Cấu tr&uacute;c thư mục json\" href=\"#json-structure\">json</a>/             // thư mục dữ liệu form, menu, dữ liễu mẫu\r\n├── packages/        // thư mục c&aacute;c g&oacute;i thư viện hỗ trợ\r\n├── public/          // thư mục chứa t&agrave;i nguy&ecirc;n ảnh, js, css, ...\r\n├── resources/       // thư mục t&agrave;i nguy&ecirc;n, chứa view\r\n├── routes/          // thư mục chứa c&aacute;c route điều hướng\r\n├── tests/           // thư mục ứng dụng\r\n├── themes/          // thư mục giao diện dược upload\r\n├── z-dev/           // thư mục thư viện rời. hỗ trợ file dev\r\n├── .env             // file cấu h&igrave;nh c&aacute;c biến m&ocirc;i trường\r\n├── artisan          // tập lệnh của laravel\r\n├── dev              // Tập lệnh của cma\r\n├── server.php\r\n├── webpack.min.js\r\n├── ... {một số file cấu h&igrave;nh}\r\n</code></pre>\r\n<p>&nbsp;</p>\r\n<h5><a id=\"app-structure\"></a>2. Cấu tr&uacute;c app/</h5>\r\n<p>Cấu tr&uacute;c app cũng gần giống Laravel chỉ kh&aacute;c l&agrave; được chia ra theo chức năng v&agrave; th&ecirc;m một v&agrave;i mắt x&iacute;ch xử l&yacute; dữ liệu</p>\r\n<pre class=\"snippet\"><code class=\"language-html\" data-lang=\"css\">\r\napp/\r\n├── Console/\r\n├── Crawlers/                    // chức năng crawl dữ liệu\r\n├── Engines/	                 // C&aacute;c class chức năng dộc lập\r\n├── Http/                        // Xử l&yacute; request\r\n│   ├── Controllers/             // chứa c&aacute;c controller\r\n│   │   ├── Accounts/            // xử l&yacute; c&aacute;c y&ecirc;u cầu t&agrave;i khoản\r\n│   │   ├── Admin/               // Quản trị website theo c&aacute;c hạng mục li&ecirc;n quan\r\n│   │   │   ├── Business/        // c&aacute;c controller chức năng web c&ocirc;ng ty\r\n│   │   │   ├── Default/         // c&aacute;c chức năng g&oacute;i mặc định\r\n│   │   │   ├── Ecommerce/       // C&aacute;c controller xử l&yacute; b&aacute;n h&agrave;ng\r\n│   │   │   ├── General/         // ... d&ugrave;ng chung\r\n│   │   │   ├── News/            // ... Tin tức\r\n│   │   │   ├── Personal/        // trang c&aacute; nh&acirc;n\r\n│   │   │   ├── AdminController.php\r\n│   │   │   ├── AjaxController.php\r\n│   │   │   ├── DashboardController.php\r\n│   │   ├── Apis/                // Xử l&yacute; c&aacute;c api request\r\n│   │   ├── Clients/             // Xữ l&yacute; c&aacute;c request ở ph&iacute;a kh&aacute;ch h&agrave;ng\r\n│   │   ├── AuthController.php\r\n│   │   ├── Controller.php         \r\n│   ├── Middlewares/\r\n│   ├── Kermel.php\r\n├── Masks/           // (mặc nạ) c&aacute;c đối tượng dai8 diện cho model trong view\r\n├── Models/          // Model\r\n├── Repositories/    // c&aacute;c cấu tr&uacute;c xử l&yacute; dữ liệu\r\n├── Support/\r\n├── Validators/      // Xử l&yacute; dữ liệu user gửi l&ecirc;n\r\n├── web/             \r\n├── ... (Một số thư mục của laravel)\r\n</code></pre>\r\n<h5><a id=\"json-structure\"></a>3. Cấu tr&uacute;c thư mục json</h5>\r\n<p>Đ&acirc;y l&agrave; thư mục quan trọng gi&uacute;p cấu h&igrave;nh, hiển thị form, hiểu thị danh s&aacute;ch bản ghi nếu sử dụng chế độ đặc biệt trong controller</p>\r\n<pre class=\"snippet\"><code class=\"language-html\" data-lang=\"css\">\r\njson/\r\n├── admin/                       // c&aacute;c file cấu h&igrave;nh cho admin\r\n│   ├── forms/                   // chứa c&aacute;c file cấu h&igrave;nh để hiển thị form\r\n│   │   ├── page.json            // Chứa th&ocirc;ng tin input, layout hiển thị tr&ecirc;n trang form\r\n│   │   ├── *.json               // tương tự với c&aacute;c file kh&aacute;c\r\n│   ├── menu/                    // chứa c&aacute;c file cấu h&igrave;nh hiển thị menu tr&ecirc;n trang admin hoặc menu bất kỳ\r\n│   │   ├── base.json\r\n│   │   ├── ...\r\n│   ├── modules/                 // Chứa th&ocirc;ng tin form v&agrave; danh s&aacute;ch bản ghi theo module\r\n│   │   ├── projects/            // module project bao gồm form v&agrave; c&aacute;ch thức hiển thị bản ghi\r\n│   │   │   ├── categories/      // module project category bao gồm form v&agrave; c&aacute;ch thức hiển thị bản ghi\r\n│   │   │   │   ├── form.json    // Cấu h&igrave;nh form Danh mục dự &aacute;n\r\n│   │   │   │   ├── list.json    // Cấu h&igrave;nh Danh mục danh s&aacute;ch\r\n│   │   │   ├── form.json        // Cấu h&igrave;nh form dự &aacute;n\r\n│   │   │   ├── list.json        // Cấu h&igrave;nh danh s&aacute;ch\r\n│   │   ├── */                   // module bao gồm form v&agrave; c&aacute;ch thức hiển thị bản ghi\r\n├── clients/                     // Tương  tự admin\r\n├── config/                      // Cấu h&igrave;nh c&aacute;c chức năng hệ thống\r\n│   ├── ecomerce.json\r\n│   ├── general.json\r\n│   ├── personal.json\r\n│   ├── products.json\r\n│   ├── system.json              // cấu h&igrave;nh chức năng cho từng loại web\r\n│   ├── user.json\r\n│   ├── web.json\r\n├── data/\r\n├── Webdata/\r\n</code></pre>\r\n<p>&nbsp;</p>\r\n<h5><a id=\"view-structure\"></a>4. Cấu tr&uacute;c thư nục Views</h5>\r\n<pre class=\"snippet\"><code class=\"language-html\" data-lang=\"css\">\r\nresources/views/\r\n├── accounts/\r\n├── admin/                       // C&aacute;c view của trang admin\r\n│   ├── _components              // c&aacute;c th&agrave;nh phần trong trang như header, sidebar, footer, modal\r\n│   ├── _layouts                 // C&aacute;c khung (vỏ) để hiển thị trang web\r\n│   ├── _meta\r\n│   ├── _modals                  // modal\r\n│   ├── _module                  // view cho form v&agrave; list\r\n│   ├── _pagination              // ph&acirc;n trang\r\n│   ├── _templates               // giống component nhưng nhỏ v&agrave; lặt vặt hơn\r\n│   ├── alert                    // view hiễn thị th&ocirc;ng b&aacute;o\r\n│   ├── auth                     // view đăng nhập v&agrave; một số thao t&aacute;c li&ecirc;n quan trong admin\r\n│   ├── crawlers                 // crawl data\r\n│   ├── dashboard                // view dashvoard\r\n│   ├── dynamics                 // danh s&aacute;ch v&agrave; c&aacute;c mục li&ecirc;n quan của k&ecirc;nh đăng b&agrave;i\r\n│   ├── errors                   // thong b&aacute;o lỗi\r\n│   ├── forms                    // form v&agrave; template input\r\n│   ├── html\r\n│   ├── menus                    // quản l&yacute; menu\r\n│   ├── pages                    // trang\r\n│   ├── pending                  // kh&ocirc;ng quan trọng\r\n│   ├── permissions              // chức năng ph&acirc;n quyền\r\n│   ├── posts                    // b&agrave;i viết\r\n│   ├── products                 // sản phẩm\r\n│   ├── profile                  // trang c&aacute; nh&acirc;n\r\n│   ├── settings                 // thiết lập\r\n│   ├── sliders                  // slider\r\n│   ├── tags                     // thẻ b&agrave;i viết\r\n│   ├── themes                   // giao diện\r\n│   ├── users                    // quản l&yacute; người d&ugrave;ng\r\n├── client-libs/                 // C&aacute;c thư viện d&ugrave;ng trong view ph&iacute;a client\r\n├── clients/                     // Chứa c&aacute;c view của giao diện\r\n├── mails/                       // C&aacute;c view của email\r\n├── sitemap/                     // sitemap\r\n</code></pre>\r\n<p>&nbsp;</p>', NULL, 0, 'public', 0, '2020-07-11 15:37:00', '2020-07-30 03:46:34'),
(29, 1, 4, 0, 11, ' 11,', 'post', 'text', 'Life Cycle', 'life-cycle', NULL, NULL, '<p>Cũng gi&oacute;ng nguy&ecirc;n bản của laravel quy tr&igrave;nh c&aacute;c bước xử l&yacute; một request như sau</p>\r\n<figure style=\"text-align: center;\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"/static/files/2020/07/11/Laravel-MVC-model-MSA-Technosoft-5f098f0c51d2d.png\" alt=\"Laravel-MVC-model-MSA-Technosoft.png\" width=\"476\" height=\"299\" />\r\n<figcaption></figcaption>\r\n<figcaption>H&igrave;nh 1: V&ograve;ng đời request của Laravel</figcaption>\r\n</figure>\r\n<p>1. Ta c&oacute; thể thấy qu&aacute; tr&igrave;nh bắt đầu khi browser gửi request đến server.</p>\r\n<p>2. Sau đ&oacute; th&ocirc;ng qua route sẽ chuyển y&ecirc;u cầu đến controller,</p>\r\n<p>3. tiếp đến controller sẽ tương t&aacute;c với model để truy xuất v&agrave; sử l&yacute; dữ liệu</p>\r\n<p>4. dữ liệu sau khi được trả về controller sẽ được xử l&yacute; hoặc đổ trực tiếp ra view</p>\r\n<p>5. view sẽ đổ ra tr&igrave;nh duyệt.</p>\r\n<p>Đ&oacute; l&agrave; quy chuẩn của laravel. C&ograve;n đối với CMS cụ thể l&agrave; Crazy Laravel th&igrave; sẽ c&oacute; th&ecirc;m hoặc biến đổi một số bước để phủ hợp với chức năng, y&ecirc;u cầu</p>', NULL, 0, 'public', 0, '2020-07-11 21:32:07', '2020-07-11 21:32:07');
INSERT INTO `posts` (`id`, `author_id`, `dynamic_id`, `parent_id`, `category_id`, `category_map`, `type`, `content_type`, `title`, `slug`, `keywords`, `description`, `content`, `feature_image`, `views`, `privacy`, `deleted`, `created_at`, `updated_at`) VALUES
(30, 1, 4, 0, 11, ' 11,', 'post', 'text', 'Controller', 'controller', NULL, NULL, '<h4><a id=\"base-controller\"></a>I. Base Controller</h4>\r\n<p>Đ&acirc;y l&agrave; controller gốc dược kế thừa từ Laravel v&agrave; triển khai th&ecirc;m c&aacute;c trait module nhằm t&aacute;i sử dụng code một c&aacute;ch tối đa. Từ controller n&agrave;y sẽ triển khai c&aacute;c controller module kh&aacute;c</p>\r\n<pre class=\"snippet\"><code class=\"language-php\" data-lang=\"php\">&lt;?php\r\n\r\nnamespace App\\Http\\Controllers;\r\n\r\nuse Illuminate\\Foundation\\Bus\\DispatchesJobs;\r\nuse Illuminate\\Routing\\Controller as BaseController;\r\nuse Illuminate\\Foundation\\Validation\\ValidatesRequests;\r\nuse Illuminate\\Foundation\\Auth\\Access\\AuthorizesRequests;\r\n\r\nclass Controller extends BaseController\r\n{\r\n    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,\r\n    \r\n    \r\n    // module quan li lien quan toi modulw se dc ke thua tu controller nay\r\n        Traits\\ModuleMethods, \r\n        // tap hop cac thuoc tinh va ham lien quan den view\r\n        Traits\\ModuleData, \r\n        // tap hop cac thuoc tinh va ham lien quan den view\r\n        Traits\\ViewMethods, \r\n        // tap hop cac thuoc tinh va ham lien quan den form\r\n        Traits\\FormMethods, \r\n        // tap hop cac thuoc tinh va ham lien quan den xu ly su kien nhu create, update, delete, restore\r\n        Traits\\CrudMethods,\r\n        // tap hop cac thuoc tinh va ham lien quan den xu ly su kien nhu save , handle\r\n        Traits\\BaseCrud,\r\n        // tap hop cac thuoc tinh va ham lien quan den xu ly su file\r\n        Traits\\FileMethods,\r\n        // tap hop cac thuoc tinh va ham lien response \r\n        Traits\\ResponseMethods;\r\n\r\n        \r\n    /**\r\n     * Create a new controller instance.\r\n     *\r\n     * @return void\r\n     */\r\n    public function __construct()\r\n    {\r\n        $this-&gt;init();\r\n    }\r\n\r\n    /**\r\n     * thuc thi mot so thiet lap\r\n     * @return void\r\n     */\r\n    public function init()\r\n    {\r\n        $this-&gt;moduleInit();\r\n        $this-&gt;crudInit();\r\n        $this-&gt;fileInit();\r\n        $this-&gt;formInit();\r\n        $this-&gt;activeMenu();\r\n        $this-&gt;start();\r\n    }\r\n\r\n    /**\r\n     * start \r\n     */\r\n    public function start()\r\n    {\r\n        # code...\r\n    }\r\n\r\n}\r\n?&gt;\r\n</code></pre>\r\n<p>&nbsp;</p>\r\n<p>Controller sẽ được chia th&agrave;nh 2 nh&oacute;m ch&iacute;nh để phục vụ cho việc uản l&yacute; code v&agrave; bảo mật. cụ thể sẽ chia l&agrave;m 2 nh&oacute;m cơ bản l&agrave; admin v&agrave; client, mỗi một nh&oacute;m sẽ c&oacute; c&aacute;c phương thức v&agrave; c&aacute;ch hoạt động kh&aacute;c nhau.</p>\r\n<h4><a id=\"admin-controller\"></a>II. Admin Controller</h4>\r\n<pre class=\"snippet\"><code class=\"language-php\" data-lang=\"php\">\r\n&lt;?php\r\n\r\nnamespace App\\Http\\Controllers\\Admin;\r\n\r\nuse App\\Http\\Controllers\\Controller;\r\n\r\n\r\nuse Illuminate\\Http\\Request;\r\nuse Crazy\\Files\\Filemanager;\r\nuse Crazy\\Html\\Menu;\r\n\r\nclass AdminController extends Controller\r\n{\r\n    /**\r\n     * @var string $routeNamePrefix\r\n     */\r\n    protected $routeNamePrefix = \'admin.\';\r\n\r\n    /**\r\n     * @var string $viewFolder thu muc chua view\r\n     * khong nen thay doi lam gi\r\n     */\r\n    protected $viewFolder = \'admin\';\r\n    /**\r\n     * @var string dường d&atilde;n thư mục chứa form\r\n     */\r\n    protected $formDir = \'admin/forms\';\r\n\r\n    /**\r\n     * @var string $menuName\r\n     */\r\n    protected $menuName = \'admin_menu\';\r\n    \r\n\r\n    protected $scope = \'admin\';\r\n\r\n}\r\n\r\n</code></pre>\r\n<p>&nbsp;</p>\r\n<h4><a id=\"project-controller\"></a>Project Controller</h4>\r\n<p>Mẫu (controller chức năng quản l&yacute; project)</p>\r\n<pre class=\"snippet\"><code class=\"language-php\" data-lang=\"php\">\r\n&lt;?php\r\n\r\nnamespace App\\Http\\Controllers\\Admin\\General;\r\n\r\nuse Illuminate\\Http\\Request;\r\nuse App\\Http\\Controllers\\Admin\\AdminController;\r\nuse Crazy\\Helpers\\Arr;\r\n\r\nuse App\\Repositories\\Projects\\ProjectRepository;\r\nuse App\\Repositories\\Tags\\TagRefRepository;\r\nuse App\\Repositories\\Metadatas\\MetadataRepository;\r\nuse App\\Repositories\\Files\\FileRepository;\r\n\r\nclass ProjectController extends AdminController\r\n{\r\n    protected $module = \'projects\';\r\n\r\n    protected $moduleName = \'Dự &aacute;n\';\r\n\r\n    protected $flashMode = true;\r\n\r\n    \r\n    \r\n    public $featureImageWidth = 400;\r\n    public $featureImageHeight = 400;\r\n    \r\n    public $socialImageWidth = 600;\r\n    public $socialImageHeight = 315;\r\n    \r\n    \r\n    // protected $makeThumbnail = true;\r\n    \r\n    /**\r\n     * Create a new controller instance.\r\n     *\r\n     * @return void\r\n     */\r\n    public function __construct(ProjectRepository $projectRepository, TagRefRepository $tagRefRepository, MetadataRepository $metadataRepository, FileRepository $fileRepository)\r\n    {\r\n        $this-&gt;repository = $projectRepository;\r\n        $this-&gt;tagRefRepository = $tagRefRepository;\r\n        $this-&gt;metadataRepository = $metadataRepository;\r\n        $this-&gt;fileRepository = $fileRepository;\r\n        $this-&gt;init();\r\n    }\r\n\r\n    /**\r\n     * can thiệp trước khi luu\r\n     * @param Illuminate\\Http\\Request $request\r\n     * @param Arr $data dũ liệu đ&atilde; được validate\r\n     * @return void\r\n     */\r\n    protected function beforeSave(Request $request, Arr $data)\r\n    {\r\n        if(!$request-&gt;id){\r\n            $data-&gt;author_id = $request-&gt;user()-&gt;id;\r\n        }\r\n        $data-&gt;slug = $this-&gt;repository-&gt;getSlug(\r\n            $request-&gt;custom_slug? $request-&gt;slug : $request-&gt;title,\r\n            $request-&gt;id\r\n        );\r\n        $this-&gt;uploadImageAttachFile($request, $data, \'feature_image\', \'static/projects\');\r\n\r\n        \r\n        $this-&gt;makeSocialImage($data, $this-&gt;module);\r\n\r\n        if($data-&gt;category_id){\r\n            $data-&gt;category_map = $this-&gt;repository-&gt;makeCategoryMap($data-&gt;category_id);\r\n        }\r\n    }<br />    \r\n    /**\r\n     * can thiệp sau khi luu\r\n     * @param Illuminate\\Http\\Request $request\r\n     * @param Model $project dũ liệu đ&atilde; được luu\r\n     * @param Arr $data \r\n     * @return void\r\n     */\r\n    public function afterSave(Request $request, $project, $data)\r\n    {\r\n        $tags =  $this-&gt;tagRefRepository-&gt;updateTagRef(\'project\', $project-&gt;id, $data-&gt;tags??[]);\r\n        $meta = $data-&gt;copy(\r\n            [\r\n                \'custom_slug\',\r\n                \'client_id\',\r\n                \'website\',\r\n                \'link\',\r\n                \'feature_image_keep_original\'\r\n            ]\r\n        );\r\n        \r\n        $meta[\'og_image_width\'] = $this-&gt;featureImageWidth;\r\n        $meta[\'og_image_height\'] = $this-&gt;featureImageHeight;\r\n        $metas = $this-&gt;metadataRepository-&gt;saveMany(\'project\', $project-&gt;id, $meta);\r\n        //nếu c&oacute; gallery\r\n        if($request-&gt;id == $project-&gt;id){\r\n            $this-&gt;fileRepository-&gt;deleteRefFileIgnoreList(\'project\', $project-&gt;id, is_array($request-&gt;gallery_ids)?$request-&gt;gallery_ids:[]);\r\n        }\r\n        if($request-&gt;gallery_data){\r\n            $this-&gt;fileRepository-&gt;saveBase64List($request-&gt;gallery_data, \'project\', $project-&gt;id, $request-&gt;user()-&gt;id);\r\n        }\r\n\r\n    }\r\n\r\n}\r\n\r\n</code></pre>\r\n<p>Ch&uacute;ng ta sẽ kh&ocirc;ng thấy được c&aacute;c phương thứ để hiển thị form, danh s&aacute;ch rồi c&aacute;c chức năng li&ecirc;n quan trong controller. Vậy l&agrave;m sao đề hiển thị? V&agrave; c&aacute;c phương thức đ&oacute; ở đ&acirc;u?</p>\r\n<p>Thực chất hầu hết c&aacute;c t&iacute;nh năng đề đ&atilde; được cung cấp trong c&aacute;c trait, khi ch&uacute;ng ta tạo c&aacute;c controller ch&uacute;ng ta chỉ cần khai b&aacute;o lại c&aacute;c thuộc t&iacute;nh rồi hệ thống sẽ tự xử l&yacute; c&aacute;c bước c&ograve;n lại.</p>\r\n<p>Vậy c&aacute;c trường hợp dasc589 biệt v&iacute; dụ như upload ảnh hay th&ecirc;m c&aacute;c th&ocirc;ng tin kh&aacute;c th&igrave; sao?</p>\r\n<p>Đ&acirc;y l&agrave; một quy tr&igrave;nh kh&eacute;p k&iacute;n. Mọi th&ocirc;ng tin cần được xử l&yacute; v&agrave; lưu trữ sẽ được quy định trong Validator của chức năng</p>\r\n<p>Một chức năng ho&agrave;n chỉnh bao gồm:</p>\r\n<p>Route (c&oacute; thể cả admin v&agrave; client)</p>\r\n<p>Controller (c&oacute; thể cả admin v&agrave; client)</p>\r\n<p>Model</p>\r\n<p>Repository (cung cấp c&aacute; phương thức truy vấn c&oacute; thể được t&aacute;i sử dụng nhiều lần ở mọi nơi)</p>\r\n<p>Validator (Quy định c&aacute;c th&ocirc;ng tin sẽ được tếp nhận v&agrave; c&aacute;ch thức x&aacute;c minh th&ocirc;ng tin)</p>\r\n<p>Mask (Mặt nạ - Đạ diện cho model trong view nhằm tr&aacute;nh sự can thiệp c&agrave;o cơ sở dữ liệu tại view)</p>\r\n<p>Tất cả sẽ được li&ecirc;n kết tại repository</p>\r\n<p>&nbsp;</p>\r\n<p>Với c&aacute;c trường hợp đạc biệt như upload ảnh hay l&agrave;m một việc g&igrave; đ&oacute; trước hoặc sau khi lưu trru74, cập nhập dử liệu ch&uacute;ng ta sẽ khai b&aacute;o c&aacute;c phương thức bắt sự kiện. V&iacute; dụ trong Project controller ở tr&ecirc;n ch&uacute;ng ta đ&atilde; khai b&aacute;o 2 phương thức <code class=\"language-php\" data-lang=\"php\">beforeSave</code> v&agrave; <code class=\"language-php\" data-lang=\"php\">afterSave</code> đ&acirc;y họi l&agrave; hướng sự kiện.</p>\r\n<h5><a id=\"crud-methods\"></a>Một số c&aacute;c sự kiện trong CRUD:</h5>\r\n<pre class=\"snippet\"><code class=\"language-php\" data-lang=\"php\">\r\n&lt;?php\r\n\r\n\r\nnamespace App\\Http\\Controllers\\Traits;\r\n\r\nuse Crazy\\Helpers\\Arr;\r\nuse Illuminate\\Http\\Request;\r\n// use Crazy\\Html\\HTML;\r\n\r\n\r\nuse Crazy\\Laravel\\Router;\r\n\r\n\r\n/**\r\n * c&aacute;c thuộc t&iacute;nh v&agrave; phương thức của form sẽ được triển trong ManagerController / hoặc admin controller\r\n *\r\n * @method void beforeSaveValidate( Request $request )\r\n * @method void beforeAjaxValidate( Request $request )\r\n * @method void beforeCreateValidate( Request $request )\r\n * @method void beforeAjaxCreateValidate( Request $request )\r\n * @method void beforeStoreValidate( Request $request )\r\n * @method void beforeUpdateValidate( Request $request )\r\n * @method void beforeAjaxUpdateValidate( Request $request )\r\n * @method void beforeValidate( Request $request )\r\n * @method void beforeAjaxValidate( Request $request )\r\n * @method void beforeHandleValidate( Request $request )\r\n * \r\n * @method void beforeSave( Request $request, Arr $data ) \r\n * @method void beforeAjaxSave( Request $request, Arr $data ) \r\n * @method void beforeCreate( Request $request, Arr $data ) \r\n * @method void beforeAjaxCreate( Request $request, Arr $data ) \r\n * @method void beforeStore( Request $request, Arr $data ) \r\n * @method void beforeUpdate( Request $request, Arr $data )\r\n * @method void beforeAjaxUpdate( Request $request, Arr $data )\r\n * @method void beforeMoveToTrash( Request $request, Arr $data ) \r\n * @method void beforeRestore( Request $request)\r\n * @method void beforeDelete( Request $request)\r\n * \r\n * @method void afterSave( Request $request, \\App\\Models\\Model $result )\r\n * @method void afterAjaxSave( Request $request, \\App\\Models\\Model $result )\r\n * @method void afterCreate( Request $request, \\App\\Models\\Model $result ) \r\n * @method void afterAjaxCreate( Request $request, \\App\\Models\\Model $result ) \r\n * @method void afterStore( Request $request, \\App\\Models\\Model $result ) \r\n * @method void afterUpdate( Request $request, \\App\\Models\\Model $result ) \r\n * @method void afterAjaxUpdate( Request $request, \\App\\Models\\Model $result ) \r\n * @method void afterMoveToTrash( Request $request, \\App\\Models\\Model $result ) \r\n * @method void afterRestore( Request $request, \\App\\Models\\Model $result )\r\n * @method void afterDelete( Request $request, \\App\\Models\\Model $result )\r\n * \r\n * @method mixed done( Request $request, Arr $data )\r\n */\r\ntrait CrudMethods\r\n{\r\n   # code\r\n}\r\n</code></pre>\r\n<p>&nbsp;</p>\r\n<h4><a id=\"client-controller\"></a>III. Client Controller</h4>\r\n<p>Đ&acirc;y l&agrave; controller g&ocirc;c của ph&iacute;a client, tất cả c&aacute;c controller module đều được kế thừa từ controller n&agrave;y v&agrave; thay đổi một số thuộc t&iacute;nh</p>\r\n<p>&nbsp;</p>\r\n<pre class=\"snippet\"><code class=\"language-php\" data-lang=\"php\">&lt;?php\r\nnamespace App\\Http\\Controllers\\Clients;\r\n\r\nuse App\\Engines\\Breadcrumb;\r\nuse App\\Engines\\CacheEngine;\r\nuse App\\Engines\\ViewManager;\r\nuse Illuminate\\Http\\Request;\r\nuse App\\Http\\Controllers\\Controller;\r\nuse Crazy\\Helpers\\Arr;\r\nuse Illuminate\\Contracts\\Support\\Htmlable;\r\nuse Mobile_Detect;\r\n\r\nclass ClientController extends Controller\r\n{\r\n\r\n    public static $isShare = false;\r\n    /**\r\n     * @var string $routeNamePrefix\r\n     */\r\n    protected $routeNamePrefix = \'clients.\';\r\n\r\n    /**\r\n     * @var string $viewFolder thu muc chua view\r\n     * khong nen thay doi lam gi\r\n     */\r\n    protected $viewFolder = \'clients\';\r\n    /**\r\n     * @var string dường d&atilde;n thư mục chứa form\r\n     */\r\n    protected $formDir = \'clients/forms\';\r\n\r\n    /**\r\n     * @var string $menuName\r\n     */\r\n    protected $menuName = \'client_menu\';\r\n    \r\n    protected $scope = \'clients\';\r\n\r\n    /**\r\n     * thời gian lưu chữ cache của view\r\n     *\r\n     * @var integer\r\n     */\r\n    public $cacheViewTime = 0;\r\n\r\n    /**\r\n     * thời gian lưu cach3 của data lấy từ db\r\n     *\r\n     * @var integer\r\n     */\r\n    public $cacheDataTime = 0;\r\n\r\n\r\n\r\n    /**\r\n     * path khi su dung view cache\r\n     *\r\n     * @var string\r\n     */\r\n    public $cacheViewPrefixPath = \'modules.\';\r\n\r\n    /**\r\n     * Breakcrump\r\n     * @var \\App\\Engines\\Breadcrumb $breadcrumb\r\n     */\r\n    protected $breadcrumb  = null;\r\n\r\n\r\n    /**\r\n     * chế độ view\r\n     *\r\n     * @var string $viewMode \r\n     */\r\n    public $viewMode = \'module\';\r\n\r\n    /**\r\n     * device\r\n     *\r\n     * @var \\Mobile_Detect\r\n     */\r\n    public $device = null;\r\n\r\n    protected function shareDefaultData($name = null, $value = null)\r\n    {\r\n        if(self::$isShare) return true;\r\n        ViewManager::share($name, $value);\r\n        self::$isShare = true;\r\n    }\r\n\r\n    public function init()\r\n    {\r\n        $this-&gt;cacheViewTime = system_setting(\'cache_view_time\', 0);\r\n        $this-&gt;cachDatawTime = system_setting(\'cache_data_time\', 0);\r\n        $this-&gt;viewFolder = \'clients.\'.theme_path();\r\n        $this-&gt;breadcrumb = app(Breadcrumb::class);\r\n        $this-&gt;device = app(Mobile_Detect::class);\r\n        $this-&gt;shareDefaultData([\r\n            \'breadcrumb\' =&gt; $this-&gt;breadcrumb ,\r\n            \'breakcrumb\' =&gt; $this-&gt;breadcrumb \r\n        ]);\r\n        parent::init();\r\n    }\r\n\r\n    \r\n    /**\r\n     * view\r\n     * @param string $bladePath\r\n     * @param array $data\r\n     * @return \\Illuminate\\View\\View\r\n     */\r\n    public function view(string $bladePath, array $data = [])\r\n    {\r\n        $bp = ($this-&gt;viewMode == \'module\'?\'modules.\':\'\') . $bladePath;\r\n        $viewdata = array_merge($data, [\r\n            \'module_slug\' =&gt; $this-&gt;module,\r\n            \'module_name\' =&gt; $this-&gt;moduleName,\r\n            \'route_name_prefix\' =&gt; $this-&gt;routeNamePrefix\r\n        ]);\r\n        return ViewManager::theme($bp, $viewdata);\r\n    }\r\n\r\n    /**\r\n     * giống view nhung trỏ sẵn v&agrave;o module\r\n     * @param string $bladeName\r\n     * @param array $data dữ liệu truyền v&agrave;o\r\n     */\r\n    public function viewModule($subModule, array $data = [])\r\n    {\r\n        return $this-&gt;view(($this-&gt;viewMode != \'module\'?\'modules.\':\'\').$this-&gt;moduleBlade . ($subModule? \'.\' . $subModule:\'\'), $data);\r\n    }\r\n\r\n\r\n    /**\r\n     * lấy th&ocirc;ng tin cche của view\r\n     *\r\n     * @param Request $request\r\n     * @param string $bladeName\r\n     * @param mixed $data\r\n     * @param string $key\r\n     * @param string $use_param\r\n     * @return mixed\r\n     */\r\n    public function cacheView(Request $request, $bladeName=null, $data = null, $key = null, $use_param = false)\r\n    {\r\n        // trường hợp kh&ocirc;ng cache \r\n        $id = ($user = $request-&gt;user()) ? $user-&gt;id : null;\r\n        if($id || $this-&gt;cacheViewTime &lt;= 0) {\r\n            if(is_array($data)) $viewData = $data;\r\n            elseif (is_callable($data) &amp;&amp; is_array($calledData = $data($request))) $viewData = $calledData;\r\n            else $viewData = [];\r\n            $html = $this-&gt;view($bladeName, $viewData);\r\n            return $html;\r\n        }\r\n        \r\n        if(!$key) $key = $bladeName;\r\n        $key = \'view-\'.$key;\r\n        if($use_param){\r\n            $params = $request-&gt;all();\r\n            ksort($params);\r\n        }else{\r\n            $params = [];\r\n        }\r\n        \r\n        \r\n        if(!($html = CacheEngine::get($key, $params)) ){\r\n            $viewData = [];\r\n            if(is_array($data)) $viewData = $data;\r\n            elseif (is_callable($data) &amp;&amp; is_array($calledData = $data($request))) {\r\n                $viewData = $calledData;\r\n            }\r\n            $html = $this-&gt;view($bladeName, $viewData);\r\n            if(!$id &amp;&amp; $this-&gt;cacheViewTime &gt; 0){\r\n                $html = $html-&gt;render();\r\n                CacheEngine::set($key, $html, $this-&gt;cacheViewTime, $params);\r\n            }\r\n        }\r\n        return $html;\r\n    }\r\n\r\n    /**\r\n     * lấy cache module hoặc tạo mới\r\n     *\r\n     * @param Request $request\r\n     * @param string $subModule\r\n     * @param array|callable $data\r\n     * @param string $key\r\n     * @param bool $use_param\r\n     * @return View\r\n     */\r\n    public function cacheViewModule(Request $request, $subModule, $data = null, $key = null, $use_param = false)\r\n    {\r\n        if(!$key) $key = $subModule;\r\n        $key = \'module-\'.$key;\r\n        return $this-&gt;cacheView($request,  $this-&gt;moduleBlade . \'.\' . $subModule, $data, $key,$use_param);\r\n    }\r\n\r\n\r\n\r\n    /**\r\n     * thao t&aacute;c với data trong csdl th&ocirc;ng qua h&agrave;m callback\r\n     *\r\n     * @param string $key\r\n     * @param callable $callback\r\n     * @return mixed\r\n     */\r\n    public function cacheData($key, $callback)\r\n    {\r\n        $k = (static::class) . \'-data-\' .$key;\r\n\r\n        if($this-&gt;cacheDataTime &lt;= 0 || !($data = CacheEngine::get($k)) ){\r\n            $d = null;\r\n            if (is_callable($callback) &amp;&amp; $calledData = $callback()) {\r\n                $d = $calledData;\r\n            }\r\n            if ($d instanceof Htmlable) {\r\n                $data = $d-&gt;toHtml();\r\n            }elseif (is_a($d, \\Illuminate\\View\\View::class)) {\r\n                $data = $d-&gt;render();\r\n            }\r\n            elseif (is_object($d) &amp;&amp; method_exists($d, \'render\')) {\r\n                $data = $d-&gt;render();\r\n            }\r\n            else{\r\n                $data = $d;\r\n            }\r\n            \r\n            if($this-&gt;cacheDataTime &gt; 0){\r\n                CacheEngine::set($k, $data, $this-&gt;cacheDataTime);\r\n            }\r\n        }\r\n        return $data;\r\n    }\r\n\r\n    /**\r\n     * cache theo url\r\n     *\r\n     * @param Request $request\r\n     * @param bool $withQueryString\r\n     * @param \\Closure $callback\r\n     * @return mixed\r\n     */\r\n    protected function cacheUrl(Request $request, $withQueryString = false, $callback = null)\r\n    {\r\n        $id = ($user = $request-&gt;user()) ? $user-&gt;id : null;\r\n        if($id || $this-&gt;cacheViewTime &lt;= 0) {\r\n            if (is_callable($callback)) {\r\n                return $callback($request);\r\n            }\r\n            return $callback;\r\n        }\r\n        $uri = $withQueryString ? $request-&gt;getRequestUri() : $request-&gt;getPathInfo();\r\n        $isMobileKey = $this-&gt;device-&gt;isMobile() ? \'mobile-\': \'desktop-\';\r\n        $urlKey = $isMobileKey.\'cache-url-\'.$uri;\r\n        if(!($data = CacheEngine::get($urlKey)) ){\r\n            $d = null;\r\n            if (is_callable($callback) &amp;&amp; $calledData = $callback($request)) {\r\n                $d = $calledData;\r\n            }\r\n            if ($d instanceof Htmlable) {\r\n                $data = $d-&gt;toHtml();\r\n            }elseif (is_a($d, \\Illuminate\\View\\View::class)) {\r\n                $data = $d-&gt;render();\r\n            }\r\n            elseif (is_object($d) &amp;&amp; method_exists($d, \'toArray\')) {\r\n                $data = $d-&gt;toArray();\r\n            }\r\n            elseif (is_object($d) &amp;&amp; method_exists($d, \'render\')) {\r\n                $data = $d-&gt;render();\r\n            }\r\n            else{\r\n                $data = $d;\r\n            }\r\n            \r\n            if(!$id &amp;&amp; $this-&gt;cacheViewTime &gt; 0){\r\n                CacheEngine::set($urlKey, $data, $this-&gt;cacheViewTime);\r\n            }\r\n        }\r\n        return $data;\r\n    }\r\n\r\n\r\n    /**\r\n     * lấy th&ocirc;ng tin cache của view\r\n     *\r\n     * @param Request $request\r\n     * @param string $key\r\n     * @param \\Closure $callback\r\n     * @return mixed\r\n     */\r\n    public function cache(Request $request, $key, $callback = null)\r\n    {\r\n        $id = ($user = $request-&gt;user()) ? $user-&gt;id : null;\r\n        if($id || $this-&gt;cacheViewTime &lt;= 0) {\r\n            if (is_callable($callback)) {\r\n                return $callback($request);\r\n            }\r\n            return $callback;\r\n        }\r\n        $urlKey = \'cache-controller-\'.$key.\'-\'.str_slug($request-&gt;getRequestUri());\r\n        \r\n        if(!($data = CacheEngine::get($urlKey))){\r\n            $d = null;\r\n            if (is_callable($callback) &amp;&amp; $calledData = $callback($request)) {\r\n                $d = $calledData;\r\n            }\r\n  \r\n            if ($d instanceof Htmlable) {\r\n                $data = $d-&gt;toHtml();\r\n            }elseif (is_a($d, \\Illuminate\\View\\View::class)) {\r\n                $data = $d-&gt;render();\r\n            }\r\n            elseif (is_object($d) &amp;&amp; method_exists($d, \'toArray\')) {\r\n                $data = $d-&gt;toArray();\r\n            }\r\n            elseif (is_object($d) &amp;&amp; method_exists($d, \'render\')) {\r\n                $data = $d-&gt;render();\r\n            }\r\n            else{\r\n                $data = $d;\r\n            }\r\n            if(!$id &amp;&amp; $this-&gt;cacheViewTime &gt; 0){\r\n                CacheEngine::set($urlKey, $data, $this-&gt;cacheViewTime);\r\n            }\r\n        }\r\n        return $data;\r\n    }\r\n\r\n\r\n\r\n\r\n\r\n\r\n    \r\n    /**\r\n     * lấy cache task của repository\r\n     *\r\n     * @param Request $request\r\n     * @param string $key\r\n     * @param \\App\\Repositories\\Base\\BaseRepository $repository\r\n     * @return \\App\\Repositories\\Base\\BaseRepository|\\App\\Repositories\\Base\\CacheTask\r\n     */\r\n    public function cacheTask(Request $request, $key, $repository = null)\r\n    {\r\n        if(!$repository) $repository = $this-&gt;repository;\r\n        return $repository-&gt;cache($key, $this-&gt;cacheDataTime, $request-&gt;all());\r\n    }\r\n\r\n\r\n}\r\n\r\n?&gt;\r\n</code></pre>\r\n<p>Ở ph&iacute;a client hầu như rất &iacute;t xử l&yacute; CRUD hầu hết l&agrave; hiển thị dữ liệu. Quan trọng nhất l&agrave; trải nghiệm của người d&ugrave;ng v&agrave; mức độ chịu dựng requuest của hệ thống. do đ&oacute; phải ch&uacute; trọng về giao diện v&agrave; tối ưu h&oacute;a c&aacute;c query. Việc chưa ho&agrave;n th&agrave;nh api cho c&aacute;c giao diện frontend đang được tạm khắc phục bằng c&aacute;ch d&ugrave;ng cache. Hy vọng thời gian tới c&oacute; thể h&agrave;n th&agrave;nh.</p>\r\n<p>&nbsp;</p>\r\n<h5><a id=\"product-controller\"></a>Product Controller</h5>\r\n<p>Mẫu controller ph&iacute;a client</p>\r\n<pre class=\"snippet\"><code class=\"language-php\" data-lang=\"php\">\r\n&lt;?php\r\n\r\nnamespace App\\Http\\Controllers\\Clients;\r\n\r\nuse App\\Repositories\\Products\\CategoryRepository;\r\nuse Illuminate\\Http\\Request;\r\nuse Crazy\\Helpers\\Arr;\r\n\r\nuse App\\Repositories\\Products\\ProductRepository;\r\nuse App\\Repositories\\Products\\ReviewRepository;\r\n\r\nclass ProductController extends ClientController\r\n{\r\n    protected $module = \'products\';\r\n\r\n    protected $moduleName = \'Product\';\r\n\r\n    protected $flashMode = true;\r\n\r\n    protected $perPage = 10;\r\n    \r\n\r\n    /**\r\n     * category\r\n     *\r\n     * @var CategoryRepository\r\n     */\r\n    public $categoryRepository;\r\n\r\n\r\n    /**\r\n     * reviwws\r\n     * @var ReviewRepository\r\n     */\r\n    public $reviewRepository;\r\n\r\n    /**\r\n     * Create a new controller instance.\r\n     *\r\n     * @return void\r\n     */\r\n    public function __construct(ProductRepository $ProductRepository, CategoryRepository $categoryRepository, ReviewRepository $reviewRepository)\r\n    {\r\n        $this-&gt;repository = $ProductRepository;\r\n        $this-&gt;categoryRepository = $categoryRepository;\r\n        // theme dieu kien\r\n        $this-&gt;repository-&gt;mode(\'mask\');\r\n        $this-&gt;categoryRepository-&gt;mode(\'mask\')-&gt;addDefaultParam(\'deleted\', \'deleted\', 0);\r\n        $this-&gt;reviewRepository = $reviewRepository-&gt;setActor(\'client\');\r\n        $this-&gt;init();\r\n\r\n        \r\n        $this-&gt;perPage = ($display = get_display_setting()) ? $display-&gt;product_per_page(10) : 10;\r\n    }\r\n\r\n    /**\r\n     * xem chi tiết sản phẩm\r\n     *\r\n     * @param Request $request\r\n     * @return View\r\n     */\r\n    public function viewProductDetail(Request $request)\r\n    {\r\n        // trả về cache url\r\n        return $this-&gt;cacheUrl($request, false, function() use($request){\r\n            // key trut cap\r\n            $slug = $request-&gt;route(\'slug\');\r\n            $key = \'view-product-detail-\';\r\n            if($slug){\r\n                $key .= \'slug-\'.$slug;\r\n                $args = [\'slug\' =&gt; $slug];\r\n            }elseif($request-&gt;id){\r\n                $key .= \'id-\'.$request-&gt;id;\r\n                $args = [\'id\' =&gt; $request-&gt;id];\r\n            }else{\r\n                return $this-&gt;view(\'errors.404\');\r\n            }\r\n            \r\n            if($product = $this-&gt;cacheTask($request, $key)-&gt;getProductDetail($args)){\r\n                $product-&gt;applyMeta();\r\n                set_active_model(\'product\', $product);\r\n                $this-&gt;breadcrumb-&gt;addProduct($product);\r\n                $page_title = $product-&gt;name;\r\n                $related_products = $this-&gt;cacheTask($request,$key.\'--related\')\r\n                                    -&gt;where(\'id\', \'!=\', $product-&gt;id)\r\n                                    -&gt;getData([\r\n                                        \'category_id\' =&gt; $product-&gt;category_id,\r\n                                        \'@order_by\' =&gt; \'rand()\',\r\n                                        \'@limit\' =&gt; 8\r\n                                    ]);\r\n                $data = compact(\'page_title\', \'product\', \'related_products\');\r\n                return $this-&gt;view(\'products.detail\', $data);\r\n            }\r\n            return $this-&gt;view(\'errors.404\');\r\n        });\r\n    }\r\n\r\n    /**\r\n     * lấy dữ liệu sản phẩm v&agrave; đổ về json\r\n     *\r\n     * @param Request $request\r\n     * @return void\r\n     */\r\n    public function getProductJsonData(Request $request)\r\n    {\r\n        extract($this-&gt;apiDefaultData);\r\n\r\n        $product = $this-&gt;cacheUrl($request, false, function() use($request){\r\n            // key truy cap\r\n            $slug = $request-&gt;route(\'slug\');\r\n            $key = \'view-product-detail-\';\r\n            if($slug){\r\n                $key .= \'slug-\'.$slug;\r\n                $args = [\'slug\' =&gt; $slug];\r\n            }elseif($request-&gt;id){\r\n                $key .= \'id-\'.$request-&gt;id;\r\n                $args = [\'id\' =&gt; $request-&gt;id];\r\n            }else{\r\n                return [\'status\' =&gt; false, \'errors\' =&gt; [\'404\' =&gt; \"Kh&ocirc;ng t&igrave;m thấy\"]];\r\n            }\r\n            \r\n            if($product = $this-&gt;cacheTask($request, $key)-&gt;getProductDetailData($args)){\r\n                $product-&gt;applyMeta();\r\n                $product-&gt;variants = $product-&gt;getVariantAttributes();\r\n                $product-&gt;options = $product-&gt;getOrderAttributes();\r\n                $product-&gt;url = $product-&gt;getViewUrl();\r\n                return [\'status\' =&gt; true, \'data\' =&gt; $product];\r\n            }\r\n            return [\'status\' =&gt; false, \'errors\' =&gt; [\'404\' =&gt; \"Kh&ocirc;ng t&igrave;m thấy\"]];\r\n        });\r\n        extract($product);\r\n        return $this-&gt;json(compact($this-&gt;apiSystemVars));\r\n    }\r\n\r\n    /**\r\n     * lấy danh s&aacute;ch hoặc t&igrave;m kiếm sản phẩm\r\n     *\r\n     * @param Request $request\r\n     * @return \\Illuminate\\View\\View\r\n     */\r\n    public function viewProducts(Request $request)\r\n    {\r\n        // cache view theo url\r\n        return $this-&gt;cacheUrl($request, true, function() use($request){\r\n            // yu khoa tim kiem\r\n            $keyword = strlen($request-&gt;search)?$request-&gt;search:(\r\n                strlen($request-&gt;s)?$request-&gt;s:(\r\n                    strlen($request-&gt;keyword)?$request-&gt;keyword:(\r\n                        strlen($request-&gt;keywords)?$request-&gt;keywords:(\r\n                            strlen($request-&gt;tim)?$request-&gt;tim:(\r\n                                $request-&gt;timkiem\r\n                            )\r\n                        )\r\n                    )\r\n                )\r\n            );\r\n            $sortby = $request-&gt;sortby??$request-&gt;orderBy;\r\n            $page_title = \"Sản phẩm\";\r\n            $categoryRoutekeys = [];\r\n            $levelParams = [];\r\n            $idMode = false;\r\n            $args = [];\r\n            $category = null;\r\n            $category_map = [0];\r\n            $key = \'product-list-\';\r\n            $ck = $key;\r\n            // trường hợp 1 level (chỉ d&ugrave;ng slug)\r\n            if($slug = $request-&gt;route(\'slug\')) $categoryRoutekeys[] = $slug;\r\n            // trường hop74 chỉ c&oacute; 2 level (parent / child)\r\n            elseif($child = $request-&gt;route(\'child\')) $categoryRoutekeys = [$request-&gt;route(\'parent\'), $child];\r\n            // trường hợp c&oacute; đến 4 level\r\n            elseif($fourth = $request-&gt;route(\'fourth\')) $categoryRoutekeys = [$request-&gt;route(\'first\'), $request-&gt;route(\'second\'), $request-&gt;route(\'third\'), $fourth];\r\n            // trường hợp chỉ c&oacute; 3 level \r\n            elseif($third = $request-&gt;route(\'third\')) $categoryRoutekeys = [$request-&gt;route(\'first\'), $request-&gt;route(\'second\'), $third];\r\n            // nếu chỉ d&ugrave;ng id\r\n            elseif($id = $request-&gt;cid??($request-&gt;category_id??($request-&gt;id??($request-&gt;category??$request-&gt;cate)))) {$levelParams[] = [\'id\' =&gt; $id]; $idMode = true;}\r\n            // nếu c&oacute; slug trong route th&igrave; foreach qua để lấy slug\r\n            if($categoryRoutekeys){\r\n                foreach ($categoryRoutekeys as $slug) {\r\n                    $levelParams[] = [\'slug\' =&gt; $slug];\r\n                }\r\n            }\r\n            // nếu c&oacute; danh mục \r\n            if($levelParams){\r\n                $key = \'product-category-\';\r\n                \r\n                $t = count($levelParams);\r\n                $lv = 0;\r\n                $ck = $key;\r\n                \r\n                for ($i=0; $i &lt; $t; $i++) { \r\n                    $params = $levelParams[$i];\r\n                    // nếu c&oacute; danh mục được set ở v&ograve;ng lạp trước th&igrave; th&ecirc;m n&oacute; v&agrave;o danh mục được k&iacute;ch hoạt\r\n                    // v&agrave; th&ecirc;m tham số id của n&oacute; l&agrave;m parent_id để truy vấn danh mục hiện tại\r\n                    // .. c&oacute; thể d&ugrave;ng with được nhưng vẫn mất ngần ấy query th&ocirc;i\r\n                    \r\n                    // tạo key để lấy cache nếu c&oacute;\r\n                    $k = $key . \'-\'. md5(json_encode($params));\r\n                    if($cate = $this-&gt;getCategory($request, $k, $params)){\r\n                        $category_map[] = $cate-&gt;id;\r\n                        $category = $cate;\r\n                        set_active_model(\'product_category\', $category);$page_title = $category-&gt;name;\r\n\r\n                        $params[\'parent_id\'] = $category-&gt;id;\r\n                        $ck = $k;\r\n                        $lv++;\r\n                    }else {\r\n                        // nếu ko c&oacute; danh mục tại v&ograve;ng lặp hiện tại th&igrave; tho&aacute;t khỏi v&ograve;ng lặp ngay v&agrave; lu&ocirc;n\r\n                        break;\r\n                    }\r\n                }\r\n                // dd(get_active_model(\'product_category\'));\r\n                // dd($category);\r\n                // nếu level bằng tổng số danh mục\r\n                if($lv==$t){\r\n                    if($idMode) $category_map = array_merge([0],$category-&gt;getMap()); \r\n                    $args = [\r\n                        \'@category\' =&gt; $category-&gt;id,\r\n                        \'@attribute_category_map\' =&gt; $category_map\r\n                    ];\r\n                }\r\n                // trường hợp ko c&oacute; danh mục hiện tại nhưng c&oacute; danh mục cha\r\n                elseif($category){\r\n                    // tra về view empty lu&ocirc;n\r\n                    $data = compact(\'category\', \'page_title\');\r\n                    return $this-&gt;viewModule(\'empty\', $data);\r\n                }\r\n                // nếu ko c&oacute; danh mục n&agrave;o\r\n                else{\r\n                    return $this-&gt;view(\'errors.404\');\r\n                }\r\n\r\n            }else{\r\n                $args = [\r\n                    \'@attribute_category_map\' =&gt; $category_map\r\n                ];\r\n            }\r\n            $products = $this-&gt;cacheTask($request, $ck)-&gt;paginate($this-&gt;perPage)-&gt;search($request, $keyword, $args);\r\n            // return($results[0]-&gt;category);\r\n            if($category){\r\n                $this-&gt;breadcrumb-&gt;addCategory($category);\r\n            }else{\r\n                $this-&gt;breadcrumb-&gt;add(\'Sản phẩm\');\r\n            }\r\n            $data = compact(\'products\', \'category\', \'page_title\', \'keyword\', \'idMode\', \'sortby\');\r\n            return $this-&gt;viewModule(\'list\', $data);\r\n        });\r\n\r\n    }\r\n\r\n\r\n\r\n    /**\r\n     * kiểm tra gi&aacute; sản phẩm theo thuộc t&iacute;nh nếu c&oacute;\r\n     *\r\n     * @param Request $request\r\n     * @return void\r\n     */\r\n    public function checkPrice(Request $request)\r\n    {\r\n        // return $request-&gt;all();\r\n        extract($this-&gt;apiDefaultData);\r\n        if($productData = $this-&gt;repository-&gt;checkPrice($request-&gt;product_id, is_array($request-&gt;attrs)?$request-&gt;attrs:[])){\r\n            $status = true;\r\n            $price = $productData[\'price\'];\r\n            $data = [\r\n                \'product\' =&gt; $productData[\'product\'],\r\n                \'price\' =&gt; $price,\r\n                \'price_format\' =&gt; get_currency_format($price)\r\n            ];\r\n        }\r\n        return $this-&gt;json(compact($this-&gt;apiSystemVars));\r\n    }\r\n\r\n\r\n\r\n    /**\r\n     * lay danh muc\r\n     *\r\n     * @param Request $request\r\n     * @param string $key\r\n     * @param array $args\r\n     * @return \\App\\Models\\Category\r\n     */\r\n    public function getCategory(Request $request, $key, $args = [])\r\n    {\r\n        $category = $this-&gt;cacheTask($request, $key, $this-&gt;categoryRepository)-&gt;mode(\'mask\')-&gt;detail($args);\r\n        if($category){\r\n            set_web_data(\'model_data.product_category.\'.$category-&gt;id, $category);\r\n        }\r\n        return $category;\r\n    }\r\n\r\n    /**\r\n     * lấy danh s&aacute;ch sản phẩm\r\n     *\r\n     * @param Request $request\r\n     * @param string $key\r\n     * @param array $args\r\n     * @return void\r\n     */\r\n    public function getProducts(Request $request, $key, $args = [])\r\n    {\r\n        return $this-&gt;cacheTask($request, $key, $this-&gt;repository)-&gt;search($request, $args);\r\n    }\r\n\r\n\r\n\r\n\r\n    /**\r\n     * gửi đ&aacute;nh gi&aacute; gi&aacute; sản phẩm\r\n     *\r\n     * @param Request $request\r\n     * @return void\r\n     */\r\n    public function makeReview(Request $request)\r\n    {\r\n        $validator = $this-&gt;reviewRepository-&gt;validator($request);\r\n        $type = \'danger\';\r\n        extract($this-&gt;createReview($request));\r\n        if($status){\r\n            $type = \'success\';\r\n        }elseif(!$errors){\r\n            $type = \'warning\';\r\n        }\r\n        $redirectData = [\r\n            \'type\' =&gt; $type,\r\n            \'message\' =&gt; $message,\r\n            \'link\' =&gt; $this-&gt;repository-&gt;findBy(\'id\', $request-&gt;product_id)-&gt;getViewUrl(),\r\n            \'text\' =&gt; \'Quay lại trang sản phẩm\'\r\n        ];\r\n        if($errors){\r\n            $redirectData[\'title\'] = $message;\r\n            $redirectData[\'message\'] = implode(\'<br />\', array_values($errors));\r\n        }\r\n        return redirect()-&gt;route(\'client.alert\')-&gt;with($redirectData);\r\n    }\r\n\r\n    /**\r\n     * gui danh gia bang ajax\r\n     *\r\n     * @param Request $request\r\n     * @return void\r\n     */\r\n    public function ajaxMakeReview(Request $request)\r\n    {\r\n        return $this-&gt;json($this-&gt;createReview($request));\r\n    }\r\n\r\n    protected function createReview(Request $request){\r\n        extract($this-&gt;apiDefaultData);\r\n        $validator = $this-&gt;reviewRepository-&gt;validator($request);\r\n        $status = false;\r\n        $errors = [];\r\n        $data = null;\r\n        if(!$validator){\r\n            $message = \'Lỗi kh&ocirc;ng x&aacute;c định\';\r\n        }elseif(!$validator-&gt;success()){\r\n            $message = \'Thiếu th&ocirc;ng tin\';\r\n            $errors = $validator-&gt;errors();\r\n        }elseif(!($review = $this-&gt;reviewRepository-&gt;create($validator-&gt;inputs()))){\r\n            $message = \'Lỗi hẽ thống! Vui l&ograve;ng thử lại sau gi&acirc;y l&aacute;t\';\r\n        }else{\r\n            $message = \'Gửi đ&aacute;nh gi&aacute; th&agrave;nh c&ocirc;ng!\';\r\n            $data = $review;\r\n            $status = true;\r\n        }\r\n        return compact($this-&gt;apiSystemVars);\r\n    }\r\n\r\n}\r\n\r\n</code></pre>', NULL, 0, 'public', 0, '2020-07-28 15:49:01', '2020-07-28 21:30:30'),
(31, 1, 5, 0, 12, ' 12,', 'post', 'text', 'Giới thiệu', 'gioi-thieu', NULL, NULL, '<p>Web 1-0-2 l&agrave; hệ thống cho ph&eacute;p t&ugrave;y biến giao diện theo &yacute; th&iacute;ch. với việc hệ thống sử dụng laravel n&ecirc;n chủ yếu sẽ d&ugrave;ng blade view thay v&igrave; php thuần.</p>\r\n<h4><a id=\"structure\"></a>1. Cấu tr&uacute;c thư mục</h4>\r\n<p>Cấu tr&uacute;c một giao diện ti&ecirc;u chuẩn gồm c&aacute;c th&agrave;nh phần như: sau:</p>\r\n<pre class=\"snippet\"><code class=\"language-html\" data-lang=\"css\">[theme folder]/\r\n├── assets/                      // chứa c&aacute;c t&agrave;i nguy&ecirc;n như ảnh, css, jsm ... \r\n│   ├── css/                     // kh&ocirc;ng bắt buộc\r\n│   ├── images/                  // kh&ocirc;ng bắt buộc\r\n│   ├── js/                      // kh&ocirc;ng bắt buộc\r\n│   ├── *..                      // kh&ocirc;ng bắt buộc\r\n├── componnts/                   // Chứa c&aacute;c components của giao diện\r\n│   ├── [component]/             // Mỗi component sẽ được chứa trong một thư mục\r\n│   │   ├── config.json          // file cấu h&igrave;nh gồm c&aacute;c th&ocirc;ng tin về component v&agrave; c&aacute;c input để cập nhật dữ liệu\r\n│   │   ├── view.blade.php       // file view sẽ nhận dữ liệu th&ocirc;ng qua một biến $data (object) dược truyền v&agrave;o\r\n│   │   ├── [subcompnent]/       // c&oacute; thể nh&oacute;m c&aacute;c component c&oacute; c&ugrave;ng vị tr&iacute; hiển thị b&ecirc;n trong một folder hoặc một component cha\r\n│   │   │   ├── config.json      // file cấu h&igrave;nh gồm c&aacute;c th&ocirc;ng tin về component v&agrave; c&aacute;c input để cập nhật dữ liệu\r\n│   │   │   ├── view.blade.php   // file view sẽ nhận dữ liệu th&ocirc;ng qua một biến $data (object) dược truyền v&agrave;o\r\n├── config/                      // Thư mục chứa c&aacute;c file json cấu h&igrave;nh giao diện\r\n│   ├── options/                 // Thư mục chứa c&aacute;c filw json l&agrave; c&aacute;c group của file options.json\r\n│   ├── areas.json               // file chứa vị tr&iacute; c&aacute;c v&ugrave;ng c&oacute; thể nh&uacute;ng component hoặc embed\r\n│   ├── menus.json               // file chứa vị tr&iacute; v&agrave; title của c&aacute;c menu\r\n│   ├── options.json             // file th&ocirc;ng tin cấu h&igrave;nh theo c&aacute;c group hoặc th&ocirc;ng tin file group trong thư mục options\r\n├── helpers/                     // thư mục chứa c&aacute;c file php chứa c&aacute;c function hỗ trợ cho giao diện m&agrave; hệ thống kh&ocirc;ng c&oacute;\r\n│   ├── [filename].php           // c&oacute; thễ c&oacute; một hoặc nhiều file hoặc kh&ocirc;ng file php n&agrave;o với bất kỳ t&ecirc;n g&igrave;\r\n├── views/                       // C&aacute;c view của giao diện\r\n│   ├── layouts/                 // C&aacute;c khung (vỏ) để hiển thị trang web\r\n│   ├── modules/                 // view chứa c&aacute;c module theo từng chức năng\r\n│   │   ├── alert/               // module hiển thị th&ocirc;ng b&aacute;o\r\n│   │   │   ├── message.blade.php\r\n│   │   ├── errors/              // module th&ocirc;ng b&aacute;o lỗi\r\n│   │   │   ├── 404.blade.php    // file view lỗi 404\r\n│   │   ├── home/                // module home\r\n│   │   │   ├── index.blade.php  // file view\r\n│   │   ├── pages/               // module hiển thị c&aacute;c trang\r\n│   │   │   ├── detail.blade.php // file view chi tiết (single page)\r\n│   │   │   ├── empty.blade.php  // file view th&ocirc;ng b&aacute;o danh s&aacute;ch trống\r\n│   │   │   ├── list.blade.php   // file view danh s&aacute;ch trang con (children pages)\r\n│   │   ├── posts/               // module hiển thị c&aacute;c b&agrave;i viết\r\n│   │   │   ├── detail.blade.php // file view chi tiết (single post)\r\n│   │   │   ├── empty.blade.php  // file view th&ocirc;ng b&aacute;o danh s&aacute;ch trống\r\n│   │   │   ├── list.blade.php   // file view danh s&aacute;ch b&agrave;i viết\r\n│   │   ├── search/              // module hiển thị kết quả t&igrave;m kiếm\r\n│   │   │   ├── results.blade.php// file view danh s&aacute;ch kết quả t&igrave;m kiếm\r\n│   │   ├── [module]/            // module\r\n│   │   │   ├── *.blade.php      // file view\r\n│   ├── templates/               // Chừa c&aacute;c th&agrave;nh phần sử dụng chung tr&ecirc;n giao diện\r\n</code></pre>\r\n<p>&nbsp;</p>\r\n<h4><a id=\"variable\"></a>2. Biến hệ thống</h4>\r\n<p>C&aacute;c biến được chia sẻ cho tất cả c&aacute;c view của giao diện bao g&ograve;m:&nbsp;</p>\r\n<h5><a id=\"options\"></a><code>$options&nbsp;</code></h5>\r\n<div>&nbsp;</div>\r\n<pre class=\"language-php\"><code>(object) $options // biến chứa tất cả c&aacute;c group thiết lập;\r\n\r\n// v&agrave;i v&iacute; dụ cụ thể\r\n$options-&gt;settings; // gọi đến đối tượng / option settings thiết lập của hệ thống bao gồm c&aacute;c group sau:\r\n$options-&gt;settings-&gt;siteinfo // hay $siteinfo // thiết lập th&ocirc;ng tin trang web như t&ecirc;n site, ti&ecirc;u để, logo, vv\r\n// v&iacute; dụ: lấy th&ocirc;ng tin logo truy cập $siteinfo-&gt;logo; Hoặc $siteinfo-&gt;logo(\"Gi&aacute; trị mặc định\");\r\n$options-&gt;theme; // Tất cả c&aacute;c thiết lập của theme hiện tại\r\n// v&iacute; dụ bạn muốn lấy th&ocirc;ng tin thiết lập trang chủ.\r\n$options-&gt;theme-&gt;home;\r\n// Nếu muốn lấy một gi&aacute; trị thuộc t&iacute;nh được thiết lập trong mục home ta c&oacute; thể lấy bằng c&aacute;ch truy cập v&agrave;o thuộc t&iacute;nh của object\r\n$options-&gt;theme-&gt;home-&gt;show_sidebar;\r\n// hoặc ta c&oacute; thể g&aacute;n gi&aacute; trị để gọi cho nhanh nếu cần lấy nhiều gi&aacute; trị\r\n$home = $options-&gt;theme-&gt;home; // g&aacute;n lu&ocirc;n c&aacute;c thiết lập trang chủ cho biến $home\r\n// từ d&acirc;y ta c&oacute; thẩy lấy gi&aacute; trị như aau:\r\n$home-&gt;show_sidebar;\r\n// Hoặc lấy về mảng tất cả c&aacute;c key value\r\n$homeArr = $home-&gt;all();\r\n// Gi&aacute; trị trả về l&agrave; một mảng c&aacute;c th&ocirc;ng tin m&agrave; bạn đ&atilde; quy định trong thiết lập\r\n</code></pre>\r\n<p>&nbsp;</p>\r\n<h5><a id=\"siteinfo\"></a>$siteinfo</h5>\r\n<pre class=\"language-php\"><code>object $siteinfo; // biến th&ocirc;ng tin site được lấy ra từ option settings\r\n\r\nstring $siteinfo-&gt;site_name; // T&ecirc;n website\r\nstring $siteinfo-&gt;slogan; // Khẩu hiệu\r\nstring $siteinfo-&gt;logo // logo\r\nstring $siteinfo-&gt;mobile_logo; // logo\r\nstring $siteinfo-&gt;footer_logo; // logo\r\nstring $siteinfo-&gt;title; // Ti&ecirc;u đề website\r\nstring $siteinfo-&gt;keywords; // Từ kh&oacute;a t&igrave;m kiếm\r\nstring $siteinfo-&gt;description; // M&ocirc; tả website\r\nstring $siteinfo-&gt;web_image; // Ảnh mặc định khi chia sẻ\r\nstring $siteinfo-&gt;favicon; // Biểu tượng\r\n// một số th&ocirc;ng tin kh&aacute;c\r\n</code></pre>\r\n<h5><a id=\"html\"></a>$html</h5>\r\n<p>biến hệ thống cung cập c&aacute;c thuộc t&iacute;nh v&agrave; phương thức để hiển thị giao diện như form, component hay menu</p>\r\n<pre class=\"language-php\"><code>$html-&gt;[area slug] // v&ugrave;ng n&agrave;o đ&oacute;\r\n// v&iacute; dụ\r\n$html-&gt;header; // gọi đến v&ugrave;ng header\r\n// trong header sẽ c&oacute; components, embeds\r\n// v&iacute; dụ show ra to&agrave;n bộ components trong phần header\r\n// trong blade view ta c&oacute; thể gọi\r\n{!! $html-&gt;header-&gt;components !!}\r\n// tương tự với embed (m&atilde; nh&uacute;ng)\r\n{!! $html-&gt;header-&gt;embeds !!}\r\n\r\n</code></pre>\r\n<p>&nbsp;</p>\r\n<h5><a id=\"helper\"></a>$helper</h5>\r\n<p>Biến cho ph&eacute;p bạn gọi c&aacute;c h&agrave;m lấy dữ liệu th&ocirc;ng qua phương thức của n&oacute;</p>\r\n<h5><a id=\"othervars\"></a>Một v&agrave;i biến kh&aacute;c</h5>\r\n<pre class=\"language-php\"><code>(object) $ecommerce // th&ocirc;ng tin thiết lập cửa h&agrave;ng\r\n(object) $payment // thiết lập thanh to&aacute;n\r\n(object) $request // biến chứa th&ocirc;ng tin request của laravel\r\n(string) $current_url // Url hiện tại</code></pre>\r\n<p>&nbsp;</p>', '0011-5f201287f3d1c.png', 0, 'public', 0, '2020-07-28 22:56:56', '2020-10-29 19:29:24');
INSERT INTO `posts` (`id`, `author_id`, `dynamic_id`, `parent_id`, `category_id`, `category_map`, `type`, `content_type`, `title`, `slug`, `keywords`, `description`, `content`, `feature_image`, `views`, `privacy`, `deleted`, `created_at`, `updated_at`) VALUES
(32, 1, 5, 0, 17, ' 17,', 'post', 'gallery', 'Lazio', 'lazio', NULL, 'Giao diện trang bán hàng cho hệ thống web102', '<p>Đ&acirc;y l&agrave; giao diện ban đầu của hệ thống web 102 cho lĩnh vực thương mại diện tử</p>\r\n<p>link demo: <a href=\"http://tmdt.vcc.vn/\">http://tmdt.vcc.vn/</a></p>\r\n<p>link download: <a href=\"https://drive.google.com/file/d/1bdrLU-vvn5ZLArAOg0bKVf_pD6ivdFL1/view?usp=sharing\">https://drive.google.com/file/d/1bdrLU-vvn5ZLArAOg0bKVf_pD6ivdFL1/view?usp=sharing</a></p>\r\n<figure><img src=\"/static/files/2020/08/08/02-5f2ec7db2ab47.png\" alt=\"02.png\" />\r\n<figcaption>Trang chủ</figcaption>\r\n</figure>\r\n<figure><img src=\"/static/files/2020/08/08/03-5f2ec7db23dea.png\" alt=\"03.png\" />\r\n<figcaption>Danh s&aacute;ch sản phẩm</figcaption>\r\n</figure>\r\n<p>&nbsp;</p>\r\n<figure><img src=\"/static/files/2020/08/08/06-5f2ec7dd47b44.png\" alt=\"06.png\" />\r\n<figcaption>Chi tiết sản phẩm</figcaption>\r\n</figure>\r\n<figure><img src=\"/static/files/2020/08/08/07-5f2ec7dd4a422.png\" alt=\"07.png\" />\r\n<figcaption>Trang Giỏ h&agrave;ng</figcaption>\r\n</figure>\r\n<p>&nbsp;</p>\r\n<figure><img src=\"/static/files/2020/08/08/08-5f2ec7ddc7b65.png\" alt=\"08.png\" />\r\n<figcaption>Trang thanh to&aacute;n</figcaption>\r\n</figure>\r\n<figure></figure>\r\n<figure><img src=\"/static/files/2020/08/08/10-5f2ec7de70ea8.png\" alt=\"10.png\" />\r\n<figcaption>Trang quản l&yacute; đơn h&agrave;ng</figcaption>\r\n</figure>\r\n<p>&nbsp;</p>\r\n<figure><img src=\"/static/files/2020/08/08/11-5f2ec7de7f49b.png\" alt=\"11.png\" />\r\n<figcaption>Chi tiết đơn h&agrave;ng</figcaption>\r\n</figure>', '01-5f2ec637678a8.png', 0, 'public', 0, '2020-08-09 02:35:19', '2020-08-09 02:50:08'),
(33, 1, 2, 0, 0, NULL, 'post', 'text', 'WordPress 1-0-2', 'wordpress-1-0-2', NULL, 'WordPress 1-0-2 0 - Tạo website chuẩn SEO nhanh chóng - Tiết kiệm chi phí', '<p><strong>Ng&agrave;y nay c&aacute;c website chạy tr&ecirc;n nền tảng wordpress được kh&aacute;ch h&agrave;ng tin tưởng sử dụng bởi hệ quản trị dễ sử dụng. Th&ecirc;m v&agrave;o đ&oacute; bố cục code web wordpress ho&agrave;n to&agrave;n th&acirc;n thiện với c&ocirc;ng cụ t&igrave;m kiếm google. Dễ d&agrave;ng ph&aacute;t triển SEO top website.</strong></p>\r\n<p><strong>Với nhu cầu sử dụng cao, quy tr&igrave;nh tạo ra website wordpress được tối ưu dẫn đến chi ph&iacute; thiết kế thấp. Tại Web 1-0-2 ch&uacute;ng t&ocirc;i vừa mới cung cấp một dịch vụ ho&agrave;n to&agrave;n mới cho ph&eacute;p bạn tạo ra mọt trang web với wordpress nhanh ch&oacute;ng chỉ sau v&agrave;i c&aacute;i click chuột. V&agrave; đăc biệt bạn kh&ocirc;ng cần phải lo về vấn quản l&yacute; hosting hay cấu h&igrave;nh lằng nhằng. Tất cả những g&igrave; bạn cần l&agrave;m đ&oacute; l&agrave; click v&agrave; click (&agrave; cả thanh to&aacute;n nữa) phần c&ograve;n lại để ch&uacute;ng t&ocirc;i lo !</strong></p>\r\n<h3><span id=\"Khi_nao_ban_nen_su_dung_code_thuan_de_thiet_ke_web\"></span><strong>Khi n&agrave;o bạn n&ecirc;n sử WordPress để thiết kế web</strong></h3>\r\n<p>Việc sử dụng code thuần l&agrave; ho&agrave;n to&agrave;n ph&ugrave; hợp cho những hệ thống website lớn ( lớn rất lớn bạn nh&eacute; ). Bởi ưu điểm của việc thiết kế web n&agrave;y l&agrave; khả năng mở rộng chức năng của website. T&ocirc;i lấy một v&iacute; dụ c&aacute;c đơn vị đang sử dụng code thuần cho website của m&igrave;nh như:&nbsp;kidsplaza,&nbsp;vingroup&hellip; C&aacute;c đơn vị n&agrave;y c&oacute; đội ngũ code ri&ecirc;ng cho doanh nghiệp của m&igrave;nh. N&ecirc;n việc quản trị hệ thống từ đầu, cũng như ph&aacute;t triển hệ thống website l&agrave; ho&agrave;n to&agrave;n khả thi v&agrave; tiện dụng.</p>\r\n<p>Nếu đơn vị bạn kh&ocirc;ng sở hữu ri&ecirc;ng đội code cho doanh nghiệp m&igrave;nh th&igrave; bạn h&atilde;y thực sự c&acirc;n nhắc khi sử dụng website code thuần. Bởi lẽ mỗi cấu tr&uacute;c website l&agrave; ho&agrave;n to&agrave;n kh&aacute;c nhau, việc thu&ecirc; một đơn vị thứ 3 mở rộng ph&aacute;t triển website dẫn đến rất nhiều rủi ro v&agrave; kh&oacute; khăn. Hơn nữa chi ph&iacute; để triển khai 1 website code thuần l&agrave; lớn gấp nhiều lần website wordpress hay web102. Nhưng ở đ&acirc;y m&igrave;nh đang đề cập đến wordpress 1-0-2.</p>\r\n<p>H&atilde;y tham khảo bảng gi&aacute; dưới đ&acirc;y v&agrave;o tạo cho m&igrave;nh một g&oacute;i ph&ugrave; hợp nh&eacute;!</p>\r\n<p>{$pricing_table}</p>', '567675-how-to-get-started-with-wordpress-5eeecdf05676e-5f720946b8393.jpg', 0, 'public', 0, '2020-09-29 02:57:27', '2020-10-07 18:40:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_views`
--

CREATE TABLE `post_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `view_date` date DEFAULT NULL,
  `view_total` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'Slider',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'slider',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `crop` tinyint(1) DEFAULT 0,
  `width` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `height` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) DEFAULT 0,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sliders`
--

INSERT INTO `sliders` (`id`, `name`, `slug`, `description`, `priority`, `crop`, `width`, `height`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Main', 'test', '00000000', 1, 0, 1200, 400, 1, 0, '2020-03-14 10:09:28', '2020-03-25 14:26:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slider_items`
--

CREATE TABLE `slider_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slider_id` bigint(20) UNSIGNED DEFAULT 0,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `props` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `slider_items`
--

INSERT INTO `slider_items` (`id`, `slider_id`, `title`, `sub_title`, `description`, `image`, `link`, `url`, `priority`, `props`) VALUES
(2, 1, 'Giải pháp tối ưu <br/>cho doanh nghiệp', NULL, NULL, 'spotkanie-biznesowe-5e7b6b115626f.jpg', NULL, NULL, 0, NULL),
(3, 1, 'Thiết Kế <span>Logo</span> <br> Nhận diện thương hiệu', NULL, NULL, '83797967-111088163800875-2662830009273548800-o-5f0d0f974b13f.jpg', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subcribes`
--

CREATE TABLE `subcribes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `subcribes`
--

INSERT INTO `subcribes` (`id`, `email`) VALUES
(1, 'doanln16@gmail.com'),
(2, 'lengocdoan.hb.2016@gmail.com'),
(3, 'letung0003@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_lower` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'undefined',
  `tagged_count` int(10) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tags`
--

INSERT INTO `tags` (`id`, `name`, `name_lower`, `keyword`, `slug`, `tagged_count`) VALUES
(1, 'Phát triển website', 'phát triển website', 'Phat trien website', 'phat-trien-website', 0),
(2, ' Thiết kế website', ' thiết kế website', ' Thiet ke website', 'thiet-ke-website', 0),
(3, ' Laravel', ' laravel', ' Laravel', 'laravel', 0),
(4, ' Thương mại điện tử', ' thương mại điện tử', ' Thuong mai dien tu', 'thuong-mai-dien-tu', 0),
(5, ' WordPress', ' wordpress', ' WordPress', 'wordpress', 0),
(6, 'dịch vụ web', 'dịch vụ web', 'dich vu web', 'dich-vu-web', 0),
(7, 'portfolio', 'portfolio', 'portfolio', 'portfolio', 0),
(8, 'web102', 'web102', 'web102', 'web102', 0),
(9, 'news', 'news', 'news', 'news', 0),
(10, ' Tin tức', ' tin tức', ' Tin tuc', 'tin-tuc', 0),
(11, 'dịch vụ web trọn gói', 'dịch vụ web trọn gói', 'dich vu web tron goi', 'dich-vu-web-tron-goi', 0),
(12, 'cv online', 'cv online', 'cv online', 'cv-online', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tag_refs`
--

CREATE TABLE `tag_refs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'post',
  `ref_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tag_refs`
--

INSERT INTO `tag_refs` (`id`, `tag_id`, `ref`, `ref_id`) VALUES
(1, 1, 'project', 1),
(2, 2, 'project', 1),
(3, 3, 'project', 1),
(4, 4, 'project', 1),
(5, 1, 'project', 2),
(6, 3, 'project', 2),
(7, 2, 'project', 2),
(8, 1, 'project', 3),
(9, 2, 'project', 3),
(10, 3, 'project', 3),
(11, 1, 'project', 4),
(12, 5, 'project', 4),
(13, 2, 'project', 4),
(14, 1, 'project', 5),
(15, 5, 'project', 5),
(16, 4, 'project', 5),
(17, 1, 'project', 6),
(18, 2, 'project', 6),
(19, 3, 'project', 6),
(20, 3, 'project', 11),
(21, 2, 'project', 11),
(22, 1, 'project', 11),
(23, 6, 'post', 14),
(24, 7, 'post', 14),
(25, 8, 'post', 14),
(26, 9, 'post', 16),
(27, 10, 'post', 16),
(28, 8, 'post', 16),
(29, 11, 'post', 16),
(32, 4, 'post', 17),
(33, 11, 'post', 17),
(34, 8, 'post', 17),
(35, 1, 'project', 23),
(36, 3, 'project', 23),
(37, 8, 'project', 23),
(38, 4, 'project', 23),
(39, 12, 'post', 14),
(40, 8, 'project', 11);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `themes`
--

CREATE TABLE `themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `secret_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'CrazyTheme',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'multi-page',
  `web_types` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` double(5,2) DEFAULT 1.00,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'protected',
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available` int(11) NOT NULL DEFAULT 0,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `themes`
--

INSERT INTO `themes` (`id`, `secret_id`, `name`, `slug`, `view_type`, `web_types`, `version`, `description`, `privacy`, `zip`, `image`, `available`, `deleted`, `created_at`, `updated_at`) VALUES
(1, '5e6c4ba89fabe', '247 News', '247-news', 'multi-page', 'news, default', 1.00, 'Giao diện tin tức', 'protected', '247-news.zip', '24hnews-preview-5e6c4ba89ef03.png', 1, 0, '2020-03-14 03:12:40', '2020-03-14 03:16:54'),
(2, '5e6c85638ef24', 'Bize', 'bize', 'multi-page', 'business', 1.00, NULL, 'protected', 'bize.zip', 'magneto-development-and-features-5e6c85638dce7.png', 1, 0, '2020-03-14 07:18:59', '2020-03-14 09:14:50'),
(3, '5e6e6ba90f67c', 'Bunas', 'bunas', 'multi-page', 'default, business', 1.00, NULL, 'public', 'bunas.zip', 'preview-large-preview-5e6e6ba908046.png', 1, 0, '2020-03-15 17:53:45', '2020-05-28 03:31:00'),
(4, '5ee9016e403c8', 'Docly', 'docly', 'multi-page', 'default, business', 1.00, 'Gao diện trang tài liệu tra cứu', 'public', 'docly.zip', 'home2-large-5ee9016e40151.png', 1, 0, '2020-06-17 04:29:18', '2021-10-21 03:56:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'transfer',
  `customer_id` bigint(20) UNSIGNED DEFAULT 0,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created_id` bigint(20) UNSIGNED DEFAULT 0,
  `approved_id` bigint(20) UNSIGNED DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `transactions`
--

INSERT INTO `transactions` (`id`, `ref`, `ref_id`, `type`, `customer_id`, `code`, `amount`, `note`, `metadata`, `time`, `status`, `deleted`, `created_id`, `approved_id`, `created_at`, `updated_at`) VALUES
(46, 'service', 77, 'payment', 1, NULL, '750000.00', '####### Start Promo #######\nCode: 1245\nValue: -50%\n######## End Promo #######\n\nCustomer Note:\n', '\"{\\\"has_promo\\\":true,\\\"promo_code\\\":\\\"1245\\\",\\\"origin_total\\\":1500000,\\\"final_total\\\":750000}\"', '2021-10-07 17:03:48', 0, 0, 1, 0, '2021-10-07 10:03:48', '2021-10-07 10:03:48'),
(47, 'service', 77, 'payment', 1, NULL, '750000.00', '####### Start Promo #######\nCode: 1245\nValue: -50%\n######## End Promo #######\n\nCustomer Note:\n', '\"{\\\"has_promo\\\":true,\\\"promo_code\\\":\\\"1245\\\",\\\"origin_total\\\":1500000,\\\"final_total\\\":750000}\"', '2021-10-07 17:11:37', 0, 0, 1, 0, '2021-10-07 10:11:37', '2021-10-07 10:11:37'),
(48, 'service', 77, 'payment', 1, NULL, '750000.00', '####### Start Promo #######\nCode: 1245\nValue: -50%\n######## End Promo #######\n\nCustomer Note:\n', '\"{\\\"has_promo\\\":true,\\\"promo_code\\\":\\\"1245\\\",\\\"origin_total\\\":1500000,\\\"final_total\\\":750000}\"', '2021-10-07 17:14:36', 1, 0, 1, 0, '2021-10-07 10:14:36', '2021-10-07 10:34:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google2fa_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `email_verified_at`, `password`, `phone_number`, `facebook_id`, `google_id`, `google2fa_secret`, `remember_token`, `type`, `avatar`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Lê Ngọc Doãn', 'doanln16@gmail.com', 'doanln', NULL, '$2y$10$r5pFq92zPvCwkvduqIhImucaVg1kCpc0dV6PMfmpaq5xztiXZ/5v6', '0945786960', NULL, NULL, NULL, 'y3Zhv7798lrqRzIIYwdDCgErzIL8c6PWBoodRed30C8mXpjSjV6wbB42BQci', 'admin', '18342541-1417276298335398-2035896623801337457-n-5e01cdad34d0f.png', 1, 0, '2020-03-12 13:34:18', '2021-10-21 03:27:32'),
(6, 'Lê Ngọc Doãn', 'aaa1@gmail.com', 'aaa1', NULL, '$2y$10$n4ugJ0QooayhAe6TANggTuCgS8HuZEOZbCqmbVRXxVAmZmrw1Lynm', NULL, NULL, NULL, NULL, NULL, 'user', 'web102-first-frame-5ed92f8993842.png', 0, 0, '2020-06-04 02:47:02', '2020-06-05 04:29:45'),
(7, 'Lê Ngọc Doãn', 'lengocdoan.hb.2016@gmail.com', 'lengocdoanhb2016', NULL, '$2y$10$By770iExlV0HOkWRLSdz8.nrTLiWcEItJXUshLLqXOGSHKPHdHP2G', NULL, NULL, NULL, NULL, 'qNg1nNYkhFtF0K9N3uxmkE4XbV8vvXiZ78NclDOOHBVEtJg5ocwr7XlLcGx2', 'user', '78d25667-b9d5-4e30-99ca-cf3e75395979-5ed9f6edf3134.png', 1, 0, '2020-06-05 02:19:50', '2020-06-05 18:40:29'),
(8, 'Đnh Trang', 'dinhthihuyentrang998@gmail.com', 'trangdth2910', NULL, '$2y$10$ubS7X2Ylv/IMgMgxnioWGegsF6TaMDIRKbB7bM7a1alwHIXHmylUa', '0362866665', NULL, NULL, NULL, NULL, 'user', '100948888-1480208805514698-5212731240842526720-o-5eda1ad3584bb.png', 1, 0, '2020-06-05 21:13:39', '2020-06-05 21:13:39'),
(9, 'Anh Tuấn', 'tuanchiko1998@gmail.com', 'tuanchiko1998', NULL, '$2y$10$6eVPyevFsQo0YpKSgH3i3eDOpSUkXzTMrauzIu44ikJ4RAYqVhqsm', '0355573311', NULL, NULL, NULL, 'hcChoH3cgiH0V0RbDWlDaDE66e6WkA07FITGgzKC6WeNmGO6WwM50GwS4ylM', 'user', NULL, 1, 0, '2020-06-06 23:49:10', '2020-09-11 02:14:16'),
(10, 'Lê Văn Tùng', 'letung0003@gmail.com', 'letung0003', NULL, '$2y$10$Jzh/Dn.Av65mVRUGCjesCe9jpjgB3RYxxs4lpnYBj1DuyNVNDCbQK', NULL, NULL, NULL, NULL, 'wiPvqD2E02XZNCKCDMZMapmUwqV2x8QpFDQgRkHCuMqGnCqimqWZupfanoZa', 'user', NULL, 1, 0, '2020-06-09 16:09:22', '2020-06-09 16:10:43'),
(11, 'test user', 'test@gmail.com', 'test', NULL, '$2y$10$DtprIbArG5xzszzz9v.rxepT5P6u0wXx8aDYxiZhJx1EvysRJqDrO', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2020-06-09 16:57:40', '2020-06-09 16:57:40'),
(12, 'Hoang', 'manhhoang3151996@gmail.com', 'manhhoang3151996', NULL, '$2y$10$jdHTASvrPrdLLZ1SvjACjOGpUfnFU3b0oxGk3aaFjYPV3hbaKI/j.', NULL, NULL, NULL, NULL, 'SerI1yghxtSKrvEOMveNjy7awvs94ybIG7n9NEW13YiR43ygCw1XXPxPnId8', 'user', NULL, 1, 0, '2020-06-09 16:59:05', '2020-06-09 16:59:29'),
(13, 'ngô phượng vỹ', 'cute2x1a@gmail.com', 'cute2x1a', NULL, '$2y$10$5FsTjGzdT6WzN8Ev3CSZj.NQQCiD.IvReqUin20vm8fLH5CpuJIA.', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2020-06-09 19:58:57', '2020-06-09 19:58:57'),
(14, 'vingroup', 'vingroup@gmail.com', 'vingroup', NULL, '$2y$10$xzysinZWhM.xnlJZ4y96xO5BoCRi3BXVWHVxS5Wny.JTrg9gBKFru', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2020-06-11 00:40:53', '2020-06-11 00:40:53'),
(15, 'Pham Trung Hieu', 'hieup2047@gmail.com', 'hieup2047', NULL, '$2y$10$s3C5DI6OcTbv8G4lPRM6cuw31RPsAANrfP5pM78kxUuuZAQxVZS7m', NULL, NULL, NULL, NULL, 'nPrgCgl4qCDtTWxvsZopa5dHot0fb2mT3sWpSbJekTlAjHJcaWjS5zmtcbLn', 'user', NULL, 1, 0, '2020-06-12 15:55:42', '2020-06-12 17:32:47'),
(16, 'Pham Trung Hieu', 'vuthininhvvt@gmail.com', 'vuthininhvvt', NULL, '$2y$10$X.q7iy04mtWhxIPMCLGWBupnpyP0osdbkU3wCUnKjQbND87WExJ4C', NULL, NULL, NULL, NULL, NULL, 'user', '53567236-2284257118514060-234413722968260608-n-5ee913806e404.png', 0, 0, '2020-06-12 17:24:30', '2020-06-17 05:46:24'),
(17, 'Nguyễn Văn Tiến', 'b0y9x199x@gmail.com', 'b0y9x199x', NULL, '$2y$10$bza29IKuSXdvWJaRaqU0.eU.I01QbVeMQhe53owA0Pbr7XVmeVryC', NULL, NULL, NULL, NULL, 'Pw0yzoMHTB7OaUDdVMZF8z6nx35zkcCKSWwFpREEEEbUhBskX1v7H44m3gMn', 'user', NULL, 1, 0, '2020-06-15 14:29:03', '2020-06-15 14:29:25'),
(18, 'Lê Ngọc Anh', 'nooffood09@gmail.com', 'nooffood09', NULL, '$2y$10$qZuquB5tnmmFFSDvguGzouohMasggihBW9VwC7P6xKlhcE14N1ah2', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-07-05 03:26:47', '2020-07-05 03:28:14'),
(19, 'Đức Tiến PT12312 WEB', 'doductientq@gmail.com', 'doductientq', NULL, '$2y$10$t63LQucdhtu8WSuSpGp3reKFGDiNotlEHYiH7REAIAkHioXhZcXZi', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-07-09 20:00:43', '2020-07-09 20:01:04'),
(20, 'Lê Văn Tùng', 'tunglvph07572@fpt.edu.vn', 'tunglvph07572', NULL, '$2y$10$PEHnuA9/EnxyCOpUF.6kmubPe.98jUPvNRDau7dgWAftb86XxV5bq', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2020-07-14 02:19:19', '2020-07-14 02:19:19'),
(21, 'Nguyen Long', 'dbhlnmn@gmail.com', 'dbhlnmn', NULL, '$2y$10$zreu8cUfPaAemCvwa6fdh.aahaYYsTvya/kkirPLncli0iNwKu9Ye', '0345985333', NULL, NULL, NULL, 'OVRlocHduvHsBdiVX6Gls5nkmh1cNcFC93Z4za17sTSoJJ7ELPk7EW5SlmkD', 'user', NULL, 1, 0, '2020-07-26 23:32:13', '2020-07-26 23:33:59'),
(22, 'Quyet', 'quyet.ng2211@gmail.com', 'quyetng2211', NULL, '$2y$10$ND5n9Jk/ORwmUloAaUIxTOFF2JXDFp2Aj8f2bGfy/Y6gNdcriADMK', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-07-27 20:17:53', '2020-07-27 20:18:46'),
(23, 'lê phúc hậu', 'lehau121212@gmail.com', 'lehau121212', NULL, '$2y$10$MJH0OcDo4igUHrb4aic07O56FAGte8KYNP/6q4yfhq.ocF4Xwkl4m', NULL, NULL, NULL, NULL, 'XAFy2epRWxHaOiM1Dd0bCa8vDHwiXXPc5PgzVp1xzbwP7vIbrHKEzgmjbUW3', 'user', NULL, 1, 0, '2020-07-28 00:43:08', '2020-07-28 00:50:31'),
(24, 'le quyet', 'lequyet840500@gmail.com', 'lequyet840500', NULL, '$2y$10$E4CQtv5CLfI.XRU.99T.peb0ayNjWKdAbafhO5qsKbXfkSYdWHHFS', NULL, NULL, NULL, NULL, 'Bl8F9GQyF1L03KxH6bW7hByuom2faBrCFu20cwFqaJFEL2qTu90Euvj3Rqan', 'user', NULL, 1, 0, '2020-07-28 01:06:46', '2020-07-28 01:07:15'),
(25, 'Nguyễn Thị Quế Anh', 'queanh0712@gmail.com', 'queanh0712', NULL, '$2y$10$a0N3O4Z8.TZcC7UTJ4TB..PNjQFILnqG60YUKjjAWh.HhnYpDL8x6', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-07-28 12:44:53', '2020-07-28 12:45:18'),
(26, 'demo123', 'admin123@gmail.com', 'admin123', NULL, '$2y$10$1ZUJE6J838kyOvyQC0BEpuHxGJa1hr17/wy7muEBPLcZqt3Ab3Bam', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2020-08-03 00:53:43', '2020-08-03 00:53:43'),
(27, 'nguyen quang huy', 'nqh.one.of.a.kind@gmail.com', 'nqhoneofakind', NULL, '$2y$10$2OrR5baIzcQnPLnY9d7Lsu7/Iz/PYW4sPZH1e6lNiwWmgxTRr4lLG', NULL, NULL, NULL, NULL, '5btNYaojMlcVgSBky0EQB6YhjNWvnffQ5Za9pS0R8MgFCWIxo43NG2b1TbLT', 'user', NULL, 1, 0, '2020-08-03 17:06:36', '2020-08-03 17:06:57'),
(28, 'Trần Quang Đại', 'tranquangdai2016@gmail.com', 'tranquangdai2016', NULL, '$2y$10$2jllEndRToGcTANy0X4Kve5aIH94i7evR/vzcZYXdRC5mbloAShwC', NULL, NULL, NULL, NULL, 'YVGPGX64C9IirTkQUalnvhX7tzdrE69AdeyQ9mU44XndNdxU2aPXktS2Z9C6', 'user', NULL, 1, 0, '2020-08-03 17:06:59', '2020-08-03 17:16:38'),
(29, 'Tuan Anh', 'lawlaww7@gmail.com', 'lawlaww7', NULL, '$2y$10$O9SIi3iyuoe9L5sJ3q84AOo7wkJUOIfMjEsmBMwT.Rz3Y9f/w2G8C', NULL, NULL, NULL, NULL, 'qtZvNs5KIy4q6uRWDkbgACW5qPBnVDBp315UTVoWHtnPhaYvgvumscBoTQ9M', 'user', NULL, 1, 0, '2020-08-03 17:07:27', '2020-08-03 17:08:09'),
(30, 'Mai Mai', 'ochna1112@gmail.com', 'ochna1112', NULL, '$2y$10$UMGBcdxhbrU73ZBk/PmySeh0AfEIYuqdivVIw36QHGachAUCqqZWa', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-08-03 17:07:44', '2020-08-03 17:08:22'),
(31, 'duythong', 'thong09x@gmail.com', 'thong09x', NULL, '$2y$10$3O8.lQT8WYhMnQjs7vgrg.oP99BChqebh3Z5CPtgRN6gjUM6xOfEe', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2020-08-03 17:08:10', '2020-08-03 17:08:10'),
(32, 'Duong Khanh Duy', 'duydkph10118@fpt.edu.vn', 'duydkph10118', NULL, '$2y$10$2n1SKNwgtCnQE446lNbupOILCJAAPEQ7CvyZ6ms6rd7z9Q3vAG/jW', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-08-03 17:08:15', '2020-08-03 17:10:05'),
(33, 'buiducquyen', 'buiducquyen1901@gmail.com', 'buiducquyen1901', NULL, '$2y$10$P9JdBtVn6RBvc8jTooJ5vetsCM97hDHGruxngN4ATeJz8luQJoi/2', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2020-08-03 17:08:19', '2020-08-03 17:08:19'),
(34, 'Nguyễn Thế Kỷ', 'kyntph05775@fpt.edu.vn', 'kyntph05775', NULL, '$2y$10$cblOM0HPSYkVmQOYppPVNuqzxcMeV4XDVNJPFhpad/NIghazJpVvK', '0941935909', NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-08-03 17:08:49', '2020-08-03 17:13:37'),
(35, 'nguyễn đình đạt', 'datndph09982@fpt.edu.vn', 'datndph09982', NULL, '$2y$10$EzTBhSzIh6kQtbfUtIE2XOnsutBwwSuqVMSuJl2QY4rYbaiHKPEUe', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-08-03 17:08:50', '2020-08-03 17:13:45'),
(36, 'Nguyen Van Tuan', 'cute0123@yahoo.com', 'cute0123', NULL, '$2y$10$BJg4t7SwbU9sUhhENbylJeUC0mLy2qYuCV8Hi1bU8sfjtmxIMfmq2', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-08-03 17:08:59', '2020-08-03 17:12:48'),
(37, 'HoànG Ah', 'anhhnph09909@fpt.edu.vn', 'anhhnph09909', NULL, '$2y$10$5ubdj1g6uD.f0rGnxGrZr.8u8vox0Uv8WbBi3sYjr2Fv2kXF3/.8C', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2020-08-03 17:09:40', '2020-08-03 17:09:40'),
(38, 'bui duc quyen', 'quyenbdph10002@fpt.edu.vn', 'quyenbdph10002', NULL, '$2y$10$dKnb/YX565Sq0uu5CyX2f.Kgbf/AnSI0fhYkq0oJvWWThbOTs8pc6', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-08-03 17:10:29', '2020-08-03 17:13:06'),
(39, 'duythong2001', 'thongthathu201@gmail.com', 'thongthathu201', NULL, '$2y$10$.DjOcwQNQEGIP/cuHFqoJOIkTGwn1pBjOUi1EzWrnDbRe9wdrq4vG', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2020-08-03 17:15:11', '2020-08-03 17:15:11'),
(40, 'Anh Tuấn', 'tuandv211@gmail.com', 'tuandv211', NULL, '$2y$10$G7zKREEIWH4NNHtGvm0P/.c1DKYTPYiyY8i9Do1nhlU3sq5uSlU/S', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2020-09-04 03:06:13', '2020-09-04 03:06:13'),
(41, 'anhtuan', 'tuandv311@gmail.com', 'tuandv311', NULL, '$2y$10$CzVSNH2c8pfUTjmzXPeaI.l.sFaL.3m4TVkW4Sr8771rSUyq5I92S', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-09-04 03:07:44', '2020-12-27 01:15:53'),
(42, 'Dao Anh Tuan', 'tuandvph05029@fpt.edu.vn', 'tuandvph05029', NULL, '$2y$10$8KsdWQFHlaEaYRBbrc/QLevxnuK7s4Fv6QWSbddSqOzPyqvpxT2Q.', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2020-09-04 03:10:29', '2020-09-04 03:10:29'),
(43, 'Hiếu Đẹp Trai', 'vuhieu2610@gmail.com', 'vuhieu2610', NULL, '$2y$10$GJ9XQXbXif7VaVQ6ZVkke.4WLqE6cZNziinSknhYN1KH8lWsYjCFO', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-10-03 19:05:21', '2020-10-03 20:00:39'),
(44, 'Hiếu Đẹp Trai', 'snowbn98@gmail.com', 'snowbn98', NULL, '$2y$10$jC0bGtTtnKDWHgZ05BGiFu7D53ubbKdP6xfqkfXjx1Kfd7P1TNc6O', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2020-10-03 19:10:14', '2020-10-03 19:10:14'),
(45, 'Doan Le', 'doanle2016@outlook.com', 'doanle2016', NULL, '$2y$10$.pmqUdbB2fZWrjFBoBjUBO.BlMn8KHstCVGq4t/J5bZeihi6L2T/.', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-10-24 22:10:18', '2020-10-24 22:12:42'),
(46, 'Nguyễn Thiện Tâm', 'tamntph09184@fpt.edu.vn', 'tamntph09184', NULL, '$2y$10$Z2Cw3mo4Y7gx1sS0hj2EpusZbp6SDjPbO1Mdhaenj7g4pdr.FM6by', '0981675396', NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2020-10-29 17:27:01', '2020-12-01 03:15:21'),
(47, 'Trần Ngọc Minh', 'tranngocminh0305@icloud.com', 'tranngocminh0305', NULL, '$2y$10$WPqrn3fLIs4R5GG4WtXjwuuGBj8pPPNUrysXGbdKE5E.ASqzSWhPa', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2021-02-10 22:43:34', '2021-02-10 22:43:34'),
(48, 'Văn Huỳnh được', 'nhoczuka49@gmail.com', 'nhoczuka49', NULL, '$2y$10$QltVqZu7rstRD8ntrio1reAOmANKVg3hayaSiwnwl8iP6ntQuKO/y', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2021-04-15 22:30:45', '2021-04-15 22:30:45'),
(49, 'gia long', 'quangsang.adv@gmail.com', 'quangsangadv', NULL, '$2y$10$DXWSmu2HHqrIjFFtdHWgveHdnzYbkNLAU0hL7riXmj0Je0dYpWvae', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2021-04-15 23:01:30', '2021-04-15 23:01:30'),
(50, 'Nguyễn Thành Long', 'aevs2534@gmail.com', 'aevs2534', NULL, '$2y$10$ie3ntlkXeeTvCaGXD/yadu4blQxKKaiLmfghr3WMKJ37Xg5QJ8t1.', NULL, NULL, NULL, NULL, 'wKz7k3Nmo5Nmr3SVvPZuCmhBQ7limP4pzMiR02d1qZHmx1lz8eig2cfRUKG2', 'user', NULL, 1, 0, '2021-04-21 11:24:58', '2021-04-21 11:25:40'),
(51, 'Lê Văn Tùng', 'letung150200@gmail.com', 'letung150200', NULL, '$2y$10$AFsMiEIHXWOJAp125Rx93OqS8W45cBmRR9yamMr/6zB90nuejzbHC', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2021-05-10 00:02:09', '2021-05-10 00:04:19'),
(52, 'Lê Ngọc Doãn', 'doanln19@gmail.com', 'doanln19', NULL, '$2y$10$HWSS/Y7Z4zixD4.HecauZu9954SFT30kOucF7Sm31jsHJxSpLPHJy', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 0, 0, '2021-07-25 13:23:10', '2021-07-25 13:23:10'),
(53, 'ducpanda', 'ducpanda98@gmail.com', 'ducpanda98', NULL, '$2y$10$pMIG/MUiBY7fB4GwljdtA.HoQOxtCoRuIyQE6ztjyQMQpSgMcTjhe', NULL, NULL, NULL, NULL, NULL, 'user', NULL, 1, 0, '2021-09-26 09:00:21', '2021-09-26 09:00:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_notices`
--

CREATE TABLE `user_notices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT 0,
  `notice_id` bigint(20) UNSIGNED DEFAULT 0,
  `seen` int(11) NOT NULL DEFAULT 0,
  `seen_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category_refs`
--
ALTER TABLE `category_refs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contact_replies`
--
ALTER TABLE `contact_replies`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `crazy_3d_item_refs`
--
ALTER TABLE `crazy_3d_item_refs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `crazy_3d_model_items`
--
ALTER TABLE `crazy_3d_model_items`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `crazy_3d_projects`
--
ALTER TABLE `crazy_3d_projects`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `crazy_3d_templates`
--
ALTER TABLE `crazy_3d_templates`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dynamics`
--
ALTER TABLE `dynamics`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `email_tokens`
--
ALTER TABLE `email_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `html_areas`
--
ALTER TABLE `html_areas`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `html_components`
--
ALTER TABLE `html_components`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `html_embeds`
--
ALTER TABLE `html_embeds`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `metadatas`
--
ALTER TABLE `metadatas`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `option_datas`
--
ALTER TABLE `option_datas`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `option_groups`
--
ALTER TABLE `option_groups`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `permission_modules`
--
ALTER TABLE `permission_modules`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `permission_module_roles`
--
ALTER TABLE `permission_module_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_module_roles_module_id_foreign` (`module_id`),
  ADD KEY `permission_module_roles_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `permission_roles`
--
ALTER TABLE `permission_roles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `permission_user_roles`
--
ALTER TABLE `permission_user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_user_roles_user_id_foreign` (`user_id`),
  ADD KEY `permission_user_roles_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `post_views`
--
ALTER TABLE `post_views`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `slider_items`
--
ALTER TABLE `slider_items`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `subcribes`
--
ALTER TABLE `subcribes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tag_refs`
--
ALTER TABLE `tag_refs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_refs_tag_id_foreign` (`tag_id`);

--
-- Chỉ mục cho bảng `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_notices`
--
ALTER TABLE `user_notices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_notices_user_id_foreign` (`user_id`),
  ADD KEY `user_notices_notice_id_foreign` (`notice_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `category_refs`
--
ALTER TABLE `category_refs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `components`
--
ALTER TABLE `components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `contact_replies`
--
ALTER TABLE `contact_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `crazy_3d_item_refs`
--
ALTER TABLE `crazy_3d_item_refs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `crazy_3d_model_items`
--
ALTER TABLE `crazy_3d_model_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT cho bảng `crazy_3d_projects`
--
ALTER TABLE `crazy_3d_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `crazy_3d_templates`
--
ALTER TABLE `crazy_3d_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `dynamics`
--
ALTER TABLE `dynamics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `email_tokens`
--
ALTER TABLE `email_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT cho bảng `html_areas`
--
ALTER TABLE `html_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `html_components`
--
ALTER TABLE `html_components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT cho bảng `html_embeds`
--
ALTER TABLE `html_embeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT cho bảng `metadatas`
--
ALTER TABLE `metadatas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=605;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT cho bảng `notices`
--
ALTER TABLE `notices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `option_datas`
--
ALTER TABLE `option_datas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=333;

--
-- AUTO_INCREMENT cho bảng `option_groups`
--
ALTER TABLE `option_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- AUTO_INCREMENT cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `permission_modules`
--
ALTER TABLE `permission_modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `permission_module_roles`
--
ALTER TABLE `permission_module_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `permission_roles`
--
ALTER TABLE `permission_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `permission_user_roles`
--
ALTER TABLE `permission_user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `post_views`
--
ALTER TABLE `post_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `slider_items`
--
ALTER TABLE `slider_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `subcribes`
--
ALTER TABLE `subcribes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `tag_refs`
--
ALTER TABLE `tag_refs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT cho bảng `user_notices`
--
ALTER TABLE `user_notices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `permission_module_roles`
--
ALTER TABLE `permission_module_roles`
  ADD CONSTRAINT `permission_module_roles_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `permission_modules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_module_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `permission_roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `permission_user_roles`
--
ALTER TABLE `permission_user_roles`
  ADD CONSTRAINT `permission_user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `permission_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tag_refs`
--
ALTER TABLE `tag_refs`
  ADD CONSTRAINT `tag_refs_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_notices`
--
ALTER TABLE `user_notices`
  ADD CONSTRAINT `user_notices_notice_id_foreign` FOREIGN KEY (`notice_id`) REFERENCES `notices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_notices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
