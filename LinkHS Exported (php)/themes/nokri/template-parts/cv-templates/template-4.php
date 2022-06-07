<?php

require trailingslashit(get_template_directory()) . "/template-parts/cv-templates/candidate-info.php";

class Nokri_Pdf3 extends TCPDF {

    public function Footer() {

        $this->SetY(-15);
        $this->writeHTML("<hr>", true, false, false, false, 'T');
        $site_name = get_bloginfo('name');
        $site_url =  home_url('url');
        $created_by = esc_html__('Created by :','nokri') . esc_html($site_name);
        $this->SetY(-13);
        $this->SetY(-15);
        $this->SetFont('aefurat', '', 10);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetY(-15);
        $this->SetFont('aefurat', '', 10);
        $this->Cell(300, 10, $created_by, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

$ex_br = "<p></p>";
$cand_name = '<h1 class ="author_name">' . $author->display_name . '</h1>';

if($cand_headline != ""){  
$cand_headline  =    '<p class ="author_headline">'."(".$cand_headline.")".'</p>';
}
if($cand_phone !=""){
  $cand_phone = '<p class ="author_intro">' . $cand_phone . '</p>';  
}
    $cand_email = '<p class ="author_intro">' . $author->user_email . '</p>';

if($cand_address){
    $cand_address = '<p class ="author_intro">' . $cand_address . '</p>';
}

$about_sec = " ";
if ($cand_introd != " ") {
    $about_sec   .='<div class="wrapper">';
    $about_sec .= '<h1 style="font-size:20">' . nokri_feilds_label('cand_about', esc_html__('About me', 'nokri')) . '</h1>';
    $about_sec .= '<p style="font-size:11">' . $cand_introd . '</p>';
    $about_sec   .='</div>';
}
$cand_dp = "";
if ($image_link != "") {

    $cand_dp = '<img src="' . $image_link . '"  width="" height="">';
}
$cand_education = get_user_meta($user_crnt_id, '_cand_education', true);
$cand_education_html = "";
if ($cand_education && $cand_education[0]['degree_name'] != '') {
    $cand_education_html .= "<p></p>";
    $cand_education_html .= '<h1>' . nokri_feilds_label('cand_edu_lab', esc_html__('Education', 'nokri')) . '</h1>
        <div class="resume-timeline">';
    foreach ($cand_education as $edu) {
        $degre_name = (isset($edu['degree_name'])) ? esc_html($edu['degree_name']) : '';
        $degre_strt = (isset($edu['degree_start'])) ? $edu['degree_start'] : '';
        $degre_insti = (isset($edu['degree_institute'])) ? '<span class="institute-name">' . esc_html($edu['degree_institute']) . '</span>' : '';
        $degre_details = (isset($edu['degree_detail'])) ? '<p>' . ($edu['degree_detail']) . '</p>' : '';
        $degre_end = (isset($edu['degree_end'])) ? $edu['degree_end'] : '';


        $cand_education_html .= '<div class="resume-timeline-box">
                <span class="degree-duration">
                    ' . esc_html($degre_name) ."-"  . "(" . esc_html($degre_strt) . "   " . "-" . "   " . esc_html($degre_end) . ")" . '                  
                </span>
           ' . ($degre_insti) . ($degre_details) . '
            </div>';
    }
}

$cand_profession = get_user_meta($user_crnt_id, '_cand_profession', true);
$cand_profession_html = "";
if ($cand_profession && $cand_profession[0]['project_organization'] != '') {

    $cand_profession_html .= '<h1>' . nokri_feilds_label('cand_prof_lab', esc_html__('Work Experience', 'nokri')) . '</h1>
        <div class="resume-timeline">';
    foreach ($cand_profession as $profession) {
        $project_end = $profession['project_end'];
        if ($profession['project_end'] == '') {
            $project_end = esc_html__('Currently working', 'nokri');
        }
        $project_role = (isset($profession['project_role'])) ? esc_html($profession['project_role']) : '';
        $project_org = (isset($profession['project_organization'])) ? '<span class="institute-name">' . $profession['project_organization'] . '</span>' : '';
        $project_strt = (isset($profession['project_start'])) ? esc_html($profession['project_start']) : '';
        $project_detail = (isset($profession['project_desc'])) ? '<p>' . $profession['project_desc'] . '</p>' : '';
        $cand_profession_html .= '<div class="resume-timeline-box">
                <span class="degree-duration">
                   ' . esc_html($project_role) . "(" . esc_html($project_strt) . "   " . "-" . "   " . esc_html($project_end) . ")" . '                     
                </span>
           ' . ($project_org) . ($project_detail) . '
            </div>';
    }
}
$cand_certifications = get_user_meta($user_crnt_id, '_cand_certifications', true);
$cand_certificate_html = "";
if ($cand_certifications && $cand_certifications[0]['certification_name'] != '') {

    $cand_certificate_html .= '<h1>' . nokri_feilds_label('cand_certi_lab', esc_html__('Awards and Certificates', 'nokri')) . '</h1>
        <div class="resume-timeline">';
    foreach ($cand_certifications as $certification) {
        $certi_name = (isset($certification['certification_name'])) ? esc_html($certification['certification_name']) : '';
        $certi_durat = (isset($certification['certification_duration'])) ? '<span>' . esc_html($certification['certification_duration']) . '</span>' : '';
        $certi_inst = (isset($certification['certification_institute'])) ? '<p class="institute-name">' . $certification['certification_institute'] . "  " . $certi_durat . '</p>' : '';
        $certi_strt = (isset($certification['certification_start'])) ? esc_html($certification['certification_start']) : '';
        $certi_end = (isset($certification['certification_end'])) ? esc_html($certification['certification_end']) : '';
        $certi_detail = (isset($certification['certification_desc'])) ? '<span class="desc"><p>' . $certification['certification_desc'] . '</p></span>' : '';

        $cand_certificate_html .= '<div class="resume-timeline-box">
                <span class="degree-duration">
                    ' . esc_html($certi_name) . "(" . esc_html($certi_strt) . "   " . "-" . "   " . esc_html($certi_end) . ")" . '                   
                </span>
           ' . ($certi_inst) . ($certi_detail) . '
            </div>';
    }
}
$skills_bar = '';
$cand_skills = get_user_meta($user_crnt_id, '_cand_skills', true);
if (isset($cand_skills) && !empty($cand_skills) && count($cand_skills) > 0) {
    $skills_bar .= '<h1 style="font-size:20">' . nokri_feilds_label('cand_skills_label', esc_html__('Skills and tools', 'nokri')) . '</h1>';
    $skills_bar .= "<ul>";
    foreach ($cand_skills as $key => $csv) {
        $term = get_term_by('id', $csv, 'job_skills');
        if ($term) {

            $skills_bar .= '<li style="font-size:12"> ' . $term->name . ' </li>';
        }
    }
    $skills_bar .= "</ul>";
}
$pdf = new Nokri_Pdf3(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(get_bloginfo('name'));
$pdf->SetTitle($author->display_name);
$pdf->SetSubject(get_bloginfo('name'));
$pdf->SetKeywords(get_bloginfo('name'));

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 006', PDF_HEADER_STRING);

// set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setPrintHeader(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 5, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->AddPage();

 $html = <<<EOF
<style>
 
      .author_name{
      text-align: center;
      text-transform:capitalize;
      font-size: 40px; }
         .author_intro{
      text-align: center;
         line-height:0.3
      }
     .wrapper{
         text-align: center;
       }
.author_headline{
          text-align: center;
         line-height:-2;
         font-size:13
    }
         
   }

</style>
         
$ex_br
$cand_name
$cand_headline
$cand_email
$cand_phone
$cand_address
$ex_br
EOF;
 
 
 $pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(51, 61, 80);
$pdf ->SetFont('aefurat', 'B', 12);
$pdf->writeHTMLCell($pdf->getPageWidth(), '', 0, 0, $html, 0, 0, 1, true, 'J', true);


$html2   =  $about_sec.$cand_profession_html.$cand_education_html.$cand_certificate_html.$skills_bar;
$pdf->SetTextColor(0,0,0);
$pdf->writeHTMLCell($pdf->getPageWidth()-50, '', '', 60, $html2 , 0, 0, 0, true, 'J', true);
ob_end_clean();
$pdf->Output($author->display_name."_resumes", 'I');