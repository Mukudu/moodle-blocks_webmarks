/*
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
*/

/**
 * Javascript file for Webmarks (Website Bookmarks) block
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
	the form is only hidden if javascript is enabled
	if it is not then editing will require a post back to the server 
	which this script should handle...
*/

M.block_webmarks = {
    init: function(Y) {
	    this.Y = Y;
	   
		//hide the form at first	
	    Y.one('#editLayer').hide();
	    
	    //this is the links to unhide our layer   
		var nodes = Y.all('#listLayer a');
   	    Y.one('#listLayer').delegate('click', function(e) {
	   	    //determine whether we are deleting or editing
	   	    
	   	    thelink = e.target.get('href');	  
	   	    //deleting we do nothing and let the request through
			if (thelink.indexOf('action=deleting') < 0) {
		    	e.preventDefault();
				//we are editing
				//determine what record we are editing
		        linkid = /[\-0-9]+/.exec(e.target.get('id'))[0];
		        if (linkid != null) {
			        //and do a ajax request if this is not new
			        if (linkid > 0) {
				        //do ajax request for details
		                uri = M.cfg.wwwroot+'/blocks/webmarks/webmarks_ajax.php';
						                
				        rawresp = Y.io(uri, {
				            data: 'webmarkid='+linkid,
				            on: {
				                success: function(id, o) {
				                    response = Y.JSON.parse(o.responseText);
				                    Y.one('#id_webmarkid').set('value',linkid);
				                    Y.one('#id_wmtitle').set('value',response.wmrecord.wbm_title);
				                    Y.one('#id_wmdesc').set('value',response.wmrecord.wbm_desc);				                    
				                    Y.one('#id_wmlink').set('value',response.wmrecord.wbm_link);				                    
				                },
				                failure: function(id, o) {
				                    if (o.statusText != 'abort') {
										alert(o.statusText);
				                    }
				                }
				            }
				        });
			        }else{
				        //reset values ottherwise we will have old values in there
				        Y.one('#id_webmarkid').set('value','0');
	                    Y.one('#id_wmtitle').set('value','');
	                    Y.one('#id_wmdesc').set('value','');				                    
	                    Y.one('#id_wmlink').set('value','');				                    
			        }
				        
			    	Y.one('#editLayer').show();
			    	Y.one('#id_wmtitle').focus();
		    	}else{
		    		alert("Linkid has not been stipulated");
	    		}

			}// else we are deleting and so just let it through
	   	    
    	}, 'a');
    	
    	//TODO need something to capture cancel requests rather than the round trip to the server when js is enabled
    	
    	
	},
		
}    
