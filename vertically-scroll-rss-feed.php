<?php

/*
Plugin Name: Vertically scroll rss feed
Description: This plug-in will scroll the RSS feed title vertically in site sidebar, admin can add/update the RSS link & style via widget management.
Author: Gopi.R
Version: 4.0
Plugin URI: http://www.gopiplus.com/work/2010/07/18/vertically-scroll-rss-feed/
Author URI: http://www.gopiplus.com/work/2010/07/18/vertically-scroll-rss-feed/
*/

function gVerticalscroll_rss()
{
	
	?>
	<script language="JavaScript" type="text/javascript">
	g_font='<?php echo get_option('gVerticalscroll_rssfeed_font'); ?>';
	g_fontSize='<?php echo get_option('gVerticalscroll_rssfeed_fontsize'); ?>';
	g_fontSizeNS4='<?php echo get_option('gVerticalscroll_rssfeed_fontsize'); ?>';
	g_fontWeight='<?php echo get_option('gVerticalscroll_rssfeed_fontweight'); ?>';
	g_fontColor='<?php echo get_option('gVerticalscroll_rssfeed_fontcolor'); ?>';
	g_textDecoration='none';
	g_fontColorHover='<?php echo get_option('gVerticalscroll_rssfeed_fontcolor'); ?>';//		| won't work
	g_textDecorationHover='none';//	| in Netscape4
	g_top=0;//	|
	g_left=0;//	| defining
	g_width=<?php echo get_option('gVerticalscroll_rssfeed_width'); ?>;//	| the box
	g_height=<?php echo get_option('gVerticalscroll_rssfeed_height'); ?>;//	|
	g_paddingTop=0;
	g_paddingLeft=0;
	g_position='relative';// absolute/relative
	g_timeout=<?php echo get_option('gVerticalscroll_rssfeed_slidetimeout'); ?>;//1000 = 1 second
	g_slideSpeed=1;
	g_slideDirection=<?php echo get_option('gVerticalscroll_rssfeed_slidedirection'); ?>;//0=down-up;1=up-down
	g_pauseOnMouseOver=true;// v2.2+ new below
	g_slideStep=1;//pixels
	g_textAlign='<?php echo get_option('gVerticalscroll_rssfeed_textalign'); ?>';// left/center/right
	g_textVAlign='<?php echo get_option('gVerticalscroll_rssfeed_textvalign'); ?>';// top/middle/bottom - won't work in Netscape4
	g_bgColor='transparent';
	</script>
	<?php
	if(get_option('gVerticalscroll_rssfeed_url') <> "")
	{
		$url = get_option('gVerticalscroll_rssfeed_url');
	}
	else
	{
		$url = "http://wordpress.org/development/feed/";
	}
	$xml = "";
	$cnt=0;
	$f = fopen( $url, 'r' );
	while( $data = fread( $f, 4096 ) ) { $xml .= $data; }
	fclose( $f );
	preg_match_all( "/\<item\>(.*?)\<\/item\>/s", $xml, $itemblocks );
	foreach( $itemblocks[1] as $block )
	{
		$cnt++;
		if($cnt==10)
		{
			break;
		}
		preg_match_all( "/\<title\>(.*?)\<\/title\>/",  $block, $title );
		preg_match_all( "/\<link\>(.*?)\<\/link\>/", $block, $link );
		
		$myLink =  '<a target="_blank" href="'.$link[1][0].'">'.addslashes($title[1][0]).'</a>';
		$rssscroll = $rssscroll . "['','".$myLink."',''],";
	}
	$rssscroll=substr($rssscroll,0,(strlen($rssscroll)-1));
	if($rssscroll == "")
	{
		$rssscroll = "['','".get_option('gVerticalscroll_rssfeed_noannouncement')."',''],['','".get_option('gVerticalscroll_rssfeed_noannouncement')."','']";
	}
	?>
	<div align="center">
	<script language="JavaScript" type="text/javascript">g_content=[<?php echo $rssscroll; ?>];</script>
	<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/vertically-scroll-rss-feed/vertically-scroll-rss-feed.js"></script>
	</div>
	<?php
}

function gVerticalscroll_rssfeed_install() 
{
	add_option('gVerticalscroll_rssfeed_title', "RSS News");
	add_option('gVerticalscroll_rssfeed_font', 'verdana,arial,sans-serif');
	add_option('gVerticalscroll_rssfeed_fontsize', '11px');
	add_option('gVerticalscroll_rssfeed_fontweight', 'normal');
	add_option('gVerticalscroll_rssfeed_fontcolor', '#000000');
	add_option('gVerticalscroll_rssfeed_width', '180');
	add_option('gVerticalscroll_rssfeed_height', '100');
	add_option('gVerticalscroll_rssfeed_slidedirection', '0');
	add_option('gVerticalscroll_rssfeed_slidetimeout', '3000');
	add_option('gVerticalscroll_rssfeed_textalign', 'center');
	add_option('gVerticalscroll_rssfeed_textvalign', 'middle');
	add_option('gVerticalscroll_rssfeed_noannouncement', 'No content available');
	$rss2_url = get_option('home'). "/?feed=rss2";
	add_option('gVerticalscroll_rssfeed_url', $rss2_url);
}

function gVerticalscroll_rssfeed_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('gVerticalscroll_rssfeed_title');
	echo $after_title;
	gVerticalscroll_rss();
	echo $after_widget;
}
	
function gVerticalscroll_rssfeed_control() 
{

	$gVerticalscroll_rssfeed_title = get_option('gVerticalscroll_rssfeed_title');
	$gVerticalscroll_rssfeed_width = get_option('gVerticalscroll_rssfeed_width');
	$gVerticalscroll_rssfeed_font = get_option('gVerticalscroll_rssfeed_font');
	$gVerticalscroll_rssfeed_height = get_option('gVerticalscroll_rssfeed_height');
	$gVerticalscroll_rssfeed_fontsize = get_option('gVerticalscroll_rssfeed_fontsize');
	$gVerticalscroll_rssfeed_slidedirection = get_option('gVerticalscroll_rssfeed_slidedirection');
	$gVerticalscroll_rssfeed_fontweight = get_option('gVerticalscroll_rssfeed_fontweight');
	$gVerticalscroll_rssfeed_slidetimeout = get_option('gVerticalscroll_rssfeed_slidetimeout');
	$gVerticalscroll_rssfeed_fontcolor = get_option('gVerticalscroll_rssfeed_fontcolor');
	$gVerticalscroll_rssfeed_textalign = get_option('gVerticalscroll_rssfeed_textalign');
	$gVerticalscroll_rssfeed_textvalign = get_option('gVerticalscroll_rssfeed_textvalign');
	$gVerticalscroll_rssfeed_noannouncement = get_option('gVerticalscroll_rssfeed_noannouncement');
	$gVerticalscroll_rssfeed_url = get_option('gVerticalscroll_rssfeed_url');
	
	if ($_POST['gVerticalscroll_rssfeed_submit']) 
	{	
		$gVerticalscroll_rssfeed_title = stripslashes($_POST['gVerticalscroll_rssfeed_title']);
		$gVerticalscroll_rssfeed_width = stripslashes($_POST['gVerticalscroll_rssfeed_width']);
		$gVerticalscroll_rssfeed_font = stripslashes($_POST['gVerticalscroll_rssfeed_font']);
		$gVerticalscroll_rssfeed_height = stripslashes($_POST['gVerticalscroll_rssfeed_height']);
		$gVerticalscroll_rssfeed_fontsize = stripslashes($_POST['gVerticalscroll_rssfeed_fontsize']);
		$gVerticalscroll_rssfeed_slidedirection = stripslashes($_POST['gVerticalscroll_rssfeed_slidedirection']);
		$gVerticalscroll_rssfeed_fontweight = stripslashes($_POST['gVerticalscroll_rssfeed_fontweight']);
		$gVerticalscroll_rssfeed_slidetimeout = stripslashes($_POST['gVerticalscroll_rssfeed_slidetimeout']);
		$gVerticalscroll_rssfeed_fontcolor = stripslashes($_POST['gVerticalscroll_rssfeed_fontcolor']);
		$gVerticalscroll_rssfeed_textalign = stripslashes($_POST['gVerticalscroll_rssfeed_textalign']);
		$gVerticalscroll_rssfeed_textvalign = stripslashes($_POST['gVerticalscroll_rssfeed_textvalign']);
		$gVerticalscroll_rssfeed_noannouncement = stripslashes($_POST['gVerticalscroll_rssfeed_noannouncement']);
		$gVerticalscroll_rssfeed_url = stripslashes($_POST['gVerticalscroll_rssfeed_url']);
		
		update_option('gVerticalscroll_rssfeed_title', $gVerticalscroll_rssfeed_title );
		update_option('gVerticalscroll_rssfeed_width', $gVerticalscroll_rssfeed_width );
		update_option('gVerticalscroll_rssfeed_font', $gVerticalscroll_rssfeed_font );
		update_option('gVerticalscroll_rssfeed_height', $gVerticalscroll_rssfeed_height );
		update_option('gVerticalscroll_rssfeed_fontsize', $gVerticalscroll_rssfeed_fontsize );
		update_option('gVerticalscroll_rssfeed_slidedirection', $gVerticalscroll_rssfeed_slidedirection );
		update_option('gVerticalscroll_rssfeed_fontweight', $gVerticalscroll_rssfeed_fontweight );
		update_option('gVerticalscroll_rssfeed_slidetimeout', $gVerticalscroll_rssfeed_slidetimeout );
		update_option('gVerticalscroll_rssfeed_fontcolor', $gVerticalscroll_rssfeed_fontcolor );
		update_option('gVerticalscroll_rssfeed_textalign', $gVerticalscroll_rssfeed_textalign );
		update_option('gVerticalscroll_rssfeed_textvalign', $gVerticalscroll_rssfeed_textvalign );
		update_option('gVerticalscroll_rssfeed_noannouncement', $gVerticalscroll_rssfeed_noannouncement );
		update_option('gVerticalscroll_rssfeed_url', $gVerticalscroll_rssfeed_url );
	}
		?>
		<table width='560' border='0' cellspacing='0' cellpadding='3'>
		  <tr>
			<td colspan="3">Enter URL</td>
		  </tr>
		  <tr>
			<td colspan="3"><input name='gVerticalscroll_rssfeed_url' type='text' id='gVerticalscroll_rssfeed_url'  value='<?php echo $gVerticalscroll_rssfeed_url; ?>' size="70" /></td>
		  </tr>
		  <tr>
			<td width="275">Title</td>
			<td width="10">&nbsp;</td>
			<td width="275">Width (only number)</td>
		  </tr>
		  <tr>
			<td><input name='gVerticalscroll_rssfeed_title' type='text' id='gVerticalscroll_rssfeed_title'  value='<?php echo $gVerticalscroll_rssfeed_title; ?>' size="30" maxlength="100" /></td>
			<td>&nbsp;</td>
			<td><input name='gVerticalscroll_rssfeed_width' type='text' id='gVerticalscroll_rssfeed_width'  value='<?php echo $gVerticalscroll_rssfeed_width; ?>' size="30" maxlength="3" /></td>
		  </tr>
		  <tr>
			<td>Font </td>
			<td>&nbsp;</td>
			<td>Height (only number)</td>
		  </tr>
		  <tr>
			<td><input name='gVerticalscroll_rssfeed_font'  type='text' id='gVerticalscroll_rssfeed_font' value='<?php echo $gVerticalscroll_rssfeed_font; ?>' size="30" /></td>
			<td>&nbsp;</td>
			<td><input name='gVerticalscroll_rssfeed_height' type='text' id='gVerticalscroll_rssfeed_height'  value='<?php echo $gVerticalscroll_rssfeed_height; ?>' size="30" maxlength="3" /></td>
		  </tr>
		  <tr>
			<td>Font Size (Ex:13px)</td>
			<td>&nbsp;</td>
			<td>Slide Direction(0=down-up;1=up-down)</td>
		  </tr>
		  <tr>
			<td><input name='gVerticalscroll_rssfeed_fontsize' type='text' id='gVerticalscroll_rssfeed_fontsize'  value='<?php echo $gVerticalscroll_rssfeed_fontsize; ?>' size="30" maxlength="6" /></td>
			<td>&nbsp;</td>
			<td><input name='gVerticalscroll_rssfeed_slidedirection' type='text' id='gVerticalscroll_rssfeed_slidedirection'  value='<?php echo $gVerticalscroll_rssfeed_slidedirection; ?>' size="30" maxlength="1" /></td>
		  </tr>
		  <tr>
			<td>Font Weight(blod/normal)</td>
			<td>&nbsp;</td>
			<td>Slide Timeout (1000=1 second)</td>
		  </tr>
		  <tr>
			<td><input name='gVerticalscroll_rssfeed_fontweight' type='text' id='gVerticalscroll_rssfeed_fontweight'  value='<?php echo $gVerticalscroll_rssfeed_fontweight; ?>' size="30" maxlength="10" /></td>
			<td>&nbsp;</td>
			<td><input name='gVerticalscroll_rssfeed_slidetimeout' type='text' id='gVerticalscroll_rssfeed_slidetimeout'  value='<?php echo $gVerticalscroll_rssfeed_slidetimeout; ?>' size="30" maxlength="5" /></td>
		  </tr>
		  <tr>
			<td>Font Color (Ex: #000000)</td>
			<td>&nbsp;</td>
			<td>Text Valign (top/middle/bottom)</td>
		  </tr>
		  <tr>
			<td><input name='gVerticalscroll_rssfeed_fontcolor' type='text' id='gVerticalscroll_rssfeed_fontcolor'  value='<?php echo $gVerticalscroll_rssfeed_fontcolor; ?>' size="30" maxlength="20" /></td>
			<td>&nbsp;</td>
			<td><input name='gVerticalscroll_rssfeed_textvalign' type='text' id='gVerticalscroll_rssfeed_textvalign'  value='<?php echo $gVerticalscroll_rssfeed_textvalign; ?>' size="30" maxlength="6" /></td>
		  </tr>
		  <tr>
			<td>No Announcement Text</td>
			<td>&nbsp;</td>
			<td>Text Alignt (left/center/right)</td>
		  </tr>
		  <tr>
			<td><input name='gVerticalscroll_rssfeed_noannouncement' type='text' id='gVerticalscroll_rssfeed_noannouncement'  value='<?php echo $gVerticalscroll_rssfeed_noannouncement; ?>' size="30" maxlength="200" /></td>
			<td>&nbsp;</td>
			<td><input name='gVerticalscroll_rssfeed_textalign' type='text' id='gVerticalscroll_rssfeed_textalign'  value='<?php echo $gVerticalscroll_rssfeed_textalign; ?>' size="30" maxlength="6" />
			<input type="hidden" id="gVerticalscroll_rssfeed_submit" name="gVerticalscroll_rssfeed_submit" value="1" /></td>
		  </tr>
		</table>
	  <h2><?php echo wp_specialchars( 'About Plugin' ); ?></h2>
	  Plug-in created by <a target="_blank" href='http://www.gopiplus.com/'>Gopi</a>. <br> 
	  <a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/vertically-scroll-rss-feed/'>Click here</a> to post suggestion or comments or feedback. <br> 
	  <a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/vertically-scroll-rss-feed/'>Click here</a> to see live demo. <br> 
	  <a target="_blank" href='http://www.gopiplus.com/work/plugin-list/'>Click here</a> to download my other plugins. <br> 
	<?php
}

function gVerticalscroll_rssfeed_widget_init()
{
  	register_sidebar_widget(__('Scroll RSS feed'), 'gVerticalscroll_rssfeed_widget');   
	
	if(function_exists('register_sidebar_widget')) 
	{
		register_sidebar_widget('Scroll RSS feed', 'gVerticalscroll_rssfeed_widget');
	}
	
	if(function_exists('register_widget_control')) 
	{
		register_widget_control(array('Scroll RSS feed', 'widgets'), 'gVerticalscroll_rssfeed_control', 560, 500);
	} 
}

function gVerticalscroll_rssfeed_deactivation() 
{
	delete_option('gVerticalscroll_rssfeed_title');
	delete_option('gVerticalscroll_rssfeed_width');
	delete_option('gVerticalscroll_rssfeed_font');
	delete_option('gVerticalscroll_rssfeed_height');
	delete_option('gVerticalscroll_rssfeed_fontsize');
	delete_option('gVerticalscroll_rssfeed_slidedirection');
	delete_option('gVerticalscroll_rssfeed_fontweight');
	delete_option('gVerticalscroll_rssfeed_slidetimeout');
	delete_option('gVerticalscroll_rssfeed_fontcolor');
	delete_option('gVerticalscroll_rssfeed_textalign');
	delete_option('gVerticalscroll_rssfeed_textvalign');
	delete_option('gVerticalscroll_rssfeed_noannouncement');
	delete_option('gVerticalscroll_rssfeed_url');
}

add_action("plugins_loaded", "gVerticalscroll_rssfeed_widget_init");
register_activation_hook(__FILE__, 'gVerticalscroll_rssfeed_install');
register_deactivation_hook(__FILE__, 'gVerticalscroll_rssfeed_deactivation');
add_action('init', 'gVerticalscroll_rssfeed_widget_init');
?>