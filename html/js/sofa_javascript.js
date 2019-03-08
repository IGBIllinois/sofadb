/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// main document.ready() function

$(document).ready(function(){

    // index.php
    $("#submit1").hover(
    function() {
    $(this).animate({"opacity": "0"}, "slow");
    },
    function() {
    $(this).animate({"opacity": "1"}, "slow");
    });
    

// user/addcase
	$('#wait_1').hide();
	
	$('#addmethodbutton').click(function(){
                //var ser = $('#output_data_1').serializeArray();
                //alert("ser = "+ser);
            var od1Values = $('#output_data_1').val();
            var od2Values = $('#output_data_2').val();
            var od1Names;
            if(od1Values === undefined) {
                // get names and values for input boxes
                od1Names = $("input[name^='output_data_1']").map(function(){return $(this).attr('id');}).get();
                od1Values = $("input[name^='output_data_1']").map(function(){return $(this).val();}).get();

            }

	$.get("func.php", {
		savecase: "1",
                od1: od1Values,
                od1Names: od1Names,
                od2: od2Values,
                drop_2: $('#drop_2').val(),
                caseid: $('#caseid').val()
		}, 
        function(response){

                //addRow('hortable',response);
                $('#wait_1').hide();
                $('#wait_2').hide();
                $('#result_1').hide();
                $('#result_2').hide();
                $('#wait_3').hide();
                $('#result_3').hide();
                $('#drop_1').hide();
                $('#drop_2').hide();
                $('#drop_3').hide();
                $('#drop_4').hide();
                $('#fchoseninput').val('0');
                $('#pchoseninput').val('0');
                $('#methodtype').val("");
                $('#addmethodbutton').hide();
                $('hortable').show();
                location.reload(); 
	
	}
                );//end get

});//end document ready functi
	
	
	
		$('#removemethodbutton').click(function(){
	     
	sendarray=deleteRow('hortable');

	$.get("func.php",{delrow:"1",delmethods:JSON.stringify(sendarray)});
	
	
		
});//end action button
	
	$('#editmethodbutton').click(function(){
	     
	senddata=deleteOneRow('hortable');
	recdata=0;
	
	
	$.get("func.php",{editrow:"1",delmethods:senddata},function (resp){$('#methodtype').val(resp).change();});
	$.get("func.php",{editrow:"2",delmethods:senddata},function (resp){ 
	recdata=resp;});
	
	//$('#drop_2').val([]).change();
		$('#drop_2').val("5");
	
	//$('#drop_2').val('1');
	
	//$('#result_1').show();
	//$('#result_2').show();
	//$('#result_3').show();
	
	
		
});//end action button
	
	
	
	
	
	$('#methodtype').change(function(){
	  $('#wait_1').show();
	  $('#result_1').hide();
	  $('#wait_2').hide();
	$('#fchoseninput').val('0');
	$('#pchoseninput').val('0');
	$('#result_2').hide();
	$('#wait_3').hide();
	$('#result_3').hide();
	$('#drop_1').hide();
	$('#drop_2').hide();
	$('#drop_3').hide();
	$('#drop_4').hide();
      $.get("func.php", {
		func: "drop_1",
		drop_var: $('#methodtype').val()
      }, function(response){
        $('#result_1').fadeOut();
        setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
      });//end get
    	return false;
	});//end method type change
        
        
    //user/editmethod    
	$('#wait_1').hide();
	
    $('#addmethodbutton').hide();
	
	$('#addmethodbutton2').click(function(){

	$.get("func.php", {
		savecase: "1"
		//mtypenum : $('#methodtype').val(),
		//mtype : $('#methodtype option:selected').html(),
		//mname : $('#drop_2 option:selected').html(),
		//featname : $('#drop_3 option:selected').html()
		}, function(response){
			addRow('hortable',response);
			$('#wait_1').hide();
	$('#wait_2').hide();
	$('#result_1').hide();
	$('#result_2').hide();
	$('#wait_3').hide();
	$('#result_3').hide();
	$('#drop_1').hide();
	$('#drop_2').hide();
	$('#drop_3').hide();
	
	$('#methodtype').val("");
	$('#addmethodbutton').hide();
	$('hortable').show();
			
			
			});//end get
		



});//end document ready functi
	
	
	
		$('#removemethodbutton2').click(function(){
	     
	sendarray=deleteRow('hortable');
	
	$.get("func.php",{delrow:"1",delmethods:JSON.stringify(sendarray)});
	
	
		
});//end action button
	
	$('#editmethodbutton2').click(function(){
	     
	senddata=deleteOneRow('hortable');
	recdata=0;
	
	
	$.get("func.php",{editrow:"1",delmethods:senddata},function (resp){$('#methodtype').val(resp).change();});
	$.get("func.php",{editrow:"2",delmethods:senddata},function (resp){ 
	recdata=resp;});
	
	//$('#drop_2').val([]).change();
		$('#drop_2').val("5");
	
	//$('#drop_2').val('1');
	
	//$('#result_1').show();
	//$('#result_2').show();
	//$('#result_3').show();
	
	
		
});//end action button
	
	
	
	
	
	$('#methodtype').change(function(){
	  $('#wait_1').show();
	  $('#result_1').hide();
	  $('#result_2').hide();
	$('#wait_3').hide();
	$('#result_3').hide();
	$('#drop_1').hide();
	$('#drop_2').hide();
	$('#drop_3').hide();
	$('#drop_4').hide();
	  
      $.get("func.php", {
		func: "drop_1",
		drop_var: $('#methodtype').val()
      }, function(response){
        $('#result_1').fadeOut();
        setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
      });//end get
    	return false;
	});//end method type change
});

// user/addcase


function finishAjax(id, response) {
  $('#wait_1').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();

}
function finishAjax_tier_three(id, response) {
  $('#wait_2').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
    $('#addmethodbutton').show();
}


function finishAjax_tier_four(id, response) {
  $('#wait_3').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}



  $(function() {
    $( "#tabs" ).tabs();
  });