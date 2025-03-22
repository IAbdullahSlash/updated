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

// Get the modal element
const modal = document.getElementById("popupModal")

// Add event listener to close modal when clicking outside
window.addEventListener("click", (event) => {
  if (event.target === modal) {
    modal.style.display = "none"
  }
})

// Make sure the existing code for opening the modal remains:
document.getElementById("getStartedBtn").addEventListener("click", () => {
  modal.style.display = "block"
})

// Keep any existing functions for the continue buttons
function continueWithoutLogin() {
  window.location.href = "without-login.html" // or whatever the destination is
}

function continueWithLogin() {
  window.location.href = "login.html" // or whatever the destination is
}


