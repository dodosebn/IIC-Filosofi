document.addEventListener('DOMContentLoaded', function() {
  // Form elements
  const form = document.getElementById('enrollment-form');
  const steps = document.querySelectorAll('.form-step');
  const nextBtns = document.querySelectorAll('.next-btn');
  const prevBtns = document.querySelectorAll('.prev-btn');
  const progressBar = document.querySelector('.progress-bar');
  const loader = document.querySelector('.form-loader');
  const successMsg = document.querySelector('.form-success');
  
  // Initialize Choices.js for custom select elements
  
  let currentStep = 0;
  showStep(currentStep);

  nextBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      if (validateStep(currentStep)) {
        currentStep++;
        showStep(currentStep);
        updateProgressBar();
      }
    });
  });

  prevBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      currentStep--;
      showStep(currentStep);
      updateProgressBar();
    });
  });

  

  // Helper functions
  function showStep(step) {
    steps.forEach((stepElement, index) => {
      stepElement.classList.toggle('active', index === step);
    });
  }

  function updateProgressBar() {
    const progress = ((currentStep + 1) / steps.length) * 100;
    progressBar.style.setProperty('--progress', `${progress}%`);
  }

  function validateStep(step) {
    let isValid = true;
    const currentStepElement = steps[step];
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

  function showLoader() {
    loader.style.display = 'flex';
    document.querySelectorAll('button').forEach(btn => {
      btn.disabled = true;
    });
  }

  function hideLoader() {
    loader.style.display = 'none';
    document.querySelectorAll('button').forEach(btn => {
      btn.disabled = false;
    });
  }

  function showSuccess() {
    successMsg.style.display = 'flex';
    
    // Close success message
    document.querySelector('.success-btn').addEventListener('click', function() {
      successMsg.style.display = 'none';
    });
  }

  function showError(message) {
    const errorElement = document.createElement('div');
    errorElement.className = 'form-error';
    errorElement.innerHTML = `<p style="color: red; text-align: center; margin-top: 1rem;">${message}</p>`;
    
    // Remove existing error if any
    const existingError = document.querySelector('.form-error');
    if (existingError) {
      existingError.remove();
    }
    
    form.appendChild(errorElement);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
      errorElement.remove();
    }, 5000);
  }
});