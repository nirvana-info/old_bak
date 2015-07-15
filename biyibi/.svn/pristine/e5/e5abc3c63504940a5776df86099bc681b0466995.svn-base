//
//  AppDelegate.h
//  NiMobile
//
//  Created by zhu clude on 4/28/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "TabBarView.h"
#import "TrafficCop.h"

@class MainAuthViewController;

@interface AppDelegate : UIResponder <UIApplicationDelegate,TabBarViewDelegate,TrafficCopCaller> {
    UIWindow *window;
	TabBarView *tabBar;
	
	UIImageView *_defaultPngToFade;
	
	UINavigationController *nvcShaker;
	UINavigationController *nvcNearby;
    UINavigationController *nvcMyFavourite;
	UINavigationController *nvcSearch;
	UINavigationController *nvcSetting;
    
    UINavigationController *activeNavController;
    
    
    MainAuthViewController *vcAuthMain;
    UINavigationController *nvcAuth;;
	
	//LoginViewController *_loginViewController;
	//SessionDataController *_sessionDataController;
	
	NSString *_basePathForWSODAPIs;
	NSData *_deviceToken;
    NSString *_basePathForZeccoAPIs;
    
}

@property (strong, nonatomic) UIWindow *window;

@property (strong, nonatomic) UITabBarController *tabBarController;


@property (nonatomic, retain) NSString *basePathForWSODAPIs;
@property (nonatomic, retain) NSString *basePathForZeccoAPIs;

- (void)configureSettings;
- (NSString *)fullPathForAPIwithGroup:(NSString *)group andMethod:(NSString *)method;
- (NSString *)fullPathForWSODAPI:(NSString *)api;
- (CGFloat)screenScaleFactor;
- (void)selectTab:(NSString *)tabName;
- (void)setLoginViewHidden:(BOOL)hidden;
- (void)setupUserForPushNotification;
- (void)showNetworkUnavailableAlert;
- (void)showInformationalAlertWithTitle:(NSString *)title andMessage:(NSString *)message;

- (void)setTabBarHidden:(BOOL)hidden;

@end
