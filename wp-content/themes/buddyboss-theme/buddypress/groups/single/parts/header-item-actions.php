<?php
/**
 * BuddyBoss - Groups Header item-actions.
 *
 * @since   BuddyPress 3.0.0
 * @version 3.1.0
 */
?>
<div id="item-actions" class="group-item-actions">

	<?php
	if ( bp_current_user_can( 'groups_access_group' ) ) :

		if ( function_exists( 'bb_platform_group_headers_element_enable' ) && bb_platform_group_headers_element_enable( 'group-organizers' ) ) :
			if ( function_exists( 'get_group_role_label' ) ) {
				if ( buddyboss_theme_bp_get_group_admins_count() > 1 ) {
					?>
					<h4 class="bp-title">
						<?php
							echo esc_html(
								get_group_role_label(
									bp_get_current_group_id(),
									'organizer_plural_label_name'
								)
							) . ':';
						?>
					</h4>
				<?php } else { ?>
					<h4 class="bp-title">
						<?php
							echo esc_html(
								get_group_role_label(
									bp_get_current_group_id(),
									'organizer_singular_label_name'
								)
							) . ':';
						?>
					</h4>
					<?php
				}
			}
			?>

			<dl class="moderators-lists">
				<dt class="moderators-title">
					<?php esc_html_e( 'Organized by', 'buddyboss-theme' ); ?>
				</dt>
				<dd class="user-list admins"><?php bp_group_list_admins(); ?>
					<?php bp_nouveau_group_hook( 'after', 'menu_admins' ); ?>
				</dd>
			</dl>
			<?php
		endif;

	endif;
	?>

</div><!-- .item-actions -->
