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
 * Webmarks (Website Bookmarks) block main plugin file 
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


/* 

	See http://docs.moodle.org/dev/Blocks/ for more information
	
	To define a "block" in Moodle, in the most basic case we need to provide just three PHP files:

H	# /blocks/webmarks/block_webmarks.php # THIS file will hold the class definition for the block, and is used both to manage it as a plugin and to render it onscreen. 
	# /blocks/webmarks/version.php  # This file will hold version information for the plugin, - see version.php. 
	# /blocks/webmarks/lang/en/block_webmarks.php # This is the English language file for your block and you can replace 'en' with your appropriate language code

#########################################################
#			VARIABLES									#
#########################################################    
    
Class variables:

    $this->config		# This stdClass object holds all the specialized instance configuration data that have been provided for this specific block instance
    $this->content		# This variable can be NULL or stdClass object dependant on $this->content_type
    					# with the actual content that is displayed inside each block.
    $this->content_type	# This variable is the type of block content - One of BLOCK_TYPE_TEXT, BLOCK_TYPE_LIST or only in Moodle 2.0 BLOCK_TYPE_TREE
    $this->context		# As of Moodle 2.0, every block now has its own context, and you can always access it via $this->context. ($this->page->context)
    $this->instance		# <Moodle 2.0 - This member stdClass object holds all the specific information that differentiates one block instance from another
    $this->page			# +Moodle 2.0 - The same as $this->instance - you do not have to use the global $PAGE object in blocks!
    $this->title		# This variable is a string that contains the human-readable name of the block. It is used to refer to blocks of that type throughout Moodle
    $this->version		# <Moodle 2.0 - In +Moodle 2.0 use a version.php file as described on the main blocks documentation page. 

Named constants:  (Block Types) 

    BLOCK_TYPE_LIST
    BLOCK_TYPE_TEXT
    BLOCK_TYPE_TREE (only +Moodle 2.0)
   
#########################################################
#			OTHER METHODS								#
#########################################################

#### Methods which you should not override but may want to use: #####

    get_content_type()			# Available in Moodle 1.5 and later. This method returns the value of $this->content_type
    get_title()					# Available in Moodle 1.5 and later. This method returns the value of $this->title
    get_version()				# Available in Moodle 1.5 and later. This method returns the value of $this->version
    instance_config_commit()	# Available in Moodle 1.5 and later. This method saves the current contents of $this->config
    is_empty()					# This method returns the a boolean true/false value, depending on whether the block has any content at all to display. 
    							# Blocks without content are not displayed by the framework. 
    name()						# Available in Moodle 1.5 and later. This method returns the internal name of your block inside Moodle, without the block_ prefix.

#### Methods which you should not override and not use at all: ####

    _add_edit_controls()
    _load_instance()
    _print_block()
    _print_shadow()
    _self_test()
*/

class block_webmarks extends block_list {						//# check documentation for additional Methods
// class block_webmarks extends block_tree {   //+Moodle 2.0 only	//# check documentation for additional Methods
// class block_webmarks extends block_base {
	
	/*
		init()
	
		Available in Moodle 1.5 and later
		This method must be implemented for all blocks. 
		It has to assign meaningful values to the object variables 
			$this->title
			$this->version (which is used by >Moodle 2.0 for performing automatic updates when available  Moodle 2+ use version.php).
			$this->content_type (is expected to have a valid constant value BLOCK_TYPE_TEXT, BLOCK_TYPE_LIST or only in Moodle 2.0 BLOCK_TYPE_TREE)

		No return value is expected from this method. 
	*/
    public function init() {
        $this->title = get_string('webmarkstitle','block_webmarks');
        //$this->version = 1234567890;			//pre Moodle 2.0
        //set the block type all the time
        //$this->content_type is expected to have a valid constant value BLOCK_TYPE_TEXT, BLOCK_TYPE_LIST or only in Moodle 2.0 BLOCK_TYPE_TREE
        //$this->content_type = BLOCK_TYPE_LIST;  //not required as we are extending block_list
    }
    
    /*
    	after_install()
    	
    	Available between Moodle 1.7 and Moodle 1.9 
    	Please note that after_install() is called once per block, not once per instance.
		The after_install() method is no longer present in Moodle 2.0 which uses an /blocks/webmarks/db/install.php file
	*/
    //public function after_install() {}
    
    
    /*
    	applicable_formats()
    	
    	Available in Moodle 1.5 and later
		This method allows you to control which pages your block can be added to. The order that the format names appear does not make any difference.
		Example format names are: 
			course-view, 
			site-index (this is an exception, referring front page of the Moodle site), 
			course-format-weeks (referring to a specific course format), 
			mod-quiz (referring to the quiz module) and 
			all (this will be used for those formats you have not explicitly allowed or disallowed). 	
    */
    public function applicable_formats() {
		  // Default case: the block can be used in courses and site index, but not in activities
		  return array(
		    'all' => true, 
		    'mod' => false,
		  );    
	}
    
	/*
		before_delete()
		
		Available in Moodle 1.7 and later
		This method is called when a block is removed from the installation, immediately before the relevant database tables are deleted. 
		It allows block authors to perform any necessary cleanup - removing temporary files and so on - before the block is deleted.
	*/
	//public function before_delete() {}
    
    
	
	/*
		config_print()
		
		Available in Moodle 1.5 and later
		This method allows you to choose how to display the global configuration screen for your block. 
		This is the screen that the administrator is presented with when he chooses "Settings..."
		
		Default behavior: print the config_global.html file
		You don't need to override this if you're satisfied with the above	
	
	*/
	//public function config_print() {}
    

    
	
	/*
		config_save()
		
		Available in Moodle 1.5 and later
		This method allows you to override the storage mechanism for your global configuration data. 
		The received argument is an associative array, with the keys being setting names and the values being setting values. 
		You should return a boolean value denoting the success or failure of your method's actions. 
		
		The default implementation saves everything as Moodle $CFG variables.
	
	*/
	//public function config_save() {}
    
	
	
	
    /*
    	get_content()
    	
    	Available in Moodle 1.5 and later
		This method should, when called, populate the $this->content variable of your block.
		This variable holds all the actual content that is displayed inside each block. Valid values for it are either NULL or an object of class stdClass.
		Normally, it begins life with a value of NULL and it becomes an object when get_content() is called and
		is expected to have certain properties, depending on the value of $this->content_type:
			BLOCK_TYPE_TEXT
				text 		# This is a string of arbitrary length and content and can contain HTML.
    			footer 		# This is a string of arbitrary length and contents can also contain HTML.
    		BLOCK_TYPE_LIST
    		    items 		#This is a numerically indexed ARRAY of strings which holds the title for each item in the list and is normally a fully qualified HTML <a> tag.
    			icons 		#This is a numerically indexed ARRAY of strings which represent the images displayed before each item of the list and should be a fully qualified HTML <img> tag.
    			footer 		#This is a string of arbitrary length and contents and can also contain HTML.
    		BLOCK_TYPE_TREE (As of Moodle 2.0)
				items 		#This is an array of tree_item objects, representing the top level of the tree to be displayed. 
							#Each tree_item::children property may contain more tree_item objects for the next level down and so on

		default "empty" values (empty arrays for the arrays and empty strings for the strings) result in the block not being displayed except to editing users
		Before starting to populate $this->content, you should also include a simple caching check - see below
    */
	public function get_content() {
		//caching check
		global $CFG, $DB, $USER, $COURSE;
		
        //global $USER, $CFG, $DB, $OUTPUT;
		
		
	    if ($this->content !== null) {
	      return $this->content;
	    }
	     
        $this->content = new stdClass;
        $this->content->footer = '';
        $this->content->items = array();
        $this->content->icons = array();
	    
		//else we populate our content
		//this stuff should go into 
// 		$itemdesc = '<a href="http://www.mukudu.net/" target="_blank">A Link</a>';
// 		$itempic = '<img src="'. $CFG->wwwroot. '/blocks/webmarks/webmark_icon.png" />';
// 		$this->content->footer = 'This is block id is'.  $this->instance->id;  //this is supposed to be in the process of being deprecated but no suitable other means is possible
// 		for ($i=0; $i<11; $i++) {
// 			array_push($this->content->items,$itemdesc);
// 			array_push($this->content->icons,$itempic);
// 		}
		
		//$this->content->footer = '<br/>This is block id is '.  $this->instance->id;  //this is supposed to be in the process of being deprecated but no suitable other means is possible		
 		//$docroot =  $CFG->wwwroot;
 		$itempic = html_writer::empty_tag('img',array('src'=>$CFG->wwwroot.'/blocks/webmarks/webmark_icon.png'));
		
		//get stuff from database;
		$blkid = $this->instance->id;
		$result = $DB->get_records('block_webmarks',array('blockid'=>$blkid),'id DESC','*',0,$this->config->wmmaxlinks);
		
		foreach ($result as $res) {
			$line = html_writer::tag('a', $res->wbm_title, array('href' => $res->wbm_link));
			if ($this->config->wmdispldesc) {
				$line .= "\n". html_writer::tag('p',$res->wbm_desc);
			}
			$this->content->items[] = $line;
			$this->content->icons[] = $itempic;
		}
		
        //$context = get_context_instance(CONTEXT_COURSE, $COURSE->id);			//get the context		
        //$isediting = has_capability('block/webmarks:managepages', $context) && isediting($this->instance->pageid);
		
		
		//footer if editing link to form
        if ($this->page->user_is_editing()) {
			$this->content->footer .= html_writer::tag('p',(html_writer::tag('a', 'Edit Web Bookmarks', array('href' => $CFG->wwwroot.'/blocks/webmarks/webmarks.php?courseid='.$COURSE->id.'&blockid='.$blkid))));
		}
		
		//$this->content->footer .= html_writer::empty_tag('br');
		
		return $this->content;
	}

	
    /*
		has_config()
		
		Available in Moodle 1.5 and later
		This method should return a boolean value that denotes whether your block wants to present a configuration interface to site admins or not. 
		To actually implement the configuration interface, you will either need to rely on the default config_print() method or override it. 
    
	*/
	//public function has_config() {}
    
	
	
	
    /*
		hide_header()
		
		Available in Moodle 1.5 and later
		This method should return a boolean value that denotes whether your block wants to hide its header (or title). 
		
		Default is false
    
	*/
	//public function hide_header() {}
    
	
	
	
    /*
		html_attributes()
		
		Available in Moodle 1.5 and later
		This method should return an associative array of HTML attributes that will be given to your block's container element 
		No sanitization will be performed in these elements at all.  If you intend to override this method, you should return the default attributes

		Default case: an id with the instance and a class with our name in it
		
	*/
	/*public function html_attributes() {
		  $attrs = parent::html_attributes();			//get default attributes
		  // Add your own attributes here, e.g.
		  // $attrs['width'] = '50%';
		  // $attrs['class'] .= ' block_'. $this->name(); // Append our class to class attribute
		  return $attrs;    
	}*/
	
	
	
	
	/*
		instance_allow_config()
		
		Available in Moodle 1.5 through 1.9.
		This method should return a boolean value. 
		True indicates that your block wants to have per-instance configuration, while false means it does not.
		
		Default is true.
		
	*/
	//public function instance_allow_config() {}
    
	
	
	
    /*
		instance_allow_multiple()
		
		Available in Moodle 1.5 and later
		This method should return a boolean value, indicating whether you want to allow multiple instances of this block in the same page or not.
		
		Default is false???
	*/
	public function instance_allow_multiple() {
		return true;
	}
    
	
	
    /*
    	instance_config_print()
    	
    	Available in Moodle 1.5 and later
		This method allows you to choose how to display the instance configuration screen for your block. 
		Override it if you need something much more complex than the default implementation allows you to do. 
		Keep in mind that whatever you do output from config_print(), it will be enclosed in a HTML form automatically. 
		You only need to provide a way to submit that form.

		You should return a boolean value denoting the success or failure of your method's actions. 
	*/
	//public function instance_config_print() {}
    
	
	
	
    /*
		instance_config_save()
		
		Available in Moodle 1.5 and later
		This method allows you to override the storage mechanism for your instance configuration data. 
		The received argument is an associative array, with the keys being setting names and the values being setting values. 
	*/
	/*
	public function instance_config_save() {
		// do your stuff
		
		// And now forward to the default implementation defined in the parent class
		//return parent::instance_config_save($data);
	}
    */
	
	
	
    /*
		preferred_width()
		
		Available in Moodle 1.5 to Moodle 1.9
		This method should return an integer value, which is the number of pixels of width your block wants to take up when displayed. 
		Moodle will TRY to honor your request	
		
		Default case: 180 pixels wide	
	*/
	//public function preferred_width() {}
    
	
	
    /*
		refresh_content()
		
		Available in Moodle 1.5 and later
		This method should cause your block to recalculate its content immediately. 
		Follow the guidelines for get_content()
	*/
	/*
	public function refresh_content() {
		// Nothing special here, depends on content()
		$this->content = NULL;
		return $this->get_content();		
	}
	*/
	
	
	
    /*
		function specialization()
		
		Available in Moodle 1.5 and later
		This method is automatically called immediately after your instance data is loaded from the database.
		Used to manipulate the data before use and the data is available in $this->instance and $this->config 
	*/
	public function specialization() {
		// Just to make sure that this method exists.
		if (!empty($this->config->wmblocktitle)) {    		//get the configured configuration title
			$this->title = $this->config->wmblocktitle;
		} else {    
			$this->config->title = get_string('webmarkstitle','block_webmarks');			//default from language strings
		}
	}
}
