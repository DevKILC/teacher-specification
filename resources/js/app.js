document.addEventListener('DOMContentLoaded', function() {
    // Setup Select2
    $('#select-teacher').select2({
        allowClear: true
    });

    // Handle Flash Messages
    if (window.flashMessage) {
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
