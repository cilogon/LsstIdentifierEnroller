<!--
/**
 */
-->
<?php
  if(!$this->action != 'add') {
    // Attach Identifiers to this Enroller
    
    $params['topLinks'][] = $this->Html->link(
      _txt('op.manage-a', array(_txt('ct.lsst_identifier_enroller_identifiers.pl'))),
      array(
        'plugin'        => 'lsst_identifier_enroller',
        'controller'    => 'lsst_identifier_enroller_identifiers',
        'action'        => 'index',
        'ieid'          => $lsst_identifier_enrollers[0]['LsstIdentifierEnroller']['id']
      ),
      array(
        'class'   => 'editbutton'
      )
    );
  }
