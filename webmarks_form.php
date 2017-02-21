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
 * Script to defining the form to manage the links for the Webmarks (Website Bookmarks) block
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

require_once("$CFG->libdir/formslib.php");

class webmarks_form extends moodleform {

	public function definition() {
        global $CFG, $PAGE;

		$mform =& $this->_form;

		//$mform->addElement('static','description','Block is ',$this->_customdata['blockid']);

	  	//edit section
	  	$mform->addElement('html','<div id="editLayer">'."\n");

		    $mform->addElement('header', 'configheader', get_string('newwebmarktitle', 'block_webmarks'));

			  	//hidden filed
			  	$mform->addElement('hidden', 'courseid', $this->_customdata['courseid']);	    // must have a courseid so we can return to this page
				$mform->addElement('hidden', 'blockid', $this->_customdata['blockid']);	   		// must have a blockid
				$mform->addElement('hidden', 'webmarkid', $this->_customdata['id'], array('id'=>'id_webmarkid'));	// 0 = new				//this is the weblink id
				$mform->addElement('hidden', 'action', 'saving', array('id'=>'id_action'));	   		// action='saving'	//default action is save - have to check for cancel in php code to avoid reliance on JS

			    //webmark title
			    $mform->addElement('text', 'wmtitle', get_string('wmtitleprompt', 'block_webmarks'));
			    $mform->setDefault('wmtitle', $this->_customdata['wbm_title']);
			    $mform->setType('wmtitle', PARAM_TEXT);

			    //webmark description
				$mform->addElement('textarea', 'wmdesc', get_string('wmdescprompt', 'block_webmarks'),'wrap="virtual" rows="5" cols="100"');
			    $mform->setDefault('wmdesc', $this->_customdata['wbm_desc']);
			    $mform->setType('wmdesc', PARAM_TEXT);

				//webmark link
			    $mform->addElement('text', 'wmlink', get_string('wmlinkprompt', 'block_webmarks'));
			    $mform->setDefault('wmlink', $this->_customdata['wbm_link']);
			    $mform->setType('wmlink', PARAM_URL);

				//normally you use add_action_buttons instead of this code
				$buttonarray=array();
				$buttonarray[] = $mform->createElement('submit', 'save', get_string('savechanges'));
				$buttonarray[] = $mform->createElement('cancel');
				$mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);

			    //$this->add_action_buttons(true,'Save Bookmark');

	  	$mform->addElement('html','</div>'."\n");

	    //edit section
	    $mform->addElement('header', 'configheader', get_string('editwebmarktitle', 'block_webmarks'));

		$existing = $this->_customdata['existingrecs'];
		$rows = '';
		//required for the YUI libraries
		$mform->addElement('html','<div id="listLayer" style="display:block; padding: 10px">'."\n");

		$courseid = $this->_customdata['courseid'];
		$blockid = $this->_customdata['blockid'];

		//add new link
		$mform->addElement('html',html_writer::tag('a','[Add A New Bookmark]', array('id'=>'wm0','href' => $PAGE->url."?courseid=$courseid&blockid=$blockid&action=editing&webmarkid=0")));
		if (count($existing)) {
			foreach ($existing as $exists) {
				// make up the edit line
				$row = html_writer::tag('td',$exists->wbm_title);
				$row .= html_writer::tag('td',$exists->wbm_desc);
				$row .= html_writer::tag('td',$exists->wbm_link);
				$row .= html_writer::tag('td', html_writer::tag('a','[Edit Bookmark]', array('id'=>'wm'.$exists->id,'href' => $PAGE->url."?courseid=$courseid&blockid=$blockid&action=editing&webmarkid=".$exists->id)));
				$row .= html_writer::tag('td', html_writer::tag('a','[Delete Bookmark]', array('id'=>'wm'.$exists->id,'href' => $PAGE->url."?courseid=$courseid&blockid=$blockid&action=deleting&webmarkid=".$exists->id)));

				$row = html_writer::tag('tr',$row);
				$rows .= $row ."\n";
			}

			$mform->addElement('html',html_writer::tag('table',$rows,array('width'=>'100%')));			//enclose in table
		}
	   	$mform->addElement('html','</div>'."\n");
	}
}
