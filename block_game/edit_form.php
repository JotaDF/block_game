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
        /*
        // Options controlling how clocks are shown.
        $showclockoptions = array(
            B_SIMPLE_CLOCK_SHOW_BOTH =>
                get_string('config_show_rank', 'block_game'),
            B_SIMPLE_CLOCK_SHOW_SERVER_ONLY =>
                get_string('config_show_score', 'block_game'),
            B_SIMPLE_CLOCK_SHOW_USER_ONLY =>
                get_string('config_show_nivel', 'block_game')
        );
        $mform->addElement('select', 'config_show_clocks',
                           get_string('config_clock_visibility', 'block_game'),
                           $showclockoptions);
        $mform->setDefault('config_show_clocks', B_SIMPLE_CLOCK_SHOW_BOTH);
        $mform->addHelpButton('config_show_clocks', 'config_clock_visibility',
                              'block_game');
        */
        // Control visibility of rank names.
        $mform->addElement('selectyesno', 'config_show_rank',
                           get_string('config_rank', 'block_game'));
        $mform->setDefault('config_show_rank', 0);
        $mform->addHelpButton('config_show_rank', 'config_rank', 'block_game');

        // Control visibility of score.
        $mform->addElement('selectyesno', 'config_show_score',
                           get_string('config_score', 'block_game'));
        $mform->setDefault('config_show_score', 0);
        $mform->addHelpButton('config_show_score', 'config_score', 'block_game');

        // Control visibility of nivel.
        $mform->addElement('selectyesno', 'config_show_nivel',
                           get_string('config_nivel', 'block_game'));
        $mform->setDefault('config_show_nivel', 0);
        $mform->addHelpButton('config_show_nivel', 'config_nivel', 'block_game');

        // Control visibility of icons.
        $mform->addElement('selectyesno', 'config_show_icons',
                           get_string('config_icons', 'block_game'));
        $mform->setDefault('config_show_icons', 1);
        $mform->addHelpButton('config_show_icons', 'config_icons', 'block_game');


        // Clock block instance alternate title.
        $mform->addElement('text', 'config_game_title',
                           get_string('config_title', 'block_game'));
        $mform->setDefault('config_game_title', '');
        $mform->disabledIf('config_game_title', 'config_show_header', 'eq', 0);
        $mform->setType('config_game_title', PARAM_MULTILANG);
        $mform->addHelpButton('config_game_title', 'config_title', 'block_game');
    }
}
