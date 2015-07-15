//
//  NSNumber+Currency.h
//  Zecco
//
//  Created by bryce.hammond on 10/06/10.
//  Copyright 2010 Wall Street On Demand, Inc. All rights reserved.
//

#import <Foundation/Foundation.h>


@interface NSNumber (CurrencyFormatting)

// these default to 2 decimal places
- (NSString *)currencyValue;
- (NSString *)currencyValueWithPositiveSign;
// this one you can specify how many decimal places you want
- (NSString *)currencyValueWithMaxFractionDigits:(int)max andMinFractionDigits:(int)min;
// this is the most customizable one
- (NSString*) currencyWithMaxDecimalPlaces:(int) maxPlaces minDecimalPlaces:(int) minPlaces showPostivePrefix:(BOOL) showPositivePrefix;


// fully customizable
+ (NSString*) currencyWithDouble:(double)aDouble maxDecimalPlaces:(int)maxPlaces minDecimalPlaces:(int) minPlaces showPositivePrefix:(BOOL) positivePrefix;
// max and min places are the same
+ (NSString*) currencyWithDouble:(double)aDouble decimalPlaces:(int)places showPositivePrefix:(BOOL) positivePrefdix;
// defaults to no postive prefix
+ (NSString*) currencyWithDouble:(double)aDouble decimalPlaces:(int)places;
// defaults to no postive prefix and default decimal places (4)
+ (NSString*) currencyWithDouble:(double)aDouble;

+ (NSString*) pureCurrencyWithDouble:(double)aDouble;


@end
