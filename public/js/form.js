document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.input').forEach(input => {
    const label = input.nextElementSibling;

    function activate() {
      label.classList.add('active');
      input.classList.add('active');
    }
    function deactivate() {
      if (!input.value) {
        label.classList.remove('active');
        input.classList.remove('active');
      }
    }

    // On page load, check if input has value (for autofill)
    if (input.value) activate();

    input.addEventListener('focus', activate);
    input.addEventListener('blur', deactivate);
    input.addEventListener('input', () => {
      if (input.value) {
        activate();
      } else {
        deactivate();
      }
    });
  });
});