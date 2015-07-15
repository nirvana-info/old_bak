//
//  ConstantsFactory.m
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import "ConstantsFactory.h"
#import "UIColorCategories.h"

@interface ConstantsFactory (Private)

- (void)readConfigurationFile;

@end


@implementation ConstantsFactory

static ConstantsFactory *singleton;

+(ConstantsFactory *)sharedInstance
{
	@synchronized(self)
	{
		if(!singleton)
		{
			singleton = [[ConstantsFactory alloc] init];
		}
	}
	
	return singleton;
}


-(id)init
{
	if(self = [super init])
	{
		_colors = [[NSMutableDictionary alloc] init];
		_fonts = [[NSMutableDictionary alloc] init];
		
		_colorConfiguration = [[NSMutableDictionary alloc] init];
		_fontConfiguration = [[NSMutableDictionary alloc] init];
		
		[self readConfigurationFile];		
	}
	
	return self;
}

-(UIFont *)getConstantFont:(NSString *)fontConstantName
{
	//see if we've already generated the font
	UIFont *queriedFont = [_fonts objectForKey:fontConstantName];
	if(queriedFont)
	{
		return queriedFont;
	}
	
	//We don't have the font yet, so we need to generate it
	
	//first get the config
	NSDictionary *fontConfig = [_fontConfiguration objectForKey:fontConstantName];
	if(nil == fontConfig)
	{
		//we don't have that font config so return nil
		return nil;
	}
	
	UIFont *font = [UIFont fontWithName:[fontConfig objectForKey:@"typeface"] 
								   size:[[fontConfig objectForKey:@"size"] floatValue]];
	[_fonts setObject:font forKey:fontConstantName];
	return font;
}

-(UIColor *)getConstantColor:(NSString *)colorConstantName
{
	//see if we've already generated the color
	UIColor *queriedcolor = [_colors objectForKey:colorConstantName];
	if(queriedcolor)
	{
		return queriedcolor;
	}
	
	//We don't have the color yet, so we need to generate it
	
	//first get the config
	NSDictionary *colorConfig = [_colorConfiguration objectForKey:colorConstantName];
	if(nil == colorConfig)
	{
		//we don't have that color config so return nil
		return nil;
	}
	
	UIColor *color = nil;
	if([colorConfig objectForKey:@"hex"])
	{
		if ([colorConfig objectForKey:@"alpha"]) 
		{
			color = [[UIColor colorWithHexString:[colorConfig objectForKey:@"hex"]] 
					 colorWithAlphaComponent:[[colorConfig objectForKey:@"alpha"] floatValue]];
		} 
		else 
		{
			color = [UIColor colorWithHexString:[colorConfig objectForKey:@"hex"]];
		}
	}
	else {
		color = [UIColor colorWithRed:[[colorConfig objectForKey:@"red"] floatValue]
								green:[[colorConfig objectForKey:@"green"] floatValue]
								 blue:[[colorConfig objectForKey:@"blue"] floatValue]
								alpha:[[colorConfig objectForKey:@"alpha"] floatValue]];
	}

	[_colors setObject:color forKey:colorConstantName];
	return color;
}

+(id)alloc
{
	@synchronized(self)
	{
		NSAssert(singleton == nil, @"Attempted to allocate a second instance of a ConstantsFactory.");
		singleton = [super alloc];
	}
	
	return singleton;
}


-(void)dealloc
{
	[_colors release];
	[_fonts release];
	[_colorConfiguration release];
	[_fontConfiguration release];
	[super dealloc];	
}

@end

@implementation ConstantsFactory (Private)

- (void)readConfigurationFile
{
	//NSLog(@"start config read");
//	NSMutableString *constantDefs = [[NSMutableString alloc] init];  // Debug
	
	NSError *error = nil;
	NSString *configFile = [[NSString alloc] initWithContentsOfFile:[[NSBundle mainBundle] 
																	 pathForResource:@"ConstantColorsAndFonts" ofType:@"yml"] encoding:NSUTF8StringEncoding error:&error];
	
	NSArray *lines = [configFile componentsSeparatedByString:@"\n"];
	
	[configFile release];
	
	NSString *currentKey = nil;
	NSMutableDictionary *currentConfigDictionary = nil;
	for(NSString *line in lines)
	{
		//strip comments
		NSRange positionRange = [line rangeOfString:@"#"];
		if(positionRange.location != NSNotFound)
		{
			line = [line substringToIndex:positionRange.location];
		}
		
		//strip off whitespace
		line = [line stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceCharacterSet]];
		
		if([line length] == 0)
			continue;
		
		if([line hasPrefix:@"fonts:"])
		{
			currentConfigDictionary = _fontConfiguration;
			continue;
		}
		else if([line hasPrefix:@"colors:"])
		{
			currentConfigDictionary = _colorConfiguration;
			continue;
		}

		if([line hasSuffix:@":"])
		{
			currentKey = [line substringToIndex:[line length] - 1];
		}
		
		if([line hasPrefix:@"{"])
		{
			line = [line substringFromIndex:1];
			line = [line substringToIndex:[line length] - 1];
			line = [line stringByReplacingOccurrencesOfString:@"\"" withString:@""];
			NSArray *configParameters = [line componentsSeparatedByString:@","];
			NSMutableDictionary *configDictionary = [[NSMutableDictionary alloc] init];
			for(NSString *parameter in configParameters)
			{
				NSArray *keyAndValue = [parameter componentsSeparatedByString:@":"];
				if([keyAndValue count] > 1)
				{
					[configDictionary setObject:[[keyAndValue objectAtIndex:1] stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceCharacterSet]]
										 forKey:[[keyAndValue objectAtIndex:0] stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceCharacterSet]]];
				}
				
			}
			[currentConfigDictionary setObject:configDictionary forKey:currentKey];

//			// Debug:
//			if (currentConfigDictionary == _colorConfiguration) 
//			{
//				UIColor *tempColor = [self getConstantColor:currentKey];
//				[constantDefs appendFormat:@"#define %@\t\t\t@\"%@\"  // Legacy: alpha = %0.2f\n", currentKey, [tempColor hexStringFromColor], [tempColor alpha]];
//			}
//			else if (currentConfigDictionary == _fontConfiguration) 
//			{
//				UIFont *tempFont = [self getConstantFont:currentKey];
//				[constantDefs appendFormat:@"#define %@\t\t\t@\"%@\"  // Legacy: size = %0.2f\n", currentKey, [tempFont fontName], [tempFont pointSize]];
//			}
//			// End debug

			[configDictionary release];
			configDictionary = nil;
		}
	}
	
//	NSLog(@"\n\n** Constant colors and fonts:\n%@\n", constantDefs);  // Debug
//	[constantDefs release];  // Debug
	//NSLog(@"end config read");
}

@end

