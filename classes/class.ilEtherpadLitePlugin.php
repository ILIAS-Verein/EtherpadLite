<?php

/**
* EtherpadLite repository object plugin
*
* @author Jan Rocho <jan.rocho@fh-dortmund.de>
* @version $Id$
*
*/
class ilEtherpadLitePlugin extends ilRepositoryObjectPlugin
{
    public const ID = "xpdl";

    public function __construct()
    {
        global $DIC;
        $this->db = $DIC->database();
        parent::__construct($this->db, $DIC["component.repository"], self::ID);
    }

    protected function uninstallCustom(): void
    {
        // removes plugin tables if they exist
        if($this->db->tableExists('rep_robj_xpdl_data')) {
            $this->db->dropTable('rep_robj_xpdl_data');
        }
                    
        if($this->db->tableExists('rep_robj_xpdl_adm_set')) {
            $this->db->dropTable('rep_robj_xpdl_adm_set');
        }
    }

    public function getPluginName(): string
    {
        return "EtherpadLite";
    }

    // fau: copyPad - new function allowCopy
    /**
     * decides if this repository plugin can be copied
     *
     * @return bool
     */
    public function allowCopy(): bool
    {
        return true;
    }
    // fau.

    /**
     * Get the title icon
     * Used for object list, creation, gui
     * used by info, export and permission tabe
     */
    public static function _getIcon(string $a_type): string
    {
        return 'Customizing/global/plugins/Services/Repository/RepositoryObject/EtherpadLite/templates/images/icon_xpdl.svg';
    }

}
