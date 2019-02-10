<?php
namespace T3\Dce\UserFunction\CustomLabels;

/*  | This extension is made for TYPO3 CMS and is licensed
 *  | under GNU General Public License.
 *  |
 *  | (c) 2012-2019 Armin Vieweg <armin@v.ieweg.de>
 */
use T3\Dce\Domain\Model\DceField;
use T3\Dce\Utility\LanguageService;

/**
 * Extends TCA label of fields with variable key
 */
class DceFieldLabel
{
    /**
     * User function to get custom labels for DCE fields
     * to show available variable name after title.
     *
     * It also respects section fields and child fields inside of sections
     * and marks them with a blue "n", which indicates that the section
     * variable contains an array with n records.
     *
     * @param array $parameter
     * @return void
     */
    public function getLabel(array &$parameter) : void
    {
        if (!isset($parameter['row']['variable']) || empty($parameter['row']['variable'])) {
            $parameter['title'] = LanguageService::sL($parameter['row']['title']);
            return;
        }
        if (!$this->isSectionChildField($parameter)) {
            if (!$this->isSectionField($parameter)) {
                if ($this->isTab($parameter)) {
                    // Tab
                    $parameter['title'] = LanguageService::sL($parameter['row']['title']);
                } else {
                    // Standard field
                    $parameter['title'] = LanguageService::sL($parameter['row']['title']) .
                        ' - {field.' . $parameter['row']['variable'] . '}';
                }
            } else {
                $parameter['title'] = LanguageService::sL($parameter['row']['title']) .
                    ' - {field.' . $parameter['row']['variable'] . '.n}';
            }
        } else {
            // Section child field
            if (is_numeric($parameter['row']['parent_field'])) {
                $parentFieldRow = $this->getDceFieldRecordByUid($parameter['row']['parent_field']);
            } else {
                $parentFieldRow = ['variable' => $parameter['parent']['uid']];
            }
            $parameter['title'] = LanguageService::sL($parameter['row']['title']) .
                ' - {field.' . $parentFieldRow['variable'] . '.n.' . $parameter['row']['variable'] . '}';
        }
    }

    /**
     * Translates title of DCEs itself
     *
     * @param array $parameter
     * @return void
     */
    public function getLabelDce(array &$parameter) : void
    {
        $parameter['title'] = LanguageService::sL($parameter['row']['title']);
    }

    /**
     * Checks if given parameters, belonging to a DCE field, is a
     * child field of section
     *
     * @param array $parameter
     * @return bool TRUE if given field parameters are child field of section
     */
    protected function isSectionChildField(array $parameter) : bool
    {
        return  !empty($parameter['row']['parent_field']);
    }

    /**
     * Checks if given parameters, belonging to a DCE field, is a
     * section field.
     *
     * @param array $parameter
     * @return bool
     */
    protected function isSectionField(array $parameter) : bool
    {
        return (int) $parameter['row']['type'][0] === DceField::TYPE_SECTION;
    }

    /**
     * Checks if given parameters, belonging to a DCE field, is a tab
     *
     * @param array $parameter
     * @return bool
     */
    protected function isTab(array $parameter) : bool
    {
        return (int) $parameter['row']['type'][0] === DceField::TYPE_TAB;
    }

    /**
     * Get row of dce field of given uid (even for deleted fields)
     *
     * @param int $uid
     * @return array|null dce field row
     */
    protected function getDceFieldRecordByUid(int $uid) : ?array
    {
        return \T3\Dce\Utility\DatabaseUtility::getDatabaseConnection()->exec_SELECTgetSingleRow(
            '*',
            'tx_dce_domain_model_dcefield',
            'uid=' . $uid
        ) ?? null;
    }
}
