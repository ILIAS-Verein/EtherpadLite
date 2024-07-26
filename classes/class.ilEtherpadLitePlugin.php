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
        global $DIC;
                
        $ilDB = $DIC['ilDB'];

        // removes plugin tables if they exist
        if($ilDB->tableExists('rep_robj_xpdl_data')) {
            $ilDB->dropTable('rep_robj_xpdl_data');
        }
                    
        if($ilDB->tableExists('rep_robj_xpdl_adm_set')) {
            $ilDB->dropTable('rep_robj_xpdl_adm_set');
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

}
