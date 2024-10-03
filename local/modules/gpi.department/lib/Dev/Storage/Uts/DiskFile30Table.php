<?php
namespace Gpi\Department\Dev\Storage\Uts;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;

/**
 * Class DiskFile30Table
 *
 * Fields:
 * <ul>
 * <li> VALUE_ID int mandatory
 * <li> UF_COUNTRY int optional
 * </ul>
 *
 * @package Bitrix\Uts
 **/

class DiskFile30Table extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'b_uts_disk_file_30';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new IntegerField(
                'VALUE_ID',
                [
                    'primary' => true,
                    'title' => Loc::getMessage('DISK_FILE_30_ENTITY_VALUE_ID_FIELD'),
                ]
            ),
            new IntegerField(
                'UF_COUNTRY',
                [
                    'title' => Loc::getMessage('DISK_FILE_30_ENTITY_UF_COUNTRY_FIELD'),
                ]
            ),
        ];
    }
}