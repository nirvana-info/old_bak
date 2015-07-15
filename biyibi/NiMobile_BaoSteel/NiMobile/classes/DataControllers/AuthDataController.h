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

@protocol AuthDataControllerDelegate
@optional
-(void) regiesterSuccessful;
-(void) regiesterFailed:(NSError *)err;
-(void) setCitySuccessful;
-(void) followSuccessful;

@end

@interface AuthDataController : BaseDataController<AuthDataControllerDelegate>{
   NSObject<AuthDataControllerDelegate> *delegate;
}

@property(nonatomic,retain) NSObject<AuthDataControllerDelegate> *delegate;

-(NSArray *)getStateCityList;
- (void) registerUserName:(NSString *)mb withPassWord:(NSString *)pw;

-(void)setCity:(NSString *)city;
-(void)followStell:(NSMutableArray *)list;


@end
