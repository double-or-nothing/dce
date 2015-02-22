<?php
namespace ArminVieweg\Dce\XClass;

/**
 * Class DataPreprocessor
 */
class DataPreprocessor extends \TYPO3\CMS\Backend\Form\DataPreprocessor {
	static protected $staticDceConfiguration = NULL;
	static protected $lastField = NULL;

	/**
	 * @var \DceTeam\Dce\Utility\StaticDce
	 */
	static protected $staticDceUtility = NULL;

	/**
	 * Constructor
	 */
	public function __construct() {
		static::$staticDceUtility = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('ArminVieweg\Dce\Utility\StaticDce');
	}

	public function fetchRecord($table, $idList, $operation) {
		if ($table === 'tx_dce_domain_model_dce' && !is_numeric($idList)) {
				// DCE record
			$realIdentifier = substr($idList, 4);
			$staticDceValues = static::$staticDceUtility->getStaticDce($realIdentifier);
			static::$staticDceConfiguration = array_merge($staticDceValues, array('uid' => $idList, 'type' => 1));
			$this->renderRecord($table, $idList, 0, static::$staticDceConfiguration);
			header('X-XSS-Protection: 0');
		} else if ($table === 'tx_dce_domain_model_dcefield' && !is_numeric($idList) && static::$staticDceConfiguration !== NULL) {
			if (isset(static::$staticDceConfiguration['fields'][$idList])) {
					// Normal fields
				$row = static::$staticDceConfiguration['fields'][$idList];
				static::$lastField = $idList;
			} else {
					// Section fields (sub)
				if (isset(static::$staticDceConfiguration['fields'][static::$lastField]['section_fields'][$idList])) {
					$row = static::$staticDceConfiguration['fields'][static::$lastField]['section_fields'][$idList];
					if (!isset($row['type'])) {
						$row['type'] = 0;
					}
				}
			}
			$row = $this->resetIndention(array_merge($row, array('uid' => $idList, 'variable' => $idList)));
			$this->renderRecord($table, $idList, 0, $row);
		} else {
			parent::fetchRecord($table, $idList, $operation);
		}
	}

	/**
	 * Resets indention of given row's configuration
	 *
	 * @param array $row
	 * @return array
	 */
	protected function resetIndention($row) {
		if (isset($row['configuration'])) {
			$smallestDifference = 1000;
			foreach (explode("\n", $row['configuration']) as $configurationLine) {
				$difference = strlen($configurationLine) - strlen(ltrim($configurationLine, "\t"));
				if ($difference > 0 && $difference < $smallestDifference) {
					$smallestDifference = $difference;
				}
			}
			$lines = array();
			foreach (explode("\n", $row['configuration']) as $configurationLine) {
				$lines[] = substr($configurationLine, $smallestDifference);
			}
			$row['configuration'] = trim(implode("\n", $lines), "\n");
		}
		return $row;
	}

	public function renderRecord_inlineProc($data, $fieldConfig, $TSconfig, $table, $row, $field) {
		if (isset($row['uid']) && $table === 'tx_dce_domain_model_dce' && strpos($row['uid'], 'dce_') === 0) {
			if ($field === 'fields') {
				return implode(',', array_keys($row[$field]));
			}
		} else if ($field === 'section_fields' && isset($row['section_fields']) && is_array($row['section_fields'])) {
			return implode(',', array_keys($row['section_fields']));
		}
		return parent::renderRecord_inlineProc($data, $fieldConfig, $TSconfig, $table, $row, $field);
	}
}