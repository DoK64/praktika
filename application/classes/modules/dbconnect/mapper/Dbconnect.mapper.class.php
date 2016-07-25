<?php

class ModuleDbconnect_MapperDbconnect extends Mapper
{

//    Положить в таблицу значения.
    public function SendFile($sKey, $sValue, $sDes)
    {
        $sSql = 'INSERT INTO
				?#
			(
				`key`,
				`value`,
				`des`
			)
			VALUES
			(
				?,
				?,
				?
			)
			
		';
        echo 'asd';
        return $this->oDb->query(
            $sSql,

            Config::Get('db.table.testconnect'),

            $sKey,
            $sValue,
            $sDes
        );


    }
//    public function GetFile($sKey)
//    {
//        $sSql= 'SELECT *
//            FROM ' + Config::Get('db.table.testconnect');
//
//        return  $this->oDb->query(
//            $sSql);
//
//    }

}