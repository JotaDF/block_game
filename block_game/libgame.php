<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Carregando dados de game do usuario
function get_game($game) {
    global $DB;

    if (!empty($game->userid) && !empty($game->courseid)) {
        $busca = $DB->get_record_sql('SELECT count(*) as total  FROM {block_game} WHERE courseid=? AND userid=?', array($game->courseid,$game->userid));
        //caso existam dados 
        if($busca->total>0){

            $gamedb = $DB->get_record('block_game',array('courseid' => $game->courseid , 'userid' => $game->userid));
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

//Carregando dados de game do usuario
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

//Altualiza dados de game do usuario
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
//Altualiza dados de avatar do game do usuario
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

//Altualiza dados de score do game do usuario
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

//Altualiza dados de nivel do game do usuario
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
//Altualiza dados de recompensas do game do usuario
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
//Altualiza dados de fases do game do usuario
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