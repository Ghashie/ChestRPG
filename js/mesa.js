document.addEventListener("DOMContentLoaded", function() {
    const openModalBtn = document.getElementById("openModalBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const modal = document.getElementById("myModal");
  
    openModalBtn.addEventListener("click", function() {
      modal.style.display = "block";
    });
  
    closeModalBtn.addEventListener("click", function() {
      modal.style.display = "none";
    });

    openJoinModalBtn.addEventListener("click", function() {
      joinModal.style.display = "block";
    });
  
    closeJoinModalBtn.addEventListener("click", function() {
      joinModal.style.display = "none";
    });
  
    window.addEventListener("click", function(event) {
      if (event.target === modal) {
        modal.style.display = "none";
      } else if (event.target === joinModal) {
        joinModal.style.display = "none";
      }
    });
  });

  