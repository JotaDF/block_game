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
function get_game($game) {
    global $DB;
    if (!empty($game->userid) && !empty($game->courseid)) {
        $busca = $DB->get_record_sql('SELECT count(*) as total  FROM {block_game} WHERE courseid=? AND userid=?', array($game->courseid,$game->userid));
        //caso existam dados 
        if($busca->total>0){
            $gamedb = $DB->get_record('block_game',array('courseid' => $game->courseid , 'userid' => $game->userid));
            if($game->courseid==1){
                //echo '<script>console.log("Entrou no if curso 1!")</script>';
                $ranking = $DB->get_records_sql('SELECT userid, SUM(score) as pt FROM {block_game} GROUP BY userid ORDER BY pt DESC');
                $poisicao=1;
                foreach($ranking as $rs){
                    if($rs->userid==$game->userid){
                        $gamedb->score = $rs->pt;
                        $gamedb->rank= $poisicao;
                        break;
                    }
                    $poisicao++;
                } 
            }else{
                $ranking = $DB->get_record_sql('SELECT count(*) as valor  FROM {block_game} WHERE courseid=? AND score>?', array($game->courseid,$gamedb->score));
                $gamedb->rank=$ranking->valor+1;
            }
            return $gamedb;

        }else{
                //caso nao existam dados 
                $new_game = new stdClass();
                $new_game->courseid	= $game->courseid;
                $new_game->userid 	= $game->userid;
                $new_game->avatar 	= 0;
                $new_game->score 	= 0;
                $new_game->nivel 	= 0;
                $new_game->rank 	= 0;
                $new_game->conquistas 	= "";
                $new_game->fases 	= "";
                $new_game->recompensas 	= "";
                $lastinsertid = $DB->insert_record('block_game', $new_game);
                $new_game->id           = $lastinsertid;
                
                return $new_game;
        }
    }
    return false;
}

//Load game user
function load_game($game) {
    global $DB;

    if (!empty($game->userid) && !empty($game->courseid)) {
        $busca = $DB->get_record_sql('SELECT count(*) as total  FROM {block_game} WHERE courseid=? AND userid=?', array($game->courseid,$game->userid));
        //caso existam dados 
        if($busca->total>0){

            $gamedb = $DB->get_record('block_game',array('courseid' => $game->courseid , 'userid' => $game->userid));

            $game_json = array(
                'game' => array(
                'id' => $gamedb->id,
                'courseid' => $gamedb->courseid,
                'userid' => $gamedb->userid,
                'avatar' => $gamedb->avatar,
                'score' => $gamedb->score,
                'nivel' => $gamedb->nivel,
                'rank' => $gamedb->rank,
                'conquistas' => explode( ',',$gamedb->conquistas),
                'fases' => explode( ',',$gamedb->fases),
                'recompensas' => explode( ',',$gamedb->recompensas)
                )
                );
            return $game_json;

        }else{
                //case is not exsist 
                $new_game = new stdClass();
                $new_game->courseid	= $game->courseid;
                $new_game->userid 	= $game->userid;
                $new_game->avatar 	= 0;
                $new_game->score 	= 0;
                $new_game->nivel 	= 0;
                $new_game->rank 	= 0;
                $new_game->conquistas 	= "";
                $new_game->fases 	= "";
                $new_game->recompensas 	= "";
                $lastinsertid = $DB->insert_record('block_game', $new_game);
                $game_json = array(
                    'game' => array(
                    'id' => $lastinsertid,
                    'courseid' => $new_game->courseid,
                    'userid' => $new_game->userid,
                    'avatar' => $new_game->avatar,
                    'score' => $new_game->score,
                    'nivel' => $new_game->nivel,
                    'rank' => $new_game->rank,
                    'conquistas' => $new_game->conquistas,
                    'fases' => $new_game->fases,
                    'recompensas' => $new_game->recompensas
                    )
                );
                return $game_json;
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
        if (empty($game->nivel)) {
            $game->nivel = 0;
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
        $save_game->nivel       = $game->nivel;
        $save_game->rank        = $game->rank;
        $save_game->conqustas   = $game->conqustas;
        $save_game->fases       = $game->fases;
        $save_game->recompensas = $game->recompensas;
         
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

//Update nivel game
function update_nivel_game($game) {
    global $DB;
     
    if (!empty($game->id) && !empty($game->nivel)) {
        
        $save_game = new stdClass();
        $save_game->id         = $game->id;
        $save_game->nivel      = $game->nivel;

        $DB->update_record('block_game', $save_game);
        
        return true;
    }
    return false;
}
//Update recompensas game
function update_recompensas_game($game) {
    global $DB;
     
    if (!empty($game->id)) {
        
        $save_game = new stdClass();
        $save_game->id          = $game->id;
        $save_game->recompensas = $game->recompensas;

        $DB->update_record('block_game', $save_game);
        
        return true;
    }
    return false;
}
//Update fases game
function update_fases_game($game) {
    global $DB;
     
    if (!empty($game->id)) {
        
        $save_game = new stdClass();
        $save_game->id    = $game->id;
        $save_game->fases = $game->fases;

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
?>