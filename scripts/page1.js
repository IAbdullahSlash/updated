  // Navigation functions
  function redirectToLogin() {
    window.location.href = 'login.php';
  }


  function continueWithoutLogin() {
    document.querySelector('.popup-content').classList.remove('show');
    setTimeout(() => {
      document.getElementById('popupModal').style.display = 'none';
      document.body.classList.remove('modal-open');
    }, 300);
    window.location.href = 'home_page.php';
  }

  function continueWithLogin() {
    document.querySelector('.popup-content').classList.remove('show');
    setTimeout(() => {
      document.getElementById('popupModal').style.display = 'none';
      document.body.classList.remove('modal-open');
    }, 300);
    window.location.href = 'login.php';
  }

  // Sidebar functions
  function hideSidebar() {
    const navham = document.querySelector('.navham');
    navham.style.display = 'none';
  }

  function showSidebar() {
    const navham = document.querySelector('.navham');
    navham.style.display = 'flex';
  }

  // Scroll animation function
  function reveal() {
    var reveals = document.querySelectorAll('.reveal');

    for (var i = 0; i < reveals.length; i++) {
      var windowheight = window.innerHeight;
      var revealtop = reveals[i].getBoundingClientRect().top;
      var revealpoint = 150;

      if (revealtop < windowheight - revealpoint) {
        reveals[i].classList.add('active');
      } else {
        reveals[i].classList.remove('active');
      }
    }
  }

  // Initialize all event listeners when DOM is loaded
  document.addEventListener('DOMContentLoaded', function() {
    // Modal elements
    const modal = document.getElementById('popupModal');
    const getStartedBtn = document.getElementById('getStartedBtn');
    const closeModal = document.querySelector('.close-modal');
    
    // FAQ elements
    const faqItems = document.querySelectorAll('.faq-item');
    
    // Get Started button click event
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
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape' && modal.style.display === 'flex') {
        document.querySelector('.popup-content').classList.remove('show');
        
        setTimeout(() => {
          modal.style.display = 'none';
          document.body.classList.remove('modal-open');
        }, 300);
      }
    });
    
    // FAQ toggle functionality
    faqItems.forEach(item => {
      const toggle = item.querySelector('.faq-toggle');
      const answer = item.querySelector('.faq-answer');
      
      toggle.addEventListener('click', () => {
        const isActive = item.classList.contains('active');
        
        // Close all FAQ items
        faqItems.forEach(faqItem => {
          faqItem.classList.remove('active');
          faqItem.querySelector('.faq-answer').style.maxHeight = null;
        });
        
        // If the clicked item wasn't active, open it
        if (!isActive) {
          item.classList.add('active');
          answer.style.maxHeight = answer.scrollHeight + 'px';
        }
      });
    });
    
    // Navbar scrolling effect
    window.addEventListener('scroll', function() {
      var navbar = document.querySelector('.navbar');  
      var heroSection = document.querySelector('.hero'); 
      
      if (window.scrollY > heroSection.offsetTop) {
        navbar.classList.add('transparent');  
      } else {
        navbar.classList.remove('transparent'); 
      }
    });
    
    // Initialize scroll reveal effect
    window.addEventListener('scroll', reveal);
    // Call once on load to reveal elements that are already in view
    reveal();
  });