// sidebar
$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $(this).toggleClass('active');
    });
});

// recent transaction table
$(document).ready(function () {
    $('#dtBasicExample').DataTable({
        "ordering": true,
        "order": [[1, 'desc']]
    });
    $('.dataTables_length').addClass('bs-select');
});

// credit transaction table
$(document).ready(function () {
    $('#dtBasicExample1').DataTable();
    $('.dataTables_length').addClass('bs-select');
});


$(document).ready(function () {


    var readURL = function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $(".file-upload").on('change', function () {
        readURL(this);
    });
});