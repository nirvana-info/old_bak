//
//  Session.h
//  Zecco
//
//  Created by bryce.hammond on 9/23/10.
//  Copyright 2010 Wall Street On Demand, Inc. All rights reserved.
//

#import <Foundation/Foundation.h>

@class ZeccoAccount;

@interface Session : NSObject {
	NSString *_authenticationToken;
	NSString *_memberId;
	NSString *_username;
    NSString *_sharedUserCookie;
}

@property (nonatomic, retain) NSString *authenticationToken;
@property (nonatomic, retain) NSString *memberId;
@property (nonatomic, retain) NSString *username;
@property (nonatomic, retain) NSString *sharedUserCookie;

- (void)fillFromDictionary:(NSDictionary *)dictionary;

@end
