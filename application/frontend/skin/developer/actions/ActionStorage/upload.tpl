{**
 * Главная
 *}
{extends 'layouts/layout.base.tpl'}

{block 'layout_content'}
<h5>
    <table style="width:100%">

        {foreach $oStortestdb as $oFile}
            <tr>

                 <td><a href=http://iu8-praktika.ru/storage/tyu/?hash={$oFile->getHash()}>{$oFile->getHash()}</a></td><td>{$oFile->getDesc()}</td>

            </tr>
        {/foreach}

    </table>
</h5>
    {*foreach ($oStortestdb as $oFile){*}
    {*//            echo $oFile->getHash();*}
    {*//            echo "<br>";*}
    {*//            echo $oFile->getLink();*}
    {*//            echo "<br><br><br>";*}
    {*$this->Viewer_Assign('name', $oFile->getHash());*}
    {*$this->Viewer_Assign('link', $oFile->getLink());*}
    {*$this->Viewer_Assign('description', $oFile->getDesc());*}

    {*Имя файла: {$name}*}
    {*Ссылка для скачивания:{$link}*}
    {*Описание:{$description}*}



{/block}
