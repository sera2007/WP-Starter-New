<?php 

/*
Template Name: Homepage
*/

get_header();?>
<?php if (have_posts()) : while (have_posts()) : the_post();?>
    <div class="content">
        <div class="container">
            
        </div>
    </div>
<?php endwhile; endif; ?>	
<?php get_footer(); ?>