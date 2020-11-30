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
    
 // Updates the list of methods when the method type is selected
 $('#methodtype').change(function(){
        $('#wait_1').show();
        $('#result_1').hide();
        $('#wait_2').hide();
        $('#fchoseninput').val('0');
        $('#pchoseninput').val('0');
        $('#result_2').hide();
        $('#drop_1').hide();
        $('#drop_2').hide();

        $.post("method_info.php", {
		func: "drop_1",
		drop_var: $('#methodtype').val()
            }, 
            function(response){
                $('#result_1').fadeOut();
                setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
            }
        );//end get
    	return false;
	});//end method type change
        //
   
        // user/addcase
        
	$('#wait_1').hide();

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

// Used in drawing method dropboxes
function finishAjax(id, response) {
  $('#wait_1').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();

}

// Used in drawing methods
function finishAjax_tier_three(id, response) {
  $('#wait_2').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
    $('#addmethodbutton').show();
}



// Draws collapseable regions for items like Bone Regions in 
// methods like Spradley/Jantz
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

// Displays tabs
  $(function() {
    $( "#tabs" ).tabs();
  });
  
  // Scroll to top of page
$('document').ready(function() {
   $(window).scrollTop(0);
});

// checkbox closing
 $(document).ready(function () {
     $('#checkboxes').hide()
 });


// Check or uncheck checkboxes
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

// Used to expand or hide a series of checkboxes, like in methods
// like Rios & Cardoso
// parameter: elementId - HTML id of the form element to expand or hide
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

// Hide a series of checkboxes when it's clicked off of
function hideCheckboxes(){

  document.onclick = function(e){
    if(!(e.target.id).startsWith("checkboxes_") ){
      //element clicked wasn't the div; hide the div
      divToHide.style.display = 'none';
    }
  };
};
// end checkbox dropdown

// Enable a field after clicking a link
// Used when a user registers to make sure the signature field is only
// enabled after a user views the terms and conditions
function enableAfterClick(elementid) {
    document.getElementById(elementid).disabled = false;
}

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