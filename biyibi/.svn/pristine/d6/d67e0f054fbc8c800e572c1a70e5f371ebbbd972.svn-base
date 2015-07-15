///	
/// @file		WSODHistoricalChartDataController.h
/// 
///	Copyright 2010 Wall Street On Demand. All rights reserved.
///	


/// 
/// @mainpage	WSOD Historical Chart API
/// @version	dev
/// 
/// Provides encapsulated modeling of the parameters for an historical chart, along with translation 
/// of that model into ChartServer- and DrawingServer-friendly API requests. Implement the delegate 
/// method to receive callbacks when chart requests succeed or fail.
/// 
/// The server-side chart API renders one of a defined list of marker types for a given timeframe 
/// (in days), plus an optional comparison symbol, upper-indicator overlay, and lower-indicator 
/// second chart--only one of each at a time. Each includes properties for label strings for use in 
/// the chart key. See the convenience methods below for adding (replacing) and removing these 
/// elements.
/// 
/// Notes:
/// * You must set the symbol, at a minimum. Everything else is optional. The timeframe defaults to 
///   three months of daily data, and the chart type defaults to 'mountain'. 
/// * You must call [refreshChartUsingCache:] to kick off an initial or refresh request.
/// * You are responsible for the element parameters matching the chart server's capabilities, their 
///   having valid values, and for passing them in as a dictionary. 
/// * Retrieved chart images are cached on disk for the duration of the session. If a chart is 
///   requested using [refreshChartUsingCache:YES] and a chart image matching all the same settings 
///   has already been retrieved, that image will be returned immediately. Pass in NO to bypass the 
///   cache and force a request from the server API.
/// * If there is a lower-indicator chart, its height is set to 15% of the total height. 
/// * To re-use this model with a different chart API, you could subclass it and override the private 
///   [chartAPIRequestString] method.
/// 
/// @TODO: 
///		- Add better support for entering parameters,
///		- Cache additional information associated with the chart such as parameter arguments.
///		- Overhaul this class to allow for multiple comparisons, overlays, and indicators.


#import <Foundation/Foundation.h>
#import "TrafficCop.h"

#pragma mark -
@protocol WSODHistoricalChartDataControllerDelegate

/// Provides a hook for API script path for chart image requests.
- (NSString *)chartAPIURL;

/// Provides a hook for outside dimensions for the chart.
- (CGSize)chartSize;

/// Provides a hook for (corrected) device screen scaleFactor.
- (CGFloat)screenScaleFactor;

/// Provides an autoreleased UIImage when the chart image is succesfully retrieved from the API.
- (void)chartIsReady:(UIImage *)chartImage fromCache:(BOOL)imageWasCached;

@optional  // (but highly recommended)

//Provides a hook for the preferred input symbolset
- (NSString *)symbolset;

/// Provides an error describing any failures encountered in chart specification or retrieval.
- (void)chartRetrievalFailed:(NSString *)message;

@end

#pragma mark -
#pragma mark Definitions

#define kHistoricalChartLogLevel		0  // (0 = off, 1 = minimal, 2 = verbose)

/// Chart marker styles.
typedef enum {
	HistoricalChartTypeNone,		// For error cases
	HistoricalChartTypeMountain,	// Mountain (fill)
	HistoricalChartTypeLine,		// Line
	HistoricalChartTypeOHLC,		// OHLC
	HistoricalChartTypeCandle		// Candlesticks
} HistoricalChartType;

/// Chart overlay types.
typedef enum {
	HistoricalChartOverlayTypeNone,
	HistoricalChartOverlayTypeBollinger,	// Bollinger Bands
	HistoricalChartOverlayTypeEMA,			// Exponential Moving Average
	HistoricalChartOverlayTypeSMA,			// Simple Moving Average
	HistoricalChartOverlayTypeWMA,			// Weighted Moving Average
	HistoricalChartOverlayTypeTSF			// Time Series Forecast
} HistoricalChartOverlayType;

/// Chart Indicator types.
typedef enum 
{
	HistoricalChartIndicatorTypeNone,
	HistoricalChartIndicatorTypeVolume,				// Volume
	HistoricalChartIndicatorTypeMACD,				// Moving Average Convergence/Divergence
	HistoricalChartIndicatorTypePROC,				// Price Rate of Change
	HistoricalChartIndicatorTypeVROC,				// Volume Rate of Change
	HistoricalChartIndicatorTypeRollingEPS,			// Rolling Earnings per Share
	HistoricalChartIndicatorTypeRSI,				// Relative Strength Index
	HistoricalChartIndicatorTypeDMI,				// Directional Movement Index
	HistoricalChartIndicatorTypePERatio,			// Price-to-Earnings Ratio
	HistoricalChartIndicatorTypeChaikinsVolatility, // Chaikins Volatility 
	HistoricalChartIndicatorTypeStochasticsFast,	// Fast Stochastics
	HistoricalChartIndicatorTypeStochasticsSlow,	// Slow Stochastics
	HistoricalChartIndicatorTypeVolumePlus			// VolumePlus
} HistoricalChartIndicatorType;

// Element types relate to overlay and indicator elements and can be used to request colors 
// and (soon) parameter arguments for those elements.
typedef enum
{
	HistoricalChartElementTypeBollinger = 0,
	HistoricalChartElementTypeBollingerSma,
	HistoricalChartElementTypeEma,
	HistoricalChartElementTypeSma,
	HistoricalChartElementTypeWma,
	HistoricalChartElementTypeTsf,
	HistoricalChartElementTypeVolume,
	HistoricalChartElementTypeMacd,
	HistoricalChartElementTypeMacdEma,
	HistoricalChartElementTypeMacdDivergence,
	HistoricalChartElementTypeProc,
	HistoricalChartElementTypeVroc,
	HistoricalChartElementTypeRollingEps,
	HistoricalChartElementTypeRsi,
	HistoricalChartElementTypeDmi,
	HistoricalChartElementTypeDmiPositive,
	HistoricalChartElementTypeDmiNegative,
	HistoricalChartElementTypePeRatio,
	HistoricalChartElementTypeChaikinsVolatility,
	HistoricalChartElementTypeStochasticsFast,
	HistoricalChartElementTypeStochasticsFastPercentK,
	HistoricalChartElementTypeStochasticsFastPercentD,
	HistoricalChartElementTypeStochasticsSlow,
	HistoricalChartElementTypeStochasticsSlowPercentK,
	HistoricalChartElementTypeStochasticsSlowPercentD,
	HistoricalChartElementTypeVolumePlus
} HistoricalChartElementType;

// Parameter types relate to parameters for overlays and indicators, and can be used to request specific
// arguments for those elements.
//typedef enum
//{
//	HistoricalChartParameterTypePeriod,
//	HistoricalChartParameterTypeStdDev,
//	HistoricalChartParameterTypeFast,
//	HistoricalChartParameterTypeSlow,
//	HistoricalChartParameterTypeSmoothing,
//	HistoricalChartParameterTypeType,
//	HistoricalChartParameterTypeShowExtraordinaryItems,
//	HistoricalChartParameterTypeEmaPeriod,
//	HistoricalChartParameterTypeDifferencePeriod,
//	HistoricalChartParameterTypeKPeriod,
//	HistoricalChartParameterTypeDPeriod
//} HistoricalChartParameterType;

#pragma mark -

/// Provides encapsulated modeling of the parameters for an historical chart.
/// 
@interface WSODHistoricalChartDataController : NSObject 
<TrafficCopCaller>
{
	NSObject<WSODHistoricalChartDataControllerDelegate> *_delegate; //weak
	HistoricalChartType _chartType;
	NSString *_symbol;
	NSString *_companyName;  // For key
	NSString *_issueType;
	NSInteger _numberOfDays;
	BOOL _realTimeData;
	
	NSString *_comparisonSymbol;  // WSODIssue
	NSString *_comparisonLabel;  // For key
	
	HistoricalChartOverlayType _overlayType;
	NSString *_overlayLabel;  // For key
	NSDictionary *_overlayParams;  // Parameters
	
	HistoricalChartIndicatorType _indicatorType;
	NSString *_indicatorLabel;  // For key
	NSDictionary *_indicatorParams;  // Parameters
	
	NSString *_tmpCachePath;  // Path to temporary (intra-session) cached chart images
	
	NSMutableDictionary*	_colorDictionary;	// Colors used by the current chart.
	UIColor*				_defaultColor;		// Color used whenever a value from _colorDictionary is NSNull.
}

// Public properties
@property (assign) NSObject<WSODHistoricalChartDataControllerDelegate> *delegate;
@property (assign) HistoricalChartType chartType;
@property (nonatomic, retain) NSString *symbol;
@property (nonatomic, retain) NSString *companyName;
@property (nonatomic, retain) NSString *issueType;
@property (assign) NSInteger numberOfDays;
@property (assign) BOOL realTimeData;
@property (nonatomic, readonly) NSDictionary* colorDictionary;
@property (nonatomic, retain) UIColor* defaultColor;

// Properties intended for internal use. 
@property (nonatomic, retain) NSString *comparisonSymbol;
@property (nonatomic, retain) NSString *comparisonLabel;
@property (assign) HistoricalChartOverlayType overlayType;
@property (nonatomic, retain) NSString *overlayLabel;
@property (nonatomic, retain) NSDictionary *overlayParams;
@property (assign) HistoricalChartIndicatorType indicatorType;
@property (nonatomic, retain) NSString *indicatorLabel;
@property (nonatomic, retain) NSDictionary *indicatorParams;
@property (nonatomic, retain) NSString *tmpCachePath;

// Public methods
- (void)setComparisonSymbol:(NSString *)symbol label:(NSString *)label;
- (void)removeComparison;

- (void)setOverlay:(HistoricalChartOverlayType)type label:(NSString *)label params:(NSDictionary *)params;
- (void)removeOverlay;

- (void)setIndicator:(HistoricalChartIndicatorType)type label:(NSString *)label params:(NSDictionary *)params;
- (void)removeIndicator;

- (void)refreshChartUsingCache:(BOOL)useCache;
- (NSString *)dataIntervalLabel;  // String describing the current interval (for use in key, etc.)

/*--------------------------------------------------------------------------------------* 
 -comparisonColorDictionary
	Returns an NSDictionary consisting of all UIColor objects that are associated with 
	the chart's comparison curve(s).
 *--------------------------------------------------------------------------------------*/
- (NSDictionary*) comparisonColorDictionary;

/*--------------------------------------------------------------------------------------* 
 -overlayColorDictionary
	Returns an NSDictionary consisting of all UIColor objects that are associated with 
	the chart's overlay curve(s).
 *--------------------------------------------------------------------------------------*/
- (NSDictionary*) overlayColorDictionary;

/*--------------------------------------------------------------------------------------* 
 -indicatorColorDictionary
	Returns an NSDictionary consisting of all UIColor objects that are associated with 
	the chart's indicator curve(s).
 *--------------------------------------------------------------------------------------*/
- (NSDictionary*) indicatorColorDictionary;

/*--------------------------------------------------------------------------------------* 
 -colorForElement:
	Returns either the UIColor associated with the specified elementType, or the default
	color if no color is found.
	*Note* 
		This method should not be used to determine whether a color exists because nil
		is never returned -- use -colorExistsForElement:.
 *--------------------------------------------------------------------------------------*/
- (UIColor*) colorForElement:(HistoricalChartElementType)elementType;

/*--------------------------------------------------------------------------------------* 
 -colorForComparisonSymbol:
	The UIColor associated with the specified comparisonSymbol, or the default color if 
	no color is found.
	*Note* 
		This method should not be used to determine whether a color exists because nil
		is never returned -- use -colorExistsForComparisonSymbol:.
 *--------------------------------------------------------------------------------------*/
- (UIColor*) colorForComparisonSymbol:(NSString*)comparisonSymbol;

/*--------------------------------------------------------------------------------------* 
 -colorExistsForElement:
	Returns TRUE if a valid color is associated with the specified elementType.
 *--------------------------------------------------------------------------------------*/
- (BOOL) colorExistsForElement:(HistoricalChartElementType)elementType;

/*--------------------------------------------------------------------------------------* 
 -colorExistsForComparisonSymbol:
	Returns TRUE if a valid color is associated with the specified comparisonSymbol.
 *--------------------------------------------------------------------------------------*/
- (BOOL) colorExistsForComparisonSymbol:(NSString*)comparisonSymbol;

///*--------------------------------------------------------------------------------------* 
// -argumentForParameter:ofElement:
//	Returns the argument that is associated with the specified parameterType and 
//	elementType.
// *--------------------------------------------------------------------------------------*/
//- (NSString*) argumentForParameter:(HistoricalChartParameterType)parameterType 
//						 ofElement:(HistoricalChartElementType)elementType;

@end
