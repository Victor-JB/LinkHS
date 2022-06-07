<?php

/* Template Name: Resume generator */



$user_id    =   isset($_GET['user_id'])   ? $_GET['user_id'] : "";
$current_user_id   = get_current_user_id();
$reg_type   = get_user_meta($current_user_id ,'_sb_reg_type',true);



if($user_id != $current_user_id  &&  $reg_type != 1){
    get_header();
 echo  '<section class="n-candidate-detail cand-reume-3">
            <div class="container">
                <div class="row">  
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                           <div class="locked-profile alert alert-danger fade in" role="alert">
                               <i class="la la-lock"></i>'. esc_html__('Sorry You are not Allowed','nokri').'
                          </div>
                    </div>
                </div>
            </div>
        </section>';
 get_footer();
 die();
}

$temp_id = isset($_GET['tem_id']) ? $_GET['tem_id'] : "";
if ($temp_id == "1") {
    require trailingslashit(get_template_directory()) . "/template-parts/cv-templates/template-1.php";
}

if ($temp_id == "2") {
    require trailingslashit(get_template_directory()) . "/template-parts/cv-templates/template-2.php";
}


if ($temp_id == "3") {
    require trailingslashit(get_template_directory()) . "/template-parts/cv-templates/template-3.php";
}
if ($temp_id == "4") {
    require trailingslashit(get_template_directory()) . "/template-parts/cv-templates/template-4.php";
}

$job_id = isset($_GET['job_id']) ? $_GET['job_id'] : "";


if($job_id !=  ""){
$job_title = get_the_title($job_id);
/* cand resume */

$resumes    =  isset($_GET['resumes']) ? $_GET['resumes'] : "";

$resumes   =   explode( ',', $resumes );

$pdf_files     =      array();
foreach ($resumes  as $resume){
       
    $file_path  =   wp_get_attachment_url($resume);     
    if($file_path !=""){
    $pdf_files[]   = $file_path;
    
    }
}

$zip = new ZipArchive();
$zip_name = " ";
$job_title = str_replace(',', '_', $job_title);
$zip_name = $job_title . "_" . ".zip"; // Zip name
$zip->open($zip_name, ZipArchive::CREATE);
if (!empty($pdf_files)) {    
    foreach ($pdf_files as $pdf_file) {
        $zip->addFromString(basename($pdf_file), WP_Filesystem($pdf_file));
    }
}
$zip->close();

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zip_name);
header('Content-Length: ' . filesize($zip_name));
ob_end_flush();
readfile($zip_name);
unlink($zip_name);
}
