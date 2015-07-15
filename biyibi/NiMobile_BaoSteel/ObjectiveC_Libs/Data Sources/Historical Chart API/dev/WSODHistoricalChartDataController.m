///	
/// @file		WSODHistoricalChartDataController.m
/// 
///	Copyright 2010 Wall Street On Demand. All rights reserved.
///	


#import "WSODHistoricalChartDataController.h"

// HTTP response header field where chart colors are retrieved.
#define kChartColorsResponseHeaderField		@"X-Colors"

// Cache-related constants.
#define	kSerializedImageDataKey				@"WSODHistoricalChartSerializedImageDataKey"
#define	kSerializedColorDictionaryKey		@"WSODHistoricalChartSerializedColorDictionaryKey"
#define kCacheFileExtension					@"cache"

// Parameter string constants as defined by the chart server. 
#define kHistoricalChartParameterPeriod							@"Period"
#define kHistoricalChartParameterStdDev							@"StdDev"
#define kHistoricalChartParameterFast							@"Fast"
#define kHistoricalChartParameterSlow							@"Slow"
#define kHistoricalChartParameterSmoothing						@"Smoothing"
#define kHistoricalChartParameterType							@"Type"
#define kHistoricalChartParameterShowExtraordinaryItems			@"ShowExtraordinaryItems"
#define kHistoricalChartParameterEmaPeriod						@"emaPeriod"
#define kHistoricalChartParameterDifferencePeriod				@"differencePeriod"
#define kHistoricalChartParameterKPeriod						@"KPeriod"
#define kHistoricalChartParameterDPeriod						@"DPeriod"

// Color label string constants as defined by the chart server.
#define kWSODHistoricalChartColorLabelBollinger					@"Bollinger Bands"
#define kWSODHistoricalChartColorLabelEMA						@"EMA"
#define kWSODHistoricalChartColorLabelSMA						@"SMA"
#define kWSODHistoricalChartColorLabelWMA						@"WMA"
#define kWSODHistoricalChartColorLabelTSF						@"Time Series Forecast"

#define kWSODHistoricalChartColorLabelVolume					@"Volume"
#define kWSODHistoricalChartColorLabelMACD						@"MACD"
#define kWSODHistoricalChartColorLabelDivergence				@"Divergence"
#define kWSODHistoricalChartColorLabelPROC						@"Price Rate of Change"
#define kWSODHistoricalChartColorLabelVROC						@"Volume Rate of Change"
#define kWSODHistoricalChartColorLabelRollingEPS				@"Rolling EPS"
#define kWSODHistoricalChartColorLabelRSI						@"RSI"
#define kWSODHistoricalChartColorLabelDMI						@"DMI"
#define kWSODHistoricalChartColorLabelDMIPositive				@"DMI.+"
#define kWSODHistoricalChartColorLabelDMINegative				@"DMI.-"
#define kWSODHistoricalChartColorLabelPERatio					@"P/E Ratio"
#define kWSODHistoricalChartColorLabelChaikinsVolatility		@"Chaikins Volatility"
#define kWSODHistoricalChartColorLabelStochasticsFast			@"Stochastics"
#define kWSODHistoricalChartColorLabelStochasticsFastPercentK	@"%K"
#define kWSODHistoricalChartColorLabelStochasticsFastPercentD	@"%D"
#define kWSODHistoricalChartColorLabelStochasticsSlow			@"Stochastics"
#define kWSODHistoricalChartColorLabelStochasticsSlowPercentK	@"%K"
#define kWSODHistoricalChartColorLabelStochasticsSlowPercentD	@"%D"
#define kWSODHistoricalChartColorLabelVolumePlus				@"Volume"

////////////////////////////////////////////////////////////////////////////////////////////////////
#pragma mark -

static NSDictionary*	s_overlayColorLabelGroups	= nil;
static NSDictionary*	s_indicatorColorLabelGroups	= nil;

@interface WSODHistoricalChartDataController (Private)

/*--------------------------------------------------------------------------------------* 
	These dictionaries map overlay types and indicator types to an array of labels 
	(label groups). After retrieving a label group from one of these dictionaries, send 
	it to -generateUniqueColorKeysForColorLabelGroup:, which will return an array of 
	unique labels that can be used as keys in _colorDictionary.
	*NOTE*: Please do not access these dictionaries directly. Use their accessors.
 *--------------------------------------------------------------------------------------*/

// Accessors
- (NSDictionary*)		overlayColorLabelGroups;
- (NSDictionary*)		indicatorColorLabelGroups;

/*--------------------------------------------------------------------------------------* 
 -colorDictionaryAssociatedWithColorLabelGroup:
	Returns an NSDictionary of UIColor objects from _colorDictionary which are associated 
	with the labels found in the specified array.
	Params:
		labelGroup - Array of color labels.
	Returns: 
		Success: a dictionary of 1 or more label/color key/value pairs. 
		Failure: nil.
 *--------------------------------------------------------------------------------------*/
- (NSDictionary*) colorDictionaryAssociatedWithColorLabelGroup:(NSArray*)labelGroup;

/*--------------------------------------------------------------------------------------* 
 -colorLabelGroupForGroupName:
	Searches the overlay and indicator label group dictionaries for an array of labels that 
	has groupName as its first element. If groupName is a number (indicating that it is a 
	WSODIssue comparison index) then a dictionary containing groupName and its associated 
	color is returned.
	Params:
		groupName - Label used to identify a label group. For example, a label group consisting
		of {@"MACD", @"EMA", @"Divergence"} has the groupName, @"MACD".
	Returns: 
		Success: a dictionary of label/color key/value pairs. 
		Failure: nil.
 *--------------------------------------------------------------------------------------*/
- (NSArray*) colorLabelGroupForGroupName:(NSString*)groupName;
	
/*--------------------------------------------------------------------------------------* 
-colorKeyByCombiningGroupName:andColorLabel:
	Combines groupName and colorLabel.
	Params:
		groupName - Label used to identify a label group. For example, a label group consisting
		of {@"MACD", @"EMA", @"Divergence"} has the groupName, @"MACD".
		colorLabel- Label associated with the groupName.
	Returns: 
		Success: A string, representing the combination of groupName and colorLabel.
		Failure: nil.
 *--------------------------------------------------------------------------------------*/
- (NSString*) colorKeyByCombiningGroupName:(NSString*)groupName andColorLabel:(NSString*)colorLabel;

/*--------------------------------------------------------------------------------------* 
 -generateUniqueColorKeysForColorLabelGroup:
	Generates unique keys for each label in the specified label group. Each generated key
	can then be used to store/access colors in _colorDictionary. Color labels retrieved 
	from the HTTP response header are not all unique, hence the importance of this method.
	Params:
		labelGroup - Array of color labels.
	Returns:
		Success: an array containing "unique" versions of the labels in labelGroup, which
		can be used as keys with overlayColorLabelGroups and indicatorColorLabelGroups.
		Failure: nil.
 *--------------------------------------------------------------------------------------*/
- (NSArray*) generateUniqueColorKeysForColorLabelGroup:(NSArray*)labelGroup;	 

/*--------------------------------------------------------------------------------------* 
 -elementKeyForElement:
	Returns the label key associated with elementType, which can be used as a key into the
	_colorDictionary.
	Params:
		elementType - identifier for a color label.
 *--------------------------------------------------------------------------------------*/
- (NSString*) elementKeyForElement:(HistoricalChartElementType)elementType;

/*--------------------------------------------------------------------------------------* 
 -colorForElementKey:
	Returns either the UIColor associated with the specified elementKey, or the default 
	color if no color is found.
	*Note* 
		This method should not be used to determine whether a color exists because nil
		is never returned -- use -colorExistsForElementKey:.
 *--------------------------------------------------------------------------------------*/	
- (UIColor*) colorForElementKey:(NSString*)elementKey;

/*--------------------------------------------------------------------------------------* 
 -colorExistsForElementKey:
	Returns TRUE if a valid color is associated with the specified elementKey.
 *--------------------------------------------------------------------------------------*/	
- (BOOL) colorExistsForElementKey:(NSString*)elementKey;

/*--------------------------------------------------------------------------------------* 
 -setColor:forElementKey:inColorDictionary:
	If color is a valid color, it is added to colorDict at key elementKey. If color is not
	valid, the default color is added instead.
	Params:
		color - the color to add to the color dictionary. If nil, NSNull, or not a 
		UIColor, the defaultColor is used instead.
		elementKey - The key used to reference color in colorDict. If nil, an exception is 
		raised by the NSMutableDictionary.
		colorDict - dictionary in which the color/elementKey pair shall be set.
 *--------------------------------------------------------------------------------------*/
- (void)setColor:(id)color forElementKey:(NSString*)elementKey inColorDictionary:(NSMutableDictionary*)colorDict;

/*--------------------------------------------------------------------------------------* 
 -parameterKeyForParameter:
	Returns the label key associated with parameterType, which can be used as a key into the
	_colorDictionary.
	Params:
		parameterType - identifier for a parameter.
 *--------------------------------------------------------------------------------------*/
//- (NSString*) parameterKeyForParameter:(HistoricalChartParameterType)parameterType;

/*--------------------------------------------------------------------------------------* 
 -parseHttpResponse:
	Parses an HTTP response for data such as the chart's color information.
	Params:
		response - HTTP response that shall be parsed.
 *--------------------------------------------------------------------------------------*/
- (void) parseHttpResponse:(NSHTTPURLResponse*)response;

/*--------------------------------------------------------------------------------------* 
 -serializeCacheWithImageData:writeToPath:
	Serializes the imageData along with the _colorDictionary and writes the data to path.
	Params:
		imageData	- Image data that will be included in the cache.
		path		- File-system path to the cache file.
 *--------------------------------------------------------------------------------------*/
- (void) serializeCacheWithImageData:(NSData*)imageData writeToPath:(NSString*)path;

/*--------------------------------------------------------------------------------------* 
 -deserializeCacheAtPath:retrieveChartImage:retrieveColorDictionary:
	Deserializes the cache at path.
	Params:
		path		- File-system path to the cache file.
		chartImage	- Pointer to the deserialized chart image.
		colorDict	- Pointer to the deserialized color dictionary.
 *--------------------------------------------------------------------------------------*/
- (void) deserializeCacheAtPath:(NSString*)path retrieveChartImage:(UIImage**)chartImagePtr retrieveColorDictionary:(NSDictionary**)colorDictPtr;

- (NSString *)dataPeriod;
- (NSString *)dataInterval;
- (NSString *)chartAPIRequestString;

@end

////////////////////////////////////////////////////////////////////////////////////////////////////
#pragma mark -

@implementation WSODHistoricalChartDataController

@synthesize delegate = _delegate, chartType = _chartType, symbol = _symbol, companyName = _companyName, issueType = _issueType;
@synthesize numberOfDays = _numberOfDays, realTimeData = _realTimeData;
@synthesize comparisonSymbol = _comparisonSymbol, comparisonLabel = _comparisonLabel;
@synthesize overlayType = _overlayType, overlayLabel = _overlayLabel, overlayParams = _overlayParams;
@synthesize indicatorType = _indicatorType, indicatorLabel = _indicatorLabel, indicatorParams = _indicatorParams;
@synthesize tmpCachePath = _tmpCachePath;
@synthesize colorDictionary = _colorDictionary;
@synthesize defaultColor = _defaultColor;

static NSString* s_sessionID = nil;  // Used to limit caching to within a single session only

#pragma mark -
#pragma mark Superclass overrides

+ (void)initialize
{
	// We will use NSTemporaryDirectory to store cached chart images within sessions, but that doesn't guarantee 
	// they are erased between sessions, so we create a timestamp-based session ID and use it in the cache path.
	NSDateFormatter *formatter = [[NSDateFormatter alloc] init];
	[formatter setDateFormat:@"yyyyMMddHHmmSS"];
	s_sessionID = [[formatter stringFromDate:[NSDate date]] retain];
	[formatter release];
}

- (id)init
{
	if (self = [super init]) 
	{
		NSString *sessionCachePath = [NSString stringWithFormat:@"/historical_charts/session_%@", s_sessionID];
		[self setTmpCachePath:[NSTemporaryDirectory() stringByAppendingPathComponent:sessionCachePath]];
		
		// Create the temporary cache folder
		NSError *error = nil;
		[[NSFileManager defaultManager] createDirectoryAtPath:_tmpCachePath 
								  withIntermediateDirectories:YES 
												   attributes:nil 
														error:&error];
		if (error) {
			if (kHistoricalChartLogLevel) DLog(@"** Error: Unable to create historical charts temp cache path (%@), error = %@", _tmpCachePath, error);
			[self setTmpCachePath:nil];  // Used later to test to see if we have a cache set up
		}
		
		[self setChartType:HistoricalChartTypeMountain];  // Default chart style is CloseMountain
		[self setNumberOfDays:90];  // Default timeframe is three months
		_realTimeData = NO;  // Default: delayed data
		
		_issueType = @"equity";
		
		_colorDictionary = nil;
		_defaultColor = nil;
	}
	return self;
}

- (void)dealloc 
{
	[[TrafficCop sharedInstance] removeCaller:self];
	
	[_symbol release];						_symbol = nil;
	[_companyName release];					_companyName = nil;
	[_comparisonSymbol release];			_comparisonSymbol = nil;
	[_comparisonLabel release];				_comparisonLabel = nil;
	[_overlayLabel release];				_overlayLabel = nil;
	[_overlayParams release];				_overlayParams = nil;
	[_indicatorLabel release];				_indicatorLabel = nil;
	[_indicatorParams release];				_indicatorParams = nil;
	[_tmpCachePath release];				_tmpCachePath = nil;
	
	[_colorDictionary release];				_colorDictionary = nil;
	self.defaultColor = nil;

	[s_overlayColorLabelGroups release];	s_overlayColorLabelGroups = nil;
	[s_indicatorColorLabelGroups release];	s_indicatorColorLabelGroups = nil;
	
    [super dealloc];
}

#pragma mark -
#pragma mark Accessors

- (UIColor*) defaultColor
{
	// Apply a hard-default should _defaultColor become nil.
	if (nil == _defaultColor)
	{
		self.defaultColor = [UIColor blackColor];
	}
	
	return _defaultColor;
}

#pragma mark -
#pragma mark Custom instance methods

- (void)setComparisonSymbol:(NSString *)symbol label:(NSString *)label 
{
	[self setComparisonSymbol:symbol];
	[self setComparisonLabel:label];
}

- (void)removeComparison 
{
	[self setComparisonSymbol:nil];
	[self setComparisonLabel:nil];
}

- (void)setOverlay:(HistoricalChartOverlayType)type label:(NSString *)label params:(NSDictionary *)params 
{
	[self setOverlayType:type];
	[self setOverlayLabel:label];
	[self setOverlayParams:params];
}

- (void)removeOverlay 
{
	[self setOverlayType:HistoricalChartOverlayTypeNone];
	[self setOverlayLabel:nil];
	[self setOverlayParams:nil];
}

- (void)setIndicator:(HistoricalChartIndicatorType)type label:(NSString *)label params:(NSDictionary *)params 
{
	[self setIndicatorType:type];
	[self setIndicatorLabel:label];
	[self setIndicatorParams:params];
}

- (void)removeIndicator 
{
	[self setIndicatorType:HistoricalChartIndicatorTypeNone];
	[self setIndicatorLabel:nil];
	[self setIndicatorParams:nil];
}

- (void)refreshChartUsingCache:(BOOL)useCache 
{
	NSString *plainAPIString	= [self chartAPIRequestString];
	NSString *keyString			= [NSString md5:plainAPIString];
	
	// If caching is requested (and we have a valid cache path), look in the temp cache first
	if (useCache && _tmpCachePath) 
	{
		NSString*				filePath	= [_tmpCachePath stringByAppendingFormat:@"%@.%@", keyString, kCacheFileExtension];
		UIImage*				chartImage	= nil;
		NSMutableDictionary*	colorDict	= nil;

		// Deserialize the cache and obtain the chart image and color dictionary.
		[self deserializeCacheAtPath:filePath retrieveChartImage:&chartImage retrieveColorDictionary:&colorDict];
		
		// If a chart image was retrieved, set the _colorDictionary to the newly retrieved colorDict and inform
		// the delegate about the new chart image.
		if (nil != chartImage)
		{
			[_colorDictionary release]; 
			_colorDictionary = colorDict;
			
			[_delegate chartIsReady:chartImage fromCache:YES];
			return;
		}
	}
	
	// No cached image was found, so kick off a request to the API
	NSString *encodedAPIString = [plainAPIString stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding];
	NSMutableURLRequest *request = [[[NSMutableURLRequest alloc] initWithURL:[NSURL URLWithString:encodedAPIString]] autorelease];
	[[TrafficCop sharedInstance] performRequest:request 
								   withPriority:TrafficCopNormalPriority
							 returnDataToObject:self 
										withKey:keyString];
	
	if (kHistoricalChartLogLevel) DLog(@"Requesting large historical chart with URL: \n\n%@\n\n", [[[request URL] absoluteString] 
																								   stringByReplacingPercentEscapesUsingEncoding:NSUTF8StringEncoding]);
}

- (NSString *)dataIntervalLabel 
{
	return [NSString stringWithFormat:@"%@-%@ data", [self dataInterval], [self dataPeriod]];
}

- (NSDictionary*) comparisonColorDictionary
{
	NSMutableDictionary* colors = nil;
	
	// Proceed only if the color dictionary is defined.
	if (nil != [self colorDictionary]) 
	{
		// Get object from color dictionary.
		id object = [[self colorDictionary] objectForKey:_comparisonSymbol];

		// Init colors dictionary, if needed.
		if (nil == colors) 
		{
			colors = [NSMutableDictionary dictionaryWithCapacity:1];
		}
		
		// Ensure a color is set in colors dictionary for key _comparisonSymbol.
		[self setColor:object forElementKey:_comparisonSymbol inColorDictionary:colors];
	}
	
	return colors;
}

- (NSDictionary*) overlayColorDictionary
{
	NSArray* colorLabelGroup = [[self overlayColorLabelGroups] objectForKey:[NSNumber numberWithInt:_overlayType]];

	return [self colorDictionaryAssociatedWithColorLabelGroup:colorLabelGroup];
	
////////////
/// Since it's probably only a matter of time before this class is modified to allow for multiple overlays, here's 
/// an implementation for it, which assumes that the current overlay types are stored as NSNumbers in an
/// NSArray.
///
//	NSMutableDictionary* colorDictionary = nil;
//	
//	if (0 < [_overlayTypesArray count]) 
//	{
//		NSDictionary* tempColorDictionary = nil;
//		
//		// For each overlay type, add it's associated colors to the color dictionary.
//		for (NSNumber* overlayType in _overlayTypesArray)
//		{
//			NSArray* colorLabelGroup = [[self indicatorColorLabelGroups] objectForKey:overlayType];
//			
//			tempColorDictionary = [self colorDictionaryAssociatedWithColorLabelGroup:colorLabelGroup];
//			
//			if (tempColorDictionary) 
//			{
//				if (nil == colorDictionary) 
//				{
//					colorDictionary = [NSMutableDictionary dictionaryWithCapacity:[_overlayTypesArray count]];
//				}
//				
//				[colorDictionary addEntriesFromDictionary:tempColorDictionary];
//			}
//		}
//	}
//	
//	return colorDictionary;
}

- (NSDictionary*) indicatorColorDictionary
{
	NSArray* colorLabelGroup = [[self indicatorColorLabelGroups] objectForKey:[NSNumber numberWithInt:_indicatorType]];

	return [self colorDictionaryAssociatedWithColorLabelGroup:colorLabelGroup];
	
////////////
/// Since it's probably only a matter of time before this class is modified to allow for multiple indicators, here's 
/// an implementation for it, which assumes that the current indicator types are stored as NSNumbers in an
/// NSArray.
///
//	NSMutableDictionary* colorDictionary = nil;
//	
//	if (0 < [_indicatorTypesArray count]) 
//	{
//		NSDictionary* tempColorDictionary = nil;
//		
//		// For each indicator type, add it's associated colors to the color dictionary.
//		for (NSNumber* indicatorType in _indicatorTypesArray)
//		{
//			NSArray* colorLabelGroup = [[self indicatorColorLabelGroups] objectForKey:indicatorType];
//			
//			tempColorDictionary = [self colorDictionaryAssociatedWithColorLabelGroup:colorLabelGroup];
//			
//			if (tempColorDictionary) 
//			{
//				if (nil == colorDictionary) 
//				{
//					colorDictionary = [NSMutableDictionary dictionaryWithCapacity:[_indicatorTypesArray count]];
//				}
//				
//				[colorDictionary addEntriesFromDictionary:tempColorDictionary];
//			}
//		}
//	}
//	
//	return colorDictionary;
}

- (UIColor*) colorForElement:(HistoricalChartElementType)elementType
{
	return [self colorForElementKey:[self elementKeyForElement:elementType]];
}

- (UIColor*) colorForComparisonSymbol:(NSString*)comparisonSymbol
{
	return [self colorForElementKey:comparisonSymbol];
}

- (BOOL) colorExistsForElement:(HistoricalChartElementType)elementType
{
	return [self colorExistsForElementKey:[self elementKeyForElement:elementType]];
}

- (BOOL) colorExistsForComparisonSymbol:(NSString*)comparisonSymbol
{
	return [self colorExistsForElementKey:comparisonSymbol];
}

//- (NSString*) argumentForParameter:(HistoricalChartParameterType)parameterType 
//						 ofElement:(HistoricalChartElementType)elementType
//{
//	return @"";
//}

#pragma mark -
#pragma mark Private methods

- (NSDictionary*) overlayColorLabelGroups
{
	if (nil == s_overlayColorLabelGroups) 
	{
		s_overlayColorLabelGroups = 
		[[NSDictionary alloc] initWithObjectsAndKeys:
		 [NSArray arrayWithObjects:
		  kWSODHistoricalChartColorLabelBollinger, 
		  kWSODHistoricalChartColorLabelSMA, nil],									[NSNumber numberWithInt:HistoricalChartOverlayTypeBollinger],
		 [NSArray arrayWithObject:kWSODHistoricalChartColorLabelEMA],				[NSNumber numberWithInt:HistoricalChartOverlayTypeEMA],
		 [NSArray arrayWithObject:kWSODHistoricalChartColorLabelSMA],				[NSNumber numberWithInt:HistoricalChartOverlayTypeSMA],
		 [NSArray arrayWithObject:kWSODHistoricalChartColorLabelWMA],				[NSNumber numberWithInt:HistoricalChartOverlayTypeWMA],
		 [NSArray arrayWithObject:kWSODHistoricalChartColorLabelTSF],				[NSNumber numberWithInt:HistoricalChartOverlayTypeTSF], nil];
	}
	
	return s_overlayColorLabelGroups;
}

- (NSDictionary*) indicatorColorLabelGroups
{
	if (nil == s_indicatorColorLabelGroups) 
	{
		s_indicatorColorLabelGroups =
		[[NSDictionary alloc] initWithObjectsAndKeys:					 
		 [NSArray arrayWithObject:kWSODHistoricalChartColorLabelVolume],			[NSNumber numberWithInt:HistoricalChartIndicatorTypeVolume],
		 
		 [NSArray arrayWithObjects:
		  kWSODHistoricalChartColorLabelMACD, 
		  kWSODHistoricalChartColorLabelEMA, 
		  kWSODHistoricalChartColorLabelDivergence, nil],							[NSNumber numberWithInt:HistoricalChartIndicatorTypeMACD],
		 
		 [NSArray arrayWithObject:kWSODHistoricalChartColorLabelPROC],				[NSNumber numberWithInt:HistoricalChartIndicatorTypePROC],
		 
		 [NSArray arrayWithObject:kWSODHistoricalChartColorLabelVROC],				[NSNumber numberWithInt:HistoricalChartIndicatorTypeVROC],
		 
		 [NSArray arrayWithObject:kWSODHistoricalChartColorLabelRollingEPS],		[NSNumber numberWithInt:HistoricalChartIndicatorTypeRollingEPS],
		 
		 [NSArray arrayWithObject:kWSODHistoricalChartColorLabelRSI],				[NSNumber numberWithInt:HistoricalChartIndicatorTypeRSI],
		 
		 [NSArray arrayWithObjects:
		  kWSODHistoricalChartColorLabelDMI,
		  kWSODHistoricalChartColorLabelDMIPositive,
		  kWSODHistoricalChartColorLabelDMINegative, nil],								[NSNumber numberWithInt:HistoricalChartIndicatorTypeDMI],
		 
		 [NSArray arrayWithObject:kWSODHistoricalChartColorLabelPERatio],			[NSNumber numberWithInt:HistoricalChartIndicatorTypePERatio],
		 
		 [NSArray arrayWithObject:kWSODHistoricalChartColorLabelChaikinsVolatility],[NSNumber numberWithInt:HistoricalChartIndicatorTypeChaikinsVolatility],
		 
		 [NSArray arrayWithObjects:
		  kWSODHistoricalChartColorLabelStochasticsFast, 
		  kWSODHistoricalChartColorLabelStochasticsFastPercentK, 
		  kWSODHistoricalChartColorLabelStochasticsFastPercentD, nil],				[NSNumber numberWithInt:HistoricalChartIndicatorTypeStochasticsFast],
		 
		 [NSArray arrayWithObjects:
		  kWSODHistoricalChartColorLabelStochasticsSlow, 
		  kWSODHistoricalChartColorLabelStochasticsSlowPercentK,
		  kWSODHistoricalChartColorLabelStochasticsSlowPercentD, nil],				[NSNumber numberWithInt:HistoricalChartIndicatorTypeStochasticsSlow],
		 
		 [NSArray arrayWithObject:kWSODHistoricalChartColorLabelVolumePlus],		[NSNumber numberWithInt:HistoricalChartIndicatorTypeVolumePlus], nil];
	}
	
	return s_indicatorColorLabelGroups;
}

- (NSDictionary*) colorDictionaryAssociatedWithColorLabelGroup:(NSArray*)labelGroup
{
	NSMutableDictionary* colors = nil;

	// Proceed only if the color dictionary is defined.
	if (nil != [self colorDictionary]) 
	{
		NSArray* uniqueGroupedColorLabels = [self generateUniqueColorKeysForColorLabelGroup:labelGroup];

		// Iterate through the grouped color labels.
		for (NSString* colorLabel in uniqueGroupedColorLabels)
		{
			// Get object from color dictionary.
			id object = [[self colorDictionary] objectForKey:colorLabel];
			
			// Init colors dictionary, if needed.
			if (nil == colors) 
			{
				colors = [NSMutableDictionary dictionaryWithCapacity:1];
			}
			
			// Ensure a color is set in colors dictionary for key colorLabel.
			[self setColor:object forElementKey:colorLabel inColorDictionary:colors];
		}
	}

	return colors;
}

- (NSArray*) colorLabelGroupForGroupName:(NSString*)groupName
{
	NSArray*		labelGroup		= nil;
	NSMutableArray*	allColorLabels	= [[NSMutableArray alloc] initWithCapacity:[[self overlayColorLabelGroups] count] + [[self indicatorColorLabelGroups] count]];
	
	[allColorLabels addObjectsFromArray:[[self overlayColorLabelGroups] allValues]];
	[allColorLabels addObjectsFromArray:[[self indicatorColorLabelGroups] allValues]];
	
	// Iterate through allColorLabels.
	for (NSArray* labels in allColorLabels)
	{
		// If the first element in labels is the groupName, then this is the label group we are interested in.
		if ([groupName isEqualToString:[labels objectAtIndex:0]]) 
		{
			labelGroup = labels;
			break;
		}
	}
	
	[allColorLabels release];
	
	// If we have not found a labelGroup, then test groupName to see if it is a comparison index.
	if (nil == labelGroup) 
	{
		NSScanner*	scanner	= [[NSScanner alloc] initWithString:groupName];
		NSString*	scannedDecimalCharacters = nil;
		
		// Scan decimal characters from groupName and place them in scannedDecimalCharacters.
		[scanner scanCharactersFromSet:[NSCharacterSet decimalDigitCharacterSet] intoString:&scannedDecimalCharacters];
		
		// If scannedDecimalCharacters is the same length as groupName, then groupName is a comparison index (WSODIssue).
		if ([groupName length] == [scannedDecimalCharacters length]) 
		{
			labelGroup = [NSArray arrayWithObject:groupName];
		}
		
		[scanner release];
	}
	
	return labelGroup;
}

- (NSString*) colorKeyByCombiningGroupName:(NSString*)groupName andColorLabel:(NSString*)colorLabel
{
	return [NSString stringWithFormat:@"%@:%@", groupName, colorLabel];
}

- (NSArray*) generateUniqueColorKeysForColorLabelGroup:(NSArray*)labelGroup
{
	NSMutableArray* uniqueColorKeys = nil;
	NSString*		groupName = nil;
	NSString*		uniqueKey = nil;
	
	// Iterate through the labels.
	for (NSString* label in labelGroup)
	{
		// Make the first label in the array the group name.
		if (nil == groupName) 
		{
			groupName = label;
			uniqueKey = [NSString stringWithString:groupName];
		}
		// Otherwise, the group name is defined, so prepend it to the label.
		else
		{
			uniqueKey = [self colorKeyByCombiningGroupName:groupName andColorLabel:label];
		}
		
		// Init uniqueColorKeys.
		if (nil == uniqueColorKeys) 
		{
			uniqueColorKeys = [NSMutableArray arrayWithCapacity:3]; // Most label groups have 3 labels or fewer.
		}
		
		// Add the unique key to the array.
		[uniqueColorKeys addObject:uniqueKey];
	}
	
	return uniqueColorKeys;
}
		
- (NSString*) elementKeyForElement:(HistoricalChartElementType)elementType
{
	NSString* elementKey = nil;
	
	switch (elementType) 
	{
		case HistoricalChartElementTypeBollinger:
			elementKey = kWSODHistoricalChartColorLabelBollinger;
			break;
			
		case HistoricalChartElementTypeBollingerSma:
			elementKey = [self colorKeyByCombiningGroupName:kWSODHistoricalChartColorLabelBollinger andColorLabel:kWSODHistoricalChartColorLabelSMA];
			break;
			
		case HistoricalChartElementTypeEma:
			elementKey = kWSODHistoricalChartColorLabelEMA;
			break;
			
		case HistoricalChartElementTypeSma:
			elementKey = kWSODHistoricalChartColorLabelSMA;
			break;
			
		case HistoricalChartElementTypeWma:
			elementKey = kWSODHistoricalChartColorLabelWMA;
			break;
			
		case HistoricalChartElementTypeTsf:
			elementKey = kWSODHistoricalChartColorLabelTSF;
			break;
			
		case HistoricalChartElementTypeVolume:
			elementKey = kWSODHistoricalChartColorLabelVolume;
			break;
			
		case HistoricalChartElementTypeMacd:
			elementKey = kWSODHistoricalChartColorLabelMACD;
			break;
			
		case HistoricalChartElementTypeMacdEma:
			elementKey = [self colorKeyByCombiningGroupName:kWSODHistoricalChartColorLabelMACD andColorLabel:kWSODHistoricalChartColorLabelEMA];
			break;
			
		case HistoricalChartElementTypeMacdDivergence:
			elementKey = [self colorKeyByCombiningGroupName:kWSODHistoricalChartColorLabelMACD andColorLabel:kWSODHistoricalChartColorLabelDivergence];
			break;
			
		case HistoricalChartElementTypeProc:
			elementKey = kWSODHistoricalChartColorLabelPROC;
			break;
			
		case HistoricalChartElementTypeVroc:
			elementKey = kWSODHistoricalChartColorLabelVROC;
			break;
			
		case HistoricalChartElementTypeRollingEps:
			elementKey = kWSODHistoricalChartColorLabelRollingEPS;
			break;
			
		case HistoricalChartElementTypeRsi:
			elementKey = kWSODHistoricalChartColorLabelRSI;
			break;
			
		case HistoricalChartElementTypeDmi:
			elementKey = kWSODHistoricalChartColorLabelDMI;
			break;
			
		case HistoricalChartElementTypeDmiPositive:
			elementKey = [self colorKeyByCombiningGroupName:kWSODHistoricalChartColorLabelDMI andColorLabel:kWSODHistoricalChartColorLabelDMIPositive];
			break;
			
		case HistoricalChartElementTypeDmiNegative:
			elementKey = [self colorKeyByCombiningGroupName:kWSODHistoricalChartColorLabelDMI andColorLabel:kWSODHistoricalChartColorLabelDMINegative];
			break;
			
		case HistoricalChartElementTypePeRatio:
			elementKey = kWSODHistoricalChartColorLabelPERatio;
			break;
			
		case HistoricalChartElementTypeChaikinsVolatility:
			elementKey = kWSODHistoricalChartColorLabelChaikinsVolatility;
			break;
			
		case HistoricalChartElementTypeStochasticsFast:
			elementKey = kWSODHistoricalChartColorLabelStochasticsFast;
			break;
			
		case HistoricalChartElementTypeStochasticsFastPercentK:
			elementKey = [self colorKeyByCombiningGroupName:kWSODHistoricalChartColorLabelStochasticsFast andColorLabel:kWSODHistoricalChartColorLabelStochasticsFastPercentK];
			break;
			
		case HistoricalChartElementTypeStochasticsFastPercentD:
			elementKey = [self colorKeyByCombiningGroupName:kWSODHistoricalChartColorLabelStochasticsFast andColorLabel:kWSODHistoricalChartColorLabelStochasticsFastPercentD];
			break;
			
		case HistoricalChartElementTypeStochasticsSlow:
			elementKey = kWSODHistoricalChartColorLabelStochasticsSlow;
			break;
			
		case HistoricalChartElementTypeStochasticsSlowPercentK:
			elementKey = [self colorKeyByCombiningGroupName:kWSODHistoricalChartColorLabelStochasticsSlow andColorLabel:kWSODHistoricalChartColorLabelStochasticsSlowPercentK];
			break;
			
		case HistoricalChartElementTypeStochasticsSlowPercentD:
			elementKey = [self colorKeyByCombiningGroupName:kWSODHistoricalChartColorLabelStochasticsSlow andColorLabel:kWSODHistoricalChartColorLabelStochasticsSlowPercentD];
			break;
			
		case HistoricalChartElementTypeVolumePlus:
			elementKey = kWSODHistoricalChartColorLabelVolumePlus;
			break;
	}
	
	return elementKey;
}

- (UIColor*) colorForElementKey:(NSString*)elementKey
{
	id object = [_colorDictionary objectForKey:elementKey];
	
	// If the object obtained from _colorDictionary is either nil or not a UIColor object,
	// return the default color.
	if (nil == object || ![object isKindOfClass:[UIColor class]]) 
	{
		object = self.defaultColor;
	}
	
	return (UIColor*)object;
}

- (BOOL) colorExistsForElementKey:(NSString*)elementKey
{
	BOOL colorExists = FALSE;
	
	id object = [_colorDictionary objectForKey:elementKey];
	
	// If object is defined and is a UIColor object, the color exists.
	if (nil != object && [object isKindOfClass:[UIColor class]]) 
	{
		colorExists = TRUE;
	}
	
	return colorExists;
}

- (void)setColor:(id)color forElementKey:(NSString*)elementKey inColorDictionary:(NSMutableDictionary*)colorDict
{
	NSAssert( colorDict != nil, @"Color dictionary cannot be nil!" );
	
	UIColor* finalColor;
	
	// If color is either nil or not an UIColor object, use the default color instead.
	if (nil == color || ![color isKindOfClass:[UIColor class]])
	{
		finalColor = self.defaultColor;
	}
	else 
	{
		finalColor = (UIColor*)color;
	}

	// Set newColor for elementKey in colorDict.
	[colorDict setObject:finalColor forKey:elementKey];
}

- (void) parseHttpResponse:(NSHTTPURLResponse*)response
{
	[_colorDictionary release]; _colorDictionary = nil;
		
	if (nil != response) 
	{
		// Obtain header data.
		NSDictionary* headerInfo = [response allHeaderFields];

//		NSLog(@"HTTP Header: %@", headerInfo);

		// Parse color data sent in the response header. The format is label1,colorValue1|label2,colorValue2 etc.
		NSArray* labelValuePairs = [[headerInfo objectForKey:kChartColorsResponseHeaderField] componentsSeparatedByString:@"|"];
		
		if (nil != labelValuePairs) 
		{
			NSMutableArray* uniqueColorKeys = nil;
			
			// Loop through the label,value pairs in colorGroups.
			for (NSString* labelValuePair in labelValuePairs)
			{
				NSArray* labelAndValue = [labelValuePair componentsSeparatedByString:@","];

				// Skip groups which do not have values.
				if ([labelAndValue count] > 1) 
				{
					// Retrieve label and value, removing '#' and '"' characters from the hex color value.
					NSString* labelString = [labelAndValue objectAtIndex:0];
					NSString* valueString = [[labelAndValue objectAtIndex:1] stringByTrimmingCharactersInSet:[NSCharacterSet punctuationCharacterSet]];
					
					// Ensure unique color keys are generated if needed. Each iteration through the surrounding for-loop will pop a unique 
					// key from uniqueColorKeys, which will (hopefully!) be appropriate for the current valueString. If the uniqueColorKeys 
					// array becomes empty, it will be redefined here. This implementation assumes that colors are always received in the same order.
					if (nil == uniqueColorKeys || 0 == [uniqueColorKeys count])
					{
						uniqueColorKeys = (NSMutableArray*)[self generateUniqueColorKeysForColorLabelGroup:
															[self colorLabelGroupForGroupName:labelString]];
					}

					// Add color to the color dictionary if a key is available. Remove key from uniqueColorKeys.
					if (0 < [uniqueColorKeys count])
					{
						// Init _colorDictionary.
						if (nil == _colorDictionary)
						{
							_colorDictionary = [[NSMutableDictionary alloc] init];
						}
						
						// If value is not 6 characters, it cannot be a hex color value, so add NSNull.
						if (6 != [valueString length]) 
						{
							[_colorDictionary setObject:[NSNull null]
												 forKey:[uniqueColorKeys objectAtIndex:0]];
						}
						// Otherwise, create a UIColor from valueString and add it to the color dictionary.
						else
						{
							[_colorDictionary setObject:[UIColor colorWithHexString:valueString] 
												 forKey:[uniqueColorKeys objectAtIndex:0]];
						}
						
						// Remove the key at index 0 since we just used it.
						[uniqueColorKeys removeObjectAtIndex:0];
					}
				}
			}
		}
	}	
	
//	NSLog(@"Color dictionary: %@", _colorDictionary);
}

- (void) serializeCacheWithImageData:(NSData*)imageData writeToPath:(NSString*)path
{
	NSMutableData*		cacheData = [[NSMutableData alloc] init];
	NSKeyedArchiver*	archiver = [[NSKeyedArchiver alloc] initForWritingWithMutableData:cacheData];
	
	// Encode image data and color dictionary.
	[archiver encodeObject:imageData forKey:kSerializedImageDataKey];
	[archiver encodeObject:_colorDictionary forKey:kSerializedColorDictionaryKey];
	[archiver finishEncoding];
	[archiver release];
	
	NSError* error = nil;
	[cacheData writeToFile:path options:0 error:&error];
	[cacheData release];
	
	if (!error) 
	{
		if (kHistoricalChartLogLevel > 1) DLog(@"Wrote cache to file (at %@)", path);
	} 
	else 
	{
		if (kHistoricalChartLogLevel) DLog(@"** Error: Failed to create a cache file (at %@), error = %@", path, error);
	}
}

- (void) deserializeCacheAtPath:(NSString*)path retrieveChartImage:(UIImage**)chartImagePtr retrieveColorDictionary:(NSDictionary**)colorDictPtr
{
	NSAssert( nil == chartImagePtr || *chartImagePtr == nil,	@"chartImagePtr seems to point at valid data, which could result in a memory leak!" );
	NSAssert( nil == colorDictPtr || *colorDictPtr == nil,		@"colorDictPtr seems to point at valid data, which could result in a memory leak!" );
	
	NSError*	error		= nil;
	NSData*		cacheData	= [[NSData alloc] initWithContentsOfFile:path options:0 error:&error];
	
	if (!error) 
	{
		NSKeyedUnarchiver*	unarchiver	= [[NSKeyedUnarchiver alloc] initForReadingWithData:cacheData];
		UIImage*			chartImage	= nil;
		NSDictionary*		colorDict	= nil;
		
		if (kHistoricalChartLogLevel > 1) DLog(@"Read cache file (at %@)", path);
			
		// Unarchive chart image.
		chartImage = [UIImage imageWithData:[unarchiver decodeObjectForKey:kSerializedImageDataKey]];
		
		// If an image was found, unarchive color information.
		if (nil != chartImage)
		{
			if (kHistoricalChartLogLevel > 1) DLog(@"Successfully retrieved cached chart image.");
			
			// Unarchive color dictionary.
			colorDict = [[unarchiver decodeObjectForKey:kSerializedColorDictionaryKey] retain];
			
			if (nil != colorDict) 
			{
				if (kHistoricalChartLogLevel > 1) DLog(@"Successfully retrieved cached color dictionary.");
			}
			else 
			{
				if (kHistoricalChartLogLevel > 1) DLog(@"Tried to retrieve color dictionary but it was not found in the cache.");
			}
		}
		else 
		{
			if (kHistoricalChartLogLevel > 1) DLog(@"Tried to retrieve chart image but it was not found in the cache.");
		}

		// If a chart image pointer is available, set its dereferenced value equal to the deserialized data.
		if (nil != chartImagePtr) 
		{
			*chartImagePtr	= chartImage;
		}
		
		// If a color dictionary pointer is available, set its dereferenced value equal to the deserialized data.
		if (nil != colorDictPtr) 
		{
			*colorDictPtr	= colorDict;
		}
		
		[unarchiver finishDecoding];
		[unarchiver release];
	}
	else
	{
		if (kHistoricalChartLogLevel) DLog(@"** Error: Failed to read cache file (at %@), error = %@", path, error);
	}

	[cacheData release];
}


- (NSString *)dataPeriod 
{
	if (_numberOfDays >= 36500)
	{
		return @"Month";		// Use monthly periods for 100 years of data.
	}
	else if (_numberOfDays > 365) 
	{
		return @"Week";
	}
	else if (_numberOfDays <= 7)  // Use intraday intervals
	{
		return @"Minute";
	}
	else 
	{
		return @"Day";  // Default (use interday intervals)
	}
}

- (NSString *)dataInterval 
{
	if (1 == _numberOfDays) 
	{
		return @"5";
	}
	else if	(2 == _numberOfDays)
	{
		return @"10";
	}
	else if	(2 < _numberOfDays && _numberOfDays <= 7)
	{
		return @"30";
	}
	else
	{
		return @"1";	// Default (ignored by ChartServer/DrawingServer unless dataPeriod is "Minute")
	}
	
	//	switch (_numberOfDays) {
	//		case 1:
	//			return @"5";  // 5-minute rollups
	//		case 2:
	//			return @"10";  // 10-minute rollups
	//		case 7:
	//			return @"30";  // 30-minute rollups
	//		default:
	//			return @"1";  // Default (ignored by ChartServer/DrawingServer unless dataPeriod is "Minute")
	//	}
}

- (NSString *)chartAPIRequestString
{
	// Build top-level chart request parameters
	NSMutableArray *requestParams = [[NSMutableArray alloc] init];
	[requestParams addObject:[NSString stringWithFormat:@"Symbol=%@", _symbol]];
	[requestParams addObject:[NSString stringWithFormat:@"issueType=%@",_issueType]];
	[requestParams addObject:[NSString stringWithFormat:@"NumberOfDays=%i", _numberOfDays]];
	[requestParams addObject:[NSString stringWithFormat:@"DataPeriod=%@", [self dataPeriod]]];
	[requestParams addObject:[NSString stringWithFormat:@"DataInterval=%@", [self dataInterval]]];
	[requestParams addObject:[NSString stringWithFormat:@"Drawing.Width=%0.0f", [_delegate chartSize].width]];
	[requestParams addObject:[NSString stringWithFormat:@"Drawing.ScaleFactor=%0.4f", [_delegate screenScaleFactor]]];
	[requestParams addObject:[NSString stringWithFormat:@"RealTime=%@", (_realTimeData ? @"True" : @"False")]];
	
	if (_comparisonSymbol)  // There is a comparison
	{
		[requestParams addObject:[NSString stringWithFormat:@"Comparisons=%@", _comparisonSymbol]];
	}
	
	if([_delegate respondsToSelector:@selector(symbolset)])
	{
		NSString *symbolset = [_delegate symbolset];
		if([symbolset length] > 0)
		{
			[requestParams addObject:[NSString stringWithFormat:@"symbolset=%@", symbolset]];
		}
	}
	
	// Start building the Panels parameter of the request
	NSMutableArray *panels = [[NSMutableArray alloc] init];
	CGFloat upperHeight = [_delegate chartSize].height;  // Default
	CGFloat lowerHeight = 0;  // Default (no indicator)
	
	// Build the Indicator (second) panel first, so we know if it has a height
	NSString *indicatorString = nil;
	if (_indicatorType != HistoricalChartIndicatorTypeNone)  // There is an indicator
	{
		upperHeight = floor([_delegate chartSize].height * .85);
		lowerHeight = ([_delegate chartSize].height - upperHeight);
		
		// Pull and format the params
		NSMutableArray *indicatorParamStrings = [[NSMutableArray alloc] init];
		for (NSString *indicatorKey in [_indicatorParams allKeys])
		{
			[indicatorParamStrings addObject:[NSString stringWithFormat:@"{\"Key\":\"%@\",\"Value\":\"%@\"}", 
											  indicatorKey, [_indicatorParams objectForKey:indicatorKey]]];
		}
		// Identify the string for this type
		NSString *indicatorTypeString = @"";
		switch (_indicatorType) {
			case HistoricalChartIndicatorTypeVolume: indicatorTypeString = @"Volume"; break;
			case HistoricalChartIndicatorTypeMACD: indicatorTypeString = @"MACD"; break;
			case HistoricalChartIndicatorTypePROC: indicatorTypeString = @"PriceRateOfChange"; break;
			case HistoricalChartIndicatorTypeVROC: indicatorTypeString = @"VolumeRateOfChange"; break;
			case HistoricalChartIndicatorTypeRollingEPS: indicatorTypeString = @"RollingEPS"; break;
			case HistoricalChartIndicatorTypeRSI: indicatorTypeString = @"RSI"; break;
			case HistoricalChartIndicatorTypeDMI: indicatorTypeString = @"DMI"; break;
			case HistoricalChartIndicatorTypePERatio: indicatorTypeString = @"PERatio"; break;
			case HistoricalChartIndicatorTypeChaikinsVolatility: indicatorTypeString = @"ChaikinsVolatility";break;
			case HistoricalChartIndicatorTypeStochasticsFast: indicatorTypeString = @"Stochastics";break;
			case HistoricalChartIndicatorTypeStochasticsSlow: indicatorTypeString = @"Stochastics";break;
			case HistoricalChartIndicatorTypeVolumePlus: indicatorTypeString = @"VolumePlus"; break;
			default: break;
		}
		indicatorString = [NSString stringWithFormat:@"{\"ExportData\":1,\"Height\":%0.0f,\"Type\":\"%@\",\"Parameters\":[%@]}", 
						   lowerHeight, 
						   indicatorTypeString, 
						   [indicatorParamStrings componentsJoinedByString:@","]];
		[indicatorParamStrings release];
	}
	
	// Start building the first (top) panel
	NSString *chartTypeString = @"";
	NSString *chartTypeParameterString = @"";
	switch (_chartType) {
		case HistoricalChartTypeLine: chartTypeString = @"CloseLine"; break;
		case HistoricalChartTypeMountain: chartTypeString = @"CloseMountain"; break;
		case HistoricalChartTypeOHLC: chartTypeString = @"OHLC"; break;
		case HistoricalChartTypeCandle: 
		{
			chartTypeString = @"Candlestick"; 
			chartTypeParameterString=@"{\"Key\":\"ShowCloseChange\", \"Value\":\"true\"}";
			break;	
		}
		default: break;
	}
	
	// Build the Overlays portion of the first (top) panel
	NSString *overlayString = @"";
	if (_overlayType != HistoricalChartOverlayTypeNone)  // There is an overlay
	{
		// Pull and format the params
		NSMutableArray *overlayParamStrings = [[NSMutableArray alloc] init];
		for (NSString *paramKey in [_overlayParams allKeys])
		{
			[overlayParamStrings addObject:[NSString stringWithFormat:@"{\"Key\":\"%@\",\"Value\":\"%@\"}", 
											paramKey, [_overlayParams objectForKey:paramKey]]];
		}
		// Identify the string for this type
		NSString *overlayTypeString = @"";
		switch (_overlayType) {
			case HistoricalChartOverlayTypeBollinger: overlayTypeString = @"BollingerBands"; break;
			case HistoricalChartOverlayTypeEMA: overlayTypeString = @"EMA"; break;
			case HistoricalChartOverlayTypeSMA: overlayTypeString = @"SMA"; break;
			case HistoricalChartOverlayTypeWMA: overlayTypeString = @"WMA"; break;
			case HistoricalChartOverlayTypeTSF: overlayTypeString = @"TimeSeriesForecast"; break;
			default:break;
		}
		overlayString = [NSString stringWithFormat:@"{\"ExportData\":1,\"Type\":\"%@\",\"Parameters\":[%@]}", 
						 overlayTypeString,
						 [overlayParamStrings componentsJoinedByString:@","]];
		
		[overlayParamStrings release];
	}
	
	[panels addObject:[NSString stringWithFormat:@"{\"ExportData\":1,\"Height\":%0.0f,\"Scaling\":\"Linear\",\"Type\":\"%@\",\"ShowXAxis\":\"true\",%@,%@}",
					   upperHeight, 
					   chartTypeString, 
					   [NSString stringWithFormat:@"\"Overlays\":[%@]", overlayString],
					   [NSString stringWithFormat:@"\"Parameters\":[%@]",chartTypeParameterString]]];
	if (indicatorString) 
	{
		[panels addObject:indicatorString];
	}
	
	// Complete the Panels parameter of the request, and add it to the top-level list
	[requestParams addObject:[NSString stringWithFormat:@"Panels={\"Panels\":[%@]}", 
							  [panels componentsJoinedByString:@","]]];
	[panels release];
	
	NSString *requestString = [NSString stringWithFormat:@"%@?%@", [_delegate chartAPIURL], [requestParams componentsJoinedByString:@"&"]];
	[requestParams release];
	
	return requestString;
}

#pragma mark -
#pragma mark TrafficCopCaller delegate methods

- (void)dataReturnedFromTrafficCop:(NSData *)data withKey:(NSString *)key response:(NSURLResponse *)response
{
	// Parse response header.
	[self parseHttpResponse:(NSHTTPURLResponse*)response];
	
	if (data)  // Safety
	{
		UIImage *img = [[UIImage alloc] initWithData:data];
		if (img)
		{
			// Pass the successful chart image back to the delegate
			[_delegate chartIsReady:[UIImage imageWithData:data] fromCache:NO];
			if (kHistoricalChartLogLevel > 1) DLog(@"Created a new image: %@", img);
			[img release];
			
			// Cache the chart image for later re-use (but only if we have a valid storage path)
			if (_tmpCachePath) 
			{
				NSString* filePath = [_tmpCachePath stringByAppendingFormat:@"%@.%@", key, kCacheFileExtension];
				
				[self serializeCacheWithImageData:data writeToPath:filePath];
			}
		}
		else 
		{
			if ([_delegate respondsToSelector:@selector(chartRetrievalFailed:)]) {
				[_delegate chartRetrievalFailed:@"Bad image data was returned from the chart API."];
				if (kHistoricalChartLogLevel) DLog(@"** Error: Bad image data was returned from the chart API");
			}
		}
	}
	else 
	{
		if ([_delegate respondsToSelector:@selector(chartRetrievalFailed:)]) {
			[_delegate chartRetrievalFailed:@"No data was returned from the chart API."];
			if (kHistoricalChartLogLevel) DLog(@"** Error: No data was returned from the chart API");
		}
	}
}

@end

