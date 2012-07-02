<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * Defines the version of Webmarks (Website Bookmarks) Block
 *
 * This code fragment is called by moodle_needs_upgrading() and
 * /admin/index.php
 *
 * @package    block
 * @subpackage webmarks
 * @copyright  2012 Nottingham University
 * @author     Benjamin Ellis - benjamin.ellis@nottingham.ac.uk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version = 2012021603;  // YYYYMMDDHH (year, month, day, 24-hr time) e.g $plugin->version = 2011062800
$plugin->requires = 2011070100; // YYYYMMDDHH e.g.$plugin->requires = 2010112400 (This is the release version for Moodle 2.0)
								// (Moodle 1.9 = 2007101509; Moodle 2.0 = 2010112400; Moodle 2.1 = 2011070100; Moodle 2.2 = 2011120100) 

// OPTIONAL //
								
//$plugin->release = '2.x (Build: 2011051000)';    //Optional - Human-readable version name 
								
$plugin->cron = 0;  //Optional - time interval (in seconds) between calls to the plugin's 'cron' function; set to 0 to disable the cron function calls.
					//Cron support is not yet implemented for all plugins. 

//$plugin->component = 'plugintype_pluginname';    //Optional - frankenstyle plugin name, strongly recommended. It is used for installation and upgrade diagnostics. 

//$plugin->maturity = MATURITY_STABLE;	//Optional - how stable the plugin is: MATURITY_ALPHA, MATURITY_BETA, MATURITY_RC, MATURITY_STABLE (Moodle 2.0 and above) 


/*$plugin->dependencies = array (			//Optional - list of other plugins that are required for this plugin to work (Moodle 2.2 and above)
											//In this example, the plugin requires any version of the forum activity and version '20100020300' (or above) of the database activity
			'mod_forum' => ANY_VERSION, 
			'mod_data' => 2010020300
		);   
			
//$plugin->component = 'block_webmarks'; // To check on upgrade, that block sits in correct place

								
/*
	closing tag for PHP. This is intentional, and a workaround for whitespace issues. 
*/
