{component 'nav' name='main' activeItem=$sMenuHeadItemSelect mods='main' items=[
	[ 'text' => 'Главная',   'url' => {router page='/'},      'name' => 'index' ],
	[ 'text' => 'Storage Upload',     'url' => {router page='storage/send'},  'name' => 'storage' ],
	[ 'text' => 'Storage Download',     'url' => {router page='storage/get'},  'name' => 'upload' ]
]}
