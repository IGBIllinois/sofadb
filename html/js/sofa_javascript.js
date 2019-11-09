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

      $.get("index.php", {
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



// Script for Chrome. When linking to a div tab, like #tab-2, Chrome doesn't
// go to the proper tab without this script.

    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);

    if (window.location.hash && isChrome) {
        //alert("Hash in chrome!" + window.location.hash);
        setTimeout(function () {
            var hash = window.location.hash;
            window.location.hash = "";
            window.location.hash = hash;
            
        }, 300);

    }
        

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




function showBoneRegion(showId) {
    var x = document.getElementById("category").options.length;

    for(var i =1; i<x; i++) {

        var id = document.getElementById("category").options[i].text;

        if(document.getElementById("category").options.selectedIndex == i) {
            document.getElementById(id).style.display = "inline";
        } else {
            document.getElementById(id).style.display = "none";
        }
    }

}


  $(function() {
    $( "#tabs" ).tabs();
  });
  
$('document').ready(function() {
   $(window).scrollTop(0);
});

// checkbox closing
 $(document).ready(function () {
     $('#checkboxes').hide()
 });



// hide checkboxes


 $(document).mouseup(function (e) {
     var ids = document.querySelectorAll('[id]');

     if(!(e.target.id).startsWith('checkbox_label') &&
             !(e.target.id).startsWith('checkboxes_') &&
             !(e.target.id).startsWith('checkbox_container')) {
         
         Array.prototype.forEach.call( ids, function( el ) {
            if((el.id).startsWith('checkbox_container')) {
                el.style.display = "none";
                expanded = false;
            }
        });
         
     };
 });
 
// checkbox dropdown
var expanded = false;

function showCheckboxes(elementId) {

  checkboxes = elementId;

  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}

function hideCheckboxes(){

  document.onclick = function(e){
    if(!(e.target.id).startsWith("checkboxes_") ){
      //element clicked wasn't the div; hide the div
      divToHide.style.display = 'none';
    }
  };
};
// end checkbox dropdown


// Add "Are you sure?" confirmation when leaving add/edit case pages
  $(function() {
    $('#casedata').areYouSure(
      {
        message: 'It looks like you have been editing something. '
               + 'If you leave before saving, your changes will be lost.'
      }
    );
  });
  
// Add "Are you sure?" confirmation when leaving add/edit method info pages  
    $(function() {
    $('#method_info_data').areYouSure(
      {
        message: 'It looks like you have been editing something. '
               + 'If you leave before saving, your changes will be lost.'
      }
    );
  });