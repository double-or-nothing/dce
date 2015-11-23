<?php

/*  | This extension is part of the TYPO3 project. The TYPO3 project is
 *  | free software and is licensed under GNU General Public License.
 *  |
 *  | (c) 2012-2015 Armin Ruediger Vieweg <armin@v.ieweg.de>
 */

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$ll = 'LLL:EXT:dce/Resources/Private/Language/locallang_db.xml:';
$extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('dce');

$dceTca = array(
    'ctrl' => array(
        'title' => $ll . 'tx_dce_domain_model_dce',
        'label' => 'title',
        'adminOnly' => 1,
        'rootLevel' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'versioningWS' => 2,
        'versioning_followPages' => true,
        'origUid' => 't3_origuid',
        'delete' => 'deleted',
        'sortby' => 'sorting',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'copyAfterDuplFields' => 'fields',
        'requestUpdate' => 'wizard_enable,wizard_icon,template_type,preview_template_type,detailpage_template_type,enable_detailpage',
        'type' => 'type',
        'typeicon_column' => 'type',
        'typeicon_classes' => array(
            '0' => 'ext-dce-dce-type-databased',
            '1' => 'ext-dce-dce-type-filebased',
        ),
    ),
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden',
    ),
    'types' => array(
        // Database DCE
        '0' => array(
            'showitem' => 'hidden;;1,type,title,fields,
			--div--;' . $ll . 'tx_dce_domain_model_dce.template,template_type,template_content;;;fixed-font:enable-tab,template_file,
			--div--;' . $ll . 'tx_dce_domain_model_dce.backendTemplate,preview_template_type,header_preview,header_preview_template_file,bodytext_preview,bodytext_preview_template_file,
			--div--;' . $ll . 'tx_dce_domain_model_dce.wizard,wizard_enable,wizard_category,wizard_description,wizard_icon,wizard_custom_icon,
			--div--;' . $ll . 'tx_dce_domain_model_dce.detailpage,enable_detailpage,detailpage_identifier,detailpage_template_type,detailpage_template,detailpage_template_file,
			--div--;' . $ll . 'tx_dce_domain_model_dce.miscellaneous,cache_dce,hide_default_ce_wrap,show_access_tab,show_category_tab,palette_fields,template_layout_root_path,template_partial_root_path'
        ),
        // Filebased DCE
        '1' => array(
            'showitem' => 'hidden;;1,type,identifier,title,fields,
			--div--;' . $ll . 'tx_dce_domain_model_dce.template,template_content;;;fixed-font:enable-tab,template_file,
			--div--;' . $ll . 'tx_dce_domain_model_dce.backendTemplate,preview_template_type,header_preview,header_preview_template_file,bodytext_preview,bodytext_preview_template_file,
			--div--;' . $ll . 'tx_dce_domain_model_dce.wizard,wizard_enable,wizard_category,wizard_description,wizard_icon,wizard_custom_icon,
			--div--;' . $ll . 'tx_dce_domain_model_dce.detailpage,enable_detailpage,detailpage_identifier,detailpage_template,detailpage_template_file,
			--div--;' . $ll . 'tx_dce_domain_model_dce.miscellaneous,cache_dce,hide_default_ce_wrap,show_access_tab,show_category_tab,palette_fields,template_layout_root_path,template_partial_root_path'
        ),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
                ),
            ),
        ),
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_dce_domain_model_dce',
                'foreign_table_where' => 'AND tx_dce_domain_model_dce.pid=###CURRENT_PID### ' .
                    'AND tx_dce_domain_model_dce.sys_language_uid IN (-1,0)',
            ),
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
        't3ver_label' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'type' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.type',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array($ll . 'tx_dce_domain_model_dce.type.databased', 0),
                    array($ll . 'tx_dce_domain_model_dce.type.filebased', 1),
                ),
                'readOnly' => true,
            ),
        ),
        'identifier' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.identifier',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => 'dce_'
            ),
        ),
        'title' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.title',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ),
        ),
        'fields' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.fields',
            'config' => array(
                'type' => 'inline',
                'allowed' => 'tx_dce_domain_model_dcefield',
                'foreign_table' => 'tx_dce_domain_model_dcefield',
                'foreign_sortby' => 'sorting',
                'foreign_field' => 'parent',
                'minitems' => 0,
                'maxitems' => 999,
                'appearance' => array(
                    'collapseAll' => 0,
                    'expandSingle' => 0,
                    'levelLinksPosition' => 'bottom',
                    'useSortable' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showRemovedLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'showSynchronizationLink' => 1,
                    'enabledControls' => array(
                        'info' => false,
                        'dragdrop' => true,
                        'sort' => true
                    )
                ),
            ),
        ),
        'wizard_enable' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.wizardEnable',
            'config' => array(
                'type' => 'check',
                'default' => true,
            ),
        ),
        'wizard_category' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.wizardCategory',
            'displayCond' => 'FIELD:wizard_enable:REQ:true',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array($ll . 'tx_dce_domain_model_dce', '--div--'),
                    array($ll . 'tx_dce_domain_model_dce_long', 'dce'),
                    array($ll . 'typo3_default_categories', '--div--'),
                    array('LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common', 'common'),
                    array('LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:special', 'special'),
                    array('LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:forms', 'forms'),
                    array('LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:plugins', 'plugins'),
                ),
            ),
        ),
        'wizard_description' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.wizardDescription',
            'displayCond' => 'FIELD:wizard_enable:REQ:true',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'wizard_icon' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.wizardIcon',
            'displayCond' => 'FIELD:wizard_enable:REQ:true',
            'config' => array(
                'type' => 'select',
                'items' => \ArminVieweg\Dce\Utility\WizardIcon::getTcaListItems(),
            ),
        ),
        'wizard_custom_icon' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.wizardCustomIcon',
            'displayCond' => 'FIELD:wizard_icon:IN:custom',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'file_reference',
                'allowed' => 'gif,png,svg,jpg',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
            ),
        ),
        'template_type' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.templateType',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array($ll . 'tx_dce_domain_model_dce.templateType.inline', 'inline'),
                    array($ll . 'tx_dce_domain_model_dce.templateType.file', 'file'),
                ),
            ),
        ),
        'template_content' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.templateContent',
            'displayCond' => 'FIELD:template_type:!IN:file',
            'config' => array(
                'type' => 'user',
                'size' => '30',
                'userFunc' => 'EXT:dce/Classes/UserFunction/UserFields/CodemirrorField.php:' .
                    'ArminVieweg\Dce\UserFunction\UserFields\CodemirrorField->getCodemirrorField',
                'parameters' => array(
                    'mode' => 'htmlmixed',
                    'showTemplates' => false,
                ),
                'default' => '{namespace dce=ArminVieweg\Dce\ViewHelpers}
<f:layout name="Default" />

<f:section name="main">
	Your template goes here...
</f:section>',
            ),
        ),
        'template_file' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.templateFile',
            'displayCond' => 'FIELD:template_type:IN:file',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'file_reference',
                'allowed' => 'html,htm',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
            ),
        ),
        'cache_dce' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.cacheDce',
            'config' => array(
                'type' => 'check',
                'default' => '1',
            ),
        ),
        'show_access_tab' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.showAccessTab',
            'config' => array(
                'type' => 'check',
                'default' => '0',
            ),
        ),
        'show_category_tab' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.showCategoryTab',
            'config' => array(
                'type' => 'check',
                'default' => '0',
            ),
        ),
        'preview_template_type' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.previewTemplateType',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array($ll . 'tx_dce_domain_model_dce.templateType.inline', 'inline'),
                    array($ll . 'tx_dce_domain_model_dce.templateType.file', 'file'),
                ),
            ),
        ),
        'header_preview' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.headerPreview',
            'displayCond' => 'FIELD:preview_template_type:!IN:file',
            'config' => array(
                'type' => 'user',
                'size' => '30',
                'userFunc' => 'EXT:dce/Classes/UserFunction/UserFields/CodemirrorField.php:' .
                    'ArminVieweg\Dce\UserFunction\UserFields\CodemirrorField->getCodemirrorField',
                'parameters' => array(
                    'mode' => 'htmlmixed',
                    'showTemplates' => false,
                ),
                'default' => '
{namespace dce=ArminVieweg\Dce\ViewHelpers}
{fields -> dce:arrayGetIndex()}
',
            ),
        ),
        'header_preview_template_file' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.headerPreviewTemplateFile',
            'displayCond' => 'FIELD:preview_template_type:IN:file',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'file_reference',
                'allowed' => 'html,htm',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
            ),
        ),
        'bodytext_preview' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.bodytextPreview',
            'displayCond' => 'FIELD:preview_template_type:!IN:file',
            'config' => array(
                'type' => 'user',
                'size' => '30',
                'userFunc' => 'EXT:dce/Classes/UserFunction/UserFields/CodemirrorField.php:' .
                    'ArminVieweg\Dce\UserFunction\UserFields\CodemirrorField->getCodemirrorField',
                'parameters' => array(
                    'mode' => 'htmlmixed',
                    'showTemplates' => false,
                ),
                'default' => '
<f:render partial="BodytextPreview/ShowAllFieldsButFirst" arguments="{fields:fields}" />
',
            ),
        ),
        'bodytext_preview_template_file' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.bodytextPreviewTemplateFile',
            'displayCond' => 'FIELD:preview_template_type:IN:file',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'file_reference',
                'allowed' => 'html,htm',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
            ),
        ),
        'template_layout_root_path' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.layoutRootPath',
            'config' => array(
                'type' => 'input',
                'eval' => 'trim,required',
                'default' => 'EXT:dce/Resources/Private/Layouts/',
            ),
        ),
        'template_partial_root_path' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.partialRootPath',
            'config' => array(
                'type' => 'input',
                'eval' => 'trim,required',
                'default' => 'EXT:dce/Resources/Private/Partials/',
            ),
        ),
        'enable_detailpage' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.enableDetailpage',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'detailpage_identifier' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.detailpageIdentifier',
            'displayCond' => 'FIELD:enable_detailpage:=:1',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,is_in',
                'is_in' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890_-',
                'default' => 'detailDceUid',
            ),
        ),
        'detailpage_template_type' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.templateType',
            'displayCond' => 'FIELD:enable_detailpage:=:1',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array($ll . 'tx_dce_domain_model_dce.templateType.inline', 'inline'),
                    array($ll . 'tx_dce_domain_model_dce.templateType.file', 'file'),
                ),
            ),
        ),
        'detailpage_template' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.detailpageTemplate',
            'displayCond' => array(
                'AND' => array(
                    'FIELD:enable_detailpage:=:1',
                    'FIELD:detailpage_template_type:!IN:file'
                )
            ),
            'config' => array(
                'type' => 'user',
                'size' => '30',
                'userFunc' => 'EXT:dce/Classes/UserFunction/UserFields/CodemirrorField.php:' .
                    'ArminVieweg\Dce\UserFunction\UserFields\CodemirrorField->getCodemirrorField',
                'parameters' => array(
                    'mode' => 'htmlmixed',
                    'showTemplates' => false,
                ),
                'default' => '{namespace dce=ArminVieweg\Dce\ViewHelpers}
<f:layout name="Default" />

<f:section name="main">
	Your detailpage template goes here...
</f:section>',
            ),
        ),
        'detailpage_template_file' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.detailpageTemplateFile',
            'displayCond' => array(
                'AND' => array(
                    'FIELD:enable_detailpage:=:1',
                    'FIELD:detailpage_template_type:IN:file'
                )
            ),
            'config' => array(
                'type' => 'group',
                'internal_type' => 'file_reference',
                'allowed' => 'html,htm',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
            ),
        ),
        'palette_fields' => array(
            'exclude' => 0,
            'label' => $ll . 'tx_dce_domain_model_dce.paletteFields',
            'config' => array(
                'type' => 'input',
                'eval' => 'trim,is_in',
                'is_in' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890-_, ',
                'default' => 'sys_language_uid, l18n_parent, colPos, spaceBefore, spaceAfter, section_frame, hidden',
            ),
        ),
    ),
);

if (!\TYPO3\CMS\Core\Utility\GeneralUtility::compat_version('7.4')) {
    $dceTca['columns']['wizard_category']['config']['items'] = array(
        array($ll . 'tx_dce_domain_model_dce', '--div--'),
        array($ll . 'tx_dce_domain_model_dce_long', 'dce'),
        array($ll . 'typo3_default_categories', '--div--'),
        array('LLL:EXT:cms/layout/locallang_db_new_content_el.xml:common', 'common'),
        array('LLL:EXT:cms/layout/locallang_db_new_content_el.xml:special', 'special'),
        array('LLL:EXT:cms/layout/locallang_db_new_content_el.xml:forms', 'forms'),
        array('LLL:EXT:cms/layout/locallang_db_new_content_el.xml:plugins', 'plugins'),
    );
}

if (!\TYPO3\CMS\Core\Utility\GeneralUtility::compat_version('7.6')) {
    unset($dceTca['ctrl']['typeicon_classes']);
    $dceTca['ctrl']['typeicons'] = array(
        '0' => $extensionPath . 'Resources/Public/Icons/tx_dce_domain_model_dce_databased.png',
        '1' => $extensionPath . 'Resources/Public/Icons/tx_dce_domain_model_dce_filebased.png',
    );
}

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('css_styled_content')) {
    //hide_default_ce_wrap
    $dceTca['columns']['hide_default_ce_wrap'] = array(
        'exclude' => 0,
        'label' => $ll . 'tx_dce_domain_model_dce.hideDefaultCeWrap',
        'config' => array(
            'type' => 'check',
            'default' => '0',
        )
    );
}

return $dceTca;
