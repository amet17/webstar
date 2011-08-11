window.addEvent("load", function(){	
    $$('.nsp_main_portal_mode3').each(function(module){
		var id = module.getProperty('id');
		var $G = $Gavick[id];
		var current_art = 0;
		var arts = module.getElements('.nsp_title_block');
		var anim_speed = $G['animation_speed'];
		var animation = false;
		var slides = [];
		var animation = false;
		
		module.getElements('.nsp_art_more').removeClass('unvisible');
		
		module.getElements('.nsp_art_more').each(function(el,i) {
			el.setProperty('id', id + '-tab-' + i);
			slides[el.getProperty('id')] = new Fx.Slide(el, {duration:anim_speed}).hide();
			el.setOpacity(0);
			el.setStyle('margin-left', (el.getParent().getParent().getElement('.nsp_title_tab .nsp_date').getSize().size.x - 1) + "px");
		});
		
		module.getElements('.nsp_title_block').each(function(el,i){
			el.addEvent('click', function() {
				if(!animation) {
					animation = true;
					
					if(module.getElement('.nsp_titles .opened')) {
						var elm = module.getElement('.nsp_titles .opened');
						
						if(elm != el) {
							elm.removeClass('opened');
							slides[elm.getElement('.nsp_art_more').getProperty('id')].slideOut();
							
							new Fx.Style(elm.getElement('.nsp_art_more'), 'opacity', { duration: anim_speed }).start(1, 0);
						}
					}
					
					(function() {
						if(el.hasClass('opened')) {
							el.removeClass('opened');
							slides[el.getElement('.nsp_art_more').getProperty('id')].slideOut();	
							
							new Fx.Style(module.getElements('.nsp_art_more')[i], 'opacity', { duration: anim_speed }).start(1, 0);
						} else {
							el.addClass('opened');
							new Fx.Style(module.getElements('.nsp_art_more')[i], 'opacity', { duration: anim_speed }).start(0, 1);
	
							slides[el.getElement('.nsp_art_more').getProperty('id')].slideIn();
						}
					}).delay(anim_speed + 50);
					
					(function() {
						animation = false;
					}).delay((anim_speed * 2) + 50);
				}
			});
		});
		
		if($G['open_first'] == 1) {
			module.getElement('.nsp_title_block').fireEvent('click');
		}
	});
});