<?php
if(Bitrix\Main\Loader::includeModule('gpi.department')) {
    new Gpi\Department\Dev\Storage\Folder\ResultModifier($arResult, $arParams);
}
?>