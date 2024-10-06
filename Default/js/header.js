//navigation
const listItems = document.querySelectorAll('.main-nav li');

listItems.forEach(item => {
  item.addEventListener('click', () => {
    listItems.forEach(li => li.classList.remove('active'));
    
    this.classList.add('active');
  });
});