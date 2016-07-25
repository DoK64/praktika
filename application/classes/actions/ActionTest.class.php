<?php
/*
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 *
 * ------------------------------------------------------
 *
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author Maxim Mzhelskiy <rus.engine@gmail.com>
 *
 */

/**
 * Обработка главной страницы, т.е. УРЛа вида /index/
 *
 * @package actions
 * @since 1.0
 */
class ActionTest extends Action
{

    protected $sMenuHeadItemSelect = 'index';

    /**
     * Инициализация
     *
     */
    public function Init()
    {
        $this->SetDefaultEvent('index');
    } 

    /**
     * Регистрация евентов
     *
     */
    protected function RegisterEvent()
    {
//        $this->AddEvent('test', 'EventTest');
        $this->AddEventPreg('/^test/i', 'EventTest');
    }


    /**********************************************************************************
     ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
     **********************************************************************************
     */

    /**
     * Главная страница
     *
     */


    protected function EventTest()
    {


        $oStortestdb = LS::Ent('Storagedatabase_Stortestdb');
        echo print_r($oStortestdb)."\n";
        // задание свойств модели
        $oStortestdb->setHash("opopo");
        echo print_r($oStortestdb)."\n";
        $oStortestdb->setLink('Jojojo');
        echo print_r($oStortestdb)."\n";
        $oStortestdb->setDesc('Jojojo');
        echo print_r($oStortestdb)."\n";
        $oStortestdb->Save();
        echo print_r($oStortestdb)."\n";

        $One='qwer';
            $Two='qwer1';
                $Three='qwer2';
        echo Config::Get('db.table.testconnect');
        $this->ModulesDbconnect_SendFile($One,$Two,$Three);

        echo print_r($this->ModulesDbconnect_GetFile('ghbdtn'));

        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplate(false);
    }

    


}