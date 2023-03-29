<div class="boonband-rule-row <?php echo isset($index) ? '' : 'boonband-rule-row-template'; ?>">
    <span class="dashicons dashicons-menu boonband-handle"></span>
    <input type="text" name="boonband_custom_body_classes_rules[<?php echo isset($index) ? $index : '{index}'; ?>][class_name]" value="<?php echo isset($rule['class_name']) ? esc_attr($rule['class_name']) : ''; ?>" placeholder="<?php _e('Class Name', 'wp-custom-body-classes-by-boon-band'); ?>">
    <select name="boonband_custom_body_classes_rules[<?php echo isset($index) ? $index : '{index}'; ?>][condition]" class="boonband-condition">
        <?php // List of available conditions ?>
        <option value="specific_page" <?php echo isset($rule['condition']) && $rule['condition'] == 'specific_page' ? 'selected' : ''; ?>><?php _e('Specific Page', 'wp-custom-body-classes-by-boon-band'); ?></option>
        <option value="page_type" <?php echo isset($rule['condition']) && $rule['condition'] == 'page_type' ? 'selected' : ''; ?>><?php _e('Page Type', 'wp-custom-body-classes-by-boon-band'); ?></option>
        <option value="specific_post_type" <?php echo isset($rule['condition']) && $rule['condition'] == 'specific_post_type' ? 'selected' : ''; ?>><?php _e('Specific Post Type', 'wp-custom-body-classes-by-boon-band'); ?></option>
        <option value="specific_post" <?php echo isset($rule['condition']) && $rule['condition'] == 'specific_post' ? 'selected' : ''; ?>><?php _e('Specific Post', 'wp-custom-body-classes-by-boon-band'); ?></option>
        <option value="service_pages" <?php echo isset($rule['condition']) && $rule['condition'] == 'service_pages' ? 'selected' : ''; ?>><?php _e('Service Pages', 'wp-custom-body-classes-by-boon-band'); ?></option>
        <option value="user_logged_in" <?php echo isset($rule['condition']) && $rule['condition'] == 'user_logged_in' ? 'selected' : ''; ?>><?php _e('User Logged In', 'wp-custom-body-classes-by-boon-band'); ?></option>
    </select>
    <select name="boonband_custom_body_classes_rules[<?php echo isset($index) ? $index : '{index}'; ?>][condition_value]" class="boonband-condition-value">
        <?php // List of available condition values based on the selected condition ?>
        <?php if (isset($rule['condition'])) : ?>
            <?php echo boonband_custom_body_classes_get_condition_value_options($rule['condition'], isset($rule['condition_value']) ? $rule['condition_value'] : null); ?>
        <?php endif; ?>
    </select>
    <button class="boonband-delete-rule"><?php _e('Delete', 'wp-custom-body-classes-by-boon-band'); ?></button>
</div>
