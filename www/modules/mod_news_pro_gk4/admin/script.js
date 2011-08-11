window.addEvent("domready",function(){
	var tabs = [];
	var options = [];
	var opt_iterator = -1;
	var base_table = $ES('.adminform .admintable',$$('#element-box .m')[0])[2];
	var update_url = 'http://www.gavick.com/updates.raw?task=json&tmpl=component&query=product&product=mod_news_pro_gk4';
	
	$$('#menu-pane .panel')[0].getElements('.paramlist_value').each(function(el){
		if(!$E('input', el) && !$E('select', el) && !$E('textarea', el)){
			opt_iterator++;
			var div_gen = new Element('div',{"class":"gk_opt"});
			div_gen.innerHTML = '<span class="gk_text">'+el.innerHTML+'</span><span class="gk_btn">Toggle</span>';
			div_gen.injectBefore(base_table.getParent().getParent());
			tabs.push(div_gen);
			options[opt_iterator] = [];
		}else options[opt_iterator].push(el.getParent());
	});

	options.each(function(el,i){
		var div = new Element('div',{"class":"gk_opts"});
		div.innerHTML = '<td colspan="2"><table cellspacing="1" width="100%" class="paramlist admintable"><tbody></tbody></table></td>';
		div.injectAfter(tabs[i]);
		div_body = div.getElementsBySelector('tbody')[0];
		options[i].each(function(elm,j){ elm.injectInside(div_body); });
	});
	
	var update_tab = new Element('div',{"class":"gk_opt","id":"gk_update"});
	update_tab.innerHTML = '<span class="gk_text">Updates</span><span class="gk_btn">Toggle</span>';
	
	update_tab.injectAfter($$('.gk_opts').getLast());
	var update_div = new Element('div',{"class":"gk_opts"});
	
	update_div.innerHTML = '<div id="gk_update_div"><span id="gk_loader"></span>Loading update data from GavicPro Update service...</div>';
	update_div.injectAfter($$('.gk_opt').getLast());
	
	//base_table.remove();
	//$$('.jpane-slider')[0].remove();
	
	$('param-page').getParent().setStyle('display','none');
	
	$('gk_update').addEvent("click", function(){
		new Asset.javascript(update_url,{
	   		id: "new_script",
	   		onload: function(){
  				$('gk_update_div').innerHTML = '<p>All updates available for this module:</p>';
				$GK_UPDATE.each(function(el){
	  				$('gk_update_div').innerHTML += '<div class="gk_update"><span class="gk_update_version"><strong>Version:</strong> ' + el.version + ' </span><span class="gk_update_data"><strong>Date:</strong> ' + el.date + ' </span><span class="gk_update_link"><a href="' + el.link + '">Download this update</a></span></div>';
				});
				if($$('.gk_update').length == 0) $('gk_update_div').innerHTML += '<p>No updates available</p>';	
	   		}
		});
		
		if(window.ie){
			var $timer = (function(){
				if(typeof($GK_UPDATE) != undefined){
					$clear($timer);
					alert('Updates data downloaded');
					$('gk_update_div').innerHTML = '<p>All updates available for this module:</p>';
					$GK_UPDATE.each(function(el){
	  					$('gk_update_div').innerHTML += '<div class="gk_update"><span class="gk_update_version"><strong>Version:</strong> ' + el.version + ' </span><span class="gk_update_data"><strong>Date:</strong> ' + el.date + ' </span><span class="gk_update_link"><a href="' + el.link + '">Download this update</a></span></div>';
					});
					if($$('.gk_update').length == 0) $('gk_update_div').innerHTML += '<p>No updates available</p>';	
				}
			}).periodical(250);
		}
	});
	//
	var data_sources = [$('paramscom_sections'), $('paramscom_categories'), $('paramscom_articles'), $('paramsk2_categories'), $('paramsk2_tags'), $('paramsk2_articles'), $('paramsvm_categories'), $('paramsvm_products')];
	//
	data_sources.each(function(el,j){
		el.getParent().getParent().setStyle('display','none');
	});
	
	$('params'+$('paramsdata_source').value).getParent().getParent().setStyle('display','');
	
	$('paramsdata_source').addEvent("change", function(){
		data_sources.each(function(el,j){
			el.getParent().getParent().setStyle('display','none');
		});
	
		$('params'+$('paramsdata_source').value).getParent().getParent().setStyle('display','');	
		$$('.gk_opts')[1].setStyle('height','auto');
	});
	$('paramsdata_source').addEvent("blur", function(){
		data_sources.each(function(el,j){
			el.getParent().getParent().setStyle('display','none');
		});
	
		$('params'+$('paramsdata_source').value).getParent().getParent().setStyle('display','');
		$$('.gk_opts')[1].setStyle('height','auto');
	});
	//
	if($('paramslinks_position').value == 'bottom') $('paramslinks_width').getParent().getParent().setStyle('display','none');
	else $('paramslinks_width').getParent().getParent().setStyle('display','');	
		
	$('paramslinks_position').addEvent('change', function(){
		if($('paramslinks_position').value == 'bottom') $('paramslinks_width').getParent().getParent().setStyle('display','none');
		else $('paramslinks_width').getParent().getParent().setStyle('display','');	
		$$('.gk_opts')[3].setStyle('height','auto');
	});

	$('paramslinks_position').addEvent('blur', function(){
		if($('paramslinks_position').value == 'bottom') $('paramslinks_width').getParent().getParent().setStyle('display','none');
		else $('paramslinks_width').getParent().getParent().setStyle('display','');
		$$('.gk_opts')[3].setStyle('height','auto');
	});
	
	var horder = $('paramsnews_header_order');
	var iorder = $('paramsnews_image_order');
	var torder = $('paramsnews_text_order');
	var inorder = $('paramsnews_info_order');
	var in2order = $('paramsnews_info2_order');
	var k2storeorder = $('paramsk2store_order');
	
	var k2storeinfo = new Element('a', {'href': '#', 'class' : 'nav-link'});
	k2storeinfo.innerHTML = 'Enable it in the K2Store settings tab';
	k2storeinfo.injectAfter(k2storeorder);
	k2storeinfo.addEvent('click', function(e){ new Event(e).stop(); acc.display(6);  });
	$('k2storeinfo').addEvent('click', function(e){ new Event(e).stop(); acc.display(6);  });
	
	[horder, iorder, torder, inorder, in2order, k2storeorder].each(function(elm) {
		elm.addEvent("change", function(){
			var unexisting = [false, false, false, false, false, false];
			unexisting[horder.value - 1] = true;
			unexisting[iorder.value - 1] = true;
			unexisting[torder.value - 1] = true;
			unexisting[inorder.value - 1] = true;
			unexisting[in2order.value - 1] = true;
			unexisting[k2storeorder.value - 1] = true;
			
			var searched = 0;
			for(var i = 0; i < 6; i++) if(!unexisting[i]) searched = i+1;
			
			[horder, iorder, torder, inorder, in2order, k2storeorder].each(function(el) { 
				if(elm != el && el.value == elm.value) el.value = searched; 
			});
		});
	});
	
	$$('.input-pixels').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">px</span>"});
	$$('.input-percents').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">%</span>"});
	$$('.input-minutes').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">minutes</span>"});
	$$('.input-ms').each(function(el){el.getParent().innerHTML = el.getParent().innerHTML + "<span class=\"unit\">ms</span>"});

    if(!window.ie) {
        $$('.last-in-group').each(function(el){
            var new_tr = new Element('tr');
            var elm = el.getParent().getParent();
            new_tr.injectAfter(elm);
            new_tr.innerHTML = '<td width="40%" style="height:5px;background:#eee;" class="paramlist_key"></td><td class="paramlist_value" style="height:5px;background:#eee;"></td>';
	   });
    }	
	
	$$('.text-limit').each(function(el){
		var tr = el.getParent().getParent();
		var destination = tr.getPrevious().getElements('td')[1];
		var element = tr.getElements('td input')[0];
		element.injectTop(destination);
		tr.remove();		
	});
	
	$$('.float').each(function(el){
		var tr = el.getParent().getParent();
		var destination = tr.getPrevious().getElements('td')[1];
		var element = tr.getElements('td select')[0];
		element.injectTop(destination);
		tr.remove();	
	});
	
	$$('.enabler').each(function(el){
		var tr = el.getParent().getParent();
		var destination = tr.getPrevious().getElements('td')[1];
		var element = tr.getElements('td select')[0];
		element.injectInside(destination);
		tr.remove();	
	});
	
	$$('.gk_switch').each(function(el){
		el.setStyle('display','none');
		var style = (el.value == 1) ? 'on' : 'off';
		var switcher = new Element('div',{'class' : 'switcher-'+style});
		switcher.injectAfter(el);
		switcher.addEvent("click", function(){
			if(el.value == 1){
				switcher.setProperty('class','switcher-off');
				el.value = 0;
			}else{
				switcher.setProperty('class','switcher-on');
				el.value = 1;
			}
		});
	});
	
	var acc = new Accordion($$('.gk_opt'),$$('.gk_opts'),{
		onActive:function(toggler){ toggler.setProperty("class","gk_opt active"); },
		onBackground:function(toggler){ toggler.setProperty("class","gk_opt"); },
		alwaysHide: true,
		duration:200
	});
	
	[$('paramssimple_crop_top'),$('paramssimple_crop_bottom'),$('paramssimple_crop_left'),$('paramssimple_crop_right')].each(function(elm) {
		elm.getParent().getParent().setStyle('display', 'none');
	});
	
	$('simple_crop_top').value = $('paramssimple_crop_top').value;
	$('simple_crop_bottom').value = $('paramssimple_crop_bottom').value;
	$('simple_crop_left').value = $('paramssimple_crop_left').value;
	$('simple_crop_right').value = $('paramssimple_crop_right').value;
	
	
	
	$('simple_crop_crop').setStyles({
		'margin-top': $('paramssimple_crop_top').value + "%",
		'margin-left': $('paramssimple_crop_left').value + "%",
		'margin-right': $('paramssimple_crop_right').value + "%",
		'margin-bottom': $('paramssimple_crop_bottom').value + "%",
		'height': (200.0 - ( (200.0 * ( $('paramssimple_crop_top').value * 1 + $('paramssimple_crop_bottom').value * 1 ) ) / 100.0 ) ) + "px",
		'width': (200.0 - ( (200.0 * ( $('paramssimple_crop_left').value * 1 + $('paramssimple_crop_right').value * 1 ) ) / 100.0 ) ) + "px"  
	});	
	
	$('simple_crop_top').addEvent('change', function() {
		$('paramssimple_crop_top').value = $('simple_crop_top').value;
		$('simple_crop_crop').setStyle('margin-top', $('paramssimple_crop_top').value + "%");
		$('simple_crop_crop').setStyle('height', (200.0 - ( (200.0 * ( $('paramssimple_crop_top').value * 1 + $('paramssimple_crop_bottom').value * 1 ) ) / 100.0 ) ) + "px" );		
	});
	
	$('simple_crop_top').addEvent('blur', function() {
		$('paramssimple_crop_top').value = $('simple_crop_top').value;
		$('simple_crop_crop').setStyle('margin-top', $('paramssimple_crop_top').value + "%");
		$('simple_crop_crop').setStyle('height', (200.0 - ( (200.0 * ( $('paramssimple_crop_top').value * 1 + $('paramssimple_crop_bottom').value * 1 ) ) / 100.0 ) ) + "px" );									
	});
	
	$('simple_crop_bottom').addEvent('change', function() {
		$('paramssimple_crop_bottom').value = $('simple_crop_bottom').value;
		$('simple_crop_crop').setStyle('margin-bottom', $('paramssimple_crop_bottom').value + "%");	
		$('simple_crop_crop').setStyle('height', (200.0 - ( (200.0 * ( $('paramssimple_crop_top').value * 1 + $('paramssimple_crop_bottom').value * 1 ) ) / 100.0 ) ) + "px" );		
	});
	
	$('simple_crop_bottom').addEvent('blur', function() {
		$('paramssimple_crop_bottom').value = $('simple_crop_bottom').value;
		$('simple_crop_crop').setStyle('margin-bottom', $('paramssimple_crop_bottom').value + "%");	
		$('simple_crop_crop').setStyle('height', (200.0 - ( (200.0 * ( $('paramssimple_crop_top').value * 1 + $('paramssimple_crop_bottom').value * 1 ) ) / 100.0 ) ) + "px" );	
	});
	
	$('simple_crop_left').addEvent('change', function() {
		$('paramssimple_crop_left').value = $('simple_crop_left').value;
		$('simple_crop_crop').setStyle('margin-left', $('paramssimple_crop_left').value + "%");	
		$('simple_crop_crop').setStyle('width', (200.0 - ( (200.0 * ( $('paramssimple_crop_left').value * 1 + $('paramssimple_crop_right').value * 1 ) ) / 100.0 ) ) + "px" );
	});
	
	$('simple_crop_left').addEvent('blur', function() {
		$('paramssimple_crop_left').value = $('simple_crop_left').value;
		$('simple_crop_crop').setStyle('margin-left', $('paramssimple_crop_left').value + "%");
		$('simple_crop_crop').setStyle('width', (200.0 - ( (200.0 * ( $('paramssimple_crop_left').value * 1 + $('paramssimple_crop_right').value * 1 ) ) / 100.0 ) ) + "px" );	
	});
	
	$('simple_crop_right').addEvent('change', function() {
		$('paramssimple_crop_right').value = $('simple_crop_right').value;
		$('simple_crop_crop').setStyle('margin-right', $('paramssimple_crop_right').value + "%");
		$('simple_crop_crop').setStyle('width', (200.0 - ( (200.0 * ( $('paramssimple_crop_left').value * 1 + $('paramssimple_crop_right').value * 1 ) ) / 100.0 ) ) + "px" );
	});
	
	$('simple_crop_right').addEvent('blur', function() {
		$('paramssimple_crop_right').value = $('simple_crop_right').value;
		$('simple_crop_crop').setStyle('margin-right', $('paramssimple_crop_right').value + "%");
		$('simple_crop_crop').setStyle('width', (200.0 - ( (200.0 * ( $('paramssimple_crop_left').value * 1 + $('paramssimple_crop_right').value * 1 ) ) / 100.0 ) ) + "px" );
	});
});