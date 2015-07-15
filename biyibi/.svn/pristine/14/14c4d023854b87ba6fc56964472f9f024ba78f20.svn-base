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

@protocol SearchDataControllerDelegate
@optional
-(void) connectError:(NSError *)err;
-(void)return_search_tags:(NSDictionary *)obj;
@end

@interface SearchDataController : BaseDataController<SearchDataControllerDelegate>{
   NSObject<SearchDataControllerDelegate> *delegate;
}

@property(nonatomic,retain) NSObject<SearchDataControllerDelegate> *delegate;

- (void) searchTags:(NSString *)tagname;

@end
