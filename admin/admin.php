<?php
/*
** adding necessary files
*/

function arrowdesign_add_delete_all_the_comments_Style_script() {

		$plugin_url = plugin_dir_url( __FILE__ );

		wp_enqueue_style( 'style',  $plugin_url . 'css/style.css');
		wp_enqueue_script('arrowdesign_delete_all_the_comments_logic_file', plugins_url('/js/logic.js',__FILE__ ));
	}

	add_action('wp_enqueue_scripts', 'arrowdesign_add_delete_all_the_comments_Style_script');

/**
 * Adds a new settings page under Setting menu
*/
	add_action( 'admin_menu', 'arrowdesign__d_a_t_c__admin_page' );
	function arrowdesign__d_a_t_c__admin_page() {
		//only editor and administrator can edit
		if( current_user_can('editor') || current_user_can('administrator') ) {
		add_options_page( __( 'Comments Deletion' ), __( 'Comments Deletion' ), 'manage_options', 'arrowd_delete_all_comments', 'arrowd_delete_all_comments_homepage' );
	}
	}


function arrowd_delete_all_comments_homepage(){

//declaration
	global $wpdb;



			//get current counts as vars


		$comments_count = wp_count_comments();


		$arrowd_count_of_all_comments_var = $comments_count->total_comments;
		$arrowd_count_of_Approved_comments_var = $comments_count->approved;
		$arrowd_count_of_Spam_comments_var = $comments_count->spam;
		$arrowd_count_of_Trash_comments_var= $comments_count->trash;

	if (is_null($arrowd_count_of_all_comments_var)){$arrowd_count_of_all_comments_var=0; }
	if (is_null($arrowd_count_of_Approved_comments_var)){$arrowd_count_of_all_comments_var=0; }
	if (is_null($arrowd_count_of_Spam_comments_var)){$arrowd_count_of_all_comments_var=0; }
	if (is_null($arrowd_count_of_Trash_comments_var)){$arrowd_count_of_all_comments_var=0; }





    ?>


	  <div class="intro_text_class" >
        	<h3>Dashboard for deleting all wordpress comments.</h3>
			<p>Click the following link to contact Arrow Design for <span>
		    <a href="https://arrowdesign.ie">Web Design</a>, Support or WordPress Plugin Development.
        </span></p>

    </div>

	  <div class="tabbedElements_firstTab"  >


        	<!--First tab -->
        </div>

<div class="container_for_left_and_right">
<div class="container_left" >
        			<h3>Instructions </h3>
					<h4>Review your current comment count</h4>
					<h4>Use the radio buttons to make your selection</h4>
					<h4>Use the Delete Selected button to delete the comments</h4>
	<br>
					<h3>Notes: </h3>
					<h4><span style="color:red">You Will Not Be Given Any Further Warnings</span></h4>
					<h4><b>Clicking Delete Will Delete All Selected Comments</b></h4>
					<h4><b><a href="" style="background-color: #6666ff; color: white; border-radius: 10px; padding: 6px; margin-right: 2px; border: 1px solid black; font-weight: bold;">Refresh the page</a> to see results</b></h4>




        		</div>


				<div class="container_right" >
        <?php

		if (isset($_POST['btn-to-delete-all-the-comments-no-further-warning'])) {

			$countOfSuccessfulDeletions = 0;
			$selected_radio_value = sanitize_text_field($_POST['delete_comments_radio']);

		if ($selected_radio_value == 'delete_all_the_comments'){

			   if($wpdb->query("TRUNCATE $wpdb->commentmeta") != FALSE){
				   $countOfSuccessfulDeletions = $countOfSuccessfulDeletions + 1;
                    if($wpdb->query("TRUNCATE $wpdb->comments") != FALSE){
						$countOfSuccessfulDeletions = $countOfSuccessfulDeletions + 1;

                        if(    $wpdb->query("Update $wpdb->posts set comment_count = 0 where post_author != 0")){

						}
                            if($wpdb->query("OPTIMIZE TABLE $wpdb->commentmeta")){
								}
                            if($wpdb->query("OPTIMIZE TABLE $wpdb->comments")){
								}
					}					//end if truncate meta

				   if($countOfSuccessfulDeletions == 2) {echo 'All Comments Deleted, Refresh Page To View Results';}
			   }//end if delete is true

		if(arrowd_updateThecommentReadout()){echo'comment count reset';}
		}


		if ($selected_radio_value == 'delete_all_trash_comments'){
   if($wpdb->query("DELETE FROM $wpdb->comments WHERE comment_approved = 'trash'") != FALSE){
                            $wpdb->query("Update $wpdb->posts set comment_count = 0 where post_author != 0");
                            $wpdb->query("OPTIMIZE TABLE $wpdb->comments");
							if ( get_option( '_transient_as_comment_count' ) !== false ) {
						      // The option already exists, so we just update it.
						      update_option( '_transient_as_comment_count', "" );
                             }
   }
			arrowd_updateThecommentReadout();

			echo 'Trash Comments Deleted, Refresh Page To View Results';
		}//end if delete all trash


		if ($selected_radio_value == 'delete_all_approved_comments'){

			  if($wpdb->query("DELETE FROM $wpdb->comments WHERE comment_approved = 1") != FALSE){
                            $wpdb->query("Update $wpdb->posts set comment_count = 0 where post_author != 0");
                            $wpdb->query("OPTIMIZE TABLE $wpdb->comments");

							if ( get_option( '_transient_as_comment_count' ) !== false ) {
						      // The option already exists, so we just update it.
						      update_option( '_transient_as_comment_count', "" );
                             }
			  }

		arrowd_updateThecommentReadout();
		echo 'Trash Comments Deleted, Refresh Page To View Results';
		} // end if delete all approved




		if ($selected_radio_value == 'delete_all_spam_comments'){
   if($wpdb->query("DELETE FROM $wpdb->comments WHERE comment_approved = 'spam'") != FALSE){
                            $wpdb->query("Update $wpdb->posts set comment_count = 0 where post_author != 0");
                            $wpdb->query("OPTIMIZE TABLE $wpdb->comments");
                           if ( get_option( '_transient_as_comment_count' ) !== false ) {
						      // The option already exists, so we just update it.
						      update_option( '_transient_as_comment_count', "" );
                             }
   }

		arrowd_updateThecommentReadout();

		echo 'Spam Comments Deleted, Refresh Page To View Results';
		}// end if delete all spam

	}//end if button was clicked



		//form for saving and displaying the text

		?>
		<!-- form to handle the deletion and display comment counts -->
 <br/>
					<h2 class="enter-text" > <span class="enter-text-span">Your Current Comment Count:</span></h2>
				 <form method="POST" action="">
<div class="center-table" style="text-align: center; margin: auto; display: flex; justify-content: center;">
<table style="border : 1px solid black; font-weight:bold;">

	<tr>
            <th bgcolor="green" colspan="3" style="color: white;background-color: #a10606;height: 3vw;font-size: 20px;">Remove Comments Options</th>

        </tr>
	<tr>
            <th style="padding-left: 10px; padding-right: 10px; height: 2vw; color: #ffffff; background-color: #000000;">Type/Count</th>
            <th colspan="2" style="padding-left: 10px; padding-right: 10px; height: 2vw; color: #ffffff; background-color: #000000;">Selection (If Available)</th>
        </tr>
	<tr>
		<td style="border-bottom: 1px solid black;height: 2vw;">
<label class="drod_focb-ad" for="text-for-focb-ad" >Count Of All Comments: = <?php echo  esc_html($arrowd_count_of_all_comments_var); ?></label>
		</td>
		<td style="border-bottom: 1px solid black;height: 2vw;"></td>
		<td style="border-bottom: 1px solid black; text-align: center;height: 2vw;">
<input type="radio" id="delete_all_the_comments" name="delete_comments_radio" required <?php if($arrowd_count_of_all_comments_var<=0) { echo 'disabled' ;  } ?>  value="delete_all_the_comments"><br>
		</td>
	</tr>

	<tr>
		<td style="border-bottom: 1px solid black;height: 2vw;">
<label class="drod_focb-ad" for="text-for-focb-ad" >Count Of Trash Comments: = <?php echo  esc_html($arrowd_count_of_Trash_comments_var); ?></label>
		</td>
			<td style="border-bottom: 1px solid black;height: 2vw;"></td>
		<td style="border-bottom: 1px solid black; text-align: center;height: 2vw;">
<input type="radio" id="delete_all_trash_comments" name="delete_comments_radio" required <?php if($arrowd_count_of_Trash_comments_var<=0) { echo 'disabled' ;  } ?>  value="delete_all_trash_comments"><br>
		</td>
</tr>


	<tr>
		<td style="border-bottom: 1px solid black;height: 2vw;">
<label class="drod_focb-ad" for="text-for-focb-ad" >Count Of Approved Comments: = <?php echo  esc_html($arrowd_count_of_Approved_comments_var); ?></label>
		</td>
			<td style="border-bottom: 1px solid black;height: 2vw;"></td>
		<td style="border-bottom: 1px solid black; text-align: center;height: 2vw;">
<input type="radio" id="delete_all_approved_comments" name="delete_comments_radio" required <?php if($arrowd_count_of_Approved_comments_var<=0) { echo 'disabled' ;  } ?>  value="delete_all_approved_comments"><br>
		</td>
	</tr>


		<tr>
			<td style="border-bottom: 1px solid black;height: 2vw;">
<label class="drod_focb-ad" for="text-for-focb-ad" >Count Of Spam Comments: = <?php echo  esc_html($arrowd_count_of_Spam_comments_var); ?></label>
			</td>
				<td style="border-bottom: 1px solid black;height: 2vw;"></td>
			<td style="border-bottom: 1px solid black; text-align: center;height: 2vw;">
<input type="radio" id="delete_all_spam_comments" name="delete_comments_radio" required <?php if($arrowd_count_of_Spam_comments_var<=0) { echo 'disabled' ;  } ?>  value="delete_all_spam_comments"><br>
			</td>
	</tr>



					 <br>
	<tr style="height:4vw;">

		<td colspan="3">
			<div class="center-btn" style="text-align: center; margin: auto; display: flex; justify-content: center;">
				<button class="button-primary-update-names-and-titles" name="btn-to-delete-all-the-comments-no-further-warning" type="submit" style="margin-right: 0;">DELETE SELECTED COMMENTS</button>			</div>
       </td>
	</tr>
					 </table>
	</div>
					</form>

        		</div>

        		</div>



        <?php


}

//update the comment count -->start
function arrowd_updateThecommentReadout(){
global $wpdb;

$getcount=$wpdb->get_results("select comment_post_ID, count(comment_post_ID) as cnt FROM $wpdb->comments group by comment_post_ID HAVING COUNT(comment_post_ID) > 0");
          if(!empty($getcount))   {
          // output data of each row
          foreach($getcount as $getcount1)
          {
              $ccid= $getcount1->comment_post_ID;
              $cc= $getcount1->cnt;
              $wpdb->query($wpdb->prepare("UPDATE $wpdb->posts
                SET comment_count='%s'
                WHERE ID = %s",$cc,$ccid));
            }

		}//end if count not empty
}//end function

//update the comment count -->end



function arrowd_datc_load_custom_wp_admin_style() {

	$plugin_url = plugin_dir_url( __FILE__ );

        wp_register_style( 'custom_css', $plugin_url . 'css/style.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_css' );


        wp_enqueue_script( 'my_script', $plugin_url .  'logic.js' );
}
add_action( 'admin_enqueue_scripts', 'arrowd_datc_load_custom_wp_admin_style' );