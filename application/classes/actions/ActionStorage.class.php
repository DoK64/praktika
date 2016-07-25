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
class ActionStorage extends Action
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
        $this->AddEvent('index', 'EventIndex');
//        $this->AddEventPreg('/^getfile$/i', '/^[\w\-]{1,50}$/i', 'EventGetFile');
        $this->AddEventPreg('/^get/i', 'EventGetFile');
        $this->AddEventPreg('/^send/i', 'EventSendFile');
    }


    /**********************************************************************************
     ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
     **********************************************************************************
     */

    /**
     * Главная страница
     *
     */
    protected function EventIndex()
    {
        echo "Загрузить файл";
        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplateAction(false);
    }

    protected function EventGetFile()
    {
        $hash = getRequest('hash');
//        $oStortestdb = LS::E()->Storagedatabase_GetStortestdbByHash($hash);
//        header('Location:' . $oStortestdb->getLink());
        $oStortestdb = LS::E()->Storagedatabase_GetStortestdbItemsAll();
        $this->Viewer_Assign('oStortestdb', $oStortestdb);

        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplateAction('upload');
    }

    # Функция получания файла по ссылкке /storage/sendfile/
    protected function EventSendFile()
    {

        if (getRequest('submit_upload')) {
            // новое имя файла
            $description = getRequest('description');
            $oldname = $_FILES['file']['name'];
            $hash = uniqid('');

            // копируем файл в директория
            $_FILES['file']['name'] = $hash;
            $uploadfile = './storage/' . basename($_FILES['file']['name']);
            copy($_FILES['file']['tmp_name'], $uploadfile);

            // генерируем ссылку на скачивание
            $download = 'http://iu8-praktika.ru/storage/';
            $File_upload = is_uploaded_file($_FILES['file']['tmp_name']);

            // передача переменных в шаблон
            $this->Viewer_Assign('hash', $hash);
            $this->Viewer_Assign('fname', $oldname);
            $this->Viewer_Assign('fsize', $_FILES['file']['size']);
            $this->Viewer_Assign('download', $download .= $_FILES['file']['name']);
            $this->Viewer_Assign('description',$description);
            $this->Viewer_Assign('File_upload', $File_upload);

            // запись в базу данных
            $oStortestdb = LS::Ent('Storagedatabase_Stortestdb');
            $oStortestdb->setHash($hash);
            $oStortestdb->setLink($download);

            $oStortestdb->setDesc($description);
            $oStortestdb->Save();

            $this->Viewer_Assign('iddownload', $download);


        }

        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplateAction('storage');

    }


}