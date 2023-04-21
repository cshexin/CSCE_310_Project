document.addEventListener('DOMContentLoaded', function() {
    let commentInput;
  
    const inputElement = document.getElementById('my-input');
    
    inputElement.addEventListener('keydown', function(event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        commentInput = inputElement.value;
        console.log('User input:', commentInput);
        inputElement.value = ''; // Clear the input field
      }
    });
  });