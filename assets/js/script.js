//  Sidebar
$(document).ready(function () {
  $("#sidebarCollapse").on("click", function () {
    $("#sidebar").toggleClass("active");
    $("#content").toggleClass("active");
  });

  $(".more-button,.body-overlay").on("click", function () {
    $("#sidebar,.body-overlay").toggleClass("show-nav");
  });
});

// Table Data
$(document).ready(function () {
  $(".data-table").each(function (_, table) {
    $(table).DataTable({
      lengthMenu: [
        [5, 10, 25, 50, 100, -1],
        [5, 10, 25, 50, 100, "All"],
      ],
      createdRow: function (row, data, index) {
        if (data[5].toLowerCase() === "aktif") {
          $("td", row).eq(5).addClass("text-success");
        } else {
          $("td", row).eq(5).addClass("text-danger");
        }
      },
    });
  });
});

// Table Log
$(document).ready(function () {
  $(".log-table").each(function (_, table) {
    $(table).DataTable({
      lengthMenu: [
        [5, 10, 25, 50, 100, -1],
        [5, 10, 25, 50, 100, "All"],
      ],
    });
  });
});

// Password Validation
var password = document.getElementById("inputPass");
var conf_password = document.getElementById("inputConfPass");

function validatePassword() {
  if (password.value != conf_password.value) {
    conf_password.setCustomValidity("Password Don't Match");
  } else {
    conf_password.setCustomValidity("");
  }
}

password.onchange = validatePassword;
conf_password.onkeyup = validatePassword;
