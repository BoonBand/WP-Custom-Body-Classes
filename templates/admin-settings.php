<div class="wrap">
    <h1><a href="https://github.com/BoonBand/WP-Custom-Body-Classes" target="_blank">WP Custom Body Classes</a> by Boon.Band</h1>
    <p>Use this plugin to easily add custom CSS classes to the &lt;body&gt; tag of your WordPress site. Follow the steps below to create rules for adding classes:</p>
    <ol>
        <li>Enter the class name(s) in the "Class Name" field. Separate multiple class names with a space.</li>
        <li>Select a condition from the dropdown list. This determines when the class will be added to the &lt;body&gt; tag.</li>
        <li>Select a value for the chosen condition from the next dropdown list.</li>
        <li>Click "Add Rule" to create more rules, if necessary.</li>
        <li>Click "Save Changes" to apply your custom classes.</li>
    </ol>

    <form method="post" action="options.php">
        <?php settings_fields('boonband_custom_body_classes_settings_group'); ?>
        <?php do_settings_sections('boonband_custom_body_classes_settings_group'); ?>
        <?php $rules = get_option('boonband_custom_body_classes_rules'); ?>
        <div class="boonband-rules-wrapper">
            <?php if (!empty($rules)) : ?>
                <?php foreach ($rules as $index => $rule) {
                    ob_start();
                    include plugin_dir_path(__FILE__) . 'partials/rule-row.php';
                    $rule_row = ob_get_clean();
                    echo str_replace('{index}', $index, $rule_row);
                } ?>
            <?php endif; ?>
        </div>
        <button id="boonband-add-rule" class="button button-primary"><?php _e('Add Rule', 'wp-custom-body-classes-by-boon-band'); ?></button>
        <?php submit_button(); ?>
    </form>
    <strong>Designed with <img draggable="false" role="img" class="emoji" alt="💕" src="https://s.w.org/images/core/emoji/14.0.0/svg/1f495.svg"> by  <a href="https://boon.band/" target="_blank" title="Boon.Band">Boon.Band</a></strong>
</div>
