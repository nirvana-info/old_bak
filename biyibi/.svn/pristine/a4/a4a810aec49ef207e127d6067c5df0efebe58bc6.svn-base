//
//  NSNumber+CommaSeparator.m
//  Zecco
//
//  Created by sirish.jetti on 11/4/10.
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import "NSNumber+CommaSeparator.h"


@implementation NSNumber (CommaSeparator) 

static NSNumberFormatter *s_commaFormatter = nil;

- (NSString *)commaSeparatedString
{
	if (nil == s_commaFormatter)
	{
		s_commaFormatter = [[NSNumberFormatter alloc] init];
		[s_commaFormatter setGroupingSize:3];
		[s_commaFormatter setGroupingSeparator:@","];
		[s_commaFormatter setUsesGroupingSeparator:YES];		
	}
	return [s_commaFormatter stringFromNumber:self];
}

@end
