<footer>
    <div class="container">
        <!-- this is for footer of menu -->
        <?php
        wp_nav_menu( 
            array(
                'theme_location' => 'footer-menu',
                //'menu' => 'Top Bar'
                'menu_class' => 'footer-bar'
            )
        );
        ?>
    </div>
</footer>


<?php wp_footer();?>
</body>
</html>