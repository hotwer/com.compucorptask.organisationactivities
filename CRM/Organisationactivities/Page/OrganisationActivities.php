<?php

require_once 'CRM/Core/Page.php';

class CRM_Organisationactivities_Page_OrganisationActivities extends CRM_Core_Page {

    public function run() {
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this);

        $this->assign('admin', FALSE);
        $this->assign('context', 'activity');
        $this->assign('contactId', $contactId);

        // also create the form element for the activity filter box
        $controller = new CRM_Core_Controller_Simple(
          'CRM_Activity_Form_ActivityFilter',
          ts('Activity Filter'),
          NULL,
          FALSE, FALSE, TRUE
        );
        $controller->set('contactId', $contactId);
        $controller->setEmbedded(TRUE);
        $controller->run();

        $this->ajaxResponse['tabCount'] = $this->getOrganisationRelationshipsActitvities($contactId);

        parent::run();
    }

    protected function getOrganisationRelationshipsActitvities($contactId) {
        $apiParams = array(
            'version' => 3,
            'contact_id_b' => $contactId,
        );

        $apiResult = civicrm_api('Relationship', 'Get', $apiParams);

        $activities = 0;

        if (!civicrm_error($apiResult)) {
            $relations = $apiResult['values'];
            
            foreach($relations as $relation) {
                $apiParams = array(
                    'version' => 3,
                    'id' => $relation['contact_id_a'],
                );

                $apiResult = civicrm_api('Contact', 'Get', $apiParams);

                if (!civicrm_error($apiResult)) {
                    $contact = array_shift($apiResult['values']);

                    if ($contact['contact_type'] == 'Individual') {

                        $apiParams = array(
                            'version' => 3,
                            'contact_id' => $relation['contact_id_a'],
                        );

                        $apiResult = civicrm_api('Activity', 'Get', $apiParams);

                        if (!civicrm_error($apiResult)) {
                            $activities += count($apiResult['values']);
                        }

                    }

                }
            }
        }

        return $activities;;

    }


}
