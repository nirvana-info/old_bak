var Dashboard = {
	activeRecentOrdersRequest: false,

	Init: function()
	{
		if($('.DashboardPanelHelpArticles').css('display') != 'none') {
			$('#HelpArticlesList').load('index.php?ToDo=HelpRSS');
		}

		$('.DashboardPanelGettingStarted .ToggleLink, .DashboardPanelOverview .ToggleLink').click(function() {
			if($('.DashboardPanelGettingStarted:hidden').length == 0) {
				var mode = 'overview';
				var hide = '.DashboardPanelGettingStarted';
				var show = '.DashboardPanelOverview';
			}
			else {
				var mode = 'gettingstarted';
				var hide = '.DashboardPanelOverview';
				var show = '.DashboardPanelGettingStarted';
			}
			SetCookie('DashboardMode', mode, 365);
			$(hide).hide();
			$(show).show();
		});

		$('.DashboardPanelContentHelpUsing .DashboardHideThis').click(function() {
			$('.DashboardPanelContentHelpUsing').fadeOut('normal');
		});

		$('.DashboardRecentOrdersToggle li a').click(function() {
			if(Dashboard.activeRecentOrdersRequest) {
				return;
			}
			$('.DashboardRecentOrdersToggle li.Active').removeClass('Active');
			$(this).blur();
			$(this).css('width', $(this).width()+'px');
			$(this).parent('li').addClass('Active');
			$(this).addClass('Loading');
			link = this;
			args = $(this).attr('rel');
			Dashboard.activeRecentOrdersRequest = true;
			$('.DashboardRecentOrderList').load('remote.php?remoteSection=dashboard&w=LoadRecentOrders&'+args, '', function() {
				$(link).removeClass('Loading').css('width', '');
				Dashboard.activeRecentOrdersRequest = false;
			});
			return false;
		});

		$('.DashboardPerformanceIndicatorsPeriodButton .Buttons a').click(function() {
			$('.DashboardPerformanceIndicatorsPeriodButton .Buttons a.Active').removeClass('Active');
			$(this).addClass('Active');
			link = this;
			args = $(this).attr('rel');
			indicator = LoadingIndicator.Show({background: '#fff', parent: '#DashboardPerformanceIndicators'});
			$('#DashboardPerformanceIndicators').load('remote.php?remoteSection=dashboard&w=GetPerformanceIndicators&'+args, '', function() {
				LoadingIndicator.Destroy(indicator);
			});
			return false;
		});

		$('#DashboardVersionCheck .HideLink').click(function() {
			period = $(this).attr('rel');
			if(period == undefined) {
				period = '';
			}
			Dashboard.HideVersionCheckMessage(period);
		});

		$('.DashboardHelpArticlesSearchForm').submit(function() {
			if($('#DashboardHelpSearchQuery').val() == '') {
				alert('Please enter a search term.');
				$('#DashboardHelpSearchQuery').focus();
				return false;
			}

			searchUrl = $(this).attr('action').replace('%query%', escape($('#DashboardHelpSearchQuery').val()));
			window.open(searchUrl, 'help', 'width=650, height=550, left='+(screen.availWidth-700)+', top=100');
			return false;
		});

		$('#DashboardHelpSearchQuery')
			.focus(function() {
				$(this).removeClass('DashboardHelpSearchHasImage');
			})
			.blur(function() {
				if(!$(this).val()) {
					$(this).addClass('DashboardHelpSearchHasImage');
				}
			})
			.keypress(function(e) {
				if(e.keyCode == 14) {
					return $('.DashboardHelpArticlesSearchForm').submit();
				}
			})
		;

		$('.DashboardHelpArticlesSearchForm .DashboardActionButton').click(function() {
			$('.DashboardHelpArticlesSearchForm').submit();
			return false;
		});
	},

	versionCheckAttempts: 30,

	CheckLatestVersion: function()
	{
		// If the version details haven't loaded, carry on
		if(latest_version == undefined || latest_version == '') {
			--Dashboard.versionCheckAttempts;
			if(versionCheckAttempts >= 0) {
				window.setTimeout(Dashboard.CheckLatestVersion, 150);
			}
			return;
		}

		// New version doesn't match the current version we're running
		if(latest_version != $('.DashboardVersionCheck .LatestVersionNumber').html()) {
			// Version checking has been disabled, return.
			if($('#DashboardVersionCheck').length == 0) {
				return;
			}

			// Update the version message
			$('#DashboardVersionCheck .LatestVersionNumber').html(latest_version);

			// Show the message
			$('#DashboardVersionCheck').show('fast');
		}
	},

	HideVersionCheckMessage: function(period)
	{
		if(period == undefined || period == 0) {
			var period = 365;
		}
		SetCookie('HideVersionCheck', $('#DashboardVersionCheck .LatestVersionNumber').html(), period);
		$('#DashboardVersionCheck').hide('fast');
	}
};

$(document).ready(function() {
	Dashboard.Init();
});