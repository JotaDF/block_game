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

        // Start block specific section in config form.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Control visibility of rank.
        $mform->addElement('selectyesno', 'config_show_rank',
                           get_string('config_rank', 'block_game'));
        $mform->setDefault('config_show_rank', 0);
        $mform->addHelpButton('config_show_rank', 'config_rank', 'block_game');

        // Control visibility of score.
        $mform->addElement('selectyesno', 'config_show_score',
                           get_string('config_score', 'block_game'));
        $mform->setDefault('config_show_score', 0);
        $mform->addHelpButton('config_show_score', 'config_score', 'block_game');

        // Control visibility of level.
        $mform->addElement('selectyesno', 'config_show_level',
                           get_string('config_level', 'block_game'));
        $mform->setDefault('config_show_level', 0);
        $mform->addHelpButton('config_show_level', 'config_level', 'block_game');
        
        // Options controlling level up.
<<<<<<< HEAD
        $level_up_options = array(100=>100,200=>200,500=>500,1000=>1000,1500=>1500,2000=>2000,5000=>5000,10000=>10000);
=======
        $level_up_options = array(100=>100,500=>500,1000=>1000,1500=>1500,2000=>2000,5000=>5000,10000=>10000);
>>>>>>> afb734063cd05f24d6e77bcc83159c10d4cb6251
        $mform->addElement('select', 'config_level_up',
                           get_string('config_level_up', 'block_game'),
                           $level_up_options);
        
        // Control visibility of icons.
        $mform->addElement('selectyesno', 'config_show_icons',
                           get_string('config_icons', 'block_game'));
        $mform->setDefault('config_show_icons', 1);
        $mform->addHelpButton('config_show_icons', 'config_icons', 'block_game');

        // Control score activities.
         $mform->addElement('selectyesno', 'config_score_activities',
                           get_string('config_score_activities', 'block_game'));
        $mform->setDefault('config_score_activities', 1);
        $mform->addHelpButton('config_score_activities', 'config_score_activities', 'block_game');

        // Control bonus of day.
         $mform->addElement('selectyesno', 'config_add_bonus_day',
                           get_string('config_bonus_day', 'block_game'));
        $mform->setDefault('config_add_bonus_day', 1);
        $mform->addHelpButton('config_add_bonus_day', 'config_bonus_day', 'block_game');

        // Game block instance alternate title.
        $mform->addElement('text', 'config_game_title',
                           get_string('config_title', 'block_game'));
        $mform->setDefault('config_game_title', '');
        $mform->disabledIf('config_game_title', 'config_show_header', 'eq', 0);
        $mform->setType('config_game_title', PARAM_MULTILANG);
        $mform->addHelpButton('config_game_title', 'config_title', 'block_game');
    }
}
