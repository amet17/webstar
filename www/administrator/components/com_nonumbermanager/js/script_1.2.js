/**
 * JavaScript file (MooTools 1.2 compatible)
 *
 * @package     NoNumber! Extension Manager
 * @version     2.3.1
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

window.addEvent( 'domready', function() {
	nnManager = new nnManager();
});

var nnManager = new Class({

	initialize: function()
	{
		this.urls = {
			'selected': new Array(),
			'install': new Array(),
			'update': new Array()
		};
		this.counters = {
			'install': 0,
			'update': 0
		};
		this.timers = {
			'install': 0,
			'update': 0
		};
		this.versions = new Array();
	},

	load_extensions: function( load_external )
	{
		var self = this;

		document.getElement( '#nonumbermanager_langs_title' ).setStyle( 'display', 'none' );
		$each( document.getElements( '.link_all .link_ready' ), function( el ) {
			el.setStyle( 'display', 'none' );
		});
		$each( document.getElements( '.link_all .link_loading' ), function( el ) {
			el.setStyle( 'display', 'block' );
		});

		document.getElement( '#link_toggle_notinstalled' ).setStyle( 'display', 'none' );

		var delay = 0;
		$each( nn_extensions, function( extension ) {
			self.versions[extension.alias] = null;
			( function() { self.load_local_data( extension.id, extension.alias, extension.types, load_external ); } ).delay( delay );
			delay = delay+100;
		});

		( function() {
			self.load_license( 'all' );
		} ).delay( delay );
	},

	load_extension: function( id, alias, types )
	{
		this.versions[alias] = null;
		this.load_local_data( id, alias, types );
		this.reload_external_data( id, alias, 1 );
	},

	load_local_data: function( id, alias, types, load_external )
	{
		if ( id == 'all' ) {
			return;
		}

		$each( document.getElements( '.local_'+id+'_result' ), function( el ) {
			el.setStyle( 'display', 'none' );
		});
		$each( document.getElements( '.local_'+id+'_loading' ), function( el ) {
			el.setStyle( 'display', 'block' );
		});

		var url = 'index.php?nn_qp=1&folder=administrator.components.com_nonumbermanager&file=details.inc.php&ext='+alias+'&types='+types;
		nnScripts.loadajax( url, 'nnManager.set_local_data( \''+id+'\', \''+alias+'\', data.trim(), \''+load_external+'\' )', 'nnManager.set_local_data( \''+id+'\', \''+alias+'\', 0, \''+load_external+'\' )', NNEM_QUERY );
	},

	set_local_data: function( id, alias, data, load_external )
	{
		$each( document.getElements( '.local_'+id+'_loading' ), function( el ) {
			el.setStyle( 'display', 'none' );
		});

		this.versions[alias] = '';
		if ( data === 0 ) {
			document.getElement( '#version_'+id+'_failed' ).setStyle( 'display', 'block' );
			document.getElement( '#row_'+id ).removeClass( 'notinstalled' );
		} else if ( data == '' ) {
			document.getElement( '#row_'+id ).addClass( 'notinstalled' );
			document.getElement( '#link_toggle_notinstalled' ).setStyle( 'display', 'block' );
			document.getElement( '#version_state_'+id+'_install' ).setStyle( 'display', 'block' );
		} else {
			var data_parts = data.split( '|' );
			this.versions[alias] = data_parts.shift();
			document.getElement( '#version_'+id+'_version' ).set( 'text', this.versions[alias] ).setStyle( 'display', 'block' );
			if ( data_parts.length ) {
				$each( document.getElements( '#version_state_'+id+'_incomplete span.missing_extension' ), function( el ) {
					el.setStyle( 'display', 'none' );
				});
				for ( var i = 0; i < data_parts.length; i++ ) {
					document.getElement( '#version_state_'+id+'_incomplete span.missing_'+data_parts[i] ).setStyle( 'display', 'inline' );
				}
				document.getElement( '#version_state_'+id+'_incomplete' ).setStyle( 'display', 'block' );
			}
			document.getElement( '#row_'+id ).removeClass( 'notinstalled' );
		}

		if ( load_external == '1' || ( load_external == '2' && data ) ) {
			this.reload_external_data( id, alias, 1 );
		}
	},

	reload_external_data: function( id, alias, count )
	{
		var self = this;
		if ( this.versions[alias] == undefined || this.versions[alias] == null && count < 10 ) {
			( function(){ self.reload_external_data( id, alias, count+1 ); } ).delay( count * 50 );
		} else {
			this.load_external_data( id, alias, self.versions[alias] );
		}
	},

	load_external_data: function( id, alias, version )
	{
		if ( id == 'all' ) {
			return;
		}

		$each( document.getElements( '.external_'+id+'_result' ), function( el ) {
			el.setStyle( 'display', 'none' );
		});
		$each( document.getElements( '.external_'+id+'_loading' ), function( el ) {
			el.setStyle( 'display', 'block' );
		});
		$each( document.getElements( 'tr#row_'+id+' input.check_checkbox' ), function( el ) {
			el.checked = 0;
		});

		var url = 'http://www.nonumber.nl/scripts/extension.php?ext='+id+'&version='+version;
		nnScripts.loadajax( url, 'nnManager.set_external_data( \''+id+'\', \''+alias+'\', data.trim() )', 'nnManager.set_external_data( \''+id+'\', \''+alias+'\', 0 )', NNEM_QUERY );
	},

	set_external_data: function( id, alias, data )
	{
		$each( document.getElements( '.external_'+id+'_loading' ), function( el ) {
			el.setStyle( 'display', 'none' );
		});

		if ( data != 0 && data != '' ) {
			var xml = null;
			if (window.DOMParser) {
				var parser = new DOMParser();
				xml = parser.parseFromString( data, "text/xml" );
			} else {
				// Internet Explorer
				xml = new ActiveXObject( 'Microsoft.XMLDOM' );
				xml.async = 'false';
				xml.loadXML( data );
			}

			var changelog = '';
			if ( xml.getElementsByTagName('changelog')[0].firstChild ) {
				changelog = xml.getElementsByTagName('changelog')[0].firstChild.nodeValue;
			}
			document.getElements( '#changelog_'+id+'_success span' )
				.set( 'title', NNEM_CHANGELOG+'::'+changelog )
				.store( 'tip:title', NNEM_CHANGELOG )
				.store( 'tip:text', changelog );
			JTooltips = new Tips( document.getElements( '#changelog_'+id+'_success span' ), { fixed: 1, className: 'changlog-tip tool' } );
			document.getElement( '#changelog_'+id+'_success' ).setStyle( 'display', 'block' );

			this.set_version_state( id, alias, xml );

		} else {
			$each( document.getElements( '.external_'+id+'_failed' ), function( el ) {
				el.setStyle( 'display', 'block' );
			});
		}
	},

	set_version_state: function( id, alias, xml )
	{
		var self = this;

		var current_version = 0;
		var new_version = 0;
		var version_state = '';
		var state = '';
		var link = '';

		if ( xml.getElementsByTagName('version')[0].getElementsByTagName('installed')[0].firstChild ) {
			current_version = xml.getElementsByTagName('version')[0].getElementsByTagName('installed')[0].firstChild.nodeValue;
		}
		if ( xml.getElementsByTagName('version')[0].getElementsByTagName('new')[0].firstChild ) {
			new_version = xml.getElementsByTagName('version')[0].getElementsByTagName('new')[0].firstChild.nodeValue;
		}
		if ( xml.getElementsByTagName('version')[0].getElementsByTagName('state')[0].firstChild ) {
			version_state = xml.getElementsByTagName('version')[0].getElementsByTagName('state')[0].firstChild.nodeValue;
		}
		if ( xml.getElementsByTagName('downloadurl')[0].firstChild ) {
			link = xml.getElementsByTagName('downloadurl')[0].firstChild.nodeValue;
		}

		if ( !current_version ) {
			state = 'install';
		} else if ( version_state == 'newer' ) {
			state = 'update';
		} else if ( version_state == 'older' ) {
			state = 'downgrade';
		} else {
			state = 'uptodate';
		}

		if ( link != '' ) {
			$each( document.getElements( '#row_'+id+' .new_version_number' ), function( el ) {
				el.set( 'text', 'v'+new_version );
			});
			document.getElement( '#version_button_'+id+'_'+state )
				.setStyle( 'display', 'block' )
				.addEvent( 'click', function() { self.install_extension( link, state ); } );
			if ( state == 'install' || state == 'update' ) {
				this.add_url( link, state );
			}
			$each( document.getElements( '#check_'+id+' input' ), function( el ) {
				el.value = link;
			});
			if ( state != 'uptodate' && state != 'downgrade' ) {
				document.getElement( '#check_'+id ).setStyle( 'display', 'block' );
				document.getElement( '#link_installselected_loading' ).setStyle( 'display', 'none' );
				document.getElement( '#link_installselected_ready' ).setStyle( 'display', 'block' );
			}
			if ( state != 'install' ) {
				var url = 'index.php?nn_qp=1&folder=administrator.components.com_nonumbermanager&file=details.inc.php&ext='+alias+'&types=langs';
				nnScripts.loadajax( url, 'nnManager.get_langs( \''+id+'\', data.trim() )', '', NNEM_QUERY );
			}
		}
		document.getElement( '#version_state_'+id+'_'+state ).setStyle( 'display', 'block' );
	},

	get_langs: function( id, data )
	{
		if ( data == 0 && data == '' ) {
			return;
		}

		var url = 'http://www.nonumber.nl/scripts/extension2.php?ext='+id+data;
		nnScripts.loadajax( url, 'nnManager.set_lang_state( \''+id+'\', data.trim() )', '', NNEM_QUERY );

	},

	set_lang_state: function( id, data )
	{
		if ( data == 0 && data == '' ) {
			return;
		}

		var xml = null;
		if (window.DOMParser) {
			var parser = new DOMParser();
			xml = parser.parseFromString( data, "text/xml" );
		} else {
			// Internet Explorer
			xml = new ActiveXObject( 'Microsoft.XMLDOM' );
			xml.async = 'false';
			xml.loadXML( data );
		}
		if ( !xml ) {
			return;
		}

		hasLangs = 0;

		var tag ='';
		var lang ='';
		var link = '';
		var current_version = 0;
		var new_version = 0;
		var version_state = '';
		var state = '';

		var langs = xml.getElementsByTagName('language');

		var list = new Element( 'ul', {
			'class': 'nonumbermanager_list_langs'
		});

		for ( i=0; i<langs.length; i++ ) {
			l = langs[i];

			tag = l.getAttribute( 'tag' );
			lang ='';
			link = '';
			current_version = 0;
			new_version = 0;
			version_state = '';
			state = '';


			if ( l.getElementsByTagName('lang')[0].firstChild ) {
				lang = l.getElementsByTagName('lang')[0].firstChild.nodeValue;
			}
			if ( l.getElementsByTagName('downloadurl')[0].firstChild ) {
				link = l.getElementsByTagName('downloadurl')[0].firstChild.nodeValue;
			}
			if ( l.getElementsByTagName('version')[0].getElementsByTagName('installed')[0].firstChild ) {
				current_version = l.getElementsByTagName('version')[0].getElementsByTagName('installed')[0].firstChild.nodeValue;
			}
			if ( l.getElementsByTagName('version')[0].getElementsByTagName('new')[0].firstChild ) {
				new_version = l.getElementsByTagName('version')[0].getElementsByTagName('new')[0].firstChild.nodeValue;
			}
			if ( l.getElementsByTagName('version')[0].getElementsByTagName('state')[0].firstChild ) {
				version_state = l.getElementsByTagName('version')[0].getElementsByTagName('state')[0].firstChild.nodeValue;
			}
			if ( version_state != 'older' && version_state != 'same' ) {
				hasLangs = 1;
				new Element( 'a', {
					href: 'javascript://',
					html: lang+' ('+new_version+')',
					onclick: 'nnManager.install_extension(\''+link+'\');'
				}).inject( new Element( 'li' ).inject( list ) ) ;
			}
		}

		if ( hasLangs ) {
			document.getElement( '#nonumbermanager_langs_title' ).setStyle( 'display', 'block' );
			document.getElement( '#version_button_'+id+'_langs' ).empty().grab( list ).setStyle( 'display', 'block' );
		}
	},

	// INSTALL
	install_extension: function( url, state )
	{
		var text = '';
		switch ( state ) {
			case 'uptodate':
				text = NNEM_UPTODATE;
				break;
			case 'downgrade':
				text = NNEM_DOWNGRADE;
				break;
			default:
				text = NNEM_AREYOUSURE;
				break;
		}

		if( !confirm( text ) ) {
			return;
		}

		text = '';
		switch ( state ) {
			case 'update':
				text = NNEM_UPDATING;
				break;
			case 'uptodate':
				text = NNEM_REINSTALLING;
				break;
			case 'downgrade':
				text = NNEM_DOWNGRADING;
				break;
			default:
				text = NNEM_INSTALLING;
				break;
		}

		nnScripts.overlay.open( 0.7, text );

		url = 'index.php?option=com_nonumbermanager&task=install&url='
			+escape( url );
		var query = NNEM_QUERY+'&'+NNEM_TOKEN+'=1';
		nnScripts.loadajax( url, 'nnManager.redirect( data )', 'nnManager.redirect( 0 )', query );
	},

	add_url: function( url, task )
	{
		var self = this;

		this.counters[task] = 0;
		$clear( this.timers[task] );
		this.timers[task] = ( function(){ self.counters[task]++; } ).periodical( 500 );

		this.urls[task][this.urls[task].length] = url;

		this.show_allbutton( task );
	},

	show_allbutton: function( task )
	{
		var self = this;

		if ( this.timers[task] ) {
			if ( this.counters[task] < 3 ) {
				( function(){ self.show_allbutton( task ); } ).delay( 500 );
			} else {
				this.counters[task] = 0;
				$clear( this.timers[task] );
				this.timers[task] = 0;

				document.getElement( '#link_'+task+'all_loading' ).setStyle( 'display', 'none' );
				document.getElement( '#link_'+task+'all_ready' ).setStyle( 'display', 'block' );
			}
		}
	},

	install_selected: function()
	{
		var self = this;

		this.uncheck_hidden();

		this.urls['selected'] = new Array();
		$each( document.getElements( 'input.check_checkbox' ), function( el ){
			if ( el.checked && el.value ) {
				self.urls['selected'][self.urls['selected'].length] = el.value;
			}
			el.checked = 0;
		});
		document.getElement( '#check_toggle' ).checked = false;

		if ( this.urls['selected'].length ) {
			this.install_extensions( 'selected' );
		} else {
			alert( NNEM_NONESELECTED );
		}
	},

	install_extensions: function( task )
	{
		if( !confirm( NNEM_AREYOUSURE ) ) {
			return;
		}

		var text = NNEM_INSTALLING;
		if ( task == 'update' ) {
			text = NNEM_UPDATING;
		}
		nnScripts.overlay.open( 0.7, text, '( '+NNEM_MAYTAKEAWHILE+' )' );

		this.urls[task] = this.array_unique( this.urls[task] );
		this.install_walk( task, this.urls[task], NNEM_TOKEN );
	},

	install_walk: function( task, urls, token, data )
	{
		if ( data && data.indexOf( '<dt class="error">Error</dt>' ) !== -1 ) {
			this.redirect( data );
			return;
		}

		if ( urls != '' && typeof urls !== 'object' ) {
			urls = urls.toString().split( ',' );
		}

		if ( urls == '' || !urls.length ) {
			var msgs = '';
			if ( task == 'update' ) {
				msgs = '<dd class="message"><ul><li>'+NNEM_EXTENSIONSUPDATED+'</li></ul></dd>';
			} else {
				msgs = '<dd class="message"><ul><li>'+NNEM_EXTENSIONSINSTALLED+'</li></ul></dd>';
			}
			msgs = msgs+'<dd class="notice"><ul><li>'+NNEM_CLEANCACHE+'</li></ul></dd>';

			msgs = '<dl id="system-message">'+msgs+'</dl>'
			this.redirect(msgs);
			return;
		}

		var url = 'index.php?option=com_nonumbermanager&task=install&url='
			+escape( urls.shift() );
		var query = NNEM_QUERY+'&'+NNEM_TOKEN+'=1';
		nnScripts.loadajax( url, 'nnManager.install_walk( \''+task+'\', \''+urls+'\',\''+token+'\', data )', 'nnManager.redirect( 0 )', query );
	},

	redirect: function( data )
	{
		if ( !data ) {
			data = '<dl id="system-message"><dd class="error"><ul><li>'+NNEM_INSTALLATIONFAILED+'</li></ul></dd></dl>';
		} else {
			if ( data.indexOf( '<dl id="system' ) === -1 ) {
				data = '';
			} else {
				data = data.replace( /[ \s\n]+/g, ' ' ).replace( /^.*(<dl id="system.*<\/dl>).*$/gi, '\$1' ).trim();
			}
		}
		var form = document.adminForm;

		var myInput = document.createElement( 'input' ) ;
		myInput.setAttribute( 'type' , 'hidden' ) ;
		myInput.setAttribute( 'name' , 'msgs' ) ;
		myInput.setAttribute( 'value', data.replace(/\"/g, '\\$&' ) );
		form.appendChild( myInput ) ;

		submitform();
	},


	// LICENSES
	save_license: function( id )
	{
		if ( id == 'all' ) {
			$each( document.getElements( '.license_result' ), function( el ) {
				el.setStyle( 'display', 'none' );
			});
			$each( document.getElements( '.license_loading' ), function( el ) {
				el.setStyle( 'display', 'block' );
			});
		} else {
			$each( document.getElements( '.license_'+id+'_result' ), function( el ) {
				el.setStyle( 'display', 'none' );
			});
			$each( document.getElements( '.license_'+id+'_loading' ), function( el ) {
				el.setStyle( 'display', 'block' );
			});
		}

		var field = document.getElement( '#license_code_'+id );

		var url = 'index.php?option=com_nonumbermanager&task=save&extension='+id+'&code='+field.value;
		nnScripts.loadajax( url, 'nnManager.load_license( \''+id+'\', data.trim() )', '', NNEM_QUERY );
	},

	load_license: function( id )
	{
		if ( id == 'nonumbermanager' ) {
			return
		}

		$each( document.getElements( '.license_'+id+'_result' ), function( el ) {
			el.setStyle( 'display', 'none' );
		});
		$each( document.getElements( '.license_'+id+'_loading' ), function( el ) {
			el.setStyle( 'display', 'block' );
		});

		if ( !document.getElement( '#license_state_'+id+'_valid' ) ) {
			this.set_licensestate( id, 'local' );
			return;
		}

		var field = document.getElement( '#license_code_'+id );
		if ( field.value ) {
			var host = document.getElement( '#license_host' );
			var url = 'http://www.nonumber.nl/scripts/license.php?host='+host.value+'&code='+field.value+'&ext='+id;
			nnScripts.loadajax( url, 'nnManager.set_licensestate( \''+id+'\', data.trim() )', 'nnManager.set_licensestate( \''+id+'\', \'failed\' )', NNEM_QUERY );
		} else {
			this.set_licensestate( id, '' );
		}
	},

	load_licenses: function( valid )
	{
		var self = this;

		$each( nn_extensions, function( extension ) {
			if ( extension.id != 'nonumbermanager' ) {
				$each( document.getElements( '.license_'+extension.id+'_result' ), function( el ) {
					el.setStyle( 'display', 'none' );
				});
				$each( document.getElements( '.license_'+extension.id+'_loading' ), function( el ) {
					el.setStyle( 'display', 'block' );
				});
				if ( valid ) {
					self.set_licensestate( extension.id, 'allvalid' );
				} else {
					self.load_license( extension.id );
				}
			}
		});
	},

	set_licensestate: function( id, state )
	{
		$each( document.getElements( '.license_'+id+'_loading' ), function( el ) {
			el.setStyle( 'display', 'none' );
		});
		$each( document.getElements( '.license_'+id+'_result' ), function( el ) {
			el.setStyle( 'display', 'none' );
		});

		if ( state == 'allvalid' ) {
			document.getElement( '#license_code_'+id+'_allvalid' ).value = document.getElement( '#license_code_all' ).value;
			document.getElement( '#license_field_'+id+'_allvalid' ).setStyle( 'display', 'block' );
		} else {
			document.getElement( '#license_field_'+id+'_field' ).setStyle( 'display', 'block' );
		}

		if ( state != '' ) {
			var color = '#999999';
			switch( state) {
				case 'allvalid':
				case 'valid':
					color = '#006600';
					break;
				case 'invalid':
					color = '#990000';
					break;
				case 'local':
					color = '#999999';
					break;
				default:
					color = '#999999';
					state = 'failed';
					break;
			}
			document.getElement( '#license_code_'+id).setStyle( 'color', color );
			document.getElement( '#license_state_'+id+'_'+state).setStyle( 'display', 'block' );
		}

		if ( id == 'all' ) {
			this.load_licenses( ( state == 'valid' ) );
		}

	},

	show_notinstalled: function()
	{
		this.uncheck_hidden();
		document.getElement( '#nonumbermanager_table' ).removeClass( 'hidenotinstalled' );
		document.getElement( '#link_show_notinstalled' ).setStyle( 'display', 'none' );
		document.getElement( '#link_hide_notinstalled' ).setStyle( 'display', 'block' );
	},
	hide_notinstalled: function()
	{
		document.getElement( '#nonumbermanager_table' ).addClass( 'hidenotinstalled' );
		document.getElement( '#link_hide_notinstalled' ).setStyle( 'display', 'none' );
		document.getElement( '#link_show_notinstalled' ).setStyle( 'display', 'block' );
		this.uncheck_hidden();
	},
	uncheck_hidden: function()
	{
		$each( document.getElements( '.hidenotinstalled tr.notinstalled input.check_checkbox' ), function( el ) {
			el.checked = 0;
		});
		$each( document.getElements( 'div.check' ), function( el ) {
			if ( el.getStyle( 'display' ) == 'none' ) {
				$each( el.getElements( 'input.check_checkbox' ), function( cb ) {
					cb.checked = 0;
				});
			}
		});
	},

	// CUSTOM FUNCTIONS
	array_unique: function( a )
	{
		var r = new Array();
		o:for(var i = 0, n = a.length; i < n; i++) {
			for(var x = i + 1 ; x < n; x++) {
				if(a[x]==a[i]) continue o;
			}
			r[r.length] = a[i];
		}
		return r;
	},

	stringToXML: function( string )
	{
		var xml;

		if ( Browser.Engine.trident ){
			xml = new ActiveXObject( 'Microsoft.XMLDOM' );
			xml.async = false;
			xml.loadXML(string);
		} else {
			xml = new DOMParser().parseFromString( string, 'text/xml' );
		}

		return xml;
	}
});