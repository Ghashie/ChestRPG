document.addEventListener("DOMContentLoaded", function () {
  const openModalBtn = document.getElementById("openModalBtn");
  const closeModalBtn = document.getElementById("closeModalBtn");
  const modal = document.getElementById("myModal");

  const openJoinModalBtn = document.getElementById("openJoinModalBtn");
  const closeJoinModalBtn = document.getElementById("closeJoinModalBtn");
  const joinModal = document.getElementById("joinModal");

  const openEditModalBtn = document.getElementById("openEditModalBtn"); // Correção aqui
  const closeEditModalBtn = document.getElementById("closeEditModalBtn");
  const editModal = document.getElementById("editModal");

  openModalBtn.addEventListener("click", function () {
    modal.style.display = "block";
  });

  closeModalBtn.addEventListener("click", function () {
    modal.style.display = "none";
  });

  openJoinModalBtn.addEventListener("click", function () {
    joinModal.style.display = "block";
  });

  closeJoinModalBtn.addEventListener("click", function () {
    joinModal.style.display = "none";
  });

  openEditModalBtn.addEventListener("click", function () {
    editModal.style.display = "block";
  });

  closeEditModalBtn.addEventListener("click", function () {
    editModal.style.display = "none";
  });

  window.addEventListener("click", function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
    } else if (event.target === joinModal) {
      joinModal.style.display = "none";
    } else if (event.target === editModal) {
      editModal.style.display = "none";
    }
  });
});
