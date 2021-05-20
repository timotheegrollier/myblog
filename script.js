$(document).ready(function () {
  $("#signin").click(() => {
    $(".logo").hide();
    $("#inscription").show();
    $(".article").hide();
    $(".login").hide();
  });
  $("#exitSign").click(() => {
    $("#inscription").hide();
    $(".article").show();
    $(".logo").show();
    $(".login").show();
  });

  $("#inscription").submit((e) => {
    e.preventDefault();
    let prenom = e.target[0].value;
    let nom = e.target[1].value;
    let pseudo = e.target[2].value;
    let email = e.target[3].value;
    let password = e.target[4].value;
    let passConfirm = e.target[5].value;
    // let avatar = e.target[6].files[0];
    // console.log(avatar);

    $.ajax({
      url: "./inscription.php", // La ressource ciblée
      type: "POST",
      data: {
        prenom: prenom,
        nom: nom,
        pseudo: pseudo,
        mail: email,
        password: password,
        mdpConfirm: passConfirm,
      },
      // cache: false,
      // contentType: false,

      dataType: "JSON",

      success: (resp) => {
        console.log(resp);
        $("#error").empty();
        for (error in resp.messages) {
          console.log(resp.messages[error]);
          if (resp.status === "ko") {
            $("#inscription").hide();
            $("#error").css("display", "flex");
            $("#error").append(
              "<p class='errorContent'>" + resp.messages[error] + "</p>"
            );
            setTimeout(() => {
              $("#error").hide();
              $(".logo").show();
            }, 1200);
          }
        }

        if (resp.status === "ok") {
          $("#connected").empty();
          $("#inscription").hide();
          $("#connected").append("<h6>" + resp.message + "</h6>");
          $("#connected").show();
          setTimeout(() => {
            window.location.replace("index.php");
          }, 800);
          setInterval(() => {
            $("#connected").hide();
            $(".logo").show();
          }, 1200);
        }
      },

      error: (resp) => {
        $("<div class='error'><h3>ERREUR</h3></div>");
      },
    });
  });

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
