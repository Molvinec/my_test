$(document).ready(function(){ 
    $.post("models/user_models.php", 
        {   
            model: "createTable", 
        });

//проверка email

    $("input[name=email]").keyup(function() {
        var text = $("input[name=email]").val();
        $("span").empty();
        if (text !== ""){
            $.ajax({
                method: "POST",
                url: "models/verification_models.php",
                data: {model: "verification", email: text}
            })
            .done(function(data) {
                var data = JSON.parse(data);
                if (data === false) {
                    $("<span>").text(" Такой email свободен").appendTo($("#email"));
                    $("input[name=submit]").prop("disabled", false);
                }
                else {
                    $("<span>").text(" Такой email занят").appendTo($("#email"));
                    $("input[name=submit]").prop("disabled", true);
                }
            }); 
        }
        else {
            return;
        }
    
    });

    //добавление данных

    $("form").submit(function(){
    
    var login = $("input[name=login]").val();
    var email = $("input[name=email]").val();
    var region = $(".region-select").val();
    var city = $(".city-select").val();
    var district = $(".district-select").val();
    
        $.post("models/user_models.php", 
            {   
                login: login, 
                email: email,
                region: region,
                city: city,
                district: district,
                model: "addUser", 
            });

        $(location).attr('href', "views/registration.html");

    return false;
    });

});