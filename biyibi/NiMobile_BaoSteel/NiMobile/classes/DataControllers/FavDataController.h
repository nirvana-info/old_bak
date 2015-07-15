//
//  AuthDataController.h
//  NiMobile
//
//  Created by zhu clude on 5/5/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "BaseDataController.h"
#import "NiConstants.h"
#import "Steels.h"

@protocol FavDataControllerDelegate
@optional
-(void) getUserInfo:(NSDictionary *)obj;
-(void) connectError:(NSError *)err;
-(void)return_follow_tags:(NSDictionary *)obj;
-(void)return_follow_users:(NSDictionary *)obj;
-(void)return_follow_stores:(NSDictionary *)obj;
@end

@interface FavDataController : BaseDataController<FavDataControllerDelegate>{
   NSObject<FavDataControllerDelegate> *delegate;
}

@property(nonatomic,retain) NSObject<FavDataControllerDelegate> *delegate;

- (void) getMyFollowTags:(NSString *)username;
- (void) getMyFollowUsers:(NSString *)username;
- (void) getMyFollowStores:(NSString *)username;
-(void)getAuthUser;



@end
