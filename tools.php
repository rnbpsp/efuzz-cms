<?php

	function require_input($vars)
	{
		$ret = array();
		$i = 0;
		for (; $i < $vars.length; i++)
		{
			$var = $vars[i];
			$ret[$i] = false;
			if (empty($_POST[$var]))
			{
				$ret[$i] = true;
				$_POST[$var] = '';
			}
		}
		
		
		/*foreach ($vars as $var)
			if (empty($_POST[$var]))
			{
				$ret = false;
				$_POST[$var] = '';
			}
		*/
		return $ret;
	}
	
	
	
?>