<?php
/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Organisationactivities_Form_OrganisationactivitiesSettings extends CRM_Core_Form {
    const RELATIONSHIP_TYPE_CONFIG_NAME = 'organisationactivities_relationship_type';
    const CONTACT_TYPE_CONFIG_NAME = 'organisationactivities_contact_type';

    private $_settingFilter = array('group' => 'organisationactivities');

    //everything from this line down is generic & can be re-used for a setting form in another extension
    private $_submittedValues = array();
    private $_settings = array();

    function buildQuickForm() {

        $settings = $this->getFormSettings();

        $this->addElement(
            'select',
            self::RELATIONSHIP_TYPE_CONFIG_NAME,
            'Relationship Type',
            $this->GetRelationshipTypes(),
            true
        );

        $this->addElement(
            'select',
            self::CONTACT_TYPE_CONFIG_NAME,
            'Contact Type',
            $this->GetContactTypes(),
            true
        );

        $this->_elements[2]->setSelected($settings['relationship_type_id']);
        $this->_elements[3]->setSelected($settings['contact_type_id']);

    /*
    foreach ($settings as $name => $setting) {
      if (isset($setting['quick_form_type'])) {
        $add = 'add' . $setting['quick_form_type'];
        if ($add == 'addElement') {
          $this->$add($setting['html_type'], $name, ts($setting['title']), CRM_Utils_Array::value('html_attributes', $setting, array ()));
        }
        else {
          $this->$add($name, ts($setting['title']));
        }
        $this->assign("{$setting['description']}_description", ts('description'));
      }
      }*/

    $this->addButtons(array(
      array (
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      )
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }
  function postProcess() {
    $this->_submittedValues = $this->exportValues();
    $this->saveSettings();
    parent::postProcess();
  }
  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons". These
    // items don't have labels. We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }
  /**
   * Get the settings we are going to allow to be set on this form.
   *
   * @return array
   */
  function getFormSettings() {
    $relationshipTypeSettings = Civi::settings()->get(self::RELATIONSHIP_TYPE_CONFIG_NAME);
    $contactTypeSettings = Civi::settings()->get(self::CONTACT_TYPE_CONFIG_NAME);

    $settings = array(
        'relationship_type_id' => $relationshipTypeSettings,
        'contact_type_id' => $contactTypeSettings,
    );

    return $settings;
  }
  /**
   * Get the settings we are going to allow to be set on this form.
   *
   * @return array
   */
  function saveSettings() {
    Civi::settings()->set(
        self::RELATIONSHIP_TYPE_CONFIG_NAME,
        $this->_submittedValues[self::RELATIONSHIP_TYPE_CONFIG_NAME]
    );

    Civi::settings()->set(
        self::CONTACT_TYPE_CONFIG_NAME,
        $this->_submittedValues[self::CONTACT_TYPE_CONFIG_NAME]
    );
  }
  /**
   * Set defaults for form.
   *
   * @see CRM_Core_Form::setDefaultValues()
   */
  function setDefaultValues() {
    /*
    return ;
    $existing = civicrm_api3('setting', 'get', array('return' => array_keys($this->getFormSettings())));
    $defaults = array();
    $domainID = CRM_Core_Config::domainID();
    foreach ($existing['values'][$domainID] as $name => $value) {
      $defaults[$name] = $value;
    }
    return $defaults;
    */
  }

    function GetContactTypes() {
        $values =  CRM_Core_DAO::executeQuery("SELECT id, name FROM civicrm_contact_type;")->fetchAll();

        $_contactTypes = array();

        foreach($values as $contactType) {
            $_contactTypes[$contactType['id']] = $contactType['name'];
        }

        return $_contactTypes;
    }

    function GetRelationshipTypes() {
        $values = CRM_Core_DAO::executeQuery("SELECT id, CONCAT(label_b_a, '/', label_a_b) AS name FROM civicrm_relationship_type;")->fetchAll();

        $_relationshipTypes = array();

        foreach($values as $relationshipType) {
            $_relationshipTypes[$relationshipType['id']] = $relationshipType['name'];
        }

        return $_relationshipTypes;
    }
}
