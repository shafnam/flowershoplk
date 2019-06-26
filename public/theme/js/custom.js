$(document).ready(function(){
        
    /* 
    ******************* 
        IMAGE UPLOAD 
    ******************
    */

    var id = 1;
    var inpId = id;

    var _URL = window.URL || window.webkitURL;
    
    /* show add another image button when previous image uploaded */
    $('div.input-files').on('change', 'input:file', function (e) {

        var showId = ++id;
        var prevId = showId -1;

        // Gets the number of elements with class pn
        var numItems = $('.upimg').length
        
        if(numItems <=5)
        {
            //$(".input-files").append('<div class="row mb-3 upimg img-'+showId+'"><div class="col-lg-4"><div id="uploadPreview-'+showId+'" class="prev-img"></div></div><div class="col-lg-8"><label for="file-upload" class="custom-file-upload" id="file-up-btn-'+showId+'">Add a Photo</label><input type="file" name="file_upload[]"></div><a href="javascript:void(0);" id="remove-'+showId+'" class="remImg" style="display:none;">Remove</a></div>');
            $("#file-up-btn-"+prevId).hide();
            $("#remove-"+prevId).show();
            $("#addAnother").show();
            //alert(numItems+"!");
            
        }

        /* image preview */
        var image, file;
        if ((file = this.files[0])) {
            image = new Image();
            image.onload = function() {
                src = this.src;
            $('#uploadPreview-'+prevId).html('<img src="'+ src +'"></div>');
                e.preventDefault();
            }
        };
        image.src = _URL.createObjectURL(file);
        //alert(prevId);
        /* .image preview */

        if(numItems == 5){
            $("#file-up-btn-"+numItems).hide();
            $("#remove-"+numItems).show();
            $("#addAnother").hide();
        }

    });

    $("#addAnother").on('click', '.addImg', function () {
        
        var showId = id;
        var prevId = showId -1;
        // Gets the number of elements with class pn
        var numItems = $('.upimg').length

        $("#addAnother").hide(); 
        $(".input-files").append('<div class="row upimg img-'+showId+'"><div class="col-lg-3"><div id="uploadPreview-'+showId+'" class="prev-img"></div></div><div class="col-lg-4"><label for="file-upload" class="custom-file-upload" id="file-up-btn-'+showId+'">Add a Photo</label><input type="file" name="file_upload[]"></div><a href="javascript:void(0);" id="remove-'+showId+'" class="remImg" style="display:none;"><i class="fa fa-minus-circle remove-num" aria-hidden="true"></i> Delete Image</a></div>');
        $("#addAnother").hide();
        if(numItems <=5)
        {
            $("#file-up-btn-"+prevId).hide();
            $("#remove-"+prevId).show();
        }
    });

    $(".input-files").on('click', '.remImg', function () {

        var showId = id;
        var prevId = showId -1;
        // Gets the number of elements with class pn
        var numItems = $('.upimg').length

        if(numItems <=5)
        {
            /*$("#file-up-btn-"+prevId).hide();
            $("#remove-"+prevId).show();*/
            //$("#remove-4").hide();
            $("#addAnother").show();   
        }
        $("#" + $(this).attr("id")).parent().remove();

    });
    
});

$(document).ready(function(){
    
    /* 
    ******************* 
        IMAGE UPLOAD 
    ******************
    */

    //var id = 1;
    var id = $('#e_img_count').val(); //current number of elements
    var _URL = window.URL || window.webkitURL;
    
    /* show add another image button when previous image uploaded */
    $('div.input-files').on('change', 'input:file', function (e) {

        var showId = ++id;
        var prevId = showId -1; 
        // Gets the number of elements with class pn
        var numItems = $('.upimg').length
        
        if(numItems <=5)
        {
            $("#edit-file-up-btn-"+prevId).hide();
            $("#editRemove-"+prevId).show();
            $("#editAddAnother").show();    
        }

        /* image preview */
        var image, file;
        if ((file = this.files[0])) {
            image = new Image();
            image.onload = function() {
                src = this.src;
            $('#editUploadPreview-'+prevId).html('<img class="img-fluid" src="'+ src +'"></div>');
                e.preventDefault();
            }
        };
        image.src = _URL.createObjectURL(file);
        /* .image preview */

        if(numItems == 5){
            $("#edit-file-up-btn-"+numItems).hide();
            $("#editRemove-"+numItems).show();
            $("#editAddAnother").hide();
        }

    });

    $("#editAddAnother").on('click', '.addImg', function () {
        
        var showId = id;
        var prevId = showId -1;
        // Gets the number of elements with class pn
        var numItems = $('.upimg').length

        $("#editAddAnother").hide(); 
        $(".input-files").append('<div class="row upimg img-'+showId+'"><div class="col-lg-4"><div id="editUploadPreview-'+showId+'" class="prev-img"></div></div><div class="col-lg-4"><label for="file-upload" class="custom-file-upload" id="edit-file-up-btn-'+showId+'">Add a Photo</label><input type="file" name="file_upload[]"></div><a href="javascript:void(0);" id="editRemove-'+showId+'" class="remImg" style="display:none;"><i class="fa fa-minus-circle remove-num" aria-hidden="true"></i> Delete Image</a></div>');
        if(numItems <=5)
        {
            $("#edit-file-up-btn-"+prevId).hide();
            $("#editRemove-"+prevId).show();
        }
    });

    $(".input-files").on('click', '.remImg', function () {

        var showId = id;
        var prevId = showId -1;
        // Gets the number of elements with class pn
        var numItems = $('.upimg').length

        alert('numItems' + numItems);

        if(numItems <=5)
        {
            $("#editAddAnother").show();   
        }
        $("#" + $(this).attr("id")).parent().remove();
    });

    //remove normal images
    $(".edit-img-preview").on('click', '.remImg', function () {
        var numItems = $('.upimg').length
        $("#" + $(this).attr("id")).parent().remove();
        if(numItems <=5){
            $("#editAddAnother").show();
        }
    });
    
});

$(document).ready(function(){
    //$("#successMessageEditProduct").delay(2000).slideUp(800);
    $("#successMessageEditProduct").delay(2000).slideUp( "slow", function() {
        $('#backButton').show();
    });
});

$(document).ready(function(){
    $('.bxslider').bxSlider({
        auto: true,
        autoControls: true,
        stopAutoOnClick: true,
        pager: true,
        slideWidth: 500
    });
});

$(document).ready(function() {
    /* 
    ******************* 
        DYNAMIC TABLE (DELIVERY AREAS)
    ******************
    */
    // var counter = 1;

    // $("#addrow").click(function () {
    //     counter += 1;
    //     $("#delivery_charges tr:last").after("<tr><td><select class='form-control' name=delivery_area[]' required><?php echo fill_unit_select_box($connect); ?></select></td><td><input type='number' class='form-control del_d' name='delivery_charge[]' value='' step='any' required></td><td><input type='hidden' name='id[]' value='"+counter+"'></td><td><input class='btn btn-sm btn-link btn-danger del' type='button' value='delete'></td></tr>");
    // });

    $("#addrow").click(function () {
        //$('.del').show();
        var old_row = $('#delivery_charges tbody tr:last');
        //var new_element = old_row.append(old_row);
        $('#delivery_charges tbody').append(old_row.clone());
    });

    $('.del_d').on('keyup', function () {
        var showBtn = true;
        // Check all inputs
        $('.del_d').each(function () {
            showBtn = showBtn && ($(this).val() !== "");
        });
        // Hide or show the button according to the boolean value
        $("#addrow").toggle(showBtn);
    });

    $('body').on('click', '.del', function(){
        $(this).parent().parent().remove();
    });

});

$(document).ready(function(){
    $("#order_process_form #order_status").change(function( event ) {
        event.preventDefault();
        //var postId = $(this).data('id'); 
        var postId = this.value;
        if(postId == '2'){
            var orderStatus = 'processing';
        }
        else if(postId == '3'){
            var orderStatus = 'completed';
        }
        else if(postId == '0'){
            var orderStatus = 'incomplete';
        }
        else if(postId == '-1'){
            var orderStatus = 'cancelled';
        }
        swal({
            title: "Are you sure?",
            text: "This action will change the order status to " + orderStatus +  "!",
            icon: "success",
            buttons: true,
            //dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $("#order_process_form").off("submit").submit();
                swal("Success! Order status changed!", {
                    icon: "success",
                });
            } else {
                swal("Order status not changed!");
            }
        });
    });

    $("#order_complete_form #order_status").change(function( event ) {
        event.preventDefault();
        
        var postId = this.value;

        if(postId == '2'){
            var orderStatus = 'processing';
        }
        else if(postId == '3'){
            var orderStatus = 'completed';
        }
        else if(postId == '0'){
            var orderStatus = 'incomplete';
        }
        else if(postId == '-1'){
            var orderStatus = 'cancelled';
        }

        swal({
            title: "Are you sure?",
            text: "This action will change the order status to " + orderStatus +  "!",
            icon: "success",
            buttons: true,
        }).then((willDelete) => {
            if (willDelete) {
                $("#order_complete_form").off("submit").submit();
                swal("Success! Order status changed!", {
                    icon: "success",
                });
            } else {
                swal("Order status not changed!");
            }
        });
    });

    $("#order_incomplete_form #order_status").change(function( event ) {
        event.preventDefault();
        
        var postId = this.value;

        if(postId == '2'){
            var orderStatus = 'processing';
        }
        else if(postId == '3'){
            var orderStatus = 'completed';
        }
        else if(postId == '0'){
            var orderStatus = 'incomplete';
        }
        else if(postId == '-1'){
            var orderStatus = 'cancelled';
        }

        swal({
            title: "Are you sure?",
            text: "This action will change the order status to " + orderStatus +  "!",
            icon: "success",
            buttons: true,
        }).then((willDelete) => {
            if (willDelete) {
                $("#order_incomplete_form").off("submit").submit();
                swal("Success! Order status changed!", {
                    icon: "success",
                });
            } else {
                swal("Order status not changed!");
            }
        });
    });

    $("#order_cancelled_form #order_status").change(function( event ) {
        event.preventDefault();
        
        var postId = this.value;

        if(postId == '2'){
            var orderStatus = 'processing';
        }
        else if(postId == '3'){
            var orderStatus = 'completed';
        }
        else if(postId == '0'){
            var orderStatus = 'incomplete';
        }
        else if(postId == '-1'){
            var orderStatus = 'cancelled';
        }

        swal({
            title: "Are you sure?",
            text: "This action will change the order status to " + orderStatus +  "!",
            icon: "success",
            buttons: true,
        }).then((willDelete) => {
            if (willDelete) {
                $("#order_cancelled_form").off("submit").submit();
                swal("Success! Order status changed!", {
                    icon: "success",
                });
            } else {
                swal("Order status not changed!");
            }
        });
    });

});