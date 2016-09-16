<?php
/**
 * This class contains all the function that are called using AJAX (jQuery)
 */
class CRM_Organisationactivities_Page_AJAX {
  public static function getContactActivity() {
    $requiredParameters = array(
      'cid' => 'Integer',
    );

    $optionalParameters = array(
      'context' => 'String',
      'activity_type_id' => 'Integer',
      'activity_type_exclude_id' => 'Integer',
    );

    $params = CRM_Core_Page_AJAX::defaultSortAndPagerParams();
    $params += CRM_Core_Page_AJAX::validateParams($requiredParameters, $optionalParameters);

    // To be consistent, the cid parameter should be renamed to contact_id in
    // the template file, see templates/CRM/Activity/Selector/Selector.tpl
    $params['contact_id'] = $params['cid'];
    unset($params['cid']);

    // get the contact activities

    $configCustomerType = self::getConfiguredOrganisationActivitiesContactType();
    $configRelationshipType = self::getConfiguredOrganisationActivitiesRelationshipType();

    $ids = self::getOrganisationRelationsByType($params['contact_id'], $configCustomerType, $configRelationshipType);

    $activities = array('data' => array());
    foreach ($ids as $id) {
        $params['contact_id'] = $id;
        $_activities = CRM_Activity_BAO_Activity::getContactActivitySelector($params);

        if (count($activities['data']) == 0) {
            $activities = $_activities;
        } else {
            array_push($activities['data'], $_activities['data']);
        }
    }

    if (!empty($_GET['is_unit_test'])) {
      return $activities;
    }

    foreach ($activities['data'] as $key => $value) {
      // Check if recurring activity.
      if (!empty($value['is_recurring_activity'])) {
        $repeat = $value['is_recurring_activity'];
        $activities['data'][$key]['activity_type'] .= '<br/><span class="bold">' . ts('Repeating (%1 of %2)', array(1 => $repeat[0], 2 => $repeat[1])) . '</span>';
      }
    }

    // store the activity filter preference CRM-11761
    $session = CRM_Core_Session::singleton();
    $userID = $session->get('userID');
    if ($userID) {
      $activityFilter = array(
        'activity_type_filter_id' => empty($params['activity_type_id']) ? '' : CRM_Utils_Type::escape($params['activity_type_id'], 'Integer'),
        'activity_type_exclude_filter_id' => empty($params['activity_type_exclude_id']) ? '' : CRM_Utils_Type::escape($params['activity_type_exclude_id'], 'Integer'),
      );

      /**
       * @var \Civi\Core\SettingsBag $cSettings
       */
      $cSettings = Civi::service('settings_manager')->getBagByContact(CRM_Core_Config::domainID(), $userID);
      $cSettings->set('activity_tab_filter', $activityFilter);
    }

    CRM_Utils_JSON::output($activities);
  }

  public static function getOrganisationRelationsByType($contactId, $customerType, $relationshipType)
  {
      $apiParams = array(
          'version' => 3,
          'contact_id_b' => $contactId,
      );

      $apiResult = civicrm_api('Relationship', 'Get', $apiParams);

      $ids = array();

      if (!civicrm_error($apiResult)) {
            $relations = $apiResult['values'];

            foreach($relations as $relation) {
                
                if ((int)$relation['relationship_type_id'] ==  (int)$relationshipType) {
                    $apiParams = array(
                        'version' => 3,
                        'id' => $relation['contact_id_a'],
                    );

                    $apiResult = civicrm_api('Contact', 'Get', $apiParams);

                    if (!civicrm_error($apiResult)) {
                        $contact = array_shift($apiResult['values']);

                        if ($contact['contact_type'] == $customerType) {

                            array_push($ids, $contact['contact_id']);
                        }

                    }
                }
            }
      }

      return $ids;
  }


  public static function getConfiguredOrganisationActivitiesContactType()
  {
        $values = CRM_Core_DAO::executeQuery("SELECT id, label FROM civicrm_contact_type;")->fetchAll();

        $_contactTypes = array();

        foreach($values as $contactType) {
            $_contactTypes[$contactType['id']] = $contactType['label'];
        }

        return $_contactTypes[Civi::settings()->get('organisationactivities_contact_type')];
  }

  public static function getConfiguredOrganisationActivitiesRelationshipType()
  {
        return Civi::settings()->get('organisationactivities_relationship_type');
  }

}
