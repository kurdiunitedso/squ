<script>
    const baseUrl = "{{ asset('') }}";
    var currentLocale = "{{ lang() }}";
</script>
@include('metronic.CustomJS.FlatpickrManager')
{{-- @include('metronic.CustomJS.ModalRendererJS') --}}
@include('metronic.CustomJS.select2JS')
@include('metronic.CustomJS.applyValidationRules')
@include('metronic.CustomJS.BaseFormHandlerJS')
@include('metronic.CustomJS.handleAjaxErrors')
@include('metronic.CustomJS.initializeFlatpickrJS')
<script>
    // Function to determine text color based on background color
    function getContrastYIQ(hexcolor) {
        if (!hexcolor) return 'black'; // Default to black if no color is provided
        hexcolor = hexcolor.replace("#", "");
        if (hexcolor.length !== 6) return 'black'; // Default to black if invalid hex
        var r = parseInt(hexcolor.substr(0, 2), 16);
        var g = parseInt(hexcolor.substr(2, 2), 16);
        var b = parseInt(hexcolor.substr(4, 2), 16);
        var yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
        return (yiq >= 128) ? 'black' : 'white';
    }

    function hexToRgb(hex) {
        // Remove # if present
        hex = hex.replace('#', '');

        // Parse the hex values
        const r = parseInt(hex.substring(0, 2), 16);
        const g = parseInt(hex.substring(2, 4), 16);
        const b = parseInt(hex.substring(4, 6), 16);

        return {
            r,
            g,
            b
        };
    }
</script>
