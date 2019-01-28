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
 * Game block language strings
 *
 * @package    contrib
 * @subpackage block_game
 * @copyright  2019 Jose Wilson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once('../../config.php');
require_once($CFG->dirroot . '/blocks/game/libgame.php');
require_once($CFG->libdir . '/completionlib.php');

global $USER, $SESSION, $COURSE, $OUTPUT, $CFG;

$op = optional_param('op', '', PARAM_ALPHA); 
$game = new stdClass();

switch ($op) {
    case "load":
        $game->courseid = $SESSION->game->courseid;
        $game->userid   = $USER->id;
         
        echo json_encode(load_game($game));
        break;
    case "update":
        
        $id             = optional_param('id', '0', PARAM_INT); 
        $userid         = optional_param('userid', '0', PARAM_INT); 
        $courseid       = optional_param('courseid', '0', PARAM_INT);
        $avatar         = optional_param('avatar', '0', PARAM_INT); 
        $score          = optional_param('score', '0', PARAM_INT); 
        $nivel          = optional_param('nivel', '0', PARAM_INT); 
        $rank           = optional_param('rank', '0', PARAM_INT);         
        $conquistas     = optional_param('conquistas', '', PARAM_SEQUENCE); 
        $fases          = optional_param('fases', '', PARAM_SEQUENCE);
        $recompensas    = optional_param('recompensas', '', PARAM_SEQUENCE); 
        
        $game->id           = $id;
        $game->userid       = $userid;
        $game->courseid     = $courseid;
        $game->avatar       = $avatar;
        $game->score        = $score;
        $game->nivel        = $nivel;
        $game->rank         = $rank;
        $game->conquistas   = $conquistas; 
        $game->fases        = $fases; 
        $game->recompensas  = $recompensas;        
        
        echo update_game($game);
        break;
    case "avatar":
        
        $id             = optional_param('id', '0', PARAM_INT); 
        $avatar         = optional_param('avatar', '0', PARAM_INT); 
        
        $game->id       = $id;
        $game->avatar   = $avatar;
        
        echo update_avatar_game($game);
        break;
    case "score":
        
        $id            = optional_param('id', '0', PARAM_INT); 
        $score         = optional_param('score', '0', PARAM_INT); 
        
        $game->id      = $id;
        $game->score   = $score;
        
        echo update_score_game($game);
        break;
    case "nivel":
        
        $id           = optional_param('id', '0', PARAM_INT); 
        $nivel        = optional_param('nivel', '0', PARAM_INT); 
//        echo ' id: '.$id;
//        echo ' nivel: '.$nivel;
        
        $game->id     = $id;
        $game->nivel  = $nivel;
        
        echo update_nivel_game($game);
        break;
     case "recompensas":
        
        $id             = optional_param('id', '0', PARAM_INT); 
        $recompensas    = optional_param('recompensas', '', PARAM_SEQUENCE); 
        
        $game->id           = $id;
        $game->recompensas  = $recompensas;
        
        echo update_recompensas_game($game);
        break;
        
    case "fases":
        
        $id       = optional_param('id', '0', PARAM_INT); 
        $fases    = optional_param('fases', '', PARAM_SEQUENCE); 
        
        $game->id     = $id;
        $game->fases  = $fases;

        echo update_fases_game($game);
        break;
   
    default:
        break;
}



