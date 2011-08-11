<?php
/**
 * @package     Advanced Module Manager
 * @version     1.19.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

/**
 * BASE ON JOOMLA CORE FILE:
 * /administrator/components/com_modules/admin.modules.html.php
 */

/**
* @version		$Id: admin.modules.html.php 11672 2009-03-08 20:39:41Z willebil $
* @package		Joomla
* @subpackage	Modules
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die();

require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'parameters.php';

/**
* @package		Joomla
* @subpackage	Modules
*/
class HTML_modules
{
	/**
	* Writes a list of the defined modules
	* @param array An array of category objects
	*/
	function view( &$rows, &$client, &$page, &$lists )
	{
		$user =& JFactory::getUser();

		//Ordering allowed ?
		$ordering = ( $lists['order'] == 'm.ordering' || $lists['order'] == 'm.position' );

		JHTML::_( 'behavior.tooltip' );

		$parameters =& NNParameters::getParameters();
		$config = JComponentHelper::getParams( 'com_advancedmodules' );
		$config = $parameters->getParams( $config->_raw, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_advancedmodules'.DS.'config.xml' );

		if ( $config->open_in_modals ) {
			JHTML::_( 'behavior.modal' );
		}

		if ( $config->show_configmsg ) {
			echo '<p>'.html_entity_decode( JText::_( 'AMM_CONFIG_MESSAGE', ENT_COMPAT, 'UTF-8' ) ).'</p>';
		}
		?>
		<form action="<?php echo JRoute::_( 'index.php?option=com_advancedmodules'); ?>" method="post" target="" name="adminForm">
			<input type="hidden" name="option" value="com_advancedmodules" />
			<input type="hidden" name="client" value="<?php echo $client->id; ?>" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
			<?php echo JHTML::_( 'form.token' ); ?>

			<div style="float:left;padding:0 2px;">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $lists['search']; ?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById( 'search' ).value='';
					document.getElementById( 'filter_state' ).value='';
					document.getElementById( 'filter_type' ).value='0';
					document.getElementById( 'filter_position' ).value='0';
					document.getElementById( 'filter_template' ).value='0';
					<?php if ( $client->id != 1 ) : ?>
					document.getElementById( 'filter_access' ).value='';
					document.getElementById( 'filter_menuitems' ).value='';
					<?php endif; ?>
					this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</div>
			<div style="float:right;padding:0 2px;">
				<?php
					echo $lists['state'];
					echo $lists['type'];
					echo $lists['position'];
					echo $lists['template'];
					if ( $client->id != 1 ) {
						echo $lists['access'];
						echo '<span class="hasTip" title="'.JText::_( 'AMM_SELECT_MENU_ITEM_ASSIGNMENT' ).'::'.JText::_( 'AMM_SELECT_MENU_ITEM_ASSIGNMENT_DESC' ).'">'
							.$lists['menuitems']
							.'</span>';
					}
				?>
			</div>
			<div style="clear:both;"></div>
			<table class="adminlist" cellspacing="1">
				<thead>
					<tr>
						<th width="20">
							<?php echo JText::_( 'NUM' ); ?>
						</th>
						<th width="20">
							<input type="checkbox" name="toggle" value="" onclick="checkAll( <?php echo count( $rows ); ?> );" />
						</th>
					<?php if ( $client->id != 1 && $config->show_color ) : ?>
						<th width="16">
							<?php echo JHTML::_('grid.sort', '<img src="'.JURI::base(true).'/components/com_advancedmodules/images/color.png" alt="Color" />', 'color', @$lists['order_Dir'], @$lists['order'] ); ?>
						</th>
					<?php endif; ?>
						<th class="title" style="text-align:left;">
							<?php echo JHTML::_('grid.sort', 'Module Name', 'm.title', @$lists['order_Dir'], @$lists['order'] ); ?>
						</th>
					<?php if ( $client->id != 1 && $config->show_tooltip == 3 ) : ?>
					<th style="text-align:left;">
						<?php echo JText::_( 'Description' ); ?>
					</th>
					<?php endif; ?>
						<th nowrap="nowrap" width="1%">
							<?php echo JHTML::_('grid.sort', 'Published', 'm.published', @$lists['order_Dir'], @$lists['order'] ); ?>
						</th>
						<th width="80" nowrap="nowrap">
							<?php echo JHTML::_('grid.sort', 'Order', 'm.ordering', @$lists['order_Dir'], @$lists['order'] ); ?>
						</th>
						<th width="1%">
							<?php if ( $ordering ) echo JHTML::_('grid.order',  $rows ); ?>
						</th>
					<?php if ( $client->id != 1 ) : ?>
						<th nowrap="nowrap" width="1%" style="text-align:left;">
							<?php echo JHTML::_('grid.sort', 'AMM_MENU_ITEMS', 'mm.menuid', @$lists['order_Dir'], @$lists['order'] ); ?>
						</th>
						<th nowrap="nowrap" width="1%">
							<?php echo JHTML::_('grid.sort', 'Access', 'groupname', @$lists['order_Dir'], @$lists['order'] ); ?>
						</th>
					<?php endif; ?>
						<th nowrap="nowrap" width="1%">
							<?php echo JHTML::_('grid.sort', 'Position', 'm.position', @$lists['order_Dir'], @$lists['order'] ); ?>
						</th>
						<th nowrap="nowrap" width="10%" class="title" style="text-align:left;">
							<?php echo JHTML::_('grid.sort', 'Type', 'm.module', @$lists['order_Dir'], @$lists['order'] ); ?>
						</th>
						<th nowrap="nowrap" width="1%" style="text-align:left;">
							<?php echo JHTML::_('grid.sort', 'ID', 'm.id', @$lists['order_Dir'], @$lists['order'] ); ?>
						</th>
					</tr>
				</thead>
				<?php
					$cols = 9;
					if ( $client->id != 1 ) {
						$cols = $cols+2;
						if ( $config->show_color ) { $cols++; }
						if ( $config->show_tooltip == 3 ) { $cols++; }
					}
				?>
				<tfoot>
					<tr>
						<td colspan="<?php echo $cols; ?>">
							<?php echo $page->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
				<tbody>
				<?php
				$parameters =& NNParameters::getParameters();

				$k = 0;
				for ( $i=0, $n=count( $rows ); $i < $n; $i++ ) {
					$row 	=& $rows[$i];

					$url = JRoute::_( 'index.php?option=com_advancedmodules&client='. $client->id .'&task=edit&cid[]='. $row->id );

					$tooltip = JText::_( 'AMM_EDIT_MODULE' ).'::'.htmlspecialchars( $row->title );
					$advanced_params = $parameters->getParams( $row->adv_params );
					if ( $config->show_tooltip == 1 && isset( $advanced_params->tooltip ) && $advanced_params->tooltip ) {
						$tooltip .= '<br /><em>'.htmlspecialchars( $advanced_params->tooltip ).'</em>';
					}

					$link = '<span class="editlinktip hasTip" title="'.$tooltip.'">'
							.'<a href="'.$url.'">'
								.$row->title
							.'</a>'
						.'</span> ';
					if ( $config->open_in_modals ) {
						$modal = '<span class="hasTip" title="'.$tooltip.'<br /><br /><strong>'.JText::_( 'AMM_OPEN_IN_MODAL_WINDOW' ).'</strong>">'
								.'<a href="'.$url.'&tmpl=component"'
								.' class="modal" rel="{handler: \'iframe\', size: {x:window.getSize().size.x-100, y: window.getSize().size.y-100}}">'
									.'<img src="components/com_advancedmodules/images/edit.png" alt="'.JText::_( 'AMM_OPEN_IN_MODAL_WINDOW' ).'" />'
								.'</a>'
							.'</span> ';
						$link = $modal.$link;
					}

					$access 	= JHTML::_('grid.access',   $row, $i );
					$checked 	= JHTML::_('grid.checkedout',   $row, $i );
					$published 	= JHTML::_('grid.published', $row, $i );
					?>
					<tr class="<?php echo "row$k"; ?>">
						<td align="right">
							<?php echo $page->getRowOffset( $i ); ?>
						</td>
						<td>
							<?php echo $checked; ?>
						</td>
						<?php
						if ( $client->id != 1 && $config->show_color ) {
							$color = 'FFFFFF';
							if ( isset( $advanced_params->color ) && $advanced_params->color ) {
								$color = strtoupper( preg_replace( '#[^a-z0-9]#si', '', $advanced_params->color ) );
							}
							echo '<td><div style="width:12px;height:12px;border:1px solid silver;background-color:#'.$color.';"></div></td>';
						}
						?>
						<td>
						<?php
						if (  JTable::isCheckedOut( $user->get ('id' ), $row->checked_out ) ) {
							echo $row->title;
						} else {
							echo $link;
						}
						if ( $client->id != 1 && $config->show_tooltip == 2 && isset( $advanced_params->tooltip ) && $advanced_params->tooltip ) {
							if ( $config->show_color ) {
								echo '<div style="padding-left:20px;">'.$advanced_params->tooltip.'</div>';
							} else {
								echo '<br />'.$advanced_params->tooltip;
							}
						}
						?>
						</td>
					<?php if ( $client->id != 1 && $config->show_tooltip == 3 ) : ?>
						<td>
							<?php if ( isset( $advanced_params->tooltip ) ) { echo $advanced_params->tooltip; } ?>
						</td>
					<?php endif; ?>
						<td align="center">
							<?php echo $published; ?>
						</td>
						<td class="order" colspan="2">
							<span><?php echo $page->orderUpIcon( $i, ( $row->position == @$rows[$i-1]->position ), 'orderup', 'Move Up', $ordering ); ?></span>
							<span><?php echo $page->orderDownIcon( $i, $n, ( $row->position == @$rows[$i+1]->position ),'orderdown', 'Move Down', $ordering ); ?></span>
							<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
							<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
						</td>
						<?php
						if ( $client->id != 1 ) {
							$assignment = JText::_( 'All' );
							if ( $row->assignment == '' ) {
								$assignment = JText::_( 'None' );
							} else if ( $row->assignment ) {
								$assignment = JText::_( 'Varies' );
							}

							?>
							<td align="center">
								<?php echo $assignment; ?>
							</td>
							<td align="center">
								<?php echo $access; ?>
							</td>
							<?php
						}
						?>
						<td align="center">
							<?php echo $row->position; ?>
						</td>
						<td>
							<?php echo $row->module ? $row->module : JText::_( 'User' ); ?>
						</td>
						<td>
							<?php echo $row->id; ?>
						</td>
					</tr>
					<?php
					$k = 1 - $k;
				}
				?>
				</tbody>
			</table>
		</form>
		<?php
	}

	function move( &$rows, &$client, &$lists )
	{
	?>
		<script language="javascript" type="text/javascript">
			function submitbutton( pressbutton ) {
				var form = document.adminForm;
				if ( pressbutton == 'cancel' ) {
					submitform( pressbutton );
					return;
				}

				// do field validation
				if ( !getSelectedValue( 'adminForm', 'position' ) ) {
					alert( "<?php echo JText::_( 'AMM_PLEASE_SELECT_A_POSITION_FROM_THE_LIST', true ); ?>" );
				} else {
					submitform( pressbutton );
				}
			}
		</script>

		<form action="index.php" method="post" name="adminForm">
			<input type="hidden" name="option" value="com_advancedmodules" />
			<input type="hidden" name="boxchecked" value="1" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="client" value="<?php echo $client->id; ?>" />
			<?php foreach ( $rows as $module ) : ?>
			<input type="hidden" name="cid[]" value="<?php echo $module->id; ?>" />
			<?php endforeach; ?>
			<?php echo JHTML::_( 'form.token' ); ?>

			<table class="adminform">
				<tr>
					<td width="3%"></td>
					<td  valign="top" width="30%">
						<strong><?php echo JText::_( 'AMM_MOVE_TO_POSITION' ); ?>:</strong>
						<br />
							<?php echo $lists['position']; ?>
						<br /><br />
					</td>
					<td  valign="top">
						<strong><?php echo JText::_( 'AMM_MODULES_BEING_MOVED' ); ?>:</strong>
						<br />
						<ol>
						<?php foreach ( $rows as $module ) : ?>
							<li><?php echo $module->title; ?></li>
						<?php endforeach; ?>
						</ol>
					</td>
				</tr>
			</table>
		</form>
	<?php
	}

	/**
	* Writes the edit form for new and existing module
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.
	* @param JTableCategory The category object
	* @param array <p>The modules of the left side.  The array elements are in the form
	* <var>$leftorder[<i>order</i>] = <i>label</i></var>
	* where <i>order</i> is the module order from the db table and <i>label</i> is a
	* text label associciated with the order.</p>
	* @param array See notes for leftorder
	* @param array An array of select lists
	* @param object Parameters
	*/
	function edit( &$model, &$row, &$orders2, &$lists, &$params, $client )
	{
		JRequest::setVar( 'hidemainmenu', 1 );

		// clean item data
		JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES, 'content' );

		if ( $client->id != 1 ) {
			$parameters =& NNParameters::getParameters();
			$config = JComponentHelper::getParams( 'com_advancedmodules' );
			$config = $parameters->getParams( $config->_raw, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_advancedmodules'.DS.'config.xml' );
		}

		$document =& JFactory::getDocument();
		$editor =& JFactory::getEditor();

		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'versions.php';
		$version = NoNumberVersions::getXMLVersion( null, null, null, 1 );

		$document->addScript( JURI::root(true).'/plugins/system/nonumberelements/js/script.js'.$version );
		$document->addScript( JURI::root(true).'/plugins/system/nonumberelements/elements/toggler.js'.$version );

		$script = "
			function submitbutton( pressbutton ) {
				if ( ( pressbutton == 'save' || pressbutton == 'apply' ) && ( document.adminForm.title.value == '' ) ) {
					alert( '".JText::_( 'Module must have a title', true )."' );
				} else {
					if ( pressbutton == 'save' ) {
						document.adminForm.target = '_parent';
					}
		";
		if ( $row->module == '' || $row->module == 'mod_custom' ) {
			$script .= $editor->save( 'content' );
		}
		$script .= "
					submitform( pressbutton );
				}
			}
			var originalOrder 	= '".$row->ordering."';
			var originalPos 	= '".$row->position."';
			var orders 			= new Array();	// array in the format [key,value,text]
		";
		$i = 0;
		foreach ( $orders2 as $k => $items ) {
			foreach ( $items as $v ) {
				$script .= "\n".'	orders['.$i++.'] = new Array( "'.$k.'","'.$v->value.'","'.$v->text.'" );';
			}
		}
		$script .= "
			window.addEvent( 'domready', function() {
				if ( !nnTogglerSet ) {
					nnTogglerSet = new nnToggler();
				}
			});
		";

		if ( $client->id != 1 ) {
			if ( $config->show_color ) {
				$colors = explode( ',', $config->main_colors );
				foreach ( $colors as $i=> $c ) {
					$colors[$i] = strtoupper( '#'.preg_replace( '#[^a-z0-9]#i', '', $c ) );
				}
				$script .= "
					mainColors = new Array( '".implode( "', '", $colors )."' );";
			}
		}

		$document->addScriptDeclaration( $script );

		$tmpl = JRequest::getCmd( 'tmpl' );

		if ( $tmpl == 'component' ) {
			HTML_modules::placeModalHeader( 'edit' );
		}

		jimport( 'joomla.html.pane' );
        // TODO: allowAllClose should default true in J!1.6, so remove the array when it does.
		$pane =& JPane::getInstance( 'sliders', array( 'allowAllClose' => true ) );

		JHTML::_( 'behavior.tooltip' );
		?>
		<form action="<?php echo JRoute::_( 'index.php'); ?>" method="post" name="adminForm">
			<input type="hidden" name="option" value="com_advancedmodules" />
			<input type="hidden" name="tmpl" value="<?php echo $tmpl; ?>" />
			<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
			<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
			<input type="hidden" name="original" value="<?php echo $row->ordering; ?>" />
			<input type="hidden" name="module" value="<?php echo $row->module; ?>" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="client" value="<?php echo $client->id; ?>" />
			<?php echo JHTML::_( 'form.token' ); ?>

		<div class="col width-50">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Details' ); ?></legend>

				<table class="admintable" cellspacing="1">
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'Module Type' ); ?>:
						</td>
						<td>
							<strong>
								<?php echo JText::_( $row->module ); ?>
							</strong>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="title">
								<?php echo JText::_( 'Title' ); ?>:
							</label>
						</td>
						<td>
							<input class="text_area" type="text" name="title" id="title" size="50" value="<?php echo $row->title; ?>" />
						</td>
					</tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_( 'Show title' ); ?>:
						</td>
						<td>
							<?php echo $lists['showtitle']; ?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'Published' ); ?>:
						</td>
						<td>
							<?php echo $lists['published']; ?>
						</td>
					</tr>
				<?php
					if ( $client->id != 1 ) :
						if ( $config->show_hideempty ) :
				?>
					<tr>
						<td valign="top" class="key">
							<label for="hideempty" class="hasTip" title="<?php echo JText::_( 'AMM_HIDE_IF_EMPTY' ); ?>::<?php echo JText::_( 'AMM_HIDE_IF_EMPTY_DESC' ); ?>">
								<?php echo JText::_( 'AMM_HIDE_IF_EMPTY', 0 ); ?>:
							</label>
						</td>
						<td>
							<?php echo $lists['hideempty']; ?>
						</td>
					</tr>
				<?php
						endif;
					endif;
				?>
					<tr>
						<td valign="top" class="key">
							<label for="position" class="hasTip" title="<?php echo JText::_( 'MODULE_POSITION_TIP_TITLE', true); ?>::<?php echo JText::_('MODULE_POSITION_TIP_TEXT', true ); ?>">
								<?php echo JText::_( 'Position' ); ?>:
							</label>
						</td>
						<td>
							<input type="text" id="position" name="position" value="<?php echo $row->position; ?>"  onchange="form.position_select.value=this.value" />
							<select id="position_select" onchange="document.getElementById('position').value=this.options[this.selectedIndex].value;this.value=''" style="background-color:#F0F0F0;">
							<?php
								echo '<option value="">-- '.JText::_( 'Select Position' ).' --</option>';
								$positions = $model->getPositions();
								foreach ( $positions as $position ) {
									echo '<option value="'.$position.'">'.$position.'</option>';
								}
							?>
							</select>
						</td>
					</tr>

					<tr>
						<td valign="top"  class="key">
							<label for="ordering">
								<?php echo JText::_( 'Order' ); ?>:
							</label>
						</td>
						<td>
							<script language="javascript" type="text/javascript">
							<!--
							writeDynaList( 'class="inputbox" name="ordering" id="ordering" size="1"', orders, originalPos, originalPos, originalOrder );
							//-->
							</script>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<label for="access">
								<?php echo JText::_( 'AMM_ACCESS_LEVEL' ); ?>:
							</label>
						</td>
						<td>
							<?php echo $lists['access']; ?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'ID' ); ?>:
						</td>
						<td>
							<?php echo $row->id; ?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'Description' ); ?>:
						</td>
						<td>
							<?php
								echo JText::_( html_entity_decode( $row->description, ENT_COMPAT, 'UTF-8' ) );
							?>
						</td>
					</tr>
				<?php
					if ( $client->id != 1 ) :
				?>
					<tr>
						<td valign="top" class="key">
							<label class="hasTip" title="<?php echo JText::_( 'AMM_CUSTOM_DESCRIPTION' ); ?>::<?php echo JText::_( 'AMM_CUSTOM_DESCRIPTION_DESC' ); ?>"><?php echo JText::_( 'AMM_CUSTOM_DESCRIPTION' ); ?>:</label>
						</td>
						<td>
							<?php echo $lists['tooltip']; ?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<label class="hasTip" title="<?php echo JText::_( 'AMM_COLOR' ); ?>::<?php echo JText::_( 'AMM_COLOR_DESC' ); ?>"><?php echo JText::_( 'AMM_COLOR' ); ?>:</label>
						</td>
						<td>
							<?php echo $lists['color']; ?>
						</td>
					</tr>
				<?php
					endif;
				?>
				</table>
			</fieldset>
		</div>

		<div class="col width-50">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Parameters' ); ?></legend>

				<?php
					echo $pane->startPane( "menu-pane" );

						echo $pane->startPanel( JText::_( 'Module Parameters' ), "param-page" );
							$p = $params;
							$params = $p->render( 'params' );
							if ( $params ) {
								echo $params;
								if ( $client->id != 1 ) {
									echo $lists['extra'];
								}
							} else {
								if ( $client->id != 1 && $lists['extra'] ) {
									echo $lists['extra'];
								} else {
									echo "<div style=\"text-align: center; padding: 5px; \">".JText::_( 'There are no parameters for this item' )."</div>";
								}
							}
						echo $pane->endPanel();

					if ( $p->getNumParams( 'advanced' ) ) {
						echo $pane->startPanel( JText::_( 'Advanced Parameters' ), "advanced-page" );
							$params = $p->render( 'params', 'advanced' );
							if( $params ) {
								echo $params;
							} else {
								echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_( 'There are no advanced parameters for this item' )."</div>";
							}
						echo $pane->endPanel();
					}

					if ( $p->getNumParams( 'legacy' ) ) {
						echo $pane->startPanel( JText::_( 'Legacy Parameters' ), "legacy-page" );
							$params = $p->render( 'params', 'legacy' );
							if ( $params ) {
								echo $params;
							} else {
								echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_( 'There are no legacy parameters for this item' )."</div>";
							}
						echo $pane->endPanel();
					}

					if ( $p->getNumParams( 'other' ) ) {
						echo $pane->startPanel( JText::_( 'Other Parameters' ), "other-page" );
							$params = $p->render( 'params', 'other' );
							if ( $params ) {
								echo $params;
							} else {
								echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_( 'There are no other parameters for this item' )."</div>";
							}
						echo $pane->endPanel();
					}

					if ( $client->id != 1 ) {
						echo $pane->startPanel( JText::_('AMM_MODULE_ASSIGNMENT' ), "assignment-page" );
							echo HTML_modules::renderAssignments( $lists, $config );
						echo $pane->endPanel();
					}
					echo $pane->endPane();
				?>
			</fieldset>
		</div>
		<div class="clr"></div>

		<?php
		if ( !$row->module || $row->module == 'custom' || $row->module == 'mod_custom' ) {
			?>
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Custom Output' ); ?></legend>

				<?php
				// parameters : areaname, content, width, height, cols, rows
				echo $editor->display( 'content', $row->content, '100%', '400', '60', '20', array( 'pagebreak', 'readmore' ) ) ;
				?>

			</fieldset>
			<?php
		}
		?>
		</form>
	<?php
	}

	function preview()
	{
		$editor =& JFactory::getEditor();

		?>
		<script type="text/javascript">
			var form = window.top.document.adminForm;
			var title = form.title.value;

			var alltext = window.top.<?php echo $editor->getContent( 'text' ) ?>;
		</script>

		<table align="center" width="90%" cellspacing="2" cellpadding="2" border="0">
			<tr>
				<td class="contentheading" colspan="2"><script type="text/javascript">document.write( title );</script></td>
			</tr>
			<tr>
				<td valign="top" height="90%" colspan="2"><script type="text/javascript">document.write( alltext + "" );</script></td>
			</tr>
		</table>
		<?php
	}

/**
	/**
	* Displays a selection list for module types
	*/
	function add( &$modules, $client )
	{
 		JHTML::_( 'behavior.tooltip' );

		?>
		<form action="<?php echo JRoute::_( 'index.php'); ?>" method="post" name="adminForm">
			<input type="hidden" name="option" value="com_advancedmodules" />
			<input type="hidden" name="client" value="<?php echo $client->id; ?>" />
			<input type="hidden" name="created" value="1" />
			<input type="hidden" name="task" value="edit" />
			<input type="hidden" name="boxchecked" value="0" />
			<?php echo JHTML::_( 'form.token' ); ?>

			<table class="adminlist" cellpadding="1" summary="Add Module">
				<thead>
					<tr>
						<th colspan="4">
						<?php echo JText::_( 'Modules' ); ?>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th colspan="4">&nbsp;
						</th>
					</tr>
				</tfoot>
				<tbody>
				<?php
				$altRow = 0;
				$count = count( $modules );
				// Variable-column ready, just pass $cols in.
				$cols = 2;
				$pct = floor( 100 / $cols );
				$rows = ceil( $count / $cols );
				$posn = 0;
				do {
					?>
					<tr class="<?php echo 'row' . $altRow; ?>" valign="top">
					<?php
					$altRow = 1 - $altRow;
					for ( $col = 0; $col < $cols; ++$col ) :
						if ( ( $mod = $posn + $col * $rows ) >= $count ) :
							?>
							<td width="<?php echo $pct; ?>%">&nbsp;</td>
							<?php
							continue;
						endif;
						$item =& $modules[$mod];
						$link = 'index.php?option=com_advancedmodules&amp;task=edit&amp;module='
							. $item->module . '&amp;created=1&amp;client=' . $client->id;

						echo '
							<td width="'.$pct.'%">
								<span class="editlinktip hasTip" title="'
									.htmlspecialchars($item->name.' :: '
									.JText::_( stripslashes( $item->descrip) ), ENT_QUOTES, 'UTF-8' )
									.'" name="module" value="'.$item->module.'" onclick="isChecked( this.checked );">
								<input type="radio" name="module" value="'
									.$item->module.'" id="cb<?php echo $mod; ?>"/><a href="'
									.$link.'">'
									.htmlspecialchars( $item->name, ENT_QUOTES, 'UTF-8' )
									.'</a></span>
							</td>';
					endfor;
					++$posn;
					?>
					</tr>
				<?php
				} while ( $posn < $rows );
				?>
				</tbody>
			</table>
		</form>
		<?php
	}
	/**
	* Displays a selection list for module types
	*/
	function placeModalHeader( $action )
	{
		$document =& JFactory::getDocument();

		$document->addStyleSheet( JURI::base( true ).'/templates/system/css/system.css' );
		$document->addStyleSheet( JURI::base( true ).'/templates/khepri/css/template.css' );
		$document->addStyleSheet( JURI::base( true ).'/templates/khepri/css/rounded.css' );

		// Render the toolbar
		echo '
			<div class="padding"><div id="toolbar-box">
	   			<div class="t"><div class="t"><div class="t"></div></div></div>
				<div class="m">
					<div class="toolbar" id="toolbar">
						<table class="toolbar"><tr>
							<td class="button" id="toolbar-save">
								<a href="#" onclick="javascript: submitbutton( \'save\' )" class="toolbar">
									<span class="icon-32-save" title="'.JText::_( 'Save' ).'"></span>
									'.JText::_( 'Save' ).'
								</a>
							</td>
							<td class="button" id="toolbar-apply">
								<a href="#" onclick="javascript: submitbutton( \'apply\' )" class="toolbar">
									<span class="icon-32-apply" title="'.JText::_( 'Apply' ).'"></span>
									'.JText::_( 'Apply' ).'
								</a>
							</td>
							<td class="button" id="toolbar-cancel">
								<a href="#" onclick="javascript: parent.location.href=parent.location; parent.SqueezeBox.window.setStyle( \'display\', \'none\' );return false;" class="toolbar">
									<span class="icon-32-cancel" title="'.JText::_( 'Close' ).'"></span>
									'.JText::_( 'Close' ).'
								</a>
							</td>
						</tr></table>
					</div>
					<div class="header icon-48-module">
						'.JText::_( 'Module' ).': <small><small>[ '.JText::_( $action ).' ]</small></small>
					</div>
					<div class="clr"></div>
				</div>
				<div class="b"><div class="b"><div class="b"></div></div>
			</div></div>';
	}
	function renderAssignments( &$lists, &$config )
	{
		jimport( 'joomla.filesystem.file' );

		$lang =& JFactory::getLanguage();
		if ( $lang->getTag() != 'en-GB' ) {
			// Loads English language file as fallback (for undefined stuff in other language file)
			$lang->load( 'com_advancedmodules', JPATH_ADMINISTRATOR, 'en-GB' );
		}
		$lang->load( 'com_advancedmodules', JPATH_ADMINISTRATOR, null, 1 );

		if ( $config->show_mirror_module ) {
			echo $lists['assignments']->render( 'advancedparams', 'mirror_module' );
			echo '<div id="'.rand( 1000000, 9999999 ).'___mirror_module.0" class="nntoggler" style="visibility: hidden;">';
		} else {
			echo '<div>';
		}

		$config->show_assignto_fc = (int) ( $config->show_assignto_fc && JFile::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_flexicontent'.DS.'admin.flexicontent.php' ) );
		$config->show_assignto_k2 = (int) ( $config->show_assignto_k2 && JFile::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'admin.k2.php' ) );
		$config->show_assignto_mr = (int) ( $config->show_assignto_mr && JFile::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_resource'.DS.'resource.php' ) );
		$config->show_assignto_zoo = (int) ( $config->show_assignto_zoo && JFile::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_zoo'.DS.'zoo.php' ) );

		if (	$config->show_match_method
			&&	( $config->show_assignto_content
				||	$config->show_assignto_fc
				||	$config->show_assignto_k2
				||	$config->show_assignto_mr
				||	$config->show_assignto_zoo
				||	$config->show_assignto_components
				||	$config->show_assignto_urls
				||	$config->show_assignto_browser
				||	$config->show_assignto_date
				||	$config->show_assignto_usergrouplevels
				||	$config->show_assignto_users
				||	$config->show_assignto_languages
				||	$config->show_assignto_templates
				||	$config->show_assignto_php
			)
		) {
			if ( $config->show_match_method ) {
				echo $lists['assignments']->render( 'advancedparams', 'match_method' );
			}
		}

		if ( $config->show_show_ignores ) {
			$html = $lists['assignments']->render( 'advancedparams', 'show_ignores' );
			$def_val = $config->show_ignores ? '2' : '-1';
			$def_text = $config->show_ignores ? JText::_( 'Show' ) : JText::_( 'Hide' );
			echo preg_replace( '#(<input [^>]*id="advancedparamsshow_ignores2"[^>]*value=)"2"([^>]*/>.*?)(</label>)#si', '\1"'.$def_val.'"\2 ('.$def_text.')\3', $html );
		} else {
			echo '<input type="hidden" name="show_ignores" value="1" />';
		}

		echo $lists['assignments']->render( 'advancedparams', 'assignto_menuitems' );
		if ( $config->show_assignto_homepage ) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_homepage' );
		}
		if ( $config->show_assignto_content ) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_content' );
		}
		if ( $config->show_assignto_fc ) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_fc' );
		}
		if ( $config->show_assignto_k2 ) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_k2' );
		}
		if ( $config->show_assignto_mr ) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_mrcats' );
		}
		if ( $config->show_assignto_zoo ) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_zoocats' );
		}
		if ( $config->show_assignto_components ) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_components' );
		}
		if ( $config->show_assignto_urls ) {
			$configuration =& JFactory::getConfig();
			$use_sef = ( $config->use_sef == 2 ) ? $configuration->getValue('config.sef') == 1 : $config->use_sef;
			echo '<input type="hidden" name="use_sef" value="'.(int) $use_sef.'" />';
			echo $lists['assignments']->render( 'advancedparams', 'assignto_urls' );
		}
		if ( $config->show_assignto_browsers ) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_browsers' );
		}
		if ( $config->show_assignto_date ) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_date' );
		}
		if (	$config->show_assignto_usergrouplevels
			||	$config->show_assignto_users
		) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_users_open' );

			if ( $config->show_assignto_usergrouplevels ) {
				echo $lists['assignments']->render( 'advancedparams', 'assignto_usergrouplevels' );
			}
			if ( $config->show_assignto_users ) {
				echo $lists['assignments']->render( 'advancedparams', 'assignto_users' );
			}
			echo $lists['assignments']->render( 'advancedparams', 'assignto_users_close' );
		}
		if ( $config->show_assignto_languages ) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_languages' );
		}
		if ( $config->show_assignto_templates ) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_templates' );
		}
		if ( $config->show_assignto_php ) {
			echo $lists['assignments']->render( 'advancedparams', 'assignto_php' );
		}
		echo '</div>';
	}
}