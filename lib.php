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

//  function enrol_magiclink_extend_navigation_frontpage(navigation_node $frontpage){
//     $show = get_config('enrol_magiclink','showinsitenavigation');
//     if($show == '1'){
//         $frontpage->add(get_string('pluginname', 'enrol_magiclink'), new moodle_url('/enrol/magiclink/helloworld.php'));
//     }
//  }

 function enrol_magiclink_extend_navigation_course(navigation_node $frontpage){
    global $PAGE;
    $courseid = $PAGE->course->id;

    if(!$courseid){
        return;
    }
    
    $show = get_config('enrol_magiclink','showincoursenavigation');
    if($show == '1'){
        $frontpage->add(get_string('pluginname', 'enrol_magiclink'), new moodle_url('/enrol/magiclink/linkedit.php',['courseid'=>$courseid]));
    }

    
 }

 class enrol_magiclink_plugin extends enrol_plugin{
    public function use_standard_editing_ui() {
        return true;
    }

    public function edit_instance_form($instance, MoodleQuickForm $mform, $context) {
        // Do nothing by default.
    }


    public function edit_instance_validation($data, $files, $instance, $context) {
        // Niente validazione per ora
        return array();
    }

    public function can_add_instance($courseid) {
        return true;
    }
 }