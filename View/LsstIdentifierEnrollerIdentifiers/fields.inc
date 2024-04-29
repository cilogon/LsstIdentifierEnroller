<?php
/**
 */

  // Determine if fields are editable
  $e = false;
  
  if(($this->action == "add" && $permissions['add']) || ($this->action == "edit" && $permissions['edit']))
    $e = true;
    
  // We shouldn't get here if we don't have at least read permission, but check just in case
  
  if(!$e && !$permissions['view'])
    return(false);

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

  if($this->action != 'view') {
    // Populate cross references
    print $this->Form->hidden('lsst_identifier_enroller_id', array('default' => $vv_identifier_enroller['LsstIdentifierEnroller']['id'])) . "\n";
  }
?>
<ul id="<?php print $this->action; ?>lsst_identifier_enroller_identifier" class="fields form-list">
  <li>
    <div class="field-name">
      <div class="field-title">
        <?php print $this->Form->label('label', _txt('fd.label')); ?>
        <span class="required">*</span>
      </div>
      <div class="field-desc"><?php print _txt('pl.lsstidentifierenroller.label.desc'); ?></div>
    </div>
    <div class="field-info">
      <?php print ($e ? $this->Form->input('label') : filter_var($lsst_identifier_enroller_identifiers[0]['LsstIdentifierEnrollerIdentifier']['label'],FILTER_SANITIZE_SPECIAL_CHARS)); ?>
    </div>
  </li>
  <li>
    <div class="field-name">
      <div class="field-title">
        <?php print $this->Form->label('description', _txt('fd.desc')); ?>
      </div>
      <div class="field-desc"><?php print _txt('pl.lsstidentifierenroller.description.desc'); ?></div>
    </div>
    <div class="field-info">
      <?php print ($e ? $this->Form->input('description') : filter_var($lsst_identifier_enroller_identifiers[0]['LsstIdentifierEnrollerIdentifier']['description'],FILTER_SANITIZE_SPECIAL_CHARS)); ?>
    </div>
  </li>
  <li>
    <div class="field-name">
      <div class="field-title">
        <?php print _txt('pl.lsstidentifierenroller.idtype'); ?>
        <span class="required">*</span>
      </div>
    </div>
    <div class="field-info">
      <?php
        $attrs = array();
        $attrs['value'] = (isset($lsst_identifier_enroller_identifiers[0]['LsstIdentifierEnrollerIdentifier']['identifier_type'])
                           ? $lsst_identifier_enroller_identifiers[0]['LsstIdentifierEnrollerIdentifier']['identifier_type']
                           : null);
        $attrs['empty'] = true;

        if($e) {
          print $this->Form->select('identifier_type',
                                    $vv_identifier_types,
                                    $attrs);

          if($this->Form->isFieldError('identifier_type')) {
            print $this->Form->error('identifier_type');
          }
        } else {
          if(!empty($lsst_identifier_enroller_identifiers[0]['LsstIdentifierEnrollerIdentifier']['identifier_type'])) {
            print $vv_identifier_types[ $lsst_identifier_enroller_identifiers[0]['LsstIdentifierEnrollerIdentifier']['identifier_type'] ];
          }
        }
      ?>
    </div>
  </li>  
  <li>
    <div class="field-name">
      <div class="field-title">
        <?php print $this->Form->label('default_env', _txt('fd.ea.default_env')); ?>
      </div>
      <div class="field-desc"><?php print _txt('fd.ea.default_env.desc'); ?></div>
    </div>
    <div class="field-info">
      <?php print ($e ? $this->Form->input('default_env') : filter_var($lsst_identifier_enroller_identifiers[0]['LsstIdentifierEnrollerIdentifier']['default_env'],FILTER_SANITIZE_SPECIAL_CHARS)); ?>
    </div>
  </li>
  <li>
    <div class="field-name">
      <div class="field-title">
        <?php print ($e ? $this->Form->label('ordr', _txt('fd.order')) : _txt('fd.order')); ?>
      </div>
    </div>
    <div class="field-info">
      <?php print ($e
                   ? $this->Form->input('ordr')
                   : filter_var($lsst_identifier_enroller_identifiers[0]['LsstIdentifierEnrollerIdentifier']['ordr'],FILTER_SANITIZE_SPECIAL_CHARS)); ?>
    </div>
  </li>
  <?php if($e): ?>
  <li class="fields-submit">
    <div class="field-name">
      <span class="required"><?php print _txt('fd.req'); ?></span>
    </div>
    <div class="field-info">
      <?php print $this->Form->submit($submit_label); ?>
    </div>
  </li>
  <?php endif; ?>
</ul>

<?php
  print $this->element("changelog");