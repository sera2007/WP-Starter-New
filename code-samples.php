<?php    //Using teplates part    get_template_part( 'loop', 'wall' ); // loop-wall.php file name    // If comments are open or we have at least one comment, load up the comment template.    if ( comments_open() || get_comments_number() ) :        comments_template();    endif;    //Get featured post image    $img_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID) ,'post-thumb'); //$img_url[0]    //Custom query pagination    $paged = ( get_query_var('page') ) ? get_query_var('page') : 1; // for Homepage    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; //for other pages    $query = new WP_Query( array( // for Homepage        'post_type' => 'catalog',        'order'=> 'ASC',        'paged' => $paged,        'page' => $paged,        'posts_per_page' => 10    ) );    $query = array( //for other pages        'post_type' => 'catalog',        'order'=> 'ASC',        'paged' => $paged,        'posts_per_page' => 10    );    if ( $query->have_posts() ) :        while ( $query->have_posts() ) : $query->the_post();            $img_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );        endwhile;        custom_pagination($query->max_num_pages,"",$paged);        wp_reset_postdata();    endif;    ?>