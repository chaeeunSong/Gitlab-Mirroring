function wtbfe_selectTab(evt, tabID) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="wtbfe-tabcontent" and hide them
  tabcontent = document.getElementsByClassName("wtbfe-tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="wtbfe-tabbtn" and remove the class "active"
  tablinks = document.getElementsByClassName("wtbfe-tabbtn");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the link that opened the tab
  document.getElementById(tabID).style.display = "block";
  evt.currentTarget.className += " active";
}