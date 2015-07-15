//
//  NSNumber+Formatting.m
//
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import "NSNumber+Formatting.h"


@implementation NSNumber(Formatting)

static NSNumberFormatter *s_numberFormatter = nil;

- (NSString*) abbreviate
{
	double d = [self doubleValue];
	
	if(fabs(d) < 1000000) {
		if(nil == s_numberFormatter)
		{
			s_numberFormatter = [[NSNumberFormatter alloc] init];
			[s_numberFormatter setNumberStyle:NSNumberFormatterCurrencyStyle];
			[s_numberFormatter setNegativePrefix:@"-"];
			[s_numberFormatter setNegativeSuffix:@""];
		}
		
		return  [s_numberFormatter stringFromNumber:self];
	}
	else if(fabs(d) > 999999999) {
		// billions
		d /= 1000000000;
		return [NSString localizedStringWithFormat:@"%.2fB", d];
	}
	else {
		// millions
		d /= 1000000;
		return [NSString localizedStringWithFormat:@"%.2fM", d];
	}
}

- (NSString*) abbreviateDecimal
{
	double d = [self doubleValue];
	
	if(fabs(d) < 1000000) {
		if(nil == s_numberFormatter)
		{
			s_numberFormatter = [[NSNumberFormatter alloc] init];
			[s_numberFormatter setNumberStyle:NSNumberFormatterDecimalStyle];
			[s_numberFormatter setNegativePrefix:@"-"];
			[s_numberFormatter setNegativeSuffix:@""];
		}
		
		return  [s_numberFormatter stringFromNumber:self];
	}
	else if(fabs(d) > 999999999) {
		// billions
		d /= 1000000000;
		return [NSString localizedStringWithFormat:@"%.2fB", d];
	}
	else {
		// millions
		d /= 1000000;
		return [NSString localizedStringWithFormat:@"%.2fM", d];
	}
}
	
@end
