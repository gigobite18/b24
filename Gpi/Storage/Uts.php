<?php

namespace Gpi\Department\Dev\Storage;

class Uts{

    public static function getTableByStorageId($storageId){

        $className = "DiskFile{$storageId}Table";

        if(file_exists($_SERVER['DOCUMENT_ROOT']."/local/modules/gpi.department/classes/Gpi/Department/Dev/Storage/Uts/{$className}.php") && class_exists("\\Gpi\\Department\\Dev\\Storage\\Uts\\$className")){

            return "\Gpi\\Department\\Dev\\Storage\\Uts\\{$className}";
        }

    }

}

?>