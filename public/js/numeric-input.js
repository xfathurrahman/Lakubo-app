$(document).ready(function () {
    const numericInputs = document.querySelectorAll('.numeric-input');
    numericInputs.forEach(function(input) {
        input.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
    });
})
