$.onreadystatechange = function() {

    $('#search').click(function () {
        if (this.value.length >= 2) {
            $.ajax({
                type: 'post',
                url: "index.php",
                dаta: {
                    search_submit:true,
                    id: $('#sId').val(),
                    firstName: $('#sFirstName').val(),
                    lastName: $('#sLastName').val(),
                    email: $('#email').val(),
                    createdFrom: $('#createdFrom').val(),
                    createdTo: $('#createdTo').val(),
                    modifiedFrom: $('#modifiedFrom').val(),
                    modifiedTo: $('#modifiedTo').val()
                },
                response: 'text',
                success: function (data) {
                    $("#search").html(data);
                }
            })
        }
    });

    $("#search").hover(function () {
        $("#search").blur();
    })
}