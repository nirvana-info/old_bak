//
//  NSNumber+Currency.m
//  Zecco
//
//  Created by bryce.hammond on 10/06/10.
//  Copyright 2010 Wall Street On Demand, Inc. All rights reserved.
//

#import "NSNumber+Currency.h"

#define DEFAULT_CURRENCY_DECIMAL_PLACES 2

@implementation NSNumber (CurrencyFormatting)

static NSNumberFormatter *__localizedFormatter = nil;
static NSLocale *__localeEnUs = nil;

- (void)constructLocalizedFormatter
{
    __localizedFormatter = [[NSNumberFormatter alloc] init];
    [__localizedFormatter setFormatterBehavior:NSNumberFormatterBehavior10_4];
	[__localizedFormatter setNumberStyle:NSNumberFormatterDecimalStyle];
	[__localizedFormatter setCurrencySymbol:@"¥"];
	[__localizedFormatter setNegativePrefix:@"-"];
	[__localizedFormatter setNegativeSuffix:@""];
    
    __localeEnUs = [[NSLocale alloc] initWithLocaleIdentifier:@"en_US"];
    [__localizedFormatter setLocale:__localeEnUs];
}

#pragma mark currency methods

// this is the granddaddy method of all, fully customizable (except for showing the currency symbol, which I don't
// this is very useful in this app)
- (NSString*) currencyWithMaxDecimalPlaces:(int) maxPlaces minDecimalPlaces:(int) minPlaces showPostivePrefix:(BOOL) showPositivePrefix
{
	if(nil == __localizedFormatter)
	{
        [self constructLocalizedFormatter];
	}
	
	[__localizedFormatter setMinimumFractionDigits:minPlaces];
	[__localizedFormatter setMaximumFractionDigits:maxPlaces];
	if(showPositivePrefix) {
		// Apple formatter thinks 0 is a positive, so only set the prefix if it's greater than 0
		if([self doubleValue] > 0) {
			[__localizedFormatter setPositivePrefix:@"+"];
		}
		else {
			[__localizedFormatter setPositivePrefix:@""];
		}
	}
	else {
		[__localizedFormatter setPositivePrefix:@""];
	}

	NSString *returnString = [__localizedFormatter stringFromNumber:self];
	return returnString;    
}

- (NSString *)currencyValue
{
	return [self currencyWithMaxDecimalPlaces:DEFAULT_CURRENCY_DECIMAL_PLACES minDecimalPlaces:DEFAULT_CURRENCY_DECIMAL_PLACES showPostivePrefix:NO];
}


// this version of currencyValue will display the + sign for positive numbers
- (NSString *)currencyValueWithPositiveSign
{
	return [self currencyWithMaxDecimalPlaces:DEFAULT_CURRENCY_DECIMAL_PLACES minDecimalPlaces:DEFAULT_CURRENCY_DECIMAL_PLACES showPostivePrefix:YES];
}

- (NSString *)currencyValueWithMaxFractionDigits:(int)max andMinFractionDigits:(int)min
{
	return [self currencyWithMaxDecimalPlaces:max minDecimalPlaces:min showPostivePrefix:NO];
}

// These are the best ones to use
+ (NSString*) currencyWithDouble:(double)aDouble maxDecimalPlaces:(int)maxPlaces minDecimalPlaces:(int) minPlaces showPositivePrefix:(BOOL) positivePrefix
{
	return [[self numberWithDouble:aDouble] currencyWithMaxDecimalPlaces:maxPlaces minDecimalPlaces:minPlaces showPostivePrefix:positivePrefix];
}

+ (NSString*) currencyWithDouble:(double)aDouble decimalPlaces:(int)places showPositivePrefix:(BOOL) positivePrefix
{
	return [self currencyWithDouble:aDouble maxDecimalPlaces:places minDecimalPlaces:places showPositivePrefix:positivePrefix];
}

// defaults to no postive prefix
+ (NSString*) currencyWithDouble:(double)aDouble decimalPlaces:(int)places
{
	return [self currencyWithDouble:aDouble decimalPlaces:places showPositivePrefix:NO];
}

// defaults to no postive prefix and default decimal places (4)
+ (NSString*) currencyWithDouble:(double)aDouble
{ 
	if ((aDouble < 0 && aDouble > -0.01) || (aDouble > 0 && aDouble < 0.01)) {
		return [self currencyWithDouble:aDouble decimalPlaces:2 showPositivePrefix:NO];
	}
	else {
		return [self currencyWithDouble:aDouble decimalPlaces:DEFAULT_CURRENCY_DECIMAL_PLACES showPositivePrefix:NO];
	}
}

+ (NSString *)currencyValueWithDouble:(double)aDouble
{
    return [[self numberWithDouble:aDouble] currencyValue];
}

+ (NSString *)currencyValueWithPositiveSignForDouble:(double)aDouble
{
    return [[self numberWithDouble:aDouble] currencyValueWithPositiveSign];
}

// defaults to no postive prefix and default decimal places (2)
+ (NSString*) pureCurrencyWithDouble:(double)aDouble
{
	//NSString *strV = [self currencyWithDouble:aDouble];
    NSString *strV = [[self numberWithDouble:aDouble] currencyWithMaxDecimalPlaces:2 minDecimalPlaces:0 showPostivePrefix:NO];
    return [strV stringByReplacingOccurrencesOfString:@"," withString:@""];
}

@end
