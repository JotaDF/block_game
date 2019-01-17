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
 * Simple Clock block definition
 *
 * @package    contrib
 * @subpackage block_game
 * @copyright  2019 Jose Wilson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/blocks/game/libgame.php');

/**
 * Game block class
 *
 * @copyright 2010 Michael de Raadt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
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
        
        //carregando Game do usuario
        $game = new stdClass();
        $game->courseid = $COURSE->id;
        $game->userid   = $USER->id;
        
        $game=  get_game($game);
        
        if (isset($this->content)) {
            return $this->content;
        }

        // Start the content, which is primarily a table.
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';
        $table = new html_table();
        $table->attributes = array('class' => 'gameTable');

        // display
        

        if ($USER->id != 0) {
            $row = array();
            $userpictureparams = array('size' => 16, 'link' => false, 'alt' => 'User');
            $userpicture = $OUTPUT->user_picture($USER, $userpictureparams);
            $row[] = $userpicture;
            $row[] = $USER->firstname;
            
            $row[] = '(Curso:'.$COURSE->id.')';
        } else {
            $row[] = '';
        }
        $table->data[] = $row;
        $this->content->text .= HTML_WRITER::table($table);

        $this->content->footer = '';
        return $this->content;
    }

}
