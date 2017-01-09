$(document).ready(function(){ 
    $(".region-select").chosen({
        width: "313px",
        no_results_text: "Ничего не найдено!",
        placeholder_text_single: "Выберите область",
    });


    //области

    $(".region-select").on('chosen:showing_dropdown', function(params) {
        
        $(".region-select").empty();
        $(".city-select").empty();
        $(".district-select").empty();
        $(".district-select").trigger("chosen:updated");
        $(".city-select").trigger("chosen:updated");
        
        $.get("models/region_models.php?model=getRegion", function(data) {
            $(".district-select").trigger("chosen:updated");
            $(".city-select").trigger("chosen:updated");
			var data = JSON.parse(data);
            for (var i = 0; i < data.length; i++) {
                $("<option>").html(data[i]).appendTo($(".region-select"));
            }
            $(".region-select").trigger("chosen:updated");
        });

    });

    //города

    $(".region-select").on('change', function(evt, params) {
        $(".district-select").empty();
        $(".district-select").trigger("chosen:updated");
        
        if ( $("select").hasClass("city-select") ) {
            getCity();
        }
        else {
            $("<br><br>").appendTo($(".location"));
            $("<select>").attr('class','city-select').appendTo($(".location"));
            getCity();
        }
            
        $(".city-select").chosen({
            width: "313px",
            no_results_text: "Ничего не найдено!",
            placeholder_text_single: "Выберите город",
        });

            function getCity(){
                $.get("models/region_models.php?model=getCity&region=" + params["selected"], function(data) {
                    $(".district-select").empty();
                    $(".city-select").empty();
                    $(".city-select").trigger("chosen:updated");
                    var data = JSON.parse(data);
                    for (var i = 0; i < data.length; i++) {
                        $("<option>").html(data[i]).appendTo($(".city-select"));
                    }
                    $(".city-select").trigger("chosen:updated");
                });
            }
        
        //районы
        
        $(".city-select").on('change', function(evt, params) {
        
            if ( $("select").hasClass("district-select") ) {
                getDistrict();
            }
            else {
                $("<br><br>").appendTo($(".location"));
                $("<select>").attr('class','district-select').appendTo($(".location"));
                getDistrict();
            }

            $(".district-select").chosen({
                width: "313px",
                no_results_text: "Ничего не найдено!",
                placeholder_text_single: "Выберите район",
            });

            function getDistrict(){
                $.get("models/region_models.php?model=getDistrict&city=" + params["selected"], function(data) {
                    $(".district-select").empty();
                    $(".district-select").trigger("chosen:updated");
                    var data = JSON.parse(data);
                    for (var i = 0; i < data.length; i++) {
                        $("<option>").html(data[i]).appendTo($(".district-select"));
                    }
                    $(".district-select").trigger("chosen:updated");
                });
            }
        
        });

    });

});