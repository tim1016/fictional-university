<?php  

$names = array('Brad', 'John', 'Jack', 'Bob', 'Rob');

$count = 0;

while ($count < count($names))
{
   echo "<h1> The name is $names[$count]   </h1>";
   $count++;
}
?> 


<?php  
/*
while(have_posts()){
  
   ?> <h2> <?php
          echo bloginfo('title'); ?>
      </h2> 
<h2> <?php
          echo bloginfo('admin_email'); ?>
      </h2>

<h2> <?php
          $b= get_bloginfo('template_directory'); 
      echo "get_bloginfo: $b" ;?>
      </h2>
<h2> <?php
          echo bloginfo('template_directory'); ?>
      </h2> 

<h2> <?php
          echo bloginfo('template_url'); ?>
      </h2> 
<h2> <?php
          echo bloginfo('version'); ?>
      </h2> 
   
   <?php
   the_post(); break;
}
*/
?>
