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
require_login();

$courseid = required_param('courseid',PARAM_INT);
$linkidtodelete = optional_param('linkidtodelete',0,PARAM_INT);
$context = context_course::instance($courseid);

require_capability('enrol/magiclink:editlink', $context);

require_once ($CFG->dirroot.'/enrol/magiclink/classes/form/linkform.php');
require_once ($CFG->dirroot.'/enrol/magiclink/classes/linkbiz.php');



$PAGE->set_url(new moodle_url('/enrol/magiclink/linkedit.php',['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_title(get_string('pluginname', 'enrol_magiclink'));
$PAGE->set_heading(get_string('pluginname', 'enrol_magiclink'));
$PAGE->set_pagelayout('standard');

if($linkidtodelete != 0){
    enrol_magiclink_linkbiz::delete_link_by_id($linkidtodelete);
    redirect(new moodle_url('/enrol/magiclink/linkedit.php',['courseid' => $courseid]));
}

$form = new enrol_magiclink_linkform();

$fromform = $form->get_data();

if($fromform != null){
    enrol_magiclink_linkbiz::insert_link_by_identifier_courseid($fromform->courseid,$fromform->linkidentifier);
    
}
else{
    $form->set_data(['courseid' => $courseid]);
}

$extraction = enrol_magiclink_linkbiz::get_links_by_courseid($courseid);

$tabella = new html_table();

$tabella->head = [
    'id',
    get_string('linkidentifier','enrol_magiclink'),
    ''
];

foreach ($extraction as $record) {
    $row = [
        $record->id,
        enrol_magiclink_linkbiz::get_linkurl_by_identifier_courseid($courseid, $record->linkidentifier),
        html_writer::tag('a',get_string('delete'),[ 'href'=>  new moodle_url('/enrol/magiclink/linkedit.php',['linkidtodelete' => $record->id,'courseid' => $courseid])])
    ];
    $tabella->data[] = $row;
}

//----------------------------------------------

echo $OUTPUT->header();

echo html_writer::tag('p',get_string('link_edit_description','enrol_magiclink'));

$form->display();

echo html_writer::table($tabella);

echo $OUTPUT->footer();