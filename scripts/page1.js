function redirectToLogin() {
    window.location.href = 'login.html';

   }
   function continueWithoutLogin() {
    window.location.href = 'index2.html';
   }
   function continueWithLogin() {
    window.location.href = 'login.html';
   }



    const getStartedBtn = document.getElementById('getStartedBtn');
    const popupModal = document.getElementById('popupModal');
    const closePopupBtn = document.getElementById('closePopupBtn');
    const continueWithLoginBtn = document.getElementById('continueWithLoginBtn');
    const continueWithoutLoginBtn = document.getElementById('continueWithoutLoginBtn');

    // Event listener for the "Get Started" button
    getStartedBtn.addEventListener('click', () => {
      popupModal.style.display = 'flex'; // Show the popup modal
    });

    // Event listener to close the popup when the "Close" button is clicked
    closePopupBtn.addEventListener('click', () => {
      popupModal.style.display = 'none'; // Hide the popup modal
    });

    // Event listeners for the buttons inside the popup
    continueWithLoginBtn.addEventListener('click', () => {
      alert('Continuing with Login...');
      popupModal.style.display = 'none'; // Hide the popup after selecting an option
    });

    continueWithoutLoginBtn.addEventListener('click', () => {
      alert('Continuing without Login...');
      popupModal.style.display = 'none'; // Hide the popup after selecting an option
    });


function hideSidebar(){
    const navham = document.querySelector('.navham')
    navham.style.display = 'none'
}
  function showSidebar(){
    const navham = document.querySelector('.navham')
    navham.style.display = 'flex'
}
