
const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
  
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");

});

function switchMode(mode) {
  let url = new URL(window.location.href);
  url.searchParams.set("mode", mode);
  window.location.href = url.toString();
}

document.addEventListener("DOMContentLoaded", function() {
  let urlParams = new URLSearchParams(window.location.search);
  if(urlParams.get("mode") === "signup") {
      document.querySelector(".container").classList.add("sign-up-mode");
  } else {
    document.querySelector(".container").classList.remove("sign-up-mode");
  }

  });