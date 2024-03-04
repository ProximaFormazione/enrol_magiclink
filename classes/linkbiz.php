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

class enrol_magiclink_linkbiz {

    public static function get_link_by_courseid_linkidentifier(int $courseid, string $linkidentifier){
        global $DB;

        return $DB->get_record('enrol_magiclink_link', ['courseid' => $courseid, 'linkidentifier' => $linkidentifier]);
    }

    public static function get_links_by_courseid(int $courseid){
        global $DB;

        return $DB->get_records('enrol_magiclink_link', ['courseid' => $courseid]);
    }

    public static function insert_link_by_identifier_courseid (int $courseid, string $linkidentifier){
        global $DB;

        $tosave = new stdClass();
        $tosave->linkidentifier = $linkidentifier;
        $tosave->courseid = $courseid;

        $DB->insert_record(
            'enrol_magiclink_link',
            $tosave
        );
    }

    public static function delete_link_by_id(int $id){
        global $DB;

        $DB->delete_records('enrol_magiclink_link',['id' => $id]);
    }

    public static function get_linkurl_by_identifier_courseid(int $courseid, string $linkidentifier){
        $murl = new moodle_url('/enrol/magiclink/enrol.php',['courseid'=>$courseid,'linkidentifier'=>$linkidentifier]);
        return $murl->out();
    }

}