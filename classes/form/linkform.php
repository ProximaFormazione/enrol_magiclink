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

defined('MOODLE_INTERNAL') || die();    

require_once("$CFG->libdir/formslib.php");

class enrol_magiclink_linkform extends moodleform {
    public function definition(){

        $mform = $this->_form;

        $mform->addElement('hidden', 'courseid', '');
        $mform->setType('courseid', PARAM_INT);

        $mform->addElement('text', 'linkidentifier', get_string('linkidentifier','enrol_magiclink'));
        $mform->setType('linkidentifier', PARAM_ALPHANUM);

        $this->add_action_buttons(false);
    }
}