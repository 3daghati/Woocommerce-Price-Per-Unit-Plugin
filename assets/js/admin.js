jQuery(document).ready(function($) {
    // Enhance select2 for unit measure field
    $(document).on('woocommerce-enhanced-select-init', function() {
        $('select.unit-measure-field').each(function() {
            $(this).select2({
                minimumResultsForSearch: 8,
                width: '100%'
            });
        });
    });

    // Custom validation for unit field
    $(document).on('click', '#publish', function(e) {
        let unitField = $('#_unit_measure');
        if (unitField.val() === '' && $('#product-type').val() === 'simple') {
            if (confirm(unit_price_display_admin.i18n.unit_warning)) {
                return true;
            }
            e.preventDefault();
            unitField.focus().css('border-color', '#dc3232');
            return false;
        }
        return true;
    });
});