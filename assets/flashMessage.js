document.addEventListener("DOMContentLoaded", function () {
  setTimeout(function () {
    var flashMessages = document.querySelectorAll(".flash-message");
    flashMessages.forEach(function (flashMessage) {
      flashMessage.style.display = "none";
    });
  }, 3000); // 3 seconds
});
