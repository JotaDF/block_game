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
 * Game block definition
 *
 * @package    contrib
 * @subpackage block_game
 * @copyright  2019 Jose Wilson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/blocks/game/libgame.php');

class block_game extends block_base {
    /**
     * Sets the block title
     *
     * @return none
     */
    public function init() {
        $this->title = get_string('game_title_default', 'block_game');
    }

    /**
     * Controls the block title based on instance configuration
     *
     * @return bool
     */
    public function specialization() {
         global $course;

        // Need the bigger course object.
        $this->course = $course;
        
        // Override the block title if an alternative is set.
        if (isset($this->config->game_title) && trim($this->config->game_title) != '') {
            $this->title = format_string($this->config->game_title);
        }
    }

    /**
     * Defines where the block can be added
     *
     * @return array
     */
    public function applicable_formats() {
        return array(
            'course-view' => true,
            'site-index' => true,
            'mod' => true,
            'my' => true
        );
    }

    /**
     * Controls global configurability of block
     *
     * @return bool
     */
    public function instance_allow_config() {
        return false;
    }

    /**
     * Controls global configurability of block
     *
     * @return bool
     */
    public function has_config() {
        return false;
    }

    /**
     * Controls if a block header is shown based on instance configuration
     *
     * @return bool
     */
    public function hide_header() {
        return isset($this->config->show_header) && $this->config->show_header == 0;
    }

    /**
     * Creates the block's main content
     *
     * @return string
     */
    public function get_content() {

        global $USER, $SESSION, $COURSE, $OUTPUT, $CFG;
        
        //load Game of user
        $game = new stdClass();
        $game->courseid = $COURSE->id;
        $game->userid   = $USER->id;
//        $game->config   = $this->config;
//        $SESSION->game  = $game;
        $game           =  load_game($game);
        $game->config   = $this->config;
        $SESSION->game  = $game;
        
        if (!file_exists($CFG->dirroot.'/blocks/game/game.js')) {
            //create file game.js';
            $context = stream_context_create(array('http' => array('method'  => 'POST','content' => '')));
            $contents = file_get_contents($CFG->wwwroot.'/blocks/game/create_game_js.php', null, $context);
          }
        if (isset($this->content)) {
            return $this->content;
        }

        // Start the content, which is primarily a table.
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';
        $showavatar = !isset($this->config->use_avatar) || $this->config->use_avatar == 1;
        $showidentity = !isset($this->config->show_identity) || $this->config->show_identity == 1;
        $showrank   = !isset($this->config->show_rank) || $this->config->show_rank == 1;
        $showinfo  = !isset($this->config->show_info) || $this->config->show_info == 1;
        $showscore  = !isset($this->config->show_score) || $this->config->show_score == 1;
        $showlevel  = !isset($this->config->show_level) || $this->config->show_level == 1;

        $level_number=0;
        //config level up
        if($showlevel){
            $level_number  = (int)$this->config->level_number;
            $level_up[0]   = (int)$this->config->level_up1;
            $level_up[1]   = (int)$this->config->level_up2;
            $level_up[2]   = (int)$this->config->level_up3;
            $level_up[3]   = (int)$this->config->level_up4;
            $level_up[4]   = (int)$this->config->level_up5;
            $level_up[5]   = (int)$this->config->level_up6;
            $level_up[6]   = (int)$this->config->level_up7;
            $level_up[7]   = (int)$this->config->level_up8;
            $level_up[8]   = (int)$this->config->level_up9;
            $level_up[9]   = (int)$this->config->level_up10;
            $level_up[10]   = (int)$this->config->level_up11;
            $level_up[11]   = (int)$this->config->level_up12;
            $level_up[12]   = (int)$this->config->level_up13;
            $level_up[13]   = (int)$this->config->level_up14;
            $level_up[14]   = (int)$this->config->level_up15;
        }

        //bonus of day
        if(isset($this->config->add_bonus_day)){
            $add_bonus_day   = $this->config->add_bonus_day;
        }else{
            $add_bonus_day   = 0;
        }
        //echo "(".$add_bonus_day.")";
        if($add_bonus_day>0){
            bonus_of_day($game,$add_bonus_day);
        }
        
        //bonus of badge
        if(isset($this->config->add_bonus_badge)){
            $bonus_badge   = $this->config->add_bonus_badge;
            $game   =  score_badge($game,$bonus_badge);
        }
        //score activity notes
        $score_activities = !isset($this->config->score_activities) || $this->config->score_activities == 1;
         
        if($score_activities){
            score_activities($game);
            if($level_number>0)
                $game   =  ranking($game,$level_up,$level_number);
        }else{
            no_score_activities($game);
            if($level_number>0)
                $game   =  ranking($game,$level_up,$level_number);
        }
        
        $table = new html_table();
        $table->attributes = array('class' => 'gameTable');

        // display
        if ($USER->id != 0) {
            $row = array();
            $userpictureparams = array('size' => 16, 'link' => false, 'alt' => 'User');
            $userpicture = $OUTPUT->user_picture($USER, $userpictureparams);
            if($showavatar){
                if($COURSE->id==1){
                    $userpicture = '<a href="'.$CFG->wwwroot. '/blocks/game/set_avatar_form.php?id='.$COURSE->id.'&avatar='.$game->avatar.'">'.'<img hspace="5" src="'.$CFG->wwwroot.'/blocks/game/pix/a'.$game->avatar.'.png" height="40" width="40"/></a>';                  
                }else{
                    $userpicture = '<img hspace="5" src="'.$CFG->wwwroot.'/blocks/game/pix/a'.$game->avatar.'.png" height="40" width="40"/>';
                }
            }
            $link_info = '';
             if($showinfo){
                $link_info = '<a href="'.$CFG->wwwroot. '/blocks/game/perfil_gamer.php?id='.$COURSE->id.'&level='.$showlevel.'&score='.$showscore.'&rank='.$showrank.'&avatar='.$showavatar.'">'.'<img hspace="12" src="'.$CFG->wwwroot.'/blocks/game/pix/info.png"/></a>';
             }
            $row[] = $userpicture.' '.get_string('label_you', 'block_game').$link_info;
            $table->data[] = $row;
            $row = array();
            $txt_icon =  $OUTPUT->pix_icon('logo', $alt, 'theme');
            $txt_course = $COURSE->id==1? '' : '('.$COURSE->shortname.')';
            $row[] = $txt_course;
            $table->data[] = $row;
            if($showrank){
                $row = array();
                $txt_icon = '<img src="'.$CFG->wwwroot.'/blocks/game/pix/rank.png" height="20" width="20"/>';
                $row[] = $txt_icon .' '. get_string('label_rank', 'block_game').': '.$game->rank.'&ordm; / '.getPlayers($game->courseid);
                $table->data[] = $row;
            }
            if($showscore){
                $row = array();
                $txt_icon = '<img src="'.$CFG->wwwroot.'/blocks/game/pix/score.png" height="20" width="20"/>';
                $row[] = $txt_icon .' '. get_string('label_score', 'block_game').': '.($game->score+$game->score_activities+$game->score_badges).'';
                $table->data[] = $row;
            }
            if($showlevel){
                $row = array();
                $txt_icon = '<img src="'.$CFG->wwwroot.'/blocks/game/pix/level.png" height="20" width="20"/>';
                $row[] = $txt_icon .' '. get_string('label_level', 'block_game').': '.$game->level.'';
                $table->data[] = $row;
            }
            $row = array();
            $txt_icon_rank  = '<hr/><table border="0" width="100%"><tr>';
            if($showrank){
                $txt_icon_rank .= '<td align="left" width="50%"><a href="'.$CFG->wwwroot. '/blocks/game/rank_game.php?id='.$COURSE->id.'"><img alt="'.get_string('label_rank', 'block_game').'" title="'.get_string('label_rank', 'block_game').'" src="'.$CFG->wwwroot.'/blocks/game/pix/rank_list.png" height="25" width="25"/></a></td>';
            }                
            $txt_icon_rank .= '<td align="right" width="50%"><a href="'.$CFG->wwwroot. '/blocks/game/help_game.php?id='.$COURSE->id.'"><img alt="'.get_string('help', 'block_game').'" title="'.get_string('help', 'block_game').'" src="'.$CFG->wwwroot.'/blocks/game/pix/help.png"  height="25" width="25"/></a></td>';
            $txt_icon_rank .= '</tr></table>';
            $row[] = $txt_icon_rank;
            $table->data[] = $row;
        } else {
            $row[] = '';
            $table->data[] = $row;
        }
        $this->content->text .= HTML_WRITER::table($table);

        $this->content->footer = '';
        return $this->content;
    }

}
