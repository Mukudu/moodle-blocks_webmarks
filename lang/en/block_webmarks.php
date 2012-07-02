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
 * Defines the english language file for the Webmarks (Website Bookmarks) Block
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

$string['pluginname'] = 'Web Bookmarks';
$string['webmarkstitle'] = 'Web Bookmarks';
$string['wmeditingtitle'] = 'Editing ' . $string['webmarkstitle'];

//params for the block edit_form
$string['wmconfigtitle'] = 'Configure This Webmark Block';
$string['wmconfblocktitle'] = 'Title for This Block';
$string['wmconfdispdescprompt'] = 'Display Description?';
$string['wmconfmaxlinksprompt'] = 'Maximum Number of Links';
$string['wmconfmaxlinkserror'] = 'The absolute number of links is 20, please re-try';

//params for the edit webmarks form
$string['invalidcourse'] = 'This course does not exist';

$string['editwebmarkdetails'] = 'Edit Webmark Details';
$string['wmtitleprompt'] = 'Webmark Title';
$string['wmdescprompt'] = 'Webmark Description';
$string['wmlinkprompt'] = 'Webmark Link (FQN e.g.http://)';

$string['editwebmarktitle'] = 'Edit Existing Webmarks';
$string['savechanges'] = 'Save Webmark';

/*
	closing tag for PHP. This is intentional, and a workaround for whitespace issues. 
*/

