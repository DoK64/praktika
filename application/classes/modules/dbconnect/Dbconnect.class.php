<?php


class ModuleDbconnect extends Module
{

protected $oMapperDbconnect = null;

/*
* Группа настроек по-умолчанию (инстанция)
*/
const DEFAULT_INSTANCE = 'default';

/*
* Префикс ключей для кеша
*/
const CACHE_FIELD_DATA_PREFIX = 'testconnect_field_data_';

/*
* Имя ключа для ядра
*/
const DEFAULT_KEY_NAME = '__default__';

/*
* Префикс для плагина в таблице
*/
const PLUGIN_PREFIX = 'plugin_';

/*
* Кеширование параметров на время работы сессии
* структура: array('instance' => array('key' => array('param1' => 'value1', 'param2' => 'value2')))
*/
protected $aSessionCache = array();

    public function Init()
    {
        $this->Setup();
    }


    /**
     * Настройка
     */
    protected function Setup()
    {
        $this->oMapperDbconnect = Engine::GetMapper(__CLASS__);
    }

    public function Set($$One,$Two,$Three))
    {
        $sCallerName = $this->GetKeyForCaller($oCaller);
        return $this->SetOneParam($sCallerName, $sParamName, $mValue, $sInstance);
    }