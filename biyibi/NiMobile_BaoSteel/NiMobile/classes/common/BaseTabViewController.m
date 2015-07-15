    //
//  BaseTabViewController.m
//  Zecco
//
//  Created by bryce.hammond on 9/27/10.
//  Copyright 2010 Wall Street On Demand, Inc. All rights reserved.
//

#import "BaseTabViewController.h"


@implementation BaseTabViewController

/*
 // The designated initializer.  Override if you create the controller programmatically and want to perform customization that is not appropriate for viewDidLoad.
- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil {
    if ((self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil])) {
        // Custom initialization
    }
    return self;
}
*/

-(id)initWithTabBar
{
 	if ([self init])
	{
		
	}
	
	return self;
}


// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView {
	[super loadView];
    [self.view setFrameHeight:480 - kTabBarHeight - kStatusBarHeight];

	//[[self navigationController] setNavigationBarHidden:YES animated:NO];
	
	UIView *topRule = [[UIView alloc] initWithFrame:CGRectMake(0, 0, [[UIScreen mainScreen] bounds].size.width, 1)];
	[topRule setBackgroundColor:[NiConstants colorWithKey:@"6B6B6B"]];
	[[self view] addSubview:topRule];
	[topRule release];
}

- (void)viewWillAppear:(BOOL)animated
{
	[super viewWillAppear:animated];
	
	if([self supportsStreaming] && [[NSUserDefaults standardUserDefaults] boolForKey:kSettingsRTStreamingEnabled])
	{
		[self startStreaming];
	}
}

- (void)viewWillDisappear:(BOOL)animated
{
	[super viewWillDisappear:animated];
	[self stopStreaming];
}


/*
// Implement viewDidLoad to do additional setup after loading the view, typically from a nib.
- (void)viewDidLoad {
    [super viewDidLoad];
}
*/

/*
// Override to allow orientations other than the default portrait orientation.
- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation {
    // Return YES for supported orientations
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}
*/

- (void)didReceiveMemoryWarning {
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc that aren't in use.
}

- (void)viewDidUnload {
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
}


- (void)dealloc {
    [super dealloc];
}

#pragma mark Methods intended to be overrided

- (BOOL)supportsStreaming
{
	return NO;
}

- (void)startStreaming
{
	
}

- (void)stopStreaming
{
	
}


@end
