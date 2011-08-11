<?php
/**
 * NoNumber! Extension Manager Form View Template
 *
 * @package     NoNumber! Extension Manager
 * @version     2.4.7
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die();

// Import html tooltips
JHTML::_( 'behavior.mootools' );
JHTML::_( 'behavior.tooltip' );

$model =& $this->getModel();

$exts = array();
foreach( $model->extensions as $alias => $extension ) {
	if ( $alias != 'all' ) {
		$exts[] = "{ name: '".$extension->name."', id: '".$extension->id."', alias: '".$extension->alias."', types: '".$extension->type."' }";
	}
}

$config =& JComponentHelper::getParams( 'com_nonumbermanager' );
$check_data = $config->get( 'check_data', 1 );

require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'versions.php';

$document =& JFactory::getDocument();
$version = NoNumberVersions::getXMLVersion( null, null, null, 1 );
$document->addScript( JURI::root( true ).'/plugins/system/nonumberelements/js/script.js'.$version );
$version = NoNumberVersions::getXMLVersion( 'nonumbermanager', 'component', 1, 1 );
$document->addScript( JURI::root( true ).'/administrator/components/com_nonumbermanager/js/script.js'.$version );
$script = "
	var nn_extensions = [ ".implode( ', ', $exts )." ];

	window.addEvent( 'domready', function() {
		nnManager.load_extensions( ".$check_data." );
	});

	/* NoNumber! Extension Manager variable */
	var NNEM_NONESELECTED =			'".JText::_( 'NNEM_NO_ITEMS_SELECTED' )."';
	var NNEM_AREYOUSURE =			'".JText::_( 'NNEM_ARE_YOU_SURE' )."';
	var NNEM_UPTODATE =				'".JText::_( 'NNEM_ALREADY_UPTODATE' )."';
	var NNEM_DOWNGRADE =			'".JText::_( 'NNEM_DOWNGRADE' )."';
	var NNEM_INSTALLING =			'".JText::_( 'NNEM_INSTALLING' )."';
	var NNEM_UPDATING =				'".JText::_( 'NNEM_UPDATING' )."';
	var NNEM_REINSTALLING =			'".JText::_( 'NNEM_REINSTALLING' )."';
	var NNEM_DOWNGRADING =			'".JText::_( 'NNEM_DOWNGRADING' )."';
	var NNEM_MAYTAKEAWHILE =		'".JText::_( 'NNEM_MAY_TAKE_A_WHILE' )."';
	var NNEM_EXTENSIONSINSTALLED =	'".JText::_( 'NNEM_EXTENSIONS_INSTALLED' )."';
	var NNEM_CLEANCACHE =			'".JText::_( 'NNEM_CLEAN_CACHE' )."';
	var NNEM_EXTENSIONSUPDATED =	'".JText::_( 'NNEM_EXTENSIONS_UPDATED' )."';
	var NNEM_INSTALLATIONFAILED =	'".JText::_( 'NNEM_INSTALLATION_FAILED' )."';
	var NNEM_CHANGELOG =			'".JText::_( 'NNEM_CHANGELOG' )."';
	var NNEM_TOKEN =				'".JUtility::getToken()."';
";
if ( $config->get( 'use_proxy', 0 ) && $config->get( 'proxy_host' ) ) {
	$script .= "	var NNEM_QUERY = 'url_options[CURLOPT_PROXY]='+escape( '".$config->get( 'proxy_host' )."' )+':'+escape( '".$config->get( 'proxy_port' )."' )"
		."+'&url_options[CURLOPT_PROXYUSERPWD]='+escape( '".$config->get( 'proxy_login' )."' )+':'+escape( '".$config->get( 'proxy_password' )."' )"
		."+'&url_options[CURLOPT_TIMEOUT]=30';";
} else {
	$script .= "	var NNEM_QUERY = '';";
}
$document->addScriptDeclaration( '	'.trim( $script ) );

echo html_entity_decode( JText::_( 'NNEM_EXTENSION_MANAGEMENT_DESC' ), ENT_COMPAT, 'UTF-8' );
?>
<p></p>
<form action="<?php echo JRoute::_( $this->request_url ) ?>" method="post" name="adminForm" id="adminForm">
	<table id="nonumbermanager_table" class="adminlist nonumbermanager<?php if ( $config->get( 'hide_notinstalled', 0 ) ) { echo ' hidenotinstalled'; } ?>">
		<thead>
			<?php
				$this->outputCodeRow( $config, $model->extensions['all'], $model->_host, count( $model->extensions )-1 );
			?>
			<tr>
				<th width="20">&nbsp;</th>
				<th width="20">&nbsp;</th>
				<th width="50" style="text-align:left;"><?php echo JText::_( 'NNEM_EXTENSION' ); ?></th>
				<th width="20" style="text-align:left;"><?php echo JText::_( 'NNEM_TYPE' ); ?></th>
				<th width="20">&nbsp;</th>
				<th width="20">&nbsp;</th>
				<th width="50"><?php echo JText::_( 'Version' ); ?></th>
				<th width="50" style="text-align:left;" nowrap="nowrap"><?php echo JText::_( 'NNEM_INSTALL_UPDATE' ); ?></th>
				<th width="1" nowrap="nowrap"><span id="nonumbermanager_langs_title" style="display:none;"><?php echo JText::_( 'NNEM_INSTALL_LANGUAGES' ); ?></span></th>
				<th style="text-align:left;"><?php echo JText::_( 'NNEM_COMMENT' ); ?></th>
				<th width="100" style="text-align:left;"><?php echo JText::_( 'NNEM_LICENSE_CODE' ); ?></th>
				<th width="20">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i = 0;
				$this->outputCodeRow( $config, $model->extensions['nonumbermanager'], $model->_host, $i++ );
				foreach( $model->extensions as $alias => $extension ) {
					if ( $alias != 'all' && $alias != 'nonumbermanager' ) {
						$this->outputCodeRow( $config, $extension, $model->_host, $i++ );
					}
				}
			?>
		</tbody>
	</table>
	<input type="hidden" id="license_host" value="<?php echo $model->_host; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>
<?php
	$xml = JApplicationHelper::parseXMLInstallFile( JPATH_SITE.str_replace( '/', DS, '/plugins/system/nonumberelements.xml' ) );
	if ( $xml && isset( $xml['version'] ) ) {
		echo '<p style="color:#999999;">'.JText::_( 'NONUMBER_ELEMENTS' ).': v.'.$xml['version'].'</p>';
	}