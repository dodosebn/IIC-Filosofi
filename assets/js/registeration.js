document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('enrollment-form');

  
  


  function validateStep() {
    let isValid = true;
    // const currentStepElement = steps[step];
    const inputs = currentStepElement.querySelectorAll('input, select');
    
    inputs.forEach(input => {
      if (!input.value.trim()) {
        input.closest('.input-field').classList.add('error');
        isValid = false;
      } else {
        input.closest('.input-field').classList.remove('error');
      }
    });
    
    return isValid;
  }
});

 

