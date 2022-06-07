<?php
get_header();
/* Template Name: Indeed search */
global $nokri;

$publisher_id    = isset($nokri['nokri_indeed_publisher_id']) ? $nokri['nokri_indeed_publisher_id'] : '';
$job_title       = isset($_GET['job-title']) ? $_GET['job-title'] : 'web developer';
$job_country     = isset($_GET['con']) ? $_GET['con'] : '';
$job_loc         = isset($_GET['job-loc']) ? $_GET['job-loc'] : '';
$job_type        = isset($_GET['jt']) ? $_GET['jt'] : '';
$sort_by         = isset($_GET['order_job']) ? $_GET['order_job'] : 'date';
$jobs_num        = isset($_GET['jn']) ? $_GET['jn'] : '25';
$job_expiry      = isset($_GET['jd']) ? $_GET['jd'] : '';
$jobs_by         = isset($_GET['jb']) ? $_GET['jb'] : '';
$fromage         = isset($_GET['frm']) ? $_GET['frm'] : '';
$current_page    = get_query_var('paged'); 

$start           =  ($current_page != ''  && $current_page != 1)   ?   ($current_page -1)*10 :  "";



$user_agent = esc_url($_SERVER['HTTP_USER_AGENT']);

$final_url = "https://api.indeed.com/ads/apisearch?publisher=$publisher_id&q=$job_title&l=$job_loc&sort=$sort_by&radius=&st=&jt=$job_type&start=$start&limit=10&format=json&fromage=$fromage&filter=&latlong=1&co=$job_country&chnl=&userip=1.2.3.4&useragent=$user_agent&v=2";
$request = wp_remote_get($final_url);
$req_body = wp_remote_retrieve_body($request);
$data = json_decode($req_body);
$jobs_result = isset($data->results) ? $data->results : array();


$total_result = isset($data->totalResults) ? $data->totalResults : 0;
$country_array = array();
$country_array = array("Argentina" => "ar", "Australia" => "au", "Austria" => "at", "Bahrain" => "h", "Belgium" => "be", "Brazil" => "br",
    "Canada" => "ca", "Chile" => "cl", "China" => "cn", "Colombia" => "co", "Czech Republic" => "cz", "Denmark" => "dk", "Finland" => "fi", "France" => "fr",
    "Germany" => "de", "Greece" => "gr", "Hong Kong" => "hk", "Hungary" => "hu", "India" => "in", "Indonesia" => "id", "Ireland" => "ie", "Israel" => "il", "Italy" => "it",
    "Japan" => "jp", "Korea" => "kr", "Kuwait" => "kw", "Luxembourg" => "lu", "Malaysia" => "my", "Mexico" => "mx", "nl" => "ar", "New Zealand" => "nz",
    "Norway" => "no", "Oman" => "om", "Pakistan" => "pk", "Peru" => "pe", "Philippines" => "ph", "Poland" => "pl", "Portugal" => "pt", "Qatar" => "qt", "Romania" => "ro", "Russia" => "ru",
    "Saudi Arabia" => "sa", "Singapore" => "sg", "South Africa" => "za", "Spain" => "es", "Sweden" => "se", "Switzerland" => "ch", "Taiwan" => "tw", "Thailand" => "th",
    "Turkey" => "tr", "United Arab Emirates" => "ae", "United Kingdom" => "gb", "United States" => "us", "Venezuela" => "ve", "Vietnam" => "vn"
);

$job_type_arr = array("Full time" => "fulltime", "Part time" => "parttime", "Contract" => "contract", "Internship" => "internship", "Temporary" => "temporary");

$jobs_number_switch = isset($nokri['nokri_indeed_jobsnumber_switch']) ? $nokri['nokri_indeed_jobsnumber_switch'] : false;

$message = __('Available Jobs', 'nokri');
?>
<section class="n-search-page" >
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">                                            
                        <aside class="new-sidebar">                       
                            <div class="heading">
                                <h4> <?php echo esc_html__("Search Filters", "nokri"); ?></h4>
                                <a href="<?php echo get_the_permalink($nokri['sb_indeeed_search_page']); ?>"><?php echo esc_html__("Clear All", "nokri"); ?></a>
                                <?php if (wp_is_mobile()) { ?>
                                    <a role="button" class="" data-toggle="collapse" href="#accordion" aria-expanded="true" id="panel_acordian"></a>
                                <?php } ?>
                            </div>   

                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading tab-collapsed " role="tab">
                                        <a role="button" data-toggle="collapse" href="#job_keyword" aria-expanded="true" class="">
                                            <?php echo esc_html__('Job Keyword', 'nokri') ?>     </a>
                                    </div>
                                    <div id="job_keyword" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
                                        <div class="panel-body">                 
                                            <form role="search" method="get" action="<?php get_the_permalink($nokri['sb_indeeed_search_page']); ?>" class="custom-search-form">
                                                <div class="form-group">
                                                    <input type="text" id="autocomplete-dynamic" autocomplete="off" class="form-control" name="job-title" value="<?php echo esc_attr($job_title) ?>" placeholder="<?php echo esc_attr__('Job title, keywords, or company ', 'nokri') ?>">
                                                    <button type="submit" class="btn n-btn-flat btn-mid"><i class="fa fa-search"></i></button>
                                                </div>
                                                <div class="form-group form-action">
                                                </div>
                                                <?php echo nokri_search_params('job-title'); ?>
                                            </form>               
                                        </div>
                                    </div>
                                </div>

                            </div>  

                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading tab-collapsed " role="tab">
                                        <a role="button" data-toggle="collapse" href="#job_country" aria-expanded="true" class="">
                                            <?php echo esc_html__('Job Country', 'nokri') ?>     </a>
                                    </div>
                                    <div id="job_country" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
                                        <div class="panel-body">                 
                                            <form method="GET" id="job_order_search">
                                                <div class="form-group">
                                                    <select class="js-example-basic-single form-control " data-allow-clear="true" data-placeholder="<?php echo esc_html__("Select Option", "nokri"); ?>" style="width: 100%" name="con" id="con">
                                                        <option><?php echo esc_html__('Select country', 'nokri') ?>
                                                            <?php
                                                            $selected = '';
                                                            foreach ($country_array as $key => $value) {
                                                                ?>

                                                            <option value="<?php echo esc_attr($value); ?>" 
                                                            <?php
                                                            if ($job_country == $value) {
                                                                echo "selected";
                                                            }
                                                            ?>><?php echo esc_html($key) ?></option>

                                                        <?php } ?>                                              
                                                    </select>
                                                </div>
                                                <?php echo nokri_search_params('con'); ?>
                                                <input type="button" class="btn n-btn-flat btn-mid location_search" id="location_search_btn" value="Search">

                                            </form>              
                                        </div>
                                    </div>
                                </div>

                            </div>  

                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading tab-collapsed " role="tab">
                                        <a role="button" data-toggle="collapse" href="#job_loc" aria-expanded="true" class="">
                                            <?php echo esc_html__('Job Location', 'nokri') ?>     </a>
                                    </div>
                                    <div id="job_loc" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
                                        <div class="panel-body">                 
                                            <form role="search" method="get" action="<?php get_the_permalink($nokri['sb_indeeed_search_page']); ?>" class="custom-search-form">
                                                <div class="form-group">
                                                    <input type="text" id="autocomplete-dynamic" autocomplete="off" class="form-control" name="job-loc" value="<?php echo esc_attr($job_loc) ?>" placeholder="<?php echo esc_attr__('city, province, or region', 'nokri') ?>">
                                                    <button type="submit" class="btn n-btn-flat btn-mid"><i class="fa fa-search"></i></button>
                                                </div>
                                                <div class="form-group form-action">
                                                </div>
                                                <?php echo nokri_search_params('job-loc'); ?>
                                            </form>               
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading tab-collapsed " role="tab">
                                        <a role="button" data-toggle="collapse" href="#job_type" aria-expanded="true" class="">
                                            <?php echo esc_html__('Job Type', 'nokri') ?>     </a>
                                    </div>
                                    <div id="job_type" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
                                        <div class="panel-body">                 
                                            <form method="GET" id="job_order_search">
                                                <div class="form-group">
                                                    <select class="js-example-basic-single form-control " data-allow-clear="true" data-placeholder="<?php echo esc_html__("Select Option", "nokri"); ?>" style="width: 100%" name="jt" id="jt">
                                                        <option><?php echo esc_html__('Select Job Type', 'nokri') ?>
                                                            <?php
                                                            $selected = '';
                                                            foreach ($job_type_arr as $key => $value) {
                                                                ?>

                                                            <option value="<?php echo esc_attr($value); ?>" 
                                                            <?php
                                                            if ($job_type == $value) {
                                                                echo "selected";
                                                            }
                                                            ?>><?php echo esc_html($key) ?></option>

                                                        <?php } ?>                                              
                                                    </select>
                                                </div>
                                                <?php echo nokri_search_params('jt'); ?>
                                                <input type="button" class="btn n-btn-flat btn-mid location_search" id="location_search_btn" value="Search">

                                            </form>              
                                        </div>
                                    </div>
                                </div>

                            </div>  

                            <?php if ($jobs_number_switch) { ?>
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading tab-collapsed " role="tab">
                                            <a role="button" data-toggle="collapse" href="#job_from" aria-expanded="true" class="">
                                                <?php echo esc_html__('Job Days', 'nokri') ?>     </a>
                                        </div>
                                        <div id="job_from" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
                                            <div class="panel-body">                 
                                                <form role="search" method="get" action="<?php get_the_permalink($nokri['sb_indeeed_search_page']); ?>" class="custom-search-form">
                                                    <div class="form-group">
                                                        <input type="number" id="autocomplete-dynamic" autocomplete="off" class="form-control" name="frm" value="<?php echo esc_attr($fromage); ?>" placeholder="<?php echo esc_attr__('Jobs days', 'nokri') ?>">
                                                        <button type="submit" class="btn n-btn-flat btn-mid"><i class="fa fa-search"></i></button>
                                                    </div>
                                                    <div class="form-group form-action">
                                                    </div>
                                                    <?php echo nokri_search_params('frm'); ?>
                                                </form>               
                                            </div>
                                        </div>
                                    </div>

                                </div>  

                            <?php } ?>

                        </aside>                   
                    </div>

                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="n-search-main">
                            <div class="n-bread-crumb">
                                <ol class="breadcrumb">
                                    <li> <a href="javascript:void(0)"><?php echo esc_html__("Home", "nokri"); ?></a></li>
                                    <li class="active"><a href="javascript:void(0);" class="active"><?php echo esc_html__("Indeed Search Page", "nokri"); ?></a></li>
                                    <li><span id="indeed_at"><a href="https://www.indeed.com/" rell="nofollow" >jobs</a> by <a href="https://www.indeed.com/" rell="nofollow" title="Job Search"><img src="https://www.indeed.com/p/jobsearch.gif" style="border: 0; vertical-align: middle;" alt="Indeed job search"></a></span>    </li>
                                </ol>
                            </div>
                           
                            <div class="heading-area">
                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <h4><?php echo esc_html($message) . " " . '(' . esc_html($total_result) . ')'; ?></h4>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <form method="GET" id="emp_active_job">
                                            <select class="js-example-basic-single form-control emp_active_job" data-allow-clear="true" data-placeholder="<?php echo esc_html__("Select Option", "nokri"); ?>" style="width: 100%" name="order_job" id="order_job">
                                                <option value="" ><?php echo esc_html__("Select Option", "nokri"); ?></option>
                                                <option value="date" <?php
                                                if ($sort_by == 'date') {
                                                    echo "selected";
                                                };
                                                ?>><?php echo esc_html__("Date", "nokri"); ?></option>
                                                <option value="relevance" <?php
                                                if ($sort_by == 'relevance') {
                                                    echo "selected";
                                                };
                                                ?>><?php echo esc_html__("Relevance", "nokri"); ?></option>
                                            </select>
                                            <?php echo nokri_form_lang_field_callback(true); ?>
                                        </form>
                                    </div>
                                </div>
                            </div>                       
                            <div class="n-search-listing n-featured-jobs">    

                                <div class="n-featured-job-boxes">

                                    <?php
                                    /* Regular Search Query */
                                    if (count($jobs_result) > 0) {
                                        foreach ($jobs_result as $job) {
                                            $current_layout = $nokri['search_layout'];
                                            $layouts = array('list_1', 'list_2', 'list_3');
                                            ?>
                                            <div class="n-job-single ">
                                                <div class="n-job-img"><img src="http://localhost/nokri-wpml/wp-content/uploads/2018/09/ss-3-150x150.jpg" alt="image" class="img-responsive"></div>
                                                <div class="n-job-detail">

                                                    <ul class="list-inline">
                                                        <li class="n-job-title-box">
                                                            <h4><a href="<?php echo esc_attr($job->url); ?>"  rel="nofollow" onmousedown="indeed_clk(this,'0000');"><?php echo esc_html($job->jobtitle) ?></a></h4>
                                                            <p>
                                                                <span><i class="ti-tag"></i> <a href="http://localhost/nokri-wpml/search-page/?cat-id=106"><?php echo esc_html($job->company) ?></a></span><span><i class="ti-location-pin"></i> <a href="http://localhost/nokri-wpml/search-page/?job-location=76"><?php echo esc_html($job->formattedLocationFull) ?></a></span>
                                                            </p>

                                                        </li>
                                                        <li class="n-job-short">

                                                            <span> <strong><?php echo esc_html__('Posted:', 'nokri') ?></strong><?php echo esc_html($job->formattedRelativeTime) ?></span>
                                                        </li>
                                                        <li class="n-job-btns">
                                                            <a href="<?php echo esc_attr($job->url); ?>" class="btn n-btn-rounded" rel="nofollow" onmousedown="indeed_clk(this,'0000');"><?php echo esc_html__('Apply Now', 'nokri'); ?> </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="clearfix"></div>

                                
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
                                        <nav aria-label="Page navigation">
                                            <?php echo indeed_job_pagination($total_result ,$current_page ); ?>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--footer section-->
<?php
get_footer();
