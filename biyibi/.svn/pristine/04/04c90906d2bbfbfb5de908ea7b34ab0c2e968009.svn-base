//
//  TrafficCopDebugConsole.m
//
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import "TrafficCopDebugConsole.h"
#import "TrafficCop.h"
#include <sys/types.h>
#include <sys/sysctl.h>

@protocol HasWindowProtocol

- (UIWindow *)window;

@end


@interface TrafficCopDebugConsole (Private)

- (void)updateDisplay:(NSTimer *)timer;
- (NSString *)readableDeviceName;

@end


@implementation TrafficCopDebugConsole

static TrafficCopDebugConsole *__singleton;

+ (void)initialize
{
	@synchronized(self)
	{
		if(nil == __singleton)
		{
			__singleton = [[TrafficCopDebugConsole alloc] initWithNibName:nil bundle:nil];
		}
	}
}

+ (id)alloc
{
	@synchronized(self)
	{
		NSAssert(__singleton == nil, @"Attempted to allocate a second instance of a TrafficCopDebugConsole.");
		__singleton = [super alloc];
	}
	
	return __singleton;
}

// The designated initializer.  Override if you create the controller programmatically and want to perform customization that is not appropriate for viewDidLoad.
- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil {
    if ((self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil])) {
        // Custom initialization
		
		if((NSClassFromString(@"UITapGestureRecognizer")) == nil || 
		   NO == [[[UIApplication sharedApplication] delegate] respondsToSelector:@selector(window)])
		{
			return nil; //this should only do anything if we can use a tap gesture recognizer and has a window we can attach to
		}
		
		_consoleViewEnabled = NO;
		_lastShakeTimeInterval = 0;
		
		_requestLog = [[NSMutableString alloc] init];
		_errorLog = [[NSMutableString alloc] init];
		_successLog = [[NSMutableString alloc] init];
		
		_requestIdx = 0;
		_errorIdx = 0;
		_successIdx = 0;
		
		UIWindow *window = [(id<HasWindowProtocol>)[[UIApplication sharedApplication] delegate] window];
		
		
#if TARGET_IPHONE_SIMULATOR
		UITapGestureRecognizer *tapGesture = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(trippleTap:)];
		[tapGesture setNumberOfTapsRequired:2];
		[tapGesture setNumberOfTouchesRequired:2];
		[window addGestureRecognizer:tapGesture];
		[tapGesture release];
#else
		//Add a tripple three tap gesture recognizer to the window
		UITapGestureRecognizer *tapGesture = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(trippleTap:)];
		[tapGesture setNumberOfTapsRequired:3];
		[tapGesture setNumberOfTouchesRequired:1];
		[window addGestureRecognizer:tapGesture];
		[tapGesture release];
		
#endif
		
		
		
    }
    return self;
}

//Enable/Disable logging through a tripple tap with three fingers
//because sometimes the double-tap is not enough
- (void)trippleTap:(UIGestureRecognizer *)recognizer
{
	if(NO == _consoleViewEnabled)
	{
		_consoleViewEnabled = YES;
		
		UIWindow *window = [(id<HasWindowProtocol>)[[UIApplication sharedApplication] delegate] window];
		
		if([[self view] superview] == nil)
		{
			[window addSubview:[self view]];
		}
		
		[self becomeFirstResponder];
		
		//turn on logging in the traffic cop
		
		[[TrafficCop sharedInstance] setRequestLoggingEnabled:YES];
		[[TrafficCop sharedInstance] setSuccessLoggingEnabled:YES];
		[[TrafficCop sharedInstance] setFailureLoggingEnabled:YES];
	}
	else
	{
		if([[self view] superview] != nil)
		{
			//move the view out of the way
			if(self.view.frame.origin.y < [[UIScreen mainScreen] bounds].size.height)
			{
				[[self view] setFrameYOrigin:self.view.frame.origin.y + [[UIScreen mainScreen] bounds].size.height];
			}
			
			[[self view] removeFromSuperview];
			
		}
		_consoleViewEnabled = NO;
		
		//turn off logging in the traffic cop (except for errors)
		
		[[TrafficCop sharedInstance] setRequestLoggingEnabled:NO];
		[[TrafficCop sharedInstance] setSuccessLoggingEnabled:NO];
	}
}



// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView {
	[super loadView];
	
	[[self view] setFrame:[[UIScreen mainScreen] bounds]];
	[[self view] setFrameYOrigin:[[UIScreen mainScreen] bounds].size.height];
	[[self view] setBackgroundColor:[UIColor whiteColor]];
	
	//calculate the height of our text views
	NSInteger textViewHeight = floor(([[UIScreen mainScreen] bounds].size.height - 190) / 3);
	NSInteger horizontalBuffer = 5;
	
	UILabel *requestLabel = [[UILabel alloc] initWithFrame:CGRectMake(horizontalBuffer, 25, 150, 20)];
	[requestLabel setText:@"All Requests"];
	[[self view] addSubview:requestLabel];
	[requestLabel release];
	
	_requestLogView = [[UITextView alloc] initWithFrame:CGRectMake(horizontalBuffer,
																   CGRectGetMaxY(requestLabel.frame) + 3,
								[[UIScreen mainScreen] bounds].size.width - (horizontalBuffer * 2),
								textViewHeight)];
	[_requestLogView setEditable:NO];
	[_requestLogView setBackgroundColor:[[self view] backgroundColor]];
	[_requestLogView setOpaque:YES];
	
	//construct a bounding box
	UIView *boundView = [[UIView alloc] initWithFrame:CGRectMake(_requestLogView.frame.origin.x - 1, 
																 _requestLogView.frame.origin.y - 1,
																 _requestLogView.frame.size.width + 2,
																 _requestLogView.frame.size.height + 2)];
	[boundView setBackgroundColor:[UIColor blackColor]];
	
	[[self view] addSubview:boundView];
	[boundView release];
	[[self view] addSubview:_requestLogView];
	
	UILabel *successLabel = [[UILabel alloc] initWithFrame:CGRectMake(horizontalBuffer,
																	  CGRectGetMaxY(_requestLogView.frame) + 3,
																	  250, 20)];
	[successLabel setText:@"Successful Requests"];
	[[self view] addSubview:successLabel];
	
	_successLogView = [[UITextView alloc] initWithFrame:CGRectMake(horizontalBuffer,
																   CGRectGetMaxY(successLabel.frame) + 3,
							[[UIScreen mainScreen] bounds].size.width - (horizontalBuffer * 2),
																   textViewHeight)];
	[_successLogView setEditable:NO];
	[_successLogView setBackgroundColor:[[self view] backgroundColor]];
	[_successLogView setOpaque:YES];
	
	//construct a bounding box
	boundView = [[UIView alloc] initWithFrame:CGRectMake(_successLogView.frame.origin.x - 1, 
																 _successLogView.frame.origin.y - 1,
																 _successLogView.frame.size.width + 2,
																 _successLogView.frame.size.height + 2)];
	[boundView setBackgroundColor:[UIColor blackColor]];
	
	[[self view] addSubview:boundView];
	[boundView release];
	[[self view] addSubview:_successLogView];
	
	UILabel *failureLabel = [[UILabel alloc] initWithFrame:CGRectMake(horizontalBuffer,
																	  CGRectGetMaxY(_successLogView.frame) + 3,
																	  150, 20)];
	[failureLabel setText:@"Failed Requests"];
	[[self view] addSubview:failureLabel];
	
	_errorLogView = [[UITextView alloc] initWithFrame:CGRectMake(horizontalBuffer,
																   CGRectGetMaxY(failureLabel.frame) + 3,
																   [[UIScreen mainScreen] bounds].size.width - (horizontalBuffer * 2),
																   textViewHeight)];
	[_errorLogView setBackgroundColor:[[self view] backgroundColor]];
	[_errorLogView setEditable:NO];
	[_errorLogView setOpaque:YES];
	
	//construct a bounding box
	boundView = [[UIView alloc] initWithFrame:CGRectMake(_errorLogView.frame.origin.x - 1, 
														 _errorLogView.frame.origin.y - 1,
														 _errorLogView.frame.size.width + 2,
														 _errorLogView.frame.size.height + 2)];
	[boundView setBackgroundColor:[UIColor blackColor]];
	
	[[self view] addSubview:boundView];
	[boundView release];
	[[self view] addSubview:_errorLogView];
	
	
	for(UILabel *label in [NSArray arrayWithObjects:requestLabel,successLabel,failureLabel,nil])
	{
		[label setFont:[UIFont fontWithName:@"Helvetica-Bold" size:16]];
		[label setBackgroundColor:[[self view] backgroundColor]];
		[label setOpaque:YES];
		[label setTextColor:[UIColor blackColor]];
	}
    
    CGFloat titleWidth = 100;
    CGFloat valueWidth = CGRectGetWidth([[self view] frame]) - (3 * horizontalBuffer);
    CGFloat labelHeight = 18;
    CGFloat networkInfoYOrigin = CGRectGetMaxY(_errorLogView.frame)+1;
	
	UILabel *networkSpeedTitle = [[UILabel alloc] initWithFrame:CGRectMake(horizontalBuffer, networkInfoYOrigin, titleWidth, labelHeight)];
	[networkSpeedTitle setText:@"Network Speed:"];
    [networkSpeedTitle setAdjustsFontSizeToFitWidth:YES];
	[networkSpeedTitle setFont:[UIFont fontWithName:@"Helvetica-Bold" size:14]];
	[[self view] addSubview:networkSpeedTitle];
    
	_networkSpeedLabel = [[UILabel alloc] initWithFrame:CGRectMake(CGRectGetMaxX([networkSpeedTitle frame])+horizontalBuffer, networkInfoYOrigin, valueWidth, labelHeight)];
	[_networkSpeedLabel setFont:[UIFont fontWithName:@"Helvetica-Bold" size:14]];
	[[self view] addSubview:_networkSpeedLabel];
	
	[networkSpeedTitle release];
	
	//network speed is returned in bytes/second so go to kilobytes
	[_networkSpeedLabel setText:[NSString stringWithFormat:@"%0.3fKB/s",[[TrafficCop sharedInstance] networkSpeed] / 1024]];
	[_networkSpeedLabel setAdjustsFontSizeToFitWidth:YES];
    
	UILabel *reachabilityLabel = [[UILabel alloc] initWithFrame:CGRectMake(horizontalBuffer, [_networkSpeedLabel bottomBorderYValue], titleWidth, labelHeight)];
    [reachabilityLabel setText:@"Reachability:"];
	[reachabilityLabel setFont:[UIFont fontWithName:@"Helvetica-Bold" size:14]];
    [reachabilityLabel setAdjustsFontSizeToFitWidth:YES];
	[[self view] addSubview:reachabilityLabel];
    
	_reachabilityLabel = [[UILabel alloc] initWithFrame:CGRectMake(CGRectGetMaxX([reachabilityLabel frame])+horizontalBuffer, [_networkSpeedLabel bottomBorderYValue], valueWidth, labelHeight)];
	[_reachabilityLabel setFont:[UIFont fontWithName:@"Helvetica-Bold" size:14]];
	[_reachabilityLabel setNumberOfLines:0];
    [_reachabilityLabel setAdjustsFontSizeToFitWidth:YES];
	[[self view] addSubview:_reachabilityLabel];
	
	[reachabilityLabel release];
	[successLabel release];
	[failureLabel release];
    
    //Add an e-mail button
	if(nil == _emailButton)
	{
		_emailButton = [[UIButton buttonWithType:UIButtonTypeRoundedRect] retain];
		[_emailButton setTitle:@"E-mail log" forState:UIControlStateNormal];
		[_emailButton addTarget:self action:@selector(emailButtonClicked:) forControlEvents:UIControlEventTouchUpInside];
	}
	
	[_emailButton setFrame:CGRectMake(horizontalBuffer, CGRectGetMaxY(_reachabilityLabel.frame) + 4, 150, 40)];
	
	[[self view] addSubview:_emailButton];
}

- (void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
    
    // (RIP Oct 22, 2010) - y-origin was drifting down after hiding the email 
    // window, so reset here. 
    [[self view] setFrame:[[UIScreen mainScreen] bounds]];

    // (RIP Oct 22, 2010) - To allow the user to edit the email screen, we
    // resign first responder when we present the mail composer. To
    // begin responding to the shake gesture again once the mail composer has
    // been dismissed, becomeFirstResponder here.
    [self becomeFirstResponder];
}

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

- (void)emailButtonClicked:(UIButton *)button
{
	MFMailComposeViewController *mailViewController = [[MFMailComposeViewController alloc] init];
	[mailViewController setMailComposeDelegate:self];
	
	[mailViewController setSubject:[NSString stringWithFormat:@"network log for %@",[[[NSBundle mainBundle] infoDictionary] objectForKey:@"CFBundleDisplayName"]]];
	NSMutableString *body = [[NSMutableString alloc] init];
	[body appendString:[[NSDate date] description]];
	[body appendString:@"\n"];
	[body appendString:[NSString stringWithFormat:@"Device: %@\n",[self readableDeviceName]]];
	UIDevice *device = [UIDevice currentDevice];
	[body appendString:[NSString stringWithFormat:@"OS Version: %@ %@\n",[device systemName], [device systemVersion]]];
	[body appendString:[NSString stringWithFormat:@"Application: %@ (%@)\n",
						[[[NSBundle mainBundle] infoDictionary] objectForKey:@"CFBundleDisplayName"],
						[[[NSBundle mainBundle] infoDictionary] objectForKey:@"CFBundleVersion"]]];
	[body appendString:@"\n\n\n"];
	[body appendString:[NSString stringWithFormat:@"Failures: \n%@\n\n\n",_errorLog]];
	[body appendString:[NSString stringWithFormat:@"Successes: \n%@\n\n\n",_successLog]];
	[body appendString:[NSString stringWithFormat:@"All Requests: \n%@\n\n\n",_requestLog]];
	 
	 
	[mailViewController setMessageBody:body isHTML:NO];
	[body release];
    
    // (RIP Oct 22, 2010) - To allow the user to edit the email screen, we
    // resign first responder when we present the mail composer. I don't 
    // completely understand why this works, but others with the same problem
    // (and this solution) can be found here: 
    // http://www.iphonedevsdk.com/forum/iphone-sdk-development/34480-problem-mfmailcomposeviewcontroller.html
	[self resignFirstResponder];
	[self presentModalViewController:mailViewController animated:YES];
    [mailViewController release];
}


- (void)dealloc {
    [super dealloc];
}

#pragma mark UIResponder methods

//Show/hide the debug console on shake

- (void)motionBegan:(UIEventSubtype)motion withEvent:(UIEvent *)event
{
	
	if(motion == UIEventSubtypeMotionShake)
	{
		NSTimeInterval currentTime = CFAbsoluteTimeGetCurrent();
		//if it's less than 5 seconds between shakes then just ignore it
		if(currentTime - _lastShakeTimeInterval < 5)
		{
			return;
		}
		
		_lastShakeTimeInterval = currentTime;
		
		//if we are hidden then show
		if([[self view] frame].origin.y >= [[UIScreen mainScreen] bounds].size.height && _consoleViewEnabled)
		{
			if([[[UIApplication sharedApplication] delegate] respondsToSelector:@selector(window)])
			{
				[[self view] setFrameYOrigin:self.view.frame.origin.y - [[UIScreen mainScreen] bounds].size.height];
				[self updateDisplay:nil];
				_updateTimer = [[NSTimer scheduledTimerWithTimeInterval:1.0 target:self selector:@selector(updateDisplay:)
															   userInfo:nil repeats:YES] retain];
			}
			
		}
		
		//otherwise hide
		else 
		{
			[_updateTimer invalidate];
			[_updateTimer release];
			_updateTimer = nil;
			[[self view] setFrameYOrigin:self.view.frame.origin.y + [[UIScreen mainScreen] bounds].size.height];
		}
	}

	//[super motionBegan:motion withEvent:event];
}

- (void)motionCancelled:(UIEventSubtype)motion withEvent:(UIEvent *)event
{
	if(motion == UIEventSubtypeMotionShake)
	{
		DLog(@"motion cancelled");
	}
	
	//[super motionCancelled:motion withEvent:event];
	
}

- (void)motionEnded:(UIEventSubtype)motion withEvent:(UIEvent *)event
{
	
	if(motion == UIEventSubtypeMotionShake)
	{
		DLog("motion ended");

	}
	
	//[super motionEnded:motion withEvent:event];
}

- (BOOL)canBecomeFirstResponder
{ 
	return YES; 
}


#pragma mark MFMailComposeViewControllerDelegate methods

- (void)mailComposeController:(MFMailComposeViewController*)controller didFinishWithResult:(MFMailComposeResult)result error:(NSError*)error 
{	
	[self dismissModalViewControllerAnimated:YES];
}


@end
				 
@implementation TrafficCopDebugConsole (Private)
				 
- (void)updateDisplay:(NSTimer *)timer
{
	//update the all requests display
	NSArray *allRequests = [[TrafficCop sharedInstance] allRequests];
	
	//add on any new network requests to our log string	
	for(NSUInteger requestIdx = _requestIdx; requestIdx < [allRequests count]; ++requestIdx)
	{
		[_requestLog appendString:[allRequests objectAtIndex:requestIdx]];
		[_requestLog appendString:@"\n"];
	}
	_requestIdx = [allRequests count];
    
	[_requestLogView setText:_requestLog];
	if([_requestLog length] > 1)
	{
		[_requestLogView scrollRangeToVisible:NSMakeRange([_requestLog length] - 1, 1)];
	}
	
	//update the successful requests display
	NSArray *successfulRequests = [[TrafficCop sharedInstance] successfulRequests];
	
	//add on any new network requests to our log string
	for(NSUInteger requestIdx = _successIdx; requestIdx < [successfulRequests count]; ++requestIdx)
	{
		[_successLog appendString:[successfulRequests objectAtIndex:requestIdx]];
		[_successLog appendString:@"\n"];
	}
	_successIdx = [successfulRequests count];
	[_successLogView setText:_successLog];
	if([_successLog length] > 1)
	{
		[_successLogView scrollRangeToVisible:NSMakeRange([_successLog length] - 1, 1)];
	}
	
	//update the failed requests display
	NSArray *failedRequests = [[TrafficCop sharedInstance] failedRequests];
	
	//add on any new network requests to our log string
	for(NSUInteger requestIdx = _errorIdx; requestIdx < [failedRequests count]; ++requestIdx)
	{
		[_errorLog appendString:[failedRequests objectAtIndex:requestIdx]];
		[_errorLog appendString:@"\n"];
	}
	_errorIdx = [failedRequests count];
	
	[_errorLogView setText:_errorLog];
	if([_errorLog length] > 1)
	{
		[_errorLogView scrollRangeToVisible:NSMakeRange([_errorLog length] - 1, 1)];
	}
	
	[_networkSpeedLabel setText:[NSString stringWithFormat:@"%0.3fKB/s",[[TrafficCop sharedInstance] networkSpeed] / 1024]];
	
	NSString *physicalReachability = nil;
	switch ([[TrafficCop sharedInstance] physicalConnectionStatus]) 
	{
		case NoInternet:
			physicalReachability = @"None";
			break;
		case PacketNetwork:
			physicalReachability = @"3G/EDGE";
			break;
		case WiFi:
			physicalReachability = @"WiFi";
			break;
		default:
			physicalReachability = @"None";
			break;
	}
	
	NSString *hostReachability = nil;
	switch ([[TrafficCop sharedInstance] physicalConnectionStatus]) 
	{
		case NoInternet:
			hostReachability = @"None";
			break;
		case PacketNetwork:
			hostReachability = @"3G/EDGE";
			break;
		case WiFi:
			hostReachability = @"WiFi";
			break;
		default:
			hostReachability = @"None";
			break;
	}
	
	NSString *reachabilityString = [[NSString alloc] initWithFormat:@"%@ (physical) \\ %@ (host)", physicalReachability, hostReachability];
	[_reachabilityLabel setText:reachabilityString];
}
	 
- (NSString *)readableDeviceName
{
	size_t size;
	sysctlbyname("hw.machine", NULL, &size, NULL, 0);
	char *machine = malloc(size);
	sysctlbyname("hw.machine", machine, &size, NULL, 0);
	NSString *platform = [NSString stringWithCString:machine encoding:NSUTF8StringEncoding];
	free(machine);
	
	NSString *deviceName = nil;
	if ([platform isEqualToString:@"iPad1,1"]) deviceName = @"iPad 1G";
	else if ([platform isEqualToString:@"iPhone1,1"]) deviceName = @"iPhone 1G";
	else if ([platform isEqualToString:@"iPhone1,2"]) deviceName = @"iPhone 3G";
	else if ([platform isEqualToString:@"iPhone2,1"]) deviceName = @"iPhone 3GS";
	else if ([platform isEqualToString:@"iPod1,1"]) deviceName = @"iPod 1G";
	else if ([platform isEqualToString:@"iPod2,1"]) deviceName = @"iPod 2G";
	else deviceName = platform;
	
	return deviceName;
	
}
				 
@end
