jQuery(document).ready(function ($) {
    // Add new rule row
    $("#boonband-add-rule").on("click", function (e) {
        e.preventDefault();
        var newRow = $(".boonband-rule-row:last").clone();
        newRow.find("input[type=text]").attr("value", ""); // Clear the text input value
        newRow.find("select.boonband-condition").prop("selectedIndex", 0);
        newRow.find("select.boonband-condition-value").html(""); // Empty the condition value dropdown

        var newIndex = $(".boonband-rules-wrapper .boonband-rule-row").length;
        newRow.html(newRow.html().replace(/\[(\d+)\]/g, (match, capturedNumber) => {
            const newIndex = parseInt(capturedNumber, 10) + 1;
            return `[${newIndex}]`;
        }));

        $(".boonband-rules-wrapper").append(newRow);
    });


    // Delete rule row
    $(document).on('click', '.boonband-delete-rule', function (e) {
        e.preventDefault();
        $(this).closest('.boonband-rule-row').remove();
    });

    // Initialize jQuery UI sortable for reordering rule rows
    $('.boonband-rules-wrapper').sortable({
        handle: '.boonband-handle',
        placeholder: 'boonband-sortable-placeholder',
    });

    // Handle condition change
    $(document).on('change', '.boonband-condition', function () {
        var $conditionSelect = $(this);
        var condition = $conditionSelect.val();
        var $conditionValueSelect = $conditionSelect.siblings('.boonband-condition-value');

        $.ajax({
            url: ajaxurl,
            method: 'POST',
            dataType: 'html',
            data: {
                action: 'boonband_custom_body_classes_update_condition_value_options',
                condition: condition,
            },
            beforeSend: function () {
                $conditionValueSelect.prop('disabled', true);
            },
            success: function (response) {
                $conditionValueSelect.html(response).prop('disabled', false);
            },
            error: function () {
                $conditionValueSelect.prop('disabled', false);
            },
        });
    });
});
