//
//  ConstantsFactory.h
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//
// Gets constant objects (fonts and colors) whose configuration is stored
// in the ConstantColorsAndFonts.plist file.  Other objects can use this class
// to get common color or font objects.

#import <UIKit/UIKit.h>

@interface ConstantsFactory : NSObject {
	NSMutableDictionary *_colors;
	NSMutableDictionary *_fonts;
	
	NSMutableDictionary *_colorConfiguration;
	NSMutableDictionary *_fontConfiguration;
}

+(ConstantsFactory *)sharedInstance;
-(UIFont *)getConstantFont:(NSString *)fontConstantName;
-(UIColor *)getConstantColor:(NSString *)colorConstantName;

@end
