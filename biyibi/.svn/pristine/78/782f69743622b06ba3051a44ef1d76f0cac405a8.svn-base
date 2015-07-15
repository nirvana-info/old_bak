//
//  NSDate+Category.m
//
//  Copyright 2010 Wall Street On Demand, Inc. All rights reserved.
//

#import "NSDate+Category.h"


@implementation NSDate (Extra)

- (NSString*) howLongAgoWas:(NSDate*) otherDate
{
	if(otherDate == nil) {
		return @"";
	}
		
	NSCalendar *calendar = [NSCalendar currentCalendar];
	NSDateComponents *components = [calendar components:(NSDayCalendarUnit|NSHourCalendarUnit|NSMinuteCalendarUnit|NSWeekCalendarUnit) 
											   fromDate:otherDate
												 toDate:self
												options:0];
	int weeks = [components week];
	int days = [components day];
	int hours = [components hour];
	int minutes = [components minute];
	
	if(weeks > 0) {
		return [NSString stringWithFormat:@"%d week%s ago", weeks, (weeks>1? "s":"")];
	}
	else if(days > 0) {
		return [NSString stringWithFormat:@"%d day%s ago", days, (days>1? "s":"")];
	}
	else if(hours > 0) {
		return [NSString stringWithFormat:@"%d hour%s ago", hours, (hours>1? "s":"")];
	}
	else {
		return [NSString stringWithFormat:@"%d minute%s ago", minutes, (minutes>1? "s":"")];
	}
}

- (NSString*) howLongAgoWithinADayWas:(NSDate *)otherDate
{
	// Days ago revert to date format if days >1	

	if(otherDate == nil) {
		return @"";
	}
	
	NSCalendar *calendar = [NSCalendar currentCalendar];
	NSDateComponents *components = [calendar components:(NSDayCalendarUnit|NSHourCalendarUnit|NSMinuteCalendarUnit|NSWeekCalendarUnit) 
											   fromDate:otherDate
												 toDate:self
												options:0];
	int days = [components day];
	int hours = [components hour];
	int minutes = [components minute];
	
	if(days > 0) {
		if (days>1) {
			NSDateFormatter *dateFormatter = [[[NSDateFormatter alloc] init]autorelease];
			[dateFormatter setLocale:[[[NSLocale alloc] initWithLocaleIdentifier:@"en_US"] autorelease]];
			[dateFormatter setTimeZone:[NSTimeZone timeZoneWithName:@"GMT"]];
			[dateFormatter setDateFormat:@"MM/dd/YY hh:mm a 'ET'"];
			return [dateFormatter stringFromDate:otherDate];
		}
		return [NSString stringWithFormat:@"%d day%s ago", days, (days>1? "s":"")];
	}
	else if(hours > 0) {
		return [NSString stringWithFormat:@"%d hour%s ago", hours, (hours>1? "s":"")];
	}
	else {
		return [NSString stringWithFormat:@"%d minute%s ago", minutes, (minutes>1? "s":"")];
	}
}

@end
