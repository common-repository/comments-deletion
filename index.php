<?php

/*
  Plugin Name: Comments Deletion
  Plugin URI: https://arrowdesign.ie/comments-deletion/
  Description: Comments deletion is a plugin that quickly removes all comments and resets the comment count icon. Administrators can quickly remove ALL comments...simple.
  Tags: Comments, deleting, spam comments removal
  Version: 2.5
  Author: Arrow Design
  Author URI: https://arrowdesign.ie
 */

// Exit if accessed directly
  if (!defined('ABSPATH'))
    exit;

/*
* Admin panel for deleting comments from wordpress
*
*/
include_once 'admin/admin.php';

/*
* Hook function for deletion of comments from
* wordpress database
*/


function arrowdesign_ie_comment_deletion_main(){
//silence is golden
}//end function

//add settings link to plugin page
function arrowd_delete_all_the_comments_settings_link($links) {
	$settings_link_ad_plugin_deleteallthecomments_Options  = '<a href="options-general.php?page=arrowd_delete_all_comments.php">Settings</a>';
	array_unshift($links, $settings_link_ad_plugin_deleteallthecomments_Options );
	return $links;
}
$plugin_arrowd_delete_all_the_comments = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin_arrowd_delete_all_the_comments", 'arrowd_delete_all_the_comments_settings_link' );

//add documentation link and support link to plugin page
function arrowddub_delete_all_the_comments_page_doc_meta( $arrowd_delete_all_the_comments_plugin_links, $file ) {
	if ( plugin_basename( __FILE__ ) == $file )
		{
			$arrowd_plugin_row_meta_delete_all_the_comments = array(
			'arrowd_delete_all_the_comments_docs'    => '<a href="' . esc_url( 'https://arrowdesign.ie/comments-deletion/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Plugin Additional Links', 'domain' ) . '" >' . esc_html__( 'Documentation', 'domain' ) . '</a>',
			'arrowd_ delete_all_the_comments _support'    => '<a href="' . esc_url( 'https://arrowdesign.ie/contact-arrow-design-2/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Plugin Additional Links', 'domain' ) . '" >' . esc_html__( 'Support', 'domain' ) . '</a>'
			);
			return is_null($arrowd_delete_all_the_comments_plugin_links) ? $arrowd_plugin_row_meta_delete_all_the_comments : array_merge( $arrowd_delete_all_the_comments_plugin_links, $arrowd_plugin_row_meta_delete_all_the_comments );
		}
	return (array) $arrowd_delete_all_the_comments_plugin_links;
}
add_filter( 'plugin_row_meta', 'arrowddub_delete_all_the_comments_page_doc_meta', 10, 2 );