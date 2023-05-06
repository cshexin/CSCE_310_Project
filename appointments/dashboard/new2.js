document.getElementById('editButton').onclick = function() {
    document.getElementById('pname').hidden = true;
    document.getElementById('showpatientlist').hidden = false;
    document.getElementById('meeting-time').removeAttribute('readonly');
};