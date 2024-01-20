const dropdownButton = document.querySelector('.dropdown-button');
const dropdownContent = document.querySelector('.dropdown-content');

dropdownButton.addEventListener('click', function() {
    dropdownContent.style.display = dropdownContent.style.display === 'none' ? 'block' : 'none';
});