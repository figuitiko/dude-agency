<?php


class SubscribersRest
{
    public static  $instance;


    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SubscribersRest();
        }

        return self::$instance;
    }
    public  function init(){

        add_action('rest_api_init', array($this, 'registerRoute'));

    }
    public function registerRoute(){
        register_rest_route('api/v1','/subscribers',array(
            'methods'=> 'POST',
            'callback'=> array($this,'setSubscriber')
        ));
    }
    public  function setSubscriber($request){
       //$body = WP_REST_Request::get_json_params();

        $values = $request->get_json_params();
        $name = $values['name'];
        $email = $values['email'];




        if (!check_ajax_referer('wp_rest', '_wpnonce', false)) {
            return ['ok'=>false,
                   'msg'=> "invalid nonce"];
        }
        if(empty($name)||empty($email)){
            return ['ok'=>false,
                'msg'=> "Not Empty fields"];
        }
        $subscriber = [
          'post_title'=> "$name+$email",
          'post_type'=>'subscriber',
            'post_status'   => 'publish'
        ];


        $post_id = wp_insert_post( $subscriber );

        update_post_meta( $post_id, 'name', $name );
        update_post_meta( $post_id, 'email', $email );

        return ['ok'=>true,
            'msg'=> "successful added"];

    }
}

$subscriberRest = SubscribersRest::getInstance();
$subscriberRest->init();