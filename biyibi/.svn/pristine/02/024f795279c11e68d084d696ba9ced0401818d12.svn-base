//
//  BaseDataController.h
//  Zecco
//
//  Created by sirish.jetti on 9/21/10.
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "TrafficCop.h"

@class AppDelegate;

typedef enum {
	MessageTypeError    = 1,
	MessageTypeWarning	= 2
}MessageType;

#define kNetworkConnectionUnavailableErrorDomain	@"NETWORK_CONNECTION_UNAVAILABLE"
#define kNoDataReturnedErrorDomain					@"NO_DATA_RETURNED"
#define kZeccoEncodingErrorDomain					@"ZECCO_ENCODING_ERROR"
#define kZeccoParsingErrorDomain					@"ZECCO_PARSING_ERROR"
#define kZeccoProcessingErrorDomain					@"ZECCO_PROCESSING_ERROR"
#define kWsodEncodingErrorDomain					@"WSOD_ENCODING_ERROR"
#define kWsodParsingErrorDomain						@"WSOD_PARSING_ERROR"
#define kWsodNilImageErrorDomain					@"WSOD_NIL_IMAGE_ERROR"

@interface BaseDataController : NSObject <TrafficCopCaller, UIAlertViewDelegate> {
	AppDelegate *_appDelegate; //weak
    
    int _alertStatusCode;
    BOOL _isAlertShow;
}

/**
 * Parses the data returned in a response from Zecco's API into a stucture (array or dictionary)
 * and returns that structure. If an error is encountered, either in the
 * response from the server or while the data is being parsed, then an NSError
 * object is created and assigned to the error parameter.
 */
- (id)parsedStructureFromZeccoJsonData:(NSData *)data error:(NSError **)error;
- (id)parsedStructureFromZeccoJsonData:(NSData *)data error:(NSError **)error excludeErrorList:(NSMutableSet *)excludeErrorList;
- (id)parsedStructureFromZeccoJsonData:(NSData *)data error:(NSError **)error excludeErrorList:(NSMutableSet *)excludeErrorList isDisableAlert:(BOOL)isDisableAlert;
- (id)parsedStructureFromZeccoJsonData:(NSData *)data error:(NSError **)error excludeErrorList:(NSMutableSet *)excludeErrorList  isDisableAlert:(BOOL)isDisableAlert isDisableWarningAlert:(BOOL)isDisableWarningAlert;

/**
 * Parses the data returned in a response from WSOD's API into a dictionary
 * and returns that dictionary. If an error is encountered, either in the
 * response from the server or while the data is being parsed, then an NSError
 * object is created and assigned to the error parameter.
 */
- (NSDictionary *)parsedDictionaryFromWSODJsonData:(NSData *)data error:(NSError **)error;

/**
 * Parses the data returned in a response from WSOD's API into an image
 * and returns that image. If an error is encountered, either in the
 * response from the server or while the image is being created, then an NSError
 * object is created and assigned to the error parameter.
 */
//Implement this if the data controller is caching any data
-(void)clearCache;
-(NSString *)zeccoURLEncode:(NSString *)inputString;
- (UIImage *)imageFromWSODData:(NSData *)data error:(NSError **)error;

-(void)performNiRequestwithGroup:(NSString *)group andMethod:(NSString *)method andArgs:(NSMutableDictionary *)args andKey:(NSString *)key;
-(void)performRequestwithURLString:(NSString *)urlString andKey:(NSString *)key;
-(void)performRestRequestwithGroup:(NSString *)group andMethod:(NSString *)method andArgs:(NSMutableDictionary *)args andKey:(NSString *)key;
-(void) OnClickAlertButtonOfDataController:(NSInteger)buttonIndex withStatusCode:(int)statusCode;

@end