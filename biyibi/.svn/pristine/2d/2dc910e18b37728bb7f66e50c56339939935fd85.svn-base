//
//  AuthDataController.m
//  NiMobile
//
//  Created by zhu clude on 5/5/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "FavDataController.h"
#define     kGetAuthUser      @"fav.kGetAuthUser"
#define     kFollowTags       @"fav.kFollowTags"
#define     kFollowUsers       @"fav.kFollowUsers"
#define     kFollowStores       @"fav.kFollowStores"
#define     follow_tags_start      @"0"
#define     follow_tags_end        @"20"




@implementation FavDataController
@synthesize delegate;


-(void)getAuthUser{
       [self performRestRequestwithGroup:@"" andMethod:@"get_auth_user" andArgs:nil andKey:kGetAuthUser];
}

//Fetch my follow tags.
- (void) getMyFollowTags:(NSString *)username{
    NSMutableDictionary *args = [NSMutableDictionary dictionaryWithObjectsAndKeys:
                                 [self zeccoURLEncode:username], @"username",
                                 [self zeccoURLEncode:follow_tags_start], @"start",
                                 [self zeccoURLEncode:follow_tags_end], @"count",
                                 nil];
   [self performRestRequestwithGroup:@"" andMethod:@"my_follow_tags" andArgs:args andKey:kFollowTags];
}


//Fetch my follow users.
- (void) getMyFollowUsers:(NSString *)username{
    NSMutableDictionary *args = [NSMutableDictionary dictionaryWithObjectsAndKeys:
                                 [self zeccoURLEncode:username], @"username",
                                 [self zeccoURLEncode:follow_tags_start], @"start",
                                 [self zeccoURLEncode:follow_tags_end], @"count",
                                 nil];
    [self performRestRequestwithGroup:@"" andMethod:@"my_follow_users" andArgs:args andKey:kFollowUsers];
}

//Fetch my follow stores.
- (void) getMyFollowStores:(NSString *)username{
    NSMutableDictionary *args = [NSMutableDictionary dictionaryWithObjectsAndKeys:
                                 [self zeccoURLEncode:username], @"username",
                                 [self zeccoURLEncode:follow_tags_start], @"start",
                                 [self zeccoURLEncode:follow_tags_end], @"count",
                                 nil];
    [self performRestRequestwithGroup:@"" andMethod:@"my_follow_stores" andArgs:args andKey:kFollowStores];
}



-(void)dataReturnedFromTrafficCop:(NSData *)data withKey:(NSString *)key response:(NSURLResponse *)response
{
    	NSError *error = nil;
    	id parsedStructure;
    
    	parsedStructure = [self parsedDictionaryFromWSODJsonData:data error:&error];
    
        if(error){
            [delegate connectError:error];
            return;
        }
	
        if ([key hasPrefix:kGetAuthUser]){
            [delegate getUserInfo:parsedStructure];
             NSLog(@"USER INFO value:%@",parsedStructure);
        }

    
    if ([key hasPrefix:kFollowTags]){
        [delegate return_follow_tags:parsedStructure];
        NSLog(@"get_follow_tags:%@",parsedStructure);
    }
    
    if ([key hasPrefix:kFollowUsers]){
        [delegate return_follow_users:parsedStructure];
        NSLog(@"get_follow_users:%@",parsedStructure);
    }
    
    if ([key hasPrefix:kFollowStores]){
        [delegate return_follow_stores:parsedStructure];
        NSLog(@"get_follow_stores:%@",parsedStructure);
    }
    
//
//    if ([key hasPrefix:kFollowSteel]) {
//        [delegate followSuccessful];
//        NSLog(@"Follow successful");
//    }

}

@end
