<?php

	/* Sidebar init */ 
	 if ( function_exists('register_sidebars') )
	 register_sidebars(2);
 
 
  /* function to handle plural word conjugates 
	 * echo noun(0, 'mouse', 'mice');
	 */  
	 function noun($num, $singular, $plural){
		 return ($num == 1)? $singular : $plural;
	 	}
?>