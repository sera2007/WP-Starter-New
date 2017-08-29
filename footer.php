<footer class="footer">
    <div class="container">
        <div class="social">
            <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                <?php dynamic_sidebar( 'footer-1' ); ?>
            <?php endif; ?>
        </div>
        <div class="partner">
            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                <?php dynamic_sidebar( 'footer-2' ); ?>
            <?php endif; ?>
        </div>
        <div class="organizer">
            <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                <?php dynamic_sidebar( 'footer-3' ); ?>
            <?php endif; ?>
        </div>
        <div class="sponsors">
            <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                <?php dynamic_sidebar( 'footer-4' ); ?>
            <?php endif; ?>
        </div>
    </div>
</footer>
</div>
<?php print_late_styles(); ?>
<?php wp_footer(); ?>
</body>

</html>