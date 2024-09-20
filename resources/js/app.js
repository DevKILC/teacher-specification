document.addEventListener('DOMContentLoaded', function() {

    // Handle Flash Messages
    if (window.flashMessage) {
        if (window.flashMessage.success) {
            Swal.fire({
                icon: 'success',
                text: window.flashMessage.success,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
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
                timer: 5000,
                timerProgressBar: true
            });
        }
    }

  
});
