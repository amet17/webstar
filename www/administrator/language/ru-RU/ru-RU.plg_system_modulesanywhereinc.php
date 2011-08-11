<?php
/**
 * Language Include File (Russian)
 * Can overrule set variables used in different elements
 *
 * @package     Modules Anywhere
 * @version     1.9.2
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @translation FarFor <serg.farfor@gmail.com>
 */

// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );

/**
 * Variables that can be overruled:
 * $image
 * $title
 * $description
 * $help
 */

$description = '
	<p>Легко вставляйте модули куда угодно в Ваш сайт.</p>
	<p>Вы можете вставить модули, используя синтаксис:<br />
	Используя имя модуля: {<span style="color:green">module <span style="color:blue">Main Menu</span></span>}<br />
	Используя идентификатор id модуля: {<span style="color:green">module <span style="color:blue">3</span></span>}</p>
	<p>Вы также можете поместить полные позиции модуля, используя синтаксис:<br />
	{<span style="color:green">modulepos <span style="color:blue">mainmenu</span></span>}</p>
	<p>Чтобы использовать другой стиль чем по умолчанию, Вы можете сделать это:<br />
	{<span style="color:green">module <span style="color:blue">Main Menu</span>|<span style="color:blue">horz</span></span>}<br />
	Вы можете выбрать из: table, horz, xhtml, rounded, none (и любой дополнительный стиль, который Ваш шаблон поддерживает).</p>
';