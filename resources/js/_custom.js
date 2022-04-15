// add row
$("#addRow").click(function () {
    var html = " ";
    html += '<div class="atribut d-flex justify-content-between">';
    html += '<div class="form-group pr-3">';
    html += "<label>Название</label>";
    html +=
        '<input type="text" name="key[]"  class="form-control m-input mr-" autocomplete="off">';
    html += "</div>";
    html += '<div class="form-group">';
    html += "<label>Значение</label>";
    html += '<div class="d-flex justify-content-between">';
    html +=
        '<input type="text" name="value[]" class="form-control m-input" autocomplete="off">';
    html += '<a href="#" class="removeRow">';
    html += '<i class="trash far fa-trash-alt p-2"></i>';
    html += "</a>";
    html += "</div>";
    html += "</div>";
    html += "</div>";

    $("#newRow").append(html);
});

// remove row
$(document).on("click", ".removeRow", function () {
    $(this).parent().parent().parent().remove();
});

$(document).ready(function () {
    $("#add_btn").on("click", function () {
        $(".add_prod").addClass("show");
        $('#add_btn').hide();
        $(".add_prod input").val("");
        $(".removeRow").trigger("click");
    });
    $("#close").on("click", function () {
        $(".add_prod").removeClass("show");
        $('#add_btn').show();
        $(".add_prod input").val("");
        $(".removeRow").trigger("click");
    });
    $("#add").on("click", function () {
        $(".add_prod input").val("");
        $(".removeRow").trigger("click");
    });
});
