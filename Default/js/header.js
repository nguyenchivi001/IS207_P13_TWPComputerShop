//navigation
const listItems = document.querySelectorAll('.main-nav li');

listItems.forEach(item => {
  item.addEventListener('click', () => {
    listItems.forEach(li => li.classList.remove('active'));
    
    item.classList.add('active');
  });
});

//responsive navigation
const responsiveNav = document.querySelector('.responsive-nav');
const menu = document.querySelector('.menu');
menu.addEventListener('click', () => {
  if(responsiveNav.classList.contains('active')) 
  {
    responsiveNav.classList.remove('active');
  } 
  else 
  {
    responsiveNav.classList.add('active');
  }
});