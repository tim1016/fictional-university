<?php get_header();?>



<?php 
while(have_posts()){
    the_post(); ?>

    <main>
    <?php 
        pageBanner(
            array(
                'title' => '',
                'subtitle' => '',
                'photo' => ''
            ));
    ?>
<!--
        <section class="banner">


            <div class="banner--interior ">                    
                <div class="row">
                    <div class="banner__box">
                        <h1 class="display-1 display-1--main moveinleft"><?php the_title();?></h1>
                        <h1 class="display-1 display-1--sub moveinright">subtitle</h1>               
                    </div>
                </div>
            </div>

        </section>
-->

        <section class="section">

            <div class="row generic-text">

                <div class="col-2-of-3">
                    <?php get_template_part('template-parts/form-search');?>
                </div>

                <?php 
                    $currentPageID = get_the_id();
                    $theChildren = get_pages( array('child_of' => $currentPageID) );
                    $theParent = wp_get_post_parent_id( $currentPageID );

                    if($theParent or $theChildren){ ?>
                        <div class="col-1-of-3">
                            <div class="sidebar__left">
                                <?php 
                                    
                                    if($theParent){
                                        $findChildrenOf = $theParent;
                                    }
                                    else{
                                        $findChildrenOf = $currentPageID;
                                    }
                                    if($theParent){
                                        ?>
                                        <div class="side-nav">
                                            <ul>
                                                <li><a href="<?php echo get_permalink( $theParent );?>"> <i class="fa fa-home" aria-hidden="true"></i> <?php echo get_the_title( $theParent );?> </a></li>
                                                <?php wp_list_pages( array( 'title_li' => NULL, 'child_of' => $findChildrenOf, 'sort_column' => 'menu_order') ); ?>
                                            </ul>
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                <?php }?>

            </div>

        </section>
    </main>

    



    <?php

}   

?>

<?php get_footer();?>
