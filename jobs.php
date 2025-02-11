<?php
/**
 * Plugin Name: Job Listings
 * Description: A simple plugin to manage job listings with a custom post type.
 * Version: 2.0
 * Author: Your Name
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Register Custom Post Type
function job_listings_cpt() {
    $args = array(
        'labels'      => array(
            'name'          => __('Jobs', 'textdomain'),
            'singular_name' => __('Job', 'textdomain'),
        ),
        'public'      => true,
        'has_archive' => true,
        'supports'    => array('title', 'editor', 'custom-fields'),
        'menu_icon'   => 'dashicons-briefcase',
    );
    register_post_type('job', $args);
}
add_action('init', 'job_listings_cpt');

// Add Meta Box
function job_meta_boxes() {
    add_meta_box(
        'job_details',
        __('Job Details', 'textdomain'),
        'job_meta_box_callback',
        'job',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'job_meta_boxes');

function job_meta_box_callback($post) {
    $company_name = get_post_meta($post->ID, 'company_name', true);
    $location = get_post_meta($post->ID, 'location', true);
    $salary = get_post_meta($post->ID, 'salary', true);
    ?>
    <p>
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" value="<?php echo esc_attr($company_name); ?>" />
    </p>
    <p>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo esc_attr($location); ?>" />
    </p>
    <p>
        <label for="salary">Salary:</label>
        <input type="text" id="salary" name="salary" value="<?php echo esc_attr($salary); ?>" />
    </p>
    <?php
}

// Save Meta Box Data
function save_job_meta($post_id) {
    if (array_key_exists('company_name', $_POST)) {
        update_post_meta($post_id, 'company_name', sanitize_text_field($_POST['company_name']));
    }
    if (array_key_exists('location', $_POST)) {
        update_post_meta($post_id, 'location', sanitize_text_field($_POST['location']));
    }
    if (array_key_exists('salary', $_POST)) {
        update_post_meta($post_id, 'salary', sanitize_text_field($_POST['salary']));
    }
}
add_action('save_post', 'save_job_meta');

// Shortcode to Display Jobs
function job_listings_shortcode() {
    $query = new WP_Query(array('post_type' => 'job', 'posts_per_page' => -1));
    $output = '<ul>';
    while ($query->have_posts()) {
        $query->the_post();
        $output .= '<li><strong>' . get_the_title() . '</strong> - ' . get_post_meta(get_the_ID(), 'company_name', true) . ' (' . get_post_meta(get_the_ID(), 'location', true) . ') - Salary: ' . get_post_meta(get_the_ID(), 'salary', true) . '</li>';
    }
    wp_reset_postdata();
    $output .= '</ul>';
    return $output;
}
add_shortcode('job_listings', 'job_listings_shortcode');

// Admin Settings Page
function job_settings_menu() {
    add_options_page('Job Settings', 'Job Settings', 'manage_options', 'job-settings', 'job_settings_page');
}
add_action('admin_menu', 'job_settings_menu');

function job_settings_page() {
    ?>
    <div class="wrap">
        <h1>Job Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('job-settings-group');
            do_settings_sections('job-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function job_register_settings() {
    register_setting('job-settings-group', 'default_salary');
    add_settings_section('job_main_section', 'Main Settings', null, 'job-settings');
    add_settings_field('default_salary', 'Default Salary', 'default_salary_callback', 'job-settings', 'job_main_section');
}
add_action('admin_init', 'job_register_settings');

function default_salary_callback() {
    $default_salary = get_option('default_salary', '50000');
    echo '<input type="text" name="default_salary" value="' . esc_attr($default_salary) . '" />';
}