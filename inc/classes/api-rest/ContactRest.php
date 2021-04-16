<?php


class ContactRest
{
    public static  $instance;


    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ContactRest();
        }

        return self::$instance;
    }
    public  function init(){

        add_action('rest_api_init', array($this, 'registerRoute'));

    }
    public function registerRoute(){
        register_rest_route('api/v1','/contacts',array(
            'methods'=> 'POST',
            'callback'=> array($this,'setContact')
        ));
    }
    public  function setContact($request){


        $values = $request->get_json_params();

        $contactName = $values['contact_name'];
        $contactEmail = $values['contact_email'];
        $phone = $values['phone'];
        $msg = $values['message'];
        $date = $values['date'];




        if (!check_ajax_referer('wp_rest', '_wpnonce', false)) {
            return ['ok'=>false,
                   'msg'=> "invalid nonce"];
        }
        if(empty($contactName)
            ||empty($contactEmail)
            ||empty($phone)
            ||empty($msg)
            ||empty($date)

            ){
            return ['ok'=>false,
                'msg'=> "Not Empty fields"];
        }
        $contact = [
          'post_title'=> "$contactName+$contactEmail",
          'post_type'=>'contact',
            'post_status'   => 'publish'
        ];


        $post_id = wp_insert_post( $contact );

        update_post_meta( $post_id, 'contact_name', $contactName );
        update_post_meta( $post_id, 'contact_email', $contactEmail );
        update_post_meta( $post_id, 'phone', $phone );
        update_post_meta( $post_id, 'message', $msg );
        update_post_meta( $post_id, 'date', $date );

        $to = $contactEmail;
        $subject = "Hello from Dude";
        $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\"><head> <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
                <title>Contacto</title></head><body><p>Hello $contactName sooner we will be in touch with you </p></body></html>";

        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail( $to, $subject, $body, $headers );

        return ['ok'=>true,
            'msg'=> "successful added"];

    }
}

$contactRest = ContactRest::getInstance();
$contactRest->init();