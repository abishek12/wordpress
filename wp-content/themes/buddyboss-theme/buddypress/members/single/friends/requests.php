<?php
/**
 * BuddyBoss - Members Connections Requests
 *
 * @since BuddyPress 3.0.0
 * @version 3.0.0
 */

bp_nouveau_member_hook( 'before', 'friend_requests_content' );

if ( bp_has_members( 'type=alphabetical&include=' . bp_get_friendship_requests() ) ) {

	bp_nouveau_pagination( 'top' );
	?>

	<ul id="friend-list" class="<?php bp_nouveau_loop_classes(); ?>" data-bp-list="friendship_requests">
		<?php
		while ( bp_members() ) :
			bp_the_member();

			$bp_get_member_user_id   = bp_get_member_user_id();
			$bp_get_member_permalink = bp_get_member_permalink();
			$bp_friend_friendship_id = bp_get_friend_friendship_id();
			?>

			<li id="friendship-<?php echo esc_attr( $bp_friend_friendship_id ); ?>" <?php bp_member_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php echo esc_attr( $bp_friend_friendship_id ); ?>" data-bp-item-component="members">
				<div class="list-wrap member-request-list-wrap">
					<div class="item-avatar">
						<a href="<?php echo esc_url( $bp_get_member_permalink ); ?>">
							<?php
							if ( function_exists( 'bb_user_presence_html' ) ) {
								bb_user_presence_html( $bp_get_member_user_id );
							} elseif ( function_exists( 'bb_current_user_status' ) ) {
								bb_current_user_status( $bp_get_member_user_id );
							} else {
								bb_user_status( $bp_get_member_user_id );
							}

							bp_member_avatar( bp_nouveau_avatar_args() );
							?>
						</a>
					</div>

					<div class="item">
						<div class="item-block">
							<h2 class="list-title member-name">
								<a href="<?php echo esc_url( $bp_get_member_permalink ); ?>"><?php bp_member_name(); ?></a>
							</h2>

							<?php if ( bp_nouveau_member_has_meta() ) : ?>
								<p class="item-meta last-activity">
									<?php bp_nouveau_member_meta(); ?>
								</p>
							<?php endif; ?>
						</div>

						<?php bp_nouveau_friend_hook( 'requests_item' ); ?>
					</div>

					<?php bp_nouveau_members_loop_buttons(); ?>
				</div>
			</li>

		<?php endwhile; ?>
	</ul>

	<?php
	bp_nouveau_friend_hook( 'requests_content' );
	bp_nouveau_pagination( 'bottom' );

} else {
	bp_nouveau_user_feedback( 'member-requests-none' );
}

bp_nouveau_member_hook( 'after', 'friend_requests_content' );
