<?php
/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2013
 * $Id$
 *
 */
/*
 * Settings metadata file
 */
return array(
  'organisationactivities_contact_type' => array(
    'group_name' => 'Organisation Activities Preferences',
    'group' => 'organisationactivities',
    'name' => 'organisationactivities_contact_type',
    'type' => 'Array',
    'default' => NULL,
    'add' => '4.7',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => 'Relationship type which will be filtered in Organisation Actitvities tab',
    'help_text' => 'Select the relationship type',
    'html_type' => 'select',
  ),
  'organisationactivities_relationship_type' => array(
    'group_name' => 'Organisation Activities Preferences',
    'group' => 'organisationactivities',
    'name' => 'organisationactivities_relationship_type',
    'type' => 'Array',
    'default' => NULL,
    'add' => '4.7',
    'is_domain' => 1,
    'is_contact' => 0,
    'description' => 'Contact which will be filtered in Organisation Activities tab',
    'help_text' => 'Select the contact type',
    'html_type' => 'select'
  ),
 );
