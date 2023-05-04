var date = new Date();
var year = date.getFullYear();
var month = date.getMonth() + 1;
var day = date.getDate();
if(month < 10) {
    month = month.toString();
    month = "0" + month;
}
if(day < 10) {
    day = day.toString();
    day = "0" + day;
}
var currentDay = year + '-' + month + '-' + day + 'T00:00';
document.getElementById('meeting-time').setAttribute('min', currentDay);