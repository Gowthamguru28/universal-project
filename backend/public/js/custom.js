function companyDelete(companyId){
   sweetDelete(companyId);   
    //swal('Delete','Are you sure want to delete?')
}
function sweetDelete(deleteId) {
    swal({
        title: "Delete",
        text: "Are you sure want to delete?",
        // type: "info",
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No"
    }).then(function(isConfirm) {
        if (isConfirm) {
           $('#'+deleteId).submit();
        }
      });
}
function editDelete(editId) {
    $('#'+editId).remove();
}
function getUnit(obj) {
    var val = obj.value;
    var base_url = "{{ URL::to('/')}}";
    $.ajax({
        url: base_url+'/get-unit',
        type: 'get',
        data: { product_id : val },
        dataType: "JSON",
        success: function(response) {			
            $(obj).parents('tr').find('.unit').val(response);
        }
      });	
}
function aa() {
    alert();
}
$( document ).ready(function() {
    
});
