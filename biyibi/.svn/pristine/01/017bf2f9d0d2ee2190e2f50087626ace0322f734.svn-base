//
//  BaseDataController.m
//  Zecco
//
//  Created by sirish.jetti on 9/21/10.
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import "BaseDataController.h"
#import "JSON.h"
#import "NiUrlRequest.h"
#import "SessionDataController.h"

#define kGoToZeccoButtonText	@"Go to zecco.com"
#define kCallZeccoButtonText	@"Call Zecco"
#define kQuitButtonText			@"Quit"
#define kUpdateButtonText		@"Update"

#define NONE_ALERT_STATUSCODE   -1



@implementation BaseDataController

- (id)init
{
	if (self = [super init])
	{
		_appDelegate = (AppDelegate *)[[UIApplication sharedApplication] delegate];
        _alertStatusCode = NONE_ALERT_STATUSCODE;
        
	}
	return self;
}

- (void)dealloc
{
	[[TrafficCop sharedInstance] removeCaller:self];
	[super dealloc];
}
-(NSString *)zeccoURLEncode:(NSString *)inputString
{
	return [[inputString stringByReplacingOccurrencesOfString:@"\""
												   withString:@"\\\""] urlEncode];
}

-(void)setAuthorizationCookieFromZeccoResponse:(NSDictionary *)respDict
{
    // clude: notice!!!, we need to take care of the Login api, coz this api will pass the data after this method processing. here we add a same login on the session domain.
    if (kIsEnableCookieAuthorization) {
        if([respDict objectForKey:@"user_info"] && [NSNull null] != [respDict objectForKey:@"user_info"])
        {
            if ([SessionDataController loggedIn]) {
                [[SessionDataController currentSession] setSharedUserCookie:[respDict objectForKey:@"user_info"]];
            }
        }
    }
}

- (NSString *)newReturnStringFromData:(NSData *)data
{
    NSString *returnString = [[NSString alloc] initWithData:data encoding:NSUTF8StringEncoding];
	
	if(nil == returnString)
	{
		returnString = [[NSString alloc] initWithData:data encoding:NSASCIIStringEncoding];
	}
    
    return returnString;
}

- (id)parsedStructureFromZeccoJsonData:(NSData *)data error:(NSError **)error excludeErrorList:(NSMutableSet *)excludeErrorList  isDisableAlert:(BOOL)isDisableAlert isDisableWarningAlert:(BOOL)isDisableWarningAlert
{
	if (nil == data)
	{
		if ([[TrafficCop sharedInstance] currentNetworkConnection] == NoInternet)
		{
			*error = [NSError errorWithDomain:kNetworkConnectionUnavailableErrorDomain code:999 userInfo:nil];
		}
		else
		{
			*error = [NSError errorWithDomain:kNoDataReturnedErrorDomain code:999 userInfo:nil];
		}
        
		return nil;
	}
	
	NSString *returnString = [self newReturnStringFromData:data];
    
	
    //	DLog(@"%@",returnString);
	
	if(nil == returnString)
	{
        *error = [NSError errorWithDomain:kZeccoEncodingErrorDomain code:0 userInfo:nil];
	}
	
	
	
	id parsedStructure = [returnString JSONValue];
	
    //	DLog(@"%@",parsedStructure);
	
	if(nil == parsedStructure)
	{
		*error = [NSError errorWithDomain:kZeccoParsingErrorDomain code:0 userInfo:nil];
	}
	
	[returnString release];
	
	if([parsedStructure isKindOfClass:[NSDictionary class]])
	{
        // set authorization cookie for later realtime quote feature
        [self setAuthorizationCookieFromZeccoResponse:parsedStructure];
        
        // pass the status code,check the error information
		NSArray *statusArray = [parsedStructure objectForKey:@"statuses"];
		//@TODO: Do we want to handle multiple status code returns?
		if([statusArray count] > 0)
		{
			NSDictionary *statusDict = [statusArray objectAtIndex:0];
			NSInteger statusCode = [[statusDict objectForKey:@"statusCd"] intValue];
			NSString *statusMessage = [statusDict objectForKey:@"msg"];
            MessageType statusMessageType = [[statusDict objectForKey:@"msgType"] intValue];
			
			if(0 != statusCode)
			{
				*error = [NSError errorWithDomain:kZeccoProcessingErrorDomain code:statusCode
                                         userInfo:[NSDictionary dictionaryWithObjectsAndKeys:
                                                   statusMessage,@"message",
                                                   [NSNumber numberWithInt:statusMessageType], @"messageType",
                                                   nil]];
                
                if (isDisableAlert) {
                    // do nothing
                }else if(isDisableWarningAlert && statusMessageType == MessageTypeWarning){
                    // do nothing
                }
                else if (nil != excludeErrorList && [excludeErrorList containsObject:[NSNumber numberWithInt:statusCode]])
                {
                    // do nothing
                }else
                {
                    if (_isAlertShow && _alertStatusCode == statusCode) {
                        // if alertbox with same status_code does exist, we do not need to show a duplicate one
                    }else{
                        _alertStatusCode = statusCode;
                        _isAlertShow = YES;
                        
                        UIAlertView *alertView = nil;
                        
                        switch (statusCode) {
                            case 101:
                            case 102:
                            case 108:
                            case 117:
                            case 118:
                            {
                                alertView = [[UIAlertView alloc] initWithTitle:kAlertTitleError message:statusMessage
                                                                      delegate:self
                                                             cancelButtonTitle:@"Close"
                                                             otherButtonTitles:/*kGoToZeccoButtonText,*/nil];
                                break;
                            }
                            case 103:
                            case 105:
                            case 114:
                            {
                                
                                if([[UIApplication sharedApplication] canOpenURL:[NSURL URLWithString:@"tel://"]])
                                {
                                    alertView = [[UIAlertView alloc] initWithTitle:kAlertTitleError message:statusMessage
                                                                          delegate:self
                                                                 cancelButtonTitle:@"Close"
                                                                 otherButtonTitles:kCallZeccoButtonText,nil];
                                }
                                else
                                {
                                    alertView = [[UIAlertView alloc] initWithTitle:kAlertTitleError message:statusMessage
                                                                          delegate:self
                                                                 cancelButtonTitle:@"Close"
                                                                 otherButtonTitles:nil];
                                }
                                
                                break;
                            }
                            case  110:
                            {
                                alertView = [[UIAlertView alloc] initWithTitle:kAlertTitleError message:statusMessage
                                                                      delegate:self
                                                             cancelButtonTitle:kQuitButtonText
                                                             otherButtonTitles:kUpdateButtonText,nil];
                                break;
                            }
                            default:
                            {
                                if (statusMessageType == MessageTypeWarning) {
                                    alertView = [[UIAlertView alloc] initWithTitle:kAlertTitleWarning message:statusMessage
                                                                          delegate:self
                                                                 cancelButtonTitle:@"OK"
                                                                 otherButtonTitles:nil];
                                }else{
                                    alertView = [[UIAlertView alloc] initWithTitle:kAlertTitleError message:statusMessage
                                                                          delegate:self
                                                                 cancelButtonTitle:@"Close"
                                                                 otherButtonTitles:nil];
                                }
                                
                                
                                break;
                            }
                        }
                        [alertView setTag:statusCode];
                        [alertView setDelegate:self];
                        [alertView show];
                        [alertView release];
                    }
                }
			}
		}
		
	}
    
    return parsedStructure;
}

- (id)parsedStructureFromZeccoJsonData:(NSData *)data error:(NSError **)error excludeErrorList:(NSMutableSet *)excludeErrorList  isDisableAlert:(BOOL)isDisableAlert{
    return [self parsedStructureFromZeccoJsonData:data error:error excludeErrorList:excludeErrorList isDisableAlert:isDisableAlert isDisableWarningAlert:NO];
}

- (id)parsedStructureFromZeccoJsonData:(NSData *)data error:(NSError **)error excludeErrorList:(NSMutableSet *)excludeErrorList{
    return [self parsedStructureFromZeccoJsonData:data error:error excludeErrorList:excludeErrorList isDisableAlert:NO];
}

- (id)parsedStructureFromZeccoJsonData:(NSData *)data error:(NSError **)error
{
	return [self parsedStructureFromZeccoJsonData:data error:error excludeErrorList:nil];
}

- (NSDictionary *)parsedDictionaryFromWSODJsonData:(NSData *)data error:(NSError **)error
{
	if (nil == data && [[TrafficCop sharedInstance] currentNetworkConnection] == NoInternet)
	{
		*error = [NSError errorWithDomain:kNetworkConnectionUnavailableErrorDomain code:999 userInfo:nil];
		return nil;
	}
	
    NSString *returnString = [self newReturnStringFromData:data];
	
	if(nil == returnString)
	{
        *error = [NSError errorWithDomain:kWsodEncodingErrorDomain code:0 userInfo:nil];
	}
	
	//@DeleteMe
	if([returnString hasPrefix:@"results"])
	{
		NSString *tempString = [returnString substringFromIndex:10];
		[returnString release];
		returnString = [tempString retain];
	}
	
	
	
	//@DeleteMe
	
	NSDictionary *parsedDict = [returnString JSONValue];
	
	if(nil == parsedDict)
	{
        *error = [NSError errorWithDomain:kWsodParsingErrorDomain code:0 userInfo:nil];
	}
	
	[returnString release];
    
    return parsedDict;
}
- (UIImage *)imageFromWSODData:(NSData *)data error:(NSError **)error
{
    UIImage *returnImage = [UIImage imageWithData:data];
    
    if(nil == returnImage)
    {
        *error = [NSError errorWithDomain:kWsodNilImageErrorDomain code:0 userInfo:nil];
    }
    
    return returnImage;
}
-(void)clearCache
{
}
#pragma mark UIAlertViewDelegate methods

- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex
{
    _alertStatusCode = NONE_ALERT_STATUSCODE;
    _isAlertShow = NO;
    
    [self OnClickAlertButtonOfDataController:buttonIndex withStatusCode:[alertView tag]];
    
	NSString *buttonText = [alertView buttonTitleAtIndex:buttonIndex];
	if([buttonText isEqualToString:kGoToZeccoButtonText])
	{
		[[UIApplication sharedApplication] openURL:[NSURL URLWithString:kZeccoHomepageUrl]];
	}
	else if([buttonText isEqualToString:kCallZeccoButtonText])
	{
		[[UIApplication sharedApplication] openURL:[NSURL URLWithString:@"tel://18777007862"]];
	}
	else if([buttonText isEqualToString:kQuitButtonText])
	{
		exit(0);
	}
	else if([buttonText isEqualToString:kUpdateButtonText])
	{
		
	}
}

-(void) OnClickAlertButtonOfDataController:(NSInteger)buttonIndex withStatusCode:(int)statusCode{
    
}

#pragma mark TrafficCopCaller methods

-(void)dataReturnedFromTrafficCop:(NSData *)data withKey:(NSString *)key response:(NSURLResponse *)response
{
	//this does nothing in the base implementation
}

-(void)performNiRequestwithGroup:(NSString *)group andMethod:(NSString *)method andArgs:(NSMutableDictionary *)args andKey:(NSString *)key
{
	[SessionDataController setLastActiveTimeToCurrentTime];
    
    // TODO combine group and method to url
    NSString *urlString = [NSString stringWithFormat:@"%@/%@/%@.api", kBaseURL, group, method];
	//NSString *urlString = [_appDelegate fullPathForAPIwithGroup:group andMethod:method];
	NSURL *url = [[NSURL alloc] initWithString:urlString] ;
    
    
	
	NiUrlRequest *request = [NiUrlRequest NiURLRequestWithURL:url
															 arguments:args];
	[[TrafficCop sharedInstance] performRequest:request withPriority:TrafficCopHighPriority
							 returnDataToObject:self withKey:key];
	[url release];
    
}

-(void)performRestRequestwithGroup:(NSString *)group andMethod:(NSString *)method andArgs:(NSMutableDictionary *)args andKey:(NSString *)key
{
	[SessionDataController setLastActiveTimeToCurrentTime];
    
    // TODO combine group and method to url
    NSString *urlString = [NSString stringWithFormat:@"%@/%@?", kBaseURL, method];
    
    // parse args dict to query string
    for (NSString *key in args.allKeys) {
        NSString *pStr = [NSString stringWithFormat:@"%@=%@", key, [args objectForKey:key]];
        
        urlString = [NSString stringWithFormat:@"%@&%@", urlString, pStr];
    }
	
	NSURL *url = [[NSURL alloc] initWithString:urlString] ;

	
	NiUrlRequest *request = [NiUrlRequest NiURLRequestWithURL:url];
	[[TrafficCop sharedInstance] performRequest:request withPriority:TrafficCopHighPriority
							 returnDataToObject:self withKey:key];
	[url release];
    
}

-(void)performRequestwithURLString:(NSString *)urlString andKey:(NSString *)key
{
	NSURL *url = [[NSURL alloc] initWithString:urlString];
    NiUrlRequest *request = [NiUrlRequest NiURLRequestWithURL:url];
	//NSMutableURLRequest *request = [[NSMutableURLRequest alloc] initWithURL:url];
	
	[[TrafficCop sharedInstance] performRequest:request withPriority:TrafficCopHighPriority
							 returnDataToObject:self withKey:key];
    
    [url release];
	//[request release];
	
}



@end
