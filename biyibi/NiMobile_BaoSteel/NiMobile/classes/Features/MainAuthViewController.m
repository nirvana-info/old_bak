//
//  MainAuthViewController.m
//  NiMobile
//
//  Created by zhu clude on 5/5/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//



#import "MainAuthViewController.h"
#import "GradientButton.h"
#import "AppDelegate.h"

#import "AuthSelectStateViewController.h"
#import "AuthSelectMobile.h"

@interface MainAuthViewController ()

@end

@implementation MainAuthViewController

// The designated initializer.  Override if you create the controller programmatically and want to perform customization that is not appropriate for viewDidLoad.
- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil {
    if ((self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil])) {
        // Custom initialization
		_sessionDataController = [[SessionDataController alloc] init];
		[_sessionDataController setDelegate:self];
        
		
		[[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(keyboardShowing:) name:UIKeyboardWillShowNotification object:nil];
		[[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(keyboardHiding:) name:UIKeyboardWillHideNotification object:nil];
    }
    return self;
}

// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView {
	[super loadView];

    
	[[self view] setFrame:[[UIScreen mainScreen] bounds]];
	[[self view] setFrameYOrigin:20];
	//[[self view] setBackgroundColor:[UIColor clearColor]];
	
	UIView *topRule = [[UIView alloc] initWithFrame:CGRectMake(0, 0, [[UIScreen mainScreen] bounds].size.width, 1)];
	[topRule setBackgroundColor:[NiConstants colorWithKey:@"6B6B6B"]];
	[[self view] addSubview:topRule];
	[topRule release];
	
	UIImageView *logoImageView = [[UIImageView alloc] initWithFrame:CGRectMake(84.0, 40.0, 152.0, 60.0)];
	logoImageView.image = [UIImage imageNamed:@"person-icon.png"]; //logo.png
	[[self view] addSubview:logoImageView];
	[logoImageView release];
	
	UILabel *usernameLabel = [[UILabel alloc] initWithFrame:CGRectMake(41.0, 131.0, 179.0, 21.0)];
	usernameLabel.font = [UIFont fontWithName:@"Helvetica-Bold" size:14];
	usernameLabel.text = @"手机号";
	usernameLabel.textColor = [NiConstants colorWithKey:@"CA4638"];
	usernameLabel.backgroundColor = [UIColor clearColor];
	[[self view] addSubview:usernameLabel];
	[usernameLabel release];
	
	_usernameTextField = [[UITextField alloc] initWithFrame:CGRectMake(41.0, 155.0, 243.0, 31.0)];
	_usernameTextField.autocapitalizationType = UITextAutocapitalizationTypeNone;
	_usernameTextField.autocorrectionType = UITextAutocorrectionTypeNo;
	_usernameTextField.borderStyle = UITextBorderStyleRoundedRect;
	_usernameTextField.clearButtonMode = UITextFieldViewModeNever;
	_usernameTextField.font = [UIFont fontWithName:@"Helvetica" size:16];
	_usernameTextField.contentVerticalAlignment = UIControlContentVerticalAlignmentCenter;
	_usernameTextField.returnKeyType = UIReturnKeyDone;
	[_usernameTextField setDelegate:self];
	[[self view] addSubview:_usernameTextField];
	
	UILabel *passwordLabel = [[UILabel alloc] initWithFrame:CGRectMake(41.0, 208.0, 79.0, 21.0)];
	passwordLabel.font = [UIFont fontWithName:@"Helvetica-Bold" size:14];
	passwordLabel.text = @"密码";
	passwordLabel.textColor = [NiConstants colorWithKey:@"CA4638"];
	passwordLabel.backgroundColor = [UIColor clearColor];
	[[self view] addSubview:passwordLabel];
	[passwordLabel release];
	
	_passwordTextField = [[UITextField alloc] initWithFrame:CGRectMake(41.0, 229.0, 243.0, 31.0)];
	_passwordTextField.autocapitalizationType = UITextAutocapitalizationTypeNone;
	_passwordTextField.autocorrectionType = UITextAutocorrectionTypeNo;
	_passwordTextField.borderStyle = UITextBorderStyleRoundedRect;
	_passwordTextField.clearButtonMode = UITextFieldViewModeNever;
	_passwordTextField.font = [UIFont fontWithName:@"Helvetica" size:16];
	_passwordTextField.contentVerticalAlignment = UIControlContentVerticalAlignmentCenter;
	_passwordTextField.returnKeyType = UIReturnKeyDone;
	_passwordTextField.secureTextEntry = YES;
	[_passwordTextField setDelegate:self];
	[[self view] addSubview:_passwordTextField];
	
	
	UIButton *signUpButton = [UIButton buttonWithType:UIButtonTypeCustom];
	signUpButton.frame = CGRectMake(30.0, 277.0, 115.0, 21.0);
	signUpButton.titleLabel.font = [UIFont fontWithName:@"Helvetica-Bold" size:14];
	[signUpButton setTitle:@"快速注册" forState:UIControlStateNormal];
	[signUpButton addTarget:self action:@selector(signUpUser:) forControlEvents:UIControlEventTouchUpInside];
	[signUpButton setTitleColor:[NiConstants colorWithKey:@"324F85"] forState:UIControlStateNormal];
	[[self view] addSubview:signUpButton];
	
	GradientButton *signInButton = [[GradientButton alloc] initWithFrame:CGRectMake(208.0, 269.0, 75.0, 30.0)];
	[signInButton setNormalGradientColors:[NSArray arrayWithObjects:
										   (id)[[NiConstants colorWithKey:@"FF7C00"] CGColor],
										   (id)[[NiConstants colorWithKey:@"FFA53D"] CGColor],nil]];
	[signInButton setNormalGradientLocations:[NSArray arrayWithObjects:
											  [NSNumber numberWithInt:0],
											  [NSNumber numberWithInt:1],nil]];
	[signInButton setHighlightGradientColors:[NSArray arrayWithObjects:
											  (id)[[NiConstants colorWithKey:@"FFA53D"] CGColor],
											  (id)[[NiConstants colorWithKey:@"FF7C00"] CGColor],nil]];
	[signInButton setHighlightGradientLocations:[NSArray arrayWithObjects:
                                                 [NSNumber numberWithInt:0],
                                                 [NSNumber numberWithInt:1],nil]];
	
	[signInButton setCornerRadius:4];
	[signInButton setStrokeColor:[NiConstants colorWithKey:@"DC6B00"]];
	[signInButton setStrokeWeight:1];
	[signInButton addTarget:self action:@selector(login:) forControlEvents:UIControlEventTouchUpInside];
	signInButton.titleLabel.font = [UIFont fontWithName:@"Helvetica-Bold" size:15];
	[signInButton setTitle:@"登录" forState:UIControlStateNormal];
	[signInButton setTitleColor:[NiConstants colorWithKey:@"07273B"] forState:UIControlStateNormal];
	[[self view] addSubview:signInButton];
	[signInButton release];
	
	UIView *bottomRule = [[UIView alloc] initWithFrame:CGRectMake(41.0, 340.0, 240.0, 1.0)];
	[bottomRule setBackgroundColor:[NiConstants colorWithKey:@"7C7C7C"]];
	[[self view] addSubview:bottomRule];
	[bottomRule release];
	
	
	UILabel *rememberMeLabel = [[UILabel alloc] initWithFrame:CGRectMake(41.0, 359.0, 127.0, 21.0)];
	rememberMeLabel.backgroundColor = [UIColor clearColor];
	rememberMeLabel.font = [UIFont fontWithName:@"Helvetica-Bold" size:14];
	rememberMeLabel.text = @"保持登陆状态";
	rememberMeLabel.textColor = [NiConstants colorWithKey:@"CA4638"];
	[[self view] addSubview:rememberMeLabel];
	[rememberMeLabel release];
	
	_rememberMeSwitch = [[UISwitch alloc] initWithFrame:CGRectMake(190.0, 356.0, 94.0, 27.0)];
    // add below line for fixing iOs5/iOs4 switch difference issue
    [_rememberMeSwitch setFrameXOrigin:(284 - _rememberMeSwitch.frame.size.width)];
    
	[_rememberMeSwitch addTarget:self action:@selector(rememberMeChanged:)
				forControlEvents:UIControlEventValueChanged];
	[_rememberMeSwitch setOn:[SessionDataController keepMeSignInOn]];
	[[self view] addSubview:_rememberMeSwitch];
	
}
- (void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    [[self navigationController] setNavigationBarHidden:YES animated:animated];
    //[GATracker signIn];
	[_rememberMeSwitch setOn:[SessionDataController keepMeSignInOn]];
    if ([SessionDataController rememberMeOn]) {
        _usernameTextField.text = [SessionDataController authenticationName];
    }
    
    //Just do test.
    _usernameTextField.text = @"13712345678";
    _passwordTextField.text = @"12345678";
}

-(void)viewWillDisappear:(BOOL)animated{
    
    [[self navigationController] setNavigationBarHidden:NO animated:animated];
    [super viewWillDisappear:animated];
}

- (void)rememberMeChanged:(UISwitch *)theSwitch
{
	[_sessionDataController setKeepMeSignInOn:[theSwitch isOn]];
}

- (void)reauthenticate
{
	//NSTimeInterval lastTimeActive = [_sessionDataController lastActiveTime];
	//NSTimeInterval timeElapsed = CFAbsoluteTimeGetCurrent() - lastTimeActive;
	
	
	/*
     //If the time elapsed is less than 30 minutes then just go
     //call the login successful
     if(timeElapsed < 60 * 30 && [_sessionDataController authenticationToken])
     {
     [self loginSuccessful];
     return;
     }
	 */
	
	if ([_sessionDataController authenticationToken]) {
		[self showLoadingViewWithMessage:@""];
		[_sessionDataController getMemberInfo];
	}
	else if([_sessionDataController canReauthenticate])
	{
		[self showLoadingViewWithMessage:@""];
		[_sessionDataController reauthenticate];
	}
	else
	{
        
        // comment below line for fixing bug #22408, below line is not necessary to be called when application wakes up
		//[[NSNotificationCenter defaultCenter] postNotification:[NSNotification notificationWithName:kSignoutNotification object:nil]];
	}
    
	
}

/*
 // Implement viewDidLoad to do additional setup after loading the view, typically from a nib.
 - (void)viewDidLoad {
 [super viewDidLoad];
 }
 */

/*
 
 - (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation {
 // Overriden to allow any orientation.
 return YES;
 }
 
 */
- (void)didReceiveMemoryWarning {
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc that aren't in use.
}


- (void)viewDidUnload {
	[_usernameTextField release];
	_usernameTextField = nil;
	[_passwordTextField release];
	_passwordTextField = nil;
	[_rememberMeSwitch release];
	_rememberMeSwitch = nil;
	[_loadingView release];
	_loadingView = nil;
    [super viewDidUnload];
}


- (void)dealloc {
	[[NSNotificationCenter defaultCenter] removeObserver:self];
	[_usernameTextField release];
	_usernameTextField = nil;
	[_passwordTextField release];
	_passwordTextField = nil;
	[_rememberMeSwitch release];
	_rememberMeSwitch = nil;
	[_sessionDataController setDelegate: nil];
	[_sessionDataController release];
	_sessionDataController = nil;
	[_loadingView release];
	_loadingView = nil;
    [super dealloc];
}

- (void)signUpUser:(UIButton *)button
{
	//TODO
    AuthSelectMobile *vc = [[AuthSelectMobile alloc] init];
    [self.navigationController pushViewController:vc animated:YES];
}

- (void)skipSignin:(UIButton *)button
{
	//[[self view] removeFromSuperview];
	[(AppDelegate *)[[UIApplication sharedApplication] delegate] setLoginViewHidden:YES];
    
	//Switch to Markets Tab
	[(AppDelegate *)[[UIApplication sharedApplication] delegate] selectTab:kTabBarButtonNameShaker];
}

- (void)keyboardShowing:(NSNotification *)note
{
	if (self.view.window)
	{
		for(UIView *subview in [[self view] subviews])
		{
			[UIView beginAnimations:@"moveUp" context:nil];
			[subview setFrameYOrigin:subview.frame.origin.y - 20];
			[UIView commitAnimations];
		}
	}
}

- (void)keyboardHiding:(NSNotification *)note
{
	if (self.view.window)
	{
		for(UIView *subview in [[self view] subviews])
		{
			[UIView beginAnimations:@"moveUp" context:nil];
			[subview setFrameYOrigin:subview.frame.origin.y + 20];
			[UIView commitAnimations];
		}
	}
}

#pragma mark class specific methods

- (void)login:(UIButton *)loginButton
{
    
	// If username not specified, alert user.
	if ([_usernameTextField.text isEqualToString:@""])
	{
		UIAlertView* alertView = [[UIAlertView alloc] initWithTitle:@"Login Error"
															message:@"Please enter your username."
														   delegate:self
												  cancelButtonTitle:@"Fix"
												  otherButtonTitles:nil];
		
		[alertView setDelegate:self];
		[alertView show];
		[alertView release];
	}
	// If password not specified, alert user.
	else if ([_passwordTextField.text isEqualToString:@""])
	{
		UIAlertView* alertView = [[UIAlertView alloc] initWithTitle:@"Login Error"
															message:@"Please enter your password."
														   delegate:self
												  cancelButtonTitle:@"Fix"
												  otherButtonTitles:nil];
		
		[alertView setDelegate:self];
		[alertView show];
		[alertView release];
	}
	// Otherwise, try to log in.
	else
	{
        //[GATracker signIn];
		[self showLoadingViewWithMessage:@""];
        //[self loginSuccessful];
		
		[_sessionDataController loginWithUsername:[_usernameTextField text]
									  andPassword:[_passwordTextField text]
									   rememberMe:[_rememberMeSwitch isOn]];
	}
}

#pragma mark UITextFieldDelegate methods

- (BOOL)textFieldShouldReturn:(UITextField *)textField
{
	[textField resignFirstResponder];
	return YES;
}

- (BOOL)textField:(UITextField *)textField shouldChangeCharactersInRange:(NSRange)range replacementString:(NSString *)string
{
    int lenLimit = 16;
    if ([_usernameTextField isEqual:textField]) {
        lenLimit = 64;
    }
    
    NSUInteger newLength = [textField.text length] + [string length] - range.length;
    return (newLength > lenLimit) ? NO : YES;
}


#pragma mark SessionDataControllerDelegate methods

- (void)loginSuccessful
{
	[self hideLoadingView];
	
	if([SessionDataController keepMeSignInOn])
	{
		[_sessionDataController storeAuthenticationToken];
	}else if([SessionDataController rememberMeOn]){
        [_sessionDataController storeAuthenticationName];
    }
	
	[_usernameTextField setText:@""];
	[_passwordTextField setText:@""];
	
	[[NSNotificationCenter defaultCenter] postNotification:
	 [NSNotification notificationWithName:kAuthenticationSuccessful object:nil]];
	//[[self view] removeFromSuperview];
	[(AppDelegate *)[[UIApplication sharedApplication] delegate] setLoginViewHidden:YES];
    
}

- (void)loginUnsuccessfulWithError:(NSError *)error
{
	[self hideLoadingView];
	//Display if it is a network error and retain the password field.
	if([[error domain] isEqualToString:kNetworkConnectionUnavailableErrorDomain])
	{
		[(AppDelegate *)[[UIApplication sharedApplication] delegate] showNetworkUnavailableAlert];
		return;
	}
	else if ([[error domain] isEqualToString:kNoDataReturnedErrorDomain])//The data returned was empty. The URL probably did not make it to the server
	{
		UIAlertView* alertView = [[UIAlertView alloc] initWithTitle:@"Login Error"
															message:@"Unable to connect to Zecco. Please check your network connection and make sure that Date and Time settings on your device are correct."
														   delegate:self
												  cancelButtonTitle:@"Close"
												  otherButtonTitles:nil];
		
		[alertView setDelegate:self];
		[alertView show];
		[alertView release];
		return;
	}
    
	
	[_passwordTextField setText:@""];
}


#pragma mark UIAlertViewDelegate methods

- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex
{
}

@end

