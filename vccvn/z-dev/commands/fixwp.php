<?php
if(!function_exists('fixwp')){
    /**
     * fixwp
     * 
     */
    function fixwp($dir=null)
    {
        $replace = [
            "wp-includes/default-constants.php" => [
                "ABSPATH . 'wp-content'" => "ABSPATH . WP_USER_CONTENT",
                " 'siteurl' ) . '/wp-content'" => " 'siteurl' ) . '/' . WP_USER_CONTENT",
                "'wp-content/plugins'" => "WP_USER_CONTENT . '/plugins'",
                "'wp-content/mu-plugins'" => "WP_USER_CONTENT . '/mu-plugins'",
        
            ],
            "wp-includes/functions.php" => [
                "'wp-content/uploads' ===" => "WP_USER_CONTENT . '/uploads' ===",
            ],
        
            "wp-includes/load.php" => [
                "'wp-content/db.php'" => "WP_USER_CONTENT . '/db.php'",
                ", 'wp-content/languages' " => ", WP_USER_CONTENT . '/languages' ",
                "ABSPATH . 'wp-content/languages'" => "ABSPATH . WP_USER_CONTENT . '/languages'",
            ],
            "wp-includes/media.php" => [
                "irname, 'wp-content/uploads' ) + 18" => "irname, WP_USER_CONTENT . '/uploads' ) + strlen(WP_USER_CONTENT . '/uploads')",
                "dirname, 'wp-content/uploads' )" => "dirname, WP_USER_CONTENT . '/uploads' )",
            ],
            "wp-includes/class-wp-user.php" => [
                "function has_cap( \$cap, ...\$args ) {\n" => "function has_cap(\$cap, ...\$args){\n        if(\$cap == 'update_core') return false;\n",
            ],
        
            "wp-includes/ms-default-constants.php" => [
                "'wp-content/blogs.dir'" => "WP_USER_CONTENT . '/blogs.dir'",
        
            ],
        
            "wp-includes/post.php" => [
                "file, 'wp-content/uploads'" => "file, WP_USER_CONTENT . '/uploads'"
            ],
        
            "wp-admin/load-styles.php" => [
                "'WP_CONTENT_DIR', ABSPATH . 'wp-content'" => "'WP_CONTENT_DIR', ABSPATH . WP_USER_CONTENT"
            ],
            "wp-admin/options-media.php" => [
                "'wp-content/uploads'" => "WP_USER_CONTENT . '/uploads'"
            ],
            "wp-admin/options-media.php" => [
                "'wp-content/uploads'" => "WP_USER_CONTENT . '/uploads'"
            ],
            "wp-admin/includes/class-core-upgrader.php" => [
                " 'wp-content' === substr( \$file, 0, 10 )" => " WP_USER_CONTENT === substr( \$file, 0, strlen(WP_USER_CONTENT) )"
            ],
        
            "wp-admin/includes/class-wp-site-health-auto-updates.php" => [
                " 'wp-content' === substr( \$file, 0, 10 )" => " WP_USER_CONTENT === substr( \$file, 0, strlen(WP_USER_CONTENT) )"
            ],
        
            "wp-admin/includes/network.php" => [
                "ABSPATH . 'wp-content'" => "ABSPATH . WP_USER_CONTENT"
            ],
            "wp-admin/includes/update-core.php" => [
                " 'wp-content' === substr( \$file, 0, 10 )" => " WP_USER_CONTENT === substr( \$file, 0, strlen(WP_USER_CONTENT) )",
                "istro . 'wp-content/languages" => "istro . WP_USER_CONTENT . '/languages",
                "distro . 'wp-content/' . " => "distro . WP_USER_CONTENT . '/' . "
            ],
        
            "wp-admin/includes/file.php" => [
                "\$wp_file_owner   = @fileowner( __FILE__ );" => "\$wp_file_owner   = @fileowner( \$temp_file_name );",
            ],
        
        ];

        $d = $dir?$dir.'/':'';

        foreach ($replace as $file => $search) {
            $f = base_path($d.$file);
            if(file_exists($f)){
                echo "phân tích file: $f\n";
                $content = file_get_contents($f);
                foreach ($search as $find => $replace_) {
                    $content = str_replace($find, $replace_, $content);
                }
                if(file_put_contents($f, $content)){
                    echo "Đã fix\n";
                }
            }
        }
        
    }
}