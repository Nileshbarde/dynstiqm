$(document).ready(function() {
    $('#changePasswordForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '../controller/change_password.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response);
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });

    $('#changeWithdrawPasswordForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '../controller/change_withdraw_password.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response);
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });
});
