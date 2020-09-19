/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	//config.extraPlugins = 'uploadimage';

	config.font_defaultLabel = 'Arial';
	config.fontSize_defaultLabel = '11px';
	config.extraAllowedContent = '*{*}';
	config.filebrowserBrowseUrl = BASE_URL+'resources/admin/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = BASE_URL+'resources/admin/ckfinder/ckfinder.html?type=Images';
	config.filebrowserUploadUrl = BASE_URL+'resources/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = BASE_URL+'resources/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.removeButtons = 'Subscript,Superscript,Save,Preview,Print,Templates,Find,Anchor,NewPage,Replace,SelectAll,Scayt,Select,Form,Checkbox,Radio,TextField,Textarea,Button,ImageButton,HiddenField,CreateDiv,BidiLtr,BidiRtl,Flash,ShowBlocks,About';
};
