/**
 * SEF module for Joomla!
 * 
 * @author $Author: shumisha $
 * @copyright Yannick Gaultier - 2007-2010
 * @package sh404SEF-15
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version $Id: notfound.js 1762 2011-02-01 12:59:44Z silianacom-svn $
 */

function shAjaxHandler(task, options, closewindow) {

	var form = $('adminForm');
	form.task.value = task;
	form.format.value = "raw";

	// Create a progress indicator
	var update = $("sh-message-box").empty();
	update.setHTML("<div class='sh-ajax-loading'>&nbsp;</div>");
	$("sh-error-box").empty();

	// Set the options of the form"s Request handler.
	options.onComplete = function(response, responseXML) {
		var root, status, message;
		try {
			root = responseXML.documentElement;
			status = root.getElementsByTagName("status").item(0).firstChild.nodeValue;
			message = root.getElementsByTagName("message").item(0).firstChild.nodeValue;
		} catch (err) {
			status = 'failure';
			message = "<div id='error-box-content'><ul><li>Sorry, something went wrong on the server while performing this action. Please retry or cancel</li></ul></div>";
		}

		// remove progress indicator
		var update = $("sh-message-box").empty();

		// insert results
		if (status == "success") {
			update.setHTML(message);
			if (closewindow) {
				setTimeout("parent.SqueezeBox.close()", 1500);
			} else {
				setTimeout("$('sh-message-box').empty()", 3000);
			}
		} else if (status == 'redirect') {
			setTimeout("parent.window.location='" + message + "';", 100);
			parent.shReloadModal = false;
			parent.SqueezeBox.close();
		} else {
			$('sh-error-box').setHTML(message);
			setTimeout("$('sh-error-box').empty();", 5000);
		}

	};

	// Send the form.
	form.send(options);
}

function shStopEvent(event) {

	// cancel the event
	new Event(event).stop();

}

function submitbutton(pressbutton) {
	if (pressbutton == "cancelPopup") {
		parent.shReloadModal = false;
		parent.SqueezeBox.close();
	} else if (pressbutton == "backPopup") {
		parent.shReloadModal = true;
		parent.SqueezeBox.close();
	} else {
		if (pressbutton == "selectnfredirect") {
			parent.shReloadModal = true;
		}
		if (pressbutton) {
			document.adminForm.task.value = pressbutton;
		}
		if (typeof document.adminForm.onsubmit == "function") {
			document.adminForm.onsubmit();
		}
		document.adminForm.submit();
	}
}

function listItemAjaxTask(id, task, options, closewindow) {
	var f = document.adminForm;
	cb = eval('f.' + id);
	if (cb) {
		for (i = 0; true; i++) {
			cbx = eval('f.cb' + i);
			if (!cbx)
				break;
			cbx.checked = false;
		} // for
		cb.checked = true;
		f.boxchecked.value = 1;
		shAjaxHandler(task, options, closewindow);
	}
	return false;
}
