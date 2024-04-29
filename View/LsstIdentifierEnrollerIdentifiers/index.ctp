<?php
/**
 */

  // Add breadcrumbs
  print $this->element("coCrumb");

  $args = array();
  $args['plugin'] = null;
  $args['controller'] = 'co_enrollment_flows';
  $args['action'] = 'index';
  $args['co'] = $cur_co['Co']['id'];
  $this->Html->addCrumb(_txt('ct.co_enrollment_flows.pl'), $args);

  $args = array();
  $args['plugin'] = null;
  $args['controller'] = 'co_enrollment_flows';
  $args['action'] = 'edit';
  $args[] = $vv_identifier_enroller['CoEnrollmentFlowWedge']['co_enrollment_flow_id'];
  $this->Html->addCrumb($vv_identifier_enroller['CoEnrollmentFlowWedge']['CoEnrollmentFlow']['name'], $args);

  $args = array();
  $args['plugin'] = null;
  $args['controller'] = 'co_enrollment_flow_wedges';
  $args['action'] = 'index';
  $args['coef'] = $vv_identifier_enroller['CoEnrollmentFlowWedge']['co_enrollment_flow_id'];
  $args[] = $vv_identifier_enroller['CoEnrollmentFlowWedge']['id'];
  $this->Html->addCrumb(_txt('ct.co_enrollment_flow_wedges.pl'), $args);

  $args = array();
  $args['plugin'] = null;
  $args['controller'] = 'co_enrollment_flow_wedges';
  $args['action'] = 'edit';
  $args[] = $vv_identifier_enroller['CoEnrollmentFlowWedge']['id'];
  $this->Html->addCrumb($vv_identifier_enroller['CoEnrollmentFlowWedge']['description'], $args);

  $crumbTxt = _txt('ct.lsst_identifier_enroller_identifiers.pl');
  $this->Html->addCrumb($crumbTxt);
  
  // Add page title
  $params = array();
  $params['title'] = $title_for_layout;

  // Add top links
  $params['topLinks'] = array();

  if($permissions['add']) {
    $params['topLinks'][] = $this->Html->link(
      _txt('op.add-a', array(_txt('ct.lsst_identifier_enroller_identifiers.1'))),
      array(
        'plugin'     => 'lsst_identifier_enroller',
        'controller' => 'lsst_identifier_enroller_identifiers',
        'action'     => 'add',
        'ieid'       => $vv_identifier_enroller['LsstIdentifierEnroller']['id']
      ),
      array('class' => 'addbutton')
    );
  }
  
  print $this->element("pageTitleAndButtons", $params);
?>

<div class="table-container">
  <table id="lsst_identifier_enroller_identifiers">
    <thead>
      <tr>
        <th><?php print $this->Paginator->sort('label', _txt('fd.label')); ?></th>
        <th><?php print $this->Paginator->sort('ordr', _txt('fd.order')); ?></th>
        <th><?php print _txt('fd.actions'); ?></th>
      </tr>
    </thead>

    <tbody>
      <?php $i = 0; ?>
      <?php foreach($lsst_identifier_enroller_identifiers as $e): ?>
      <tr class="line<?php print ($i % 2)+1; ?>">
        <td>
          <?php
            print $this->Html->link($e['LsstIdentifierEnrollerIdentifier']['label'],
                                    array(
                                      'plugin' => 'lsst_identifier_enroller',
                                      'controller' => 'lsst_identifier_enroller_identifiers',
                                      'action' => ($permissions['edit'] ? 'edit' : ($permissions['view'] ? 'view' : '')),
                                      $e['LsstIdentifierEnrollerIdentifier']['id']));
          ?>
        </td>
        <td>
          <?php
            if(!empty($e['LsstIdentifierEnrollerIdentifier']['ordr'])) {
              print filter_var($e['LsstIdentifierEnrollerIdentifier']['ordr'], FILTER_SANITIZE_SPECIAL_CHARS);
            }
          ?>
        </td>
        <td>
          <?php
            if($permissions['edit']) {
              print $this->Html->link(_txt('op.edit'),
                                      array('plugin' => 'lsst_identifier_enroller',
                                            'controller' => 'lsst_identifier_enroller_identifiers',
                                            'action' => 'edit',
                                            $e['LsstIdentifierEnrollerIdentifier']['id']),
                                      array('class' => 'editbutton')) . "\n";
            }
            
            if($permissions['delete']) {
              print '<button type="button" class="deletebutton" title="' . _txt('op.delete')
                . '" onclick="javascript:js_confirm_generic(\''
                . _txt('js.remove') . '\',\''    // dialog body text
                . $this->Html->url(              // dialog confirm URL
                  array(
                    'plugin' => 'lsst_identifier_enroller',
                    'controller' => 'lsst_identifier_enroller_identifiers',
                    'action' => 'delete',
                    $e['LsstIdentifierEnrollerIdentifier']['id'],
                    'ieid' => $e['LsstIdentifierEnrollerIdentifier']['lsst_identifier_enroller_id']
                  )
                ) . '\',\''
                . _txt('op.remove') . '\',\''    // dialog confirm button
                . _txt('op.cancel') . '\',\''    // dialog cancel button
                . _txt('op.remove') . '\',[\''   // dialog title
                . filter_var(_jtxt($e['LsstIdentifierEnrollerIdentifier']['label']),FILTER_SANITIZE_STRING)  // dialog body text replacement strings
                . '\']);">'
                . _txt('op.delete')
                . '</button>';
            }
          ?>
          <?php ; ?>
        </td>
      </tr>
      <?php $i++; ?>
      <?php endforeach; ?>
    </tbody>

  </table>
</div>

<?php
  print $this->element("pagination");