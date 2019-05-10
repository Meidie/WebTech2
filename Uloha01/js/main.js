
function change(id) {

    if(id === 'add'){

        $("#addForm").show();
        $("#showForm").hide();
        $("#table").empty();
        $("#pdfLink").hide();

    }else if(id === 'show'){

        $("#addForm").hide();
        $("#showForm").show();
        $("#table").empty();
        $("#success").hide();
        $("#createFailed").hide();
        $("#noSubmitData").hide();
        $("#wrongFile").hide();
        $("#wrongSize").hide();
        $("#connectionFailed").hide();
        $("#wrongSeparator").hide();
        $("#unableToOpen").hide();
        $("#pdfLink").hide();
    }
}

$('#submitDelete').click(function () {
    $("#pdfLink").hide();
});

$('#uploadButton').click(function () {
    $("input[type='file']").trigger('click');
});

$("input[type='file']").change(function () {
    $('#fileName').val(this.value.replace(/C:\\fakepath\\/i, ''));
});

