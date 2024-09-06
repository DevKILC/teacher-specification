import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    // select2select
    $('#select-teacher').select2({
        allowClear: true
    });

});
document.addEventListener("DOMContentLoaded", function() {
    // Check if the window.flashMessage object exists
    if (window.flashMessage) {
        // Handle success message
        if (window.flashMessage.success) {
            Swal.fire({
                icon: 'success',
                text: window.flashMessage.success,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        }
        
        // Handle error message
        if (window.flashMessage.error) {
            Swal.fire({
                icon: 'error',
                text: window.flashMessage.error,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        }
    }
});
