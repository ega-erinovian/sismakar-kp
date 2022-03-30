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

// Tabel Karyawan Setting
$(document).ready(function () {
  $(".data-table").each(function (_, table) {
    $(table).DataTable({
      lengthMenu: [
        [5, 10, 25, 50, 100, -1],
        [5, 10, 25, 50, 100, "All"],
      ],
      createdRow: function (row, data) {
        if (data[5].toLowerCase() === "aktif") {
          $("td", row).eq(5).addClass("text-success");
        } else {
          $("td", row).eq(5).addClass("text-danger");
        }
      },
    });
  });
});
