<?php
/* Employer Email Templates */
global $nokri; 
$user_id	 =   get_current_user_id();
$meta_data   =   $template_name = $template_subject = $template_body = $template_id = $template_for = '';
if( isset( $_GET['edit-id'] ) && $_GET['edit-id'] != "" )
{	
	$template_id		= $_GET['edit-id'];
	$meta_data 			= get_user_meta($user_id, $template_id, true );
	$meta_data 			= nokri_base64Decode($meta_data);
	$val 				= json_decode( $meta_data, true );
	$template_name 		= $val['name'];
	$template_subject 	= $val['subject'];
	$template_for    	= $val['for'];
	$template_body 		= $val['body'];
	
}
/* Getting Applied Status */
$apllied_actions =  nokri_canidate_apply_status();
$options         = '';
foreach( $apllied_actions as $val => $key )
{
	$selected =   '';
	if ($template_for == $val)
	{
		$selected = "selected";
	}
  $options .= '<option value="'.esc_attr($val).'" '.$selected.'>'.esc_html($key).'</option>';
}
/* Employer Details For Email */
$emp_detials  =   get_user_by('id', $user_id);
$emp_name     =   $emp_detials->display_name;
$emp_headline =   get_user_meta( $user_id, '_user_headline',true);
$emp_web      =   get_user_meta( $user_id, '_emp_web',true);

if( $template_body == "" ) {
$template_body = '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 430px; padding: 10px; width: 430px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 430px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">'.$emp_headline.'</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">'.$emp_name.'</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
'.esc_html__( 'Your Message Here', 'nokri' ).'
&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">'.$emp_name.'</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="'.$emp_web.'">'.$emp_name.'</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>';
}
?>
<div class="cp-loader"></div>
<div class="main-body">
    <div class="dashboard-edit-profile">
        <h4 class="dashboard-heading"><?php echo esc_html__( 'Add Your Email Templates', 'nokri' ); ?></h4>
        <form method="post" enctype="multipart/form-data" id="create_email_template">
        <input type="hidden" value="<?php echo esc_attr($template_id); ?>" id="template_id" name="template_id" />
            <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label><?php echo esc_html__( 'Template Name', 'nokri' ); ?><span class="required">*</span>
                    </label>
                    <input type="text" placeholder="<?php echo esc_html__( 'Template name', 'nokri' ); ?>" required value="<?php echo esc_html($template_name); ?>" name="email_temp_name" class="form-control">
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label><?php echo esc_html__( 'Email Subject', 'nokri' ); ?><span class="required">*</span>
                    </label>
                    <input type="text" placeholder="<?php echo esc_html__( 'Email Subject', 'nokri' ); ?>" required value="<?php echo esc_html($template_subject);?>" name="email_temp_subject" class="form-control">
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                <label> <?php echo esc_html__( 'Template For', 'nokri' ); ?><span class="required">*</span></label>
                    <select  class="select-resume form-control" name="email_temp_for" required> 
                        <?php echo "".$options; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label><?php echo esc_html__( 'Description', 'nokri' ); ?><span class="required">*</span>
                    </label>
                    <textarea cols="6" rows="8" name="email_temp_details"  class="form-control rich_textarea"><?php echo "".$template_body;?></textarea>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <button class="btn n-btn-flat" id="temp_save"><?php echo esc_html__( 'Save Template', 'nokri' ); ?></button>
                <button class="btn n-btn-flat" type="button" id="temp_proc" disabled><?php echo  esc_html__( 'Processing...','nokri' ); ?></button>
            </div>
        </form>
    </div>
</div>
</div>