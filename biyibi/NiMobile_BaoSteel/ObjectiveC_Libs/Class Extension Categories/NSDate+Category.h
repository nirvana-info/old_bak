//
//  NSDate+Category.h
//
//  Copyright 2010 Wall Street On Demand, Inc. All rights reserved.
//

#import <Foundation/Foundation.h>


@interface NSDate (Extra) 
	// this prints out "x units ago", where x is some number and units is "minutes", "days", "weeks", etc
	- (NSString*) howLongAgoWas:(NSDate*) otherDate;
	// this prints out "x units ago", where x is some number and units is "minutes", "days",
	//But if days > 1, prints out just the date in MM/dd/YY hh:mm a 'ET' format
- (NSString*) howLongAgoWithinADayWas:(NSDate *)otherDate;

@end
