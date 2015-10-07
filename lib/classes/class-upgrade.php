<?php
/**
 * WP-Property Upgrade Handler
 *
 * @since 2.1.0
 * @author peshkov@UD
 */
namespace UsabilityDynamics\WPP {

  if( !class_exists( 'UsabilityDynamics\WPP\Upgrade' ) ) {

    class Upgrade {

      /**
       * Run Upgrade Process
       *
       * @param $old_version
       * @param $new_version
       */
      static public function run( $old_version, $new_version ){

        self::do_backup( $old_version, $new_version );

        /**
         * WP-Property 1.42.4 and less compatibility
         */
        update_option( "wpp_version", $new_version );

        /**
         * Specific upgrade conditions.
         */
        switch( true ) {

          case ( version_compare( $old_version, '2.1.0', '<' ) ):
            /*
             * Enable Legacy Features
             */
            $settings = get_option( 'wpp_settings' );
            if( !empty( $settings[ 'configuration' ] ) ) {
              $settings[ 'configuration' ][ 'enable_legacy_features' ] = 'true';
            }
            update_option( 'wpp_settings', $settings );
            break;

        }

        /* Additional stuff can be handled here */
        do_action( ud_get_wp_property()->slug . '::upgrade', $old_version, $new_version );
      }

      /**
       * Saves backup of WPP settings to uploads and to DB.
       *
       * @param $old_version
       * @param $new_version
       */
      static public function do_backup( $old_version, $new_version ) {
        /* Do automatic Settings backup! */
        $settings = get_option( 'wpp_settings' );

        if( !empty( $settings ) ) {

          /**
           * Fixes allowed mime types for adding download files on Edit Product page.
           *
           * @see https://wordpress.org/support/topic/2310-download-file_type-missing-in-variations-filters-exe?replies=5
           * @author peshkov@UD
           */
          add_filter( 'upload_mimes', function( $t ){
            if( !isset( $t['json'] ) ) {
              $t['json'] = 'application/json';
            }
            return $t;
          }, 99 );

          $filename = md5( 'wpp_settings_backup' ) . '.json';
          $upload = wp_upload_bits( $filename, null, json_encode( $settings ) );

          if( !empty( $upload ) && empty( $upload[ 'error' ] ) ) {
            if( isset( $upload[ 'error' ] ) ) unset( $upload[ 'error' ] );
            $upload[ 'version' ] = $old_version;
            $upload[ 'time' ] = time();
            update_option( 'wpp_settings_backup', $upload );
          }

        }
      }

    }

  }

}
