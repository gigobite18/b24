<?php

namespace Gpi\Department\Dev\Storage\Folder;

class ResultModifier{

    function __construct(&$arResult, &$arParams){

        $this->arResult = $arResult;
        $this->arParams = $arParams;

        $this->storageId = $this->arParams['STORAGE']->getId();

        $this->utsTable = \Gpi\Department\Dev\Storage\Uts::getTableByStorageId($this->storageId);

        if(!$this->utsTable)
            return;

        $this->defineUts();
        $this->addUfFields();
        $this->addRowsData();

        $arResult = $this->arResult;
        $arParams = $this->arParams;

    }

    protected function defineUts(){

        $fileFields = \Bitrix\Main\UserFieldTable::getList([
            'filter' => [
                'ENTITY_ID' => "DISK_FILE_{$this->storageId}"
            ]
        ])->fetchAll();

        $fileFields = array_combine(array_column($fileFields, 'FIELD_NAME'),$fileFields);

        $enumerationFields = array_filter($fileFields, fn($field) => $field['USER_TYPE_ID'] == 'enumeration');

        $enumerationValuesRS = \CUserFieldEnum::GetList([], ['USER_FIELD_ID' => array_column($enumerationFields, 'ID')]);

        $enumCodes = array_combine(array_column($enumerationFields, 'ID'), array_column($enumerationFields, 'FIELD_NAME'));

        while($enumerationValue = $enumerationValuesRS->fetch()){
            $fileFields[$enumCodes[$enumerationValue['USER_FIELD_ID']]]['ITEMS'][$enumerationValue['ID']] = $enumerationValue['VALUE'];
        }

        $this->fields = $fileFields;

    }

    protected function addUfFields(){


        foreach ($this->fields as $code => $field){

            switch ($field['USER_TYPE_ID']){

                case 'enumeration':

                    $this->arResult['FILTER']['FILTER'][] = [
                        'id' => $code,
                        'name' => $code,
                        'type' => 'list',
                        'items' => $field['ITEMS'],
                        'default' => true,
                    ];

                    $this->arResult['GRID']['HEADERS'][] = [
                        'id' => $code,
                        'name' => $code,
                        'default' => true,
                    ];

                    break;

            }

        }


    }

    protected function addRowsData()
    {

        $ufData = $this->getRowsUFData();

        foreach ($this->arResult['GRID']['ROWS'] as &$row){

            if(!$ufData[$row['id']])
                continue;

            foreach ($this->fields  as $field){

                switch ($field['USER_TYPE_ID']){

                    case 'enumeration':

                        $row['columns'][$field['FIELD_NAME']] = $field['ITEMS'][$ufData[$row['id']][$field['FIELD_NAME']]];

                        break;

                }

            }

        }

    }

    protected function getRowsUFData(){

        $select = ['ID'];

        foreach ($this->fields as $code => $field)
            $select[$code] = "UTS_TABLE.$code";

        $queryResult = \Bitrix\Disk\Internals\ObjectTable::getList([
            'select' => $select,
            'runtime' => [
                'UTS_TABLE' => [
                    'data_type' => $this->utsTable,
                    'reference' => [
                        'this.ID' => 'ref.VALUE_ID'
                    ]
                ]
            ],
            'filter' => [
                'STORAGE_ID' => $this->arParams['STORAGE']->getId(),
            ]
        ])->fetchAll();

        $data = array_combine(array_column($queryResult, 'ID'), $queryResult);

        return $data;

    }

}

?>