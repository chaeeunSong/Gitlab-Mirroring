jQuery(document).ready(function($) {
	// 언어선택
	$("#selectLang").change(function(){
		var selectedLang =  $(this).val();
		//alert(selectedLang);

		var data = {
			'action': 'act_select_a_lang',
			'sel_lang': selectedLang,
			//'security': '<?php echo wp_create_nonce("select_a_lang_nonce"); ?>' 
			'security': SelLang.security
		};

		$.post(ajaxurl, data, function(response) {
			//alert(response);
			location.reload();
		});
	});
});
