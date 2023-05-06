document.getElementById('editButton').onclick = function() {
    document.getElementById('dname').hidden = true;
    document.getElementById('showdoctorlist').hidden = false;
    document.getElementById('meeting-time').removeAttribute('readonly');
};