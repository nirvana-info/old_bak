//
//  NSNumber+Formatting.h
//
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import <Foundation/Foundation.h>


@interface NSNumber(Formatting)

// this will shorten numbers in the millions to "xM" and numbers in the billions to "xB", where "x" is the shortened number
- (NSString*) abbreviate;
- (NSString*) abbreviateDecimal;


@end
