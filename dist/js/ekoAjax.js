
function AddExam()
{
   
    $("#dropResponse").empty();
    var search_query = $("input[name=inputEstimatedBudget]").val();
    var search_type = $("#inputStatus").val();
    $.ajax({
        type : 'POST',
        url: ajax_url+'JSON/AddExam.php',
        data: {search_query:search_query,search_type:search_type},
        success: function(mesaj){
            
            $("#dropResponse").append(mesaj);
        }
    });
}