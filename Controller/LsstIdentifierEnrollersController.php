<?php
/**
 */

App::uses("SEWController", "Controller");

class LsstIdentifierEnrollersController extends SEWController {
  // Class name, used by Cake
  public $name = "LsstIdentifierEnrollers";
  
  // Establish pagination parameters for HTML views
  public $paginate = array(
    'limit' => 25,
    'order' => array(
      'co_enrollment_flow_wedge_id' => 'asc'
    )
  );
  
  /**
   * Authorization for this Controller, called by Auth component
   * - precondition: Session.Auth holds data used for authz decisions
   * - postcondition: $permissions set with calculated permissions
   *
   * @since  COmanage Registry v4.0.0
   * @return Array Permissions
   */
  
  function isAuthorized() {
    $roles = $this->Role->calculateCMRoles();
    
    // Construct the permission set for this user, which will also be passed to the view.
    $p = array();
    
    // Determine what operations this user can perform
    
    // Delete an existing Identifier Enroller?
    $p['delete'] = ($roles['cmadmin'] || $roles['coadmin']);
    
    // Edit an existing Identifier Enroller?
    $p['edit'] = ($roles['cmadmin'] || $roles['coadmin']);
    
    // View all existing Identifier Enroller?
    $p['index'] = ($roles['cmadmin'] || $roles['coadmin']);
    
    // View an existing Identifier Enroller?
    $p['view'] = ($roles['cmadmin'] || $roles['coadmin']);
    
    $this->set('permissions', $p);
    return($p[$this->action]);
  }
}
