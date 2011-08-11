window.addEvent("load", function(){	
    $$('.nsp_main_portal_mode2').each(function(module){
		var id = module.getProperty('id');
		var $G = $Gavick[id];
		var current_art = 0;
		var arts = module.getElements('.nsp_art');
		var headline_size = module.getElement('.nsp_art_headline').getSize().size.y;
		var headline_titles = module.getElements('.nsp_art_headline');
		var auto_anim = module.hasClass('autoanim');
		var anim_speed = $G['animation_speed'];
		var anim_interval = $G['animation_interval'];
		var animation = false;
		var scrollWrap = module.getElement('.nsp_arts');
		var scroller = new Fx.Scroll(scrollWrap, {duration: anim_speed, wheelStops: false});
		var headlines = new Fx.Style(module.getElement('.nsp_text_wrap'), 'margin-top', {duration: anim_speed, wheelStops: false});
		var dimensions = scrollWrap.getSize();
		var startItem = 0;
		var sizeWrap = scrollWrap.getCoordinates();
		
		module.getElement('.nsp_art').addClass('active');
		module.getElement('.nsp_arts_scroll').setStyle('width', (arts[arts.length-1].getSize().size.x * arts.length) + 2);
		
		// reset
		scroller.scrollTo(0,0);
		//
		if(module.getElement('.nsp_bottom_interface .prev')) {
			module.getElement('.nsp_bottom_interface .prev').addEvent('click', function() {
				animation = true;
				
				new Fx.Style(headline_titles[current_art], 'opacity', {duration:anim_speed / 2}).start(1,0);
				
				if(current_art == 0) {
					current_art = arts.length - 1;
				} else {
					current_art--;
				}
				
				scroller.toElement(arts[current_art]);
				headlines.start(-1 * headline_size * current_art);
				
				new Fx.Style(headline_titles[current_art], 'opacity', {duration:anim_speed * 2}).start(0,1);
				
				arts.each(function(art,i){
					if(i !== current_art && arts[i].hasClass('active')) {
						arts[i].removeClass('active');
					} else if(i == current_art) {
						if(!arts[i].hasClass('active')) arts[i].addClass('active');
					}
				});
			});
		}
		
		if(module.getElement('.nsp_bottom_interface .next')) {
			module.getElement('.nsp_bottom_interface .next').addEvent('click', function() {
				animation = true;
				
				new Fx.Style(headline_titles[current_art], 'opacity', {duration:anim_speed / 2}).start(1,0);
				
				if(current_art < arts.length - 1) {
					current_art++;
				} else {
					current_art = 0;
				}
				
				scroller.toElement(arts[current_art]);
				headlines.start(-1 * headline_size * current_art);
				
				new Fx.Style(headline_titles[current_art], 'opacity', {duration:anim_speed * 2}).start(0,1);
				
				arts.each(function(art,i){
					if(i !== current_art && arts[i].hasClass('active')) {
						arts[i].removeClass('active');
					} else if(i == current_art) {
						if(!arts[i].hasClass('active')) arts[i].addClass('active');
					}
				});
			});
		}
		
		if(auto_anim){
			(function(){
				if(!animation) module.getElement('.nsp_bottom_interface .next').fireEvent("click");
				else animation = false;
			}).periodical($G['animation_interval'] / 2);
		}
	});
});