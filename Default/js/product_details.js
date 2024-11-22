function changeImage(thumbnail) {
  const mainImage = document.getElementById("mainImage");
  mainImage.src = thumbnail.src;
}


const input = document.getElementById('quantity');
input.addEventListener('input', function() {
  if (parseInt(input.value) < 1) {
    input.value = 1;
  }
});