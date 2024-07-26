<?php
/*
    +-----------------------------------------------------------------------------+
    | EtherpadLite ILIAS Plugin                                                        |
    +-----------------------------------------------------------------------------+
    | Copyright (c) 2012-2013 Jan Rocho										      |
    |                                                                             |
    | This program is free software; you can redistribute it and/or               |
    | modify it under the terms of the GNU General Public License                 |
    | as published by the Free Software Foundation; either version 2              |
    | of the License, or (at your option) any later version.                      |
    |                                                                             |
    | This program is distributed in the hope that it will be useful,             |
    | but WITHOUT ANY WARRANTY; without even the implied warranty of              |
    | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the               |
    | GNU General Public License for more details.                                |
    |                                                                             |
    | You should have received a copy of the GNU General Public License           |
    | along with this program; if not, write to the Free Software                 |
    | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA. |
    +-----------------------------------------------------------------------------+
*/

/**
* Access/Condition checking for EtherpadLite object
*
* @author 		Jan Rocho <jan.rocho@fh-dortmund.de>
* @version $Id$
*/
class ilObjEtherpadLiteAccess extends ilObjectPluginAccess
{

    /**
    * Checks wether a user may invoke a command or not
    * (this method is called by ilAccessHandler::checkAccess)
    *
    * Please do not check any preconditions handled by
    * ilConditionHandler here. Also don't do usual RBAC checks.
    *
    * @param	string $cmd        command (not permission!)
    * @param	string $permission permission
    * @param	int    $ref_id     reference id
    * @param	int    $obj_id     object id
    * @param	int    $user_id    user id (if not provided, current user is taken)
    *
    * @return	boolean		true, if everything is ok
    */
    public function _checkAccess(string $cmd, string $permission, int $ref_id, int $obj_id, ?int $user_id = null): bool
    {
        global $DIC;
        
        $ilUser = $DIC['ilUser'];
        $ilAccess = $DIC['ilAccess'];

        if ($user_id == "") {
            $user_id = $ilUser->getId();
        }

        switch ($permission) {
            case "read":
            case "visible":
                if (!ilObjEtherpadLiteAccess::checkOnline($obj_id) &&
                    !$ilAccess->checkAccessOfUser($user_id, "write", "", $ref_id)) {
                    return false;
                }
                break;
        }

        return true;
    }
    
    /**
    * Check online status of example object
    */
    public static function checkOnline($a_id)
    {
        global $DIC;
        $ilDB = $DIC['ilDB'];
        
        $set = $ilDB->query(
            "SELECT is_online FROM rep_robj_xpdl_data ".
            " WHERE id = ".$ilDB->quote($a_id, "integer")
        );
        $rec  = $ilDB->fetchAssoc($set);
        return (boolean) $rec["is_online"];
    }

}
