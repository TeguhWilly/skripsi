// untuk ckeditor
var editor;
function hapus_editor(){
	if(editor)
		editor.destroy();
	}
function replaceDiv(div){
	hapus_editor();
	editor = CKEDITOR.replace(div,
	{
		toolbar : 'MyToolbar',
		});
	CKFinder.setupCKEditor(editor,'js/ckfinder/');		
	}
