//
//  NiUrlRequest.m
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "NiUrlRequest.h"
#import "JSON.h"

#define kAPIAppID @"442557C2-90CB-4D0A-A013-9B094E68596F"

@implementation NiUrlRequest

+ (NiUrlRequest *)NiURLRequestWithURL:(NSURL *)url arguments:(NSMutableDictionary *)arguments
{
	NiUrlRequest *request = [[[NiUrlRequest alloc] initWithURL:url] autorelease];
	[arguments setObject:kAPIAppID forKey:@"appId"];
	[arguments setObject:[NSNumber numberWithInt:2] forKey:@"type"];
//	[arguments setObject:[[UIDevice currentDevice] uniqueIdentifier] forKey:@"uniqueID"];
//	
//	NSString *authToken = [[SessionDataController currentSession] authenticationToken];
//	NSString *memberId  = [[SessionDataController currentSession] memberId];
//	
//	if(nil != authToken)
//	{
//		[arguments setObject:authToken forKey:@"authTkn"];
//	}
//	if(nil != memberId)
//	{
//		[arguments setObject:memberId forKey:@"mId"];
//	}
	
	[request setHTTPMethod:@"POST"];
	NSString *postString = [[NSString alloc] initWithFormat:
							@"Object=%@",[arguments JSONRepresentation]];
	[request setHTTPBody:[postString dataUsingEncoding:NSUTF8StringEncoding]];
	[postString release];
	
	return request;
}

+ (NiUrlRequest *)NiURLRequestWithURL:(NSURL *)url
{
	NiUrlRequest *request = [[[NiUrlRequest alloc] initWithURL:url] autorelease];
	
	return request;
}

@end