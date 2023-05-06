// Description: File to make the edit-btn functional in post page
// Author: Hexin Hu

function showEditForm(postId) {
  var postCard = document.querySelector('#post-' + postId);
  var title = postCard.querySelector('.card-content h3').textContent;
  var content = postCard.querySelector('.card-content p').textContent;
  var editForm = document.querySelector('#edit-post-' + postId);
  var postForm = postCard.querySelector('.card-content');

  editForm.querySelector('#edit-title').value = title.trim();
  editForm.querySelector('#edit-content').value = content.trim();

  postForm.style.display = 'none';
  editForm.style.display = 'block';
}
