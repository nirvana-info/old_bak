//
//  TabBarView.m
//  Zecco
//
//  Created by sirish.jetti on 9/13/10.
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import "TabBarView.h"
#import "TabBarButton.h"

@interface TabBarView ()

- (TabBarButton*) tabWithName:(NSString*)name;
- (void) selectTab:(TabBarButton*)newTab;
- (void) buttonSelected:(TabBarButton *)newTab;

@end

@implementation TabBarView

@synthesize delegate = _delegate;
@synthesize currentTab = _currentTab;

#pragma mark -
#pragma mark Application lifecycle

- (id)initWithFrame:(CGRect)frame {
    if ((self = [super initWithFrame:frame])) {
        // Initialization code		
	}
    return self;
}
- (id) initWithDefaultFrame {
	
	
	CGRect frame = CGRectMake(0, 480 - kTabBarHeight, 320, kTabBarHeight);
	
	if ((self = [super initWithFrame:frame])) {
        // Initialization code
		//[self setBackgroundColor:[UIColor blackColor]];
        self.backgroundColor = [UIColor colorWithPatternImage:[UIImage imageNamed:@"tab_bg.png"]];
		
				
		float padding_l = 10.0;
        //[button addTarget:self action:@selector(buttonTapped) forControlEvents:UIControlEventTouchUpInside];
        // the first and last tab's width is 54, other tab's width is 53
        float tWidth = ( 320.00 - 2*padding_l ) / 5;
		_buttonShaker    = [[TabBarButton alloc] initWithFrame:CGRectMake(padding_l + 0.00*tWidth, 0, tWidth, kTabBarHeight) andName:kTabBarButtonNameShaker];
        _buttonNearBy        = [[TabBarButton alloc] initWithFrame:CGRectMake(1.00*tWidth+padding_l, 0, tWidth, kTabBarHeight) andName:kTabBarButtonNameNearBy];
		_buttonMyFav		= [[TabBarButton alloc] initWithFrame:CGRectMake(2.00*tWidth+padding_l, 0, tWidth, kTabBarHeight) andName:kTabBarButtonNameMyFav];
		_buttonSearch		= [[TabBarButton alloc] initWithFrame:CGRectMake(3.00*tWidth+padding_l, 0, tWidth, kTabBarHeight) andName:kTabBarButtonNameSearch];
		_buttonSetting		= [[TabBarButton alloc] initWithFrame:CGRectMake(4.00*tWidth+padding_l, 0, tWidth, kTabBarHeight) andName:kTabBarButtonNameSetting];

		
		[_buttonShaker	addTarget:self action:@selector(buttonSelected:) forControlEvents:UIControlEventTouchUpInside];
        [_buttonNearBy       addTarget:self action:@selector(buttonSelected:) forControlEvents:UIControlEventTouchUpInside];
		[_buttonMyFav		addTarget:self action:@selector(buttonSelected:) forControlEvents:UIControlEventTouchUpInside];
		[_buttonSearch		addTarget:self action:@selector(buttonSelected:) forControlEvents:UIControlEventTouchUpInside];
		[_buttonSetting		addTarget:self action:@selector(buttonSelected:) forControlEvents:UIControlEventTouchUpInside];

        
		[self addSubview:_buttonShaker];
        [self addSubview:_buttonNearBy];
		[self addSubview:_buttonMyFav];
		[self addSubview:_buttonSearch];
		[self addSubview:_buttonSetting];
		
		[self selectTab:_buttonShaker];		
	}
	
    return self;
}
/*
 // Only override drawRect: if you perform custom drawing.
 // An empty implementation adversely affects performance during animation.
 - (void)drawRect:(CGRect)rect {
 // Drawing code
 }
 */

- (void) buttonSelected:(TabBarButton *)newTab
{
    //GATrack
    //[GATracker bottomNavClicked:newTab.name];
    [self selectTab:newTab];
}

- (TabBarButton*) tabWithName:(NSString*)name
{
	if([name isEqualToString:kTabBarButtonNameShaker])
	{
		return _buttonShaker;		
	}
    else if([name isEqualToString:kTabBarButtonNameNearBy])
	{
		return _buttonNearBy;
	}
	else if([name isEqualToString:kTabBarButtonNameMyFav])
	{
		return _buttonMyFav;
	}
	else if([name isEqualToString:kTabBarButtonNameSearch])
	{
		return _buttonSearch;
	}
	else if([name isEqualToString:kTabBarButtonNameSetting])
	{
		return _buttonSetting;
	}

	
	return nil;
}

- (void) selectTab:(TabBarButton*)newTab
{
	//select the navController
	if (![[_currentTab name] isEqualToString:[newTab name]])
	{
		[_delegate tabBarButtonTapped:[newTab name]];
		[_currentTab setImageNormal];
		_currentTab = newTab;
		[_currentTab setImageSelected];
	}
	else 
	{
		[_delegate activeTabBarButtonTapped];
	}

}

- (void) selectTabNamed:(NSString*)name
{
	[self selectTab:[self tabWithName:name]];
}

#pragma mark -
#pragma mark Memory management

- (void)dealloc {
    [super dealloc];
}

@end


