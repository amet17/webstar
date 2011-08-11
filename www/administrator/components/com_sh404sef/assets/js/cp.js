/**
 * SEF module for Joomla!
 * 
 * @author $Author: shumisha $
 * @copyright Yannick Gaultier - 2007-2010
 * @package sh404SEF-15
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version $Id: cp.js 1559 2010-08-23 10:01:15Z silianacom-svn $
 */

var shQuickControlNeedsUpdate = false;
var shAnalyticsCompletedRequestsList = false;
var shAnalyticsProgress = null;
var shAnalyticsOptions = null;

function shSetupQuickControl() {
	var url = "index.php?option=com_sh404sef&c=config&view=config&layout=qcontrol&format=raw&tmpl=component&noMsg=1";
	new Ajax(url, {
		method : 'get',
		onComplete : function(response) {
			shUpdateQuickControl(response);
		}
	}).request();
}

function shUpdateQuickControl(response) {

	$('qcontrolcontent').setHTML(response);
	var AnalyticsTooltips = new Tips($$('.hasTip'), {
		maxTitleChars : 50,
		fixed : false
	});
	setTimeout("$('sh-message-box').empty()", 3000);
	setTimeout("$('sh-error-box').empty()", 5000);

}

function shSetupSecStats(task) {
	task = task ? task : 'showsecstats';
	var url = "index.php?option=com_sh404sef&task=" + task
			+ "&layout=secstats&format=raw&tmpl=component&noMsg=1";
	var update = $("sh-progress-cpprogress").empty();
	update.setHTML("<div class='sh-ajax-loading'>&nbsp;</div>");
	new Ajax(url, {
		method : 'get',
		onComplete : function(response) {
			update.empty();
			shUpdateSecStats(response);
		}
	}).request();
}

function shUpdateSecStats(response) {

	$('secstatscontent').setHTML(response);
	setTimeout("$('sh-message-box').empty()", 3000);
	setTimeout("$('sh-error-box').empty()", 5000);

}

function shSetupUpdates(forced) {
	forced = forced ? "forced=1" : 'forced=0';
	var url = "index.php?option=com_sh404sef&task=showupdates&layout=updates&format=raw&tmpl=component&noMsg=1&"
			+ forced;
	var update = $("sh-progress-cpprogress").empty();
	update.setHTML("<div class='sh-ajax-loading'>&nbsp;</div>");
	new Ajax(url, {
		method : 'get',
		onComplete : function(response) {
			update.empty();
			shUpdateUpdates(response);
		}
	}).request();
}

function shUpdateUpdates(response) {

	$('updatescontent').setHTML(response);
	setTimeout("$('sh-message-box').empty()", 3000);
	setTimeout("$('sh-error-box').empty()", 5000);

}

function shAnalyticsRequestCompleted(req) {

	shAnalyticsCompletedRequestsList.set(req, true);
	completed = true;
	shAnalyticsCompletedRequestsList.each(function(value, key) {
		completed = completed && value;
	});
	if (completed) {
		shAnalyticsProgress.empty();
		setTimeout('shRefreshTooltips();', 250);
	}

}

function shRefreshTooltips() {
	var AnalyticsTooltips = new Tips($$('.hasAnalyticsTip'), {
		maxTitleChars : 50,
		fixed : false
	});
}

function shSetupAnalytics(options) {

	shAnalyticsOptions = options || {};

	shAnalyticsProgress = $("sh-progress-analyticsprogress");
	shAnalyticsProgress.setHTML("<div class='sh-ajax-loading'>&nbsp;</div>");

	var defaultOptions = {
		forced : 0,
		showFilters : 'yes',
		accountId : '',
		groupBy : '',
		startDate : '',
		endDate : '',
		cpWidth : 0,
		report : 'dashboard',
		subrequest : 'visits'
	};

	forced = "forced="
			+ (shAnalyticsOptions.forced ? shAnalyticsOptions.forced
					: defaultOptions.forced);
	showFilters = "&showFilters="
			+ (shAnalyticsOptions.showFilters ? shAnalyticsOptions.showFilters
					: defaultOptions.showFilters);

	// is account Id selected by user ?
	var accountIdEl = $('accountId');
	accountId = accountIdEl ? "&accountId=" + accountIdEl.value
			: defaultOptions.accountId;
	var startDateEl = $('startDate');
	startDate = startDateEl ? "&startDate=" + startDateEl.value
			: defaultOptions.startDate;
	var endDateEl = $('endDate');
	endDate = endDateEl ? "&endDate=" + endDateEl.value
			: defaultOptions.endDate;
	var reportEl = $('report');
	report = "&report=" + (reportEl ? reportEl.value : defaultOptions.report);
	var groupByEl = $('groupBy');
	groupBy = "&groupBy="
			+ (groupByEl ? groupByEl.value : defaultOptions.groupBy);
	var cpEl = $('left');
	cpEl = cpEl || $('sh404sef-analytics-wrapper');
	cpWidth = "&cpWidth=" + (cpEl ? cpEl.offsetWidth : defaultOptions.cpWidth);
	shAnalyticsOptions.url = "index.php?option=com_sh404sef&view=analytics&format=raw&tmpl=component&noMsg=1&"
			+ forced
			+ showFilters
			+ report
			+ accountId
			+ groupBy
			+ cpWidth
			+ startDate + endDate;

	shAnalyticsCompletedRequestsList = new Hash( {
		'headers' : false,
		'visits' : false,
		'sources' : false,
		'global' : false,
		'perf' : false,
		'top5urls' : false,
		'top5referrers' : false
	});

	// don't empty headers!
	shAnalyticsCompletedRequestsList.each(function(value, key) {
		if (key != "headers") {
			$("analyticscontent_" + key).empty();
		}
	});

	_shPerformAnalyticsSubRequest('headers');
	_shPerformAnalyticsSubRequest('visits');

	for ( var i = 1; i < 6; i++) {
		setTimeout('shContinueAnalytics' + i + '();', 300 * i);
	}

}

function shContinueAnalytics1() {

	_shPerformAnalyticsSubRequest('sources');

}

function shContinueAnalytics2() {

	_shPerformAnalyticsSubRequest('global');
}

function shContinueAnalytics3() {

	_shPerformAnalyticsSubRequest('perf');

}

function shContinueAnalytics4() {

	_shPerformAnalyticsSubRequest('top5urls');

}

function shContinueAnalytics5() {

	_shPerformAnalyticsSubRequest('top5referrers');
}

function _shPerformAnalyticsSubRequest(subrequestname) {

	new Ajax(shAnalyticsOptions.url + '&subrequest=' + subrequestname, {
		method : 'get',
		onComplete : function(response) {
			shAnalyticsRequestCompleted(subrequestname);
			shUpdateAnalytics(response, subrequestname);
		}
	}).request();
}

function shUpdateAnalytics(response, subrequest) {

	$('analyticscontent_' + subrequest).setHTML(response);
	id = $('startDate');
	if (id) {
		Calendar.setup( {
			inputField : "startDate", // id of the input field
			ifFormat : "%Y-%m-%d", // format of the input field
			button : "startDate_img", // trigger for the calendar (button ID)
			align : "Bl", // alignment (defaults to "Bl")
			singleClick : true
		});
		Calendar.setup( {
			inputField : "endDate", // id of the input field
			ifFormat : "%Y-%m-%d", // format of the input field
			button : "endDate_img", // trigger for the calendar (button ID)
			align : "Tl", // alignment (defaults to "Bl")
			singleClick : true
		});
	}
	setTimeout("$('sh-message-box').empty()", 3000);
	setTimeout("$('sh-error-box').empty()", 5000);

}

function shSubmitQuickControl(event) {

	// cancel the event
	new Event(event).stop();

	var form = $('adminForm');

	// Create a progress indicator
	var update = $("sh-progress-cpprogress").empty();
	update.setHTML("<div class='sh-ajax-loading'>&nbsp;</div>");
	$("sh-error-box").empty();

	// Set the options of the form"s Request handler.
	var options = {};
	options.onComplete = function(response) {
		var message;
		// alert(response);
		message = "<div id='error-box-content'><ul><li>Sorry, something went wrong on the server while performing this action. Please try again or contact administrator</li></ul></div>";

		// remove progress indicator
		var update = $("sh-progress-cpprogress").empty();

		// insert results
		shUpdateQuickControl(response)

	};

	// Send the form.
	form.send(options);

}
