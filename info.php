<?php

/*
  Snippet developed for the Open Source Content Management System Website Baker (http://websitebaker.org)
  Copyright (C) 2016, Christoph Marti

  LICENCE TERMS:
  This snippet is free software. You can redistribute it and/or modify it 
  under the terms of the GNU General Public License  - version 2 or later, 
  as published by the Free Software Foundation: http://www.gnu.org/licenses/gpl.html.

  DISCLAIMER:
  This snippet is distributed in the hope that it will be useful, 
  but WITHOUT ANY WARRANTY; without even the implied warranty of 
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
  GNU General Public License for more details.


  -----------------------------------------------------------------------------------------
   Code snippet OneForAll ItemGroup for Website Baker v2.6.x
  -----------------------------------------------------------------------------------------

 
	DEVELOPMENT HISTORY:

   v0.3  (Christoph Marti; 04/18/2016)
	 + Added FTAN_SUPPORTED file

   v0.2  (Christoph Marti; 01/18/2016)
	 + Added error message if second function argument is not specified
	 + Bugfix: Added trim() function to the csv to array conversion of the group field names

   v0.1  (Christoph Marti; 12/08/2015)
	 + Initial release of OneForAll ItemGroup snippet

  -----------------------------------------------------------------------------------------
*/


$module_directory   = 'oneforall_itemgroup';
$module_name        = 'OneForAll ItemGroup';
$module_function    = 'snippet';
$module_version     = '0.3';
$module_platform    = '2.7';
$module_author      = 'Christoph Marti';
$module_license     = 'GNU General Public License';
$module_description = 'This snippet displays the linked item titles of a specified OneForAll group on any page you want.<br /><b>Requires the module OneForAll or rather the renamed version of OneForAll.</b><br />Function can be invoked from the template or a code section. Call: <code>oneforall_itemgroup($module_name, $groups[, $max_items = null])</code>. Add more than one group using comma separated values.';
?>
