//navigation
// const listItems = document.querySelectorAll('.main-nav li');

// listItems.forEach(item => {
//   item.addEventListener('click', () => {
//     const cid = item.getAttribute('cid');
//     localStorage.setItem('activeCategory', cid);
//     localStorage.setItem('first', false);
//   });
// });

// window.addEventListener('load', () => {
//   const activeCategory = localStorage.getItem('activeCategory');
//   const first = localStorage.getItem('first') ? localStorage.getItem('first') : true;

//   if(first === true)
//   {
//     activeItem = document.querySelector(`.category[cid="0"]`);
//     activeItem.classList.add('active');
//   }
//   if(activeCategory) {
//     const activeItem = document.querySelector(`.category[cid="${activeCategory}"]`);
//     if (activeItem) {
//       activeItem.classList.add('active');
//     }
//   }
// });

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
