<?php
/**
 * EdxChildtheme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage EdxChildTheme
 * @since Twenty Twenty 1.0
 */

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/**
 * Enqueue parent and child stylesheets.
 */
function my_theme_enqueue_styles() {
	$parenthandle = 'twentytwenty-style';
	wp_enqueue_style(
		$parenthandle,
		get_template_directory_uri() . '/style.css',
		array(), // if the parent theme code has a dependency, copy it to here.
		'20200524'
	);

	wp_enqueue_style(
		'edxchildtheme-style',
		get_stylesheet_uri(),
		array( $parenthandle ),
		wp_get_theme()->get( 'Version' )
	);
	// Serif font.
	wp_enqueue_style(
		'edxchildtheme-serif',
		'https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700',
		array(),
		'20200524'
	);

	// Font awesome.
	wp_enqueue_style(
		'edxchildtheme-fontawesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css',
		array(),
		'20200524'
	);

	// Custom JS for top menu.
	wp_enqueue_script(
		'edxchildtheme-top-menu',
		get_stylesheet_directory_uri() . '/js/top-menu.js',
		array(),
		'20200524',
		true
	);
}

/**
 * Logo & Description
 */
/**
 * Displays the site logo, either text or image.
 *
 * @param array   $args Arguments for displaying the site logo either as an image or text.
 * @param boolean $echo Echo or return the HTML.
 *
 * @return string $html Compiled HTML based on our arguments.
 */
function edxchildtheme_site_logo( $args = array(), $echo = true ) {
	$logo       = get_custom_logo();
	$site_title = get_bloginfo( 'name' );
	$contents   = '';
	$classname  = '';

	$defaults = array(
		'logo'        => '%1$s<h1 class="site-title">%2$s</h1>',
		'logo_class'  => 'site-logo',
		'title'       => '<a href="%1$s">%2$s</a>',
		'title_class' => 'site-title',
		'home_wrap'   => '<h1 class="%1$s">%2$s</h1>',
		'single_wrap' => '<div class="%1$s faux-heading">%2$s</div>',
		'condition'   => ( is_front_page() || is_home() ) && ! is_page(),
	);

	$args = wp_parse_args( $args, $defaults );

	/**
	 * Filters the arguments for `twentytwenty_site_logo()`.
	 *
	 * @param array  $args     Parsed arguments.
	 * @param array  $defaults Function's default arguments.
	 */
	$args = apply_filters( 'twentytwenty_site_logo_args', $args, $defaults );

	if ( has_custom_logo() ) {
		$contents  = sprintf( $args['logo'], $logo, esc_html( $site_title ) );
		$classname = $args['logo_class'];
	} else {
		$contents  = sprintf( $args['title'], esc_url( get_home_url( null, '/' ) ), esc_html( $site_title ) );
		$classname = $args['title_class'];
	}

	$wrap = 'home_wrap';

	$html = sprintf( $args[ $wrap ], $classname, $contents );

	/**
	 * Filters the arguments for `twentytwenty_site_logo()`.
	 *
	 * @param string $html      Compiled html based on our arguments.
	 * @param array  $args      Parsed arguments.
	 * @param string $classname Class name based on current view, home or single.
	 * @param string $contents  HTML for site title or logo.
	 */
	$html = apply_filters( 'twentytwenty_site_logo', $html, $args, $classname, $contents );

	if ( ! $echo ) {
		return $html;
	}

	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

}

/**
 * WordPress filter example (Title).
 *
 * @param string $title The post title.
 * @param int    $id The post ID.
 */
function edxchildtheme_filter_the_title( $title, $id = null ) {
	if ( in_category( 'block', $id ) ) {
		return '<i class="post-title-icon fas fa-dice-d6" title="Block Editor Post"></i> ' . $title;
	}

	if ( in_category( 'classic', $id ) ) {
		return '<i class="post-title-icon fas fa-file-alt" title="Classic Editor Post"></i> ' . $title;
	}

	return $title;
}

add_filter( 'the_title', 'edxchildtheme_filter_the_title', 10, 2 );
add_filter( 'single_cat_title', 'edxchildtheme_filter_the_title', 10, 2 );


/**
 * WordPress filter for excerpt Length.
 *
 * @param int $length Numbers of words in excerpt.
 */
function edxchildtheme_filter_excerpt_length( int $length ) {
	return 20;
}

add_filter( 'excerpt_length', 'edxchildtheme_filter_excerpt_length', 10, 1 );

/**
 * WordPress filter for Read more link
 *
 * @param string $more Filtered excerpt.
 */
function edxchildtheme_filter_excerpt_more( string $more ) {
	return '&hellip; <a href="' . get_the_permalink() . '">[read more] </a>';
}

add_filter( 'excerpt_more', 'edxchildtheme_filter_excerpt_more', 10, 1 );

/**
 * Register Widget areas
 */
function edxchildtheme_sidebar_registration() {

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	// Sidebar Widgets.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __( 'Sidebar', 'edxchildtheme' ),
				'id'          => 'sidebar-edxchildtheme',
				'description' => __( 'Widgets in this area will be displayed under the Expanded / Mobile menu.', 'edxchildtheme' ),
			)
		)
	);

}

add_action( 'widgets_init', 'edxchildtheme_sidebar_registration' );

/**
 * Register a new Colophon menu
 */
function edxchildtheme_register_colophon_menu() {
	register_nav_menu( 'colophon', __( 'Colophon Nenu', 'edxchildtheme' ) );
}

add_action( 'after_setup_theme', 'edxchildtheme_register_colophon_menu' );

/**
 * Filter to remove author from top post meta
 */
function edxchildtheme_remove_author_post_meta() {
	return array(
		'post-date',
		'comments',
		'sticky',
	);
}
add_filter( 'twentytwenty_post_meta_location_single_top', 'edxchildtheme_remove_author_post_meta' );

/**
 * Filter to add Category to bottom post meta.
 *
 * @param array $post_meta The post meta array.
 */
function edxchildtheme_add_categories_post_meta( array $post_meta ) {
	// Add categories to bottom post meta.
	$add_meta = array(
		'categories',
		'author',
	);

	return array_merge( $post_meta, $add_meta );
}
add_filter( 'twentytwenty_post_meta_location_single_bottom', 'edxchildtheme_add_categories_post_meta' );

/**
 * Function to calculate reading time.
 */
function edxchildtheme_reading_time() {
	$content = get_post_field( 'post_content', get_the_ID() );
	$count   = str_word_count( wp_strip_all_tags( $content ) );
	$time    = $count / 250; // Approx 250 words per minute.
	$minutes = floor( $time % 60 ); // Left of decimal $time (minutes).
	$seconds = $time - (int) $time; // Right of decimal $time (seconds).
	$seconds = round( $seconds * 60 ); // Convert decimal to minutes.
	$seconds = $seconds < 10 ? ( '0' . $seconds ) : $seconds; // 4:9 to 4:09.
	return $minutes . ':' . $seconds;
}

/**
 * Add reading time to post meta.
 */
function edxchildtheme_add_reading_time() {
	// Only print read time on the upper post meta.
	static $count = 0;
	if ( $count < 1 ) {
		?>
		<li class="post-reading-time meta-wrapper">
			<span class="meta-icon">
				<span class="screen-reader-text"><?php _e( 'Reading Time', 'edxchildtheme' ); // phpcs:ignore ?></span>
				<i class="far fa-clock"></i>
			</span>
			<span class="meta-text">
				<?php printf( __( '%s Reading Time', 'edxchildtheme' ), edxchildtheme_reading_time() ); // phpcs:ignore ?>
			</span>
		</li>
		<?php
		$count++;
	} else {
		$count = 0;
	}
}
add_action( 'twentytwenty_start_of_post_meta_list', 'edxchildtheme_add_reading_time' );

