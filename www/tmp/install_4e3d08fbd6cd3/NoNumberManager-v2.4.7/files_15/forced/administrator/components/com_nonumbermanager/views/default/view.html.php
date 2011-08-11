<?php
/**
 * NoNumber! Extension Manager View
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

// Import VIEW object class
jimport( 'joomla.application.component.view' );

/**
 * NoNumber! Extension Manager View
 */
class NoNumberManagerViewDefault extends JView
{
	var $request_url = null;
	var $data = null;

	/**
	 * Display the view
	 */
	function display( $tpl = null )
	{
		$uri =& JFactory::getURI();
		$this->request_url =$uri->toString();

		$model =& $this->getModel();
		$model->getData();

		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'versions.php';

		// set document title
		$document =& JFactory::getDocument();
		$version = NoNumberVersions::getXMLVersion( null, null, null, 1 );
		$document->addStyleSheet( JURI::root( true ).'/plugins/system/nonumberelements/css/style.css'.$version );
		$version = NoNumberVersions::getXMLVersion( 'nonumbermanager', 'component', 1, 1 );
		$document->addStyleSheet( JURI::root( true ).'/administrator/components/com_nonumbermanager/css/nonumbermanager.css'.$version );
		$document->setTitle( JText::_( 'NONUMBER_EXTENSION_MANAGER' ) );

		JToolBarHelper::title( JText::_( 'NNEM_EXTENSION_MANAGEMENT' ), 'nonumbermanager' );
		JToolBarHelper::preferences( 'com_nonumbermanager', '360' );

		parent::display( $tpl );
	}

	/**
	 * Get the data (should be in model really)
	 */
	function getData()
	{
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__nonumber_licenses";
		$db->setQuery( $sql );
		return $db->loadObjectList( 'extension' );
	}

	/**
	 * Get the html for a table row (extension name + code)
	 */
	function outputCodeRow( &$config, $extension, $host, $i = 0 )
	{
		$id = $extension->id;
?>
	<?php if ( $id == 'all' ) { ?>
		<tr id="row_<?php echo $id; ?>" style="background-color: #FFFFFF;">
			<td nowrap="nowrap">
				<input type="checkbox" name="toggle" id="check_toggle" value="" onclick="checkAll(<?php echo $i; ?>);" />
			</td>
			<td nowrap="nowrap" colspan="6">
				<div id="link_checkdata" class="hasTip" title=" ::<?php echo JText::_( 'NNEM_REFRESH_DESC' ); ?>">
					<div id="link_checkdata_ready" class="button2-left nonumbermanager_button"><div class="blank nonumbermanager_checkcheckdata"><a href="javascript://" onclick="nnManager.load_extensions( 1 );"><?php echo JText::_( 'NNEM_CHECK_DATA' ); ?></a></div></div>
				</div>
				<div id="link_toggle_notinstalled" style="display:none;">
					<div id="link_hide_notinstalled" class="button2-left" <?php if ( $config->get( 'hide_notinstalled', 0 ) ) { echo 'style="display:none;"'; } ?>><div class="blank"><a href="javascript://" onclick="nnManager.hide_notinstalled();"><?php echo JText::_( 'NNEM_HIDE_NOTINSTALLED' ); ?></a></div></div>
					<div id="link_show_notinstalled" class="button2-left" <?php if ( !$config->get( 'hide_notinstalled', 0 ) ) { echo 'style="display:none;"'; } ?>><div class="blank"><a href="javascript://" onclick="nnManager.show_notinstalled();"><?php echo JText::_( 'NNEM_SHOW_NOTINSTALLED' ); ?></a></div></div>
				</div>
			</td>
			<td nowrap="nowrap" colspan="3">
				<div id="link_installall" class="link_all">
					<div id="link_installall_loading" class="button2-left link_loading nonumbermanager_button nonumbermanager_ghosted"><div class="blank nonumbermanager_installall"><a href="javascript://"><?php echo JText::_( 'NNEM_INSTALL_ALL' ); ?></a></div></div>
					<div id="link_installall_ready" class="button2-left link_ready nonumbermanager_button" style="display:none;" class="hasTip" title="<?php echo JText::_( 'NNEM_THIS_WILL_INSTALL_ALL_EXTENSIONS_THAT_ARE_NOT_ALREADY_INSTALLED' ); ?>"><div class="blank nonumbermanager_installall"><a href="javascript://" onclick="nnManager.install_extensions( 'install' );"><?php echo JText::_( 'NNEM_INSTALL_ALL' ); ?></a></div></div>
				</div>
				<div id="link_updateall" class="link_all">
					<div id="link_updateall_loading" class="button2-left link_loading nonumbermanager_button nonumbermanager_ghosted"><div class="blank nonumbermanager_updateall"><a href="javascript://"><?php echo JText::_( 'NNEM_UPDATE_ALL' ); ?></a></div></div>
					<div id="link_updateall_ready" class="button2-left link_ready nonumbermanager_button" style="display:none;" class="hasTip" title="<?php echo JText::_( 'NNEM_THIS_WILL_UPDATE_ALL_EXTENSIONS_THAT_ARE_NOT_UPTODATE' ); ?>"><div class="blank nonumbermanager_updateall"><a href="javascript://" onclick="nnManager.install_extensions( 'update' );"><?php echo JText::_( 'NNEM_UPDATE_ALL' ); ?></a></div></div>
				</div>
				<div id="link_installselected" class="link_all">
					<div id="link_installselected_loading" class="button2-left link_loading nonumbermanager_button nonumbermanager_ghosted"><div class="blank nonumbermanager_installselected"><a href="javascript://"><?php echo JText::_( 'NNEM_INSTALL_SELECTED' ); ?></a></div></div>
					<div id="link_installselected_ready" class="button2-left link_ready nonumbermanager_button" style="display:none;" class="hasTip" title="<?php echo JText::_( 'NNEM_THIS_WILL_INSTALL_UPDATE_ALL_SELECTED_EXTENSIONS' ); ?>"><div class="blank nonumbermanager_installselected"><a href="javascript://" onclick="nnManager.install_selected();"><?php echo JText::_( 'NNEM_INSTALL_SELECTED' ); ?></a></div></div>
				</div>
			</td>
	<?php } else { ?>
		<tr id="row_<?php echo $id; ?>">
			<td nowrap="nowrap">
				<div id="check_<?php echo $id; ?>_loading" class="check external_<?php echo $id; ?>_loading" style="display:none;"><img src="<?php echo JURI::base(); ?>components/com_nonumbermanager/images/loading.gif" alt="" width="16" height="16" /></div>
				<div id="check_<?php echo $id; ?>" class="check external_<?php echo $id; ?>_result" style="display:none;">
					<input class="check_checkbox" type="checkbox" id="cb<?php echo $i; ?>" name="cid[]" value="" onclick="isChecked(this.checked);" />
				</div>
			</td>
			<td nowrap="nowrap">
				<span class="hasTip" title=" ::<?php echo JText::_( 'NNEM_REFRESH_DESC' ); ?>">
					<a href="javascript://" onclick="nnManager.load_extension( '<?php echo $id; ?>', '<?php echo $extension->alias; ?>', '<?php echo $extension->type; ?>' )">
						<img src="<?php echo JURI::base(); ?>components/com_nonumbermanager/images/refresh.png" alt="<?php echo JText::_( 'NNEM_REFRESH' ); ?>" width="16" height="16" />
					</a>
				</span>
			</td>
			<td nowrap="nowrap">
				<a href="http://www.nonumber.nl/<?php echo $id; ?>" target="_blank" style="text-decoration: none;">
					<span class="hasTip" title="<?php echo JText::_( 'DESCRIPTION' ).'::'.JText::_( $extension->name.'_DESC' ); ?>">
						<img src="<?php echo JURI::base(); ?>components/com_nonumbermanager/images/icons/<?php echo $id; ?>.png" alt="" width="16" height="16" /> <?php echo JText::_( $extension->name ); ?>
					</span>
					<span class="hasTip" title=" ::<?php echo JText::_( 'NNEM_WEBSITE' ); ?>">
						<img src="<?php echo JURI::base(); ?>components/com_nonumbermanager/images/link.png" alt="" width="16" height="16" />
					</span>
				</a>
			</td>
			<td nowrap="nowrap">
			<?php
				foreach( $extension->types as $type ) {
					$tip = JText::_( 'NN_'.strtoupper( $type->type ) );
					$icon = '<img src="'.JURI::base().'components/com_nonumbermanager/images/ext_'.$type->type.'.png" alt="'.$tip.'" style="margin:0 1px;" width="16" height="16" />';
					if ( $type->link ) {
						$icon = '<a href="index.php?'.$type->link.'" target="_blank">'.$icon.'</a>';
						$tip .= '::'.JText::_( 'NNEM_GO_TO_EXTENSION' );
					} else {
						$tip = ' ::'.$tip;
					}
					echo '<label class="hasTip" title="'.$tip.'">'.$icon.'</label>';
				}
			?>
			</td>
			<td nowrap="nowrap" style="text-align:center">
				<span class="hasTip" title=" ::<?php echo JText::_( 'NNEM_DOWNLOAD' ); ?>">
					<a href="http://www.nonumber.nl/<?php echo $id; ?>/download" target="_blank">
						<img src="<?php echo JURI::base(); ?>components/com_nonumbermanager/images/download.png" alt="<?php echo JText::_( 'NNEM_DOWNLOAD' ); ?>" width="16" height="16" />
					</a>
				</span>
			</td>
			<td nowrap="nowrap" style="text-align:center">
			<?php
				echo $this->getDiv( $extension, 'changelog', 'external', 'loading' );
				echo $this->getDiv( $extension, 'changelog', 'external', 'success', '', 'changelog' );
				echo $this->getDiv( $extension, 'changelog', 'external', 'failed' );
			?>
			</td>
			<td nowrap="nowrap" style="text-align:center">
			<?php
				echo $this->getDiv( $extension, 'version', 'local', 'loading' );
				echo $this->getDiv( $extension, 'version', 'local', 'version' );
				echo $this->getDiv( $extension, 'version', 'local', 'failed' );
			?>
			</td>
			<td nowrap="nowrap">
			<?php
				echo $this->getDiv( $extension, 'version_state', 'external', 'check', '<div class="hasTip" title=" ::'.JText::_( 'NNEM_REFRESH_DESC' ).'"><div class="button2-left nonumbermanager_button"><div class="blank nonumbermanager_checkcheckdata"><a href="javascript://" onclick="nnManager.load_extension( \''.$id.'\', \''.$extension->alias.'\', \''.$extension->type.'\' );">'.JText::_( 'NNEM_CHECK_DATA' ).'</a></div></div></div>', '', 'display:block;' );
				echo $this->getDiv( $extension, 'version_button', 'external', 'loading' );
				echo $this->getDiv( $extension, 'version_button', 'external', 'update', '<div class="button2-left nonumbermanager_button"><div class="blank nonumbermanager_update"><a href="javascript://">'.JText::_( 'NNEM_UPDATE_TO_NEW_VERSION' ).' <strong class="new_version_number"></strong></a></div></div>' );
				echo $this->getDiv( $extension, 'version_button', 'external', 'install', '<div class="button2-left nonumbermanager_button"><div class="blank nonumbermanager_install"><a href="javascript://">'.JText::_( 'NNEM_INSTALL_NEW_VERSION' ).' <strong class="new_version_number"></strong></a></div></div>' );
				echo $this->getDiv( $extension, 'version_button', 'external', 'uptodate', '<a href="javascript://">'.JText::_( 'NNEM_REINSTALL_NEW_VERSION' ).' <strong class="new_version_number"></strong></a>' );
				echo $this->getDiv( $extension, 'version_button', 'external', 'downgrade', '<a href="javascript://">'.JText::_( 'NNEM_DOWNGRADE_TO_STABLE_VERSION' ).' <strong class="new_version_number"></strong></a>' );
				echo $this->getDiv( $extension, 'version_button', 'external', 'failed', '<div class="hasTip" title=" ::'.JText::_( 'NNEM_REFRESH_DESC' ).'"><div class="button2-left nonumbermanager_button"><div class="blank nonumbermanager_checkcheckdata"><a href="javascript://" onclick="nnManager.load_extension( \''.$id.'\', \''.$extension->alias.'\', \''.$extension->type.'\' );">'.JText::_( 'NNEM_CHECK_DATA' ).'</a></div></div></div>' );
			?>
			</td>
			<td nowrap="nowrap">
			<?php
				echo $this->getDiv( $extension, 'version_button', 'external', 'langs', '', '', 'float:left;padding-top:2px;' );
			?>
			</td>
			<td>
			<?php
				echo $this->getDiv( $extension, 'version_state', 'local,external', 'loading' );
				echo $this->getDiv( $extension, 'version_state', 'local,external', 'update', JText::_( 'NNEM_NEW_VERSION_AVAILABLE' ), 'note', 'color:#990000;' );
				echo $this->getDiv( $extension, 'version_state', 'local,external', 'install', JText::_( 'NNEM_NOT_INSTALLED' ) );
				echo $this->getDiv( $extension, 'version_state', 'local,external', 'uptodate', JText::_( 'NNEM_VERSION_IS_UPTODATE' ), 'yes', 'color:#006600;' );
				echo $this->getDiv( $extension, 'version_state', 'local,external', 'downgrade', JText::_( 'NNEM_VERSION_IS_UPTODATE' ), 'yes', 'color:#006600;' );
				echo $this->getDiv( $extension, 'version_state', 'local', 'incomplete', JText::sprintf( 'NNEM_MISSING_EXTENSIONS',
						' <span class="missing_extension missing_com"> &bull; '.JText::_( 'NN_COM' ).'</span>'
						.'<span class="missing_extension missing_mod"> &bull; '.JText::_( 'NN_MOD' ).'</span>'
						.'<span class="missing_extension missing_plg_system"> &bull; '.JText::_( 'NN_PLG_SYSTEM' ).'</span>'
						.'<span class="missing_extension missing_plg_editors-xtd"> &bull; '.JText::_( 'NN_PLG_EDITORS-XTD' ).'</span>'
					), 'note', 'color:#990000;' );
				echo $this->getDiv( $extension, 'version_state', 'local,external', 'failed', JText::_( 'NNEM_COULD_NOT_CHECK_VERSION' ), 'no', 'color:#999999;' );
			?>
			</td>
	<?php } ?>
			<td nowrap="nowrap" class="license_field_<?php echo $id; ?>">
			<?php
				if ( $id != 'nonumbermanager' ) {
					echo $this->getDiv( $extension, 'license_field', 'license', 'loading' );
					echo $this->getDiv( $extension, 'license_field', 'license', 'field',
						'<input class="license_code" id="license_code_'.$id.'" type="text" name="codes['.$id.']" value="'.$extension->code.'" onchange="this.style.color=\'#666666\';" style="width:100px;font-family:monospace;font-size:1.2em;color:#666666;" />'
						.'<span class="hasTip" title=" ::'.JText::_( 'NNEM_SAVE_CODE' ).'"><a href="javascript://" onclick="nnManager.save_license( \''.$id.'\' )"><img src="'.JURI::base().'components/com_nonumbermanager/images/save.png" alt="'.JText::_( 'Save' ).'" width="16" height="16" /></a></span>',
						'', 'white-space:nowrap;' );
					echo $this->getDiv( $extension, 'license_field', 'license', 'allvalid',
						'<input class="license_code" id="license_code_'.$id.'_allvalid" type="text" readonly="readonly" value="" style="width:100px;font-family:monospace;font-size:1.2em;background-color:#CCEECC;color:#99AA99;font-style:italic;" onfocus="this.blur()" />'
						, '', 'white-space:nowrap;' );
				}
			?>
			</td>
			<td nowrap="nowrap" class="license_state_<?php echo $id; ?>">
			<?php
				if ( $id != 'nonumbermanager' ) {
					// loading
					echo $this->getDiv( $extension, 'license_state', 'license', 'loading' );
					// local
					echo $this->getIcon( $extension, 'local', 'note', JText::_( 'NNEM_THE_CODE_CANNOT_BE_CHECKED' ) );
					if ( $host != 'localhost' ) {
						// all valid
						echo $this->getIcon( $extension, 'allvalid', 'yes', JText::sprintf( 'NNEM_THE_CODE_IS_VALID', $host ) );
						// valid
						echo $this->getIcon( $extension, 'valid', 'yes', JText::sprintf( 'NNEM_THE_CODE_IS_VALID', $host ) );
						// not valid
						echo $this->getIcon( $extension, 'invalid', 'no', JText::sprintf( 'NNEM_THE_CODE_IS_NOT_VALID', $host ) );
						// fail
						echo $this->getIcon( $extension, 'failed', 'note', JText::_( 'NNEM_RETRY' ) );
					}
				}
			?>
			</td>
		</tr>
<?php
	}
	function getDiv( $extension, $type, $groups, $state, $html = '', $icon = '', $styling = '' ) {
		$id = $extension->id;
		if ( $icon ) {
			$html = '<span><a href="http://www.nonumber.nl/'.$id.'" target="_blank"><img src="'.JURI::base().'components/com_nonumbermanager/images/'.$icon.'.png" alt="" width="16" height="16" /></a></span> '.$html;
		}
		if ( $state == 'loading' ) {
			$html .= ' <img src="'.JURI::base().'components/com_nonumbermanager/images/loading.gif" alt="" width="16" height="16" />';
		} else if ( !$html && $state == 'failed' ) {
			$html .= ' <span class="hasTip" title=" ::'.JText::_( 'NNEM_RETRY' ).'"><a href="javascript://" onclick="nnManager.load_extension( \''.$id.'\', \''.$extension->alias.'\', \''.$extension->type.'\' )"><img src="'.JURI::base().'components/com_nonumbermanager/images/refresh.png" alt="'.JText::_( 'NNEM_RETRY' ).'" width="16" height="16" /></a></span>';
		}

		$class = $type
				.' '.$type.'_'.$id.'_'.( $state == 'loading' ? 'loading' : 'result' )
				.( ( $state == 'failed' ) ? ' '.$type.'_'.$id.'_failed' : '' );
		foreach( explode( ',', $groups ) as $group ) {
			$class .= ' '.$group.'_'.( $state == 'loading' ? 'loading' : 'result' )
				.' '.$group.'_'.$id.'_'.( $state == 'loading' ? 'loading' : 'result' )
				.( ( $state == 'failed' ) ? ' '.$group.'_'.$id.'_failed' : '' );
		}
		$html = '<div id="'.$type.'_'.$id.'_'.$state.'" class="'.$class.'" style="display:none;'.$styling.'">'.trim( $html ).'</div>';
		return $html;
	}

	function getIcon( $extension, $state = '', $icon = 'note', $text = '' ) {
		$group = 'license';
		$type = 'license_state';
		$id = $extension->id;

		$extra = '';
		if ( $state == 'failed' ) {
			$extra = 'onmouseover="this.src=\''.JURI::base().'components/com_nonumbermanager/images/refresh.png\';" onmouseout="this.src=\''.JURI::base().'components/com_nonumbermanager/images/'.$icon.'\';"';
		}
		$html = '<img src="'.JURI::base().'components/com_nonumbermanager/images/'.$icon.'.png" alt="" '.$extra.' width="16" height="16" />';
		if ( $state == 'failed' ) {
			$html = '<a href="javascript://" onclick="nnManager.load_license( \''.$id.'\' );"></a>';
		}
		if ( $text ) {
			$html = '<span class="hasTip" title=" ::'.$text.'">'.$html .'</span>';
		}

		$html = '<div id="'.$type.'_'.$id.'_'.$state.'"'
			.' class="'
				.$type
				.' '.$group.'_'.( $state == 'loading' ? 'loading' : 'result' )
				.' '.$group.'_'.$id.'_'.( $state == 'loading' ? 'loading' : 'result' )
				.( ( $state == 'failed' ) ? ' '.$group.'_'.$id.'_failed' : '' )
				.' '.$type.'_'.$id.'_'.( $state == 'loading' ? 'loading' : 'result' )
				.( ( $state == 'failed' ) ? ' '.$type.'_'.$id.'_failed' : '' )
			.'" style="display:none;">'.trim( $html ).'</div>';
		return $html;
	}
}