<?php
/**
 * BuddyBoss - Group Leaders
 *
 * @since BuddyBoss 3.1.1
 * @version 3.1.1
 */

$message_button_args = array(
	'link_text'   => '<i class="bb-icon-l bb-icon-envelope"></i>',
	'button_attr' => array(
		'data-balloon-pos' => 'down',
		'data-balloon'     => esc_html__( 'Message', 'buddyboss-theme' ),
	),
);

$footer_buttons_class = ( bp_is_active( 'friends' ) && bp_is_active( 'messages' ) ) ? 'footer-buttons-on' : '';

$is_follow_active = bp_is_active( 'activity' ) && function_exists( 'bp_is_activity_follow_active' ) && bp_is_activity_follow_active();
$follow_class     = $is_follow_active ? 'follow-active' : '';

if ( bp_group_has_members( 'group_role=admin,mod' ) ) {
	bp_nouveau_group_hook( 'before', 'members_content' );
	bp_nouveau_pagination( 'top' );
	bp_nouveau_group_hook( 'before', 'members_list' );

	$bp_loggedin_user_id = bp_loggedin_user_id();
	?>

	<ul id="members-list" class="<?php bp_nouveau_loop_classes(); ?>">

		<?php
		while ( bp_group_members() ) :
			bp_group_the_member();

			$bp_get_group_member_id = bp_get_group_member_id();

			// Check if members_list_item has content.
			ob_start();
			bp_nouveau_member_hook( '', 'members_list_item' );
			$members_list_item_content = ob_get_contents();
			ob_end_clean();
			$member_loop_has_content = ! empty( $members_list_item_content );
			?>

			<li <?php bp_member_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php echo esc_attr( $bp_get_group_member_id ); ?>" data-bp-item-component="members">
				<div class="list-wrap <?php echo esc_attr( $footer_buttons_class ); ?> <?php echo esc_attr( $follow_class ); ?> <?php echo $member_loop_has_content ? esc_attr( ' has_hook_content' ) : esc_attr( '' ); ?>">

					<div class="list-wrap-inner">
						<div class="item-avatar">
							<a href="<?php bp_group_member_domain(); ?>">
								<?php
								if ( function_exists( 'bb_user_presence_html' ) ) {
									bb_user_presence_html( $bp_get_group_member_id );
								} elseif ( function_exists( 'bb_current_user_status' ) ) {
									bb_current_user_status( $bp_get_group_member_id );
								} else {
									bb_user_status( $bp_get_group_member_id );
								}

								bp_group_member_avatar();
								?>
							</a>
						</div>

						<div class="item">
							<div class="item-block">
								<h2 class="list-title member-name">
									<?php bp_group_member_link(); ?>
								</h2>

								<p class="joined item-meta">
									<?php bp_group_member_joined_since(); ?>
								</p>
							</div>

							<div class="button-wrap member-button-wrap only-list-view">
								<?php
								if ( function_exists( 'bb_get_followers_count' ) ) {
									bb_get_followers_count( $bp_get_group_member_id );
								}

								if ( bp_is_active( 'friends' ) ) {
									bp_add_friend_button();
								}

								if ( bp_is_active( 'messages' ) ) {
									bp_send_message_button( $message_button_args );
								}

								if ( $is_follow_active ) {
									bp_add_follow_button( $bp_get_group_member_id, $bp_loggedin_user_id );
								}
								?>
							</div>

							<?php
							if ( $is_follow_active ) {
								$justify_class = ( $bp_get_group_member_id == $bp_loggedin_user_id ) ? 'justify-center' : '';
								?>
								<div class="flex only-grid-view align-items-center follow-container <?php echo esc_attr( $justify_class ); ?>">
									<?php
									if ( function_exists( 'bb_get_followers_count' ) ) {
										bb_get_followers_count( $bp_get_group_member_id );
									}

									bp_add_follow_button( $bp_get_group_member_id, $bp_loggedin_user_id );
									?>
								</div>
							<?php } ?>
						</div><!-- // .item -->

						<?php if ( bp_is_active( 'friends' ) && bp_is_active( 'messages' ) && ( $bp_get_group_member_id != $bp_loggedin_user_id ) ) { ?>
							<div class="flex only-grid-view button-wrap member-button-wrap footer-button-wrap"><?php bp_add_friend_button(); ?><?php bp_send_message_button( $message_button_args ); ?></div>
							<?php
						}

						if ( bp_is_active( 'friends' ) && ! bp_is_active( 'messages' ) ) { ?>
							<div class="only-grid-view button-wrap member-button-wrap on-top">
								<?php bp_add_friend_button(); ?>
							</div>
							<?php
						}

						if ( ! bp_is_active( 'friends' ) && bp_is_active( 'messages' ) ) { ?>
							<div class="only-grid-view button-wrap member-button-wrap on-top">
								<?php bp_send_message_button( $message_button_args ); ?>
							</div>
						<?php } ?>
					</div>

					<div class="bp-members-list-hook">
						<?php if ( $member_loop_has_content ) { ?>
							<a class="more-action-button" href="#"><i class="bb-icon-f bb-icon-ellipsis-h"></i></a>
						<?php } ?>
						<div class="bp-members-list-hook-inner">
							<?php bp_nouveau_member_hook( '', 'members_list_item' ); ?>
						</div>
					</div>

				</div>
			</li>

		<?php endwhile; ?>
	</ul>

	<?php
	bp_nouveau_group_hook( 'after', 'members_list' );
	bp_nouveau_pagination( 'bottom' );
	bp_nouveau_group_hook( 'after', 'members_content' );
} else {
	bp_nouveau_user_feedback( 'group-members-none' );
}
