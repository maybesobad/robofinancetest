$(".query").change(function () {
  var elem = this;
  $.ajax({
    type: "GET",
    url: "ajax.php?check=" + elem.value,
    success: function (response) {
      var jsonData;
      try {
        jsonData = JSON.parse(response);
      } catch (err) {
        $("table").html("unidentified error");
        $(".paginator").html("");
        return;
      }
      if (jsonData.error) {
        $("table").html(jsonData.error);
        $(".paginator").html("");
      } else {
        $("table").html(jsonData.table);
        $(".paginator").html(jsonData.paginator);
      }
    },
  });
});

$(document).on("click", "li", function () {
  if ($(this).hasClass("active") || $(this).hasClass("disabled")) {
    return;
  }
  var elem = $(this);
  var limit = elem.data("limit");
  var page = elem.data("page");
  var query = elem.data("query");

  $.ajax({
    type: "GET",
    url: "ajax.php?limit=" + limit + "&page=" + page + "&check=" + query,
    success: function (response) {
      var jsonData = JSON.parse(response);
      $("table").html(jsonData.table);
      $(".paginator").html(jsonData.paginator);
    },
  });
});
