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