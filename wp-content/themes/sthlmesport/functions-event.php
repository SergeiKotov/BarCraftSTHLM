<?php
/**
 * @package sthlmesport
 */
?>

<?php
// unused...

function event_posts_cache() {
    $args = array( 'type'=>'post', 'orderby'=>'name',
                   'order'=>'ASC', 'taxonomy'=>'category' );
    $categories = get_categories( $args );
    $event_query = array();
    foreach ( $categories as $cat ) {
        $args = array( 'post_type'=>'event',
                       'posts_per_page'=>1,
                       'cat'=>$cat->cat_ID,
                       'order_by'=>'_date',
                       'order'=>'ASC',
                       'no_found_rows'=>true );
        $query = new WP_Query( $args );
        while ( $query->have_posts() ) : $query->the_post();
            $event_query[$cat->slug] = array( 'name'=>$cat->name, 'title'=>get_the_title(get_the_ID()), // ...
                                              'event-date'=>(get_post_meta(get_the_ID(), '_date', true)),
                                              'event-link'=>get_permalink(get_the_ID()),
                                              'term_link'=>esc_attr(get_term_link($cat->slug, 'category')) );
        endwhile;
    }
    wp_reset_postdata();
    set_transient( 'event_query', $event_query );
    return $event_query;
}

function event_str($s) { // unused atm, move and rename?
    return (strlen($s) > 23) ? substr($s, 0, 20) . '...' : $s;
}
?>

