var ready = true;

function checkAll(id, name) {
    $('input[name="' + name + '"]').attr('checked', $('#' + id).is(':checked'));
}

function confirmDeleteInvalid() {
    if (confirm("This will remove all invalid cards.")) {
        return true;
        //window.location = "http://Validshop.SU/mycards.php?del=invalid";
    }
    return false;
}

function checkCard(card_id) {
    if (ready) {
        $.ajax({
            type: "GET",
            url: './checker.php?card_id=' + card_id,
            beforeSend: function() {
                ready = false;
                $("#check_" + card_id).html("<img src=\"./images/loading.gif\" height=\"30px\" width=\"30px\" />");
            },
            success: function(msg) {
                ready = true;
                $("#check_" + card_id).html(msg).show("slow");
            },
            error: function(msg) {
                ready = true;
                $("#check_" + card_id).html("<span class=\"red\">Loading error.</span>");
            }
        });
    } else {
        alert('Please wait until current checking complete.');
    }
}

function change_city_select_mode(auto) {
    switch ($("[name='city_select_mode']").val()) {
        case '0':
            $("#card_city").removeClass('bold');
            $("#card_state").removeClass('bold');
            $("#card_zip").removeClass('bold');
            if (auto == true) {
                $("[name='card_city']").removeAttr("readonly");
                $("[name='card_state']").removeAttr("readonly");
                $("[name='card_zip']").removeAttr("readonly");
            } else {
                $("[name='card_city']").val('').removeAttr("readonly");
                $("[name='card_state']").val('').removeAttr("readonly");
                $("[name='card_zip']").val('').removeAttr("readonly");
            }
            break;
        case '1':
            $("#card_city").removeClass('bold');
            $("#card_state").removeClass('bold');
            $("#card_zip").addClass('bold');
            $("[name='card_city']").val('AUTO BY ZIP').attr("readonly", true);
            $("[name='card_state']").val('AUTO BY ZIP').attr("readonly", true);
            if (auto == true) {
                $("[name='card_zip']").removeAttr("readonly");
            } else {
                $("[name='card_zip']").val('').removeAttr("readonly");
            }
            break;
        case '2':
            $("#card_city").addClass('bold');
            $("#card_state").addClass('bold');
            $("#card_zip").removeClass('bold');
            if (auto == true) {
                $("[name='card_city']").removeAttr("readonly");
                $("[name='card_state']").removeAttr("readonly");
            } else {
                $("[name='card_city']").val('').removeAttr("readonly");
                $("[name='card_state']").val('').removeAttr("readonly");
            }
            $("[name='card_zip']").val('AUTO BY CITY').attr("readonly", true);
            break;
    }
    return false;
}

function change_country_select_mode(auto) {
    switch ($("[name='country_select_mode']").val()) {
        case '0':
            $("[name='card_country']").val('AUTO BY BIN').attr("readonly", true);
            break;
        case '1':
            if (auto == true) {
                $("[name='card_country']").removeAttr("readonly");
            } else {
                $("[name='card_country']").val('').removeAttr("readonly");
            }
            break;
    }
    return false;
}
$(document).ready(function() {
    change_city_select_mode(true);
    change_country_select_mode(true);
    $('.viewcard').popupWindow({
        height: 300,
        width: 900,
    });
});
$(document).ready(function() {
    $('.select-with-search').select2();
    $('#db').select2();
});
