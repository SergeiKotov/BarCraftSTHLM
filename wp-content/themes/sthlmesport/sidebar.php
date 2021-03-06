<?php
/**
 * The Sidebar containing the events sidebar
 *
 * @package sthlmesport
 */

$args = array( 'type'=>'post', 'orderby'=>'name',
               'order'=>'ASC', 'taxonomy'=>'category' );
$categories = get_categories( $args );
$event_query = array();
foreach ( $categories as $cat ) {
    $args = array( 'post_type'      => 'event',
                   'numberposts'    => 1,
                   'cat'            => $cat->cat_ID,
                   'meta_key'       => '_date',
                   'order'          => 'DESC',
                   'orderby'       => 'meta_value',
                   'no_found_rows'  => true,
                   'meta_query'     => array(array(
                       'key'    => '_date',
                       'value'  => date('Ymd'),
                       'compare'=> '>=',
                       'type'   => 'NUMERIC'
                   ))
                  );
    $query = new WP_Query( $args );
    while ( $query->have_posts() ) : $query->the_post();
        $event_query[$cat->slug] = array( 'name'=>$cat->name, 'title'=>get_the_title(get_the_ID()), // ...
                                          'event-date'=>(get_post_meta(get_the_ID(), '_date', true)),
                                          'event-link'=>get_permalink(get_the_ID()),
                                          'term_link'=>esc_attr(get_term_link($cat->slug, 'category')) );
    endwhile;
}
?>

            <div id="secondary" class="widget-area" role="complementary">
            	<aside class="events-area widget">

            	<?php if (isset($event_query['starcraft'])) : ?>
	                <a href="<?php echo $event_query['starcraft']['event-link']; ?>" class="event-box" id="starcraft-event-box">
	                    <p class="event-text">Nästa BarCraft</p>
	                    <p class="event-date"><?php echo date("j/n", strtotime($event_query['starcraft']['event-date']) ); ?></p>
	                </a>
	            <?php else: ?>
	                <div class="event-box" id="starcraft-event-box">
	                    <p class="event-text">Nästa BarCraft</p>
	                    <p class="event-date">TBA</p>
	                </div>
	            <?php endif; ?>

				<?php if (isset($event_query['lol'])) : ?>
	               <a href="<?php echo $event_query['lol']['event-link']; ?>" class="event-box" id="lol-event-box">
	                    <p class="event-text">Nästa Bar of Legends</p>
	                    <p class="event-date"><?php echo  date("j/n", strtotime($event_query['lol']['event-date']) ); ?></p>
	                </a>
	            <?php else: ?>
	                <div class="event-box" id="lol-event-box">
	                    <p class="event-text">Nästa Bar of Legends</p>
	                    <p class="event-date">TBA</p>
	                </div>
	            <?php endif; ?>

				<?php if (isset($event_query['dota'])) : ?>
	                <a href="<?php echo $event_query['dota']['event-link']; ?>" class="event-box" id="dota-event-box">
	                    <p class="event-text">Nästa Pubstomp</p>
	                    <p class="event-date"><?php echo  date("j/n", strtotime($event_query['dota']['event-date']) ); ?></p>
	                </a>
	            <?php else: ?>
	                <div class="event-box" id="dota-event-box">
	                    <p class="event-text">Nästa Pubstomp</p>
	                    <p class="event-date">TBA</p>
	                </div>
	            <?php endif; ?>

	            <?php if (isset($event_query['hearthstone'])) : ?>
	                <a href="<?php echo $event_query['hearthstone']['event-link']; ?>" class="event-box" id="hearthstone-event-box">
	                    <p class="event-text">Nästa Fireside</p>
	                    <p class="event-date"><?php echo  date("j/n", strtotime($event_query['hearthstone']['event-date']) ); ?></p>
	                </a>
	            <?php else: ?>
	                <div class="event-box" id="hearthstone-event-box">
	                    <p class="event-text">Nästa Fireside</p>
	                    <p class="event-date">TBA</p>
	                </div>
	            <?php endif; ?>

				<?php if (isset($event_query['esport'])) : ?>
	                <a href="<?php echo $event_query['esport']['event-link']; ?>" class="event-box" id="esport-event-box">
	                    <p class="event-text">Nästa Turnering</p>
	                    <p class="event-date"><?php echo  date("j/n", strtotime($event_query['esport']['event-date']) ); ?></p>
	                </a>
	            <?php else: ?>
	                <div class="event-box" id="esport-event-box">
	                    <p class="event-text">Nästa Turnering</p>
	                    <p class="event-date">TBA</p>
	                </div>
	            <?php endif; ?>

	            	<div id="social-box">
	            		<a class="social-link" href="https://www.facebook.com/STHLMesport" target="_blank"><img src="<?php bloginfo('template_directory');?>/img/icon/social-facebook-36.png"></a>
	            		<a class="social-link" href="https://twitter.com/sthlmesport" target="_blank"><img src="<?php bloginfo('template_directory');?>/img/icon/social-twitter-36.png"></a>
	            		<a class="social-link" href="http://instagram.com/sthlmesport" target="_blank"><img src="<?php bloginfo('template_directory');?>/img/icon/social-instagram-36.png"></a>
	            		<a class="social-link" href="http://youtube.com/sthlmesport" target="_blank"><img class="social-link" src="<?php bloginfo('template_directory');?>/img/icon/social-youtube-36.png"></a>
	            	</div>

	            </aside>


	            <?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

	            <aside id="search" class="widget widget_search">
	                <?php get_search_form(); ?>
	            </aside>

	            <aside id="archives" class="widget">
	                <h1 class="widget-title"><?php _e( 'Archives', 'sthlmesport' ); ?></h1>
	                <ul>
	                    <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
	                </ul>
	            </aside>

	            <aside id="meta" class="widget">
	                <h1 class="widget-title"><?php _e( 'Meta', 'sthlmesport' ); ?></h1>
	                <ul>
	                    <?php wp_register(); ?>
	                    <li><?php wp_loginout(); ?></li>
	                    <?php wp_meta(); ?>
	                </ul>
	            </aside>

	        <?php endif; // end sidebar widget area ?>

            </div><!-- #secondary -->
