<?php
/*
Plugin Name: Vertically scroll rss feed
Description: This plug-in will scroll the RSS feed title vertically in the widget, admin can add/update the RSS link & style via widget management.
Author: Gopi Ramasamy
Version: 9.2
Plugin URI: http://www.gopiplus.com/work/2010/07/18/vertically-scroll-rss-feed/
Author URI: http://www.gopiplus.com/work/2010/07/18/vertically-scroll-rss-feed/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
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
	g_fontColorHover='<?php echo get_option('gVerticalscroll_rssfeed_fontcolor'); ?>';
	g_textDecorationHover='none';
	g_top=0;
	g_left=0;
	g_width=<?php echo get_option('gVerticalscroll_rssfeed_width'); ?>;
	g_height=<?php echo get_option('gVerticalscroll_rssfeed_height'); ?>;
	g_paddingTop=0;
	g_paddingLeft=0;
	g_position='relative';
	g_timeout=<?php echo get_option('gVerticalscroll_rssfeed_slidetimeout'); ?>;
	g_slideSpeed=1;
	g_slideDirection=<?php echo get_option('gVerticalscroll_rssfeed_slidedirection'); ?>;
	g_pauseOnMouseOver=true;
	g_slideStep=1;
	g_textAlign='<?php echo get_option('gVerticalscroll_rssfeed_textalign'); ?>';
	g_textVAlign='<?php echo get_option('gVerticalscroll_rssfeed_textvalign'); ?>';
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
	
	$maxitems = 0;
	$rssscroll = "";
	$mxrf = "";
	include_once( ABSPATH . WPINC . '/feed.php' );
	$rss = fetch_feed( $url );
	if ( ! is_wp_error( $rss ) )
	{
    	$cnt = 0;
		$maxitems = $rss->get_item_quantity( 10 ); 
    	$rss_items = $rss->get_items( 0, $maxitems );
		if ( $maxitems > 0 )
		{
			foreach ( $rss_items as $item )
			{
				$links = $item->get_permalink();
				$title = esc_sql($item->get_title());				
				$myLink =  '<a target="_blank" href="'.$links.'">'.$title.'</a>';
				$rssscroll = $rssscroll . "['','".$myLink."',''],";
				$cnt = $cnt + 1;
			}
		}
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
	
	if (isset($_POST['gVerticalscroll_rssfeed_submit'])) 
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
			<td colspan="3"><?php _e('Enter URL', 'vertically-scroll-rss-feed'); ?></td>
		  </tr>
		  <tr>
			<td colspan="3"><input name='gVerticalscroll_rssfeed_url' type='text' id='gVerticalscroll_rssfeed_url'  value='<?php echo $gVerticalscroll_rssfeed_url; ?>' size="60" /></td>
		  </tr>
		  <tr>
			<td width="275"><?php _e('Title', 'vertically-scroll-rss-feed'); ?></td>
			<td width="10">&nbsp;</td>
			<td width="275"><?php _e('Width (only number)', 'vertically-scroll-rss-feed'); ?></td>
		  </tr>
		  <tr>
			<td><input name='gVerticalscroll_rssfeed_title' type='text' id='gVerticalscroll_rssfeed_title'  value='<?php echo $gVerticalscroll_rssfeed_title; ?>' size="20" maxlength="100" /></td>
			<td>&nbsp;</td>
			<td><input name='gVerticalscroll_rssfeed_width' type='text' id='gVerticalscroll_rssfeed_width'  value='<?php echo $gVerticalscroll_rssfeed_width; ?>' size="20" maxlength="3" /></td>
		  </tr>
		  <tr>
			<td><?php _e('Font', 'vertically-scroll-rss-feed'); ?></td>
			<td>&nbsp;</td>
			<td><?php _e('Height (only number)', 'vertically-scroll-rss-feed'); ?></td>
		  </tr>
		  <tr>
			<td><input name='gVerticalscroll_rssfeed_font'  type='text' id='gVerticalscroll_rssfeed_font' value='<?php echo $gVerticalscroll_rssfeed_font; ?>' size="20" /></td>
			<td>&nbsp;</td>
			<td><input name='gVerticalscroll_rssfeed_height' type='text' id='gVerticalscroll_rssfeed_height'  value='<?php echo $gVerticalscroll_rssfeed_height; ?>' size="20" maxlength="3" /></td>
		  </tr>
		  <tr>
			<td><?php _e('Font Size (Ex:13px)', 'vertically-scroll-rss-feed'); ?></td>
			<td>&nbsp;</td>
			<td><?php _e('Slide Direction(0=down-up;1=up-down)', 'vertically-scroll-rss-feed'); ?></td>
		  </tr>
		  <tr>
			<td><input name='gVerticalscroll_rssfeed_fontsize' type='text' id='gVerticalscroll_rssfeed_fontsize'  value='<?php echo $gVerticalscroll_rssfeed_fontsize; ?>' size="20" maxlength="6" /></td>
			<td>&nbsp;</td>
			<td><input name='gVerticalscroll_rssfeed_slidedirection' type='text' id='gVerticalscroll_rssfeed_slidedirection'  value='<?php echo $gVerticalscroll_rssfeed_slidedirection; ?>' size="20" maxlength="1" /></td>
		  </tr>
		  <tr>
			<td><?php _e('Font Weight(blod/normal)', 'vertically-scroll-rss-feed'); ?></td>
			<td>&nbsp;</td>
			<td><?php _e('Slide Timeout (1000=1 second)', 'vertically-scroll-rss-feed'); ?></td>
		  </tr>
		  <tr>
			<td><input name='gVerticalscroll_rssfeed_fontweight' type='text' id='gVerticalscroll_rssfeed_fontweight'  value='<?php echo $gVerticalscroll_rssfeed_fontweight; ?>' size="20" maxlength="10" /></td>
			<td>&nbsp;</td>
			<td><input name='gVerticalscroll_rssfeed_slidetimeout' type='text' id='gVerticalscroll_rssfeed_slidetimeout'  value='<?php echo $gVerticalscroll_rssfeed_slidetimeout; ?>' size="20" maxlength="5" /></td>
		  </tr>
		  <tr>
			<td><?php _e('Font Color (Ex: #000000)', 'vertically-scroll-rss-feed'); ?></td>
			<td>&nbsp;</td>
			<td><?php _e('Text Valign (top/middle/bottom)', 'vertically-scroll-rss-feed'); ?></td>
		  </tr>
		  <tr>
			<td><input name='gVerticalscroll_rssfeed_fontcolor' type='text' id='gVerticalscroll_rssfeed_fontcolor'  value='<?php echo $gVerticalscroll_rssfeed_fontcolor; ?>' size="20" maxlength="20" /></td>
			<td>&nbsp;</td>
			<td><input name='gVerticalscroll_rssfeed_textvalign' type='text' id='gVerticalscroll_rssfeed_textvalign'  value='<?php echo $gVerticalscroll_rssfeed_textvalign; ?>' size="20" maxlength="6" /></td>
		  </tr>
		  <tr>
			<td><?php _e('No Announcement Text', 'vertically-scroll-rss-feed'); ?></td>
			<td>&nbsp;</td>
			<td><?php _e('Text Alignt (left/center/right)', 'vertically-scroll-rss-feed'); ?></td>
		  </tr>
		  <tr>
			<td><input name='gVerticalscroll_rssfeed_noannouncement' type='text' id='gVerticalscroll_rssfeed_noannouncement'  value='<?php echo $gVerticalscroll_rssfeed_noannouncement; ?>' size="20" maxlength="200" /></td>
			<td>&nbsp;</td>
			<td><input name='gVerticalscroll_rssfeed_textalign' type='text' id='gVerticalscroll_rssfeed_textalign'  value='<?php echo $gVerticalscroll_rssfeed_textalign; ?>' size="20" maxlength="6" />
			<input type="hidden" id="gVerticalscroll_rssfeed_submit" name="gVerticalscroll_rssfeed_submit" value="1" /></td>
		  </tr>
		</table>
	  <br /><?php _e('Check official website for more information', 'vertically-scroll-rss-feed'); ?> 
	  <a target="_blank" href="http://www.gopiplus.com/work/2010/07/18/vertically-scroll-rss-feed/"><?php _e('Click here', 'vertically-scroll-rss-feed'); ?></a> <br /> <br />
	<?php
}

function gVerticalscroll_rssfeed_widget_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget(__('Scroll RSS feed', 'vertically-scroll-rss-feed'), 
				__('Scroll RSS feed', 'vertically-scroll-rss-feed'), 'gVerticalscroll_rssfeed_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control(__('Scroll RSS feed', 'vertically-scroll-rss-feed'), 
				array(__('Scroll RSS feed', 'vertically-scroll-rss-feed'), 'widgets'), 'gVerticalscroll_rssfeed_control', 'width=550');
	} 
}

function gVerticalscroll_rssfeed_deactivation() 
{
	// No required
}

function gVerticalscroll_textdomain()
{
	load_plugin_textdomain( 'vertically-scroll-rss-feed', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'gVerticalscroll_textdomain');
add_action("plugins_loaded", "gVerticalscroll_rssfeed_widget_init");
register_activation_hook(__FILE__, 'gVerticalscroll_rssfeed_install');
register_deactivation_hook(__FILE__, 'gVerticalscroll_rssfeed_deactivation');
add_action('init', 'gVerticalscroll_rssfeed_widget_init');
?>