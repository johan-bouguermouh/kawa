/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
    console.log('in open')
    // document.getElementById("mySidenav").style.width = "450px";
    document.getElementById("mySidenav").style.transform = "translateX(0px)";
    document.getElementById("main").style.marginLeft = "450px";
  }
  
  /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
  function closeNav() {
    // document.getElementById("mySidenav").style.width = "450px";
    document.getElementById("mySidenav").style.transform = "translateX(450px)";
    document.getElementById("main").style.marginLeft = "450px";
  }