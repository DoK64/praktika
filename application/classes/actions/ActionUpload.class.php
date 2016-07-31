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
class ActionUpload extends Action
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
        # $this->AddEventPreg('/^getfile$/i', '/^[\w\-]{1,50}$/i', 'EventGetFile');
        $this->AddEventPreg('/^get$/i', 'EventGetFile');
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
        #echo "Скачать файл с хэшем: ".getRequest('hash');
        #$this->GetParamEventMatch(0,0);
        echo print_r($this->Storage_Get(getRequest('hash'), $this));
        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplate(false);
    }

    # Функция получания файла по ссылкке /storage/sendfile/
    protected function EventSendFile()
    {
//        echo "Загрузка файла:\n";
//        echo "\tИмя: ";
//        echo print_r($_FILES['file']['name']);
//        echo "\n\tРазмер: ";
//        echo print_r($_FILES['file']['size']);
//          $hash = uniqid('');
//          echo "\n\thash: ".$hash;
//        $uploaddir = './storage/';
//        $uploadfile = $uploaddir.basename($_FILES['file']['name']);
//        copy($_FILES['file']['tmp_name'], $uploadfile);
//        $this->ModuleStor_Set($hash, $uploadfile, $this);
//        $uploaddir = './storage/';
//        $uploadfile = $uploaddir.basename($_FILES['file']['name']);
        $description='';

        if (getRequest('submit_upload')) {
//            echo $description;
//            $File_upload = is_uploaded_file($_FILES['file']['tmp_name']);
            $uploaddir = './storage/';
            $uploadfile = $uploaddir . basename($_FILES['file']['name']);
            $download = 'http://iu8-praktika.ru';
            $download .= substr($uploadfile, 1);
            $profitfile=file_exists($uploadfile);
            $this->Viewer_Assign('profitfile', $profitfile);
            //Проверка на повтор.
            if ($profitfile)
            {
                
                $errorupload= 'http://iu8-praktika.ru'.$uploadfile ;
                $this->Viewer_Assign('faled', $errorupload);

            } else {

                $File_upload = is_uploaded_file($_FILES['file']['tmp_name']);
                $uploaddir = './storage/';
                $uploadfile = $uploaddir . basename($_FILES['file']['name']);
                $hash = uniqid('');
                $this->Viewer_Assign('hash', $hash);
                $this->Viewer_Assign('fname', $_FILES['file']['name']);
                $this->Viewer_Assign('fsize', $_FILES['file']['size']);
                $download = 'http://iu8-praktika.ru';
                $download .= substr($uploadfile, 1);

                $this->Viewer_Assign('download', $download);
                copy($_FILES['file']['tmp_name'], $uploadfile);
                $this->Viewer_Assign('File_upload', $File_upload);
                $this->ModuleStor_Set($hash, $download, $this);
                $this->Viewer_Assign('iddownload', $this->ModuleStor_Get($hash, $this));
            }

        }


        /**
         * Устанавливаем шаблон вывода
         */
        $this->SetTemplateAction('upload');

    }


}