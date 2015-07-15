//
//  SessionDataController.h
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "BaseDataController.h"
#import "Session.h"

@protocol SessionDataControllerDelegate

- (void)loginSuccessful;
- (void)loginUnsuccessfulWithError:(NSError *)error;

@end


@interface SessionDataController : BaseDataController  {
	NSObject<SessionDataControllerDelegate> *delegate;
	NSString *_username;
	NSString *_password;
	
    //	BOOL _keepMeSignInOn;
	
}

@property (nonatomic, assign) NSObject<SessionDataControllerDelegate> *delegate;


- (void)loginWithUsername:(NSString *)username andPassword:(NSString *)password rememberMe:(BOOL)rememberMe;
- (void)logout;
- (void)getNewAuthToken;
- (void)getMemberInfo;

- (NSString *)authenticationToken;
+ (NSString *)authenticationName;
- (BOOL)canReauthenticate;
- (void)reauthenticate;
- (void)storeAuthenticationToken;
- (void)storeAuthenticationName;

- (NSTimeInterval)lastActiveTime;
- (void)setKeepMeSignInOn:(BOOL)rememberMe;
//@property (nonatomic, assign) BOOL keepMeSignInOn;

+ (void)setLastActiveTimeToCurrentTime;
+ (Session *)currentSession;
+ (BOOL)loggedIn;
+ (BOOL)keepMeSignInOn;
+ (BOOL)rememberMeOn;
+ (BOOL)authTokenExists;
+ (void)clearAuthenticationData;

@end
