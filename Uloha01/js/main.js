
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
    }
}

$('#uploadButton').click(function () {
    $("input[type='file']").trigger('click');
});

$("input[type='file']").change(function () {
    $('#fileName').val(this.value.replace(/C:\\fakepath\\/i, ''));
});

