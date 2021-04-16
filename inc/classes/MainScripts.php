<?php


class MainScripts
{
    private  $main_css_path = '';
    private  $css_path = '';
    private  $scss_path = '';
    private  $font_path = '';
    private  $js_path = '';

    public  function init()
    {

        $this->main_css_path =DU_THEME_URL;
     //   self::$css_path = DU_THEME_CSS_URL;
       $this->scss_path = DU_THEME_SCSS_URL;
       $this->css_path = DU_THEME_CSS_URL;
      //  self::$font_path = DU_THEME_FONTS_DIR;
       $this->js_path = DU_THEME_JS_URL;

        add_action( 'wp_enqueue_scripts', array (
            $this,
            'enqueue_frontend'
        ) );


    }

    /**
     * Register and enqueue styles
     * @param array $styles
     * @return void
     */
    public static function _add_styles( $styles )
    {
        foreach ( $styles as $handle => $args )
        {
            if ( $args === true )
            {
                wp_enqueue_style( $handle );
            }
            elseif ( is_array( $args ) )
            {
                wp_register_style(
                    $handle,
                    $args['src'],
                    isset( $args['deps'] ) ? $args['deps'] : array (),
                    isset( $args['ver'] ) ? $args['ver'] : THEME_VERSION,
                    isset( $args['media'] ) ? $args['ver'] : 'all'
                );

                if ( !isset( $args['enqueue'] ) || (isset( $args['enqueue'] ) && $args['enqueue'] === true) )
                {
                    wp_enqueue_style( $handle );
                }
            }
        }
    }

    /**
     * Register and enqueue scripts
     * @param array $scripts
     * @return void
     */
    static function _add_scripts( $scripts )
    {
        foreach ( $scripts as $handle => $args )
        {
            if ( $args === true )
            {
                wp_enqueue_script( $handle );
            }
            elseif ( is_array( $scripts ) )
            {
                wp_register_script(
                    $handle,
                    $args['src'],
                    isset( $args['deps'] ) ? $args['deps'] : array (),
                    isset( $args['ver'] ) ? $args['ver'] : THEME_VERSION,
                    isset( $args['in_footer'] ) ? $args['in_footer'] : true
                );

                if ( !isset( $args['enqueue'] ) || (isset( $args['enqueue'] ) && $args['enqueue'] === true) )
                {
                    wp_enqueue_script( $handle );
                }

                if ( isset( $args['localize'] ) && is_array( $args['localize'] ) && !empty( $args['localize'] ) )
                {
                    wp_localize_script(
                        $handle,
                        str_replace( '-', '_', $handle ).'_params',
                        $args['localize']
                    );
                }

                if ( isset( $args['data'] ) && is_array( $args['data'] ) && !empty( $args['data'] ) )
                {
                    $data_args = $args['data'];

                    if ( isset( $data_args['key'] ) && isset( $data_args['value'] ) )
                    {
                        wp_script_add_data(
                            $handle,
                            $data_args['key'],
                            $data_args['value']
                        );
                    }
                }
            }
        }
    }

    public  function enqueue_frontend(){
        //$js_path = self::$js_path;
        $js_path= $this->js_path;
      $current_page = get_page_template_slug( get_queried_object_id() );

        $scripts['jquery'] = array (
            'src'=>'',
            'deps'=>'',
            'ver'=>'',
            'in_footer' => true
        );



        $scripts['bootstrap-js'] = array (
            'src' => $js_path.'/bootstrap.bundle.min.js',
            'deps' => array (),
            'ver' => THEME_VERSION,
            'in_footer' => true
        );
        $scripts['jquery-ui-js'] = array (
            'src' => $js_path.'/jquery-ui.min.js',
            'deps' => array (),
            'ver' => THEME_VERSION,
            'in_footer' => true
        );
        $scripts['sweetAlert2'] = array (
            'src' => 'https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js',
            'deps' => array (),
            'ver' => THEME_VERSION,
            'in_footer' => true
        );
        $scripts['custom'] = array (
            'src' => $js_path.'/custom.js',
            'deps' => array (),
            'ver' => THEME_VERSION,
            'in_footer' => true,
            'localize'=>array(
                'wp_rest'=> wp_create_nonce('wp_rest')
            )
        );


        // Add Styles
        $this->_add_styles($this->_load_frontend_styles( $current_page ) );
        // Add Scripts
        $this->_add_scripts( $scripts );
    }

    private   function _load_frontend_styles( $current_page )
    {

        $main_path = $this->main_css_path;
        //$font_path = self::$font_path;

        $scss_path = $this->scss_path;
        $css_path = $this->css_path;


        //General Styles
        $styles['style'] = [
            'src' => $main_path . '/style.css'

        ];
        $styles['bootstrap'] = [
            'src' => $css_path.'/bootstrap.min.css'
        ];
        $styles['jquery-ui-css'] = [
            'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css'
        ];
        $styles['main'] = [
            'src' => $scss_path.'/main.css'
        ];



        return $styles;
    }


}
$scripts = new MainScripts();
$scripts->init();