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

function xmldb_enrol_magiclink_upgrade($oldversion) {
    global $DB;
 
    $dbman = $DB->get_manager();

    if ($oldversion < 2024022801) {

        // Define table enrol_magiclink_link to be created.
        $table = new xmldb_table('enrol_magiclink_link');

        // Adding fields to table enrol_magiclink_link.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('linkidentifier', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table enrol_magiclink_link.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('fk_courseid', XMLDB_KEY_FOREIGN, ['courseid'], 'course', ['id']);

        // Adding indexes to table enrol_magiclink_link.
        $table->add_index('iu__linkidentifier_courseid', XMLDB_INDEX_UNIQUE, ['linkidentifier', 'courseid']);

        // Conditionally launch create table for enrol_magiclink_link.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Magiclink savepoint reached.
        upgrade_plugin_savepoint(true, 2024022801, 'enrol', 'magiclink');
    }


    return true;
}