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
 * Initially developped for :
 * Université de Cergy-Pontoise
 * 33, boulevard du Port
 * 95011 Cergy-Pontoise cedex
 * FRANCE
 *
 * Adds to the course a section where the teacher can submit a problem to groups of students
 * and give them various collaboration tools to work together on a solution.
 *
 * @package   local_ucploginbox
 * @copyright 2017 Brice Errandonea <brice.errandonea@u-cergy.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * File : lib.php
 * Library functions
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Adds the plugin to the Course administration menu.
 * @param settings_navigation $nav
 * @param context $context
 */
function local_ucploginbox_extend_settings_navigation(settings_navigation $nav, context $context) {
    global $CFG, $PAGE;
    
	if ($PAGE->url->get_path() == '/') {
		$customcontent = '<div style="text-align:center">';
        $customcontent .= '<h3>'.get_string('accesswith', 'local_ucploginbox').'</h3>';
        $customcontent .= '<table style="margin:auto"><tr>';
        $customcontent .= local_ucploginbox_button("$CFG->wwwroot/login/index.php?authCAS=CAS", 'ucpaccount');
        $customcontent .= local_ucploginbox_button("$CFG->wwwroot/login/index.php?authCAS=NOCAS", 'seformeraccount');
        $customcontent .= '</tr><tr>';
        $sesskey = sesskey();
        $customcontent .= local_ucploginbox_button("$CFG->wwwroot/auth/oauth2/login.php?id=2&wantsurl=%2F&sesskey=$sesskey", 'googleaccount');
        $customcontent .= local_ucploginbox_button("$CFG->wwwroot/auth/oauth2/login.php?id=3&wantsurl=%2F&sesskey=$sesskey", 'facebookaccount');
        $customcontent .= '</tr></table>';
        $customcontent .= "<p><a href='$CFG->wwwroot/login/forgot_password.php'>".get_string('forgotten', 'local_ucploginbox')."</a></p>";
        $customcontent .= "<a class='btn btn-secondary' href='$CFG->wwwroot/login/signup.php'>".get_string('addnew', 'local_ucploginbox')."</a>";
        $customcontent .= '</div>';
	    echo "<div id='ucploginboxstore'><div style='display:none' id='loginboxcustomcontent'>$customcontent</div></div>";
    }
}

function local_ucploginbox_button($url, $identifier) {
	$button = "<a class='btn btn-primary' style='width:100%' href='$url'>".get_string($identifier, 'local_ucploginbox')."</a>";
	return "<td width='45%'>$button</td>";
}

?>

<style>
#loginbox #boxform {
   display:none;
}
</style>

<script>
window.onload = ucploginbuttons;
function ucploginbuttons() {		
    area = document.getElementsByClassName('fpsignup');
    place = area[0];
    if (place) {		
        store = document.getElementById('loginboxcustomcontent');  
        place.innerHTML = store.innerHTML;
        place.style.display='block';
		
		/*Juliette*/
		//~ head = document.getElementsByTagName("header")[0]; //BRICE
		head = document.getElementsByClassName("usermenu")[0];
		if (head) {
			head.style.display = 'none';
		}		
    }
}
</script>


