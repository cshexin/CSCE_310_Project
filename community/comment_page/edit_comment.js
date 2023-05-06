// Description: This .js file is used for hiding the form of editing.
// Author: Tian Wu 


function toggleEditForm(commentId) {
  var editForm = document.getElementById('edit-form-' + commentId);
  if (editForm.style.display === 'none') {
    editForm.style.display = 'block';
  } else {
    editForm.style.display = 'none';
  }
}

