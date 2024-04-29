<?php
/**
 */
  
global $cm_lang, $cm_texts;

// When localizing, the number in format specifications (eg: %1$s) indicates the argument
// position as passed to _txt.  This can be used to process the arguments in
// a different order than they were passed.

$cm_lsst_identifier_enroller_texts['en_US'] = array(
  // Titles, per-controller
  'ct.lsst_identifier_enroller_identifiers.1'  => 'LSST Identifier Enroller Identifier',
  'ct.lsst_identifier_enroller_identifiers.pl' => 'LSST Identifier Enroller Identifiers',
  'ct.lsst_identifier_enrollers.1'             => 'LSST Identifier Enroller',
  'ct.lsst_identifier_enrollers.pl'            => 'LSST Identifier Enrollers',
  
  // Error messages
//  'er.identifierenroller.read' => 'Cannot open source file "%1$s" for reading',
  
  // Plugin texts
  'pl.lsstidentifierenroller.description.desc' => 'Description rendered when requesting a value for this Identifier',
  'pl.lsstidentifierenroller.idtype' =>   'Identifier Type',
  'pl.lsstidentifierenroller.label.desc' => 'Label rendered when requesting a value for this Identifier',
  'pl.lsstidentifierenroller.selected' => 'Identifier "%1$s" (%2$s) selected',
);
