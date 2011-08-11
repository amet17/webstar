<?php
// no direct access
defined('_JEXEC') or die ('Restricted access');

jimport('joomla.plugin.plugin');
JLoader::register('K2Parameter', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'lib'.DS.'k2parameter.php');

/**
 *K2 Plugin to search and display objects on Yandex Maps
 */

class plgK2k2ymap extends JPlugin {

	// Some params
	var $pluginName = 'k2ymap';
	var $pluginGroupDesc = 'Parametry mapy';
	var $count = 1;

	function plgK2k2ymap( & $subject, $params){
		parent::__construct($subject, $params);
	}

	function showYandexMap( &$object, $type ){
   ++$count;
   $output = '';
   if (!defined('yMap')) {
      define("yMap", 1, true);

		$plugin = & JPluginHelper::getPlugin('k2', 'k2ymap');
		$pluginParams = new JParameter($plugin->params);
		$plugins = new K2Parameter($object->plugins,null,$this->pluginName);

		$document =& JFactory::getDocument();
      //Here is taken extrafield	value to search in Yandex Maps
			foreach ($object->extra_fields as $key=>$extraField){
							if ($extraField->name == $pluginParams->get('extraFieldName')) {
										$search_value = $extraField->value;
									}
						 }	
						 				 
		if ($search_value != '') {
				$bContent='<div style="width:50px; height:auto; text-align:left; overflow:hidden;">'.$search_value.'</div>';		 
				$output = '
				<script src="http://api-maps.yandex.ru/1.1/index.xml?key='.$pluginParams->get('apikey').'" type="text/javascript"></script>
<script type="text/javascript">
				//<![CDATA[
        // Создание обработчика для события window.onLoad
        YMaps.jQuery(function () {
                // Создание экземпляра карты и его привязка к созданному контейнеру
            var map = new YMaps.Map(YMaps.jQuery("#'.$pluginParams->get('ymapdivid').$count.'")[0]),
                
                // Результат поиска
                geoResult;				
			YMaps.jQuery(document).ready(function(){
             // Запускаем поиск
                var geocoder = new YMaps.Geocoder("'.$search_value.'", { 
                    prefLang : "ru"
                } );

                var listenerLoad = YMaps.Events.observe(geocoder, geocoder.Events.Load, function (geocoder) {
                    // Если результа геокодирования был добавлен на карту, то удалим его
                    if (geoResult) {
                        map.removeOverlay(geoResult);
                    }
                    if (geocoder.length()) {
                        // Отображаем первый релевантный результат геокодирования
                        geoResult = geocoder.get(0);
                        map.addOverlay(geoResult);
                        geoResult.openBalloon();
												//map.geoResult.BalloonStyle({style: "default#buildingsIcon"});
												//{style: "default#buildingsIcon"}
												//geoResult.Balloon.setContent("<div style="width:30px; height:30px;">sddf</div>");
                        // Центрируем карту по найденному объекту
                        map.setBounds(geoResult.getBounds());
                    } else {
                        alert("Не удалось найти объект.");
                    }

                    listenerLoad.cleanup();
                });
            });

        })
				//]]>
</script>
<div id="'.$pluginParams->get('ymapdivid').$count.'" style="'.$pluginParams->get('ymapdivstyle').'"></div>
';		
		} else { $output = ''; } 
	
      }
		return $output;
	}


	/**
	* Below we list all available FRONTEND events, to trigger K2 plugins.
	* Watch the different prefix "onK2" instead of just "on" as used in Joomla! already.
	* Most functions are empty to showcase what is available to trigger and output. A few are used to actually output some code for example reasons.
	*/
	
	function onK2PrepareContent( &$item, &$params, $limitstart ){
		return;
	}
	
	function onK2AfterDisplay( &$item, &$params, $limitstart ){
		return;
	}
	
	function onK2BeforeDisplay( &$item, &$params, $limitstart ){
		return;
	}
	
	function onK2AfterDisplayTitle( &$item, &$params, $limitstart ){
		return;
	}
	
	function onK2BeforeDisplayContent( &$item, &$params, $limitstart ){
		return;
	}
	
	// Event to display in the frontend the Yandex Map with item marker as entered in the item form
	function onK2AfterDisplayContent( & $item, & $params, $limitstart){
	  return $this->showYandexMap( $item, 'item' );
	}

// Event to display in the frontend the Yandex Map with category marker as entered in the category form
	function onK2CategoryDisplay( &$category, &$params, $limitstart ){
		return $this->showYandexMap( $category, 'category' );
	}
	
	// Event to display in the frontend the Yandex Map with user marker as entered in the user form
	function onK2UserDisplay( &$user, &$params, $limitstart ){
		return $this->showYandexMap( $user, 'user' );
	}

	// Function to render plugin parameters in the backend - no need to change anything
	function onRenderAdminForm( & $item, $type, $tab='') {
		global $mainframe;
		$form = new K2Parameter($item->plugins, JPATH_SITE.DS.'plugins'.DS.'k2'.DS.$this->pluginName.'.xml', $this->pluginName);
		if ( !empty ($tab)) {
			$path = $type.'-'.$tab;
		}
		else {
			$path = $type;
		}
		$fields = $form->render('plugins', $path);
		if ($fields){
			$plugin = new JObject;
			$plugin->set('name', JText::_( 'Map parameters' ));
			$plugin->set('fields', $fields);
			return $plugin;
		}
	}

	// This function ONLY for compatibility with K2 Usert system plugin - it use this function instead onRenderAdminForm
	function onRenderUserForm( & $user) {
		global $mainframe;
		$form = new K2Parameter($user->plugins, JPATH_SITE.DS.'plugins'.DS.'k2'.DS.$this->pluginName.'.xml', $this->pluginName);
		$fields = $form->render('plugins', 'user');
		$plugin = new JObject;
		$plugin->set('name', $this->pluginNameHumanReadable);
		$plugin->set('fields', $fields);
		return $plugin;
	}
}	