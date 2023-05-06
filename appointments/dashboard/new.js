// Description: hides the previous doctor name and provides a list of doctors to choose and maked creating meeting editable
// Author: Valerie Villafana
document.getElementById('editButton').onclick = function() {
    document.getElementById('dname').hidden = true;
    document.getElementById('showdoctorlist').hidden = false;
    document.getElementById('meeting-time').removeAttribute('readonly');
};