///	
/// @file		WSODConstants.m
/// 
///	Copyright 2010 Wall Street On Demand. All rights reserved.
///	


#import "WSODConstants.h"
#import "UIColorCategories.h"


@implementation WSODConstants

@synthesize persistentColors = _persistentColors;

static WSODConstants *s_singleton;


#pragma mark Superclass overrides

+ (id)alloc
{
	@synchronized(self)
	{
		NSAssert(s_singleton == nil, @"Attempted to allocate a second instance of a WSODConstants or subclass.");
		s_singleton = [super alloc];
	}
	
	return s_singleton;
}

- (id)init
{
	if (self = [super init])
	{
		_persistentColors = [[NSMutableDictionary alloc] init];
	}
	
	return self;
}

- (void)dealloc
{
	[_persistentColors release];
	_persistentColors = nil;
	[super dealloc];	
}


#pragma mark Custom class methods

/// Access the singleton instance of this class (intended for internal use).
///
+ (WSODConstants *)sharedInstance
{
	@synchronized(self)
	{
		if (!s_singleton)
		{
			s_singleton = [[WSODConstants alloc] init];
		}
	}
	
	return s_singleton;
}

/// Get an autoreleased color object as specified in the passed constant key.
///
+ (UIColor *)colorWithKey:(NSString *)constantName {
	// See if we've already generated the color
	UIColor *newColor = [[[WSODConstants sharedInstance] persistentColors] objectForKey:constantName];
	if (newColor)
	{
		return newColor;
	}
	
	// We don't have the color yet, so we need to generate it
	newColor = [[UIColor alloc] initWithHexString:constantName];
	if (newColor) {  // Safety
		[[[WSODConstants sharedInstance] persistentColors] setObject:newColor forKey:constantName];
		[newColor release];
	}
	return newColor;
}


@end

