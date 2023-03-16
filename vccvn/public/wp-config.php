<?php
define( 'WP_AUTO_UPDATE_CORE', false );

// define( 'AUTOMATIC_UPDATER_DISABLED', true );
// define( 'DISALLOW_FILE_MODS', true );
/**
 * Cấu hình cơ bản cho WordPress
 *
 * Trong quá trình cài đặt, file "wp-config.php" sẽ được tạo dựa trên nội dung
 * mẫu của file này. Bạn không bắt buộc phải sử dụng giao diện web để cài đặt,
 * chỉ cần lưu file này lại với tên "wp-config.php" và điền các thông tin cần thiết.
 *
 * File này chứa các thiết lập sau:
 *
 * * Thiết lập MySQL
 * * Các khóa bí mật
 * * Tiền tố cho các bảng database
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Thiết lập MySQL - Bạn có thể lấy các thông tin này từ host/server ** //
/** Tên database MySQL */
define('DB_NAME', __WP_CONFIG_DB_NAME__?__WP_CONFIG_DB_NAME__:'');

/** Username của database */
define('DB_USER', __WP_CONFIG_DB_USER__?__WP_CONFIG_DB_USER__:'');

/** Mật khẩu của database */
define('DB_PASSWORD', __WP_CONFIG_DB_PASSWORD__?__WP_CONFIG_DB_PASSWORD__:'');

/** Hostname của database */
define('DB_HOST', __WP_CONFIG_DB_HOST__?__WP_CONFIG_DB_HOST__:'localhost');

/** Database charset sử dụng để tạo bảng database. */
define('DB_CHARSET', __WP_CONFIG_DB_CHARSET__?__WP_CONFIG_DB_CHARSET__:'utf8');

/** Kiểu database collate. Đừng thay đổi nếu không hiểu rõ. */
define('DB_COLLATE', __WP_CONFIG_DB_COLLATE__?__WP_CONFIG_DB_COLLATE__:'');

/**#@+
 * Khóa xác thực và salt.
 *
 * Thay đổi các giá trị dưới đây thành các khóa không trùng nhau!
 * Bạn có thể tạo ra các khóa này bằng công cụ
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Bạn có thể thay đổi chúng bất cứ lúc nào để vô hiệu hóa tất cả
 * các cookie hiện có. Điều này sẽ buộc tất cả người dùng phải đăng nhập lại.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'q n:$;t:RvWJEx3R+ebxT.CLPhN{d-d]ytG)3%}A^3[,<hpz:JJi+thi1j/K)kVT');
define('SECURE_AUTH_KEY',  '$SD[*Dty|8/ug<mP/W_w$(_fkD+)<c1=V$mh+<Hktad6^#;DRL+KFWe9AmR>AQp!');
define('LOGGED_IN_KEY',    '4E_+7YaiEq=ln03-=cI{-pV+7gw;UM~-D-y9eR&j:C[NrUA!+`nG;Ds|:FB=ZdBv');
define('NONCE_KEY',        '!i$(D$%0rP42PbWjft-j+]k,] 5;+|4Qiy/PaJE(RVKO<OlVGB%dHx6xB_+AScGT');
define('AUTH_SALT',        '<~?jEH()ykQd]tL2D]5AGr5GXc6DuTRjbe2w4U|,/a8a+;,-ps!I]i2oB+39/6#(');
define('SECURE_AUTH_SALT', 'tqgo*;{}9%WR0K~sIurLwv-P&KbP %:bC6)7H[:uOh $+6lw8H~0J`eNI$&=REM`');
define('LOGGED_IN_SALT',   '-2rIE#sG)VN7<r~TjnO1LG8?[VP|h!8,ntf/4US)@p?j/(]]y=(RqXgJR7L~3byN');
define('NONCE_SALT',       'F--:x)k1.pkV MM}[_u*(Aq(we~I`-z88xSC8P``2f_3x0]z/]h$Un-CJ/>G_@!O');

/**#@-*/

/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix = __WP_CONFIG_TABLE_PREFIX__;

/**
 * Dành cho developer: Chế độ debug.
 *
 * Thay đổi hằng số này thành true sẽ làm hiện lên các thông báo trong quá trình phát triển.
 * Chúng tôi khuyến cáo các developer sử dụng WP_DEBUG trong quá trình phát triển plugin và theme.
 *
 * Để có thông tin về các hằng số khác có thể sử dụng khi debug, hãy xem tại Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', __WP_CONFIG_DEBUG__);

/* Đó là tất cả thiết lập, ngưng sửa từ phần này trở xuống. Chúc bạn viết blog vui vẻ. */

/** Đường dẫn tuyệt đối đến thư mục cài đặt WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Thiết lập biến và include file. */
require_once(ABSPATH . 'wp-settings.php');
