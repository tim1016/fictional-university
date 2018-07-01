<?php get_header();?>


    <main>
        <section class="banner">
            <div class="banner--home">
                <div class="row">
                    <div class="col-2-of-3">
                        <div class="banner__text-box boxed dark-shadow">
                            <h1 class="display-1 display-1--main moveinleft">REISavvy</h1>
                            <h1 class="display-1 display-1--sub moveinright">the win-win philosophy</h1>
                            <a href="#" class="btn btn--white moveinbottom">Get in Touch</a>
                        </div>         
                    </div>


                    <div class="col-1-of-3">
                        <?php get_template_part('template-parts/form-fco');?>
                    </div>
                </div>
            </div>
        </section>




        








        <section class="section">
            <div class="row">
                <div class="col-1-of-2">

                    <h2 class="heading-3 u-center-text u-margin-bottom-medium">Upcoming Events</h2>

                    <?php 
                        $today = date('Ymd');
                        $homepageEvents = new WP_Query(array(
                            'posts_per_page' => 2,
                            'post_type' => 'event',
                            'meta_key' => 'event_date',
                            'orderby' => 'meta_value_num',
                            'order' => 'ASC',
                            'meta_query' => array(
                                array(
                                    'key' => 'event_date',
                                    'compare' => '>=',
                                    'value' => $today,
                                    'type' => 'numeric'
                                )
                            )
                        ));

                        while($homepageEvents->have_posts()) {
                            $homepageEvents->the_post();
                            get_template_part('template-parts/content', 'event');
                        }
                    ?>

                    <p class="u-center-text no-margin"><a href="<?php echo get_post_type_archive_link('event');?>" class="btn btn--blue">View All Events</a></p>
                </div>

                <div class="col-1-of-2">
                    <h2 class="heading-3 u-center-text u-margin-bottom-medium">From Our Blogs</h2>
                    <?php 
                        $homepagePosts = new WP_Query(array(
                            'posts_per_page' => -1
                        ));

                        while($homepagePosts->have_posts()){
                            $homepagePosts->the_post(); 
                            ?>
                        <div class="event-summary">
                            <a class="event-summary__date event-summary__date--beige u-center-text" href="<?php the_permalink();?>">
                                <span class="event-summary__month"> <?php the_time('M')?>  </span>
                                <span class="event-summary__day"><?php the_time('j')?> </span>  
                            </a>
                            <div class="event-summary__content">
                                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
                                <p><?php echo wp_trim_words( get_the_content(), 18)?> <a href="<?php the_permalink();?>" class="nu gray">Read more</a></p>
                            </div>
                        </div>                            

                            <?php
                        }
                        wp_reset_postdata();
                    
                    ?>

                    

                    <p class="u-center-text no-margin"><a href="<?php echo site_url('/blog')?>" class="btn btn--yellow">View All Blog Posts</a></p>
                </div>
            </div>
        </section>


        <section class="section section--scenarios">    
            <div class="row">
                <div class="scenario-heading-container">
                    <h2 class="heading-2 center">
                        <span class="heading-2--main">No matter what your situation or circumtance</span>
                        <span class="heading-2--sub">We can help!</span>
                    </h2>
                </div>

                

                <div class="scenario-container">
                    
                        <div class="scenario">
                            <svg class="scenario__icon">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#burden"></use>
                            </svg>  
                            <h2 class="scenario-heading">
                                Behind In Payments Or In Foreclosure
                            </h2>
                        </div>   
    
    
                        <div class="scenario">
                            <svg class="scenario__icon">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#moving"></use>
                            </svg>  
                            <h2 class="scenario-heading">
                                Already Moved Or Moving Soon
                            </h2>
                        </div> 
                        
                        <div class="scenario">
                            <svg class="scenario__icon">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#tax"></use>
                            </svg>  
                            <h2 class="scenario-heading">
                                Behind In Your Property Taxes
                            </h2>
                        </div>   
    
    
                        <div class="scenario">
                            <svg class="scenario__icon">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#tools"></use>
                            </svg>  
                            <h2 class="scenario-heading">
                                Property Needs Repairs
                            </h2>
                        </div> 
    
                        <div class="scenario">
                            <svg class="scenario__icon">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#unwanted"></use>
                            </svg>  
                            <h2 class="scenario-heading">
                                Inherited An Unwanted Property
                            </h2>
                        </div>   
    
    
                        <div class="scenario">
                            <svg class="scenario__icon">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#closing"></use>
                            </svg>  
                            <h2 class="scenario-heading">
                                Not Enough Equity To Afford Selling
                            </h2>
                        </div> 
                    
                    
                
                        <div class="scenario">
                            <svg class="scenario__icon">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#goingdown"></use>
                            </svg>  
                            <h2 class="scenario-heading">
                                Worth Less Than What You Owe
                            </h2>
                        </div>   
        
        
                        <div class="scenario">
                            <svg class="scenario__icon">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#listed"></use>
                            </svg>  
                            <h2 class="scenario-heading">
                                    Listed With An Agent Before
                            </h2>
                        </div> 
                        
                        <div class="scenario">
                            <svg class="scenario__icon">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#codeviolations"></use>
                            </svg>  
                            <h2 class="scenario-heading">
                                Property Has Code Violations
                            </h2>
                        </div>   
    
    
                        <div class="scenario">
                            <svg class="scenario__icon">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#badtenant"></use>
                            </svg>  
                            <h2 class="scenario-heading">
                                Non-Paying Tenants
                            </h2>
                        </div> 
    
                        <div class="scenario">
                            <svg class="scenario__icon">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#doublepayments"></use>
                            </svg>  
                            <h2 class="scenario-heading">
                                Making Double Payments
                            </h2>
                        </div>   
    
    
                        <div class="scenario">
                            <svg class="scenario__icon">
                                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#alarmclock"></use>
                            </svg>  
                            <h2 class="scenario-heading">
                                Need To Sell Very Quickly
                            </h2>
                        </div> 

                    

                    

                </div>
            </div>
        </section>
    
        <section class="section section--specialities ">
            <div class="row">
                <div class="specialities-container">
                    <div class="col-1-of-3">
                        <div class="speciality light-shadow  generic-text generic-text--justified-content">
                            <div class="speciality__photo">
                                <img class="speciality__img" sizes="160px" src="<?php echo get_template_directory_uri();?>/img/house-1.jpg" alt="Selling simplified">
                            </div>
                            <div class="speciality__content">
                                <h3 class="heading-3 heading-3--secondary">Selling process simplified</h3>                            
                                <p>You have options when it comes to selling your home, but your neighborhood realtor isn’t going to tell you about them. Selling your house doesn’t have to be a succession of hope and disappointment with each offer made and loan that didn’t approve. When you work with investors, you get a fair offer and a fast closing without the headaches that come with retail buyers.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-1-of-3">
                        <div class="speciality light-shadow  generic-text generic-text--justified-content">
                            <div class="speciality__photo">
                                <img class="speciality__img" sizes="160px" src="<?php echo get_template_directory_uri();?>/img/savemoney.jpg" alt="Selling simplified">
                            </div>
                            <div class="speciality__content">
                                <h3 class="heading-3 heading-3--secondary">Save money on commisions</h3>                            
                                <p>As a seller, you're bound to face a parade of taxes, fees, commissions, and miscellaneous closing costs that can whittle away up to 4-7% of your home's sale price. This does not include any cost of repairs needed to bring your home up to market condition. We give you a fast and fair offer, so you can move on with your life.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-1-of-3">
                        <div class="speciality light-shadow  generic-text generic-text--justified-content">
                            <div class="speciality__photo">
                                <img class="speciality__img" sizes="160px" src="<?php echo get_template_directory_uri();?>/img/close.jpg" alt="Selling simplified">
                            </div>
                            <div class="speciality__content">
                                <h3 class="heading-3 heading-3--secondary">Close when you want</h3>                            
                                <p>
                                    A typical real estate sale using conventional mortage takes <a href="https://www.realtor.com/advice/buy/how-long-does-it-take-to-close-on-a-house/">50 days</a> for closing. During this time buyers, title companies and banks do their due diligence for the sale of your home. Many times the sale falls through and the seller loses both time and money. As professional investors, we have the capability to expedite the title work and avail money in as little as 7 days.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    


<div class="row">

</div>    


    </main>


<?php get_footer();?>
