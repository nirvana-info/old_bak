//
//  TabViewController.h
//  Zecco
//
//  Created by sirish.jetti on 9/2/10.
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import <UIKit/UIKit.h>

@class AppDelegate;
@class NiLoadingView;

@interface BaseViewController : UIViewController {
	AppDelegate *_appDelegate;  //weak
	
	NiLoadingView *_loadingView;
	
	
}

- (id) init;
- (void)showLoadingViewWithMessage:(NSString *)message;
- (void)hideLoadingView;
- (BOOL)doSupportShakeActon;
- (void)didWhenShakeActionEnded;
- (void)setTabBarHidden:(BOOL)isHidden;

@end


