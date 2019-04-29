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
 * Game block config form definition
 *
 * @package    contrib
 * @subpackage block_game
 * @copyright  2019 Jose Wilson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/blocks/game/libgame.php');

require_login();

global $USER, $SESSION, $COURSE, $OUTPUT, $CFG;


$courseid = required_param('id', PARAM_INT);


$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

$game = new stdClass();
$game = $SESSION->game;

require_login($course);
$PAGE->set_pagelayout('course');
$PAGE->set_url('/blocks/game/rank_game.php', array('id' => $courseid));
$PAGE->set_context(context_course::instance($courseid));
$PAGE->set_title(get_string('rank_game_title', 'block_game'));
$PAGE->set_heading(get_string('rank_game_title', 'block_game'));

echo $OUTPUT->header();
if($game->config->show_rank==1){
    $outputhtml = '<div class="rank">';
    if($courseid!=1){
        $outputhtml .= '<h3>( '.$course->fullname.' )</h3><br/>';
    }else{
        $outputhtml .= '<h3>( '.get_string('general', 'block_game').' )</h3><br/>';
    }
    $outputhtml .= '<table border="0" width="100%">';
    $rs_rank_list = rank_list($courseid);
    $ord =1;
    foreach ($rs_rank_list as $gamer) {
        $txt_avatar='';
        if($game->config->use_avatar==1){
            //$txt_avatar= '<img  align="center" hspace="5" src="'.$CFG->wwwroot.'/blocks/game/pix/a'.$gamer->avatar.'.png" title="avatar"/>';
            $txt_avatar= $OUTPUT->pix_icon('a'.$gamer->avatar, $alt, 'block_game');
        } 
        $txt_ord = $ord.'&ordm;';
         $txt_user   = $txt_avatar.' ******** ';
        if ($game->config->show_identity==0) {
            $txt_user   = $txt_avatar.' '.$gamer->firstname;
        }
        $txt_pt     = $gamer->pt;
        if($gamer->userid==$USER->id){
            $txt_user = $txt_avatar.' <strong>'.$gamer->firstname.'</trong>';
            $txt_pt = '<strong>'.$gamer->pt.'</trong>';
            $txt_ord = '<strong>'.$ord.'&ordm;</trong>';
        }
        $outputhtml .= '<tr>';
        $outputhtml .= '<td>';
        $outputhtml .= $txt_ord.'<hr/></td><td> '.$txt_user.' <hr/></td><td> '.$txt_pt.'<hr/></td>'; 
        $outputhtml .= '</tr>';
        $ord++;
    }
    $outputhtml .= '</table>';

    $users_not_start_game = getNoPlayers($courseid);
    if($users_not_start_game>0){
        if($users_not_start_game==1){
            $outputhtml .= '<br/>('.$users_not_start_game.' '.get_string('not_start_game', 'block_game').' )';
        }else{
            $outputhtml .= '<br/>('.$users_not_start_game.' '.get_string('not_start_game_s', 'block_game').' )';
        }
    }
    $outputhtml .= '</div>';
}
echo $outputhtml;

echo $OUTPUT->footer();