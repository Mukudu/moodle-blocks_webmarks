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
 * Script to manage the links for the Webmarks (Website Bookmarks) block
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

	require_once('../../config.php');
	require_once('webmarks_form.php');
	require_once('lib.php');
	
	global $CFG, $DB, $PAGE;
	$errormessage = '';
	
	require_login();

	$courseid = required_param('courseid',PARAM_INT);
	//need this later to set the course
	$thiscourse = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);  //throws an exception???

	//should really check for the following 2 existance but cycles are expensive
	$blockid = required_param('blockid',PARAM_INT);
	//$thisblock = $DB->get_record('block', array('id' => $blockid), '*', MUST_EXIST);  //throws an exception???	
	
	$webmarkid = optional_param('webmarkid',0,PARAM_INT);
	
	$theaction = optional_param('action', '', PARAM_ALPHA);
	
	/* All the following is required for all types of action */
	
	$context = get_context_instance(CONTEXT_COURSE, $courseid);
	//fix up for the page display			
	$PAGE->set_course($thiscourse);
	$PAGE->set_url('/blocks/webmarks/webmarks.php');
	$PAGE->set_heading($SITE->fullname);
	$PAGE->set_pagelayout('course');
	$PAGE->set_title(get_string('webmarkstitle', 'block_webmarks'));
	$PAGE->navbar->add(get_string('webmarkstitle', 'block_webmarks'));	

	//javascript stuff
	//not sure what this does but it appears to instruct Moodle to load the relevant YUI classes	
    $jsmodule = array(
        'name'  =>  'block_webmarks',
        'fullpath'  =>  '/blocks/webmarks/module.js',
        'requires'  =>  array('base', 'node')
    );	
	//load and initialise the js 
    $PAGE->requires->js_init_call('M.block_webmarks.init',array(),false,$jsmodule);
 
	//set up the form - Get form default/current values
	$formdata = array();
	$formdata['courseid'] = $courseid;
	$formdata['blockid'] = $blockid;
	$formdata['id'] = $webmarkid; 
	$formdata['wbm_title'] = optional_param('wmtitle', null, PARAM_TEXT);
	$formdata['wbm_desc'] = optional_param('wmdesc', null, PARAM_TEXT);
	$formdata['wbm_link'] = optional_param('wmlink', null, PARAM_URL);
	
	if ($theaction == 'editing' && $webmarkid) {
		//here we are editing - this bit is normally done by ajax if JS is switched on - otherwise it has to be done here
		if ($webmark = getWebmarkByID($webmarkid)) {
			$formdata['wbm_title'] = $webmark->wbm_title;
			$formdata['wbm_desc'] = $webmark->wbm_desc;
			$formdata['wbm_link'] = $webmark->wbm_link;
		}	//else we should throw an error
	}elseif ($theaction == 'deleting' && $webmarkid) {
		$DB->delete_records('block_webmarks',array('id'=>$webmarkid));
	}elseif ($theaction == 'saving' && (optional_param('save',0,PARAM_RAW)) ) {			//MAKE SURE WE HAVE SUBMITTED NOT CANCELLED
		//check we have a valid URL for the link - moodle would have replaced it with '' if it was not a valid URL because we specified PARAM_URL
		//NO IT DOES NOT SOMETHING NOT RIGHT HERE
		if ($formdata['wbm_link']) {
			//the record information is already set in $formdata
			$updrecord = (object) $formdata;
			if ($webmarkid) {
				$DB->update_record('block_webmarks',$updrecord);
				$formdata['webmarkid'] = 0; 	//reset recordid
			}else { 
				$DB->insert_record('block_webmarks',$updrecord);
			}
			//now ensure we have a clear form for the next transaction
			$formdata['wbm_title'] = '';
			$formdata['wbm_desc'] = '';
			$formdata['wbm_link'] = '';
		}else{
			$errormessage = 'Please specificy a valid URL for this weblink';
		}
	}

	//get the existing records ready for editing
	$formdata['existingrecs'] = $DB->get_records('block_webmarks',array('blockid'=>$blockid),'wbm_title');

	$wmform = new webmarks_form(null,$formdata);
		
	//display the editing page
	echo $OUTPUT->header();
	echo $OUTPUT->heading(get_string('wmeditingtitle', 'block_webmarks'), 3, 'main');
	$wmform->display();
	if (!empty($errormessage)) {
		echo $errormessage;
	}	
	echo $OUTPUT->footer();	
 
	
?>
