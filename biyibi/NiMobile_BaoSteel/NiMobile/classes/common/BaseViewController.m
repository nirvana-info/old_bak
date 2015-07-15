    //
//  TabViewController.m
//  Zecco
//
//  Created by sirish.jetti on 9/2/10.
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import "BaseViewController.h"
#import "NiLoadingView.h"

@implementation BaseViewController

- (id)init
{
    self = [self initWithNibName:nil bundle:nil];
	
    return self;
}



 // The designated initializer.  Override if you create the controller programmatically and want to perform customization that is not appropriate for viewDidLoad.
- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil {
    if ((self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil])) {
        // Custom initialization
		_appDelegate = (AppDelegate *)[[UIApplication sharedApplication] delegate];
		
    }
    return self;
}



// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView {
	[super loadView];
	//[[self view] setBackgroundColor:[NiConstants colorWithKey:@"222222"]];
    self.view.backgroundColor = [UIColor colorWithPatternImage:[UIImage imageNamed:@"biyibiBG.jpg"]];
	
}

- (void)showLoadingViewWithMessage:(NSString *)message
{
	if(nil == _loadingView)
	{
		_loadingView = [[NiLoadingView alloc] initWithFrame:[[self view] bounds] message:message activityIndicator:YES];
		
	}
	else
	{
		[_loadingView setMessage:message];
	}
	
	[[self view] addSubview:_loadingView];
}

- (void)hideLoadingView
{
	if([_loadingView superview])
	{
		[_loadingView removeFromSuperview];
	}
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
	[_loadingView release];
    [super dealloc];
}

- (void)setTabBarHidden:(BOOL)isHidden{
    [_appDelegate setTabBarHidden:isHidden];
}

#pragma shake supporting
-(BOOL)doSupportShakeActon{
    return NO;
}

-(BOOL)canBecomeFirstResponder {
    return [self doSupportShakeActon];
}

-(void)viewDidAppear:(BOOL)animated {
    [super viewDidAppear:animated];
    [self becomeFirstResponder];
}

- (void)viewWillDisappear:(BOOL)animated {
    [self resignFirstResponder];
    [super viewWillDisappear:animated];
}


- (void)motionEnded:(UIEventSubtype)motion withEvent:(UIEvent *)event {
    if ([self doSupportShakeActon]) {
        if (event.type == UIEventTypeMotion && event.subtype == UIEventSubtypeMotionShake) {
            [self didWhenShakeActionEnded];
        }
    }
    
}

- (void)didWhenShakeActionEnded{
    
}

@end
