'use strict';

jQuery(document).ready(function(){
	Gallery.init(); // Load Module
});


var Gallery = {

	init:(function(){

		if(typeof console !== 'undefined'){
			console.log('Gallery module version: 1.6 - Loaded');
			console.log('Developer: Vasil Tsintsev / http://tsintsev.com');
		}
		this.toggleAlbumEdit();
	}),

	toggleAlbumEdit : function()
	{
		if($('#new-category-form').length){

			var itemsHide = function (){
				$('#cat-add-btn,#cat-edit-btn,#cat-del-btn,#cat-name-field').hide();
			};

			itemsHide();

			$('#category-dropdown').change(function(){
				var val = $(this).val();
				itemsHide();

				if(val == 0){

				}else if(val == 999999){
					$('#cat-name-field').val("");
					$('#cat-add-btn,#cat-name-field').show();
					$('#cat-action').val('add-category');
				}else{
					var catname = $("#new-category-form option:selected").text();
					$('#cat-edit-btn,#cat-del-btn,#cat-name-field').show();
					$('#cat-name-field').val(catname.replace('EDIT: ','').replace(/^\s/,''));
					$('#cat-action').val('edit-category');
				}
			});

			$('#cat-del-btn').click(function(){
				$('#cat-action').val('del-category');
				return confirm('Are you sure ?');
			})

		}


	}


};