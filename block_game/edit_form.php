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
 * Game block config form definition
 *
 * @package    contrib
 * @subpackage block_game
 * @copyright  2019 Jose Wilson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(__FILE__) . '/../../config.php');


class block_game_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        global $SESSION;
        $visible = false;
        echo "ID-Curso:".$SESSION->game->courseid;
        if(is_siteadmin()){
            $visible = true;
        }  else if($SESSION->game->courseid>1){
            $visible = true;
        }
        
        if ($visible) {
            // Start block specific section in config form.
            $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

            // Game block instance alternate title.
            $mform->addElement('text', 'config_game_title', get_string('config_title', 'block_game'));
            $mform->setDefault('config_game_title', '');
            $mform->setType('config_game_title', PARAM_MULTILANG);
            $mform->addHelpButton('config_game_title', 'config_title', 'block_game');

            // Control visibility of avatar.
            $mform->addElement('selectyesno', 'config_use_avatar', get_string('config_avatar', 'block_game'));
            $mform->setDefault('config_use_avatar', 0);
            $mform->addHelpButton('config_use_avatar', 'config_avatar', 'block_game');

            // Control visibility of link info user game.
            $mform->addElement('selectyesno', 'config_show_info', get_string('config_info', 'block_game'));
            $mform->setDefault('config_show_info', 1);
            $mform->addHelpButton('config_show_info', 'config_info', 'block_game');

            // Control score activities.
            $mform->addElement('selectyesno', 'config_score_activities', get_string('config_score_activities', 'block_game'));
            $mform->setDefault('config_score_activities', 1);
            $mform->addHelpButton('config_score_activities', 'config_score_activities', 'block_game');

            // Control bonus of day.
            $bonus_day_options = array(0 => 0, 5 => 5, 10 => 10, 15 => 15, 20 => 20, 50 => 50, 100 => 100);
            $mform->addElement('select', 'config_add_bonus_day', get_string('config_bonus_day', 'block_game'), $bonus_day_options);
            $mform->addHelpButton('config_add_bonus_day', 'config_bonus_day', 'block_game');

            // Control bonus of badge course completed.
            $bonus_badge_options = array(100 => 100, 200 => 200, 500 => 500, 1000 => 1000, 2000 => 2000);
            $mform->addElement('select', 'config_add_bonus_badge', get_string('config_bonus_badge', 'block_game'), $bonus_badge_options);
            $mform->addHelpButton('config_add_bonus_badge', 'config_bonus_badge', 'block_game');

            // Control visibility of rank.
            $mform->addElement('selectyesno', 'config_show_rank', get_string('config_rank', 'block_game'));
            $mform->setDefault('config_show_rank', 0);
            $mform->addHelpButton('config_show_rank', 'config_rank', 'block_game');

            // Preserve user identity.
            $mform->addElement('selectyesno', 'config_show_identity', get_string('config_identity', 'block_game'));
            $mform->setDefault('config_show_identity', 0);
            $mform->hideIf('config_show_identity', 'config_show_rank', 'eq', 0);
            $mform->disabledIf('config_show_identity', 'config_show_rank', 'eq', 0);
            $mform->addHelpButton('config_show_identity', 'config_identity', 'block_game');

            // Control visibility of score.
            $mform->addElement('selectyesno', 'config_show_score', get_string('config_score', 'block_game'));
            $mform->setDefault('config_show_score', 0);
            $mform->addHelpButton('config_show_score', 'config_score', 'block_game');

            // Control visibility of level.
            $mform->addElement('selectyesno', 'config_show_level', get_string('config_level', 'block_game'));
            $mform->setDefault('config_show_level', 0);
            $mform->addHelpButton('config_show_level', 'config_level', 'block_game');

            // Options controlling level up.
            $level_up_options = array(4 => 4, 6 => 6, 8 => 8, 10 => 10, 12 => 12, 15 => 15);
            $mform->addElement('select', 'config_level_number', get_string('config_level_number', 'block_game'), $level_up_options);
            $mform->hideIf('config_level_number', 'config_show_level', 'eq', 0);
            $mform->disabledIf('config_level_number', 'config_show_level', 'eq', 0);
            $mform->addHelpButton('config_level_number', 'config_level_number', 'block_game');

            $level_up_points = array(1 => 300, 2 => 500, 3 => 1000, 4 => 2000, 5 => 4000, 6 => 6000, 7 => 10000, 8 => 20000, 9 => 30000, 10 => 50000, 11 => 70000, 12 => 100000, 13 => 150000, 14 => 300000, 15 => 500000);
            for ($i = 1; $i <= count($level_up_points); $i++) {
                // Options controlling points level up.
                $mform->addElement('text', 'config_level_up' . $i, get_string('config_level_up' . $i, 'block_game'));
                $mform->setDefault('config_level_up' . $i, $level_up_points[$i]);
                $mform->hideIf('config_level_up' . $i, 'config_show_level', 'eq', 0);
                $mform->disabledIf('config_level_up' . $i, 'config_show_level', 'eq', 0);
                foreach ($level_up_options as $level) {
                    if ($level < $i) {
                        $mform->hideIf('config_level_up' . $i, 'config_level_number', 'eq', $level);
                        $mform->disabledIf('config_level_up' . $i, 'config_level_number', 'eq', $level);
                    }
                }
                $mform->setType('config_level_up' . $i, PARAM_INT);
                $mform->addHelpButton('config_level_up' . $i, 'config_level_up' . $i, 'block_game');
            }
        }
    }

}
