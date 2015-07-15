//
//  Session.m
//  Zecco
//
//  Created by bryce.hammond on 9/23/10.
//  Copyright 2010 Wall Street On Demand, Inc. All rights reserved.
//

#import "Session.h"

@implementation Session


@synthesize authenticationToken = _authenticationToken;
@synthesize memberId = _memberId;
@synthesize username = _username;
@synthesize sharedUserCookie = _sharedUserCookie;

- (id)init
{
	if(self = [super init])
	{

	}
	
	return self;
}

- (void)fillFromDictionary:(NSDictionary *)dict
{
	[self setAuthenticationToken:[[dict objectForKey:@"authTkn"] stringValue]];
	[self setMemberId:[[dict objectForKey:@"mId"] stringValue]];
    [self setUsername:[dict objectForKey:@"username"]];
    
    if([dict objectForKey:@"username"] && [NSNull null] != [dict objectForKey:@"username"])
	{
		[self setSharedUserCookie:[dict objectForKey:@"username"]];
	}	
}



- (void)dealloc
{

	[_authenticationToken release];
	[_memberId release];
	[_username release];
    [_sharedUserCookie release];
	[super dealloc];
}

@end
