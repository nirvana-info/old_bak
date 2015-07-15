///	
/// @file		WSODConstants.h
/// 
///	Copyright 2010 Wall Street On Demand. All rights reserved.
///	


/// 
/// @mainpage	WSOD Constants Framework
/// @version	1
/// 
/// Provides a convenient way to access commonly-used colors in an app. 
/// This class is intended to be subclassed; define colors as hex strings 
/// in your Constants subclass:
///    #define ccMyColor   @"33B6FA"  // 'cc' prefix for 'constant color' 
/// then access them in code with:
///	   [AppNameConstants colorWithKey:ccMyColor]
///
/// This also provides auto-completion and compile-time confirmation that 
/// the constant has been defined. Internally, instantiated colors are 
/// retained to save on UIColor objects.



#import <UIKit/UIKit.h>


@interface WSODConstants : NSObject {
	NSMutableDictionary *_persistentColors;  // Maps constant keys to UIColors
}

@property (nonatomic, retain) NSMutableDictionary *persistentColors;

/// Access the singleton instance of this class (intended for internal use).
+ (WSODConstants *)sharedInstance;

/// Get an autoreleased color object as specified in the passed constant key.
+ (UIColor *)colorWithKey:(NSString *)constantName;  // Always opaque

@end
