function redirectToLogin() {
    window.location.href = 'login.html';
}
function hideSidebar(){
    const navham = document.querySelector('.navham')
    navham.style.display = 'none'
}
  function showSidebar(){
    const navham = document.querySelector('.navham')
    navham.style.display = 'flex'
}
