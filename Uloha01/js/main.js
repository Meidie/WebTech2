
function change(id) {
    console.log(id);

    if(id === 'add'){

        $("#addForm").show();
        $("#showForm").hide();
        $("#table").empty();
        $("#alert").show();

    }else if(id === 'show'){

        $("#addForm").hide();
        $("#showForm").show();
        $("#table").empty();
        $("#alert").hide();
        $("#success").hide();
        $("#createFailed").hide();
        $("#noSubmitData").hide();
        $("#wrongFile").hide();
        $("#wrongSize").hide();
        $("#connectionFailed").hide();
        $("#wrongSeparator").hide();
        $("#unableToOpen").hide();
    }
}

$('#uploadButton').click(function () {
    $("input[type='file']").trigger('click');
});

$("input[type='file']").change(function () {
    $('#fileName').val(this.value.replace(/C:\\fakepath\\/i, ''));
});

