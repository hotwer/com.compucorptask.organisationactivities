<?php

require_once 'organisationactivities.civix.php';

// clear cachces
//CRM_Core_Config::clearDBCache();


/**
* Debugging tool
* Dump and Die
*/
function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function organisationactivities_civicrm_config(&$config) {

    _organisationactivities_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function organisationactivities_civicrm_xmlMenu(&$files) {
    _organisationactivities_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function organisationactivities_civicrm_install() {
  _organisationactivities_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function organisationactivities_civicrm_uninstall() {
  _organisationactivities_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function organisationactivities_civicrm_enable() {
  _organisationactivities_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function organisationactivities_civicrm_disable() {
  _organisationactivities_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function organisationactivities_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _organisationactivities_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function organisationactivities_civicrm_managed(&$entities) {
  _organisationactivities_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * @param array $caseTypes
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function organisationactivities_civicrm_caseTypes(&$caseTypes) {
  _organisationactivities_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function organisationactivities_civicrm_angularModules(&$angularModules) {
_organisationactivities_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function organisationactivities_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _organisationactivities_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/*
 * Implements hook_civicrm_alterMenu().
 *
 * @link https://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterMenu
 *
function organisationactivities_civicrm_alterMenu(&$items) {
    $items['civicrm/organisationactivities'] = array(
        'page_callback' => 'CRM_Organisationactivities_Page_OrganisationActivities',
        'access_arguments' => array(array('access CiviCRM'), "and"),
    );
} // */

/*
 * Functions below this ship commented out. Uncomment as required.
 *
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function organisationactivities_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 */
function organisationactivities_civicrm_navigationMenu(&$menu) {

    $lastNavigationId = CRM_Core_DAO::singleValueQuery("SELECT max(id) FROM civicrm_navigation");

    if (is_numeric($lastNavigationId)) {
        $lastNavigationId = ((int)$lastNavigationId) + 1;
    }

    $administerNavigationId = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_Navigation', 'Administer', 'id', 'name');

    if (is_numeric($administerNavigationId)) {
        $menu[$administerNavigationId]['child'][(int)$lastNavigationId] = array(
            'attributes' => array (
                'label' => ts('Organisation Activities', array('domain' => 'com.compucorptask.organisationactivities')),
                'url' => 'civicrm/organisationactivities/settings',
                'permission' => null,
                'operator' => null,
                'separator' => 1,
                'parentID' => $administerNavigationId,
                'navID' => $lastNavigationId,
                'active' => 1
            )
        );
    }

    _organisationactivities_civix_navigationMenu($menu);
} // */

/**
 * Implements hook_civicrm_tabset().
 *
 * @link https://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_tabset
 */
function organisationactivities_civicrm_tabset($tabsetName, &$tabs, $context) {
    if ($tabsetName == 'civicrm/contact/view') {
        $contactId = $context['contact_id'];

        $apiResult = civicrm_api('Contact', 'Get', array('id' => $contactId, 'version' => 3));

        $contact = array_shift($apiResult['values']);

        if ($contact['contact_type'] == 'Organization') {


            $url = CRM_Utils_System::url(
                'civicrm/organisationactivities',
                "reset=1&snippet=1&force=1&cid=$contactId"
            );

            $tabs[] = array('id' => 'organisationActivities',
                'url' => $url,
                'title' => 'Organisation Activities',
                'weight' => 300,
            );
        }
    }
}
