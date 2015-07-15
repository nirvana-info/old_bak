//
//  AreaProvince.m
//  biyibi
//
//  Created by nirvana on 5/2/13.
//  Copyright (c) 2013 nirvana. All rights reserved.
//

#import "AreaProvince.h"

@implementation AreaProvince
@synthesize provinceCode = _provinceCode;
@synthesize provinceValue = _provinceValue;
@synthesize cityData = _cityData;

-(void) dealloc{
    [_provinceCode dealloc];
    [_provinceValue dealloc];
    [_cityData dealloc];
    [super dealloc];
}

@end
