<?php
global $nokri;

$user_id = get_current_user_id();


$job_id = '';
$post_in = array();
if (isset($_GET['zoom-scheduled']) && isset($_GET['job-id'])) {
    $job_id = $_GET['job-id'];

    $args = array(
        'post_type' => 'job_post',
        'orderby' => 'date',
        'order' => 'DESC',
        'author' => $user_id,
        'post_status' => array('publish'),
        'meta_query' => array(
            array(
                'key' => '_job_status',
                'value' => 'active',
                'compare' => '='
            )
        )
    );
} else {
//        add_filter( 'posts_where', function ( $where, \WP_Query $q )
//        { 
//            if ( true !== $q->get( '_zoom_meeting-' ) ){return $where; }
//            $where = str_replace( 'meta_key =', 'meta_key LIKE', $where );
//            return $where;
//        }, 10, 2 );     

    $args = array(
        'post_type' => 'job_post',
        'orderby' => 'date',
        'order' => 'DESC',
        'author' => $user_id,
        'post_status' => array('publish'),
        'meta_query' => array(
            array(
                'key' => '_job_status',
                'value' => 'active',
                'compare' => '='
            )
        )
    );
}
$args = nokri_wpml_show_all_posts_callback($args);
$getPosts = new WP_Query($args);

if (isset($_GET['job-id']) && $_GET['job-id'] != "") {

    $job_id = $_GET['job-id'];
    $query = "SELECT *  FROM $wpdb->postmeta WHERE post_id = '$job_id' AND meta_key like '_zoom_meeting-%' ";
    $results = $wpdb->get_results($query);
    $data = array();
    $tr = "";
    $btns = "";
    foreach ($results as $result) {

        $value = isset($result->meta_value) ? $result->meta_value : "";
        $data_arr = $value != "" ? unserialize($value) : array();

        if (is_array($data_arr) && !empty($data_arr)) {
            $meeting_id = isset($data_arr['_nokri_meet_id']) ? $data_arr['_nokri_meet_id'] : "";
            $job_id = isset($data_arr['_nokri_job_id']) ? $data_arr['_nokri_job_id'] : "";
            $cand_id = isset($data_arr['_nokri_cand_id']) ? $data_arr['_nokri_cand_id'] : "";
            $topic = isset($data_arr['_nokri_meet_topic']) ? $data_arr['_nokri_meet_topic'] : "";
            $meeting_time = isset($data_arr['_nokri_meet_time']) ? $data_arr['_nokri_meet_time'] : "";
            $join_url = isset($data_arr['_nokri_meet_joinurl']) ? $data_arr['_nokri_meet_joinurl'] : "";
            $duration = isset($data_arr['_nokri_meet_duration']) ? $data_arr['_nokri_meet_duration'] : "";

            //$meeting_data = get_user_meta($user_id, '_zoom_meeting-' . $cand_id . '-' . $job_id, true);
            $zoom_meet_time = date_i18n("F j, Y g:i a", strtotime($meeting_time));

            $action = '<ul class="list-inline">
                        <li class="tool-tip" title="' . esc_html__('Start Meeting', 'nokri') . '"> <a href="' . $join_url . '"  data-applierId="' . esc_attr($cand_id) . '" data-jobid="' . esc_attr($job_id) . ' class="label label-success   start_single_meeting"> <i class="ti-video-camera"></i></a></li>
                        <li class="tool-tip" title="' . esc_html__('Edit Meeting', 'nokri') . '"> <a href="javascript:void(0)"   data-applierId="' . esc_attr($cand_id) . '" data-jobid="' . esc_attr($job_id) . '" data-meetid="' . esc_attr($meeting_id) . '" class="label label-info  nokri_zoom_edit_meeting"> <i class="ti-pencil-alt"></i></a></li>
                        <li class="tool-tip" title="' . esc_html__('Deletet Meeting', 'nokri') . '"><a   href="javascript:void(0)"  data-applierId="' . esc_attr($cand_id) . '" data-jobid="' . esc_attr($job_id) . '" data-meetid="' . esc_attr($meeting_id) . '" class="label label-danger del_single_meeting"> <i class="ti-trash"></i></a></li>
                      </ul>';

            $tr .= '<tr>
                <td>' . $meeting_id . '</td>
                <td>' . $topic . '</td>
                <td>' . $zoom_meet_time . '</td>                   
                <td>' . $duration . '</td>                       
                <td>' . $action . '</td>
            </tr>';
        }
    }
    ?>
    <div class="main-body">
        <div class="dashboard-job-stats followers">
            <h4><?php echo esc_html__('Zoom Meetings List', 'nokri') . " : " . get_the_title($job_id); ?></h4>
            <div class="dashboard-posted-jobs">
                <table class="table dashboard-table table-fit"> 
                    <thead>
                        <tr class="header-title">
                            <th> <?php echo esc_html__('Meeting id', 'nokri'); ?></th>
                            <th> <?php echo esc_html__('Meeting Topic', 'nokri'); ?></th>
                            <th> <?php echo esc_html__('Meeting Time', 'nokri'); ?></th>
                            <th> <?php echo esc_html__('Duration', 'nokri'); ?></th>
                            <th> <?php echo esc_html__('Actions', 'nokri'); ?></th>
                        </tr>
                    </thead>
                    <tbody><?php echo ''.($tr); ?></tbody>                
                </table>
            </div>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="main-body">
        <div class="dashboard-job-stats followers">
            <h4><?php echo esc_html__('Jobs List', 'nokri'); ?></h4>
            <div class="dashboard-posted-jobs">

                <table class="table dashboard-table table-fit"> 
                    <thead>
                        <tr class="header-title">
                            <th> <?php echo esc_html__('Id', 'nokri'); ?></th>
                            <th> <?php echo esc_html__('job Title', 'nokri'); ?></th>
                            <th> <?php echo esc_html__('Actions', 'nokri'); ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if ($getPosts->have_posts()) {
                            while ($getPosts->have_posts()) {
                                $getPosts->the_post();
                                ?>
                                <tr>
                                    <td><?php echo get_the_ID() ?></td>
                                    <td><?php echo get_the_title() ?></td>
                                    <td><a href ="?tab-data=zoom-scheduled&job-id=<?php echo get_the_ID() ?>"><?php echo esc_html__('View Meetings', 'nokri'); ?></a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
}