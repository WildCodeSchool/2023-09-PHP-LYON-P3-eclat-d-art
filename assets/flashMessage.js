document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    document
      .querySelectorAll(".flash-message")
      .forEach((flashMessage) => (flashMessage.style.display = "none"));
  }, 4000); // 4 seconds
});
