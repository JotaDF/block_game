<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Carregando dados de game do usuario
function load_game($game) {
    global $DB;

    if (!empty($game->userid) && !empty($game->courseid)) {
        $busca = $DB->get_record_sql('SELECT count(*) as total  FROM {scorm_game} WHERE courseid=? AND scormid=? AND userid=?', array($game->courseid,$game->scormid,$game->userid));
        //caso existam dados 
        if($busca->total>0){

            $gamedb = $DB->get_record('scorm_game',array('courseid' => $game->courseid , 'scormid' => $game->scormid, 'userid' => $game->userid));

            $game_json = array(
                'game' => array(
                'id' => $gamedb->id,
                'courseid' => $gamedb->courseid,
                'scormid' => $gamedb->scormid,
                'userid' => $gamedb->userid,
                'avatar' => $gamedb->avatar,
                'score' => $gamedb->score,
                'nivel' => $gamedb->nivel,
                'recompensas' => array ($gamedb->recompensas)
                )
                );
            return $game_json;

        }else{
                //caso nao existam dados 
                $new_game = new stdClass();
                $new_game->courseid	= $game->courseid;
                $new_game->scormid 	= $game->scormid;
                $new_game->userid 	= $game->userid;
                $new_game->avatar 	= 0;
                $new_game->score 	= 0;
                $new_game->nivel 	= 0;
                $new_game->recompensas 	= "";
                $lastinsertid = $DB->insert_record('scorm_game', $new_game);
                $game_json = array(
                    'game' => array(
                    'id' => $lastinsertid,
                    'courseid' => $new_game->courseid,
                    'scormid' => $new_game->scormid,
                    'userid' => $new_game->userid,
                    'avatar' => $new_game->avatar,
                    'score' => $new_game->score,
                    'nivel' => $new_game->nivel,
                    'recompensas' => array ()
                    )
                );
                return $game_json;
        }
    }


    return false;
}

//Altualiza dados de game do usuario
function update_game($game) {
    global $DB;

    if (!empty($game->id) && !empty($game->userid) && !empty($game->courseid)) {
        if (empty($game->scormid)) {
            $game->scormid = 0;
        }
        if (empty($game->avatar)) {
            $game->avatar = 0;
        }
        if (empty($game->score)) {
            $game->score = 0;
        }
        if (empty($game->nivel)) {
            $game->nivel = 0;
        }
        $save_game = new stdClass();
        $save_game->id       = $game->id;
        $save_game->courseid = $game->courseid;
        $save_game->scormid  = $game->scormid;
        $save_game->userid   = $game->userid;
        $save_game->avatar   = $game->avatar;
        $save_game->score    = $game->score;
        $save_game->nivel    = $game->nivel;
        $DB->update_record('scorm_game', $save_game);
        
        return true;
    }
    return false;
}
//Acrescenta recompensa de game do usuario
function add_reconpenca($game,$recompensa) {
    global $DB;

    if (!empty($game->id) && !empty($game->userid) && !empty($game->courseid)) {
        if (empty($game->scormid)) {
            $game->scormid = 0;
        }
        if (empty($game->avatar)) {
            $game->avatar = 0;
        }
        if (empty($game->score)) {
            $game->score = 0;
        }
        if (empty($game->nivel)) {
            $game->nivel = 0;
        }
        $save_game = new stdClass();
        $save_game->id       = $game->id;
        $save_game->courseid = $game->courseid;
        $save_game->scormid  = $game->scormid;
        $save_game->userid   = $game->userid;
        $save_game->avatar   = $game->avatar;
        $save_game->score    = $game->score;
        $save_game->nivel    = $game->nivel;
        $DB->update_record('scorm_game', $save_game);
        
        return true;
    }
    return false;
}
