/**
 * Projet Name : Dynamic Form Processing with PHP
 * URL: http://techstream.org/Web-Development/PHP/Dynamic-Form-Processing-with-PHP
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Tech Stream
 * http://techstream.org
 */


function msieversion()
   {
      var ua = window.navigator.userAgent;
      var msie = ua.indexOf ( "MSIE " );

      if ( msie > 0 )      // If Internet Explorer, return version number
         return parseInt (ua.substring (msie+5, ua.indexOf (".", msie )));
      else                 // If another browser, return 0
         return 0;

   }





function addRow(tableID,linkingID) {
	var fChosen=parseInt(document.getElementById("fchoseninput").value);
	var pChosen=parseInt(document.getElementById("pchoseninput").value);

        
	if (!msieversion())
	{
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	if(rowCount < 201){							// limit the user from creating fields more than your limits
	//	var fChosen = @Session["featurechosen"][0];
		//var pChosen = @Session["phasechosen"][0];
		
		
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
                
		for(var i=0; i<colCount; i++) {
			if(i==0)
			{var newcell = row.insertCell(i);
			newcell.innerHTML = "<input type='checkbox' name='chk[]'  />";}
                        else if(i==1) {
                            var newCell = row.insertCell(i);
                            newCell.innerHTML = "Edit";
                            
                        } else if(i==2) {
                            var newCell = row.insertCell(i);
                            newCell.innerHTML = '<form action="index.php" method="post" id="removedata" onsubmit="return confirm(\'Do you really want to remove this method from this case?\')"> <input name="delid" type="hidden" value="'+linkingID.trim()+'"/><input name="delsubmit" type="submit" value="Remove" /> </form>';

                        
                        }   
			else if (i==3)
			{
				var newcell=row.insertCell(i);
				
				
				
				newcell.innerHTML=$('#methodtype option:selected').html();
				}
			else if (i==4)
			{
				var newcell=row.insertCell(i);
				
				
				
				newcell.innerHTML=$('#drop_2 option:selected').html();
				}
				
			else if (i==5)
			{
				var newcell=row.insertCell(i);
				

                                dataoutput = "";
                                od1 = $('#output_data_1').val();
                                od2 = $('#output_data_2').val();
                                for(j = 0; j<od1.length; j++) {
                                    for(k=0; k<od2.length; k++) {
                                        dataoutput += "("+od1[j]+", "+od2[k]+") ";
                                    }
                                }
                                
                                newcell.innerHTML=dataoutput;

                        } else if (i == 6) {
			if (fChosen!=0 && pChosen!=0)
			{newcell.innerHTML=$('#drop_3 option:selected').html().concat("|",$('#drop_4 option:selected').html());}
			else if (fChosen!=0 && pChosen==0)
			{ newcell.innerHTML=$('#drop_3 option:selected').html().concat("|No Measurement");}
			else if (fChosen==0) 
			{newcell.innerHTML="None|No Measurement";}
	
				
				
				} 
				else if (i>3)
				{
				var newcell=row.insertCell(i);
                                newcell.innerHTML=$('#drop_3 option:selected').html();
				}
			
		}
	}else{
		 alert("Maximum number of methods is 200.");
			   
	}

	}//end if not internet explorer
	else{
	//var fChosen = @Session["featurechosen"][0];
	//	var pChosen = @Session["phasechosen"][0];
	
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	if(rowCount < 201){							// limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
		for(var i=0; i<colCount; i++) {
			if(i==0)
			{var newcell = row.insertCell(i);
			newcell.innerHTML = "<input type='checkbox' name='chk[]'  />";}
			else if (i==1)
			{
				var newcell=row.insertCell(i);
				
				
				
				newcell.innerHTML=$('#methodtype option:selected').html();
				}
				else if (i==2)
			{
				var newcell=row.insertCell(i);
				
				
				
				newcell.innerHTML=$('#drop_2 option:selected').html();
				}
				
				else if (i==3)
			{
				var newcell=row.insertCell(i);
				if (fChosen!=0 && pChosen!=0)
			{newcell.innerHTML=$('#drop_3 option:selected').html().concat("|",$('#drop_4 option:selected').html());}
				else if (fChosen!=0 && pChosen==0)
				{ newcell.innerHTML=$('#drop_3 option:selected').html().concat("|No Measurement");}
				else if (fChosen==0) 
				{newcell.innerHTML="None|No Measurement";}
			//	newcell.innerHTML='<a href="./viewdetails.php?id='+ linkingID + '\">Details</a>';
				//if ( $('#drop_3').val()=="")
				//{
				//newcell.innerHTML="";
				//}
				//else {newcell.innerHTML=$('#drop_3 option:selected').html();}
				
				
				} 
				else if (i>3)
				{
				var newcell=row.insertCell(i);
				newcell.innerHTML='<a href="./viewdetails.php?id='+ linkingID + '\">Details</a>';	
				}
			
		}
	}else{
		 alert("Maximum number of methods is 200.");
			   
	}
	
	
	
	
	
	
	
		
	}//end if internet explorer


}

function deleteRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	
	var methindex=0;
	var deletemethods= new Array();
	var numdeletedmethods=0;
	
	for(var i=1; i<rowCount; i++) {
		methindex++;
		
		
		var row = table.rows[i];
		var chkbox = row.cells[0].childNodes[0];
		
		if(null != chkbox && true == chkbox.checked) {
					
			
			if(rowCount <= 1) { 						// limit the user from removing all the fields
				alert("Cannot Remove Any More.");
				break;
			}
			table.deleteRow(i);
			deletemethods[numdeletedmethods]=methindex;
			numdeletedmethods++;
			
			rowCount--;
			i--;
		}
	}

deletemethods.unshift(numdeletedmethods);

return deletemethods;

}

function deleteOneRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	
	var methindex=0;
	var deletemethods=-1;
	var numdeletedmethods=0;
	
	for(var i=1; i<rowCount; i++) {
		methindex++;
		
		
		var row = table.rows[i];
		var chkbox = row.cells[0].childNodes[0];
		
		if(null != chkbox && true == chkbox.checked) {
					
			
			if(numdeletedmethods == 1) { 						// limit the user from removing all the fields
				alert("Only First Selected Method Will Be Edited.");
				return deletemethods;
			}
			table.deleteRow(i);
			deletemethods=methindex;
			numdeletedmethods++;
			
			rowCount--;
			i--;
		}
	}

if(deletemethods==-1)
{alert("Please Select a Method to Edit First.");}


return deletemethods;

}