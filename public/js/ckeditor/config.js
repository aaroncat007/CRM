/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.height = 500;

	config.filebrowserBrowseUrl = '/js/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '/js/ckfinder/ckfinder.html?Type=Images';
	config.filebrowserFlashBrowseUrl = '/js/ckfinder/ckfinder.html?Type=Flash';
	//可上傳圖檔
	config.filebrowserImageUploadUrl = '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	/*上傳一般檔案 依照需求使用*/
	config.filebrowserUploadUrl = '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	/*上傳Flash檔案 依照需求使用*/
	config.filebrowserFlashUploadUrl = '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
	//這邊主要是讓ckeditor去引入ckfinder的檔案，藉此開啟附加的上傳功能(包含圖片管理庫)
};
