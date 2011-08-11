<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');
jimport('joomla.html.pane');

require_once(JPATH_SITE."/components/com_adsmanager/helpers/field.php");

?>
<style>
.icon-48-adsmanager {
	background-image: url('../components/com_adsmanager/images/logo.png');
	height: 48px;
}
</style>
<?php 

/**
 * @package		Joomla
 * @subpackage	Contacts
 */
class AdsmanagerViewAdmin extends JView
{
	function __construct($config = array())
	{
		parent::__construct($config);
		
		$uri =& JFactory::getURI();
		$baseurl = JURI::base();
		$baseurl = str_replace("administrator/","",$baseurl);
		
		$user		= JFactory::getUser();
		
		$this->assign("userid",$user->id);
		$this->assign("baseurl",$baseurl);
		$this->assignRef("baseurl",$baseurl);
	}
	
	function display($tpl = null)
	{
		$subfunction = "_".$this->_layout;
		
		$this->$subfunction();
		
		parent::display();
	}
	
	function setListToolbar($title)
	{
		JToolBarHelper::title( $title, 'adsmanager' );
		JToolBarHelper::editList();
		JToolBarHelper::addNew();
		JToolBarHelper::deleteList();	
	}
	
	function setEditToolbar($title)
	{
		JToolBarHelper::title( $title, 'adsmanager' );
		JToolBarHelper::save();
		JToolBarHelper::cancel();	
	}
	
	function setViewToolbar($title)
	{
		JToolBarHelper::title( $title, 'adsmanager' );
		JToolBarHelper::editList();
	}
	
	function _mosTreeRecurse( $id, $indent, $list, &$children, $maxlevel=9999, $level=0, $type=1,$parent='parent') {
        if (@$children[$id] AND $level <= $maxlevel) {
            $newindent = $indent.($type ? '.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : '&nbsp;&nbsp;');
            $pre = $type ? '<sup>L</sup>&nbsp;' : '- ';
            foreach ($children[$id] as $v) {
                $id = $v->id;
               $list[$id] = $v;
               $list[$id]->treename = $indent.($v->$parent == 0 ? '' : $pre).$v->name;
                $list[$id]->children = count( @$children[$id] );
               $list[$id]->level = $level;
                $list = $this->_mosTreeRecurse( $id, $newindent, $list, $children, $maxlevel, $level+1, $type );
            }
        }
        return $list;
    }
	
	
	function _listcategories()
	{
		$app = JFactory::getApplication();
		
		$this->setListToolbar(JText::_("COM_ADSMANAGER")." - ".JText::_("ADSMANAGER_CATEGORIES"));
		
		$limit					= $app->getUserStateFromRequest('global.list.limit',									'limit',			$app->getCfg('list_limit'), 'int');
		$limitstart				= $app->getUserStateFromRequest("com_adsmanager.admin_category.limitstart",			'limitstart',		0,			'int');
		
		
		$model = $this->getModel();
		$total = $model->getNbCats(false);
		
		jimport('joomla.html.pagination');
		$pagination = new JPagination($total, $limitstart, $limit);
		
		$rows = $model->getCategories(false);
		
		// establish the hierarchy of the menu
		$children = array();
		// first pass - collect children
		foreach ($rows as $v ) {
			$pt 	= $v->parent;
			$list 	= @$children[$pt] ? $children[$pt] : array();
			array_push( $list, $v );
			$children[$pt] = $list;
		}
		// second pass - get an indent list of the items
		$list = $this->_mosTreeRecurse( 0, '', array(), $children);
		$list = array_slice( $list, $pagination->limitstart, $pagination->limit );
		
		$ordering = 1;
		$this->assignRef('ordering',$ordering);
		$this->assignRef('list',$list);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('total',$total);
	}
	
	function _editcategory()
	{
		$this->setEditToolbar(JText::_("COM_ADSMANAGER")." - ".JText::_("ADSMANAGER_EDIT_CATEGORY"));
		
		$catid = JRequest::getVar( 'cids', array(0), '', 'array' );
		JArrayHelper::toInteger($catid, array(0));
		$id	= JRequest::getVar( 'id', $catid[0], '', 'int' );

		$model = $this->getModel();
		
		$cat = $model->getCategory($id);
						 
		$cats = $model->getCatTree(false);
		$this->assignRef('cats',$cats);
		
		$this->assignRef('row',$cat);

	}
	
	function _listcontents()
	{
		$app = JFactory::getApplication();
		
		$confmodel	  = $this->getModel("Configuration");
		$catmodel     = $this->getModel("Category");
		$contentmodel = $this->getModel("Content");
		
		$limit					= $app->getUserStateFromRequest('global.list.limit',									'limit',			$app->getCfg('list_limit'), 'int');
		$limitstart				= $app->getUserStateFromRequest("com_adsmanager.admin_content.limitstart",			'limitstart',		0,			'int');
		$filter_order     = $app->getUserStateFromRequest( 'com_adsmanager.content.filter_order','filter_order','a.id','cmd' );
        $filter_order_Dir = $app->getUserStateFromRequest( 'com_adsmanager.content.filter_order_Dir','filter_order_Dir', 'ASC','word' );
		$filterpublish 	  = $app->getUserStateFromRequest( 'com_adsmanager.content.publish','filterpublish', '' );
		$search 	 	  = $app->getUserStateFromRequest( 'com_adsmanager.content.user','search', '','word' );
		
		$this->setListToolbar(JText::_("COM_ADSMANAGER")." - ".JText::_("ADSMANAGER_CONTENTS"));
		
		$user		= JFactory::getUser();
		
		$conf = $confmodel->getConfiguration();
		
		$lists['order_Dir']= $filter_order_Dir;
		$lists['order'] = $filter_order;
		$this->assignRef('lists',$lists);

		$filters = array();
	
		$catid = JRequest::getInt( 'catid',	0 );
		if ($catid != 0) {
			$filters['category'] = $catid;
		}
		$this->assignRef('cat',$catid);
		
		if ($filterpublish != "") {
			$filters['publish'] = $filterpublish;
		}
		$this->assignRef('filterpublish',$filterpublish);
		
		if ($search != "") {
			$filters['username'] = $search;
		}
		$this->assignRef('search',$search);
		
		$cats = $catmodel->getCatTree(false);
		$this->assignRef('cats',$cats);
			
		
		$total = $contentmodel->getNbContents($filters);
		$contents = $contentmodel->getContents($filters,$limitstart, $limit,$filter_order,$filter_order_Dir,1);//1=admin
		
		jimport('joomla.html.pagination');
		$pagination = new JPagination($total, $limitstart, $limit);
		
		$this->assignRef('contents',$contents);
		$this->assignRef('conf',$conf);
		$this->assignRef('pagination',$pagination);
	}
	
	function _editcontent()
	{
		$this->setEditToolbar(JText::_("COM_ADSMANAGER")." - ".JText::_("ADSMANAGER_EDIT_CONTENT"));
		
		$app = &JFactory::getApplication();

		$user		= JFactory::getUser();
		
		$confmodel	  = $this->getModel("Configuration");
		$usermodel	  = $this->getModel("User");
		$contentmodel = $this->getModel("Content");
		$catmodel	  = $this->getModel("Category");
		$fieldmodel	  = $this->getModel("Field");
		
		$conf = $confmodel->getConfiguration();
		$this->assignRef('conf',$conf);
		
		$catid = JRequest::getInt( 'catid',	0 );
		if ($catid != 0) {
			$category = $catmodel->getCategory($catid);
			$category->img = $this->get('baseurl').'/images/com_adsmanager/categories/'.$catid.'cat_t.jpg';
		}
		else
		{
			$category->name = JText::_("");
			$category->description = "";
			$category->img = "";
		}
		
		$this->assignRef('category',$category);
		$this->assignRef('catid',$catid);
		
		$fields = $fieldmodel->getFields();	
		$this->assignRef('fields',$fields);
		
		
		$field_values = $fieldmodel->getFieldValues();
		foreach($fields as $field)
		{
			if ($field->cbfieldvalues != "-1")
			{
				/*get CB value fields */
				$cbfieldvalues = $fieldmodel->getCBFieldValues($field->cbfieldvalues);
				$field_values[$field->fieldid] = $cbfieldvalues;
			}
		}
		$this->assignRef('field_values',$field_values);

		$plugins = $fieldmodel->getPlugins();
		$field = new JHTMLAdsmanagerField($conf,$field_values,"1",$plugins,"",$this->get('baseurl'));
		
		$this->assignRef('field',$field);
		
		$errorMsg = JRequest::getString( 'errorMsg',	"" );
		$this->assignRef('errorMsg',$errorMsg);	
		
		$users = $usermodel->getUsers();
		$this->assignRef('users',$users);

		/* No need to user query, if errorMsg */
		if ($errorMsg == "")
		{
			if ($conf->comprofiler == 0)
			{	
				$profile = $usermodel->getProfile($user->id);
			}
			else
			{
				$profile = $usermodel->getCBProfile($user->id);
			}
		}
		
		$contentid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($contentid, array(0));
		$contentid	= JRequest::getVar( 'id', $contentid[0], '', 'int' );
		
		// Update Ad ?
		if ($contentid > 0)
		{ // edit ad	
			$content = $contentmodel->getContent($contentid);
			$content->ad_text = str_replace ('<br/>',"\r\n",$content->ad_text);
			$isUpdateMode = 1;
		}
		else { // insert
			$isUpdateMode = 0;	
		}
		
		$this->assignRef('content',$content);
		
		$this->assignRef('isUpdateMode',$isUpdateMode);
		
		
		$tree = $catmodel->getCatTree(false);
		$this->assignRef('cats',$tree);
		
		$nullobj = null;
		if ($errorMsg != "")
			$this->assignRef('default',(object) JRequest::get( 'post' ));
		else
			$this->assignRef('default',$nullobj);
			
		if (($conf->submission_type == 2)&&($user->id == "0"))
		{
			$this->assignRef('warning_text',ADSMANAGER_WARNING_NEW_AD_NO_ACCOUNT."<br/>");
		}
		
		switch($errorMsg)
		{
			case "bad_password":
				$this->assignRef('error_text',JText::_('ADSMANAGER_BAD_PASSWORD')."<br />");
				break;
			case "email_already_used":
				$this->assignRef('error_text',JText::_('ADSMANAGER_EMAIL_ALREADY_USED')."<br />");
				break;
			case "file_too_big":
				$this->assignRef('error_text',JText::_('ADSMANAGER_FILE_TOO_BIG')."<br />");
		}
		
		$nbcats = $conf->nbcats;
		if (function_exists("getMaxCats"))
		{
		  $nbcats = getMaxCats($conf->nbcats);
		}
		$this->assignRef('nbcats',$nbcats);
		
		if (($conf->submission_type == 0)&&($user->id == 0))
		{
			$this->assignRef('account_creation',1);
		}
	}
	
	function _position()
	{
		JToolBarHelper::title(JText::_("COM_ADSMANAGER")." - ".JText::_("ADSMANAGER_CONTENT_DISPLAY"), 'adsmanager' );
		
		$model		= $this->getModel("position");
		
		$positions = $model->getPositions();
		
		$model		= $this->getModel("field");
		
		$fDisplay = $model->getFieldsbyPositions();
		
		$this->assignRef('fDisplay',$fDisplay);
		$this->assignRef('positions',$positions);
	}
	
	function _columns()
	{
		$this->setListToolbar(JText::_("COM_ADSMANAGER")." - ".JText::_("ADSMANAGER_COLUMNS"));
		
		$fieldmodel = $this->getModel("Field");
		$columnmodel = $this->getModel("Column");
		
		$columns = $columnmodel->getColumns(null,true);
		$fcolumns = $fieldmodel->getFieldsbyColumns();
		
		$this->assignRef('columns',$columns);
		$this->assignRef('fColumns',$fcolumns);
	}
	
	function _editcolumn()
	{
		$this->setEditToolbar(JText::_("COM_ADSMANAGER")." - ".JText::_("ADSMANAGER_EDIT_COLUMN"));
		
		$columnmodel = $this->getModel("Column");
		$catmodel = $this->getModel("Category");
		
		$cats = $catmodel->getCatTree(false);
		$nbcats = $catmodel->getNbCats(false);
		
		$id = JRequest::getVar( 'cid', array(0));
		if (is_array($id))
			$id = $id[0];
		$column = $columnmodel->getColumn($id);
		
		$this->assignRef('cats',$cats);
		$this->assignRef('nbcats',$nbcats);
		$this->assignRef('column',$column);
	}
	
	function _listfields()
	{
		$app = &JFactory::getApplication();
		
		$this->setListToolbar(JText::_("COM_ADSMANAGER")." - ".JText::_("ADSMANAGER_FIELDS"));
		
		$limit			  = $app->getUserStateFromRequest('global.list.limit','limit',$app->getCfg('list_limit'),'int');
		$limitstart		  = $app->getUserStateFromRequest( "com_adsmanager.field.limitstart",'limitstart',0,'int');
		$filter_order     = $app->getUserStateFromRequest( 'com_adsmanager.field.filter_order','filter_order','f.ordering','cmd' );
        $filter_order_Dir = $app->getUserStateFromRequest( 'com_adsmanager.field.filter_order_Dir','filter_order_Dir', 'ASC','word' );
		
		$fieldmodel		= $this->getModel("field");
		
		$total 	= $fieldmodel->getNbFields();
		
		jimport('joomla.html.pagination');
		$pagination = new JPagination($total, $limitstart, $limit);
		
		$fields = $fieldmodel->getFields(false,$limitstart, $limit,$filter_order,$filter_order_Dir);
		
		$lists['order_Dir']= $filter_order_Dir;
		$lists['order'] = $filter_order;
		$this->assignRef('lists',$lists);
		$this->assignRef('fields',$fields);
		$this->assignRef('pagination',$pagination);
		$ordering = 1;
		$this->assignRef('ordering',$ordering);
	}
	
	function _editfield()
	{
		$this->setEditToolbar(JText::_("COM_ADSMANAGER")." - ".JText::_("ADSMANAGER_EDIT_FIELD"));
		
		$fieldmodel		= $this->getModel("field");
		$catmodel		= $this->getModel("category");
		$positionmodel	= $this->getModel("position");
		$columnmodel	= $this->getModel("column");
		
		$plugins = $fieldmodel->getPlugins();
		$this->assignRef('plugins',$plugins);
		
		$id = JRequest::getVar( 'cid', array(0));
		if (is_array($id))
			$id = $id[0];
		
		$field = null;
		
		if ($id)
			$field = $fieldmodel->getField($id);
			
		$this->assignRef('field',$field);
		
		$cats = $catmodel->getCatTree(false);
		$nbcats = $catmodel->getNbCats(false);
		$this->assignRef('cats',$cats);
		$this->assignRef('nbcats',$nbcats);
		
		$fieldValues = $fieldmodel->getFieldValues($id);
		$this->assignRef('fieldvalues',$fieldValues);
		
		$columns = array();
		$types = array();
		$lists = array();
		$positions = array();
		$cbfields = array();
		$sort_direction = array();
		$display_title_list = array();
	
		$types[] = JHTML::_('select.option', 'checkbox', 'Check Box (Single)' );
		$types[] = JHTML::_('select.option', 'multicheckbox', 'Check Box (Muliple)' );
		$types[] = JHTML::_('select.option', 'multicheckboximage', 'Check Box (Muliple Images)' );
		$types[] = JHTML::_('select.option', 'date', 'Date' );
		$types[] = JHTML::_('select.option', 'select', 'Drop Down (Single Select)' );
		$types[] = JHTML::_('select.option', 'multiselect', 'Drop Down (Multi-Select)' );
		$types[] = JHTML::_('select.option', 'emailaddress', 'Email Address' );	
		$types[] = JHTML::_('select.option', 'number', 'Number Text' );	
		$types[] = JHTML::_('select.option', 'price', 'Price' );	
		$types[] = JHTML::_('select.option', 'editor', 'Editor Text Area' );
		$types[] = JHTML::_('select.option', 'textarea', 'Text Area' );
		$types[] = JHTML::_('select.option', 'text', 'Text Field' );
		$types[] = JHTML::_('select.option', 'url', 'URL' );
		$types[] = JHTML::_('select.option', 'radio', 'Radio Button' );
		$types[] = JHTMLSelect::option ('radioimage','Radio Button (Image)');
		$types[] = JHTML::_('select.option', 'file', 'File' );

		if(isset($plugins))
			foreach($plugins as $key => $plug)
			{
				$types[] = JHTML::_('select.option', $key, $plug->getFieldName() ); 
			}
		
		$columns[] = JHTML::_('select.option', '-1', 'No Column' );
		
		$db_columns = $columnmodel->getColumns(null,true);
		foreach($db_columns as $col)
		{
			if ((@$col->name)&&($col->name!=""))
				$coln = JText::_($col->name);
			$columns[] = JHTML::_('select.option', "$col->id", "$coln" );
		}
		
		$cb_fields = $fieldmodel->getAllCbFields();
		
		$cbfields[] = JHTML::_('select.option', '-1', JText::_('ADSMANAGER_NOT_USED') );
		if (isset($cb_fields))
		{
			foreach($cb_fields as $cb)
			{
				$cbfields[] = JHTML::_('select.option', $cb->fieldid, "(".$cb->fieldid.") ".$cb->name );
			}
		}
		
		$positions[] = JHTML::_('select.option', '-1', JText::_('ADSMANAGER_NO_DISPLAY') );
		
		$db_positions = $positionmodel->getPositions(null);
		foreach($db_positions as $pos)
		{
			if ((@$pos->title)&&($pos->title!=""))
				$p = "(".JText::_($pos->title).")";
			else
				$p = "";
			$positions[] = JHTML::_('select.option', "$pos->id", "$pos->name.$p" );
		}
	
		$sort_direction[] = JHTML::_('select.option', 'DESC', JText::_('ADSMANAGER_CMN_SORT_DESC') );
		$sort_direction[] = JHTML::_('select.option', 'ASC', JText::_('ADSMANAGER_CMN_SORT_ASC') );
		
		$display_title_list[] = JHTML::_('select.option', '0', JText::_('ADSMANAGER_NO_DISPLAY') );
		$display_title_list[] = JHTML::_('select.option', '1', JText::_('ADSMANAGER_DISPLAY_DETAILS') );
		$display_title_list[] = JHTML::_('select.option', '2', JText::_('ADSMANAGER_DISPLAY_LIST') );
		$display_title_list[] = JHTML::_('select.option', '3', JText::_('ADSMANAGER_DISPLAY_LIST_AND_DETAILS') );
		
		$lists['display_title'] = JHTML::_('select.genericlist', $display_title_list, 'display_title', 'class="inputbox" size="1"', 'value', 'text', @$field->display_title );
			
		$lists['type'] = JHTML::_('select.genericlist', $types, 'type', 'class="inputbox" size="1" onchange="selType(this.options[this.selectedIndex].value);"', 'value', 'text', @$field->type );
	
		$lists['required'] = JHTML::_('select.booleanlist', 'required', 'class="inputbox" size="1"', @$field->required );
		
		$lists['columns'] = JHTML::_('select.genericlist', $columns, 'columnid', 'class="inputbox" size="1"', 'value', 'text', @$field->columnid );
	
		$lists['positions'] = JHTML::_('select.genericlist', $positions, 'pos', 'class="inputbox" size="1"', 'value', 'text', @$field->pos );
	
		$lists['profile'] = JHTML::_('select.booleanlist', 'profile', 'class="inputbox" size="1"', @$field->profile );
	
		$lists['cbfields'] = JHTML::_('select.genericlist', $cbfields, 'cb_field', 'class="inputbox" size="1"', 'value', 'text', @$field->cb_field );
		$lists['cbfieldvalues'] = JHTML::_('select.genericlist', $cbfields, 'cbfieldvalues', 'class="inputbox" size="1"', 'value', 'text', @$field->cbfieldvalues );
		
		if (!isset($field->editable))
			$field->editable = 1;
		$lists['editable'] = JHTML::_('select.booleanlist', 'editable', 'class="inputbox" size="1"', @$field->editable );
		
		$lists['searchable'] = JHTML::_('select.booleanlist', 'searchable', 'class="inputbox" size="1"', @$field->searchable );
		
		$lists['sort'] = JHTML::_('select.booleanlist', 'sort', 'class="inputbox" size="1"', @$field->sort );
		
		$lists['sort_direction'] = JHTML::_('select.genericlist', $sort_direction, 'sort_direction', 'class="inputbox" size="1"', 'value', 'text', @$field->sort_direction );
		
		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox" size="1"', @$field->published );
		
		$this->assignRef('lists',$lists);
		
		$path = JPATH_SITE."/images/com_adsmanager/fields";
		$handle = opendir( $path );
	
		$fieldimages = array();
		while ($file = readdir($handle)) {
			$dir = $path.'/'.$file;
			if (!is_dir($dir))
			{
				if (($file != ".") && ($file != "..")) {
					$fieldimages[] = $file;
				}
			}
		}
		closedir($handle);
		$this->assignRef('fieldimages',$fieldimages);
	}
	
	function _configuration()
	{
		$this->setEditToolbar(JText::_("COM_ADSMANAGER")." - ".JText::_("ADSMANAGER_CONFIGURATION"));
		
		$model = $this->getModel();
		$conf  = $model->getConfiguration();
		$this->assignRef('conf',$conf);
	}
	
	function _tools()
	{
		JToolBarHelper::title(JText::_("COM_ADSMANAGER")." - ".JText::_("Tools"), 'adsmanager' );
	}
	
	function _listfieldimages()
	{
		JToolBarHelper::title(JText::_("COM_ADSMANAGER")." - ".JText::_("ADSMANAGER_FIELD_IMAGES"), 'adsmanager' );
		JToolBarHelper::deleteList();	
		
		$path = JPATH_SITE."/images/com_adsmanager/fields";
		$handle = opendir( $path );
		$fieldimages = array();
		while ($file = readdir($handle)) {
			//$dir = mosPathName( $path.'/'.$file, false );
			$dir = $path.'/'.$file;
			if (!is_dir($dir))
			{
				if (($file != ".") && ($file != "..")) {
				$fieldimages[] = $file;
				}
			}
		}
		closedir($handle);	
	
		$this->assignRef('fieldimages',$fieldimages);
	}
	
	function _listplugins()
	{
		JToolBarHelper::title( JText::_("COM_ADSMANAGER")." - ".JText::_("ADSMANAGER_PLUGINS"), 'adsmanager' );
		JToolBarHelper::deleteList();	
		
		$path = JPATH_SITE."/images/com_adsmanager/plugins/";
		$handle = opendir( $path );
		$plugins = null;
		while ($file = readdir($handle)) {
			//$dir = mosPathName( $path.'/'.$file, false );
			$dir = $path."/".$file;
			
			if (is_dir($dir))
			{
				if (($file != ".") && ($file != "..")) {
					if (!file_exists($path.'/'.$file.'/plug.php')) {
						//rmdir_rf($path);
					} 
					else
						$plugins[] = $file;
				}
			}
		}
		closedir($handle);
		
		$this->assignRef('plugins',$plugins);
	}
	
	function displaySingleCatChooser($ad_id,$conf,$option,$cats,$catid,$itemid="")
	{
		?>
		<script language="JavaScript" type="text/JavaScript">
		<!--
		function jumpmenu(target,obj,restore){
		  eval(target+".location='"+obj.options[obj.selectedIndex].value+"'");	
		  obj.options[obj.selectedIndex].innerHTML="<?php echo JText::_('ADSMANAGER_WAIT');?>";	
		}		
		//-->
		</script>
		<select class='adsmanager_required' name='category_choose' onchange="jumpmenu('parent',this)">
		<?php
			
		 if ((@$ad_id)&&($ad_id != ""))
			$link = "index.php?option=com_adsmanager&c=contents&task=edit&id=$ad_id";
		 else
			$link = "index.php?option=com_adsmanager&c=contents&task=add";
		 if ($catid == 0)
			echo "<option value='#' selected=selected>".JText::_('ADSMANAGER_SELECT_CATEGORY')."</option>";		
		 if (function_exists("selectPaidCategories"))
			selectPaidCategories(0,"",$cats,$catid,$conf->root_allowed,$link,0); 
		else
			$this->selectSingleCategory(0,"",$cats,$catid,$conf->root_allowed,$link,0); 
		?>
		</select>
		<?php 
	}
	
	function displayCatsList($id, $level, $cats,$root_allowed) {
		if (@$cats[$id]) {
			foreach ($cats[$id] as $row) {
				if (($root_allowed == 1)||(!@$cats[$row->id])) {
					?>
					<option value="<?php echo $row->id; ?>">
					<?php echo $level.$row->name; ?>
					</option>
					<?php 
				}
				$this->displayCatsList($row->id, $level.$row->name." >> ", $cats,$root_allowed);
			}
		}
	}
	
	function displaySelectedCatsList($id, $level,$selectedcats, $cats,$root_allowed) {
		if (@$cats[$id]) {
			foreach ($cats[$id] as $row) {
				if (($root_allowed == 1)||(!@$cats[$row->id])) {
					if ((is_array($selectedcats))&&(in_array($row->id,$selectedcats))) {
					?>
					<option value="<?php echo $row->id; ?>">
					<?php echo $level.$row->name; ?>
					</option>
					<?php 
					}
				}
				$this->displaySelectedCatsList($row->id, $level.$row->name." >> ",$selectedcats,$cats,$root_allowed);
			}
		}
	}
	
	function displayMultipleCatsChooser($selectedcats,$cats,$conf,$option,$itemid="")
	{
	?>
	<table width="100%" border="0">
	<tr>
		<td valign="top" width="100">
			<select name="cats" class="inputbox" size="10" style="min-width:100px;" multiple="multiple">
			<?php 
			if (function_exists("displayPaidCatsList"))
				displayPaidCatsList(0,"",$cats,$conf->root_allowed,$this);
			else
				$this->displayCatsList(0,"",$cats,$conf->root_allowed);
			?>
			</select>
			<br />
		</td>
		<td width="2%">
			<input class="button" type="button" value=">>" name="addcat" onclick="addSelectedToList('adminForm','cats','selected_cats')" title="<?php echo JText::_('ADSMANAGER_ADD'); ?>"/>
			<br/>
			<input class="button" type="button" value="<<" name="delcat" onclick="delSelectedFromList('adminForm','selected_cats')" title="<?php echo JText::_('ADSMANAGER_DELETE'); ?>"/>
		</td>
		<td valign="top">	
			<select name="selected_cats" multiple="multiple" class="inputbox" size="10" >
			<?php
			if (function_exists("displayPaidSelectedCatsList"))
				displayPaidSelectedCatsList(0,"",$selectedcats,$cats,$conf->root_allowed,$this);
			else
				$this->displaySelectedCatsList(0,"",$selectedcats,$cats,$conf->root_allowed);
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="3">
		<?php
		if (function_exists("displayPaidCat"))
		{
			displayPaidCat($conf->nbcats); 
		}
		else
		{
			echo sprintf(JText::_('ADSMANAGER_NBCATS_LEGEND'),$conf->nbcats);
		}
		?>
		</td>
	</tr>
	</table>
	<script type="text/javascript">
		/**
		* Adds a select item(s) from one list to another
		*/
		
		var nbmaxcats = <?php echo $conf->nbcats;?>;
		
		function addSelectedToList( frmName, srcListName, tgtListName ) {
			var form = eval( 'document.' + frmName );
			var srcList = eval( 'form.' + srcListName );
			var tgtList = eval( 'form.' + tgtListName );
			var count = 0;

			var srcLen = srcList.length;
			var tgtLen = tgtList.length;
			
			for (var i=0; i < srcLen; i++) {
				if (srcList.options[i].selected) {
					count++;
				}
			}
			if (tgtLen + count > nbmaxcats)
			{
				alert(<?php echo json_encode(JText::_('ADSMANAGER_NBCATS_LIMIT')); ?>);
				return 0;
			}
			var tgt = "x";

			//build array of target items
			for (var i=tgtLen-1; i > -1; i--) {
				tgt += "," + tgtList.options[i].value + ","
			}

			count = 0;
			for (var i=0; i < srcLen; i++) {
				if (srcList.options[i].selected && tgt.indexOf( "," + srcList.options[i].value + "," ) == -1) {
					opt = new Option( srcList.options[i].text, srcList.options[i].value );
					tgtList.options[tgtList.length] = opt;
					count++;
				}
			}
			
			updateFields();
			return count;
		}

		function delSelectedFromList( frmName, srcListName ) {
			var form = eval( 'document.' + frmName );
			var srcList = eval( 'form.' + srcListName );
			var count = 0;
			var srcLen = srcList.length;

			for (var i=srcLen-1; i > -1; i--) {
				if (srcList.options[i].selected) {
					srcList.options[i] = null;
					count++;
				}
			}
			updateFields();
			return count;
		}
	</script>
	<?php
	}
	
	function selectSingleCategory($id, $level, $children,&$catid,$root_allowed,$link,$current_cat_only =0) {
		if (@$children[$id]) {
			foreach ($children[$id] as $row) {
				if (($root_allowed == 1)||(!@$children[$row->id])) {
					?>
					<option value="<?php echo "$link&amp;catid=".$row->id; ?>" <?php if ($row->id == $catid) { echo "selected='selected'"; } ?>>
					<?php echo $level.$row->name; ?>
					</option>
					<?php 
				}
				$this->selectSingleCategory($row->id, $level.$row->name." >> ", $children,$catid,$root_allowed,$link,$current_cat_only);
			}
		}
	}
	
	function selectCategories($id, $level, $children,$catid,$nodisplaycatid,$multiple=0,$catsid="") {
		if (@$children[$id]) {
			foreach ($children[$id] as $row) {
				if ($row->id != $nodisplaycatid) {
					if ((($multiple == 0)&&($row->id != $catid))
					    ||
					    (($multiple == 1)&&(strpos($catsid, ",$row->id,") === false)))
						echo "<option value='".$row->id."'>".$level.$row->name."</option>";
					else
						echo "<option value='".$row->id."' selected>".$level.$row->name."</option>";
					
					$this->selectCategories($row->id, $level.$row->name." >> ", $children,$catid,$nodisplaycatid,$multiple,$catsid);
				}
			}
		}
	}
	
	function displayRequired($state,$url) {
		$app =& JFactory::getApplication();
		if(version_compare(JVERSION,'1.6.0','>=')){
			$templateDir = JURI::base() . 'templates/' . $app->getTemplate().'/images/admin/';
		} else {
			$templateDir = "images/";
		}

		if ($state == 1)
			$return = '<img border="0" alt="Required" src="'.$templateDir.'tick.png">';
		else
			$return = '<img border="0" alt="Not Required" src="'.$templateDir.'publish_x.png">';
		$return = "<a href='$url'>".$return."</a>";
		return $return;
	}
}