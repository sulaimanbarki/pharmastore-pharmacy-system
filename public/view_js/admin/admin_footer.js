"use strict";
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $(function () {
    //Date picker
      $('#datepicker').datepicker({
        autoclose: true
      })
      
  }) 

  $(document).ready(function() {
  $('.select2').select2();


  $('.category').change(function(){
    var cat_id= $(this).val();

    $.ajax({
      url:  '{{route("ajax_groups")}}',
      dataType: 'json',
      type: 'post',
      data: {category_id: cat_id},
      success:function(response){
        var html_output='';
        for (i = 0; i < response.length; i++) {
          html_output += '<option value="'+response[i].id+'">'+response[i].name+'</option>';          
        }
        $('.medicine_group').html(html_output);        
      }
    });

  });

});
  

function delete_item(url){
      event.preventDefault();
      bootbox.confirm({
      message: "Are you sure to delete this?",
      buttons: {
          confirm: {
              label: 'Yes',
              className: 'btn-danger'
          },
          cancel: {
              label: 'No',
              className: 'btn-success'
          }
      },
      callback: function (result) {
          if(result==true){
            location.href = url;
          }
      }
  });
    }