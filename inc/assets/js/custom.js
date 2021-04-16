(function ($) {
    $(document).ready(function () {

        $('#calendar').datepicker();
       console.log( $('#calendar').val());
       console.log(new Date().toDateString('/'));
        $('#subscribers').submit(function (event) {
            var name = '';
            var email = '';
            if($('#staticName').val()){
                name = $('#staticName').val()
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: "you can't let the Name empty",
                    icon: 'error',
                    confirmButtonText: 'ok'
                })
            }
            if($('#staticEmail2').val()){
                 email = $('#staticEmail2').val()
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: "you can't let the Email empty",
                    icon: 'error',
                    confirmButtonText: 'ok'
                })
            }

            var formData = {
                'name' : name,
                'email':email,

            };
            formData = JSON.stringify(formData);
            $.ajax({
                type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                contentType: "application/json",
                url         : `wp-json/api/v1/subscribers?_wpnonce=${custom_params.wp_rest}`, // the url where we want to POST
                data        : formData, // our data object
                dataType    : 'json', // what type of data do we expect back from the server
                encode          : true,
            })
                // using the done promise callback
                .done(function(data) {

                    // log data to the console so we can see
                   console.log(data);
                   if(data.ok){
                       Swal.fire({
                           title: 'success!',
                           text: "you are subscribed",
                           icon: 'success',
                           confirmButtonText: 'ok'
                       })
                   }else {
                       Swal.fire({
                           title: 'success!',
                           text: "there was an error",
                           icon: 'success',
                           confirmButtonText: 'ok'
                       })
                   }
                    resetSubscriber();

                    // here we will handle errors and validation messages
                });

            // stop the form from submitting the normal way and refreshing the page
            event.preventDefault();
        })

        $('#contact_form').submit(function (event) {
            var contactName = '';
            var contactEmail = '';
            var phone = '';
            var message = '';
            var date = '';

            if($('#contactName').val()){
                contactName = $('#contactName').val()
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: "you can't let the Name empty",
                    icon: 'error',
                    confirmButtonText: 'ok'
                })
            }
            if($('#contactEmail').val()){
                contactEmail = $('#contactEmail').val()
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: "you can't let the Email empty",
                    icon: 'error',
                    confirmButtonText: 'ok'
                })
            }
            if($('#phone').val()){
                phone = $('#phone').val()
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: "you can't let the Phone empty",
                    icon: 'error',
                    confirmButtonText: 'ok'
                })
            }
            if($('#msg').val()){
                message = $('#msg').val()
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: "you can't let the Message empty",
                    icon: 'error',
                    confirmButtonText: 'ok'
                })
            }

            if($('#calendar').val()){
                date = $('#calendar').val()
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: "you can't let the Date empty",
                    icon: 'error',
                    confirmButtonText: 'ok'
                })
            }
            var formContactData = {
                'contact_name' : contactName,
                'contact_email':contactEmail,
                'phone':phone,
                'message':message,
                'date':date,

            };

            formContactData = JSON.stringify(formContactData);

            $.ajax({
                type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                contentType: "application/json",
                url         : `wp-json/api/v1/contacts?_wpnonce=${custom_params.wp_rest}`, // the url where we want to POST
                data        : formContactData, // our data object
                dataType    : 'json', // what type of data do we expect back from the server
                encode          : true,
            })
                // using the done promise callback
                .done(function(data) {

                    // log data to the console so we can see
                    console.log(data);
                    if(data.ok){
                        Swal.fire({
                            title: 'success!',
                            text: "Sooner we'll contact you",
                            icon: 'success',
                            confirmButtonText: 'ok'
                        })
                    }else{
                        Swal.fire({
                            title: 'Error!',
                            text: "you can't let the Date empty",
                            icon: 'error',
                            confirmButtonText: 'ok'
                        })
                    }
                    resetContactData();
                    // here we will handle errors and validation messages
                });


            event.preventDefault();
        })

       function resetSubscriber() {
            console.log("i am here");
           $('#staticName').val('');
           $('#staticEmail2').val('');
       }
       function resetContactData() {
           $('#contactName').val('');
           $('#contactEmail').val('');
           $('#phone').val('');
           $('#msg').val('');
           $('#calendar').val(new Date.toString());
       }

    })
})(jQuery)