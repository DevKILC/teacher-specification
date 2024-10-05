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
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-custom-popup' // Add custom class to popup
                }
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
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-custom-popup' // Add custom class to popup
                }
            });
        }
    }

});

// Add custom CSS for z-index
const style = document.createElement('style');
style.innerHTML = `
    .swal-custom-popup {
        z-index: 9999 !important; /* Set z-index to ensure it's on top */
    }
`;
document.head.appendChild(style);
