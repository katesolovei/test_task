$(function() {

//Живой поиск
    $('#search').bind("change keyup input click", function () {
        if (this.value.length >= 2) {
            $.ajax({
                type: 'post',
                url: "index.php", //Путь к обработчику
                dаta: {
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
                    alert( data['id']);
                    window.location = 'index.php?id='+data['id']+'firstName'+data['firstName'];
                    //$(".search_result").html(data).fadeIn(); //Выводим полученые данные в списке
                }
            })
        }
    })

    $("#search").hover(function () {
        $("#search").blur(); //Убираем фокус с input
    })
})
// //При выборе результата поиска, прячем список и заносим выбранный результат в input
//     $(".search_result").on("click", "li", function(){
//         s_user = $(this).text();
//         //$(".who").val(s_user).attr('disabled', 'disabled'); //деактивируем input, если нужно
//         $(".search_result").fadeOut();
//     })
// })