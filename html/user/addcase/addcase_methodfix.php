<?php

if(isset($_SESSION['caseid']))
 { 
 unset($_SESSION['num_methods']);
 unset($_SESSION['methodname']);
 unset($_SESSION['methodtype']);
 unset($_SESSION['methodfeature']);
 unset($_SESSION['methodphase']);
 
 unset($_SESSION['loadedmethods']);
       			
				
       		    unset($_SESSION['phasechosen']);
				unset($_SESSION['featurechosen']);
        		 
       
       			unset($_SESSION['caseid']);
 }

?>