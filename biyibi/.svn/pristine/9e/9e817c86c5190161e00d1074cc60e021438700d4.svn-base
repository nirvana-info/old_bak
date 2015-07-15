//
//  AuthDataController.m
//  NiMobile
//
//  Created by zhu clude on 5/5/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "AuthDataController.h"

#define kRegisterMobile       @"register.RegisterMobile"
#define kRegisterProvince     @"register.Province"
#define kRegisterCity         @"register.City"
#define kFollowSteel         @"register.follow"


@implementation AuthDataController
@synthesize delegate;

-(NSArray *)getStateCityList{
    NSArray *provinces = [[NSArray alloc] initWithContentsOfFile:[[NSBundle mainBundle] pathForResource:@"city.plist" ofType:nil]];
    return [provinces autorelease];
}


- (void) registerUserName:(NSString *)mb withPassWord:(NSString *)pw{
    if([[mb stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceCharacterSet]] length] == 0)
	{
		NSMutableDictionary *errorDetail = [NSMutableDictionary dictionary];
		[errorDetail setValue:@"Please enter your username." forKey:@"message"];
		NSError *error = [NSError errorWithDomain:@"LocalFailure" code:100 userInfo:errorDetail];
		[delegate regiesterFailed:error];

		return;
	}
	
	if([[pw stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceCharacterSet]] length] == 0)
	{
		NSMutableDictionary *errorDetail = [NSMutableDictionary dictionary];
		[errorDetail setValue:@"Please enter your password." forKey:@"message"];
		NSError *error = [NSError errorWithDomain:@"LocalFailure" code:100 userInfo:errorDetail];
		[delegate regiesterFailed:error];

		return;
	}
	
	
	NSMutableDictionary *args = [NSMutableDictionary dictionaryWithObjectsAndKeys:
								 [self zeccoURLEncode:mb], @"cell",
								 [self zeccoURLEncode:pw], @"password",
								 //[NSNumber numberWithInt:(rememberMe ? 1 : 0)], @"remMe",
								 nil];
	[self performRestRequestwithGroup:@"" andMethod:@"register" andArgs:args andKey:kRegisterMobile];

}

-(void)setCity:(NSString *)city{
    if (city != nil) {
        NSMutableDictionary *args = [NSMutableDictionary dictionaryWithObjectsAndKeys:
                                     [self zeccoURLEncode:city], @"location",
                                     nil];
        [self performRestRequestwithGroup:@"" andMethod:@"set_profile" andArgs:args andKey:kRegisterCity];
    }
}

-(void)followStell:(NSMutableArray *)list{
    if (list.count >0) {
        for (int i=0; i< list.count;i++ ) {
            NSMutableDictionary *args = [NSMutableDictionary dictionaryWithObjectsAndKeys:
                                         [self zeccoURLEncode:[list objectAtIndex:i]], @"object_id",
                                         nil];
            [self performRestRequestwithGroup:@"" andMethod:@"toggle_follow" andArgs:args andKey:kFollowSteel];
        }
        
    }

}

-(void)dataReturnedFromTrafficCop:(NSData *)data withKey:(NSString *)key response:(NSURLResponse *)response
{
    	NSError *error = nil;
    	id parsedStructure;
    
    	parsedStructure = [self parsedDictionaryFromWSODJsonData:data error:&error];
    
        if(error){
            [delegate regiesterFailed:error];
            return;
        }
	
        if ([key hasPrefix:kRegisterMobile]){
            [delegate regiesterSuccessful];
             NSLog(@"response value:%@",parsedStructure);
        }
    
    
    if ([key hasPrefix:kRegisterCity]){
        [delegate setCitySuccessful];
        NSLog(@"Register city value successful");
    }
    
    if ([key hasPrefix:kFollowSteel]) {
        [delegate followSuccessful];
        NSLog(@"Follow successful");
    }
    
    //        else if ([key hasPrefix:kExpirationDatesForStrikePrefix])
    //		{
    //			NSString *symbol = [key substringFromIndex:	[kExpirationDatesForStrikePrefix length]];
    //			if ([delegate respondsToSelector:@selector(expirationDatesRetrievalFailedForSymbol:)])
    //			{
    //				[delegate expirationDatesRetrievalFailedForSymbol:symbol];
    //			}
    //		}
    //		return;
    //	}
    //
    //
    //	if ([key hasPrefix:kOptionChainPrefix])
    //	{
    //        //		NSArray *keyParts = [key componentsSeparatedByString:@"."];
    //
    //		//NSString *symbolAndDate = [key substringFromIndex:	[kOptionChainPrefix length]];
    //		//NSUInteger endLocation = [symbolAndDate rangeOfString:@"." options:NSBackwardsSearch].location;
    //		//NSString *symbol = [symbolAndDate substringToIndex:endLocation];
    //		//NSInteger expDate = [[symbolAndDate substringFromIndex:endLocation+1] intValue];
    //        NSString *symbolAndDateAndRoot = [key substringFromIndex:	[kOptionChainPrefix length]];
    //        NSArray *keyArr = [symbolAndDateAndRoot componentsSeparatedByString:@"_"];
    //        NSString *symbol = [keyArr objectAtIndex:0];
    //        NSInteger expDate = [[keyArr objectAtIndex:1] intValue] ;
    //        NSString *root = [keyArr objectAtIndex:2];
    //
    //		NSDictionary *optionsDict = [[parsedStructure objectForKey:@"results"] objectForKey:@"options"];
    //
    //		[s_optionChains fillFromDictionary:optionsDict
    //                                 forSymbol:symbol
    //                         andExpirationDate:expDate
    //                                andExpRoot:root];
    //		[delegate optionsDataAvailableForSymbol:symbol];
    //
    //	}
    //	else if ([key hasPrefix:kExpirationDatesPrefix])
    //	{
    //		NSString *symbol = [key substringFromIndex:	[kExpirationDatesPrefix length]];
    //		[s_expirationDates fillFromDictionary:[[parsedStructure objectForKey:@"results"] objectForKey:@"options"] forSymbol:symbol];
    //		[delegate expirationDatesAvailableForSymbol:symbol];
    //	}else if ([key hasPrefix:kExpirationDatesForStrikePrefix])
    //	{
    //		NSString *symbol = [key substringFromIndex:	[kExpirationDatesForStrikePrefix length]];
    //		[s_expDateAndStrikes fillFromDictionary:[parsedStructure objectForKey:@"results"] forSymbol:symbol];
    //        [self getStrikePricesForExceptions:[s_expDateAndStrikes getDatesForSymbol:symbol] andSymbol:symbol];
    //	}else if ([key hasPrefix:kStrikePricesPrefix])
    //	{
    //		NSString *symbol = [key substringFromIndex:	[kStrikePricesPrefix length]];
    //		[s_expDateAndStrikes fillStrikesFromDictionary:[parsedStructure objectForKey:@"results"] forSymbol:symbol];
    //        [delegate expirationDatesAvailableForSymbol:symbol];
    //	}

}

@end
