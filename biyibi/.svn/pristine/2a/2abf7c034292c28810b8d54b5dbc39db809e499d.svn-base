//
//  MemberInfo.m
//  NiMobile
//
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "ProductInfo.h"

@implementation ProductInfo

@synthesize
photoUrl = _photoUrl,
name = _name,
weight = _weight,
price = _price,
qualityInfo = _qualityInfo,
service = _service,
code = _code,
origin = _origin,
place = _place,
size = _size,
sizeInfo = _sizeInfo,
comments = _comments,
stock = _stock,
company = _company;

- (void)fillFromDictionary:(NSDictionary *)dict
{
    [self setPhotoUrl:[dict objectForKey:@"photourl"]];
    [self setName:[dict objectForKey:@"name"]];
    [self setWeight:[dict objectForKey:@"weight"]];
    [self setPrice:[[dict objectForKey:@"price"] doubleValue]];
    [self setQualityInfo:[dict objectForKey:@"qualityInfo"]];
    [self setService:[dict objectForKey:@"service"]];
    [self setCode:[dict objectForKey:@"code"]];
    [self setOrigin:[dict objectForKey:@"origin"]];
    [self setPlace:[dict objectForKey:@"place"]];
    [self setSize:[dict objectForKey:@"size"]];
    [self setSizeInfo:[dict objectForKey:@"sizeInfo"]];
    [self setStock:[[dict objectForKey:@"stock"] intValue]];
	[self setComments:[dict objectForKey:@"comments"]];
    [self setCompany:[dict objectForKey:@"company"]];
	
}
- (void)dealloc
{
    [_photoUrl release];
    [_name release];
    [_weight release];
    [_qualityInfo release];
    [_service release];
    [_code release];
    [_origin release];
    [_place release];
    [_size release];
    [_sizeInfo release];
    [_comments release];
    [_company release];
    
	[super dealloc];
}

@end
