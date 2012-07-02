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
 * Edit Block Instance Form for the Webmarks (Website Bookmarks) block
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

class block_webmarks_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {
       
        //new section
        $mform->addElement('header', 'configheader', get_string('wmconfigtitle', 'block_webmarks'));	

        //block title
        $mform->addElement('text', 'config_wmblocktitle',get_string('wmconfblocktitle', 'block_webmarks'));
        $mform->setDefault('config_wmblocktitle',get_string('webmarkstitle','block_webmarks'));
        $mform->setType('config_wmblocktitle', PARAM_TEXT);
        
        //Link Limit
        $mform->addElement('text', 'config_wmmaxlinks', get_string('wmconfmaxlinksprompt', 'block_webmarks'));
        $mform->setDefault('config_wmmaxlinks', 5);		//yes
        $mform->setType('config_wmmaxlinks', PARAM_INT);
        //stop any sillyness
		//$mform->addRule('config_wmmaxlinks', get_string('wmconfmaxlinkserror', 'block_webmarks'), 'nonzero ', '', 'client', false, false);
        
        //Show Link Description Choice
		$mform->addElement('selectyesno', 'config_wmdispldesc', get_string('wmconfdispdescprompt', 'block_webmarks'));
        $mform->setDefault('config_wmdispldesc', 0);			//no

    }
}

