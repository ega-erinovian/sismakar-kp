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
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"],
      ],
      createdRow: function (row, data) {
        if (data[1].toLowerCase() === "aktif" || data[1].toLowerCase() === "show") {
          $("td", row).eq(1).addClass("text-success");
        } else {
          $("td", row).eq(1).addClass("text-danger");
        }
      },
    });
  });
});

// Table Log Aktivitas
$(document).ready(function () {
  $(".log-table").each(function (_, table) {
    $(table).DataTable({
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"],
      ],
      order: [[0, "desc"]],
    });
  });
});
