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


//Load game user of de block
function load_game($game) {
    global $DB;
    if (!empty($game->userid) && !empty($game->courseid)) {
        $busca = $DB->get_record_sql('SELECT count(*) as total  FROM {block_game} WHERE courseid=? AND userid=?', array($game->courseid,$game->userid));
        //if the data 
        if($busca->total>0){
            $gamedb = $DB->get_record('block_game',array('courseid' => $game->courseid , 'userid' => $game->userid));
            $gamedb = ranking($gamedb);
            return $gamedb;

        }else{
                //if there is no data
                $new_game = new stdClass();
                $new_game->courseid         = $game->courseid;
                $new_game->userid           = $game->userid;
                $new_game->avatar           = 0;
                $new_game->score            = 0;
                $new_game->score_activities = 0;
                $new_game->level            = 0;
                $new_game->rank             = 0;
                $new_game->achievements     = "";
                $new_game->rewards          = "";
                $new_game->phases           = "";
                $new_game->frame            = "";
                $new_game->bonus_day        = "";
                $lastinsertid = $DB->insert_record('block_game', $new_game);
                $new_game->id           = $lastinsertid;
                
                return $new_game;
        }
    }
    return false;
}

//update game user
function update_game($game) {
    global $DB;

    if (!empty($game->id) && !empty($game->userid) && !empty($game->courseid)) {
        if (empty($game->avatar)) {
            $game->avatar = 0;
        }
        if (empty($game->score)) {
            $game->score = 0;
        }
        if (empty($game->level)) {
            $game->level = 0;
        }
        if (empty($game->rank)) {
            $game->rank = 0;
        }
        $save_game = new stdClass();
        $save_game->id          = $game->id;
        $save_game->courseid    = $game->courseid;
        $save_game->userid      = $game->userid;
        $save_game->avatar      = $game->avatar;
        $save_game->score       = $game->score;
        $save_game->level       = $game->level;
        $save_game->rank        = $game->rank;
        $save_game->achievements= $game->achievements;
        $save_game->rewards     = $game->rewards;
        $save_game->phases      = $game->phases;
        $save_game->frame       = $game->frame;
         
        $DB->update_record('block_game', $save_game);
        
        return true;
    }
    return false;
}
//update avatar user
function update_avatar_game($game) {
    global $DB;
     
    if (!empty($game->id) && !empty($game->avatar)) {
        
        $save_game = new stdClass();
        $save_game->id          = $game->id;
        $save_game->avatar      = $game->avatar;

        $DB->update_record('block_game', $save_game);
        
        return true;
    }
    return false;
}

//Update score game
function update_score_game($game) {
    global $DB;
     
    if (!empty($game->id) && !empty($game->score)) {
        
        $save_game = new stdClass();
        $save_game->id          = $game->id;
        $save_game->score      = $game->score;

        $DB->update_record('block_game', $save_game);
        
        return true;
    }
    return false;
}

//Update level game
function update_level_game($game) {
    global $DB;
     
    if (!empty($game->id) && !empty($game->level)) {
        
        $save_game = new stdClass();
        $save_game->id         = $game->id;
        $save_game->level      = $game->level;

        $DB->update_record('block_game', $save_game);
        
        return true;
    }
    return false;
}
//Update achievements game
function update_achievements_game($game) {
    global $DB;
     
    if (!empty($game->id)) {
        
        $save_game = new stdClass();
        $save_game->id    = $game->id;
        $save_game->achievements = $game->achievements;

        $DB->update_record('block_game', $save_game);
        
        return true;
    }
    return false;
}

//Update rewards game
function update_rewards_game($game) {
    global $DB;
     
    if (!empty($game->id)) {
        
        $save_game = new stdClass();
        $save_game->id          = $game->id;
        $save_game->rewards = $game->rewards;

        $DB->update_record('block_game', $save_game);
        
        return true;
    }
    return false;
}
//Update phases game
function update_phases_game($game) {
    global $DB;
     
    if (!empty($game->id)) {
        
        $save_game = new stdClass();
        $save_game->id    = $game->id;
        $save_game->phases = $game->phases;

        $DB->update_record('block_game', $save_game);
        
        return true;
    }
    return false;
}
//Update frame game
function update_frame_game($game) {
    global $DB;
     
    if (!empty($game->id)) {
        
        $save_game = new stdClass();
        $save_game->id    = $game->id;
        $save_game->frame = $game->frame;

        $DB->update_record('block_game', $save_game);
        
        return true;
    }
    return false;
}

//Update bonus of the day game
function bonus_of_day($game) {
    global $DB;     
    if (!empty($game->id)) {
        $busca = $DB->get_record_sql('SELECT CURDATE() as hoje, bonus_day  FROM {block_game} WHERE courseid=? AND userid=?', array($game->courseid,$game->userid));
        if($busca->bonus_day<$busca->hoje){
            $game->score = $game->score+10;
            $game->bonus_day=$busca->hoje;
            $DB->update_record('block_game', $game);
        }
        return true;
    }
    return false;
}

//score activity notes
function score_activities($game) {
    global $DB;
    if (!empty($game->id)) {
        $busca = $DB->get_record_sql("SELECT FORMAT(SUM(g.finalgrade),0) as score_activities FROM {grade_grades} g INNER JOIN {grade_items} i ON g.itemid=i.id WHERE i.courseid=? AND i.itemtype='mod' AND g.userid=?", array($game->courseid,$game->userid));
        if ($busca->score_activities=="" || empty($busca->score_activities)){
             $game->score_activities    = 0;
         }else{
             $game->score_activities    = $busca->score_activities;
         }        
         $DB->execute("UPDATE {block_game} SET score_activities=? WHERE id=?", array($game->score_activities,$game->id));
         
        return true;
    }
    return false;
}
//no score activity notes
function no_score_activities($game) {
    global $DB;
    if (!empty($game->id)) {
        $DB->execute("UPDATE {block_game} SET score_activities=0 WHERE id=?", array($game->id));
        return true;
    }
    return false;
}

//ranking user
function ranking($game) {
    global $DB;
     
    if (!empty($game->id)) {
        if($game->courseid==1){
                $ranking = $DB->get_records_sql('SELECT userid, (SUM(score)+SUM(IFNULL(score_activities, 0))) as pt FROM {block_game} GROUP BY userid ORDER BY pt DESC');
                $poisicao=1;
                foreach($ranking as $rs){
                    if($rs->userid==$game->userid){
                        $game->rank= $poisicao;
                        break;
                    }
                    $poisicao++;
                } 
            }else{
                $ranking = $DB->get_records_sql('SELECT userid, (SUM(score)+SUM(IFNULL(score_activities, 0))) as pt FROM {block_game} WHERE courseid=? GROUP BY userid ORDER BY pt DESC', array($game->courseid));
                $poisicao=1;
                foreach($ranking as $rs){
                    if($rs->userid==$game->userid){
                        $game->rank= $poisicao;
                        break;
                    }
                    $poisicao++;
                } 
            }
        $DB->update_record('block_game', $game);
    }
    return $game;
}


?>