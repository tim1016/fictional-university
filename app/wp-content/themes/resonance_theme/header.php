<!DOCTYPE html>
<html <?php language_attributes( );?>>
<head>
    <meta charset=<?php bloginfo( 'charset' ); ?>> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title> -->
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <?php wp_head();?>
</head>
<body <?php body_class(  );?>>
    <header class="header">
        <div class="header__navigation">    
            <div class="fixed">
                <div class="row">
                    <div class="brand">          
                    
                        <a href='<?php echo site_url( )?>'>
                            <svg class="brand__img">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#newresonance"></use>
                            </svg>   
                        </a> 
                    
                        <a class="brand__text" href="<?php echo site_url( )?>"><strong>Resonance</strong>Realty</a>
                    </div>
                    
                    <nav>
                        <div class="nav-mobile">
                            <a id="nav-toggle" href="#!"><span></span></a>
                        </div>
                        <ul class="nav-list">
                            <li <?php if (is_page( 'sell' ) or wp_get_post_parent_id( 0 )==46) echo 'class="current-menu-item"';?>><a href="#!">Sell</a>
                                <ul class="nav-dropdown">
                                    <li><a href="#!">Fast Cash Offer</a></li>
                                    <li><a href="<?php echo site_url( '/sell/already-moved/' )?>">Already Moved</a></li>
                                    <li><a href="<?php echo site_url( '/sell/stop-foreclosure/' )?>">Stop Foreclosure</a></li>
                                    <li><a href="<?php echo site_url( '/sell/no-equity/' )?>">No Equity</a></li>
                                    <li><a href="#!">Previously Listed</a></li>
                                    <li><a href="#!">Code Violations</a></li>
                                    <li><a href="#!">Inheritance</a></li>
                                    <li><a href="#!">Double Payments</a></li>
                                    <li><a href="#!">Problem Rental</a></li>
                                </ul>
                            </li>
                            <li <?php if(get_post_type()=='event') echo 'class="current-menu-item"'?>><a href="<?php echo get_post_type_archive_link( 'event' )?>">Events</a></li>
                            <li <?php if(get_post_type()=='program') echo 'class="current-menu-item"'?>><a href="<?php echo get_post_type_archive_link( 'program' )?>">Programs</a></li>
<!--                            <li><a href="leaseoption.html">Lease</a></li> -->
                            <li <?php if (get_post_type() == 'campus') echo 'class="current-menu-item"';?>><a href="<?php echo get_post_type_archive_link('campus')?>">Campus</a></li>
                            
        
                            <li><a href="#!">About</a>
                                <ul class="nav-dropdown">
                                    <li><a href="<?php echo site_url( '/about-us' )?>">About Us</a></li>
                                    <li><a href="<?php echo site_url( '/privacy-policy' )?>">Privacy Policy</a></li>
                                    <li><a href="#!">Opportunities</a></li>
                                </ul>
                            </li>
                            <li <?php if (get_post_type() == 'post') echo 'class="current-menu-item"';?>><a href="<?php echo site_url( 'Blog' )?>">Blog</a></li>

                            <li><a href="<?php echo esc_url( site_url('/search') )?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a></li>

                            <?php if(is_user_logged_in()){ ?>
                                <li><a href="<?php echo site_url('/my-notes'); ?>" class="button button--tertiary">My Notes</a></li>



                                <li><a href="<?php echo wp_logout_url(); ?>" class="button button--secondary button--with-photo">
                                <span><?php echo  get_avatar( get_current_user_id(),30); ?></span>
                                <span>Log out</span>
                                </a></li>

                            <?php }
                            else{ ?>
                                <li><a href="<?php echo wp_registration_url(); ?>" class="button button--secondary">Sign up</a></li>
                                <li><a href="<?php echo wp_login_url();?>" class=" white">Login</a></li>
                                <?php

                            }
                            
                            
                            
                            ?>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>    
    
