$(document).ready(function() {
    $("div[id^='oef']").hide();
    $("#oefs").change(function() {
        $("div[id^='oef']").hide();
        var selectedValue = $(this).val();
        $("#" + selectedValue).show();
    });
});
