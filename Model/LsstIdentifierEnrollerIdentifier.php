<?php
/**
 */

class LsstIdentifierEnrollerIdentifier extends AppModel {
  // Add behaviors
  public $actsAs = array('Containable', 'Changelog' => array('priority' => 5));
  
  // Association rules from this model to other models
  public $belongsTo = array("LsstIdentifierEnroller.LsstIdentifierEnroller");
  
  // Default display field for cake generated views
  public $displayField = "label";
  
  // Validation rules for table elements
  public $validate = array(
    'lsst_identifier_enroller_id' => array(
      'rule' => 'numeric',
      'required' => true,
      'allowEmpty' => false
    ),
    'label' => array(
      'rule' => array('validateInput'),
      'required' => true,
      'allowEmpty' => false
    ),
    'description' => array(
      'rule' => array('validateInput'),
      'required' => false,
      'allowEmpty' => true
    ),
    'identifier_type' => array(
      'rule' => array('validateInput'),
      'required' => true,
      'allowEmpty' => false
    ),
    'default_env' => array(
      'rule' => array('validateInput'),
      'required' => false,
      'allowEmpty' => true
    ),
    'ordr' => array(
      'rule' => 'numeric',
      'required' => false,
      'allowEmpty' => true
    )
  );

  /**
   * Obtain the CO ID for a record.
   *
   * @since  COmanage Registry v4.0.0
   * @param  integer Record to retrieve for
   * @return integer Corresponding CO ID, or NULL if record has no corresponding CO ID
   * @throws InvalidArgumentException
   * @throws RunTimeException
   */

  public function findCoForRecord($id) {
    // It's a long walk to the CO...
    
    $args = array();
    $args['conditions']['LsstIdentifierEnrollerIdentifier.id'] = $id;
    $args['contain'] = array(
      'LsstIdentifierEnroller' => array(
        'CoEnrollmentFlowWedge' => array(
          'CoEnrollmentFlow'
        )
      )
    );

    $ef = $this->find('first', $args);

    if(!empty($ef['LsstIdentifierEnroller']['CoEnrollmentFlowWedge']['CoEnrollmentFlow']['co_id'])) {
      return $ef['LsstIdentifierEnroller']['CoEnrollmentFlowWedge']['CoEnrollmentFlow']['co_id'];
    }

    return parent::findCoForRecord($id);
  }
}
