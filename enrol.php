<?php

// Copyright (C) 2024 Azienda S.r.l. (https://www.sitoazienda.it/)
//
// This file is part of the Magic Link plugin for Moodle - http://moodle.org/
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details: http://www.gnu.org/copyleft/gpl.html
/**
 * @package    enrol_magiclink
 * @author     Mario Rossi <mario.rossi@mailinesistente.it>
 * @copyright  2024 Azienda S.r.l. (https://www.sitoazienda.it/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

require_login(null,false);

require_once ($CFG->dirroot.'/enrol/magiclink/classes/linkbiz.php');
require_once ($CFG->dirroot.'/enrol/magiclink/lib.php');

$linkidentifier = required_param('linkidentifier',PARAM_ALPHANUM);
$courseid = required_param('courseid',PARAM_ALPHANUM);

$link = enrol_magiclink_linkbiz::get_link_by_courseid_linkidentifier($courseid, $linkidentifier);

if(!$link){
    print_error("invalid link");
}

$enrolinstances = enrol_get_instances($courseid, true);

$magiclink_instance = null;
foreach ($enrolinstances as $instance) {
    if($instance->enrol == 'magiclink'){
        $magiclink_instance = $instance;
        break;
    }
}

if($magiclink_instance == null){
    print_error("link disabled");
}
else{
    $plugin = new enrol_magiclink_plugin();

    $plugin->enrol_user($magiclink_instance, $USER->id);
}

redirect(new moodle_url('/course/view.php',['id'=>$courseid]));

