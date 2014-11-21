<?php 
/*
Plugin Name: WP-Dialog
Plugin URI:  http://zhangge.net/4718.html
Description: <strong>WordPress友好对话框&底部底部滚动推荐条插件</strong>，1. 通过这个插件可以为博客增加一个友好的右下角滑动对话框，可以自动判断搜索来路、新老访客(是否留过言)，给出不同的欢迎语句！2. 在博客底部集成随机文章滚动推荐条，并在右侧集成手动呼出对话框按钮；3. 启用这个插件之后还能够在有人复制文章网站内容的时候，弹出转载版权提示，具体请自行测试。
Version: 1.1.0
Author: 张戈
Author URI: http://zhangge.net
Copyright: 张戈博客原创插件，任何个人或团体不可擅自更改版权。
*/
class WP_Dialog{  
    function __construct(){
            wp_register_script( 'WP-Dialog', plugins_url('dialog.js',__FILE__), array(), '1.1', false );
            wp_enqueue_script( 'WP-Dialog' );
            wp_enqueue_style( 'WP-Dialog', plugins_url('skins/default.css',__FILE__), array(), '1.1', false );
            add_action('wp_footer', 'WP-Dialog');
            function scroll_bar(){
	            include('scroll-bar.php');
            }
            add_action( 'wp_footer', 'scroll_bar' ); 
    }
}  
new WP_Dialog();
?>