<div id="success_message" class="alert alert-success" style="display: none; font-size: 0.5rem;"></div>


<form id="enquiry">

    <h2>Send an enquiry about <?php the_title();?></h2>
    
    <input type="hidden" name="registration" value="<?php the_field('registration');?>">

    <form>
        <div class="form-group row mb-2">
            <div class=" row col-md mb-1">
                <input type="text" name="fname" placeholder="First Name" class="form-control" required>
            </div>
            <div class="row col-md mb-1 offset-md-1">
                <input type="text" name="lname" placeholder="Last Name" class="form-control" required>
            </div>
        </div>
        <div class="form-group row mb-2">
            <div class="row col mb-1">
                <input type="email" name="email" placeholder="Email Address" class="form-control" required>
            </div>
            <div class="row col mb-1 offset-md-1">
                <input type="tel" name="phone" placeholder="Phone" class="form-control" required>
            </div>
        </div>
        <div class="form-group row mb-3">
            <textarea name="enquiry" class="form-control" placeholder="Your Enquiry" required></textarea>
        </div>
        <div class="form-group row mb-3">
            <button type="submit" class="btn btn-success btn-block">Send your enquiry</button>
        </div>
    </form>

<script>
    (function($){
        $('#enquiry').submit(function(event){
            event.preventDefault();
            var endpoint = '<?php echo admin_url('admin-ajax.php');?>';

            var form = $('#enquiry').serialize();

            var formdata = new FormData;

            formdata.append('action', 'enquiry');
            // Append nonce for security
            formdata.append('nonce', '<?php echo wp_create_nonce('ajax-nonce');?>');
            formdata.append('enquiry', form);

            $.ajax(endpoint, {
                type: 'POST',
                data:formdata,
                processData: false,
                contentType: false,//type of data

                success: function(res){
                    //alert(res.data);

                    // this will hidden after submit button
                    $('#enquiry').fadeOut(200);
                    //success function
                    $('#success_message').text('Thanks for your enquiry').show();

                    // reset the form after submission
                    $('#enquiry').trigger('reset');

                    // the screen will back to the top page before send message
                    $('#enquiry').fadeIn(500);

                },
                error: function(err)
                {
                    alert(err.responseJSON.data);
                }
            })
        })
    })(jQuery)
</script>
    