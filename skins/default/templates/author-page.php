<?php
/**
 * The template to display the user's avatar, bio and socials on the Author page
 *
 * @package SWEAT
 * @since SWEAT 1.71.0
 */
?>

<div class="author_page author vcard"<?php
	if ( sweat_is_on( sweat_get_theme_option( 'seo_snippets' ) ) ) {
		?> itemprop="author" itemscope="itemscope" itemtype="<?php echo esc_attr( sweat_get_protocol( true ) ); ?>//schema.org/Person"<?php
	}
?>>

	<div class="author_avatar"<?php
		if ( sweat_is_on( sweat_get_theme_option( 'seo_snippets' ) ) ) {
			?> itemprop="image"<?php
		}
	?>>
		<?php
		$sweat_mult = sweat_get_retina_multiplier();
		echo get_avatar( get_the_author_meta( 'user_email' ), 120 * $sweat_mult );
		?>
	</div>

	<h4 class="author_title"<?php
		if ( sweat_is_on( sweat_get_theme_option( 'seo_snippets' ) ) ) {
			?> itemprop="name"<?php
		}
	?>><span class="fn"><?php the_author(); ?></span></h4>

	<?php
	$sweat_author_description = get_the_author_meta( 'description' );
	if ( ! empty( $sweat_author_description ) ) {
		?>
		<div class="author_bio"<?php
			if ( sweat_is_on( sweat_get_theme_option( 'seo_snippets' ) ) ) {
				?> itemprop="description"<?php
			}
		?>><?php echo wp_kses( wpautop( $sweat_author_description ), 'sweat_kses_content' ); ?></div>
		<?php
	}
	?>

	<div class="author_details">
		<span class="author_posts_total">
			<?php
			$sweat_posts_total = count_user_posts( get_the_author_meta('ID'), 'post' );
			if ( $sweat_posts_total > 0 ) {
				// Translators: Add the author's posts number to the message
				echo wp_kses( sprintf( _n( '%s article published', '%s articles published', $sweat_posts_total, 'sweat' ),
										'<span class="author_posts_total_value">' . number_format_i18n( $sweat_posts_total ) . '</span>'
								 		),
							'sweat_kses_content'
							);
			} else {
				esc_html_e( 'No posts published.', 'sweat' );
			}
			?>
		</span><?php
			ob_start();
			do_action( 'sweat_action_user_meta', 'author-page' );
			$sweat_socials = ob_get_contents();
			ob_end_clean();
			sweat_show_layout( $sweat_socials,
				'<span class="author_socials"><span class="author_socials_caption">' . esc_html__( 'Follow:', 'sweat' ) . '</span>',
				'</span>'
			);
		?>
	</div>

</div>
