//
//  AppDelegate.m
//  NiMobile
//
//  Created by zhu clude on 4/28/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "AppDelegate.h"

#import "MainShakerViewController.h"
#import "MainNearByViewController.h"
#import "MainMyFavViewController.h" 
#import "MainSearchViewController.h"
#import "MainSettingViewController.h"
#import "MainAuthViewController.h"

#import "FavMemberViewController.h"
#import "FavCompanyViewController.h"

@implementation AppDelegate

- (void)dealloc
{
    [_window release];
    [_tabBarController release];
    [super dealloc];
}

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
    // support shake action
    application.applicationSupportsShakeToEdit = YES;
    
    // Override point for customization after application launch.
	window = [[UIWindow alloc] initWithFrame:[[UIScreen mainScreen] bounds]];
	[window setBackgroundColor:[NiConstants colorWithKey:@"222222"]];
    
	tabBar = [[TabBarView alloc] initWithDefaultFrame];
	[tabBar setDelegate:self];
	
	//_sessionDataController = [[SessionDataController alloc] init];
	
	[[TrafficCop sharedInstance] setVerboseLoggingEnabled:YES];
	
	nvcShaker  = [[UINavigationController alloc] initWithRootViewController:[[MainShakerViewController alloc] initWithTabBar]];
	[[nvcShaker navigationBar] setTintColor:[NiConstants colorWithKey:kNavBarColor]];
    
    nvcNearby  = [[UINavigationController alloc] initWithRootViewController:[[MainNearByViewController alloc] initWithTabBar]];
	[[nvcNearby navigationBar] setTintColor:[NiConstants colorWithKey:kNavBarColor]];
    
    nvcMyFavourite  = [[UINavigationController alloc] initWithRootViewController:[[MainMyFavViewController alloc] initWithTabBar]];

	[[nvcMyFavourite navigationBar] setTintColor:[NiConstants colorWithKey:kNavBarColor]];
    
    nvcSearch = [[UINavigationController alloc] initWithRootViewController:[[MainSearchViewController alloc] initWithTabBar]];
    [[nvcSearch navigationBar] setTintColor:[NiConstants colorWithKey:kNavBarColor]];
    
    nvcSetting = [[UINavigationController alloc] initWithRootViewController:[[MainSettingViewController alloc] initWithTabBar]];
    [[nvcSetting navigationBar] setTintColor:[NiConstants colorWithKey:kNavBarColor]];
    	
	activeNavController = nvcShaker;

	[window addSubview:[nvcShaker view]];
	[window addSubview:tabBar];
    
    // show login fiew when app strted
    vcAuthMain = [[MainAuthViewController alloc] initWithNibName:nil bundle:nil];
    nvcAuth = [[UINavigationController alloc] initWithRootViewController:vcAuthMain];
    [[nvcAuth navigationBar] setTintColor:[NiConstants colorWithKey:kNavBarColor]];
    [window addSubview:[nvcAuth view]];
	
	[window setBackgroundColor:[UIColor lightGrayColor]];
	[window makeKeyAndVisible];
	
	_defaultPngToFade = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"Default.png"]];
	[window addSubview:_defaultPngToFade];
	[UIView beginAnimations:nil context:nil];
	[UIView setAnimationDelegate:self];
	[UIView setAnimationDidStopSelector:@selector(completedFadingDefaultPng:finished:context:)];
	[UIView setAnimationDuration:.4];
	[_defaultPngToFade setAlpha:0];
	[UIView commitAnimations];
    

//    [self.window makeKeyAndVisible];
    return YES;
}

- (void)applicationWillResignActive:(UIApplication *)application
{
    // Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
    // Use this method to pause ongoing tasks, disable timers, and throttle down OpenGL ES frame rates. Games should use this method to pause the game.
}

- (void)applicationDidEnterBackground:(UIApplication *)application
{
    // Use this method to release shared resources, save user data, invalidate timers, and store enough application state information to restore your application to its current state in case it is terminated later. 
    // If your application supports background execution, this method is called instead of applicationWillTerminate: when the user quits.
}

- (void)applicationWillEnterForeground:(UIApplication *)application
{
    // Called as part of the transition from the background to the inactive state; here you can undo many of the changes made on entering the background.
}

- (void)applicationDidBecomeActive:(UIApplication *)application
{
    // Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
}

- (void)applicationWillTerminate:(UIApplication *)application
{
    // Called when the application is about to terminate. Save data if appropriate. See also applicationDidEnterBackground:.
}

/*
// Optional UITabBarControllerDelegate method.
- (void)tabBarController:(UITabBarController *)tabBarController didSelectViewController:(UIViewController *)viewController
{
}
*/

/*
// Optional UITabBarControllerDelegate method.
- (void)tabBarController:(UITabBarController *)tabBarController didEndCustomizingViewControllers:(NSArray *)viewControllers changed:(BOOL)changed
{
}
*/


- (void)completedFadingDefaultPng:(NSString *)animationID finished:(BOOL)finished context:(void *)context {
	[_defaultPngToFade removeFromSuperview];
	[_defaultPngToFade release];
}

- (NSString *)fullPathForAPIwithGroup:(NSString *)group andMethod:(NSString *)method
{
    
	//NSString *baseURL = [[NSUserDefaults standardUserDefaults] stringForKey:kBaseURLDevelopment];
	
	//Add logic to switch between Dev and Production
    return [NSString stringWithFormat:@"%@/%@/%@.api", self.basePathForZeccoAPIs, group, method];
	//return [NSString stringWithFormat:@"%@/%@/%@.api", kBaseURLDevelopment, group, method];
    //return [NSString stringWithFormat:@"%@/%@/%@.api", kBaseURLProduction, group, method];
    
}
- (void)selectTab:(NSString *)tabName
{
	[tabBar selectTabNamed:tabName];
}

- (void)setLoginViewHidden:(BOOL)hidden
{
	if(hidden)
	{
		if([[nvcAuth view] superview])
		{
			[[nvcAuth view] removeFromSuperview];
			[window addSubview:[activeNavController view]];
			[window addSubview:tabBar];
            
		}
	}
	else
	{
        if([[activeNavController view] superview])
		{
            [[activeNavController view] removeFromSuperview];
            [window addSubview:[vcAuthMain view]];
        }
	}
	
}

#pragma mark TabBarViewDelegate methods
- (void)tabBarButtonTapped:(NSString *)name
{
    
    UINavigationController *newNavController = nil;
	//NSError *error;
	if([name isEqualToString:kTabBarButtonNameShaker])
	{
		newNavController = nvcShaker;
	}
    else if([name isEqualToString:kTabBarButtonNameNearBy])
    {
        newNavController = nvcNearby;
    }
	else if([name isEqualToString:kTabBarButtonNameMyFav])
	{
		newNavController = nvcMyFavourite;
	}
	else if([name isEqualToString:kTabBarButtonNameSearch])
	{
		newNavController = nvcSearch;
	}
	else if([name isEqualToString:kTabBarButtonNameSetting])
	{
		newNavController = nvcSetting;
	}

    
    [[activeNavController view] removeFromSuperview];
	
	[window addSubview:[newNavController view]];
	[window addSubview:tabBar];
	
	activeNavController = newNavController;
}
- (void)activeTabBarButtonTapped
{
	[activeNavController popToRootViewControllerAnimated:TRUE];
}

- (void)setTabBarHidden:(BOOL)hidden{
    if (tabBar.window) {
        [tabBar setHidden:hidden];
    }
}

@end
