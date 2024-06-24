var modal = document.getElementById("profile_modal");

var openBtn = document.getElementById("open"); 

var close2Btn = document.getElementById("close2");

var closeBtn = document.getElementsByClassName("close")[0]; 

openBtn.onclick = function() {
  modal.style.display = "block";
}

close2Btn.onclick = function() {
  modal.style.display = "none";
}

closeBtn.onclick = function() {
  modal.style.display = "none";
}
close2Btn.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
