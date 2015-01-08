<?php if(get_option('display_dialog')=="" || get_option('display_dialog')=="display"){ ?>
<script type="text/javascript" src="<?php echo plugins_url('diydialog.js?ver=1.2.2',__FILE__);?>"></script>
<link rel="stylesheet" href="<?php echo plugins_url('skins/default.css?ver=1.2.2',__FILE__);?>" />
<?php } ?>

<?php if(get_option('scroll_bar')=="display" || get_option('scroll_bar')=="" ){?>
<div id="gg">
	<div class="close"><a href="javascript:void(0)" onclick="$('#gg').slideUp('slow');" title="关闭">×</a>
	<div id="feedb"><a href="<?php if(get_option('Diy_feed')==""){echo "/feed";} else {echo get_option('Diy_feed');}?>" rel="nofollow" target="_blank" title="欢迎订阅我的博客" class="image"><img alt="订阅图标按钮" src="<?php echo plugins_url('images/feed.gif',__FILE__);?>" style="width:23px;height:23px;" /></a>
	
<?php if((get_option('crazy')=="display"||get_option('crazy')=="")&&(get_option('display_dialog')=="" || get_option('display_dialog')=="display")){ ?>
	<a title="亲，点我放松一下吧~！(单击启动，双击或ESC停止)" id="hig" href="javascript:void(0);" onclick="hig();" ondblclick="stopCrazy();"><img src="<?php echo plugins_url('images/crazy.png',__FILE__);?>" style="height:23px;width:22px;margin: -1px 0 0 0"></a>	
<?php } ?>

<?php if((get_option('display_button')=="display"||get_option('display_button')=="")&&(get_option('display_dialog')=="" || get_option('display_dialog')=="display")){ ?>
	<a href="javascript:void(0)" onclick="deleteCookie('welcome');welcome();" title="呼出欢迎对话框"><img src="<?php echo plugins_url('skins/icons/face-happy.png',__FILE__);?>" style="width:23px;height:23px;"></a>
<?php } ?>

	</div>
	<div class="bulletin">
		<ul>
			<?php 
				$loop = new WP_Query( array( 'post_type' => array(post),'orderby' => 'rand','posts_per_page' => 5 ) );
				while ( $loop->have_posts() ) : $loop->the_post();
			?>
			<li><a href="<?php the_permalink(); ?>" target="_blank" title="细看 <?php the_title(); ?>">
			<?php echo '随机推荐：《';the_title();echo '》(';if(function_exists('the_views')) {print ' 阅读';the_views();print '次 |</a>';}comments_popup_link('坐等沙发','1条评论','%条评论'); ?>)</li>
			<?php endwhile; ?>
		</ul>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
function welcome(){
    if (ykey != 'undefined' && ykey != ''&& ykey != null){
        var tipkey = '您搜索的关键词是【'+ykey+'】，';
    } else {
        var tipkey = '';(getCookie('author').match('[\u4e00-\u9fa5a-zA-Z0-9].*')||GetCookie('author'))
    }
    var username = decodeURIComponent(
            (getCookie('author').match('[\u4e00-\u9fa5a-zA-Z0-9].*') || GetCookie('author')
        ) || (
            getCookie('name').match('[\u4e00-\u9fa5a-zA-Z0-9].*') || GetCookie('name')
        ) || (
            getCookie('inpName').match('[\u4e00-\u9fa5a-zA-Z0-9].*') || GetCookie('inpName')
        ) || (
            getCookie('commentposter').match('[\u4e00-\u9fa5a-zA-Z0-9].*') || GetCookie('commentposter')
        ) || null);
    if (search != null) {
        if (username != "null") {
            var title = "【"+username+'】,欢迎从【'+search+'】回来！';
                
        } else {
            var title = '欢迎来自【'+search+'】的朋友！';
        } 
        var content = tipkey+'<?php echo preg_replace('/\'/i','"',get_option('so_content'));?>';
        if (content = ""){
            content = '若当前文章未能解决您的问题，您可以先尝试站内搜索，当然也可以给我留言喔(^_^)!';
        }
        DiyDialog(title,content);
    } else {
        var wel = getCookie('welcome');
        if (username != "null" && wel !='already') {
            var title = '【'+username+'】欢迎回来！';
            var content = '<?php echo preg_replace('/\'/i','"',get_option('gu_content'));?>';
            if (content == ' ' || content == ''){
                content = '温馨提示：有需求可以先尝试站内搜索，当然也可以给我留言喔(^_^)!';
            }
            DiyDialog(title,content);            
        } else if(username == "null" && wel !='already') {
            var title = '您好，欢迎访问我的个人博客！';
            var content = '<?php echo preg_replace('/\'/i','"',get_option('st_content'));?>';
            if (content == ' ' || content == ''){
                content = '温馨提示：有需求可以先尝试站内搜索，当然也可以给我留言喔(^_^)!';
            }
            DiyDialog(title,content);            
        }
        addCookie('welcome','already');
    }
}
<?php if(get_option('guestbook') != ''){ ?>
    var welurl = '<a target="_blank" style="color:#0196e3;" href="<?php echo get_option('guestbook');?>">给我留言</a>';
<?php } else { ?>
        var welurl = '给我留言';
<?php } ?>
<?php if(get_option('copyright_warn')=="enabled"||get_option('copyright_warn')==""){ ?>
function warning(){
    if(navigator.userAgent.indexOf("MSIE")>0)  {   
        art.dialog.alert('复制成功！若要转载请务必保留原文链接，谢谢合作！');
    } else {  
        alert("复制成功！若要转载请务必保留原文链接，谢谢合作！");
    }
}
document.body.oncopy=function(){warning();}
<?php } ?>

<?php if((get_option('crazy')=="display"||get_option('crazy')=="")&&(get_option('display_dialog')=="" || get_option('display_dialog')=="display")){ ?>
var hicss="<?php echo plugins_url('skins/hi.css',__FILE__);?>";
var CrazyMusic=<?php echo json_encode(preg_split('[\n]', get_option('music')));?>;
function KeyMonitor(){ 
    if (event.keyCode == 27){
        stopCrazy()
    }; 
 };
$(document).dblclick(stopCrazy);
$(document).keydown(KeyMonitor);
<?php } ?>
</script>