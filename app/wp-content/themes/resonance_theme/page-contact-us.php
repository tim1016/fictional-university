<?php
 
  //response generation function

    $response = "";

    //function to generate response
    function my_contact_form_generate_response($type, $message){

        global $response;

        if($type == "success") $response = "<div class='success'>{$message}</div>";
        else $response = "<div class='error'>{$message}</div>";

    }

  //response messages
    $not_human       = "Human verification incorrect.";
    $missing_content = "Please supply all information.";
    $email_invalid   = "Email Address Invalid.";
    $message_unsent  = "Message was not sent. Try Again.";
    $message_sent    = "Thanks! Your message has been sent.";
    

    $name = $_POST['message_name'];
    $email = $_POST['message_email'];
    $message = $_POST['message_text'];
    $human = $_POST['message_human'];

    
    
    $to = $email; //
    $from=get_bloginfo('admin_email');
    //$from=get_option('admin_email');
    $subject = "Message from " . $from;
    $headers = array('Content-Type: text/html; charset=UTF-8');
    //$headers = 'From: '. $email . "\r\n" .
    //'Reply-To: ' . $from . "\r\n";

    //mail ('resonanceoncl@gmail.com', "Test Postfix", "Test mail from postfix");
 
    if(!$human == 0){
        if($human != 2) my_contact_form_generate_response("error", $not_human); //not human!
        else {
    
            //validate email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                my_contact_form_generate_response("error", $email_invalid);
            else //email is valid
            {
                //validate presence of name and message
                if(empty($name) || empty($message)){
                my_contact_form_generate_response("error", $missing_content);
                }
                else //ready to go!
                {
                $sent = wp_mail($to, $subject, strip_tags($message), $headers);
  //              if($sent) my_contact_form_generate_response("success", $sent); //message sent!
    //            else my_contact_form_generate_response("error", $sent); //message wasn't sent
                }
            }
        }
    }
    else if ($_POST['submitted']) my_contact_form_generate_response("error", $missing_content);
?>

  <?php
  /*
  require_once('recaptchalib.php');
  $privatekey = "6Le_YVcUAAAAAImJcNpaoT5gU-6HqiSGJH3XeGYS";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
  } else {
    // Your code here to handle a successful verification
  }
  */
  ?>



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
                    <?php 
                    echo "<p> Email will sent by " . $from  . " to " . $to . "with subject: " . $subject . " and headers: " . "</p>" ;
                    
                    ?>

                    <div id="respond">
                        <?php echo $response; ?>
                        <form action="<?php the_permalink(); ?>" method="post">
                            <p><label for="name">Name: <span>*</span> <br><input type="text" name="message_name" placeholder="Name" value="<?php echo esc_attr($_POST['message_name']); ?>"></label></p>
                            <p><label for="message_email">Email: <span>*</span> <br><input type="text" name="message_email" placeholder="Email" value="<?php echo esc_attr($_POST['message_email']); ?>"></label></p>
                            <p><label for="message_text">Message: <span>*</span> <br><textarea type="text" placeholder="Message" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea></label></p>
                            <p><label for="message_human">Human Verification: <span>*</span> <br><input type="text" style="width: 60px;" name="message_human"> + 3 = 5</label></p>
                            <input type="hidden" name="submitted" value="1">
                            <p><input type="submit"></p>
                        </form>
                    </div>
                </div>

            </div>

        </section>
    </main>

    



    <?php

}   

?>

<?php get_footer();?>
