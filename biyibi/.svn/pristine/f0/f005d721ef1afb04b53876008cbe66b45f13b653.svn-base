//
//  AreaSetViewController.m
//  biyibi
//
//  Created by nirvana on 5/2/13.
//  Copyright (c) 2013 nirvana. All rights reserved.
//

#import "AuthSelectMobile.h"
#import "AuthDataController.h"
#import "AppDelegate.h"

@interface AuthSelectMobile()

@end

@implementation AuthSelectMobile
@synthesize list = _list;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"注册";
		self.navigationItem.title = @"注册";
        
        _authDataController = [[AuthDataController alloc] init];
        [_authDataController setDelegate : self];
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    
    UILabel *lblUserName = [[UILabel alloc] initWithFrame:CGRectMake(20, 50, 70, 20)];
    lblUserName.textColor = [UIColor blackColor];
    lblUserName.backgroundColor = [UIColor clearColor];
    lblUserName.font = [UIFont fontWithName:@"Helvetica-Bold" size:14];
	lblUserName.text = @"手机号:";
	lblUserName.textColor = [NiConstants colorWithKey:@"CA4638"];
    [self.view addSubview:lblUserName];
    [lblUserName release];
    
    _txtUserName = [[UITextField alloc] initWithFrame:CGRectMake(100, 50, 200, 30)];
    _txtUserName.autocapitalizationType = UITextAutocapitalizationTypeNone;
	_txtUserName.autocorrectionType = UITextAutocorrectionTypeNo;
	_txtUserName.borderStyle = UITextBorderStyleRoundedRect;
	_txtUserName.clearButtonMode = UITextFieldViewModeNever;
	_txtUserName.font = [UIFont systemFontOfSize:14];
	_txtUserName.contentVerticalAlignment = UIControlContentVerticalAlignmentCenter;
	_txtUserName.returnKeyType = UIReturnKeyDone;
    [_txtUserName setDelegate:self];
    //_txtUserName.keyboardType = UIKeyboardTypeNumbersAndPunctuation;
    [self.view addSubview:_txtUserName];
    
    UILabel *lblPassword = [[UILabel alloc] initWithFrame:CGRectMake(20, 110, 70, 20)];
    lblPassword.textColor = [UIColor blackColor];
    lblPassword.backgroundColor = [UIColor clearColor];
    
    lblPassword.font = [UIFont fontWithName:@"Helvetica-Bold" size:14];
	lblPassword.text = @"密  码:";
	lblPassword.textColor = [NiConstants colorWithKey:@"CA4638"];
    
    [self.view addSubview:lblPassword];
    [lblPassword release];
    
    _txtPassword = [[UITextField alloc] initWithFrame:CGRectMake(100, 110, 200, 30)];
    _txtPassword.autocapitalizationType = UITextAutocapitalizationTypeNone;
	_txtPassword.autocorrectionType = UITextAutocorrectionTypeNo;
	_txtPassword.borderStyle = UITextBorderStyleRoundedRect;
	_txtPassword.clearButtonMode = UITextFieldViewModeNever;
	_txtPassword.font = [UIFont systemFontOfSize:14];
	_txtPassword.contentVerticalAlignment = UIControlContentVerticalAlignmentCenter;
	_txtPassword.returnKeyType = UIReturnKeyDone;
    _txtPassword.secureTextEntry = YES;
    [_txtPassword setDelegate:self];
    [self.view addSubview:_txtPassword];
    
    
    UIButton *button = [UIButton buttonWithType:UIButtonTypeCustom];
    UIImage *img = [UIImage imageNamed:@"btn-a1.png"];
    
    button.frame = CGRectMake(40, 220, 240, 40);
    
    [button setBackgroundImage:img forState:UIControlStateNormal];
    [button setBackgroundImage:img forState:UIControlStateSelected];

    [button addTarget:self action:@selector(registerClicked:) forControlEvents:UIControlEventTouchUpInside];
  
    button.titleLabel.font = [UIFont fontWithName:@"Helvetica-Bold" size:18];
	[button setTitle:@"注    册" forState:UIControlStateNormal];
	[button setTitleColor:[NiConstants colorWithKey:@"07273B"] forState:UIControlStateNormal];

    
    //button.contentMode = UIViewContentModeScaleToFill; //Look up UIViewContentMode in the documentation for other options
    
    [self.view addSubview:button];
      
}

-(void)viewWillAppear:(BOOL)animated{
    [super viewWillAppear:animated];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


-(void)btnClicked
{
	//TODO
    AuthSelectStateViewController *vc = [[AuthSelectStateViewController alloc] init];
    [self.navigationController pushViewController:vc animated:YES];
    
}

#pragma mark UITextFieldDelegate methods

- (BOOL)textFieldShouldReturn:(UITextField *)textField
{
	[textField resignFirstResponder];
	return YES;
}

- (void)registerClicked:(UIButton *)registerButton
{
	// If username not specified, alert user.
	if ([_txtUserName.text isEqualToString:@""])
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
	else if ([_txtPassword.text isEqualToString:@""])
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
        [_authDataController registerUserName:_txtUserName.text withPassWord:_txtPassword.text];
 	}
}


#pragma mark delegate authdatacontroller.

-(void) regiesterSuccessful{
    [self hideLoadingView];
    AuthSelectStateViewController *vc = [[AuthSelectStateViewController alloc] init];
    [self.navigationController pushViewController:vc animated:YES];
};

-(void) regiesterFailed:(NSError *)error{
    [self hideLoadingView];
    //Display if it is a network error and retain the password field.
	if([[error domain] isEqualToString:kNetworkConnectionUnavailableErrorDomain])
	{
		[(AppDelegate *)[[UIApplication sharedApplication] delegate] showNetworkUnavailableAlert];
		return;
	}
	else if ([[error domain] isEqualToString:kNoDataReturnedErrorDomain])//The data returned was empty. The URL probably did not make it to the server
	{
		UIAlertView* alertView = [[UIAlertView alloc] initWithTitle:@"Register Error"
															message:@"Unable to connect to BaoSteel!"
														   delegate:self
												  cancelButtonTitle:@"Close"
												  otherButtonTitles:nil];
		
		[alertView setDelegate:self];
		[alertView show];
		[alertView release];
		return;
	}else{
        UIAlertView* alertView = [[UIAlertView alloc] initWithTitle:@"Register Error"
															message:@"Resister number has existed!"
														   delegate:self
												  cancelButtonTitle:@"Close"
												  otherButtonTitles:nil];
		
		[alertView setDelegate:self];
		[alertView show];
		[alertView release];
		return;

    }
    
	
	[_txtUserName setText:@""];
    [_txtPassword setText:@""];
};





@end
