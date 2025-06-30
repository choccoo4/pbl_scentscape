// --- Profile Picture Preview ---
const profileInput = document.getElementById('profilePicInput');
const profilePreview = document.getElementById('profilePicPreview');
if (profileInput && profilePreview) {
    profileInput.addEventListener('change', function (event) {
        const [file] = event.target.files;
        if (file) {
            profilePreview.src = URL.createObjectURL(file);
        }
    });
}

// --- SweetAlert Session Notifications ---
const successMsg = document.body.dataset.success;
const errorMsg = document.body.dataset.error;
const errorList = document.body.dataset.errors;

if (successMsg) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: successMsg,
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false
    });
}

if (errorMsg) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: errorMsg,
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false
    });
}

if (errorList) {
    Swal.fire({
        icon: 'error',
        title: 'Something went wrong',
        html: errorList,
    });
}
