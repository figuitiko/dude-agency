<?php


class MainClass
{
    private static  $instance = null;

    public function __construct() {
        $this->defineConstants();
        $this->includeFiles();

    }
    public static  function  getInstance(){
        if(self::$instance === null){
            self::$instance = new MainClass();
        }
        return self::$instance;
    }
    private function includeFiles(){
        include_once ('MainScripts.php');

    }
    private function  defineConstants(){
        $active_theme = wp_get_theme();
        define( 'DU_HOME', 'https://'.$_SERVER['HTTP_HOST'] );
        define( 'DU_SITEURL', 'https://'.$_SERVER['HTTP_HOST'] );
        define( 'THEME_NAME', $active_theme->get( 'Name' ) );
        define( 'THEME_VERSION', $active_theme->get( 'Version' ) );
        define( 'DU_THEME_LOCAL_MODE', true );
        define( 'DU_STYLE_DIR', get_stylesheet_uri() );
        define( 'DU_THEME_DIR', get_template_directory() );
        define( 'DU_THEME_DIR_URI', get_stylesheet_directory_uri() );
        define( 'DU_THEME_URL', get_template_directory_uri() );
        define( 'DU_THEME_SCSS_URL', DU_THEME_DIR_URI.'/inc/assets/scss' );
        define( 'DU_THEME_CSS_URL', DU_THEME_DIR_URI.'/inc/assets/css' );
        define( 'DU_THEME_JS_URL', DU_THEME_DIR_URI.'/inc/assets/js' );
        define( 'DU_THEME_IMG_URL', DU_THEME_DIR_URI.'/inc/assets/img' );
        //define( 'DU_THEME_FONTS_DIR', DU_THEME_DIR_URI.'/inc/assets/css/font' );

    }



}