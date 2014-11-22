<?php if(get_option('scroll_bar')=="display" || get_option('scroll_bar')=="" ){?>
<div id="gg">
	<div class="close"><a href="javascript:void(0)" onclick="$('#gg').slideUp('slow');" title="关闭">×</a>
	<div id="feedb"><a href="/feed" rel="nofollow" target="_blank" title="欢迎订阅我的博客" class="image"><img alt="订阅图标按钮" src="<?php echo plugins_url('images/feed.gif',__FILE__);?>" style="width:23px;height:23px;" /></a>
<?php if(get_option('display_button')=="display"||get_option('display_button')==""){ ?>
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
			<?php echo '随机推荐：《';the_title();echo '》';if(function_exists('the_views')) {print '( 阅读';the_views();print '次 |</a>';}comments_popup_link('坐等沙发','1条评论','%条评论'); ?>)</li>
			<?php endwhile; ?>
		</ul>
	</div>
</div>
<script type="text/javascript" src="<?php echo plugins_url('scroll_bar.js',__FILE__);?>"></script>
<?php } ?>
<?php if(get_option('copyright_warn')=="enabled"||get_option('copyright_warn')==""){ ?>
<script type="text/javascript">
function warning(){
    if(navigator.userAgent.indexOf("MSIE")>0)  {   
        art.dialog.alert('复制成功！若要转载请务必保留原文链接，谢谢合作！');
    } else {  
        alert("复制成功！若要转载请务必保留原文链接，谢谢合作！");
    }
}
document.body.oncopy=function(){warning();}
</script>
<?php } ?>