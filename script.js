const links = document.querySelectorAll('.navbar a');
const currentPage = window.location.pathname.split('/').pop();

links.forEach(link => {
  const href = link.getAttribute('href');
  const button = link.querySelector('button');

  if ((href === currentPage) || (href === 'index.html' && (currentPage === '' || currentPage === 'index.html'))) {
    button.classList.add('active');
  }
});
