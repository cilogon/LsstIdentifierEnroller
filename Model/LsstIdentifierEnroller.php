<?php
/**
 */

class LsstIdentifierEnroller extends AppModel {
  // Required by COmanage Plugins
  public $cmPluginType = "enroller";
  
  // Document foreign keys
  public $cmPluginHasMany = array();
  
  // Add behaviors
  public $actsAs = array('Containable', 'Changelog' => array('priority' => 5));
  
  // Association rules from this model to other models
  public $belongsTo = array("CoEnrollmentFlowWedge");
  
  public $hasMany = array("LsstIdentifierEnroller.LsstIdentifierEnrollerIdentifier" => array('dependent' => true));
  
  // Default display field for cake generated views
  public $displayField = "co_enrollment_flow_wedge_id";
  
  // Validation rules for table elements
  public $validate = array(
    'co_enrollment_flow_wedge_id' => array(
      'rule' => 'numeric',
      'required' => true,
      'allowEmpty' => false
    )
  );
  
  /**
   * Expose menu items.
   * 
   * @since COmanage Registry v2.0.0
   * @return Array with menu location type as key and array of labels, controllers, actions as values.
   */
  
  public function cmPluginMenus() {
    return array();
  }
}
