<?php
/**
 * The template for displaying the 404 template in the Twenty Twenty theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content" role="main">

<header class="section-inner error404-content">
	<figure class="featured-media error404-media">
		<div class="featured-media-inner section-inner thin">
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/img/oops.png' ); ?>" alt="Oops Something went wrong."/>
		</div>
	</figure>
	<h1 class="entry-title"><?php esc_html_e( 'Page Not Found', 'edxchildtheme' ); ?></h1>
</header>

	<div class="section-inner error404-content">

		<div class="intro-text"><p><?php esc_html_e( 'Nothing was found at this location. Maybe try one of the links below or a search?', 'edxchildtheme' ); ?></p></div>

		<?php
		get_search_form(
			array(
				'label' => __( '404 not found', 'edxchildtheme' ),
			)
		);
		?>

	</div><!-- .section-inner -->

	<div class="section-inner error404-widgets">
	<?php
	// Display recent posts widget.
	the_widget( 'WP_Widget_Recent_Posts' );
	// Display categories widget.
	if ( count( get_categories() ) > 2 ) :
		?>
		<div class="widget widget_categories">
			<h2 class="widgettitle"><?php esc_html_e( 'Most Used Categories', 'edxchildtheme' ); ?></h2>
			<ul>
				<?php
				wp_list_categories(
					array(
						'orderby'    => 'count',
						'order'      => 'DESC',
						'show_count' => 1,
						'title_li'   => '',
						'number'     => 10,
					)
				);
				?>
			</ul>
		</div>
		<?php
	endif;
	// Display Archives widget.
	$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'edxchildtheme '), convert_smilies( ':)' ) ) . '</p>'; // phpcs:ignore
	the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
	// Display Tag Clud widget.
	the_widget( 'WP_Widget_Tag_Cloud' );
	?>
	</div> <!-- error404-widgets-->

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
