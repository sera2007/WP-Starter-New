<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(); ?></title>
    <?php
    $favicon = get_field('favicon','option');
    if (!empty($favicon)){
    ?>
        <link rel="icon" type="image/png" href="<?php the_field('favicon','option'); ?>">
        <link rel="shortcut icon" href="<?php the_field('favicon','option'); ?>"/>
    <?php } ?>
    <?php wp_head();?>
    <!--[if IE]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/r29/html5.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="wrapper">
    <header class="header">
        <div class="container">
            <div class="logo">
                <?php
                $image = get_field('logo','option');
                $logo_text = get_field('logo_text','option');
                if (!empty($logo_text)){ ?>
                    <a href="<?php echo site_url(); ?>"><?php the_field('logo_text','option'); ?></a>
                <?php }elseif (!empty($image)){ ?>
                    <a href="<?php echo site_url(); ?>"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/></a>
                <?php } ?>
            </div>
            <div class="menu">
                <a class="menu_toggle"><img src="<?php echo  get_template_directory_uri().'/public/' ?>img/icon-burger.png" alt="" id="menu_section"></a>
                    <ul class="main_menu">
                        <?php
                        // get wordpress menu locations
                        $menu_locations = get_nav_menu_locations();
                        $menu = get_heirachical_menu('top-menu', $menu_locations);
                        $page_id = get_the_ID();

                        foreach(array_reverse($menu) as $key_1=>$level_1){
                            if(count($level_1->children)>0){$is_children='menuparent has-regularmenu hasSubmenu';}else{$is_children='';}
                            //if(($level_1->current)==1){$active='active';}else{$active='';}
                            echo "<li class=' $is_children'><a class='$active $is_children' href='".$level_1->url."'>".$level_1->title."</a>";
                            if(count($level_1->children)>0){
                                echo '<ul class="submenu level_1">';
                                foreach($level_1->children as $key_2=>$level_2){
                                    //if(($level_2->current)==1){$active='active';}else{$active='';}
                                    echo "<li ><a class='$active' href='".$level_2->url."'>".$level_2->title."</a>";
                                    if(count($level_2->children)>0){
                                        echo '<ul class="submenu level_2">';
                                        foreach($level_2->children as $key_3=>$level_3){
                                            //if(($level_3->current)==1){$active='active';}else{$active='';}
                                            echo "<li ><a class='$active' href='".$level_3->url."'>".$level_3->title."</a>";
                                            echo "</li> ";
                                        }
                                        echo '</ul>';
                                    }
                                    echo "</li> ";
                                }
                                echo '</ul>';
                            }
                            echo "</li> ";
                        }
                        ?>
                    </ul>
                </div><!-- /dl-menuwrapper -->
        </div>
    </header>