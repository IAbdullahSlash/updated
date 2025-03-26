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
  window.location.href = "index2.html" 
}

function continueWithLogin() {
  window.location.href = "login.html" 
}
// Modal functionality
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('popupModal');
  const getStartedBtn = document.getElementById('getStartedBtn');
  const closeModal = document.querySelector('.close-modal');
  
  // Open modal when Get Started is clicked
  if (getStartedBtn) {
      getStartedBtn.addEventListener('click', function() {
          modal.style.display = 'flex';
          document.body.classList.add('modal-open');
          
          // Add animation class
          setTimeout(() => {
              document.querySelector('.popup-content').classList.add('show');
          }, 10);
      });
  }
  
  // Close modal when X is clicked
  if (closeModal) {
      closeModal.addEventListener('click', function() {
          document.querySelector('.popup-content').classList.remove('show');
          
          setTimeout(() => {
              modal.style.display = 'none';
              document.body.classList.remove('modal-open');
          }, 300);
      });
  }
  
  // Close modal when clicking outside
  window.addEventListener('click', function(event) {
      if (event.target === modal) {
          document.querySelector('.popup-content').classList.remove('show');
          
          setTimeout(() => {
              modal.style.display = 'none';
              document.body.classList.remove('modal-open');
          }, 300);
      }
  });
});




