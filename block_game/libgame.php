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
            return $gamedb;

        }else{
                //if there is no data
                $new_game = new stdClass();
                $new_game->courseid         = $game->courseid;
                $new_game->userid           = $game->userid;
                $new_game->avatar           = 0;
                $new_game->score            = 0;
                $new_game->score_activities = 0;
                $new_game->score_badges     = 0;
                $new_game->level            = 0;
                $new_game->rank             = 0;
                $new_game->achievements     = "";
                $new_game->rewards          = "";
                $new_game->phases           = "";
                $new_game->badges           = "";
                $new_game->frame            = "";
                $new_game->bonus_day        = null;
                $lastinsertid = $DB->insert_record('block_game', $new_game);

                $new_game->id           = $lastinsertid;
                
                return $new_game;
        }
    }
    return false;
}

//get games user
function get_games_user($userid) {
    global $DB;
    if (!empty($userid)) {
        $games = $DB->get_records_sql('SELECT * FROM {block_game} WHERE userid=? ORDER BY courseid DESC',array($userid));                 
        return $games;
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
        $save_game->badges      = $game->badges;
        $save_game->frame       = $game->frame;
         
        $DB->update_record('block_game', $save_game);
        
        return true;
    }
    return false;
}
//update avatar user
function update_avatar_game($game) {
    global $DB;
     
    if (!empty($game->userid) && !empty($game->avatar)) {
        
        $DB->execute("UPDATE {block_game} SET avatar=? WHERE userid=?", array($game->avatar,$game->userid));

        //$DB->update_record('block_game', $save_game);
        
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
//Update badges game
function update_badges_game($game) {
    global $DB;
     
    if (!empty($game->id)) {
        
        $save_game = new stdClass();
        $save_game->id    = $game->id;
        $save_game->badges= $game->badges;

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
function bonus_of_day($game,$bonus) {
    global $DB;     
    if (!empty($game->id)) {
        $busca = $DB->get_record_sql('SELECT CURDATE() as hoje, bonus_day  FROM {block_game} WHERE courseid=? AND userid=?', array($game->courseid,$game->userid));
        if($busca->bonus_day<$busca->hoje){
            $game->score = ((int)$game->score + (int)$bonus);
            $game->bonus_day=$busca->hoje;
            $DB->update_record('block_game', $game);
        }
        return ((int)$game->score + (int)$bonus);
    }
    return false;
}

//score activity notes
function score_activities($game) {
    global $DB, $CFG;
    if (!empty($game->id)) {
        if( $CFG->dbtype=="mysql"){
            $busca = $DB->get_record_sql("SELECT FORMAT(SUM(g.finalgrade),0) as score_activities FROM {grade_grades} g INNER JOIN {grade_items} i ON g.itemid=i.id WHERE i.courseid=? AND i.itemtype='mod' AND g.userid=?", array($game->courseid,$game->userid));
        }else if( $CFG->dbtype=="pgsql"){
            $busca = $DB->get_record_sql("SELECT to_number(SUM(g.finalgrade),0) as score_activities FROM {grade_grades} g INNER JOIN {grade_items} i ON g.itemid=i.id WHERE i.courseid=? AND i.itemtype='mod' AND g.userid=?", array($game->courseid,$game->userid));
        }
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

//score badges of course completed
function score_badge($game,$value) {
    global $DB;
    $badges = array();
    if (!empty($game->userid)) {
        if( $CFG->dbtype=="mysql"){
            $rs = $DB->get_records_sql("SELECT cc.userid, cc.course, IFNULL(cc.timecompleted, 0) timecompleted
                              FROM {course_completions} cc
                              WHERE cc.userid = ?
                              AND timecompleted<>0", array($game->userid));
        }else if( $CFG->dbtype=="pgsql"){
            $rs = $DB->get_records_sql("SELECT cc.userid, cc.course, CASE WHEN cc.timecompleted IS NULL THEN 0 END) timecompleted
                              FROM {course_completions} cc
                              WHERE cc.userid = ?
                              AND timecompleted<>0", array($game->userid));
        }
        $n_badges = 0;
        foreach ($rs as $c){         
            $badges[$n_badges] = $c->course;
            $n_badges++;
        }
        
        $game->badges = "".implode(",", $badges)."";
        $game->score_badges = ($n_badges*$value);
        
        $DB->execute("UPDATE {block_game} SET badges=?,score_badges=? WHERE userid=? AND courseid=?", array($game->badges,$game->score_badges,$game->userid,1));

        return $game;
    }
    return $game;
}

//ranking user
function ranking($game,$level_up,$level_number) {
    global $DB;
     
    if (!empty($game->id)) {
        if($game->courseid==1){
                if( $CFG->dbtype=="mysql"){
                    $ranking = $DB->get_records_sql('SELECT g.userid, u.firstname,SUM(g.score) as sum_score, SUM(IFNULL(g.score_activities, 0)) as sum_score_activities, SUM(IFNULL(g.score_badges, 0)) as sum_score_badges, (SUM(score)+SUM(IFNULL(score_activities, 0))+SUM(IFNULL(score_badges, 0))) as pt FROM {block_game} as g, {user} as u WHERE u.id=g.userid GROUP BY userid  
ORDER BY pt DESC,sum_score_badges DESC,sum_score_activities DESC,sum_score DESC');
                }else if( $CFG->dbtype=="pgsql"){
                    $ranking = $DB->get_records_sql('SELECT g.userid, u.firstname,SUM(g.score) as sum_score, SUM(case when g.score_activities IS NULL THEN 0 END)) as sum_score_activities, SUM(case when g.score_badges IS NULL THEN 0 END)) as sum_score_badges, (SUM(score)+SUM(case when score_activities IS NULL THEN 0 END))+SUM(case when score_badges IS NULL THEN 0 END))) as pt FROM {block_game} as g, {user} as u WHERE u.id=g.userid GROUP BY userid  
ORDER BY pt DESC,sum_score_badges DESC,sum_score_activities DESC,sum_score DESC');
                }
                $poisicao=1;
                foreach($ranking as $rs){
                    if($rs->userid==$game->userid){
                        $game->rank= $poisicao;
                        //seting level and update score
                        if(setsLevel($rs->pt,$level_up)>=$level_number){
                            $level = $level_number;
                        }else{
                            $level = setsLevel($rs->pt,$level_up);
                        }
                        $game->score = $rs->sum_score;
                        $game->score_activities = $rs->sum_score_activities;
                        $game->level = $level;
                        break;
                    }
                    $poisicao++;
                } 
            }else{
                if( $CFG->dbtype=="mysql"){
                    $ranking = $DB->get_records_sql('SELECT g.userid, u.firstname,SUM(g.score) as sum_score, SUM(IFNULL(g.score_activities, 0)) as sum_score_activities, (SUM(score)+SUM(IFNULL(score_activities, 0))) as pt FROM mdl_block_game  as g, mdl_user as u WHERE u.id=g.userid AND courseid=? GROUP BY userid ORDER BY pt DESC, sum_score_activities DESC,sum_score DESC', array($game->courseid));
                }else if( $CFG->dbtype=="pgsql"){
                    $ranking = $DB->get_records_sql('SELECT g.userid, u.firstname,SUM(g.score) as sum_score, SUM(case when g.score_activities IS NULL THEN 0 END)) as sum_score_activities, (SUM(score)+SUM(case when score_activities IS NULL THEN 0 END))) as pt FROM mdl_block_game  as g, mdl_user as u WHERE u.id=g.userid AND courseid=? GROUP BY userid ORDER BY pt DESC, sum_score_activities DESC,sum_score DESC', array($game->courseid));
                }
                $poisicao=1;
                foreach($ranking as $rs){
                    if($rs->userid==$game->userid){
                        $game->rank= $poisicao;
                        //seting level
                        if(setsLevel($rs->pt,$level_up)>=$level_number){
                            $level = $level_number;
                        }else{
                            $level = setsLevel($rs->pt,$level_up);
                        }
                        $game->level = $level;
                        break;
                    }
                    $poisicao++;
                } 
            }
        $DB->execute("UPDATE {block_game} SET rank=?,level=? WHERE id=?", array($game->rank,$game->level,$game->id));
    }
    return $game;
}

//seting level
function setsLevel($score_full,$level_up){
    $level = 0;
    foreach ($level_up as $level_value){
        if($score_full>=$level_value){
            $level++;
        }
    }
    return $level;
}

//Get number of players of course
function getPlayers($courseid) {
    global $DB;     
    if (!empty($courseid)) {
        if($courseid==1){
            $busca = $DB->get_record_sql('SELECT count(*) as total FROM {user} WHERE confirmed=1 AND deleted=0 AND suspended=0 AND id > 1');
            return $busca->total;
        }else{
            $busca = $DB->get_record_sql('SELECT count(*) as total FROM {role_assignments} rs, {user} u, {context} e WHERE u.id=rs.userid AND rs.contextid=e.id AND e.contextlevel=50 AND e.instanceid=?', array($courseid));
            return $busca->total;   
        }
        
    }
    return false;
}

//Get number not players of course
function getNoPlayers($courseid) {
    global $DB;     
    if (!empty($courseid)) {
        if($courseid==1){
            $sql = 'SELECT count(*) as total FROM {user} WHERE confirmed=1 AND deleted=0 AND suspended=0 AND id > 1 AND id NOT IN(SELECT userid FROM {block_game})';
            $busca = $DB->get_record_sql($sql);
            return $busca->total;
        }else{
            $sql = 'SELECT count(*) as total FROM {role_assignments} rs, {user} u, {context} e WHERE u.id=rs.userid AND rs.contextid=e.id AND e.contextlevel=50 AND e.instanceid=?  AND u.id NOT IN(SELECT userid FROM {block_game})';
            $busca = $DB->get_record_sql($sql, array($courseid));
            return $busca->total;   
        }
        
    }
    return false;
}

//ranking list
function rank_list($courseid) {
    global $DB;
     
    if (!empty($courseid)) {
        if($courseid==1){
            if( $CFG->dbtype=="mysql"){
                $ranking = $DB->get_records_sql('SELECT g.userid, u.firstname, g.avatar,SUM(g.score) as sum_score, SUM(IFNULL(g.score_activities, 0)) as sum_score_activities, SUM(IFNULL(g.score_badges, 0)) as sum_score_badges, (SUM(score)+SUM(IFNULL(score_activities, 0))+SUM(IFNULL(score_badges, 0))) as pt FROM {block_game} as g, {user} as u WHERE u.id=g.userid GROUP BY userid  
ORDER BY pt DESC,sum_score_badges DESC,sum_score_activities DESC,sum_score DESC');                
            }else if( $CFG->dbtype=="pgsql"){
                $ranking = $DB->get_records_sql('SELECT g.userid, u.firstname, g.avatar,SUM(g.score) as sum_score, SUM(case when g.score_activities IS NULL THEN 0 END)) as sum_score_activities, SUM(case when g.score_badges IS NULL THEN 0 END)) as sum_score_badges, (SUM(score)+SUM(case when score_activities IS NULL THEN 0 END))+SUM(case when score_badges IS NULL THEN 0 END))) as pt FROM {block_game} as g, {user} as u WHERE u.id=g.userid GROUP BY userid  
ORDER BY pt DESC,sum_score_badges DESC,sum_score_activities DESC,sum_score DESC');
            }
            return $ranking;    
               
        }else{
            if( $CFG->dbtype=="mysql"){
                $ranking = $DB->get_records_sql('SELECT g.userid, u.firstname, g.avatar,SUM(g.score) as sum_score, SUM(IFNULL(g.score_activities, 0)) as sum_score_activities, (SUM(score)+SUM(IFNULL(score_activities, 0))) as pt FROM mdl_block_game  as g, mdl_user as u WHERE u.id=g.userid AND courseid=? GROUP BY userid ORDER BY pt DESC, sum_score_activities DESC,sum_score DESC', array($courseid));
            }else if( $CFG->dbtype=="pgsql"){
                $ranking = $DB->get_records_sql('SELECT g.userid, u.firstname, g.avatar,SUM(g.score) as sum_score, SUM(case when g.score_activities IS NULL THEN 0 END)) as sum_score_activities, (SUM(score)+SUM(case when score_activities IS NULL THEN 0 END))) as pt FROM mdl_block_game  as g, mdl_user as u WHERE u.id=g.userid AND courseid=? GROUP BY userid ORDER BY pt DESC, sum_score_activities DESC,sum_score DESC', array($courseid));
            }
            return $ranking;
        }
    }
    return false;
}

