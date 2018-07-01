<?php
add_action('rest_api_init', 'reiRegisterSearch');

function reiRegisterSearch(){
    register_rest_route('rei/v1', 'search', array(
        'methods' =>  WP_REST_SERVER::READABLE, //'GET',
        'callback' => 'reiSearchResults'
    ));    
}

function reiSearchResults($data){
    $mainQuery  = new WP_Query(array(
        'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
        's' =>  sanitize_text_field($data['term'])
    ));

    $results = array(
        'generalInfo' => array(),
        'professors' => array(),
        'programs' => array(),
        'campuses' => array(),
        'events' => array()
    );

    while($mainQuery->have_posts()){
        $mainQuery->the_post();
        if( get_post_type() == 'post' || get_post_type()== 'page'){
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink( ),
                'postType' => get_post_type(),
                'authorName' => get_the_author()
            ));
        }
        if( get_post_type() == 'program'){
            $relatedCampuses = get_field('related_campus');

            if($relatedCampuses){
                foreach($relatedCampuses as $campus){
                    array_push($results['campuses'], array(
                        'title' => get_the_title($campus),
                        'permalink' => get_the_permalink($campus),
                        'postType' => 'campus'
                    ));

                }
            }

            array_push($results['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink( ),
                'postType' => get_post_type(),
                'id' => get_the_id(),
            ));
            
        }        
        if( get_post_type() == 'professor'){
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink( ),
                'postType' => get_post_type(),
                'image' => get_the_post_thumbnail_url( 0,'cropped300' )
            ));
        }        
        if( get_post_type() == 'campus'){
            array_push($results['campuses'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink( ),
                'postType' => get_post_type()
            ));
        }        
        if( get_post_type() == 'event'){
            $eventDate = new DateTime(get_field('event_date'));
            $description = NULL;
            if(has_excerpt()){
                $description = get_the_excerpt(); //the_excerpt may add extra <p> </p> tag in the markup
            }else{
                $description = wp_trim_words( get_the_content(),20);
            }
                        
            
            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink( ),
                'postType' => get_post_type(),
                'month' => $eventDate->format('M'),
                'day' => $eventDate->format('d'),
                'description' => $description
            ));
        }        
        

    }

    if($results['programs']){
        $programsMetaQuery = array('relation' => 'OR');
        foreach($results['programs'] as $item){
            array_push($programsMetaQuery, array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . $item['id'] . '"'
            ));
        }
        $programRelationshipQuery = new WP_Query(array(
            'post_type' => array('professor', 'event'),
            'meta_query' => $programsMetaQuery
        ));

        wp_reset_postdata();



        while($programRelationshipQuery->have_posts()){
            $programRelationshipQuery->the_post();
    
            if( get_post_type() == 'professor'){
                array_push($results['professors'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink( ),
                    'postType' => get_post_type(),
                    'image' => get_the_post_thumbnail_url( 0,'cropped300' )
                ));
            } 


            if( get_post_type() == 'event'){
                $eventDate = new DateTime(get_field('event_date'));
                $description = NULL;
                if(has_excerpt()){
                    $description = get_the_excerpt(); //the_excerpt may add extra <p> </p> tag in the markup
                }else{
                    $description = wp_trim_words( get_the_content(),20);
                }
                            
                
                array_push($results['events'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink( ),
                    'postType' => get_post_type(),
                    'month' => $eventDate->format('M'),
                    'day' => $eventDate->format('d'),
                    'description' => $description
                ));
            }      
        }
    
        $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
        $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
    }


    return $results;

}


