$(document).ready(add());

function add(){
  $("#add").on("click", function(e){
    e.preventDefault();
    var frm = $("#form-add").serialize();
    $.ajax({
      type: "POST",
      url: "assets/back/dbconect/querys.php?query=1",
      dataType: "json",
      data: frm
    }).done(function (info) {
    	location.reload();
    })
  });
}