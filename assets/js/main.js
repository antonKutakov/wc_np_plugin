(function($){

    $('#myarea').change(function(){
        $(this).find(':selected').attr('data-selected','selected-option')
            .siblings('option').removeAttr('data-selected');
    });
    $('#mycity').change(function(){
        $(this).find(':selected').attr('data-selected','selected-option-city')
            .siblings('option').removeAttr('data-selected');
    });
    $('#mywerehouse').change(function(){
        $(this).find(':selected').attr('data-selected','selected-option-ware')
            .siblings('option').removeAttr('data-selected');
    });

    $("#wusd-settings-form").on("submit", function(e){
        $(".valid-notice-area").removeClass('error');
        $(".valid-notice-city").removeClass('error');
        $(".valid-notice-warehouse").removeClass('error');
        e.preventDefault();
        var selectedArea = $("#myarea option:selected").val();
        var selectedCity = $("#mycity option:selected").val();
        var selectedWarehouse = $("#mywerehouse option:selected").val();
        if(selectedArea == 0  ){
            $(".valid-notice-area").addClass('error');
        }
        else if(selectedCity == 0 ){
            $(".valid-notice-city").addClass('error');

        }
        else if(selectedWarehouse == 0 ){
            $(".valid-notice-warehouse").addClass('error');
        }
        else{
            $(".valid-notice-area").removeClass('error');
            $(".valid-notice-city").removeClass('error');
            $(".valid-notice-warehouse").removeClass('error');
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: $("#wusd-settings-form").serialize() + "&action=wusd_save_settings",
                beforeSend: function(){
                    $(".wusd-preloader").css({'display' : 'flex'});
                },
                complete: function(){
                    $(".wusd-preloader").css({'display' : 'none'});
                },
                success: function (resp) {
                    console.log(resp);
                    $(".wusd-preloader").css({'display' : 'none'});
                }
            });
        }
    });

    $("#myarea").select2({
        placeholder: "Оберіть область",
        allowClear:true
    });
    $("#mycity").select2({
        placeholder: "Оберіть місто",
        allowClear:true
    });
    $("#mywerehouse").select2({

    });

    $("#load_addresses").on('click', function(e){
        e.preventDefault();
        $.ajax({
            type: "GET",
            data: "action=wusd_load_addresses",
            url: ajaxurl,
            beforeSend: function(){
                $(".wusd-preloader").css({'display' : 'flex'});
            },
            complete: function(){
                $(".wusd-preloader").css({'display' : 'none'});   
            },
            success: function(resp) {
                console.log(JSON.parse(resp));
                $(".wusd-preloader").css({'display' : 'none'});
            },
            error: function(resp){
                console.log(resp);
            }
        });
    })

    function render_options(selector, data){
        var options = data;
        var options_count = Object.keys(data).length;
        var content = "";
        for(var i = 0; i < options_count; i++){
               content += "<option value='" + options[i].Ref + "'>"+ options[i].Description +"</option>"
        }
        render_content(selector, content);

    }
    function render_options_cities(selector, data){
        // console.log(data);
        empty_parent(selector, "option");
        var options = data;
        var options_count = Object.keys(data).length;
        var str = $( "#select" ).text();
        var content = "<option value='0'>" + 'Оберіть Місто' + "</option>"
        for(var i = 0; i < options_count; i++){
             content += "<option value='" + options[i].Ref  + "'>"+ options[i].Description +"</option>"
        }

        render_content(selector, content);
    }

    function render_options_cities_nochange(selector, data){
        empty_parent(selector, "option");
        
        var options = data;
        var options_count = Object.keys(data).length;
        // console.log(options);
        var str = $( "#select" ).val();
        
        var curr_city = options.filter(function(city){
            if(city.Description == str){
                return city;
            }
        })

        // console.log(curr_city);

        var content = "<option value='"+ curr_city[0].Ref +"' data-selected='selected-option-city'>" + str  +"</option>"

        for(var i = 0; i < options_count; i++){
             content += "<option value='" + options[i].Ref  + "'>"+ options[i].Description +"</option>"
        }


        render_content(selector, content);
    }

    function render_options_warehouses(selector, data){
        empty_parent(selector, "option");
        var options = data;
        var options_count = Object.keys(data).length;
        var content = "<option value='0'>" + 'Оберіть Відділення' + "</option>"
        for(var i = 0; i < options_count; i++){
            content += "<option value='" + options[i].Ref + "'>"+ options[i].Description +"</option>"
        }
        render_content(selector, content);
    }

    function render_content(append_to = '', content = ''){
        $(append_to).append(content);
    }

    /**
     * Empty parent block
     *
     * @param {string} parent_block
     * @param {string} child_block
     */
    function empty_parent(parent_block = '', child_block = ''){
        if($(parent_block).has(child_block)){
            $(parent_block).empty();
        }
    }
    $( document ).ready(function() {
        $.ajax({
            type: "GET",
            data: "action=wusd_preload_addresses",
            url: ajaxurl,
            success: function (resp) {
                var resp = JSON.parse(resp);
                render_options('.area', resp);
            },
            error: function (resp) {
                console.log(resp);
            }
        });
    })

    /**
     * Render Areas
     *
     * @param {json} resp
     */
    function render_checkout(resp){
        var field = JSON.parse(resp);

        var content = "<div class='test'>";
        content += "<div class='content-item-value'>";
        content += "<p>" + field + "</p>";
        content += "</div>";
        content += "</div>";

        render_content(".wusd_wrap", content);

    }

    $('.area').bind(' change', function(){
        var selected = $(".area option:selected").val();

        $.ajax({
            type: "GET",
            data: "area="+selected+"&action=wusd_preload_cities",
            url: ajaxurl,
            success: function(resp){
                render_options_cities('.city', JSON.parse(resp));
            },
            error: function(resp){
                console.log("error");
            }
        })
    });

    $(function(){
        var selected = $(".area option:selected").val();
        $.ajax({
            type: "GET",
            data: "area="+selected+"&action=wusd_preload_cities",
            url: ajaxurl,
            success: function(resp){
                render_options_cities_nochange('.city', JSON.parse(resp));
            },
            error: function(resp){
                console.log("error");
            }
        })
    });

    $('.city').on('change', function(){
        var selected = $(".city option:selected").text();

        $.ajax({
            type: "GET",
            data: "city="+selected+"&action=wusd_preload_warehouses",
            url: ajaxurl,
            success: function(resp){
                console.log(resp);
                render_options_warehouses('.werehouse', JSON.parse(resp));
            },
            error: function(resp){
                console.log("error");
            }
        })
    });



})(jQuery)






