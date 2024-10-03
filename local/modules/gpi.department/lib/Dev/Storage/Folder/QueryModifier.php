<?php

namespace Gpi\Department\Dev\Storage\Folder;

class QueryModifier{

    public static function modifyObjectsQueryParams($component, $filter, &$params)
    {

        $utsTable = \Gpi\Department\Dev\Storage\Uts::getTableByStorageId($component->arParams['STORAGE']->getId());

        if($utsTable){

            $params['runtime']['UTS_TABLE'] = [
                'data_type' => $utsTable,
                'reference' => [
                    'this.ID' => 'ref.VALUE_ID'
                ]
            ];

            foreach ($filter as $key => $value) {

                if(strpos($key, 'UF_') === 0){
                    $params['filter']['UTS_TABLE.'.$key] = $value;
                }

            }


            $enumFields = \Bitrix\Main\UserFieldTable::getList([
                'filter' => [
                    'ENTITY_ID' => "DISK_FILE_{$component->arParams['STORAGE']->getId()}",
                    'USER_TYPE_ID' => 'enumeration'
                ]
            ])->fetchAll();

            foreach ($enumFields as $enumField){

                $code = $enumField['FIELD_NAME'];

                $params['runtime']["UTS_ENUM_$code"] = [
                    'data_type' => 'Gpi\Department\Dev\Storage\Uts\MainEnumTable',
                    'reference' => [
                        "this.UTS_TABLE.$code" => 'ref.ID'
                    ]
                ];

            }

        }

    }

}

?>