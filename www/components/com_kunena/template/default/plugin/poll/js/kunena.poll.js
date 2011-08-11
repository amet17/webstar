/**
* @version $Id: kunena.poll.js 4336 2011-01-31 06:05:12Z severdia $
* Kunena Component
* @package Kunena
*
* @Copyright (C) 2008 - 2011 Kunena Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.kunena.org
**/

window.addEvent('domready', function() {	
	function valuetotaloptions(number){		
		var optiontotal = $('numbertotal');
		if(optiontotal != null) {
			optiontotal.set('value',number);
		}				
	}
	function regleCSS(number_field) {
		$('opt'+number_field).set('style', {
		    'fontWeight': 'bold'		    
		});
	}	
	
	function create_new_field_now(){		
		  var numfield = number_field-1;		  
		  var polldiv = $('kbbcode-poll-options');
		  var hide_input = $('nb_options_allowed');
		  valuetotaloptions(number_field);		  
		  var mydiv = new Element('div', {
			  id:'option'+number_field,
			  text:KUNENA_POLL_OPTION_NAME+" "+number_field
		  });		  
		  $('helpbox').set('value',KUNENA_EDITOR_HELPLINE_OPTION );
		  var input = new Element('input', {
			  name:'polloptionsID[newoption'+numfield+']',
			  id:'field_option'+numfield,
			  maxlength:'50',
			  size:'30',
			  onmouseover: '$("helpbox").set("value", "'+KUNENA_EDITOR_HELPLINE_OPTION+'")'
		  });		  
		  mydiv.injectInside(polldiv).injectBefore(hide_input);
		  input.inject(mydiv);
		  //regleCSS(number_field); //need to test this on IE
		  number_field++;
		}

		//this function insert a text by modifing the DOM, for show infos given by ajax result
		function insert_text_write(textString)
		{				
			var polldiv = $('kbbcode-poll-options');
			var hide_input = $('nb_options_allowed');
			var mydiv = new Element('div');
			
			var span = new Element('span');
			
			var myimg = new Element('img', {
				'src':KUNENA_ICON_ERROR					
			});				
			mydiv.injectInside(polldiv).injectBefore(hide_input);
			mydiv.set('id','option_error');
			myimg.injectInside(mydiv);				

			span.injectInside(mydiv);
			span.set('text', textString);
		}		
			
	if($('kbutton-poll-add') != undefined) {
		$('kbutton-poll-add').onclick = function () {
			var nboptionsmax = $('nb_options_allowed').get('value');			
			if(nboptionsmax == "0") {				
				if(number_field == '1') {
					create_new_field_now();
					create_new_field_now();
				} else {
					create_new_field_now();
				}
			}else {
				if(number_field <= nboptionsmax){
					if(number_field == '1') {
						create_new_field_now();
						create_new_field_now();
					} else {
						create_new_field_now();
					}
				} else {
					if($('option_error')== undefined){
						insert_text_write(KUNENA_POLL_NUMBER_OPTIONS_MAX_NOW);
					}	
				}
			}
		};
	}
	if($('kbutton-poll-rem') != undefined) {
		$('kbutton-poll-rem').onclick = function () {
			if($('option_error')){
				$('option_error').dispose();
			}
			var matable = $('kbbcode-poll-options');		
			if(number_field > 1) {
				number_field = number_field - 1 ;
				var row = $('option'+number_field);
				matable.removeChild(row);
				var value = number_field - 1;
				valuetotaloptions(value);
			}
		};
	}

});	