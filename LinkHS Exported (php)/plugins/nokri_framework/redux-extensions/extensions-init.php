<?php
    // All extensions placed within the extensions directory will be auto-loaded for your Redux instance.
  
$vc   =  isset($_REQUEST['vc_editable']) ?  $_REQUEST['vc_editable'] : "";


if(!$vc){ 
    
Redux::setExtensions( 'nokri', dirname( __FILE__ ) . '/extensions/' );

}
   
    // Any custom extension configs should be placed within the configs folder.
    if ( file_exists( dirname( __FILE__ ) . '/configs/' ) ) {
        $files = glob( dirname( __FILE__ ) . '/configs/*.php' );
        if ( ! empty( $files ) ) {
            foreach ( $files as $file ) {
                include $file;
            }
        }
    }
/* Demo data parameters settings */
if ( !function_exists( 'nokri_framework_description_text' ) ) {
    function nokri_framework_description_text( $description ) {
        $message = '<p>'. esc_html__( 'Best if used on new WordPress install & this theme requires PHP version 7.0+', 'redux-framework' ) .'</p>';
        $message .= '<p>'. esc_html__( 'Images are for demo purpose only.', 'redux-framework' ) .'</p>';
        $message .= '
        <h3>What if the Import fails or stalls?</h3>
        If the import stalls and fails to respond after a few minutes You are suffering from PHP configuration limits that are set too low to complete the process. You should contact your hosting provider and ask them to increase those limits to a minimum as follows:
        </p>
        <ul style="margin-left: 60px">
            <li>max_execution_time 2000</li>
            <li>memory_limit 256M</li>
            <li>post_max_size 100M</li>
            <li>upload_max_filesize 32M</li>
        </ul>
        <p>You can verify your PHP configuration limits by installing a simple plugin found here: <a href="https://wordpress.org/plugins/wp-serverinfo/" target="_blank">https://wordpress.org/plugins/wp-serverinfo/</a>. And you can also check your PHP error logs to see the exact error being returned.</p>
        <p>If you were not able to import demo, please contact on our <a target="_blank" href="https://scriptsbundle.ticksy.com/"><b>support forum</b></a>, our technical staff will import demo for you.</p>
        ';
        return $message;
    }
    add_filter( 'wbc_importer_description', 'nokri_framework_description_text', 10 );
}
