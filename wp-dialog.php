<?php 
/*
Plugin Name: WP Dialog
Plugin URI:  http://zhangge.net/4718.html
Description: <strong>WordPress友好对话框&底部滚动条插件</strong>，1. 通过这个插件可以为博客增加一个友好的右下角滑动对话框，可以自动判断搜索来路、新老访客(是否留过言)，给出自定义欢迎语句！2. 在博客底部集成随机文章滚动推荐条，并在右侧集成手动呼出对话框、嗨一下按钮；3. 启用这个插件之后还能够在有人复制文章网站内容的时候，弹出转载版权提示；所有功能在设置界面都能灵活地开启或关闭。
Version: 1.2.5.1
Author: 张戈
Author URI: http://zhangge.net/about/
Copyright: 张戈博客原创插件，任何个人或团体不可擅自更改版权。
*/
class WP_Dialog{  
    function __construct(){
            function wp_dialog_bar(){
	            include('scroll-bar.php');
            }  
            add_action( 'wp_footer', 'wp_dialog_bar' );   
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

register_activation_hook(__FILE__, 'wp_dialog_install');
function wp_dialog_install() {
    add_option("so_content", "若当前文章未能解决您的问题，您可以先尝试站内搜索，当然也可以喔(^_^)!", '', 'yes');
    add_option("gu_content", "温馨提示：有需求可以先尝试站内搜索，当然也可以给我留言喔(^_^)!", '', 'yes');
    add_option("st_content", "温馨提示：有需求可以先尝试站内搜索，当然也可以给我留言喔(^_^)!", '', 'yes');
}    
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
    <form accept-charset="GBK" action="https://shenghuo.alipay.com/send/payment/fill.htm" method="POST" target="_blank"><input name="optEmail" type="hidden" value="ge@zhangge.net" />
    <input name="payAmount" type="hidden" value="0" />
    <input id="title" name="title" type="hidden" value="赞助张戈博客" />
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
        if (get_option('wp_dialog_bar')=="" || get_option('wp_dialog_bar')=="display"){
            $display_bar='checked="checked"';
        } else {
            $hidden_bar='checked="checked"';
        }
        //嗨一下
        if (get_option('crazy')=="" || get_option('crazy')=="display"){
            $display_hi='checked="checked"';
        } else {
            $hidden_hi='checked="checked"';
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
        if(get_option('so_content') ==""){
            $so_content = "若当前文章未能解决您的问题，您可以先尝试站内搜索，当然也可以给我留言喔(^_^)!";
        } else {
            $so_content = get_option('so_content');
        }
        if(get_option('gu_content') ==""){
            $gu_content = "温馨提示：有需求可以先尝试站内搜索，当然也可以给我留言喔(^_^)!";
        } else {
            $gu_content = get_option('gu_content');
        }
        if(get_option('st_content') ==""){
            $st_content = "温馨提示：有需求可以先尝试站内搜索，当然也可以给我留言喔(^_^)!";
        } else {
            $st_content = get_option('st_content');
        }
        //Cookies记忆功能
        if (get_option('LoadRememberInfo')=="" || get_option('LoadRememberInfo')=="enabled"){
            $enabled='checked="checked"';
        } else {
            $disabled='checked="checked"';
        }
        
?>
<p><h4>主体对话框功能</h4>
    <input type="radio" name="display_dialog" id="display_dialog" value="display" <?php echo $display_dialog;?>/>
    <label for="display_dialog" style="cursor: pointer;">开启</label>
    <br />
    <input type="radio" name="display_dialog" id="hidden_dialog" value="hidden" <?php echo $hidden_dialog;?>/>
    <label for="hidden_dialog" style="cursor: pointer;">关闭</label>
</p>
<p><h4>设置欢迎内容(支持html语言)</h4>
1). 搜索引擎：<br />
<textarea name="so_content" id="so_content" placeholder="留空则使用插件默认欢迎语..." cols="55" rows="3"><?php echo $so_content;?></textarea><br />
2). 留言熟客：<br />
<textarea name="gu_content" id="gu_content" placeholder="留空则使用插件默认欢迎语..." cols="55" rows="3"><?php echo $gu_content;?></textarea><br />
3). 首次光临：<br />
<textarea name="st_content" id="st_content" placeholder="留空则使用插件默认欢迎语..." cols="55" rows="3"><?php echo $st_content;?></textarea><br />
</p>
<p><h4>底部滚动推荐条</h4>
    <input type="radio" name="wp_dialog_bar" id="display_bar" value="display" <?php echo $display_bar;?>/>
    <label for="display_bar" style="cursor: pointer;">开启</label>
    <br />
    <input type="radio" name="wp_dialog_bar" id="hidden_bar" value="hidden" <?php echo $hidden_bar;?>/>
    <label for="hidden_bar" style="cursor: pointer;">关闭</label>
</p>
<p><h4>让网站嗨一下</h4>
    <input type="radio" name="crazy" id="display_hi" value="display" <?php echo $display_hi;?>/>
    <label for="display_hi" style="cursor: pointer;">开启</label>
    <br />
    <input type="radio" name="crazy" id="hidden_hi" value="hidden" <?php echo $hidden_hi;?>/>
    <label for="hidden_hi" style="cursor: pointer;">关闭</label>
</p>
<p> 歌曲url地址(一行一首)：<br />
<textarea name="music" id="music" placeholder="比如：http://zhagnge.net/music.mp3(推荐将音乐上传到七牛)" cols="55" rows="6"><?php echo get_option('music');?></textarea>
</p>
<span>邮件订阅地址：</span>
    <input type="text" name="Diy_feed" placeholder="比如：http://list.qq.com/cgi-bin/qf_invite?id=71a2f28dff63348c301ded982b0a083857be253891e9bae8" id="guestbook" style="width:322px" value="<?php echo get_option('Diy_feed');?>"/>（留空则使用WP默认订阅）
    
<?php if((get_option('wp_dialog_bar')==""||get_option('wp_dialog_bar')=="display")&&(get_option('display_dialog')=="" || get_option('display_dialog')=="display")){ ?>
<p><h4>手动呼出对话框功能</h4>
    <input type="radio" name="display_button" id="button_display" value="display" <?php echo $button_display;?>/>
    <label for="button_display" style="cursor: pointer;">开启</label>
    <br />
    <input type="radio" name="display_button" id="button_hidden" value="hidden" <?php echo $button_hidden;?>/>
    <label for="button_hidden" style="cursor: pointer;">关闭</label><br /><br />
<p>     
<?php } ?>
<p><h4>复制版权提醒功能</h4>
    <input type="radio" name="copyright_warn" id="enabled" value="enabled" <?php echo $enabled;?>/>
    <label for="enabled" style="cursor: pointer;">开启</label>
    <br />
    <input type="radio" name="copyright_warn" id="disabled" value="disabled" <?php echo $disabled;?>/>
    <label for="disabled" style="cursor: pointer;">关闭</label>
</p>
<p><h4>Cookies记忆功能</h4>
    <input type="radio" name="LoadRememberInfo" id="enabled" value="enabled" <?php echo $enabled;?>/>
    <label for="enabled" style="cursor: pointer;">开启</label>
    <br />
    <input type="radio" name="LoadRememberInfo" id="disabled" value="disabled" <?php echo $disabled;?>/>
    <label for="disabled" style="cursor: pointer;">关闭</label>
</p> 
    <br />
    <input type="hidden" name="action" value="update" />   
    <input type="hidden" name="page_options" value="display_dialog,wp_dialog_bar,crazy,display_button,copyright_warn,guestbook,music,Diy_feed,so_content,gu_content,st_content" />
    <input type="submit" value="保存设置" class="button-primary" />
</p>   
</form>
</div>
<?php } ?>