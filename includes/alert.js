document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const success = urlParams.get('success');
    
    // Handle error messages
    if (error) {
        let title = 'Oops...';
        let icon = 'error';
        let message = '';

        switch (error) {
            case 'InputAllFields':
                message = 'Please fill out all required fields.';
                break;
            case 'UsernameNotValid':
                message = 'Username must be at least 3 characters and include 1 number!';
                break;
            case 'InvalidEmail':
                message = 'Please enter a valid email address.';
                break;
            case 'EmailAlreadyRegistered':
                message = 'This email is already registered.';
                break;
            case 'InvalidPassword':
                message = 'Password must be at least 6 characters and include 1 number.';
                break;
            case "PasswordDoesn'tMatch":
                message = 'Passwords do not match.';
                break;
            case 'Faileduploadimage':
                message = 'Failed to upload the image. Please try again.';
                break;
            case 'UnsupportedFileFormat':
                message = 'Unsupported file format. Only JPG and JPEG are allowed.';
                break;
            case 'IncorrectPass':
                message = 'The password you entered is incorrect.';
                break;
            case 'InvalidUserPass':
                message = 'Invalid username or password. Please try again.';
                break;
            default:
                message = 'An unexpected error occurred.';
                break;
        }

        // Show alert
        Swal.fire({
            icon: icon,
            title: title,
            text: message,
            confirmButtonColor: '#d33'
        }).then(() => {
            // Clear error from URL
            urlParams.delete('error');
            const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
            window.history.replaceState(null, '', newUrl);
        });
    }

    // Handle success messages
    if (success) {
        let message = '';

        switch (success) {
            case 'AccountCreated':
                message = 'Account created successfully!';
                break;
            default:
                message = 'Operation completed successfully.';
                break;
        }

        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
            confirmButtonColor: '#3085d6'
        }).then(() => {
            // Clear success from URL
            urlParams.delete('success');
            const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
            window.history.replaceState(null, '', newUrl);
        });
    }
});
