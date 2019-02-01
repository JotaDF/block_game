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
        $SESSION->game  = $game;
        $game           =  load_game($game);
        
        if (isset($this->content)) {
            return $this->content;
        }

        // Start the content, which is primarily a table.
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';
        $showavatar = !isset($this->config->use_avatar) || $this->config->use_avatar == 1;
        $showrank   = !isset($this->config->show_rank) || $this->config->show_rank == 1;
        $showicons  = !isset($this->config->show_icons) || $this->config->show_icons == 1;
        $showscore  = !isset($this->config->show_score) || $this->config->show_score == 1;
        $showlevel  = !isset($this->config->show_level) || $this->config->show_level == 1;
        
        if(isset($this->config->level_up)){
            $level_up   = $this->config->level_up;
        }else{
            $level_up   = 100;
        }

        //bonus of day
        $bonus_of_day = !isset($this->config->add_bonus_day) || $this->config->add_bonus_day == 1;
        if($bonus_of_day){
            bonus_of_day($game);
        }
        
        //score activity notes
        $score_activities = !isset($this->config->score_activities) || $this->config->score_activities == 1;
         
        if($score_activities){
            score_activities($game);
            $game   =  ranking($game,$level_up);
        }else{
            no_score_activities($game);
            $game   =  ranking($game,$level_up);
        }
        
        $table = new html_table();
        $table->attributes = array('class' => 'gameTable');

        // display
        if ($USER->id != 0) {
            $row = array();
            $userpictureparams = array('size' => 16, 'link' => false, 'alt' => 'User');
            $userpicture = $OUTPUT->user_picture($USER, $userpictureparams);
            if($showavatar){
                $userpicture = '<a href="'.$CFG->wwwroot. '/blocks/game/set_avatar_form.php?id='.$COURSE->id.'&avatar='.$game->avatar.'">'.'<img src="'.$CFG->wwwroot.'/blocks/game/pix/a'.$game->avatar.'.png" height="40" width="40"/></a>';
            }
            $row[] = $userpicture.' '.get_string('label_you', 'block_game');
            $table->data[] = $row;
            $row = array();
            $txt_icon = $showicons? $OUTPUT->pix_icon('logo', $alt, 'theme') : '';
            $txt_course = $COURSE->id==1? '' : '('.$COURSE->shortname.')';
            $row[] = $txt_course;
            $table->data[] = $row;
            if($showrank){
                $row = array();
                $txt_icon = $showicons? $OUTPUT->pix_icon('rank', $alt, 'block_game') : '';
                $row[] = $txt_icon .' '. get_string('label_rank', 'block_game').': '.$game->rank.'';
                $table->data[] = $row;
            }
            if($showscore){
                $row = array();
                $txt_icon = $showicons? $OUTPUT->pix_icon('score', $alt, 'block_game') : '';
                $row[] = $txt_icon .' '. get_string('label_score', 'block_game').': '.($game->score+$game->score_activities).'';
                $table->data[] = $row;
            }
            if($showlevel){
                $row = array();
                $txt_icon = $showicons? $OUTPUT->pix_icon('level', $alt, 'block_game') : '';
                $row[] = $txt_icon .' '. get_string('label_level', 'block_game').': '.$game->level.'';
                $table->data[] = $row;
            }
            $row = array();
            //$txt_set_avatar='<a href="'.$CFG->wwwroot. '/blocks/game/set_avatar_form.php?id='.$COURSE->id.'&avatar='.$game->avatar.'"> avatar</a><br>';
            //$row[] =$txt_set_avatar;
            //$table->data[] = $row;
        } else {
            $row[] = '';
            $table->data[] = $row;
        }
        $this->content->text .= HTML_WRITER::table($table);

        $this->content->footer = '';
        return $this->content;
    }

}
