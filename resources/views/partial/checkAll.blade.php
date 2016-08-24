<script>
    $(document).on('change', '#checkAll', function (event) {
        if (this.checked){
            $('input[type="checkbox"]').each(function () {
                this.checked = true;

            })
        }else {
            $('input[type="checkbox"]').each(function () {
                this.checked = false;

            })
        }
    });
//    $('#toggle').click(function () {
//        //check if checkbox is checked
//        if ($(this).is(':checked')) {
//
//            $('#sendNewSms').removeAttr('disabled'); //enable input
//
//        } else {
//            $('#sendNewSms').attr('disabled', true); //disable input
//        }
//    });

</script>