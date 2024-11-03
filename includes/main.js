// Function to open the add modal
// Function to open the add modal
function addModal() {
    const modal = document.getElementById('addModal');
    modal.classList.remove('hidden');

    // Reset form for adding
    const form = modal.querySelector('form');
    form.reset();

    // Add transition for opening
    setTimeout(() => {
        modal.querySelector('.modal-content').classList.add('scale-100', 'opacity-100');
    }, 50);
}

// Function to open the update modal
function openUpdateModal(recordId, name, password) {
    const modal = document.getElementById('updateModal');
    modal.classList.remove('hidden');

    // Populate the form fields
    document.getElementById('recordId').value = recordId;
    document.getElementById('updateUsername').value = name;
    document.getElementById('updatePassword').value = password;

    // Add transition for opening
    setTimeout(() => {
        modal.querySelector('.modal-content').classList.add('scale-100', 'opacity-100');
    }, 50);
}

// Function to close the modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.querySelector('.modal-content').classList.remove('scale-100', 'opacity-100');
    
    // Hide the modal after transition
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}


// Check Edit Buttons
// Function to check for success or alert messages in URL
function checkForRecordStatus() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const alert = urlParams.get('alert');

    if (success === 'RecordUpdated') {
        showAlert('success', 'Success', 'Record updated successfully!');
    }else if (success === 'RecordCreated') {
        showAlert('success', 'Success', 'Record Created successfully!');
    } else if (alert === 'RecordNotUpdated') {
        showAlert('error', 'Oops...', 'Failed to create record. Please try again.');
    } else if (alert === 'UserAlreadyExists') {
        showAlert('warning', 'Warning', 'User already exists. Please choose a different username.');
    }

    // Clear the alert/error parameters from the URL
    urlParams.delete('success'); // Added this line to clear success
    urlParams.delete('alert');   // Correctly delete the alert parameter
    const newUrl = window.location.pathname + '?' + urlParams.toString();
    
    // Update the URL without reloading the page
    window.history.replaceState(null, '', newUrl);
}

// Function to show alerts using SweetAlert
function showAlert(icon, title, text) {
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
        confirmButtonColor: '#3085d6'
    });
}


// Function to check for error in URL
function checkForErrorInURL() {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: decodeURIComponent(error),
            confirmButtonColor: '#d33'
        });

        urlParams.delete('error');
        const newUrl = window.location.pathname + '?' + urlParams.toString();
        window.history.replaceState(null, '', newUrl);
    }
}

// Function to check for deleted record message
function checkForDeletedRecord() {
    const urlParams = new URLSearchParams(window.location.search);
    const isDeleted = urlParams.get('deleted');

    // Handle the success case
    if (isDeleted === 'true') {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Record deleted successfully!',
            confirmButtonColor: '#3085d6'
        }).then(() => {
            cleanupUrl(urlParams);
        });
    }
    // Handle the failure case
    else if (isDeleted === 'false') {
        Swal.fire({
            icon: 'error',
            title: 'Record not Deleted',
            text: 'Failed to delete the record. It may not exist or belong to the user.',
            confirmButtonColor: '#d33'
        }).then(() => {
            cleanupUrl(urlParams);
        });
    }
}

// Function to clean up the URL
function cleanupUrl(urlParams) {
    urlParams.delete('deleted');
    const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
    window.history.replaceState(null, '', newUrl);
}

// Function to handle delete button confirmations
function setupDeleteButtons() {
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const form = this.closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
}

// Initialize functions on page load
document.addEventListener('DOMContentLoaded', function () {
    checkForRecordStatus();
    checkForErrorInURL();
    checkForDeletedRecord();
    setupDeleteButtons();
});


// Copy to Clipboard
function copyToClipboard(element) {
    // Get the text content of the clicked element
    const text = element.textContent;

    // Use the Clipboard API to copy the text to the clipboard
    navigator.clipboard.writeText(text)
        .then(() => {
            Swal.fire({
                title: 'Copied!',
                text: 'Copied to clipboard: ' + text,
                icon: 'success',
                showConfirmButton: false,
                timer: 1000 // Auto-hide after 2 seconds
            });
        })
        .catch(err => {
            console.error('Could not copy text: ', err);
        });
}
