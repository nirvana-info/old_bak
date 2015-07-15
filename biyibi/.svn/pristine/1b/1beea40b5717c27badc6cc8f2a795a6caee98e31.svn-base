//
//  MemberInfo.m
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "MemberInfo.h"

@implementation MemberInfo

@synthesize
mname = _mname,
gender = _gender,
photoUrl = _photoUrl,
distance = _distance,
comments = _comments,
company = _company,
mobile = _mobile,
province = _province,
proviceCode = _provinceCode,
city = _city,
cityCode = _cityCode,
categories = _categories;

- (void)fillFromDictionary:(NSDictionary *)dict
{
	[self setMname:[dict objectForKey:@"name"]];
	[self setGender:[[dict objectForKey:@"gender"] intValue]];
    [self setDistance:[[dict objectForKey:@"distance"] doubleValue]];
	[self setPhotoUrl:[dict objectForKey:@"photourl"]];
	[self setComments:[dict objectForKey:@"comments"]];
	
}
- (void)dealloc
{
	[_mname release];
	[_photoUrl release];
	[_comments release];
    [_company release];
    [_mobile release];
    [_province release];
    [_provinceCode release];
    [_city release];
    [_cityCode release];
    [_categories release];
	[super dealloc];
}

@end
