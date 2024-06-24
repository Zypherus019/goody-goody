//table functions for suppliers
$(document).ready(function() {
    function fetchData() {
        $.ajax({
            url: 'fetch_supp.php',
            type: 'GET',
            success: function(data) {
                $('#dataTable tbody').html(data);
            }
        });
    }

    fetchData();
    $('#insertForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: 'insert_supp.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                fetchData();
                alert(response);
                $('#insertForm')[0].reset();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    $(document).on('click', '.transferBtn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'transfer_supp.php',
            type: 'POST',
            data: {id: id},
            success: function(response) {
                fetchData();
                alert(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});


$(document).ready(function() {
    function fetchData() {
        $.ajax({
            url: 'block_list.php',
            type: 'GET',
            success: function(data) {
                $('#dataTable2 tbody').html(data);
            }
        });
    }

    $(document).on('click', '.backBtn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'return_supp.php',
            type: 'POST',
            data: {id: id},
            success: function(response) {
                fetchData();
                alert(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});




$(document).ready(function() {
    $('#addBtn').click(function() {
        $('#addModal').css('display', 'block');
    });

    $('.close').click(function() {
        $('#addModal').css('display', 'none');
    });
    $(window).click(function(event) {
        if (event.target == $('#addModal')[0]) {
            $('#addModal').css('display', 'none');
        }
    });
});

