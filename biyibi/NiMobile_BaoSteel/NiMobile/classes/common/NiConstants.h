//
//  NiConstants.h
//  NiMobile
//
//  Created by zhu clude on 4/28/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "WSODConstants.h"

//API
#define kBaseURLDevelopment				@"http://203.166.177.116/api"
#define kBaseURLProduction				@"http://203.166.177.116/api"
#define kBaseURL                        @"http://203.166.177.116/api"


// APIs

#define kWSODQuotesAPI			@"quotes/quote_api.asp?outputFormat=JSON&"
#define kWSODSymbolSearchAPI	@"symbols/search_api.asp?outputFormat=JSON&"
#define kWSODMarketsAPI			@"markets/markets_api.asp?outputFormat=JSON&"
#define kWSODStockAPI			@"stock/stock_api.asp?outputFormat=JSON&"
#define kWSODChartsAPI			@"charts/charts_api.asp"
#define kWSODAlertsAPI			@"alerts/alerts_api.asp?outputFormat=JSON&"
#define kWSODOptionsAPI			@"options/options_api.asp?outputFormat=JSON&"

// Settings keys								**********
#define kSettingsAPIEnvKey						@"Settings.API_Environment"  // Used with the settings bundle in ad-hoc releases
#define kSettingsBuildKey						@"Settings.Build_Version"  // Used with the settings bundle in ad-hoc releases
#define kSettingsRTStreamingEnabled				@"Settings.RT_Streaming_Enabled"  // Used by the in-app settings dialog
#define kSettingsRememberMeEnabled				@"Settings.RememberMe_Enabled"  // Used by the in-app settings dialog
#define kAppSettingsEQChartSettings             @"AppSettings.ChartSettings.EQ"
#define kAppSettingsMFChartSettings             @"AppSettings.ChartSettings.MF"
#define kAppSettingsINChartSettings             @"AppSettings.ChartSettings.IN"
#define kAppSettingsMarketSettings              @"AppSettings.MarketSettings"
#define kAppSettingsAccountSettings             @"AppSettings.AccountSettings"
// Settings notifications						**********
#define kStreamingUpdateNotification			@"Notification.RTStreamingSettingChanged"

//measurements
#define kTabBarHeight	50
#define kStatusBarHeight	20
#define kNavigationBarHeight	44
#define kNavigationTabBarHeight   27

// App position tracking keys
#define kLastMainTab							@"MainTabTracker"

//Authentication
#define kAuthenticationSuccessful				@"AuthenticationSuccessfulNotification"
#define kSignoutNotification					@"SignoutNotification"
#define kRememberMeKey							@"RememberMe"
#define kKeepMeSignIn							@"KeepMeSignIn"
//#define kAuthenticationTokenKey					@"Zecco.AuthToken"
#define kLastActiveTimeKey						@"Zecco.LastActiveTime"

//Authentication SFHFKeychainUtils keys
#define kUsernameKeychainKey                    @"Zecco.UsernameKey"
#define kAuthenticationKeychainKey              @"Zecco.AuthenticationKey"
#define kAuthenticationServiceName              @"Zecco"

// Colors
#define kDefaultBackground		@"222222"
#define kNavBarColor			@"303030"
#define kPositiveGreenColor		@"41B574"
#define kNegativeRedColor		@"EB0A5E"
#define kPurpleColor            @"AA5FB3"
#define kBlueColor              @"0E448D"
#define kTabBackgroundColor		@"343434"
#define kTabBackgroundDarkColor @"212121"
#define kTabHeaderColor			@"FFFFFF"
#define kLightTableLineColor	@"525252"
#define kDarkRowColor			@"222222"
#define kDarkRowSelected		@"1A1A1A"
#define kDarkTableLineColor		@"353535"
#define kTableLabelColor		@"999999"
#define kPinkArrowColor			@"E90A8D"

//User Defaults
//#define kMarketMoversLastSelected	@"MarketMoversType.LastSelected"
#define	kRecentSymbols				@"RecentSymbols"

// TabBarButton names
#define kTabBarButtonNameShaker     @"Shaker"
#define kTabBarButtonNameNearBy     @"NearBy"
#define kTabBarButtonNameMyFav      @"MyFav"
#define kTabBarButtonNameSearch		@"Search"
#define kTabBarButtonNameSetting	@"Setting"


//Markets sub tab title
#define kMarketsIndicesTitle		@"Indices"
#define kMarketsMoversTitle			@"Market Movers"
#define kMarketsNewsTitle			@"Market News"

//Quote sub tab title
#define kQuotesMoversTitle          @"Market Movers"
#define kQuotesNewsTitle            @"News"
#define kQuotesChartTitle           @"Chart"
#define kQuotesOptionsTitle         @"Options"
#define kQuotesCommunityTitle       @"Community"
#define kQuotesProfileTitle         @"Profile"
#define kQuotesPortfolioTitle       @"Portfolio"

// Alert titles
#define kAlertTitleError            @"Error"
#define kAlertTitleWarning          @"Warning"

// Zecco homepage
#define kZeccoHomepageUrl			@"http://www.zecco.com/"

// 3DES key for encrypt / descrypt sharke cookie which using for retrieving realtime quote
#define k3DESPrivateKeyForSharedCookie  @"It8GP2c7CbWzHUlzkO0gwj84"
#define k3DESPublicKeyForSharedCookie   @"Ib0GJYX7CbezHHlzLg0gwj59"

// Rates My App
#define kIsRatesMyAppEnabled            YES

// Enable WSOD COOKIE Authorization
#define kIsEnableCookieAuthorization    YES

#define kSecureUDIDKey              @"SuperSecureCode:O_o"
#define DEFAULT_FONT_NAME       @"HelveticaNeue"
#define DEFAULT_BOLD_FONT_NAME  @"HelveticaNeue-Bold"

@interface NiConstants : WSODConstants

@end
