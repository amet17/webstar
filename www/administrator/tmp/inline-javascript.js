		window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });var GantrySlideList = ['coresettings', 'presets', 'layouts'];var AdminURI = 'http://portal/administrator/';var UnallowedParams = ['presets', 'cache-enabled', 'cache-time', 'gzipper-enabled', 'gzipper-time', 'gzipper-expirestime', 'gzipper-stripwhitespace', 'rtl-enabled', 'inactive-enabled', 'inactive-menuitem'];
			GantryLang = {
				'preset_title': 'Gantry Presets Saver',
				'preset_select': 'Select the Presets you want to save and choose a new name for them. Hit "skip" on a Presets section if you don\'t want to save as new that specific Preset.',
				'preset_name': 'Preset Name',
				'key_name': 'Key Name',
				'preset_naming': 'Preset Naming for',
				'preset_skip': 'Skip',
				'success_save': 'NEW PRESET SAVED WITH SUCCESS!',
				'success_msg': '<p>The new Presets have been successfully saved and they are ready to be used right now. You will find them from the list of the respective presets.</p><p>Click "Close" button below to close this window.</p>',
				'fail_save': 'SAVE FAILED',
				'fail_msg': '<p>It looks like the saving of the new Preset didn\'t succeed. Make sure your template folder and "custom/presets.ini" at your template folder root have write permissions.</p><p>Once you think you have fixed the permission, hit the button "Retry" below.</p><p>If it still fails, please ask for support on RocketTheme forums</p>',
				'cancel': 'Отмена',
				'save': 'Сохранить',
				'retry': 'Retry',
				'close': 'Закрыть',
				'show_parameters': 'Show Involved Params'
			};
			var GantryPrefix = 'params';
		var Presets = {};var PresetsKeys = {};Presets["presets"] = new Hash({'Preset 1': {'bodylevel': 'high', 'headerstyle': 'dark', 'headerlink': '#63B8F9', 'menupillstyle': 'default', 'bodytext': '#555', 'bodylink': '#0B86E5', 'accentstyle': 'orange', 'footerstyle': 'dark', 'footerlink': '#63B8F9', 'font-family': 'helvetica'}, 'Preset 2': {'bodylevel': 'high', 'headerstyle': 'dark', 'headerlink': '#88CA31', 'menupillstyle': 'blue', 'bodytext': '#555', 'bodylink': '#4F9F00', 'accentstyle': 'blue', 'footerstyle': 'dark', 'footerlink': '#88CA31', 'font-family': 'helvetica'}, 'Preset 3': {'bodylevel': 'high', 'headerstyle': 'dark', 'headerlink': '#90C4DD', 'menupillstyle': 'brown', 'bodytext': '#555', 'bodylink': '#3C7C9D', 'accentstyle': 'brown', 'footerstyle': 'dark', 'footerlink': '#90C4DD', 'font-family': 'helvetica'}, 'Preset 4': {'bodylevel': 'high', 'headerstyle': 'light', 'headerlink': '#CA4629', 'menupillstyle': 'darkorange', 'bodytext': '#555', 'bodylink': '#8F1C00', 'accentstyle': 'darkgrey', 'footerstyle': 'dark', 'footerlink': '#CA4629', 'font-family': 'helvetica'}, 'Preset 5': {'bodylevel': 'high', 'headerstyle': 'dark', 'headerlink': '#CA8B18', 'menupillstyle': 'darkorange', 'bodytext': '#555', 'bodylink': '#C27300', 'accentstyle': 'darkorange', 'footerstyle': 'dark', 'footerlink': '#CA8B18', 'font-family': 'tachyon'}, 'Preset 6': {'bodylevel': 'high', 'headerstyle': 'dark', 'headerlink': '#8BB500', 'menupillstyle': 'green', 'bodytext': '#555', 'bodylink': '#679200', 'accentstyle': 'green', 'footerstyle': 'dark', 'footerlink': '#8BB500', 'font-family': 'tachyon'}, 'Preset 7': {'bodylevel': 'high', 'headerstyle': 'light', 'headerlink': '#D99200', 'menupillstyle': 'lightblue', 'bodytext': '#555', 'bodylink': '#D99200', 'accentstyle': 'lightblue', 'footerstyle': 'dark', 'footerlink': '#DEA11A', 'font-family': 'tachyon'}, 'Preset 8': {'bodylevel': 'high', 'headerstyle': 'dark', 'headerlink': '#D992C6', 'menupillstyle': 'purple', 'bodytext': '#555', 'bodylink': '#772576', 'accentstyle': 'purple', 'footerstyle': 'dark', 'footerlink': '#D992C6', 'font-family': 'tachyon'}});PresetsKeys['presets'] = ['preset1', 'preset2', 'preset3', 'preset4', 'preset5', 'preset6', 'preset7', 'preset8'];window.addEvent('domready', Scroller.init.bind(Scroller, 'presets'));
		window.addEvent('domready', function() {
			document.id('paramsbodylevel').addEvents({
				'set': function(value) {
					var slider = window.sliderbodylevel;
					var index = slider.list.indexOf(value);
					slider.set(index);
				}
			});
			window.sliderbodylevel = new RokSlider(document.id('bodylevel').getElement('.slider'), document.id('bodylevel').getElement('.knob'), {
				steps: 1,
				snap: true,
				initialize: function() {
					this.hiddenEl = document.id('paramsbodylevel');	
				},
				onComplete: function() {
					this.knob.removeClass('down');
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						cache.set('bodylevel', this.list[this.step]);
					}
				},
				onDrag: function(now) {
					this.element.getFirst().setStyle('width', now + 10);
				},
				onChange: function(step) {
					document.id('paramsbodylevel').setProperty('value', this.list[step]);
				},
				onTick: function(position) {
					if(this.options.snap) position = this.toPosition(this.step);
					this.knob.setStyle(this.property, position);
					this.fireEvent('onDrag', position);
				}
			});
			window.sliderbodylevel.list = ['low', 'high'];
			window.sliderbodylevel.set(1);
			
			document.id('bodylevel').getElement('.knob').addEvents({
				'mousedown': function() {this.addClass('down');},
				'mouseup': function() {this.removeClass('down');}
			});
		});
		var rainbowLoad = function(name, hex) {
				if (hex) {
					var n = name.replace('params', '');
					document.id(n+'_input').getPrevious().value = hex;
					document.id(n+'_input').getFirst().setStyle('background-color', hex);
				}
			};
		
		var r_headerlink;
		window.addEvent('domready', function() {
			$('paramsheaderlink').getParent().addEvents({
				'mouseenter': f_headerlink,
				'mouseleave': function(){
					this.removeEvent('mouseenter', f_headerlink);
				}
			});
		});
		
		var f_headerlink = function(){
			var input = document.id('paramsheaderlink');
			r_headerlink = new MooRainbow('myRainbow_headerlink_input', {
				id: 'myRainbow_headerlink',
				startColor: $('paramsheaderlink').get('value').hexToRgb(true) || [255, 255, 255],
				imgPath: '/components/com_gantry/admin/widgets/colorchooser/images/',
				transparent: 1,
				onChange: function(color) {
					if (color == 'transparent') {
						input.getNext().getFirst().addClass('overlay-transparent').setStyle('background-color', 'transparent');
						input.value = 'transparent';
					}
					else {
						input.getNext().getFirst().removeClass('overlay-transparent').setStyle('background-color', color.hex);
						input.value = color.hex;
					}
					
					if (this.visible) this.okButton.focus();
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						cache.set('headerlink', input.value.toString());
					}
				}
			});	
			
			r_headerlink.okButton.setStyle('outline', 'none');
			document.id('myRainbow_headerlink_input').addEvent('click', function() {
				(function() {r_headerlink.okButton.focus()}).delay(10);
			});
			input.addEvent('keyup', function(e) {
				if (e) e = new Event(e);
				if ((this.value.length == 4 || this.value.length == 7) && this.value[0] == '#') {
					var rgb = new Color(this.value);
					var hex = this.value;
					var hsb = rgb.rgbToHsb();
					var color = {
						'hex': hex,
						'rgb': rgb,
						'hsb': hsb
					}
					r_headerlink.fireEvent('onChange', color);
					r_headerlink.manualSet(color.rgb);
				};
			}).addEvent('set', function(value) {
				this.value = value;
				this.fireEvent('keyup');
			});
			input.getNext().getFirst().setStyle('background-color', r_headerlink.sets.hex);
			rainbowLoad('myRainbow_headerlink');
		};

		var r_bodytext;
		window.addEvent('domready', function() {
			$('paramsbodytext').getParent().addEvents({
				'mouseenter': f_bodytext,
				'mouseleave': function(){
					this.removeEvent('mouseenter', f_bodytext);
				}
			});
		});
		
		var f_bodytext = function(){
			var input = document.id('paramsbodytext');
			r_bodytext = new MooRainbow('myRainbow_bodytext_input', {
				id: 'myRainbow_bodytext',
				startColor: $('paramsbodytext').get('value').hexToRgb(true) || [255, 255, 255],
				imgPath: '/components/com_gantry/admin/widgets/colorchooser/images/',
				transparent: 1,
				onChange: function(color) {
					if (color == 'transparent') {
						input.getNext().getFirst().addClass('overlay-transparent').setStyle('background-color', 'transparent');
						input.value = 'transparent';
					}
					else {
						input.getNext().getFirst().removeClass('overlay-transparent').setStyle('background-color', color.hex);
						input.value = color.hex;
					}
					
					if (this.visible) this.okButton.focus();
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						cache.set('bodytext', input.value.toString());
					}
				}
			});	
			
			r_bodytext.okButton.setStyle('outline', 'none');
			document.id('myRainbow_bodytext_input').addEvent('click', function() {
				(function() {r_bodytext.okButton.focus()}).delay(10);
			});
			input.addEvent('keyup', function(e) {
				if (e) e = new Event(e);
				if ((this.value.length == 4 || this.value.length == 7) && this.value[0] == '#') {
					var rgb = new Color(this.value);
					var hex = this.value;
					var hsb = rgb.rgbToHsb();
					var color = {
						'hex': hex,
						'rgb': rgb,
						'hsb': hsb
					}
					r_bodytext.fireEvent('onChange', color);
					r_bodytext.manualSet(color.rgb);
				};
			}).addEvent('set', function(value) {
				this.value = value;
				this.fireEvent('keyup');
			});
			input.getNext().getFirst().setStyle('background-color', r_bodytext.sets.hex);
			rainbowLoad('myRainbow_bodytext');
		};

		var r_bodylink;
		window.addEvent('domready', function() {
			$('paramsbodylink').getParent().addEvents({
				'mouseenter': f_bodylink,
				'mouseleave': function(){
					this.removeEvent('mouseenter', f_bodylink);
				}
			});
		});
		
		var f_bodylink = function(){
			var input = document.id('paramsbodylink');
			r_bodylink = new MooRainbow('myRainbow_bodylink_input', {
				id: 'myRainbow_bodylink',
				startColor: $('paramsbodylink').get('value').hexToRgb(true) || [255, 255, 255],
				imgPath: '/components/com_gantry/admin/widgets/colorchooser/images/',
				transparent: 1,
				onChange: function(color) {
					if (color == 'transparent') {
						input.getNext().getFirst().addClass('overlay-transparent').setStyle('background-color', 'transparent');
						input.value = 'transparent';
					}
					else {
						input.getNext().getFirst().removeClass('overlay-transparent').setStyle('background-color', color.hex);
						input.value = color.hex;
					}
					
					if (this.visible) this.okButton.focus();
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						cache.set('bodylink', input.value.toString());
					}
				}
			});	
			
			r_bodylink.okButton.setStyle('outline', 'none');
			document.id('myRainbow_bodylink_input').addEvent('click', function() {
				(function() {r_bodylink.okButton.focus()}).delay(10);
			});
			input.addEvent('keyup', function(e) {
				if (e) e = new Event(e);
				if ((this.value.length == 4 || this.value.length == 7) && this.value[0] == '#') {
					var rgb = new Color(this.value);
					var hex = this.value;
					var hsb = rgb.rgbToHsb();
					var color = {
						'hex': hex,
						'rgb': rgb,
						'hsb': hsb
					}
					r_bodylink.fireEvent('onChange', color);
					r_bodylink.manualSet(color.rgb);
				};
			}).addEvent('set', function(value) {
				this.value = value;
				this.fireEvent('keyup');
			});
			input.getNext().getFirst().setStyle('background-color', r_bodylink.sets.hex);
			rainbowLoad('myRainbow_bodylink');
		};

		var r_footerlink;
		window.addEvent('domready', function() {
			$('paramsfooterlink').getParent().addEvents({
				'mouseenter': f_footerlink,
				'mouseleave': function(){
					this.removeEvent('mouseenter', f_footerlink);
				}
			});
		});
		
		var f_footerlink = function(){
			var input = document.id('paramsfooterlink');
			r_footerlink = new MooRainbow('myRainbow_footerlink_input', {
				id: 'myRainbow_footerlink',
				startColor: $('paramsfooterlink').get('value').hexToRgb(true) || [255, 255, 255],
				imgPath: '/components/com_gantry/admin/widgets/colorchooser/images/',
				transparent: 1,
				onChange: function(color) {
					if (color == 'transparent') {
						input.getNext().getFirst().addClass('overlay-transparent').setStyle('background-color', 'transparent');
						input.value = 'transparent';
					}
					else {
						input.getNext().getFirst().removeClass('overlay-transparent').setStyle('background-color', color.hex);
						input.value = color.hex;
					}
					
					if (this.visible) this.okButton.focus();
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						cache.set('footerlink', input.value.toString());
					}
				}
			});	
			
			r_footerlink.okButton.setStyle('outline', 'none');
			document.id('myRainbow_footerlink_input').addEvent('click', function() {
				(function() {r_footerlink.okButton.focus()}).delay(10);
			});
			input.addEvent('keyup', function(e) {
				if (e) e = new Event(e);
				if ((this.value.length == 4 || this.value.length == 7) && this.value[0] == '#') {
					var rgb = new Color(this.value);
					var hex = this.value;
					var hsb = rgb.rgbToHsb();
					var color = {
						'hex': hex,
						'rgb': rgb,
						'hsb': hsb
					}
					r_footerlink.fireEvent('onChange', color);
					r_footerlink.manualSet(color.rgb);
				};
			}).addEvent('set', function(value) {
				this.value = value;
				this.fireEvent('keyup');
			});
			input.getNext().getFirst().setStyle('background-color', r_footerlink.sets.hex);
			rainbowLoad('myRainbow_footerlink');
		};

			Array.prototype.compareArrays = function(arr) {
				if (!arr) return false;
			    if (this.length != arr.length) return false;
			    for (var i = 0; i < arr.length; i++) {
			        if (this[i].compareArrays) { //likely nested array
			            if (!this[i].compareArrays(arr[i])) return false;
			            else continue;
			        }
			        if (this[i] != arr[i]) return false;
			    }
			    return true;
			}
			
			String.implement({
				baseConversion: function(from, to) {
					var num = this;
					if(isNaN(from) || from < 2 || from > 36 || isNaN(to) || to < 2 || to > 36)
						throw (new RangeError('Illegal radix. Radices must be integers between 2 and 36, inclusive.'));
					num = parseInt(num, from);
					num = num.toString(to);

					return num;
				},
				
				hex2dec: function() {
					if (!isNaN(this.toInt())) return this;
					return this.baseConversion(24, 10);
				},
				
				dec2hex: function() {
					return this.baseConversion(10, 24);					
				}
			});
			
			var createTip = function(id) {
				var el = document.id(id);
				if (el) return el;
				
				el = new Element('div', {'id': id}).inject(document.body).set('text', '2 | 2 | 2 | 2 | 2 | 2');
				el.fx = new Fx.Tween(el, {duration: 200, link: 'cancel'}).set('opacity', 0);
				
				return el;				
			};
			
			var updateTip = function(slider) {
				var blocks = slider.RT.blocks, output = '';
				blocks.each(function(block, i) {
					if (block.style.display != 'none') {
						var grid = block.className.split(' ')[1].replace('mini-grid-', '');
						output += grid.hex2dec() + ' | ';
					}
				});
				
				output = output.substring(0, output.length - 2);
				
				return output;
			};
			
			var updateSlider = function(slider, range) {
				var x = slider;
				range = range;
				
				x.min = 0; 
				x.max = slider.RT.list[range].length - 1;
				x.range = x.max - x.min;
				x.steps = x.max;
				x.stepSize = Math.abs(x.range) / x.steps;
				x.stepWidth = Number((x.stepSize * x.full / Math.abs(x.range)).toFixed(4));

				var grid = (x.stepWidth == Infinity) ? x.full : x.stepWidth;
				x.drag.options.grid = grid;
				
				if (!x.steps) x.drag.detach();
				else x.drag.attach();
				
				slider.RT.current = range;
			};
		
			var updateBlocks = function(slider, amount, step) {
				if (!step) step = 0;
				var blocks = slider.RT.blocks;
				var current = slider.RT.list[slider.RT.current];
				amount = amount;
				blocks.removeClass('main');
				blocks.each(function(block, i) {
					
					if (i < slider.RT.current) blocks[i].setStyle('display', 'block');
					else blocks[i].setStyle('display', 'none');
					var grid = slider.RT.list[amount][Math.round(step, 0)].toString();
					blocks[i].className = '';
					
					var chr = (amount == 1) ? slider.RT.gridSize : grid.charAt(i).hex2dec();
					blocks[i].addClass('mini-grid').addClass('mini-grid-' + chr);

					var keyValue = blocks[i].innerHTML;
					if (keyValue == slider.RT.keyName && (keyValue != '')) blocks[i].addClass('main');
				});
			};
			
			var serializeSettings = function(slider, settings) {
				var serial = '';
				
				// grid size
				serial += 'a:1:{i:' + slider.RT.gridSize + ';';
				
				// main index
				serial += 'a:' + settings.getLength() + ':{';
				settings.each(function(val, key) {
					// values of index
					serial += 'i:' + key + ';a:' + val.length + ':{';
					
					for (i = 0, l = val.length; i < l; i++) {
						if (slider.RT.type == 'custom') {
							var tmp = slider.RT.store[key][i];
							serial += 's:' + tmp.length + ':"' + tmp + '";i:' + val[i].hex2dec() + ';';
						} else {
							serial += 'i:' + i + ';i:' + val[i].hex2dec() + ';';
						}
					}

					serial += '}';
				});
				
				serial += '}}';

				return serial;
			};
		
		window.addEvent('domready', function() {
			
			var tip = createTip('positions-tip');
			document.id('paramstopPosition').addEvent('set', function(value) {
				var baseValue = value;
				var slider = window.slidertopPosition.RT;
				
				if (!value.contains('{')) value = serialize(value.replace(/\s/g, '').split(','));
				
				value = value.unserialize();

				if (!value[slider.gridSize]) return;
				else value = new Hash(value[slider.gridSize]);
				
				var arrayMulti = {};
				var arraySingle = {};
				
				value.each(function(wrapper_value, key) {
					arrayMulti[key] = [];
					arraySingle[key] = [];
					if (slider.type == 'custom') {
						arrayMulti[key] = {};
						arraySingle[key] = {};
						arrayMulti[key]['keys'] = [];
						arrayMulti[key]['values'] = [];
						arraySingle[key]['keys'] = [];
						arraySingle[key]['values'] = [];
					}
					
					$H(wrapper_value).each(function(inner_value, inner_key) {
						var val = inner_value.toString().dec2hex();
						if (slider.type != 'custom') {
							arrayMulti[key].push(val);
							arraySingle[key].push(val);
						} else {
							arrayMulti[key]['keys'].push(inner_key);
							arraySingle[key]['keys'].push(inner_key);
							arrayMulti[key]['values'].push(val);
							arraySingle[key]['values'].push(val);
						}

					});
					if (slider.type != 'custom') arraySingle[key] = [arraySingle[key].join('')];
					else arraySingle[key]['values'] = [arraySingle[key]['values'].join('')];
				});
				
				slider.defaults = $merge(slider.defaults, arraySingle);
				
				if (slider.type != 'custom') {
					var cur = arraySingle[slider.current];
					if (cur) {
						var current = slider.list[slider.current].indexOf(cur[0]) || 0;
						window.slidertopPosition.set(current);//.fireEvent('onComplete', [current, true]);
					}
				} else {
					var defaults = slider.defaults[slider.current];
					var keys = slider.keys[slider.current];
					var tests = [];
					
					keys.each(function(key, i) {
						if (key.compareArrays(defaults.keys)) tests.push(i);
					});

					var list = slider.list[slider.current];
					
					tests.each(function(test, j) {
						if (list[test] == defaults.values[0]) {
							slidertopPosition.set(test);//.fireEvent('onComplete', [test, true]);
						}
					});
				}
			 	this.set('value', baseValue);
			});
			window.slidertopPosition = new RokSlider(document.id('topPosition').getElement('.position'), document.id('topPosition').getElement('.knob'), {
				offset: 5,
				snap: true,
				initialize: function() {
					this.hiddenEl = document.id('paramstopPosition');
					this.RT = {};
					this.RT.current = $$('#topPosition .list .active a')[0].getFirst().innerHTML.toInt();
					this.RT.list = {'1': ['c'],'2': ['2a', '39', '48', '57', '66', '75', '84', '93', 'a2'],'3': ['228', '237', '246', '255', '264', '273', '282', '327', '336', '345', '354', '363', '372', '426', '435', '444', '453', '462', '525', '534', '543', '552', '624', '633', '642', '723', '732', '822'],'4': ['2226', '2235', '2244', '2253', '2262', '2325', '2334', '2343', '2352', '2424', '2433', '2442', '2523', '2532', '2622', '3225', '3234', '3243', '3252', '3324', '3333', '3342', '3423', '3432', '3522', '4224', '4233', '4242', '4323', '4332', '4422', '5223', '5232', '5322', '6222'],'5': ['22224', '22233', '22242', '22323', '22332', '22422', '23223', '23232', '23322', '24222', '32223', '32232', '32322', '33222', '42222'],'6': ['222222']};
					this.RT.navigation = document.id('topPosition').getElement('.list').getChildren();
					this.RT.blocks = document.id('topPosition').getElements('.mini-grid');
					this.RT.settings = {};
					this.RT.gridSize = 12;
					this.RT.defaults = {2: ['66'], 1: ['c'], 3: ['444'], 4: ['3333'], 5: ['32223'], 6: ['222222']};
					this.RT.keyName = '' || '';
					this.RT.type = 'regular';
					this.RT.store = {};
					
					this.options.steps = this.RT.list[this.RT.current].length - 1;
					this.setOptions(this.options);

					var current = this.RT.current, navigation = this.RT.navigation, blocks = this.RT.blocks;
					var settings = this.RT.settings;
					navigation.each(function(nav, i) {
						settings[current] = [];
						nav.addEvent('click', function(event) {
							if (event) new Event(event).stop();
							navigation.removeClass('active');
							this.addClass('active');
							
							updateSlider(window.slidertopPosition, this.getFirst().getFirst().innerHTML.toInt());

							var value = slidertopPosition.RT.defaults[slidertopPosition.RT.current][0];
							if (slidertopPosition.RT.type == 'custom') {
								var defaults = slidertopPosition.RT.defaults[slidertopPosition.RT.current];
								var keys = slidertopPosition.RT.keys[slidertopPosition.RT.current];
								var tests = [];
								keys.each(function(key, i) {
									if (key.compareArrays(defaults.keys)) tests.push(i);
								});
								var list = slidertopPosition.RT.list[slidertopPosition.RT.current];
								
								tests.each(function(test, j) {
									if (list[test] == defaults.values[0]) {
										slidertopPosition.set(test);
									}
								});
								
							} else {
								slidertopPosition.set(slidertopPosition.RT.list[slidertopPosition.RT.current].indexOf(value));
							}
						});
					});
					updateBlocks(this, current);
				},
				
				onComplete: function(value, force) {
					this.knob.removeClass('down');
					var serialize = serializeSettings(this, new Hash(this.RT.settings));
					if (!force) document.id('paramstopPosition').set('value', serialize);
					var setting = '';
					var step = Math.round(this.step);
					for (i = 0, len = this.RT.current; i < len; i++) {
						setting += this.RT.list[this.RT.current][(isNaN(step) || step < 0) ? 0 : step].toString().charAt(i);
					}
					if (this.RT.type != 'custom') this.RT.defaults[this.RT.current] = [setting];
					else {
						this.RT.defaults[this.RT.current].values = [setting];
						var keys = [];
						for (i=0,l=this.RT.current;i<l;i++) {
							keys.push(this.RT.blocks[i].innerHTML);
						}
						this.RT.defaults[this.RT.current].keys = keys;
					}
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						
						cache.set('topPosition', document.id('paramstopPosition').value);
					}
					
				},
				onDrag: function(now) {
					this.element.getFirst().setStyle('width', now + 10);
					var step = this.step;
					
					var layout = this.RT.list[this.RT.current][Math.round(step, 0)], output = '';
					if (!layout) return;
					
					layout = layout.toString();
					this.RT.settings[this.RT.current] = [];
					this.RT.store[this.RT.current] = [];
					for (i = 0, len = this.RT.current; i < len; i++) {
					    output += layout.charAt(i).hex2dec() + ((i == len - 1) ? '' : ' | ');
						
						if (this.RT.type == 'custom') {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
							this.RT.store[this.RT.current].push(this.RT.keys[this.RT.current][Math.round(step,0)][i]);
							
						} else {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
						}
						if (this.RT.keys) {
							var keyIndex = this.RT.keys[this.RT.current][Math.round(step,0)][i];
							this.RT.blocks[i].set('text', keyIndex);
						}
					}
					tip.set('html', output);
					
					updateBlocks(window.slidertopPosition, this.RT.current, step);
				},
				onChange: function(position) {
					if(this.options.snap) position = this.toPosition(this.step);
					position = position || 0;
					this.knob.setStyle(this.property, position);
					this.fireEvent('onDrag', position);
				}
			});

			slidertopPosition.RT.navigation[1].fireEvent('click');
			
			document.id('topPosition').getElement('.knob').addEvents({
				'mousedown': function() {this.addClass('down');},
				'mouseup': function() {this.removeClass('down');}
			});
			
			document.id('topPosition-wrapper').addEvents({
				'mouseenter': function() {
					var container = this.getElement('.mini-container');
					var pos = container.getCoordinates();
					tip.setStyles({
						'left': pos.left + pos.width + 5,
						'top': pos.top - 5
					});
					tip.set('html', updateTip(slidertopPosition));
					tip.fx.start('opacity', 1);
				},
				'mouseleave': function() {
					tip.fx.start('opacity', 0);
				}
			});
		});
		
		window.addEvent('domready', function() {
			
			var tip = createTip('positions-tip');
			document.id('paramsheaderPosition').addEvent('set', function(value) {
				var baseValue = value;
				var slider = window.sliderheaderPosition.RT;
				
				if (!value.contains('{')) value = serialize(value.replace(/\s/g, '').split(','));
				
				value = value.unserialize();

				if (!value[slider.gridSize]) return;
				else value = new Hash(value[slider.gridSize]);
				
				var arrayMulti = {};
				var arraySingle = {};
				
				value.each(function(wrapper_value, key) {
					arrayMulti[key] = [];
					arraySingle[key] = [];
					if (slider.type == 'custom') {
						arrayMulti[key] = {};
						arraySingle[key] = {};
						arrayMulti[key]['keys'] = [];
						arrayMulti[key]['values'] = [];
						arraySingle[key]['keys'] = [];
						arraySingle[key]['values'] = [];
					}
					
					$H(wrapper_value).each(function(inner_value, inner_key) {
						var val = inner_value.toString().dec2hex();
						if (slider.type != 'custom') {
							arrayMulti[key].push(val);
							arraySingle[key].push(val);
						} else {
							arrayMulti[key]['keys'].push(inner_key);
							arraySingle[key]['keys'].push(inner_key);
							arrayMulti[key]['values'].push(val);
							arraySingle[key]['values'].push(val);
						}

					});
					if (slider.type != 'custom') arraySingle[key] = [arraySingle[key].join('')];
					else arraySingle[key]['values'] = [arraySingle[key]['values'].join('')];
				});
				
				slider.defaults = $merge(slider.defaults, arraySingle);
				
				if (slider.type != 'custom') {
					var cur = arraySingle[slider.current];
					if (cur) {
						var current = slider.list[slider.current].indexOf(cur[0]) || 0;
						window.sliderheaderPosition.set(current);//.fireEvent('onComplete', [current, true]);
					}
				} else {
					var defaults = slider.defaults[slider.current];
					var keys = slider.keys[slider.current];
					var tests = [];
					
					keys.each(function(key, i) {
						if (key.compareArrays(defaults.keys)) tests.push(i);
					});

					var list = slider.list[slider.current];
					
					tests.each(function(test, j) {
						if (list[test] == defaults.values[0]) {
							sliderheaderPosition.set(test);//.fireEvent('onComplete', [test, true]);
						}
					});
				}
			 	this.set('value', baseValue);
			});
			window.sliderheaderPosition = new RokSlider(document.id('headerPosition').getElement('.position'), document.id('headerPosition').getElement('.knob'), {
				offset: 5,
				snap: true,
				initialize: function() {
					this.hiddenEl = document.id('paramsheaderPosition');
					this.RT = {};
					this.RT.current = $$('#headerPosition .list .active a')[0].getFirst().innerHTML.toInt();
					this.RT.list = {'1': ['c'],'2': ['2a', '39', '48', '57', '66', '75', '84', '93', 'a2'],'3': ['228', '237', '246', '255', '264', '273', '282', '327', '336', '345', '354', '363', '372', '426', '435', '444', '453', '462', '525', '534', '543', '552', '624', '633', '642', '723', '732', '822'],'4': ['2226', '2235', '2244', '2253', '2262', '2325', '2334', '2343', '2352', '2424', '2433', '2442', '2523', '2532', '2622', '3225', '3234', '3243', '3252', '3324', '3333', '3342', '3423', '3432', '3522', '4224', '4233', '4242', '4323', '4332', '4422', '5223', '5232', '5322', '6222'],'5': ['22224', '22233', '22242', '22323', '22332', '22422', '23223', '23232', '23322', '24222', '32223', '32232', '32322', '33222', '42222'],'6': ['222222']};
					this.RT.navigation = document.id('headerPosition').getElement('.list').getChildren();
					this.RT.blocks = document.id('headerPosition').getElements('.mini-grid');
					this.RT.settings = {};
					this.RT.gridSize = 12;
					this.RT.defaults = {2: ['39'], 1: ['c'], 3: ['444'], 4: ['3333'], 5: ['32223'], 6: ['222222']};
					this.RT.keyName = '' || '';
					this.RT.type = 'regular';
					this.RT.store = {};
					
					this.options.steps = this.RT.list[this.RT.current].length - 1;
					this.setOptions(this.options);

					var current = this.RT.current, navigation = this.RT.navigation, blocks = this.RT.blocks;
					var settings = this.RT.settings;
					navigation.each(function(nav, i) {
						settings[current] = [];
						nav.addEvent('click', function(event) {
							if (event) new Event(event).stop();
							navigation.removeClass('active');
							this.addClass('active');
							
							updateSlider(window.sliderheaderPosition, this.getFirst().getFirst().innerHTML.toInt());

							var value = sliderheaderPosition.RT.defaults[sliderheaderPosition.RT.current][0];
							if (sliderheaderPosition.RT.type == 'custom') {
								var defaults = sliderheaderPosition.RT.defaults[sliderheaderPosition.RT.current];
								var keys = sliderheaderPosition.RT.keys[sliderheaderPosition.RT.current];
								var tests = [];
								keys.each(function(key, i) {
									if (key.compareArrays(defaults.keys)) tests.push(i);
								});
								var list = sliderheaderPosition.RT.list[sliderheaderPosition.RT.current];
								
								tests.each(function(test, j) {
									if (list[test] == defaults.values[0]) {
										sliderheaderPosition.set(test);
									}
								});
								
							} else {
								sliderheaderPosition.set(sliderheaderPosition.RT.list[sliderheaderPosition.RT.current].indexOf(value));
							}
						});
					});
					updateBlocks(this, current);
				},
				
				onComplete: function(value, force) {
					this.knob.removeClass('down');
					var serialize = serializeSettings(this, new Hash(this.RT.settings));
					if (!force) document.id('paramsheaderPosition').set('value', serialize);
					var setting = '';
					var step = Math.round(this.step);
					for (i = 0, len = this.RT.current; i < len; i++) {
						setting += this.RT.list[this.RT.current][(isNaN(step) || step < 0) ? 0 : step].toString().charAt(i);
					}
					if (this.RT.type != 'custom') this.RT.defaults[this.RT.current] = [setting];
					else {
						this.RT.defaults[this.RT.current].values = [setting];
						var keys = [];
						for (i=0,l=this.RT.current;i<l;i++) {
							keys.push(this.RT.blocks[i].innerHTML);
						}
						this.RT.defaults[this.RT.current].keys = keys;
					}
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						
						cache.set('headerPosition', document.id('paramsheaderPosition').value);
					}
					
				},
				onDrag: function(now) {
					this.element.getFirst().setStyle('width', now + 10);
					var step = this.step;
					
					var layout = this.RT.list[this.RT.current][Math.round(step, 0)], output = '';
					if (!layout) return;
					
					layout = layout.toString();
					this.RT.settings[this.RT.current] = [];
					this.RT.store[this.RT.current] = [];
					for (i = 0, len = this.RT.current; i < len; i++) {
					    output += layout.charAt(i).hex2dec() + ((i == len - 1) ? '' : ' | ');
						
						if (this.RT.type == 'custom') {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
							this.RT.store[this.RT.current].push(this.RT.keys[this.RT.current][Math.round(step,0)][i]);
							
						} else {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
						}
						if (this.RT.keys) {
							var keyIndex = this.RT.keys[this.RT.current][Math.round(step,0)][i];
							this.RT.blocks[i].set('text', keyIndex);
						}
					}
					tip.set('html', output);
					
					updateBlocks(window.sliderheaderPosition, this.RT.current, step);
				},
				onChange: function(position) {
					if(this.options.snap) position = this.toPosition(this.step);
					position = position || 0;
					this.knob.setStyle(this.property, position);
					this.fireEvent('onDrag', position);
				}
			});

			sliderheaderPosition.RT.navigation[1].fireEvent('click');
			
			document.id('headerPosition').getElement('.knob').addEvents({
				'mousedown': function() {this.addClass('down');},
				'mouseup': function() {this.removeClass('down');}
			});
			
			document.id('headerPosition-wrapper').addEvents({
				'mouseenter': function() {
					var container = this.getElement('.mini-container');
					var pos = container.getCoordinates();
					tip.setStyles({
						'left': pos.left + pos.width + 5,
						'top': pos.top - 5
					});
					tip.set('html', updateTip(sliderheaderPosition));
					tip.fx.start('opacity', 1);
				},
				'mouseleave': function() {
					tip.fx.start('opacity', 0);
				}
			});
		});
		
		window.addEvent('domready', function() {
			
			var tip = createTip('positions-tip');
			document.id('paramsshowcasePosition').addEvent('set', function(value) {
				var baseValue = value;
				var slider = window.slidershowcasePosition.RT;
				
				if (!value.contains('{')) value = serialize(value.replace(/\s/g, '').split(','));
				
				value = value.unserialize();

				if (!value[slider.gridSize]) return;
				else value = new Hash(value[slider.gridSize]);
				
				var arrayMulti = {};
				var arraySingle = {};
				
				value.each(function(wrapper_value, key) {
					arrayMulti[key] = [];
					arraySingle[key] = [];
					if (slider.type == 'custom') {
						arrayMulti[key] = {};
						arraySingle[key] = {};
						arrayMulti[key]['keys'] = [];
						arrayMulti[key]['values'] = [];
						arraySingle[key]['keys'] = [];
						arraySingle[key]['values'] = [];
					}
					
					$H(wrapper_value).each(function(inner_value, inner_key) {
						var val = inner_value.toString().dec2hex();
						if (slider.type != 'custom') {
							arrayMulti[key].push(val);
							arraySingle[key].push(val);
						} else {
							arrayMulti[key]['keys'].push(inner_key);
							arraySingle[key]['keys'].push(inner_key);
							arrayMulti[key]['values'].push(val);
							arraySingle[key]['values'].push(val);
						}

					});
					if (slider.type != 'custom') arraySingle[key] = [arraySingle[key].join('')];
					else arraySingle[key]['values'] = [arraySingle[key]['values'].join('')];
				});
				
				slider.defaults = $merge(slider.defaults, arraySingle);
				
				if (slider.type != 'custom') {
					var cur = arraySingle[slider.current];
					if (cur) {
						var current = slider.list[slider.current].indexOf(cur[0]) || 0;
						window.slidershowcasePosition.set(current);//.fireEvent('onComplete', [current, true]);
					}
				} else {
					var defaults = slider.defaults[slider.current];
					var keys = slider.keys[slider.current];
					var tests = [];
					
					keys.each(function(key, i) {
						if (key.compareArrays(defaults.keys)) tests.push(i);
					});

					var list = slider.list[slider.current];
					
					tests.each(function(test, j) {
						if (list[test] == defaults.values[0]) {
							slidershowcasePosition.set(test);//.fireEvent('onComplete', [test, true]);
						}
					});
				}
			 	this.set('value', baseValue);
			});
			window.slidershowcasePosition = new RokSlider(document.id('showcasePosition').getElement('.position'), document.id('showcasePosition').getElement('.knob'), {
				offset: 5,
				snap: true,
				initialize: function() {
					this.hiddenEl = document.id('paramsshowcasePosition');
					this.RT = {};
					this.RT.current = $$('#showcasePosition .list .active a')[0].getFirst().innerHTML.toInt();
					this.RT.list = {'1': ['c'],'2': ['2a', '39', '48', '57', '66', '75', '84', '93', 'a2'],'3': ['228', '237', '246', '255', '264', '273', '282', '327', '336', '345', '354', '363', '372', '426', '435', '444', '453', '462', '525', '534', '543', '552', '624', '633', '642', '723', '732', '822'],'4': ['2226', '2235', '2244', '2253', '2262', '2325', '2334', '2343', '2352', '2424', '2433', '2442', '2523', '2532', '2622', '3225', '3234', '3243', '3252', '3324', '3333', '3342', '3423', '3432', '3522', '4224', '4233', '4242', '4323', '4332', '4422', '5223', '5232', '5322', '6222'],'5': ['22224', '22233', '22242', '22323', '22332', '22422', '23223', '23232', '23322', '24222', '32223', '32232', '32322', '33222', '42222'],'6': ['222222']};
					this.RT.navigation = document.id('showcasePosition').getElement('.list').getChildren();
					this.RT.blocks = document.id('showcasePosition').getElements('.mini-grid');
					this.RT.settings = {};
					this.RT.gridSize = 12;
					this.RT.defaults = {2: ['84'], 1: ['c'], 3: ['444'], 4: ['3333'], 5: ['32223'], 6: ['222222']};
					this.RT.keyName = '' || '';
					this.RT.type = 'regular';
					this.RT.store = {};
					
					this.options.steps = this.RT.list[this.RT.current].length - 1;
					this.setOptions(this.options);

					var current = this.RT.current, navigation = this.RT.navigation, blocks = this.RT.blocks;
					var settings = this.RT.settings;
					navigation.each(function(nav, i) {
						settings[current] = [];
						nav.addEvent('click', function(event) {
							if (event) new Event(event).stop();
							navigation.removeClass('active');
							this.addClass('active');
							
							updateSlider(window.slidershowcasePosition, this.getFirst().getFirst().innerHTML.toInt());

							var value = slidershowcasePosition.RT.defaults[slidershowcasePosition.RT.current][0];
							if (slidershowcasePosition.RT.type == 'custom') {
								var defaults = slidershowcasePosition.RT.defaults[slidershowcasePosition.RT.current];
								var keys = slidershowcasePosition.RT.keys[slidershowcasePosition.RT.current];
								var tests = [];
								keys.each(function(key, i) {
									if (key.compareArrays(defaults.keys)) tests.push(i);
								});
								var list = slidershowcasePosition.RT.list[slidershowcasePosition.RT.current];
								
								tests.each(function(test, j) {
									if (list[test] == defaults.values[0]) {
										slidershowcasePosition.set(test);
									}
								});
								
							} else {
								slidershowcasePosition.set(slidershowcasePosition.RT.list[slidershowcasePosition.RT.current].indexOf(value));
							}
						});
					});
					updateBlocks(this, current);
				},
				
				onComplete: function(value, force) {
					this.knob.removeClass('down');
					var serialize = serializeSettings(this, new Hash(this.RT.settings));
					if (!force) document.id('paramsshowcasePosition').set('value', serialize);
					var setting = '';
					var step = Math.round(this.step);
					for (i = 0, len = this.RT.current; i < len; i++) {
						setting += this.RT.list[this.RT.current][(isNaN(step) || step < 0) ? 0 : step].toString().charAt(i);
					}
					if (this.RT.type != 'custom') this.RT.defaults[this.RT.current] = [setting];
					else {
						this.RT.defaults[this.RT.current].values = [setting];
						var keys = [];
						for (i=0,l=this.RT.current;i<l;i++) {
							keys.push(this.RT.blocks[i].innerHTML);
						}
						this.RT.defaults[this.RT.current].keys = keys;
					}
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						
						cache.set('showcasePosition', document.id('paramsshowcasePosition').value);
					}
					
				},
				onDrag: function(now) {
					this.element.getFirst().setStyle('width', now + 10);
					var step = this.step;
					
					var layout = this.RT.list[this.RT.current][Math.round(step, 0)], output = '';
					if (!layout) return;
					
					layout = layout.toString();
					this.RT.settings[this.RT.current] = [];
					this.RT.store[this.RT.current] = [];
					for (i = 0, len = this.RT.current; i < len; i++) {
					    output += layout.charAt(i).hex2dec() + ((i == len - 1) ? '' : ' | ');
						
						if (this.RT.type == 'custom') {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
							this.RT.store[this.RT.current].push(this.RT.keys[this.RT.current][Math.round(step,0)][i]);
							
						} else {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
						}
						if (this.RT.keys) {
							var keyIndex = this.RT.keys[this.RT.current][Math.round(step,0)][i];
							this.RT.blocks[i].set('text', keyIndex);
						}
					}
					tip.set('html', output);
					
					updateBlocks(window.slidershowcasePosition, this.RT.current, step);
				},
				onChange: function(position) {
					if(this.options.snap) position = this.toPosition(this.step);
					position = position || 0;
					this.knob.setStyle(this.property, position);
					this.fireEvent('onDrag', position);
				}
			});

			slidershowcasePosition.RT.navigation[3].fireEvent('click');
			
			document.id('showcasePosition').getElement('.knob').addEvents({
				'mousedown': function() {this.addClass('down');},
				'mouseup': function() {this.removeClass('down');}
			});
			
			document.id('showcasePosition-wrapper').addEvents({
				'mouseenter': function() {
					var container = this.getElement('.mini-container');
					var pos = container.getCoordinates();
					tip.setStyles({
						'left': pos.left + pos.width + 5,
						'top': pos.top - 5
					});
					tip.set('html', updateTip(slidershowcasePosition));
					tip.fx.start('opacity', 1);
				},
				'mouseleave': function() {
					tip.fx.start('opacity', 0);
				}
			});
		});
		
		window.addEvent('domready', function() {
			
			var tip = createTip('positions-tip');
			document.id('paramsfeaturePosition').addEvent('set', function(value) {
				var baseValue = value;
				var slider = window.sliderfeaturePosition.RT;
				
				if (!value.contains('{')) value = serialize(value.replace(/\s/g, '').split(','));
				
				value = value.unserialize();

				if (!value[slider.gridSize]) return;
				else value = new Hash(value[slider.gridSize]);
				
				var arrayMulti = {};
				var arraySingle = {};
				
				value.each(function(wrapper_value, key) {
					arrayMulti[key] = [];
					arraySingle[key] = [];
					if (slider.type == 'custom') {
						arrayMulti[key] = {};
						arraySingle[key] = {};
						arrayMulti[key]['keys'] = [];
						arrayMulti[key]['values'] = [];
						arraySingle[key]['keys'] = [];
						arraySingle[key]['values'] = [];
					}
					
					$H(wrapper_value).each(function(inner_value, inner_key) {
						var val = inner_value.toString().dec2hex();
						if (slider.type != 'custom') {
							arrayMulti[key].push(val);
							arraySingle[key].push(val);
						} else {
							arrayMulti[key]['keys'].push(inner_key);
							arraySingle[key]['keys'].push(inner_key);
							arrayMulti[key]['values'].push(val);
							arraySingle[key]['values'].push(val);
						}

					});
					if (slider.type != 'custom') arraySingle[key] = [arraySingle[key].join('')];
					else arraySingle[key]['values'] = [arraySingle[key]['values'].join('')];
				});
				
				slider.defaults = $merge(slider.defaults, arraySingle);
				
				if (slider.type != 'custom') {
					var cur = arraySingle[slider.current];
					if (cur) {
						var current = slider.list[slider.current].indexOf(cur[0]) || 0;
						window.sliderfeaturePosition.set(current);//.fireEvent('onComplete', [current, true]);
					}
				} else {
					var defaults = slider.defaults[slider.current];
					var keys = slider.keys[slider.current];
					var tests = [];
					
					keys.each(function(key, i) {
						if (key.compareArrays(defaults.keys)) tests.push(i);
					});

					var list = slider.list[slider.current];
					
					tests.each(function(test, j) {
						if (list[test] == defaults.values[0]) {
							sliderfeaturePosition.set(test);//.fireEvent('onComplete', [test, true]);
						}
					});
				}
			 	this.set('value', baseValue);
			});
			window.sliderfeaturePosition = new RokSlider(document.id('featurePosition').getElement('.position'), document.id('featurePosition').getElement('.knob'), {
				offset: 5,
				snap: true,
				initialize: function() {
					this.hiddenEl = document.id('paramsfeaturePosition');
					this.RT = {};
					this.RT.current = $$('#featurePosition .list .active a')[0].getFirst().innerHTML.toInt();
					this.RT.list = {'1': ['c'],'2': ['2a', '39', '48', '57', '66', '75', '84', '93', 'a2'],'3': ['228', '237', '246', '255', '264', '273', '282', '327', '336', '345', '354', '363', '372', '426', '435', '444', '453', '462', '525', '534', '543', '552', '624', '633', '642', '723', '732', '822'],'4': ['2226', '2235', '2244', '2253', '2262', '2325', '2334', '2343', '2352', '2424', '2433', '2442', '2523', '2532', '2622', '3225', '3234', '3243', '3252', '3324', '3333', '3342', '3423', '3432', '3522', '4224', '4233', '4242', '4323', '4332', '4422', '5223', '5232', '5322', '6222'],'5': ['22224', '22233', '22242', '22323', '22332', '22422', '23223', '23232', '23322', '24222', '32223', '32232', '32322', '33222', '42222'],'6': ['222222']};
					this.RT.navigation = document.id('featurePosition').getElement('.list').getChildren();
					this.RT.blocks = document.id('featurePosition').getElements('.mini-grid');
					this.RT.settings = {};
					this.RT.gridSize = 12;
					this.RT.defaults = {2: ['66'], 1: ['c'], 3: ['444'], 4: ['3333'], 5: ['32223'], 6: ['222222']};
					this.RT.keyName = '' || '';
					this.RT.type = 'regular';
					this.RT.store = {};
					
					this.options.steps = this.RT.list[this.RT.current].length - 1;
					this.setOptions(this.options);

					var current = this.RT.current, navigation = this.RT.navigation, blocks = this.RT.blocks;
					var settings = this.RT.settings;
					navigation.each(function(nav, i) {
						settings[current] = [];
						nav.addEvent('click', function(event) {
							if (event) new Event(event).stop();
							navigation.removeClass('active');
							this.addClass('active');
							
							updateSlider(window.sliderfeaturePosition, this.getFirst().getFirst().innerHTML.toInt());

							var value = sliderfeaturePosition.RT.defaults[sliderfeaturePosition.RT.current][0];
							if (sliderfeaturePosition.RT.type == 'custom') {
								var defaults = sliderfeaturePosition.RT.defaults[sliderfeaturePosition.RT.current];
								var keys = sliderfeaturePosition.RT.keys[sliderfeaturePosition.RT.current];
								var tests = [];
								keys.each(function(key, i) {
									if (key.compareArrays(defaults.keys)) tests.push(i);
								});
								var list = sliderfeaturePosition.RT.list[sliderfeaturePosition.RT.current];
								
								tests.each(function(test, j) {
									if (list[test] == defaults.values[0]) {
										sliderfeaturePosition.set(test);
									}
								});
								
							} else {
								sliderfeaturePosition.set(sliderfeaturePosition.RT.list[sliderfeaturePosition.RT.current].indexOf(value));
							}
						});
					});
					updateBlocks(this, current);
				},
				
				onComplete: function(value, force) {
					this.knob.removeClass('down');
					var serialize = serializeSettings(this, new Hash(this.RT.settings));
					if (!force) document.id('paramsfeaturePosition').set('value', serialize);
					var setting = '';
					var step = Math.round(this.step);
					for (i = 0, len = this.RT.current; i < len; i++) {
						setting += this.RT.list[this.RT.current][(isNaN(step) || step < 0) ? 0 : step].toString().charAt(i);
					}
					if (this.RT.type != 'custom') this.RT.defaults[this.RT.current] = [setting];
					else {
						this.RT.defaults[this.RT.current].values = [setting];
						var keys = [];
						for (i=0,l=this.RT.current;i<l;i++) {
							keys.push(this.RT.blocks[i].innerHTML);
						}
						this.RT.defaults[this.RT.current].keys = keys;
					}
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						
						cache.set('featurePosition', document.id('paramsfeaturePosition').value);
					}
					
				},
				onDrag: function(now) {
					this.element.getFirst().setStyle('width', now + 10);
					var step = this.step;
					
					var layout = this.RT.list[this.RT.current][Math.round(step, 0)], output = '';
					if (!layout) return;
					
					layout = layout.toString();
					this.RT.settings[this.RT.current] = [];
					this.RT.store[this.RT.current] = [];
					for (i = 0, len = this.RT.current; i < len; i++) {
					    output += layout.charAt(i).hex2dec() + ((i == len - 1) ? '' : ' | ');
						
						if (this.RT.type == 'custom') {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
							this.RT.store[this.RT.current].push(this.RT.keys[this.RT.current][Math.round(step,0)][i]);
							
						} else {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
						}
						if (this.RT.keys) {
							var keyIndex = this.RT.keys[this.RT.current][Math.round(step,0)][i];
							this.RT.blocks[i].set('text', keyIndex);
						}
					}
					tip.set('html', output);
					
					updateBlocks(window.sliderfeaturePosition, this.RT.current, step);
				},
				onChange: function(position) {
					if(this.options.snap) position = this.toPosition(this.step);
					position = position || 0;
					this.knob.setStyle(this.property, position);
					this.fireEvent('onDrag', position);
				}
			});

			sliderfeaturePosition.RT.navigation[3].fireEvent('click');
			
			document.id('featurePosition').getElement('.knob').addEvents({
				'mousedown': function() {this.addClass('down');},
				'mouseup': function() {this.removeClass('down');}
			});
			
			document.id('featurePosition-wrapper').addEvents({
				'mouseenter': function() {
					var container = this.getElement('.mini-container');
					var pos = container.getCoordinates();
					tip.setStyles({
						'left': pos.left + pos.width + 5,
						'top': pos.top - 5
					});
					tip.set('html', updateTip(sliderfeaturePosition));
					tip.fx.start('opacity', 1);
				},
				'mouseleave': function() {
					tip.fx.start('opacity', 0);
				}
			});
		});
		
		window.addEvent('domready', function() {
			
			var tip = createTip('positions-tip');
			document.id('paramsutilityPosition').addEvent('set', function(value) {
				var baseValue = value;
				var slider = window.sliderutilityPosition.RT;
				
				if (!value.contains('{')) value = serialize(value.replace(/\s/g, '').split(','));
				
				value = value.unserialize();

				if (!value[slider.gridSize]) return;
				else value = new Hash(value[slider.gridSize]);
				
				var arrayMulti = {};
				var arraySingle = {};
				
				value.each(function(wrapper_value, key) {
					arrayMulti[key] = [];
					arraySingle[key] = [];
					if (slider.type == 'custom') {
						arrayMulti[key] = {};
						arraySingle[key] = {};
						arrayMulti[key]['keys'] = [];
						arrayMulti[key]['values'] = [];
						arraySingle[key]['keys'] = [];
						arraySingle[key]['values'] = [];
					}
					
					$H(wrapper_value).each(function(inner_value, inner_key) {
						var val = inner_value.toString().dec2hex();
						if (slider.type != 'custom') {
							arrayMulti[key].push(val);
							arraySingle[key].push(val);
						} else {
							arrayMulti[key]['keys'].push(inner_key);
							arraySingle[key]['keys'].push(inner_key);
							arrayMulti[key]['values'].push(val);
							arraySingle[key]['values'].push(val);
						}

					});
					if (slider.type != 'custom') arraySingle[key] = [arraySingle[key].join('')];
					else arraySingle[key]['values'] = [arraySingle[key]['values'].join('')];
				});
				
				slider.defaults = $merge(slider.defaults, arraySingle);
				
				if (slider.type != 'custom') {
					var cur = arraySingle[slider.current];
					if (cur) {
						var current = slider.list[slider.current].indexOf(cur[0]) || 0;
						window.sliderutilityPosition.set(current);//.fireEvent('onComplete', [current, true]);
					}
				} else {
					var defaults = slider.defaults[slider.current];
					var keys = slider.keys[slider.current];
					var tests = [];
					
					keys.each(function(key, i) {
						if (key.compareArrays(defaults.keys)) tests.push(i);
					});

					var list = slider.list[slider.current];
					
					tests.each(function(test, j) {
						if (list[test] == defaults.values[0]) {
							sliderutilityPosition.set(test);//.fireEvent('onComplete', [test, true]);
						}
					});
				}
			 	this.set('value', baseValue);
			});
			window.sliderutilityPosition = new RokSlider(document.id('utilityPosition').getElement('.position'), document.id('utilityPosition').getElement('.knob'), {
				offset: 5,
				snap: true,
				initialize: function() {
					this.hiddenEl = document.id('paramsutilityPosition');
					this.RT = {};
					this.RT.current = $$('#utilityPosition .list .active a')[0].getFirst().innerHTML.toInt();
					this.RT.list = {'1': ['c'],'2': ['2a', '39', '48', '57', '66', '75', '84', '93', 'a2'],'3': ['228', '237', '246', '255', '264', '273', '282', '327', '336', '345', '354', '363', '372', '426', '435', '444', '453', '462', '525', '534', '543', '552', '624', '633', '642', '723', '732', '822'],'4': ['2226', '2235', '2244', '2253', '2262', '2325', '2334', '2343', '2352', '2424', '2433', '2442', '2523', '2532', '2622', '3225', '3234', '3243', '3252', '3324', '3333', '3342', '3423', '3432', '3522', '4224', '4233', '4242', '4323', '4332', '4422', '5223', '5232', '5322', '6222'],'5': ['22224', '22233', '22242', '22323', '22332', '22422', '23223', '23232', '23322', '24222', '32223', '32232', '32322', '33222', '42222'],'6': ['222222']};
					this.RT.navigation = document.id('utilityPosition').getElement('.list').getChildren();
					this.RT.blocks = document.id('utilityPosition').getElements('.mini-grid');
					this.RT.settings = {};
					this.RT.gridSize = 12;
					this.RT.defaults = {3: ['336'], 1: ['c'], 2: ['66'], 4: ['3333'], 5: ['32223'], 6: ['222222']};
					this.RT.keyName = '' || '';
					this.RT.type = 'regular';
					this.RT.store = {};
					
					this.options.steps = this.RT.list[this.RT.current].length - 1;
					this.setOptions(this.options);

					var current = this.RT.current, navigation = this.RT.navigation, blocks = this.RT.blocks;
					var settings = this.RT.settings;
					navigation.each(function(nav, i) {
						settings[current] = [];
						nav.addEvent('click', function(event) {
							if (event) new Event(event).stop();
							navigation.removeClass('active');
							this.addClass('active');
							
							updateSlider(window.sliderutilityPosition, this.getFirst().getFirst().innerHTML.toInt());

							var value = sliderutilityPosition.RT.defaults[sliderutilityPosition.RT.current][0];
							if (sliderutilityPosition.RT.type == 'custom') {
								var defaults = sliderutilityPosition.RT.defaults[sliderutilityPosition.RT.current];
								var keys = sliderutilityPosition.RT.keys[sliderutilityPosition.RT.current];
								var tests = [];
								keys.each(function(key, i) {
									if (key.compareArrays(defaults.keys)) tests.push(i);
								});
								var list = sliderutilityPosition.RT.list[sliderutilityPosition.RT.current];
								
								tests.each(function(test, j) {
									if (list[test] == defaults.values[0]) {
										sliderutilityPosition.set(test);
									}
								});
								
							} else {
								sliderutilityPosition.set(sliderutilityPosition.RT.list[sliderutilityPosition.RT.current].indexOf(value));
							}
						});
					});
					updateBlocks(this, current);
				},
				
				onComplete: function(value, force) {
					this.knob.removeClass('down');
					var serialize = serializeSettings(this, new Hash(this.RT.settings));
					if (!force) document.id('paramsutilityPosition').set('value', serialize);
					var setting = '';
					var step = Math.round(this.step);
					for (i = 0, len = this.RT.current; i < len; i++) {
						setting += this.RT.list[this.RT.current][(isNaN(step) || step < 0) ? 0 : step].toString().charAt(i);
					}
					if (this.RT.type != 'custom') this.RT.defaults[this.RT.current] = [setting];
					else {
						this.RT.defaults[this.RT.current].values = [setting];
						var keys = [];
						for (i=0,l=this.RT.current;i<l;i++) {
							keys.push(this.RT.blocks[i].innerHTML);
						}
						this.RT.defaults[this.RT.current].keys = keys;
					}
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						
						cache.set('utilityPosition', document.id('paramsutilityPosition').value);
					}
					
				},
				onDrag: function(now) {
					this.element.getFirst().setStyle('width', now + 10);
					var step = this.step;
					
					var layout = this.RT.list[this.RT.current][Math.round(step, 0)], output = '';
					if (!layout) return;
					
					layout = layout.toString();
					this.RT.settings[this.RT.current] = [];
					this.RT.store[this.RT.current] = [];
					for (i = 0, len = this.RT.current; i < len; i++) {
					    output += layout.charAt(i).hex2dec() + ((i == len - 1) ? '' : ' | ');
						
						if (this.RT.type == 'custom') {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
							this.RT.store[this.RT.current].push(this.RT.keys[this.RT.current][Math.round(step,0)][i]);
							
						} else {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
						}
						if (this.RT.keys) {
							var keyIndex = this.RT.keys[this.RT.current][Math.round(step,0)][i];
							this.RT.blocks[i].set('text', keyIndex);
						}
					}
					tip.set('html', output);
					
					updateBlocks(window.sliderutilityPosition, this.RT.current, step);
				},
				onChange: function(position) {
					if(this.options.snap) position = this.toPosition(this.step);
					position = position || 0;
					this.knob.setStyle(this.property, position);
					this.fireEvent('onDrag', position);
				}
			});

			sliderutilityPosition.RT.navigation[3].fireEvent('click');
			
			document.id('utilityPosition').getElement('.knob').addEvents({
				'mousedown': function() {this.addClass('down');},
				'mouseup': function() {this.removeClass('down');}
			});
			
			document.id('utilityPosition-wrapper').addEvents({
				'mouseenter': function() {
					var container = this.getElement('.mini-container');
					var pos = container.getCoordinates();
					tip.setStyles({
						'left': pos.left + pos.width + 5,
						'top': pos.top - 5
					});
					tip.set('html', updateTip(sliderutilityPosition));
					tip.fx.start('opacity', 1);
				},
				'mouseleave': function() {
					tip.fx.start('opacity', 0);
				}
			});
		});
		
		window.addEvent('domready', function() {
			
			var tip = createTip('positions-tip');
			document.id('paramsmaintopPosition').addEvent('set', function(value) {
				var baseValue = value;
				var slider = window.slidermaintopPosition.RT;
				
				if (!value.contains('{')) value = serialize(value.replace(/\s/g, '').split(','));
				
				value = value.unserialize();

				if (!value[slider.gridSize]) return;
				else value = new Hash(value[slider.gridSize]);
				
				var arrayMulti = {};
				var arraySingle = {};
				
				value.each(function(wrapper_value, key) {
					arrayMulti[key] = [];
					arraySingle[key] = [];
					if (slider.type == 'custom') {
						arrayMulti[key] = {};
						arraySingle[key] = {};
						arrayMulti[key]['keys'] = [];
						arrayMulti[key]['values'] = [];
						arraySingle[key]['keys'] = [];
						arraySingle[key]['values'] = [];
					}
					
					$H(wrapper_value).each(function(inner_value, inner_key) {
						var val = inner_value.toString().dec2hex();
						if (slider.type != 'custom') {
							arrayMulti[key].push(val);
							arraySingle[key].push(val);
						} else {
							arrayMulti[key]['keys'].push(inner_key);
							arraySingle[key]['keys'].push(inner_key);
							arrayMulti[key]['values'].push(val);
							arraySingle[key]['values'].push(val);
						}

					});
					if (slider.type != 'custom') arraySingle[key] = [arraySingle[key].join('')];
					else arraySingle[key]['values'] = [arraySingle[key]['values'].join('')];
				});
				
				slider.defaults = $merge(slider.defaults, arraySingle);
				
				if (slider.type != 'custom') {
					var cur = arraySingle[slider.current];
					if (cur) {
						var current = slider.list[slider.current].indexOf(cur[0]) || 0;
						window.slidermaintopPosition.set(current);//.fireEvent('onComplete', [current, true]);
					}
				} else {
					var defaults = slider.defaults[slider.current];
					var keys = slider.keys[slider.current];
					var tests = [];
					
					keys.each(function(key, i) {
						if (key.compareArrays(defaults.keys)) tests.push(i);
					});

					var list = slider.list[slider.current];
					
					tests.each(function(test, j) {
						if (list[test] == defaults.values[0]) {
							slidermaintopPosition.set(test);//.fireEvent('onComplete', [test, true]);
						}
					});
				}
			 	this.set('value', baseValue);
			});
			window.slidermaintopPosition = new RokSlider(document.id('maintopPosition').getElement('.position'), document.id('maintopPosition').getElement('.knob'), {
				offset: 5,
				snap: true,
				initialize: function() {
					this.hiddenEl = document.id('paramsmaintopPosition');
					this.RT = {};
					this.RT.current = $$('#maintopPosition .list .active a')[0].getFirst().innerHTML.toInt();
					this.RT.list = {'1': ['c'],'2': ['2a', '39', '48', '57', '66', '75', '84', '93', 'a2'],'3': ['228', '237', '246', '255', '264', '273', '282', '327', '336', '345', '354', '363', '372', '426', '435', '444', '453', '462', '525', '534', '543', '552', '624', '633', '642', '723', '732', '822'],'4': ['2226', '2235', '2244', '2253', '2262', '2325', '2334', '2343', '2352', '2424', '2433', '2442', '2523', '2532', '2622', '3225', '3234', '3243', '3252', '3324', '3333', '3342', '3423', '3432', '3522', '4224', '4233', '4242', '4323', '4332', '4422', '5223', '5232', '5322', '6222'],'5': ['22224', '22233', '22242', '22323', '22332', '22422', '23223', '23232', '23322', '24222', '32223', '32232', '32322', '33222', '42222'],'6': ['222222']};
					this.RT.navigation = document.id('maintopPosition').getElement('.list').getChildren();
					this.RT.blocks = document.id('maintopPosition').getElements('.mini-grid');
					this.RT.settings = {};
					this.RT.gridSize = 12;
					this.RT.defaults = {4: ['3333'], 1: ['c'], 2: ['66'], 3: ['444'], 5: ['32223'], 6: ['222222']};
					this.RT.keyName = '' || '';
					this.RT.type = 'regular';
					this.RT.store = {};
					
					this.options.steps = this.RT.list[this.RT.current].length - 1;
					this.setOptions(this.options);

					var current = this.RT.current, navigation = this.RT.navigation, blocks = this.RT.blocks;
					var settings = this.RT.settings;
					navigation.each(function(nav, i) {
						settings[current] = [];
						nav.addEvent('click', function(event) {
							if (event) new Event(event).stop();
							navigation.removeClass('active');
							this.addClass('active');
							
							updateSlider(window.slidermaintopPosition, this.getFirst().getFirst().innerHTML.toInt());

							var value = slidermaintopPosition.RT.defaults[slidermaintopPosition.RT.current][0];
							if (slidermaintopPosition.RT.type == 'custom') {
								var defaults = slidermaintopPosition.RT.defaults[slidermaintopPosition.RT.current];
								var keys = slidermaintopPosition.RT.keys[slidermaintopPosition.RT.current];
								var tests = [];
								keys.each(function(key, i) {
									if (key.compareArrays(defaults.keys)) tests.push(i);
								});
								var list = slidermaintopPosition.RT.list[slidermaintopPosition.RT.current];
								
								tests.each(function(test, j) {
									if (list[test] == defaults.values[0]) {
										slidermaintopPosition.set(test);
									}
								});
								
							} else {
								slidermaintopPosition.set(slidermaintopPosition.RT.list[slidermaintopPosition.RT.current].indexOf(value));
							}
						});
					});
					updateBlocks(this, current);
				},
				
				onComplete: function(value, force) {
					this.knob.removeClass('down');
					var serialize = serializeSettings(this, new Hash(this.RT.settings));
					if (!force) document.id('paramsmaintopPosition').set('value', serialize);
					var setting = '';
					var step = Math.round(this.step);
					for (i = 0, len = this.RT.current; i < len; i++) {
						setting += this.RT.list[this.RT.current][(isNaN(step) || step < 0) ? 0 : step].toString().charAt(i);
					}
					if (this.RT.type != 'custom') this.RT.defaults[this.RT.current] = [setting];
					else {
						this.RT.defaults[this.RT.current].values = [setting];
						var keys = [];
						for (i=0,l=this.RT.current;i<l;i++) {
							keys.push(this.RT.blocks[i].innerHTML);
						}
						this.RT.defaults[this.RT.current].keys = keys;
					}
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						
						cache.set('maintopPosition', document.id('paramsmaintopPosition').value);
					}
					
				},
				onDrag: function(now) {
					this.element.getFirst().setStyle('width', now + 10);
					var step = this.step;
					
					var layout = this.RT.list[this.RT.current][Math.round(step, 0)], output = '';
					if (!layout) return;
					
					layout = layout.toString();
					this.RT.settings[this.RT.current] = [];
					this.RT.store[this.RT.current] = [];
					for (i = 0, len = this.RT.current; i < len; i++) {
					    output += layout.charAt(i).hex2dec() + ((i == len - 1) ? '' : ' | ');
						
						if (this.RT.type == 'custom') {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
							this.RT.store[this.RT.current].push(this.RT.keys[this.RT.current][Math.round(step,0)][i]);
							
						} else {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
						}
						if (this.RT.keys) {
							var keyIndex = this.RT.keys[this.RT.current][Math.round(step,0)][i];
							this.RT.blocks[i].set('text', keyIndex);
						}
					}
					tip.set('html', output);
					
					updateBlocks(window.slidermaintopPosition, this.RT.current, step);
				},
				onChange: function(position) {
					if(this.options.snap) position = this.toPosition(this.step);
					position = position || 0;
					this.knob.setStyle(this.property, position);
					this.fireEvent('onDrag', position);
				}
			});

			slidermaintopPosition.RT.navigation[3].fireEvent('click');
			
			document.id('maintopPosition').getElement('.knob').addEvents({
				'mousedown': function() {this.addClass('down');},
				'mouseup': function() {this.removeClass('down');}
			});
			
			document.id('maintopPosition-wrapper').addEvents({
				'mouseenter': function() {
					var container = this.getElement('.mini-container');
					var pos = container.getCoordinates();
					tip.setStyles({
						'left': pos.left + pos.width + 5,
						'top': pos.top - 5
					});
					tip.set('html', updateTip(slidermaintopPosition));
					tip.fx.start('opacity', 1);
				},
				'mouseleave': function() {
					tip.fx.start('opacity', 0);
				}
			});
		});
		
		window.addEvent('domready', function() {
			
			var tip = createTip('positions-tip');
			document.id('paramsmainbodyPosition').addEvent('set', function(value) {
				var baseValue = value;
				var slider = window.slidermainbodyPosition.RT;
				
				if (!value.contains('{')) value = serialize(value.replace(/\s/g, '').split(','));
				
				value = value.unserialize();

				if (!value[slider.gridSize]) return;
				else value = new Hash(value[slider.gridSize]);
				
				var arrayMulti = {};
				var arraySingle = {};
				
				value.each(function(wrapper_value, key) {
					arrayMulti[key] = [];
					arraySingle[key] = [];
					if (slider.type == 'custom') {
						arrayMulti[key] = {};
						arraySingle[key] = {};
						arrayMulti[key]['keys'] = [];
						arrayMulti[key]['values'] = [];
						arraySingle[key]['keys'] = [];
						arraySingle[key]['values'] = [];
					}
					
					$H(wrapper_value).each(function(inner_value, inner_key) {
						var val = inner_value.toString().dec2hex();
						if (slider.type != 'custom') {
							arrayMulti[key].push(val);
							arraySingle[key].push(val);
						} else {
							arrayMulti[key]['keys'].push(inner_key);
							arraySingle[key]['keys'].push(inner_key);
							arrayMulti[key]['values'].push(val);
							arraySingle[key]['values'].push(val);
						}

					});
					if (slider.type != 'custom') arraySingle[key] = [arraySingle[key].join('')];
					else arraySingle[key]['values'] = [arraySingle[key]['values'].join('')];
				});
				
				slider.defaults = $merge(slider.defaults, arraySingle);
				
				if (slider.type != 'custom') {
					var cur = arraySingle[slider.current];
					if (cur) {
						var current = slider.list[slider.current].indexOf(cur[0]) || 0;
						window.slidermainbodyPosition.set(current);//.fireEvent('onComplete', [current, true]);
					}
				} else {
					var defaults = slider.defaults[slider.current];
					var keys = slider.keys[slider.current];
					var tests = [];
					
					keys.each(function(key, i) {
						if (key.compareArrays(defaults.keys)) tests.push(i);
					});

					var list = slider.list[slider.current];
					
					tests.each(function(test, j) {
						if (list[test] == defaults.values[0]) {
							slidermainbodyPosition.set(test);//.fireEvent('onComplete', [test, true]);
						}
					});
				}
			 	this.set('value', baseValue);
			});
			window.slidermainbodyPosition = new RokSlider(document.id('mainbodyPosition').getElement('.position'), document.id('mainbodyPosition').getElement('.knob'), {
				offset: 5,
				snap: true,
				initialize: function() {
					this.hiddenEl = document.id('paramsmainbodyPosition');
					this.RT = {};
					this.RT.current = $$('#mainbodyPosition .list .active a')[0].getFirst().innerHTML.toInt();
					this.RT.list = {'1': ['c'],'2': ['66', '75', '84', '93', '66', '57', '48', '39'],'3': ['444', '633', '822', '444', '363', '282', '444', '336', '228'],'4': ['3333', '4233', '4323', '4332', '6222', '3333', '3423', '2433', '3432', '2622', '3333', '3243', '2343', '3342', '2262', '3333', '3324', '3234', '2334', '2226']}; this.RT.keys = {'1': [['mb']],'2': [['mb', 'sa'], ['mb', 'sa'], ['mb', 'sa'], ['mb', 'sa'], ['sa', 'mb'], ['sa', 'mb'], ['sa', 'mb'], ['sa', 'mb']],'3': [['mb', 'sa', 'sb'], ['mb', 'sa', 'sb'], ['mb', 'sa', 'sb'], ['sa', 'mb', 'sb'], ['sa', 'mb', 'sb'], ['sa', 'mb', 'sb'], ['sa', 'sb', 'mb'], ['sa', 'sb', 'mb'], ['sa', 'sb', 'mb']],'4': [['mb', 'sa', 'sb', 'sc'], ['mb', 'sa', 'sb', 'sc'], ['mb', 'sa', 'sb', 'sc'], ['mb', 'sa', 'sb', 'sc'], ['mb', 'sa', 'sb', 'sc'], ['sa', 'mb', 'sb', 'sc'], ['sa', 'mb', 'sb', 'sc'], ['sa', 'mb', 'sb', 'sc'], ['sa', 'mb', 'sb', 'sc'], ['sa', 'mb', 'sb', 'sc'], ['sa', 'sb', 'mb', 'sc'], ['sa', 'sb', 'mb', 'sc'], ['sa', 'sb', 'mb', 'sc'], ['sa', 'sb', 'mb', 'sc'], ['sa', 'sb', 'mb', 'sc'], ['sa', 'sb', 'sc', 'mb'], ['sa', 'sb', 'sc', 'mb'], ['sa', 'sb', 'sc', 'mb'], ['sa', 'sb', 'sc', 'mb'], ['sa', 'sb', 'sc', 'mb']]};
					this.RT.navigation = document.id('mainbodyPosition').getElement('.list').getChildren();
					this.RT.blocks = document.id('mainbodyPosition').getElements('.mini-grid');
					this.RT.settings = {};
					this.RT.gridSize = 12;
					this.RT.defaults = {2: {'values': ['84'], 'keys': ["mb", "sa"]}, 1: {'values': ['c'], 'keys': ["mb"]}, 3: {'values': ['633'], 'keys': ["mb", "sa", "sb"]}, 4: {'values': ['6222'], 'keys': ["mb", "sa", "sb", "sc"]}};
					this.RT.keyName = 'mb' || '';
					this.RT.type = 'custom';
					this.RT.store = {};
					
					this.options.steps = this.RT.list[this.RT.current].length - 1;
					this.setOptions(this.options);

					var current = this.RT.current, navigation = this.RT.navigation, blocks = this.RT.blocks;
					var settings = this.RT.settings;
					navigation.each(function(nav, i) {
						settings[current] = [];
						nav.addEvent('click', function(event) {
							if (event) new Event(event).stop();
							navigation.removeClass('active');
							this.addClass('active');
							
							updateSlider(window.slidermainbodyPosition, this.getFirst().getFirst().innerHTML.toInt());

							var value = slidermainbodyPosition.RT.defaults[slidermainbodyPosition.RT.current][0];
							if (slidermainbodyPosition.RT.type == 'custom') {
								var defaults = slidermainbodyPosition.RT.defaults[slidermainbodyPosition.RT.current];
								var keys = slidermainbodyPosition.RT.keys[slidermainbodyPosition.RT.current];
								var tests = [];
								keys.each(function(key, i) {
									if (key.compareArrays(defaults.keys)) tests.push(i);
								});
								var list = slidermainbodyPosition.RT.list[slidermainbodyPosition.RT.current];
								
								tests.each(function(test, j) {
									if (list[test] == defaults.values[0]) {
										slidermainbodyPosition.set(test);
									}
								});
								
							} else {
								slidermainbodyPosition.set(slidermainbodyPosition.RT.list[slidermainbodyPosition.RT.current].indexOf(value));
							}
						});
					});
					updateBlocks(this, current);
				},
				
				onComplete: function(value, force) {
					this.knob.removeClass('down');
					var serialize = serializeSettings(this, new Hash(this.RT.settings));
					if (!force) document.id('paramsmainbodyPosition').set('value', serialize);
					var setting = '';
					var step = Math.round(this.step);
					for (i = 0, len = this.RT.current; i < len; i++) {
						setting += this.RT.list[this.RT.current][(isNaN(step) || step < 0) ? 0 : step].toString().charAt(i);
					}
					if (this.RT.type != 'custom') this.RT.defaults[this.RT.current] = [setting];
					else {
						this.RT.defaults[this.RT.current].values = [setting];
						var keys = [];
						for (i=0,l=this.RT.current;i<l;i++) {
							keys.push(this.RT.blocks[i].innerHTML);
						}
						this.RT.defaults[this.RT.current].keys = keys;
					}
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						
						cache.set('mainbodyPosition', document.id('paramsmainbodyPosition').value);
					}
					
				},
				onDrag: function(now) {
					this.element.getFirst().setStyle('width', now + 10);
					var step = this.step;
					
					var layout = this.RT.list[this.RT.current][Math.round(step, 0)], output = '';
					if (!layout) return;
					
					layout = layout.toString();
					this.RT.settings[this.RT.current] = [];
					this.RT.store[this.RT.current] = [];
					for (i = 0, len = this.RT.current; i < len; i++) {
					    output += layout.charAt(i).hex2dec() + ((i == len - 1) ? '' : ' | ');
						
						if (this.RT.type == 'custom') {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
							this.RT.store[this.RT.current].push(this.RT.keys[this.RT.current][Math.round(step,0)][i]);
							
						} else {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
						}
						if (this.RT.keys) {
							var keyIndex = this.RT.keys[this.RT.current][Math.round(step,0)][i];
							this.RT.blocks[i].set('text', keyIndex);
						}
					}
					tip.set('html', output);
					
					updateBlocks(window.slidermainbodyPosition, this.RT.current, step);
				},
				onChange: function(position) {
					if(this.options.snap) position = this.toPosition(this.step);
					position = position || 0;
					this.knob.setStyle(this.property, position);
					this.fireEvent('onDrag', position);
				}
			});

			slidermainbodyPosition.RT.navigation[1].fireEvent('click');
			
			document.id('mainbodyPosition').getElement('.knob').addEvents({
				'mousedown': function() {this.addClass('down');},
				'mouseup': function() {this.removeClass('down');}
			});
			
			document.id('mainbodyPosition-wrapper').addEvents({
				'mouseenter': function() {
					var container = this.getElement('.mini-container');
					var pos = container.getCoordinates();
					tip.setStyles({
						'left': pos.left + pos.width + 5,
						'top': pos.top - 5
					});
					tip.set('html', updateTip(slidermainbodyPosition));
					tip.fx.start('opacity', 1);
				},
				'mouseleave': function() {
					tip.fx.start('opacity', 0);
				}
			});
		});
		
		window.addEvent('domready', function() {
			
			var tip = createTip('positions-tip');
			document.id('paramsmainbottomPosition').addEvent('set', function(value) {
				var baseValue = value;
				var slider = window.slidermainbottomPosition.RT;
				
				if (!value.contains('{')) value = serialize(value.replace(/\s/g, '').split(','));
				
				value = value.unserialize();

				if (!value[slider.gridSize]) return;
				else value = new Hash(value[slider.gridSize]);
				
				var arrayMulti = {};
				var arraySingle = {};
				
				value.each(function(wrapper_value, key) {
					arrayMulti[key] = [];
					arraySingle[key] = [];
					if (slider.type == 'custom') {
						arrayMulti[key] = {};
						arraySingle[key] = {};
						arrayMulti[key]['keys'] = [];
						arrayMulti[key]['values'] = [];
						arraySingle[key]['keys'] = [];
						arraySingle[key]['values'] = [];
					}
					
					$H(wrapper_value).each(function(inner_value, inner_key) {
						var val = inner_value.toString().dec2hex();
						if (slider.type != 'custom') {
							arrayMulti[key].push(val);
							arraySingle[key].push(val);
						} else {
							arrayMulti[key]['keys'].push(inner_key);
							arraySingle[key]['keys'].push(inner_key);
							arrayMulti[key]['values'].push(val);
							arraySingle[key]['values'].push(val);
						}

					});
					if (slider.type != 'custom') arraySingle[key] = [arraySingle[key].join('')];
					else arraySingle[key]['values'] = [arraySingle[key]['values'].join('')];
				});
				
				slider.defaults = $merge(slider.defaults, arraySingle);
				
				if (slider.type != 'custom') {
					var cur = arraySingle[slider.current];
					if (cur) {
						var current = slider.list[slider.current].indexOf(cur[0]) || 0;
						window.slidermainbottomPosition.set(current);//.fireEvent('onComplete', [current, true]);
					}
				} else {
					var defaults = slider.defaults[slider.current];
					var keys = slider.keys[slider.current];
					var tests = [];
					
					keys.each(function(key, i) {
						if (key.compareArrays(defaults.keys)) tests.push(i);
					});

					var list = slider.list[slider.current];
					
					tests.each(function(test, j) {
						if (list[test] == defaults.values[0]) {
							slidermainbottomPosition.set(test);//.fireEvent('onComplete', [test, true]);
						}
					});
				}
			 	this.set('value', baseValue);
			});
			window.slidermainbottomPosition = new RokSlider(document.id('mainbottomPosition').getElement('.position'), document.id('mainbottomPosition').getElement('.knob'), {
				offset: 5,
				snap: true,
				initialize: function() {
					this.hiddenEl = document.id('paramsmainbottomPosition');
					this.RT = {};
					this.RT.current = $$('#mainbottomPosition .list .active a')[0].getFirst().innerHTML.toInt();
					this.RT.list = {'1': ['c'],'2': ['2a', '39', '48', '57', '66', '75', '84', '93', 'a2'],'3': ['228', '237', '246', '255', '264', '273', '282', '327', '336', '345', '354', '363', '372', '426', '435', '444', '453', '462', '525', '534', '543', '552', '624', '633', '642', '723', '732', '822'],'4': ['2226', '2235', '2244', '2253', '2262', '2325', '2334', '2343', '2352', '2424', '2433', '2442', '2523', '2532', '2622', '3225', '3234', '3243', '3252', '3324', '3333', '3342', '3423', '3432', '3522', '4224', '4233', '4242', '4323', '4332', '4422', '5223', '5232', '5322', '6222'],'5': ['22224', '22233', '22242', '22323', '22332', '22422', '23223', '23232', '23322', '24222', '32223', '32232', '32322', '33222', '42222'],'6': ['222222']};
					this.RT.navigation = document.id('mainbottomPosition').getElement('.list').getChildren();
					this.RT.blocks = document.id('mainbottomPosition').getElements('.mini-grid');
					this.RT.settings = {};
					this.RT.gridSize = 12;
					this.RT.defaults = {2: ['66'], 1: ['c'], 3: ['444'], 4: ['3333'], 5: ['32223'], 6: ['222222']};
					this.RT.keyName = '' || '';
					this.RT.type = 'regular';
					this.RT.store = {};
					
					this.options.steps = this.RT.list[this.RT.current].length - 1;
					this.setOptions(this.options);

					var current = this.RT.current, navigation = this.RT.navigation, blocks = this.RT.blocks;
					var settings = this.RT.settings;
					navigation.each(function(nav, i) {
						settings[current] = [];
						nav.addEvent('click', function(event) {
							if (event) new Event(event).stop();
							navigation.removeClass('active');
							this.addClass('active');
							
							updateSlider(window.slidermainbottomPosition, this.getFirst().getFirst().innerHTML.toInt());

							var value = slidermainbottomPosition.RT.defaults[slidermainbottomPosition.RT.current][0];
							if (slidermainbottomPosition.RT.type == 'custom') {
								var defaults = slidermainbottomPosition.RT.defaults[slidermainbottomPosition.RT.current];
								var keys = slidermainbottomPosition.RT.keys[slidermainbottomPosition.RT.current];
								var tests = [];
								keys.each(function(key, i) {
									if (key.compareArrays(defaults.keys)) tests.push(i);
								});
								var list = slidermainbottomPosition.RT.list[slidermainbottomPosition.RT.current];
								
								tests.each(function(test, j) {
									if (list[test] == defaults.values[0]) {
										slidermainbottomPosition.set(test);
									}
								});
								
							} else {
								slidermainbottomPosition.set(slidermainbottomPosition.RT.list[slidermainbottomPosition.RT.current].indexOf(value));
							}
						});
					});
					updateBlocks(this, current);
				},
				
				onComplete: function(value, force) {
					this.knob.removeClass('down');
					var serialize = serializeSettings(this, new Hash(this.RT.settings));
					if (!force) document.id('paramsmainbottomPosition').set('value', serialize);
					var setting = '';
					var step = Math.round(this.step);
					for (i = 0, len = this.RT.current; i < len; i++) {
						setting += this.RT.list[this.RT.current][(isNaN(step) || step < 0) ? 0 : step].toString().charAt(i);
					}
					if (this.RT.type != 'custom') this.RT.defaults[this.RT.current] = [setting];
					else {
						this.RT.defaults[this.RT.current].values = [setting];
						var keys = [];
						for (i=0,l=this.RT.current;i<l;i++) {
							keys.push(this.RT.blocks[i].innerHTML);
						}
						this.RT.defaults[this.RT.current].keys = keys;
					}
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						
						cache.set('mainbottomPosition', document.id('paramsmainbottomPosition').value);
					}
					
				},
				onDrag: function(now) {
					this.element.getFirst().setStyle('width', now + 10);
					var step = this.step;
					
					var layout = this.RT.list[this.RT.current][Math.round(step, 0)], output = '';
					if (!layout) return;
					
					layout = layout.toString();
					this.RT.settings[this.RT.current] = [];
					this.RT.store[this.RT.current] = [];
					for (i = 0, len = this.RT.current; i < len; i++) {
					    output += layout.charAt(i).hex2dec() + ((i == len - 1) ? '' : ' | ');
						
						if (this.RT.type == 'custom') {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
							this.RT.store[this.RT.current].push(this.RT.keys[this.RT.current][Math.round(step,0)][i]);
							
						} else {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
						}
						if (this.RT.keys) {
							var keyIndex = this.RT.keys[this.RT.current][Math.round(step,0)][i];
							this.RT.blocks[i].set('text', keyIndex);
						}
					}
					tip.set('html', output);
					
					updateBlocks(window.slidermainbottomPosition, this.RT.current, step);
				},
				onChange: function(position) {
					if(this.options.snap) position = this.toPosition(this.step);
					position = position || 0;
					this.knob.setStyle(this.property, position);
					this.fireEvent('onDrag', position);
				}
			});

			slidermainbottomPosition.RT.navigation[3].fireEvent('click');
			
			document.id('mainbottomPosition').getElement('.knob').addEvents({
				'mousedown': function() {this.addClass('down');},
				'mouseup': function() {this.removeClass('down');}
			});
			
			document.id('mainbottomPosition-wrapper').addEvents({
				'mouseenter': function() {
					var container = this.getElement('.mini-container');
					var pos = container.getCoordinates();
					tip.setStyles({
						'left': pos.left + pos.width + 5,
						'top': pos.top - 5
					});
					tip.set('html', updateTip(slidermainbottomPosition));
					tip.fx.start('opacity', 1);
				},
				'mouseleave': function() {
					tip.fx.start('opacity', 0);
				}
			});
		});
		
		window.addEvent('domready', function() {
			
			var tip = createTip('positions-tip');
			document.id('paramsbottomPosition').addEvent('set', function(value) {
				var baseValue = value;
				var slider = window.sliderbottomPosition.RT;
				
				if (!value.contains('{')) value = serialize(value.replace(/\s/g, '').split(','));
				
				value = value.unserialize();

				if (!value[slider.gridSize]) return;
				else value = new Hash(value[slider.gridSize]);
				
				var arrayMulti = {};
				var arraySingle = {};
				
				value.each(function(wrapper_value, key) {
					arrayMulti[key] = [];
					arraySingle[key] = [];
					if (slider.type == 'custom') {
						arrayMulti[key] = {};
						arraySingle[key] = {};
						arrayMulti[key]['keys'] = [];
						arrayMulti[key]['values'] = [];
						arraySingle[key]['keys'] = [];
						arraySingle[key]['values'] = [];
					}
					
					$H(wrapper_value).each(function(inner_value, inner_key) {
						var val = inner_value.toString().dec2hex();
						if (slider.type != 'custom') {
							arrayMulti[key].push(val);
							arraySingle[key].push(val);
						} else {
							arrayMulti[key]['keys'].push(inner_key);
							arraySingle[key]['keys'].push(inner_key);
							arrayMulti[key]['values'].push(val);
							arraySingle[key]['values'].push(val);
						}

					});
					if (slider.type != 'custom') arraySingle[key] = [arraySingle[key].join('')];
					else arraySingle[key]['values'] = [arraySingle[key]['values'].join('')];
				});
				
				slider.defaults = $merge(slider.defaults, arraySingle);
				
				if (slider.type != 'custom') {
					var cur = arraySingle[slider.current];
					if (cur) {
						var current = slider.list[slider.current].indexOf(cur[0]) || 0;
						window.sliderbottomPosition.set(current);//.fireEvent('onComplete', [current, true]);
					}
				} else {
					var defaults = slider.defaults[slider.current];
					var keys = slider.keys[slider.current];
					var tests = [];
					
					keys.each(function(key, i) {
						if (key.compareArrays(defaults.keys)) tests.push(i);
					});

					var list = slider.list[slider.current];
					
					tests.each(function(test, j) {
						if (list[test] == defaults.values[0]) {
							sliderbottomPosition.set(test);//.fireEvent('onComplete', [test, true]);
						}
					});
				}
			 	this.set('value', baseValue);
			});
			window.sliderbottomPosition = new RokSlider(document.id('bottomPosition').getElement('.position'), document.id('bottomPosition').getElement('.knob'), {
				offset: 5,
				snap: true,
				initialize: function() {
					this.hiddenEl = document.id('paramsbottomPosition');
					this.RT = {};
					this.RT.current = $$('#bottomPosition .list .active a')[0].getFirst().innerHTML.toInt();
					this.RT.list = {'1': ['c'],'2': ['2a', '39', '48', '57', '66', '75', '84', '93', 'a2'],'3': ['228', '237', '246', '255', '264', '273', '282', '327', '336', '345', '354', '363', '372', '426', '435', '444', '453', '462', '525', '534', '543', '552', '624', '633', '642', '723', '732', '822'],'4': ['2226', '2235', '2244', '2253', '2262', '2325', '2334', '2343', '2352', '2424', '2433', '2442', '2523', '2532', '2622', '3225', '3234', '3243', '3252', '3324', '3333', '3342', '3423', '3432', '3522', '4224', '4233', '4242', '4323', '4332', '4422', '5223', '5232', '5322', '6222'],'5': ['22224', '22233', '22242', '22323', '22332', '22422', '23223', '23232', '23322', '24222', '32223', '32232', '32322', '33222', '42222'],'6': ['222222']};
					this.RT.navigation = document.id('bottomPosition').getElement('.list').getChildren();
					this.RT.blocks = document.id('bottomPosition').getElements('.mini-grid');
					this.RT.settings = {};
					this.RT.gridSize = 12;
					this.RT.defaults = {3: ['444'], 1: ['c'], 2: ['66'], 4: ['3333'], 5: ['32223'], 6: ['222222']};
					this.RT.keyName = '' || '';
					this.RT.type = 'regular';
					this.RT.store = {};
					
					this.options.steps = this.RT.list[this.RT.current].length - 1;
					this.setOptions(this.options);

					var current = this.RT.current, navigation = this.RT.navigation, blocks = this.RT.blocks;
					var settings = this.RT.settings;
					navigation.each(function(nav, i) {
						settings[current] = [];
						nav.addEvent('click', function(event) {
							if (event) new Event(event).stop();
							navigation.removeClass('active');
							this.addClass('active');
							
							updateSlider(window.sliderbottomPosition, this.getFirst().getFirst().innerHTML.toInt());

							var value = sliderbottomPosition.RT.defaults[sliderbottomPosition.RT.current][0];
							if (sliderbottomPosition.RT.type == 'custom') {
								var defaults = sliderbottomPosition.RT.defaults[sliderbottomPosition.RT.current];
								var keys = sliderbottomPosition.RT.keys[sliderbottomPosition.RT.current];
								var tests = [];
								keys.each(function(key, i) {
									if (key.compareArrays(defaults.keys)) tests.push(i);
								});
								var list = sliderbottomPosition.RT.list[sliderbottomPosition.RT.current];
								
								tests.each(function(test, j) {
									if (list[test] == defaults.values[0]) {
										sliderbottomPosition.set(test);
									}
								});
								
							} else {
								sliderbottomPosition.set(sliderbottomPosition.RT.list[sliderbottomPosition.RT.current].indexOf(value));
							}
						});
					});
					updateBlocks(this, current);
				},
				
				onComplete: function(value, force) {
					this.knob.removeClass('down');
					var serialize = serializeSettings(this, new Hash(this.RT.settings));
					if (!force) document.id('paramsbottomPosition').set('value', serialize);
					var setting = '';
					var step = Math.round(this.step);
					for (i = 0, len = this.RT.current; i < len; i++) {
						setting += this.RT.list[this.RT.current][(isNaN(step) || step < 0) ? 0 : step].toString().charAt(i);
					}
					if (this.RT.type != 'custom') this.RT.defaults[this.RT.current] = [setting];
					else {
						this.RT.defaults[this.RT.current].values = [setting];
						var keys = [];
						for (i=0,l=this.RT.current;i<l;i++) {
							keys.push(this.RT.blocks[i].innerHTML);
						}
						this.RT.defaults[this.RT.current].keys = keys;
					}
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						
						cache.set('bottomPosition', document.id('paramsbottomPosition').value);
					}
					
				},
				onDrag: function(now) {
					this.element.getFirst().setStyle('width', now + 10);
					var step = this.step;
					
					var layout = this.RT.list[this.RT.current][Math.round(step, 0)], output = '';
					if (!layout) return;
					
					layout = layout.toString();
					this.RT.settings[this.RT.current] = [];
					this.RT.store[this.RT.current] = [];
					for (i = 0, len = this.RT.current; i < len; i++) {
					    output += layout.charAt(i).hex2dec() + ((i == len - 1) ? '' : ' | ');
						
						if (this.RT.type == 'custom') {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
							this.RT.store[this.RT.current].push(this.RT.keys[this.RT.current][Math.round(step,0)][i]);
							
						} else {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
						}
						if (this.RT.keys) {
							var keyIndex = this.RT.keys[this.RT.current][Math.round(step,0)][i];
							this.RT.blocks[i].set('text', keyIndex);
						}
					}
					tip.set('html', output);
					
					updateBlocks(window.sliderbottomPosition, this.RT.current, step);
				},
				onChange: function(position) {
					if(this.options.snap) position = this.toPosition(this.step);
					position = position || 0;
					this.knob.setStyle(this.property, position);
					this.fireEvent('onDrag', position);
				}
			});

			sliderbottomPosition.RT.navigation[3].fireEvent('click');
			
			document.id('bottomPosition').getElement('.knob').addEvents({
				'mousedown': function() {this.addClass('down');},
				'mouseup': function() {this.removeClass('down');}
			});
			
			document.id('bottomPosition-wrapper').addEvents({
				'mouseenter': function() {
					var container = this.getElement('.mini-container');
					var pos = container.getCoordinates();
					tip.setStyles({
						'left': pos.left + pos.width + 5,
						'top': pos.top - 5
					});
					tip.set('html', updateTip(sliderbottomPosition));
					tip.fx.start('opacity', 1);
				},
				'mouseleave': function() {
					tip.fx.start('opacity', 0);
				}
			});
		});
		
		window.addEvent('domready', function() {
			
			var tip = createTip('positions-tip');
			document.id('paramsfooterPosition').addEvent('set', function(value) {
				var baseValue = value;
				var slider = window.sliderfooterPosition.RT;
				
				if (!value.contains('{')) value = serialize(value.replace(/\s/g, '').split(','));
				
				value = value.unserialize();

				if (!value[slider.gridSize]) return;
				else value = new Hash(value[slider.gridSize]);
				
				var arrayMulti = {};
				var arraySingle = {};
				
				value.each(function(wrapper_value, key) {
					arrayMulti[key] = [];
					arraySingle[key] = [];
					if (slider.type == 'custom') {
						arrayMulti[key] = {};
						arraySingle[key] = {};
						arrayMulti[key]['keys'] = [];
						arrayMulti[key]['values'] = [];
						arraySingle[key]['keys'] = [];
						arraySingle[key]['values'] = [];
					}
					
					$H(wrapper_value).each(function(inner_value, inner_key) {
						var val = inner_value.toString().dec2hex();
						if (slider.type != 'custom') {
							arrayMulti[key].push(val);
							arraySingle[key].push(val);
						} else {
							arrayMulti[key]['keys'].push(inner_key);
							arraySingle[key]['keys'].push(inner_key);
							arrayMulti[key]['values'].push(val);
							arraySingle[key]['values'].push(val);
						}

					});
					if (slider.type != 'custom') arraySingle[key] = [arraySingle[key].join('')];
					else arraySingle[key]['values'] = [arraySingle[key]['values'].join('')];
				});
				
				slider.defaults = $merge(slider.defaults, arraySingle);
				
				if (slider.type != 'custom') {
					var cur = arraySingle[slider.current];
					if (cur) {
						var current = slider.list[slider.current].indexOf(cur[0]) || 0;
						window.sliderfooterPosition.set(current);//.fireEvent('onComplete', [current, true]);
					}
				} else {
					var defaults = slider.defaults[slider.current];
					var keys = slider.keys[slider.current];
					var tests = [];
					
					keys.each(function(key, i) {
						if (key.compareArrays(defaults.keys)) tests.push(i);
					});

					var list = slider.list[slider.current];
					
					tests.each(function(test, j) {
						if (list[test] == defaults.values[0]) {
							sliderfooterPosition.set(test);//.fireEvent('onComplete', [test, true]);
						}
					});
				}
			 	this.set('value', baseValue);
			});
			window.sliderfooterPosition = new RokSlider(document.id('footerPosition').getElement('.position'), document.id('footerPosition').getElement('.knob'), {
				offset: 5,
				snap: true,
				initialize: function() {
					this.hiddenEl = document.id('paramsfooterPosition');
					this.RT = {};
					this.RT.current = $$('#footerPosition .list .active a')[0].getFirst().innerHTML.toInt();
					this.RT.list = {'1': ['c'],'2': ['2a', '39', '48', '57', '66', '75', '84', '93', 'a2'],'3': ['228', '237', '246', '255', '264', '273', '282', '327', '336', '345', '354', '363', '372', '426', '435', '444', '453', '462', '525', '534', '543', '552', '624', '633', '642', '723', '732', '822'],'4': ['2226', '2235', '2244', '2253', '2262', '2325', '2334', '2343', '2352', '2424', '2433', '2442', '2523', '2532', '2622', '3225', '3234', '3243', '3252', '3324', '3333', '3342', '3423', '3432', '3522', '4224', '4233', '4242', '4323', '4332', '4422', '5223', '5232', '5322', '6222'],'5': ['22224', '22233', '22242', '22323', '22332', '22422', '23223', '23232', '23322', '24222', '32223', '32232', '32322', '33222', '42222'],'6': ['222222']};
					this.RT.navigation = document.id('footerPosition').getElement('.list').getChildren();
					this.RT.blocks = document.id('footerPosition').getElements('.mini-grid');
					this.RT.settings = {};
					this.RT.gridSize = 12;
					this.RT.defaults = {3: ['444'], 1: ['c'], 2: ['66'], 4: ['3333'], 5: ['32223'], 6: ['222222']};
					this.RT.keyName = '' || '';
					this.RT.type = 'regular';
					this.RT.store = {};
					
					this.options.steps = this.RT.list[this.RT.current].length - 1;
					this.setOptions(this.options);

					var current = this.RT.current, navigation = this.RT.navigation, blocks = this.RT.blocks;
					var settings = this.RT.settings;
					navigation.each(function(nav, i) {
						settings[current] = [];
						nav.addEvent('click', function(event) {
							if (event) new Event(event).stop();
							navigation.removeClass('active');
							this.addClass('active');
							
							updateSlider(window.sliderfooterPosition, this.getFirst().getFirst().innerHTML.toInt());

							var value = sliderfooterPosition.RT.defaults[sliderfooterPosition.RT.current][0];
							if (sliderfooterPosition.RT.type == 'custom') {
								var defaults = sliderfooterPosition.RT.defaults[sliderfooterPosition.RT.current];
								var keys = sliderfooterPosition.RT.keys[sliderfooterPosition.RT.current];
								var tests = [];
								keys.each(function(key, i) {
									if (key.compareArrays(defaults.keys)) tests.push(i);
								});
								var list = sliderfooterPosition.RT.list[sliderfooterPosition.RT.current];
								
								tests.each(function(test, j) {
									if (list[test] == defaults.values[0]) {
										sliderfooterPosition.set(test);
									}
								});
								
							} else {
								sliderfooterPosition.set(sliderfooterPosition.RT.list[sliderfooterPosition.RT.current].indexOf(value));
							}
						});
					});
					updateBlocks(this, current);
				},
				
				onComplete: function(value, force) {
					this.knob.removeClass('down');
					var serialize = serializeSettings(this, new Hash(this.RT.settings));
					if (!force) document.id('paramsfooterPosition').set('value', serialize);
					var setting = '';
					var step = Math.round(this.step);
					for (i = 0, len = this.RT.current; i < len; i++) {
						setting += this.RT.list[this.RT.current][(isNaN(step) || step < 0) ? 0 : step].toString().charAt(i);
					}
					if (this.RT.type != 'custom') this.RT.defaults[this.RT.current] = [setting];
					else {
						this.RT.defaults[this.RT.current].values = [setting];
						var keys = [];
						for (i=0,l=this.RT.current;i<l;i++) {
							keys.push(this.RT.blocks[i].innerHTML);
						}
						this.RT.defaults[this.RT.current].keys = keys;
					}
					
					if (Gantry.MenuItemHead) {
						var cache = Gantry.MenuItemHead.Cache[Gantry.Selection];
						if (!cache) cache = new Hash({});
						
						cache.set('footerPosition', document.id('paramsfooterPosition').value);
					}
					
				},
				onDrag: function(now) {
					this.element.getFirst().setStyle('width', now + 10);
					var step = this.step;
					
					var layout = this.RT.list[this.RT.current][Math.round(step, 0)], output = '';
					if (!layout) return;
					
					layout = layout.toString();
					this.RT.settings[this.RT.current] = [];
					this.RT.store[this.RT.current] = [];
					for (i = 0, len = this.RT.current; i < len; i++) {
					    output += layout.charAt(i).hex2dec() + ((i == len - 1) ? '' : ' | ');
						
						if (this.RT.type == 'custom') {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
							this.RT.store[this.RT.current].push(this.RT.keys[this.RT.current][Math.round(step,0)][i]);
							
						} else {
							this.RT.settings[this.RT.current].push(layout.charAt(i));
						}
						if (this.RT.keys) {
							var keyIndex = this.RT.keys[this.RT.current][Math.round(step,0)][i];
							this.RT.blocks[i].set('text', keyIndex);
						}
					}
					tip.set('html', output);
					
					updateBlocks(window.sliderfooterPosition, this.RT.current, step);
				},
				onChange: function(position) {
					if(this.options.snap) position = this.toPosition(this.step);
					position = position || 0;
					this.knob.setStyle(this.property, position);
					this.fireEvent('onDrag', position);
				}
			});

			sliderfooterPosition.RT.navigation[3].fireEvent('click');
			
			document.id('footerPosition').getElement('.knob').addEvents({
				'mousedown': function() {this.addClass('down');},
				'mouseup': function() {this.removeClass('down');}
			});
			
			document.id('footerPosition-wrapper').addEvents({
				'mouseenter': function() {
					var container = this.getElement('.mini-container');
					var pos = container.getCoordinates();
					tip.setStyles({
						'left': pos.left + pos.width + 5,
						'top': pos.top - 5
					});
					tip.set('html', updateTip(sliderfooterPosition));
					tip.fx.start('opacity', 1);
				},
				'mouseleave': function() {
					tip.fx.start('opacity', 0);
				}
			});
		});
		