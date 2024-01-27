document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    document.querySelectorAll(".flash-message").forEach(flashMessage => flashMessage.style.display = "none");
  }, 3000); // 3 seconds
});
