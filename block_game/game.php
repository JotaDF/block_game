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

// This page prints a particular instance of aicc/scorm package.

require_once('../../config.php');
require_once($CFG->dirroot.'/mod/scorm/locallib.php');
require_once($CFG->dirroot.'/mod/scorm/libgame.php');
require_once($CFG->libdir . '/completionlib.php');


$op = optional_param('op', '', PARAM_ALPHA); 
$game = new stdClass();

switch ($op) {
    case "load":
        $game->courseid = $SESSION->scorm->courseid;
        $game->scormid  = $SESSION->scorm->id;
        $game->userid   = $USER->id;
         
        echo json_encode(load_game($game));
        break;
    case "update":
        
        $id         = optional_param('id', '0', PARAM_INT); 
        $userid     = optional_param('userid', '0', PARAM_INT); 
        $courseid   = optional_param('courseid', '0', PARAM_INT); 
        $scormid    = optional_param('scormid', '0', PARAM_INT);
        $avatar     = optional_param('avatar', '0', PARAM_INT); 
        $score      = optional_param('score', '0', PARAM_INT); 
        $nivel      = optional_param('nivel', '0', PARAM_INT); 
        
        $game->id       = $id;
        $game->userid   = $userid;
        $game->courseid = $courseid;
        $game->scormid  = $scormid;
        $game->avatar   = $avatar;
        $game->score    = $score;
        $game->nivel    = $nivel;
        
        echo update_game($game);
        break;

    default:
        break;
}



