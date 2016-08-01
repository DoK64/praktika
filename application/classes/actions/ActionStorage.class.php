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
        $this->AddEventPreg('/^tyu/i', 'EventGetByHash');
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

    protected function EventGetByHash()
    {
        $hash = getRequest('hash');
        $oStortestdb = LS::E()->Storagedatabase_GetStortestdbByHash($hash);
        $file = '.' . substr($oStortestdb->getLink(), 22);
        // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
        // если этого не сделать файл будет читаться в память полностью!
        if (ob_get_level()) {
            ob_end_clean();
        }
        // заставляем браузер показать окно сохранения файла
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        // читаем файл и отправляем его пользователю
        readfile($file);

        echo "crfxfk";

        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplate(false);
    }

    # Функция получания файла по ссылкке /storage/sendfile/
    protected function EventSendFile()
    {

        if (getRequest('submit_upload')) {
            // новое имя файла
            $description = getRequest('description');
            $address = getRequest('address');
            $oldname = $_FILES['file']['name'];
            $hash = uniqid('');
            // копируем файл в директория
            $_FILES['file']['name'] = $hash;
            $uploadfile = './storage/' . basename($_FILES['file']['name']);
            if ($address != null) {
                $enddir = './storage/';
                $dirs = explode("/", $address);
                foreach ($dirs as $dir) {
                    error_reporting(0);
                    mkdir($enddir . $dir . '/');
                    error_reporting(E_ERROR | E_WARNING | E_PARSE);
                    $enddir .= $dir . '/';
                }
                $uploadfile = $enddir .= basename($_FILES['file']['name']);
            }

            copy($_FILES['file']['tmp_name'], $uploadfile);

            // генерируем ссылку на скачивание
            $download = 'http://iu8-praktika.ru/tyu/?hash=' .$hash;
            $File_upload = is_uploaded_file($_FILES['file']['tmp_name']);

            // передача переменных в шаблон
            $this->Viewer_Assign('hash', $hash);
            $this->Viewer_Assign('fname', $oldname);
            $this->Viewer_Assign('fsize', $_FILES['file']['size']);
            $this->Viewer_Assign('download', $download .= $_FILES['file']['name']);
            $this->Viewer_Assign('description', $description);
            $this->Viewer_Assign('File_upload', $File_upload);

            // запись в базу данных
            $oStortestdb = LS::Ent('Storagedatabase_Stortestdb');
            $oStortestdb->setHash($hash);
            $oStortestdb->setLink($download);
            $oStortestdb->setDesc($description);
            $oStortestdb->setDir(substr($uploadfile, 1));
            $oStortestdb->Save();

            $this->Viewer_Assign('iddownload', $download);


        }

        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplateAction('storage');

    }


}