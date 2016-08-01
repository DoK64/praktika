{**
 * Главная
 *}
{extends 'layouts/layout.base.tpl'}

{block 'layout_content'}

   <h4>Загрузить файл:</h4>
<h5>
   <form action='' method='POST' enctype='multipart/form-data'>
       Описание: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<input type="text"  name="description" valiue=""/><br><br>
       Путь загрузки файла:&nbsp;  <input type="text" name="address" value=""/><br><br>
       <input type='file' name='file' >
       <input type='submit' name='submit_upload' value='Загрузить'></form>
   <br>
</h5>
   {if $File_upload eq false}
      <h5>Выберите новый файл.</h5><br>
      {elseif $File_upload eq true}
<h5>  Файл {$fname} успешно загружен на сервер.<br>
      Имя файла:{$fname} <br>
      Размер: {$fsize}<br>
      Хеш: {$hash} <br>
      Описание: {$description}<br>

      Ссылка для скачивания: {$iddownload}
</h5>
      {else}

      <h5>Выберите файл.</h5>

   {/if}



{/block}
