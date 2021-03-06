<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2009 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 *
 *
 * $Source: /cvs_backup/e107_0.8/e107_handlers/emailprint_class.php,v $
 * $Revision$
 * $Date$
 * $Author$
 */

if (!defined('e107_INIT')) { exit; }

include_lan(e_LANGUAGEDIR.e_LANGUAGE."/lan_print.php");
include_lan(e_LANGUAGEDIR.e_LANGUAGE."/lan_email.php");

class emailprint 
{
	function render_emailprint($mode, $id, $look = 0) 
	{
		// $look = 0  --->display all icons
		// $look = 1  --->display email icon only
		// $look = 2  --->display print icon only
		

		$text_emailprint = "";

		//new method emailprint_class : (only news is core, rest is plugin: searched for e_emailprint.php which should hold $email and $print values)
		if($mode == "news")
		{
			$email = "news";
			$print = "news";
		}
		else
		{
			//load the others from plugins
			$handle = opendir(e_PLUGIN);
			while (false !== ($file = readdir($handle))) 
			{
				if ($file != "." && $file != ".." && is_dir(e_PLUGIN.$file)) 
				{
					$plugin_handle = opendir(e_PLUGIN.$file."/");
					while (false !== ($file2 = readdir($plugin_handle))) 
					{
						if ($file2 == "e_emailprint.php") 
						{
							require_once(e_PLUGIN.$file."/".$file2);
						}
					}
				}
			}
		}
		

		
		if(deftrue('e_BOOTSTRAP'))
		{
			$genericMail = "<i class='icon-envelope'></i>"; 
			$genericPrint = "<i class='icon-print'></i>"; 
		}
		else // BC
		{
			$genericMail = "<img src='".e_IMAGE_ABS."generic/email.png'  alt='".LAN_EMAIL_7."'  />";
			$genericPrint = "<img src='".e_IMAGE_ABS."generic/printer.png'  alt='".LAN_PRINT_1."'  />";	
		}
		

		if ($look == 0 || $look == 1) 
		{
			$ico_mail = (defined("ICONMAIL") && file_exists(THEME."images/".ICONMAIL) ? "<img src='".THEME_ABS."images/".ICONMAIL."'  alt='".LAN_EMAIL_7."'  />" : $genericMail);
			//TDOD CSS class
			$text_emailprint .= "<a href='".e_HTTP."email.php?".$email.".".$id."' title='".LAN_EMAIL_7."'>".$ico_mail."</a> ";
		}
		if ($look == 0 || $look == 2) 
		{
			$ico_print = (defined("ICONPRINT") && file_exists(THEME."images/".ICONPRINT) ? "<img src='".THEME_ABS."images/".ICONPRINT."' alt='".LAN_PRINT_1."'  />" : $genericPrint);
			//TODO CSS class
			$text_emailprint .= "<a href='".e_HTTP."print.php?".$print.".".$id."' title='".LAN_PRINT_1."'>".$ico_print."</a>";
		}
		return $text_emailprint;
	}
}

?>