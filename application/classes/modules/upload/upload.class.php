<?php

class ModuleUpload extends module {

    public function init() {


    }
    public function UploadFile ($_FILES) {
        echo "Загрузка файла:\n";
        echo "\tИмя: ";
        echo print_r($_FILES['file']['name']);
        echo "\n\tРазмер: ";
        echo print_r($_FILES['file']['size']);
        $hash = uniqid('', true);
        echo "\n\thash: ".$hash;
        $this->Storage_Set($hash, 'kjfgkfjg', $this);

    }
}