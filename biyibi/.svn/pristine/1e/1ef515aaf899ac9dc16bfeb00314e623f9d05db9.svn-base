//
//  SessionDataController.m
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "SessionDataController.h"
#import "NiURLRequest.h"
#import "SFHFKeychainUtils.h"

#define kAuthenticationKey	@"Authentication.Login"
#define kLogoutKey			@"Authentication.Logout"
#define kNewAuthTokenKey	@"Authentication.NewAuthToken"
#define kMemberInfoKey	@"Authentication.MemberInfo"
#define kAuthenticationGroup @"authentication"


static Session *s_currentSession = nil;
static NSString *s_authenticationName = nil;
static NSString *s_authenticationToken = nil;
static NSTimeInterval s_lastActiveTime;
static BOOL	s_keepMeSignInOn = FALSE;
static BOOL	s_rememberMeOn = FALSE;

@implementation SessionDataController

@synthesize delegate;
//@synthesize keepMeSignInOn = _keepMeSignInOn;

+ (void)initialize
{
	s_lastActiveTime = [[NSUserDefaults standardUserDefaults] doubleForKey:kLastActiveTimeKey];
	s_keepMeSignInOn = [[NSUserDefaults standardUserDefaults] boolForKey:kKeepMeSignIn];
    s_rememberMeOn = [[NSUserDefaults standardUserDefaults] boolForKey:kSettingsRememberMeEnabled];
    
    if (s_rememberMeOn) {
        NSError *error = nil;
        s_authenticationName = [[SFHFKeychainUtils getPasswordForUsername:kUsernameKeychainKey
                                                           andServiceName:kAuthenticationServiceName error:&error] retain];
    }else{
        s_authenticationName = nil;
    }
}
+ (void)clearAuthenticationData
{
	NSError *error = nil;
	[SFHFKeychainUtils deleteItemForUsername:kAuthenticationKeychainKey
							  andServiceName:kAuthenticationServiceName error:&error];
	[s_currentSession release];
	s_currentSession = nil;
	[s_authenticationToken release];
	s_authenticationToken = nil;
    
    if (NO == s_rememberMeOn) {
        [SFHFKeychainUtils deleteItemForUsername:kUsernameKeychainKey
                                  andServiceName:kAuthenticationServiceName error:&error];
        [s_authenticationName release];
        s_authenticationName = nil;
    }
    //[s_authenticationName release];
	//s_authenticationName = nil;
	s_lastActiveTime = 0;
	[[NSUserDefaults standardUserDefaults] setDouble:s_lastActiveTime forKey:kLastActiveTimeKey];
	
}
+ (BOOL)authTokenExists
{
	return nil != s_authenticationToken;
}
- (id)init
{
	if(self = [super init])
	{
		//_keepMeSignInOn = [[NSUserDefaults standardUserDefaults] boolForKey:kKeepMeSignIn];
		
		if(NO == s_keepMeSignInOn)
		{
			//make sure the keychain is clear
			NSError *error = nil;
			//[SFHFKeychainUtils deleteItemForUsername:kAuthenticationKeychainKey andServiceName:kAuthenticationServiceName error:&error];
            if (NO == s_rememberMeOn) {
                [SFHFKeychainUtils deleteItemForUsername:kUsernameKeychainKey andServiceName:kAuthenticationServiceName error:&error];
            }
			
		}
	}
	
	return self;
}

- (void)loginWithUsername:(NSString *)username andPassword:(NSString *)password rememberMe:(BOOL)rememberMe
{
	if([[username stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceCharacterSet]] length] == 0)
	{
		NSMutableDictionary *errorDetail = [NSMutableDictionary dictionary];
		[errorDetail setValue:@"Please enter your username." forKey:@"message"];
		NSError *error = [NSError errorWithDomain:@"LocalFailure" code:100 userInfo:errorDetail];
		[delegate loginUnsuccessfulWithError:error];
        
        //[GATracker errorTrack:@"Login" Label:@"Please enter your username." Code:100];
		return;
	}
	
	if([[password stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceCharacterSet]] length] == 0)
	{
		NSMutableDictionary *errorDetail = [NSMutableDictionary dictionary];
		[errorDetail setValue:@"Please enter your password." forKey:@"message"];
		NSError *error = [NSError errorWithDomain:@"LocalFailure" code:100 userInfo:errorDetail];
		[delegate loginUnsuccessfulWithError:error];
        
        //[GATracker errorTrack:@"Login" Label:@"Please enter your password." Code:100];
		return;
	}
	
	[_username release];
	_username = [username retain];
	[_password release];
	_password = [password retain]; //Required to get new auth token
	
	NSMutableDictionary *args = [NSMutableDictionary dictionaryWithObjectsAndKeys:
								 [self zeccoURLEncode:username], @"credential",
								 [self zeccoURLEncode:password], @"password",
								 //[NSNumber numberWithInt:(rememberMe ? 1 : 0)], @"remMe",
								 nil];
	[self performRestRequestwithGroup:kAuthenticationGroup andMethod:@"login" andArgs:args andKey:kAuthenticationKey];
	
}

+ (BOOL)loggedIn
{
	return (s_currentSession != nil && s_authenticationToken != nil && [s_currentSession memberId] != nil);
}

+ (BOOL)keepMeSignInOn;
{
	return s_keepMeSignInOn;
}
+ (BOOL)rememberMeOn;
{
	return s_rememberMeOn;
}
- (void)logout
{
	if (s_authenticationToken)
	{
		NSMutableDictionary *args = [NSMutableDictionary dictionaryWithObjectsAndKeys: nil];
		[self performNiRequestwithGroup:kAuthenticationGroup andMethod:@"logout" andArgs:args andKey:kLogoutKey];
	}
	
	NSError *error = nil;
	[SFHFKeychainUtils deleteItemForUsername:kAuthenticationKeychainKey
							  andServiceName:kAuthenticationServiceName error:&error];
    
    if (NO == s_rememberMeOn) {
        [SFHFKeychainUtils deleteItemForUsername:kUsernameKeychainKey
                                  andServiceName:kAuthenticationServiceName error:&error];
        [s_authenticationName release];
        s_authenticationName = nil;
    }
	
	[s_currentSession release];
	s_currentSession = nil;
	[s_authenticationToken release];
	s_authenticationToken = nil;
	s_lastActiveTime = 0;
	[self setKeepMeSignInOn:NO];
	
	[[NSUserDefaults standardUserDefaults] setDouble:s_lastActiveTime forKey:kLastActiveTimeKey];
	
	[[NSNotificationCenter defaultCenter] postNotification:[NSNotification notificationWithName:kSignoutNotification
																						 object:nil]];
    
}

-(void) getNewAuthToken
{
	NSMutableDictionary *args = [NSMutableDictionary dictionaryWithObjectsAndKeys:
								 _password, @"pword",
								 nil];
	
	[self performNiRequestwithGroup:kAuthenticationGroup andMethod:@"getnewauthtoken" andArgs:args andKey:kNewAuthTokenKey];
	
}
-(void) getMemberInfo
{
	NSMutableDictionary *args = [NSMutableDictionary dictionaryWithObjectsAndKeys: nil];
	
	[self performNiRequestwithGroup:kAuthenticationGroup andMethod:@"get_auth_user" andArgs:args andKey:kMemberInfoKey];
	
}

- (NSString *)authenticationToken
{
	return s_authenticationToken;
}

+ (NSString *)authenticationName
{
	return s_authenticationName;
}

- (BOOL)canReauthenticate
{
	NSError *error = nil;
	NSString *authenticationToken = [SFHFKeychainUtils getPasswordForUsername:kAuthenticationKeychainKey
                                                               andServiceName:kAuthenticationServiceName error:&error];
    
	return (nil != authenticationToken);
    
}

- (void)reauthenticate
{
	if([self canReauthenticate])
	{
		NSError *error = nil;
		s_authenticationToken = [[SFHFKeychainUtils getPasswordForUsername:kAuthenticationKeychainKey
															andServiceName:kAuthenticationServiceName error:&error] retain];
		
		_username = [[SFHFKeychainUtils getPasswordForUsername:kUsernameKeychainKey
												andServiceName:kAuthenticationServiceName error:&error] retain];
		
		[[SessionDataController currentSession] setUsername:_username];
		
		[[SessionDataController currentSession] setAuthenticationToken:s_authenticationToken];
        
		[self getMemberInfo];
	}
}

- (void)storeAuthenticationToken
{
	if(s_authenticationToken)
	{
		NSError *error = nil;
		[SFHFKeychainUtils storeUsername:kAuthenticationKeychainKey
							 andPassword:s_authenticationToken
						  forServiceName:kAuthenticationServiceName
						  updateExisting:YES error:&error];
		
		if (error)
		{
			;//@FIXME
		}
		
		[SFHFKeychainUtils storeUsername:kUsernameKeychainKey
							 andPassword:[[SessionDataController currentSession] username]
						  forServiceName:kAuthenticationServiceName
						  updateExisting:YES error:&error];
		
		if (error)
		{
			;//@FIXME
		}
	}
}

- (void)storeAuthenticationName
{
	NSError *error = nil;
    [SFHFKeychainUtils storeUsername:kUsernameKeychainKey
                         andPassword:[[SessionDataController currentSession] username]
                      forServiceName:kAuthenticationServiceName
                      updateExisting:YES error:&error];
    
    if (error)
    {
        ;//@FIXME
    }
}

- (NSTimeInterval)lastActiveTime
{
	return s_lastActiveTime;
}

+ (void)setLastActiveTimeToCurrentTime
{
    
	s_lastActiveTime = CFAbsoluteTimeGetCurrent();
	[[NSUserDefaults standardUserDefaults] setDouble:s_lastActiveTime forKey:kLastActiveTimeKey];
	[[NSUserDefaults standardUserDefaults] synchronize];
}

- (void)setKeepMeSignInOn:(BOOL)rememberMe
{
    //	[self willChangeValueForKey:@"keepMeSignInOn"];
	s_keepMeSignInOn = rememberMe;
	[[NSUserDefaults standardUserDefaults] setBool:s_keepMeSignInOn forKey:kKeepMeSignIn];
    //	[self didChangeValueForKey:@"keepMeSignInOn"];
	[[NSUserDefaults standardUserDefaults] synchronize];
}


+ (Session *)currentSession
{
	if(nil == s_currentSession)
	{
		s_currentSession = [[Session alloc] init];
	}
	
	return s_currentSession;
}

#pragma mark TrafficCopCaller methods

-(void)dataReturnedFromTrafficCop:(NSData *)data withKey:(NSString *)key response:(NSURLResponse *)response
{
	NSError *error = nil;
	id parsedStructure = [self parsedStructureFromZeccoJsonData:data error:&error];
	
	if(error)
	{
		[delegate loginUnsuccessfulWithError:error];
		//Handle Error
		switch ([error code]) {
			case 101:
			case 102:
			case 103:
                //case 104:
			case 105:
			case 107:
			case 108:
			case 109:
			case 110:
			case 114:
			case 117:
			case 118:
			case 106:
			case 111:
			case 112:
			case 998:
			{
				//Logout if auth token is valid
				if (nil != s_authenticationToken)
				{
					NSMutableDictionary *args = [NSMutableDictionary dictionaryWithObjectsAndKeys: nil];
					[self performNiRequestwithGroup:kAuthenticationGroup andMethod:@"logout" andArgs:args andKey:kLogoutKey];
				}
				//Clear auth data
				[SessionDataController clearAuthenticationData];
				
				[[NSNotificationCenter defaultCenter] postNotification:[NSNotification notificationWithName:kSignoutNotification object:nil]];
				break;
			}
            case 104:
            {
                //Clear auth data
				[SessionDataController clearAuthenticationData];
				[[NSNotificationCenter defaultCenter] postNotification:[NSNotification notificationWithName:kSignoutNotification object:nil]];
				break;
            }
			default:
				break;
		}
		
		//[GATracker errorTrack:@"Login" Label:[[error userInfo] objectForKey:@"message" ] Code:[error code]];
		return;
	}
	
	if([key isEqualToString:kAuthenticationKey])
	{
        
		[s_currentSession release];
		s_currentSession = [[Session alloc] init];
		[s_currentSession fillFromDictionary:parsedStructure];
		[s_currentSession setUsername:_username];
        
		[s_authenticationToken release];
		s_authenticationToken = [[s_currentSession authenticationToken] retain];
        
        // fix bug 21982, update authentication name after login with new user
        [s_authenticationName release];
        s_authenticationName = [[s_currentSession username] retain];
        
        // TODO:
		//[_appDelegate setupUserForPushNotification];
		[delegate loginSuccessful];
	}
	else if([key isEqualToString:kLogoutKey])
	{
        
	}
	else if([key isEqualToString:kNewAuthTokenKey])
	{
		
	}
	else if([key isEqualToString:kMemberInfoKey])
	{
		[s_currentSession release];
		s_currentSession = [[Session alloc] init];
		[s_currentSession fillFromDictionary:parsedStructure];
		[s_currentSession setUsername:_username];
        
		[s_currentSession setAuthenticationToken:s_authenticationToken];
		
		[delegate loginSuccessful];
	}
}


- (void)dealloc
{
	[[TrafficCop sharedInstance] removeCaller:self];
	[_username release];
	[_password release];
	[super dealloc];
}
@end

