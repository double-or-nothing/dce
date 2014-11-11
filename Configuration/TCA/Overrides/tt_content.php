<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$newTtContentColumns = array(
	'tx_dce_dce' => array(
		'label' => 'LLL:EXT:dce/Resources/Private/Language/locallang_db.xml:tt_content.tx_dce_dce',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_dce_domain_model_dce',
			'items' => array(
				array('', ''),
			),
			'minitems' => 0,
			'maxitems' => 1,
		),
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $newTtContentColumns);