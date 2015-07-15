//
//  TabBarView.h
//  Zecco
//
//  Created by sirish.jetti on 9/13/10.
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import <UIKit/UIKit.h>
@class TabBarButton;

@protocol TabBarViewDelegate;

@interface TabBarView : UIView {
	
	NSString *_selectedButton;
	NSObject<TabBarViewDelegate> *_delegate;
	
	TabBarButton*	_currentTab;		// Pointers, not retained.
	TabBarButton*	_buttonShaker;
    TabBarButton*   _buttonNearBy;
	TabBarButton*	_buttonMyFav;
	TabBarButton*	_buttonSearch;
	TabBarButton*	_buttonSetting;
}
@property (assign) NSObject<TabBarViewDelegate> *delegate;
@property (nonatomic, retain) TabBarButton* currentTab;
-(id) initWithDefaultFrame;

- (void) selectTabNamed:(NSString*)name;

@end


@protocol TabBarViewDelegate
- (void)tabBarButtonTapped:(NSString *)name;
- (void)activeTabBarButtonTapped;
@end