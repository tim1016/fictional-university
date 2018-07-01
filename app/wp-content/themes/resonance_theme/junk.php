               <div class="post__item">
                    <h2 class="heading-3 primary post__item--title"><a href="<?php the_permalink(  );?>"><?php the_title( );?></a></h2>
                    <div class="metabox">
                        <p>Posted by <?php echo the_author_posts_link( );?> on <?php the_time('n.j.y')?> in <?php echo get_the_category_list( ', ' )?></p>
                    </div>
                    <div class="generic-text">
                    <?php the_excerpt();?>
                    </div>
                    <p><a class="btn-text" href="<?php the_permalink(  );?>"> Continue Reading &raquo; </a></p>
                </div>



                <div class="col-1-of-3">
                    <div class="card">
                        <div class="wrapper" style="background-image: url(<?php the_post_thumbnail_url('medium'); ?>);">
                            <div class="date">
                                <span class="day"><?php the_time('j')?></span>
                                <span class="month"><?php the_time('M')?></span>
                                <span class="year"><?php the_time('Y')?></span>
                            </div>
                            <div class="data">
                                <div class="content">
                                    <span class="author"><?php echo the_author_posts_link( );?></span>
                                    <h1 class="title"><a href="<?php the_permalink(  );?>"><?php the_title( );?></a></h1>
                                    <p class="text"><?php the_excerpt();?></p>
                                    <label for="show-menu" class="menu-button"><span></span></label>
                                </div>
                                <input type="checkbox" id="show-menu" />
                                <ul class="menu-content">
                                    <li>
                                        <a href="#" class="fa fa-bookmark-o"></a>
                                    </li>
                                    <li><a href="#" class="fa fa-heart-o"><span>47</span></a></li>
                                    <li><a href="#" class="fa fa-comment-o"><span>8</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>   