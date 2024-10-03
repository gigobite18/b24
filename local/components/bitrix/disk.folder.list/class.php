<?php

class CDiskFolderListComponent extends DiskComponent implements \Bitrix\Main\Engine\Contract\Controllerable
{

	private function getGridData()
    {

        /*

        // Какой-то код до нужного места

        */
        if (Loader::includeModule('gpi.department')) {
            \Gpi\Department\Dev\Storage\Folder\QueryModifier::modifyObjectsQueryParams($this, (new \Bitrix\Main\UI\Filter\Options($this->gridOptions->getGridId()))->getFilter(), $parameters);
        }
        foreach (ObjectTable::getList($parameters) as $row) {
            $objectIds[] = $row['ID'];
        }

        /*

        // Какой-то код до после нужного места

        */


    }

}
