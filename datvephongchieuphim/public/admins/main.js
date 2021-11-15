//Action delete
$(function () {
    $(document).on('click', '.action_delete', actionDelete)

})

function actionDelete(event) {
    event.preventDefault();
    let urlRequest = $(this).data('url');
    let that = $(this);

    Swal.fire({
        title: 'Bạn có chắc không?',
        text: "Bạn sẽ không thể hoàn nguyên điều này!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Có, xóa nó!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: urlRequest,
                success: function (data) {
                    if (data.code == 200) {
                        that.parent().parent().remove();
                        console.log('oke');
                    }
                },
                error: function () {

                }
            });
            //Swal.fire(
            // 'Deleted!',
            //   'Your file has been deleted.',
            //  'success'
            // )
        }
    })
}

//Search
$(document).ready(function () {
    $('#myInput').on('keyup', function (event) {
        event.preventDefault();
        /* Act on the event */
        var tukhoa = $(this).val().toLowerCase();
        $('#myTable tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(tukhoa) > -1);
        });

    });
});

//Phone number format
$(".phone_number").text(function(i, text) {
    text = text.replace(/(\d{3})(\d{3})(\d{4})/, "$1.$2.$3");
    return text;
});
