//
//  AuthDataController.m
//  NiMobile
//
//  Created by zhu clude on 5/5/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "SearchDataController.h"
#define     kSearchTags      @"search.searchTags"



@implementation SearchDataController
@synthesize delegate;



//Fetch my follow tags.
- (void) searchTags:(NSString *)name{
    NSMutableDictionary *args = [NSMutableDictionary dictionaryWithObjectsAndKeys:
                                 [self zeccoURLEncode:name], @"query",
                                 nil];
   [self performRestRequestwithGroup:@"" andMethod:@"search" andArgs:args andKey:kSearchTags];
}


-(void)dataReturnedFromTrafficCop:(NSData *)data withKey:(NSString *)key response:(NSURLResponse *)response
{
    	NSError *error = nil;
    	id parsedStructure;
    
    	parsedStructure = [self parsedDictionaryFromWSODJsonData:data error:&error];
    
//        if(error){
//            [delegate connectError:error];
//            return;
//        }
	
    
    if ([key hasPrefix:kSearchTags]){
        [delegate return_search_tags:parsedStructure];
        NSLog(@"search_tags successful:%@",parsedStructure);
    }
 
}

@end
