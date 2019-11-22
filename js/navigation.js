const accountPanel = document.querySelector("#account-panel") || null;
const mainSection = document.querySelector("body > section") || null;
const navpanel = document.querySelector("#nav-panel") || null;
const asideNav = document.querySelector("#aside-nav") || null;

if(accountPanel)
accountPanel.addEventListener("click", () => {
  if (accountPanel.classList.contains("active")) {
    accountPanel.classList.remove("active");
  } else {
    accountPanel.classList.add("active");
  }
});

if(navpanel){
  navpanel.addEventListener("click", () => {
    asideNav.classList.add("visible");
  });
  document.addEventListener('touchstart', handleTouchStart, false);        
  document.addEventListener('touchmove', handleTouchMove, false);

  var xDown = null; 

  function getTouches(evt) {
    return evt.touches || evt.originalEvent.touches;
  }  

  function handleTouchStart(evt) {
      const firstTouch = getTouches(evt)[0];
      xDown = firstTouch.clientX < 50 ? firstTouch.clientX : null;
  };                                                

  function handleTouchMove(evt) {
      if (!xDown) {
          return;
      }
      var xUp = evt.touches[0].clientX;
      var xDiff = xDown - xUp;

      if ( xDiff < 0 ) {
        asideNav.classList.add("visible");
      }                       
      
      xDown = null;                                           
  };
}
  

if(mainSection)
mainSection.addEventListener("click", () => {
  accountPanel.classList.remove("active");
  asideNav.classList.remove("visible");
});