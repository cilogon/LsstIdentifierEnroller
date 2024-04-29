<?php
/**
 */

App::uses('CoPetitionsController', 'Controller');

class LsstIdentifierEnrollerCoPetitionsController extends CoPetitionsController {
  // Class name, used by Cake
  public $name = "LsstIdentifierEnrollerCoPetitions";

  public $uses = array("CoPetition",
                       "LsstIdentifierEnroller.LsstIdentifierEnroller");
  
  /**
   */
  
  protected function execute_plugin_petitionerAttributes($id, $onFinish) {
    // Pull our config to see if we have any identifiers to collect
    
    $efwid = $this->viewVars['vv_efwid'];
    
    $args = array();
    $args['conditions']['LsstIdentifierEnroller.co_enrollment_flow_wedge_id'] = $efwid;
    $args['contain'] = array('LsstIdentifierEnrollerIdentifier');
    
    $identifiers = $this->LsstIdentifierEnroller->find('first', $args);

    if(empty($identifiers['LsstIdentifierEnrollerIdentifier'])) {
      // There are no attributes to collect, redirect
      $this->redirect($onFinish);
    }

    // Get the CO Person ID
    $coPersonId = $this->CoPetition->field('enrollee_co_person_id', array('CoPetition.id' => $id));

    // Get the CoPerson Identifiers.
    // If we already have a type of identifier that matches the one controlled by the plugin instance
    // skip
    $args = array();
    $args['conditions']['Identifier.co_person_id'] = $coPersonId;
    $args['contain'] = false;
    $pidentifiers = $this->CoPetition->EnrolleeCoPerson->Identifier->find('all', $args);

    foreach ($pidentifiers as $ident) {
      foreach ($identifiers['LsstIdentifierEnrollerIdentifier'] as $idx => $ie) {
        if($ident['Identifier']['type'] == $ie['identifier_type']) {
          unset($identifiers['LsstIdentifierEnrollerIdentifier'][$idx]);
        }
      }
    }

    if(empty($identifiers['LsstIdentifierEnrollerIdentifier'])) {
      // There are no attributes to collect, redirect
      $this->redirect($onFinish);
    }

    if($this->request->is('post')) {
      // Post, process the request

      // Walk through the list of configured identifiers and save any we find.
      // (While the form enforces "required", we don't bother here -- it's not even clear if we should.)

      // Run everything in a single transaction. If any identifier fails to save,
      // we want the form to rerender, and the easiest thing is to make all
      // identifiers editable (rather than just whichever failed).

      $dbc = $this->CoPetition->EnrolleeCoPerson->Identifier->getDataSource();
      $dbc->begin();

      $err = false;

      $this->log("FOO identifier is " . print_r($identifiers, true));

      foreach($identifiers['LsstIdentifierEnrollerIdentifier'] as $ie) {
        if(empty($this->request->data['CoPetition'][ $ie['id'] ])) {
          continue;
        }

        // For simplicity in form management, the identifiers are submitted under 'CoPetition'
        // We have the type and the proposed identifier

        $identifier = array(
          'Identifier' => array(
            'identifier'   => $this->request->data['CoPetition'][ $ie['id'] ],
            'type'         => $ie['identifier_type'],
            'login'        => false,
            'co_person_id' => $coPersonId,
            'status'       => SuspendableStatusEnum::Active
          )
        );

        try {
          $this->CoPetition->EnrolleeCoPerson->Identifier->create();
          $this->CoPetition->EnrolleeCoPerson->Identifier->save($identifier, array('provision' => false));

          // Create some history
          $actorCoPersonId = $this->Session->read('Auth.User.co_person_id');

          $txt = _txt('pl.lsstidentifierenroller.selected',
                      array($this->request->data['CoPetition'][ $ie['id'] ],
                        $ie['identifier_type']));

          $this->CoPetition->EnrolleeCoPerson->HistoryRecord->record($coPersonId,
                                                                     null,
                                                                     null,
                                                                     $actorCoPersonId,
                                                                     ActionEnum::CoPersonEditedManual,
                                                                     $txt);

          $this->CoPetition->CoPetitionHistoryRecord->record($id,
                                                             $actorCoPersonId,
                                                             PetitionActionEnum::AttributesUpdated,
                                                             $txt);
        } catch(Exception $e) {
          $dbc->rollback();
          $err = true;
          $this->Flash->set($e->getMessage(), array('key' => 'error'));
          break;
        }
      } // foreach

      if(!$err) {
        // We're done, commit and redirect
        $dbc->commit();
        $this->redirect($onFinish);
      }

    } // is POST

    // We have some identifiers, render a form
    $this->set('vv_identifiers', $identifiers['LsstIdentifierEnrollerIdentifier']);

    // Check for default ENV
    $default_env = Hash::combine($identifiers['LsstIdentifierEnrollerIdentifier'], '{n}.id', '{n}.default_env');
    $default_env_values = array();
    foreach($default_env as $idx => $env_key) {
      $default_env_values[$idx] = getenv($env_key);
    }

    $this->set('vv_default_env', $default_env);
    $this->set('vv_default_env_values', $default_env_values);
  }
}
