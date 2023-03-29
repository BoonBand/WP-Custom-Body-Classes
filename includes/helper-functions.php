<?php
function boonband_custom_body_classes_check_condition($rule) {
    $condition = $rule['condition'];
    $condition_value = $rule['condition_value'];

    switch ($condition) {
        case 'specific_page':
            return is_page($condition_value);
        case 'page_type':
            return call_user_func("is_{$condition_value}");
        case 'specific_post_type':
            return is_singular($condition_value);
        case 'specific_post':
            return is_single($condition_value);
        case 'service_pages':
            return boonband_custom_body_classes_is_service_page($condition_value);
        case 'user_logged_in':
            return is_user_logged_in() == ($condition_value === 'yes');
        default:
            // Custom condition handling
            return apply_filters('boonband_custom_body_classes_check_condition', false, $condition, $condition_value, $rule);
    }
}

function boonband_custom_body_classes_is_service_page($page_type) {
    switch ($page_type) {
        case '404':
            return is_404();
        case 'search':
            return is_search();
        case 'no_results':
            global $wp_query;
            return (is_search() || is_archive()) && $wp_query->post_count == 0;
        default:
            // Custom service page handling
            return apply_filters('boonband_custom_body_classes_is_service_page', false, $page_type);
    }
}

function boonband_custom_body_classes_get_condition_value_options($condition, $selected_value = null) {
    $options = '';

    switch ($condition) {
        case 'specific_page':
            $pages = get_pages();
            foreach ($pages as $page) {
                $selected = $selected_value == $page->ID ? 'selected' : '';
                $options .= sprintf('<option value="%s" %s>%s</option>', $page->ID, $selected, $page->post_title);
            }
            break;
        case 'page_type':
            $page_types = array('home', 'front_page', 'archive', 'single', 'page', 'category', 'tag', 'date', 'author');
            foreach ($page_types as $page_type) {
                $selected = $selected_value == $page_type ? 'selected' : '';
                $options .= sprintf('<option value="%s" %s>%s</option>', $page_type, $selected, ucfirst(str_replace('_', ' ', $page_type)));
            }
            break;
        case 'specific_post_type':
            $post_types = get_post_types(array('public' => true), 'objects');
            foreach ($post_types as $post_type) {
                $selected = $selected_value == $post_type->name ? 'selected' : '';
                $options .= sprintf('<option value="%s" %s>%s</option>', $post_type->name, $selected, $post_type->labels->name);
            }
            break;
        case 'specific_post':
            $posts = get_posts(array('posts_per_page' => -1));
            foreach ($posts as $post) {
                $selected = $selected_value == $post->ID ? 'selected' : '';
                $options .= sprintf('<option value="%s" %s>%s</option>', $post->ID, $selected, $post->post_title);
            }
            break;
        case 'service_pages':
            $service_pages = array('404', 'search', 'no_results');
            foreach ($service_pages as $service_page) {
                $selected = $selected_value == $service_page ? 'selected' : '';
                $options .= sprintf('<option value="%s" %s>%s</option>', $service_page, $selected, ucfirst(str_replace('_', ' ', $service_page)));
            }
            break;
        case 'user_logged_in':
            $user_logged_in_options = array('yes' => __('Yes', 'wp-custom-body-classes-by-boon-band'), 'no' => __('No', 'wp-custom-body-classes-by-boon-band'));
            foreach ($user_logged_in_options as $value => $label) {
                $selected = $selected_value == $value ? 'selected' : '';
                $options .= sprintf('<option value="%s" %s>%s</option>', $value, $selected, $label);
            }
            break;
        default:
            // Custom condition value handling
            $options = apply_filters('boonband_custom_body_classes_get_condition_value_options', $options, $condition, $selected_value);
    }

    return $options;
}
