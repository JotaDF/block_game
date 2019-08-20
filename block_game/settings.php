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
 *  Block Game config form definition class
 *
 * @package    block_game
 * @copyright  2019 Jose Wilson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_login();

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_heading('block_game/displaysettings',
            get_string('defaultdisplaysettings', 'block_game'), ''));

    $settings->add(new admin_setting_configcheckbox('block_game/use_avatar',
        get_string('config_avatar', 'block_game'), '', 1));

    $settings->add(new admin_setting_configcheckbox('block_game/show_info',
        get_string('config_info', 'block_game'), '', 1));

    $settings->add(new admin_setting_configcheckbox('block_game/score_activities',
        get_string('config_info', 'block_game'), '', 1));

    $bonusdayoptions = array(0 => 0, 5 => 5, 10 => 10, 15 => 15, 20 => 20, 50 => 50, 100 => 100);
    $settings->add(new admin_setting_configselect('block_game/bonus_day', get_string('config_bonus_day', 'block_game'),
        '', -2, $bonusdayoptions));

    $bonusbadgeoptions = array(0 => 0, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000, 2000 => 2000);
    $settings->add(new admin_setting_configselect('block_game/bonus_badge', get_string('config_bonus_badge', 'block_game'),
        '', -2, $bonusbadgeoptions));

    $settings->add(new admin_setting_configcheckbox('block_game/show_rank',
        get_string('config_rank', 'block_game'), '', 1));

    $settings->add(new admin_setting_configcheckbox('block_game/show_identity',
        get_string('config_identity', 'block_game'), '', 1));

    $settings->add(new admin_setting_configcheckbox('block_game/show_score',
        get_string('config_score', 'block_game'), '', 1));

    $settings->add(new admin_setting_configcheckbox('block_game/show_level',
        get_string('config_level', 'block_game'), '', 1));

    // Options controlling level up.
    $levelupoptions = array(4 => 4, 6 => 6, 8 => 8, 10 => 10, 12 => 12, 15 => 15);
    $settings->add(new admin_setting_configselect('block_game/level_number', get_string('config_level_number', 'block_game'),
        '', -2, $levelupoptions));

    $leveluppoints = array(1 => 300, 2 => 500, 3 => 1000, 4 => 2000,
        5 => 4000, 6 => 6000, 7 => 10000, 8 => 20000,
        9 => 30000, 10 => 50000, 11 => 70000, 12 => 100000,
        13 => 150000, 14 => 300000, 15 => 500000);
    for ($i = 1; $i <= count($leveluppoints); $i++) {
        $settings->add(new admin_setting_configtext('block_game/level_up' . $i, get_string('config_level_up' . $i, 'block_game'),
        '', $leveluppoints[$i], PARAM_INT));
    }
}
