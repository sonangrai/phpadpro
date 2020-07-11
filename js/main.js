function avt() {
  //document.getElementById("dropdown-box").style.height = "auto";
  var element = document.getElementById("dropdown-box");
  element.classList.add("shavt");
}

$(document).ready(function () {
  $("#prof").click(function () {
    $(".dropdown-box").toggleClass("shavt");
  });
});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("#here").attr("src", e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  }
}

//for custom error msg
document.addEventListener("DOMContentLoaded", function () {
  var elements = document.getElementsByTagName("INPUT");
  for (var i = 0; i < elements.length; i++) {
    elements[i].oninvalid = function (e) {
      e.target.setCustomValidity("");
      if (!e.target.validity.valid) {
        e.target.setCustomValidity("タイトルに何も入力されていません。");
      }
    };
    elements[i].oninput = function (e) {
      e.target.setCustomValidity("");
    };
  }
});

//for popup
// Get the modal
var modal = document.getElementById("myModal");

function popup(a, b) {
  modal.style.display = "block";
  document.getElementById("img01").src = a;
  document.getElementById("caption").innerHTML = b;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
  modal.style.display = "none";
};
