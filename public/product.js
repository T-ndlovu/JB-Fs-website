
/*Product images*/
let sIndex = 1;
showSlide(sIndex);

function plusSlide(n) {
  showSlide(sIndex += n);
}

function currentS(n) {
  showSlide(sIndex = n);
}

function showSlide(n) {
  let r;
  let slide = document.getElementsByClassName("mySlide");
  let dots = document.getElementsByClassName("demo");
  let captionText = document.getElementById("caption");
  if (n > slide.length) {sIndex = 1}
  if (n < 1) {sIndex = slide.length}
  for (r = 0; r < slide.length; r++) {
    slide[r].style.display = "none";
  }
  for (r = 0; r < dots.length; r++) {
    dots[r].className = dots[r].className.replace(" active", "");
  }
  slide[sIndex-1].style.display = "block";
  dots[sIndex-1].className += " active";
  captionText.innerHTML = dots[sIndex-1].alt;
}




//Info regarding product

function openinfo(evt, Name) {
  var v, x, tablinks;
  x = document.getElementsByClassName("info");
  for (v = 0; v < x.length; v++) {
      x[v].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (v = 0; v < tablinks.length; v++) {
      tablinks[v].className = tablinks[v].className.replace(" activebar", "");
  }
  document.getElementById(Name).style.display = "block";
  evt.currentTarget.className += " activebar";
}
