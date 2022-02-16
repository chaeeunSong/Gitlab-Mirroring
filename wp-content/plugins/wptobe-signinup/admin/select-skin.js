jQuery(document).ready(function($) {
	// 스킨선택
	$("#selectSkin").change(function(){
		var selectedSkin =  $(this).val();
		//alert(selectedSkin);

		var data = {
			'action': 'act_select_a_skin',
			'skin_name': selectedSkin,
			'security': SelSkin.security
		};

		$.post(ajaxurl, data, function(response) {
			//alert(response);
		});
	});
});
