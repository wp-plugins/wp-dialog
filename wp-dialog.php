<?php 
/*
Plugin Name: WP-Dialog
Plugin URI:  http://zhangge.net/4718.html
Description: <strong>WordPress友好对话框&底部底部滚动推荐条插件</strong>，1. 通过这个插件可以为博客增加一个友好的右下角滑动对话框，可以自动判断搜索来路、新老访客(是否留过言)，给出不同的欢迎语句！2. 在博客底部集成随机文章滚动推荐条，并在右侧集成手动呼出对话框按钮；3. 启用这个插件之后还能够在有人复制文章网站内容的时候，弹出转载版权提示；所有功能在设置界面都能灵活地开启或关闭。
Version: 1.2.2
Author: 张戈
Author URI: http://zhangge.net/about/
Copyright: 张戈博客原创插件，任何个人或团体不可擅自更改版权。
*/
class WP_Dialog{  
    function __construct(){
            function scroll_bar(){
	            include('scroll-bar.php');
            }  
            add_action( 'wp_footer', 'scroll_bar' );   
add_filter('plugin_action_links', 'WP_Dialog_plugin_action_links', 10, 3);
function WP_Dialog_plugin_action_links($action_links, $plugin_file, $plugin_info) {
    $this_file = basename(__FILE__);
    if(substr($plugin_file, -strlen($this_file))==$this_file) {
        $new_action_links = array(
        "<a href='options-general.php?page=wp_dialog'>设置</a>"
        );
        foreach($action_links as $action_link) {
        if (stripos($action_link, '>Edit<')===false) {
            if (stripos($action_link, '>Deactivate<')!==false) {
                $new_action_links[] = $action_link;
            } else {
                $new_action_links[] = $action_link;
                    }
                }
            }
    return $new_action_links;
        }
  return $action_links;
        }            
    }
}  
new WP_Dialog();
?>
<?php   
if( is_admin() ) {   
    add_action('admin_menu', 'display_wp_dialog_menu');   
}   
function display_wp_dialog_menu() {   
    add_options_page('WP_Dialog友好对话框插件设置', 'WP Dialog','administrator','wp_dialog', 'display_wp_dialog_page');
}   
function display_wp_dialog_page() {   
?>   
<div> 
    <div style="width: 420px;"><h2>WP_Dialog友好对话框插件设置</h2>
    <form accept-charset="GBK" action="https://shenghuo.alipay.com/send/payment/fill.htm" method="POST" target="_blank"><input name="optEmail" type="hidden" value="287988783@qq.com" />
    <input name="payAmount" type="hidden" value="0" />
    <input id="title" name="title" type="hidden" value="赞助张戈博客o(∩_∩)o" />
    <input name="memo" type="hidden" value="请填写您的联系方式，以便张戈答谢。" />
    <input title="如果好用，您可以赞助张戈博客" name="pay" src="<?php echo plugins_url('images/payment.png',__FILE__);?>" type="image" value="捐赠共勉" style="float: right;margin-top: -43px;"/>
    </form>
</div>
<form method="post" action="options.php">   
    <?php 
        wp_nonce_field('update-options');
        //主题对话框
        if (get_option('display_dialog')=="" || get_option('display_dialog')=="display"){
            $display_dialog='checked="checked"';
        } else {
            $hidden_dialog='checked="checked"';
        }
        //滚动条
        if (get_option('scroll_bar')=="" || get_option('scroll_bar')=="display"){
            $display='checked="checked"';
        } else {
            $hidden='checked="checked"';
        }
        //手动呼出
        if (get_option('display_button')=="" || get_option('display_button')=="display"){
            $button_display='checked="checked"';
        } else {
            $button_hidden='checked="checked"';
        }
        //版权提醒
        if (get_option('copyright_warn')=="" || get_option('copyright_warn')=="enabled"){
            $enabled='checked="checked"';
        } else {
            $disabled='checked="checked"';
        }        
?>
<p><h3>主体对话框功能</h3>
    <input type="radio" name="display_dialog" id="display_dialog" value="display" <?php echo $display_dialog;?>/>
    <label for="display_dialog" style="cursor: pointer;"><b>开启</b></label>
    <br />
    <input type="radio" name="display_dialog" id="hidden_dialog" value="hidden" <?php echo $hidden_dialog;?>/>
    <label for="hidden_dialog" style="cursor: pointer;"><b>关闭</b></label>
</p>
<p><h3>底部滚动文章推荐条</h3>
    <input type="radio" name="scroll_bar" id="display" value="display" <?php echo $display;?>/>
    <label for="display" style="cursor: pointer;"><b>开启</b></label>
    <br />
    <input type="radio" name="scroll_bar" id="hidden" value="hidden" <?php echo $hidden;?>/>
    <label for="hidden" style="cursor: pointer;"><b>关闭</b></label>
</p> 
<?php if((get_option('scroll_bar')==""||get_option('scroll_bar')=="display")&&(get_option('display_dialog')=="" || get_option('display_dialog')=="display")){ ?>
<p><h3>手动呼出对话框功能</h3>
    <input type="radio" name="display_button" id="button_display" value="display" <?php echo $button_display;?>/>
    <label for="display" style="cursor: pointer;"><b>开启</b></label>
    <br />
    <input type="radio" name="display_button" id="button_hidden" value="hidden" <?php echo $button_hidden;?>/>
    <label for="display" style="cursor: pointer;"><b>关闭</b></label>
<p>     
<?php } ?>
<p><h3>开启复制版权提醒功能</h3>
    <input type="radio" name="copyright_warn" id="enabled" value="enabled" <?php echo $enabled;?>/>
    <label for="enabled" style="cursor: pointer;"><b>开启</b></label>
    <br />
    <input type="radio" name="copyright_warn" id="disabled" value="disabled" <?php echo $disabled;?>/>
    <label for="disabled" style="cursor: pointer;"><b>关闭</b></label>
</p> 
    <br />
    <input type="hidden" name="action" value="update" />   
    <input type="hidden" name="page_options" value="display_dialog,scroll_bar,display_button,copyright_warn" />
    <input type="submit" value="保存设置" class="button-primary" />
</p>   
</form>
</div>
<?php } ?>