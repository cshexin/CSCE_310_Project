// Description: hides the previous patient name and provides a list of patients to choose and maked creating meeting editable
// Author: Valerie Villafana
document.getElementById('editButton').onclick = function() {
    document.getElementById('pname').hidden = true;
    document.getElementById('showpatientlist').hidden = false;
    document.getElementById('meeting-time').removeAttribute('readonly');
};