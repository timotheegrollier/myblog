$(document).ready(function () {
  $(".editArtBtn").click(function () {
    $(this).toggle();
    $(".article").toggle();
    $("#newArticle").toggle();
    $("#exitArt").show();
  });

  $("#exitArt").click(function () {
    $(this).toggle();
    $(".article").toggle();
    $("#newArticle").toggle();
    $(".editArtBtn").toggle();
  });
});
