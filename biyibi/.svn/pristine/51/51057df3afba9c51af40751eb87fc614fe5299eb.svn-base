//
//  Steels.m
//  NiMobile
//
//  Created by nirvana on 5/15/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "Steels.h"

@implementation Steels

@synthesize
photoUrl = _photoUrl,
name = _name,
steelCode = _steelCode;


- (void)fillFromDictionary:(NSDictionary *)dict
{
    [self setPhotoUrl:[dict objectForKey:@"photourl"]];
    [self setName:[dict objectForKey:@"name"]];
    [self setSteelCode:[dict objectForKey:@"steelCode"]];
}

- (void)dealloc
{
    [_photoUrl release];
    [_name release];
    [_steelCode release];
 	[super dealloc];
}

@end
