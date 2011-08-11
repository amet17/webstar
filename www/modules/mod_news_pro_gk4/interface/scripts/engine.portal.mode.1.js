window.addEvent("load", function(){	
    $$('.nsp_main_portal_mode1').each(function(module){
		var id = module.getProperty('id');
		var $G = $Gavick[id];
		var current_art = 0;
		var arts = module.getElements('.nsp_art');
		var auto_anim = module.hasClass('autoanim');
		var anim_speed = $G['animation_speed'];
		var anim_interval = $G['animation_interval'];
		var animation = false;
		var scrollWrap = module.getElement('.nsp_arts');
		var scroller = new Fx.Scroll(scrollWrap, {duration: anim_speed, wheelStops: false});
		var dimensions = scrollWrap.getSize();
		var startItem = 0;
		var sizeWrap = scrollWrap.getCoordinates();
		// reset
		scroller.scrollTo(0,0);
		//
		if(arts.length > 0 && dimensions.scrollSize.y > dimensions.size.y){
			// find first unvisible news
			var found = false;
			//
			for(var i = 0; i < arts.length && !found; i++) {
				var size = arts[i].getCoordinates();
				if((size.top - sizeWrap.top) + size.height - 10 > dimensions.size.y) {
					found = i;
				}	
			}
			//
			start_item = found;
		}
		
		if(module.getElement('.nsp_top_interface .prev')) {
			module.getElement('.nsp_top_interface .prev').addEvent('click', function() {
				animation = true;
				
				if(current_art == 0) {
					current_art = arts.length - 1;
				} else {
					current_art--;
				}
				
				if(current_art > 0) {
					var to = arts[current_art].getCoordinates();
					scroller.scrollTo(0, Math.abs(sizeWrap.height - ((to.top - sizeWrap.top) + to.height)));
				} else {
					scroller.scrollTo(0,dimensions.scrollSize.y);
				}
			});
		}
		
		if(module.getElement('.nsp_top_interface .next')) {
			module.getElement('.nsp_top_interface .next').addEvent('click', function() {
				animation = true;
				
				if(current_art == 0) {
					current_art = start_item;
				} else {
					if(current_art < arts.length - 1) {
						current_art++;
					} else {
						current_art = 0;
					}
				}
				
				if(current_art > 0) {
					var to = arts[current_art].getCoordinates();
					scroller.scrollTo(0, Math.abs(sizeWrap.height - ((to.top - sizeWrap.top) + to.height)));
				} else {
					scroller.scrollTo(0,0);
				}
			});
		}
		
		if(auto_anim){
			(function(){
				if(!animation) module.getElement('.nsp_top_interface .next').fireEvent("click");
				else animation = false;
			}).periodical($G['animation_interval'] / 2);
		}
	});
});