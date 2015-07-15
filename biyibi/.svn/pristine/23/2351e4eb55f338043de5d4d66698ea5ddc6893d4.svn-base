//
//  DSMembers.h
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "FavDataController.h"

@class MemberInfo;

@protocol DSMemberDelegate <NSObject>

-(void)didSelectMember: (MemberInfo *)member;

@end

@interface DSMembers : NSObject<UITableViewDataSource, UITableViewDelegate,FavDataControllerDelegate>{
    //PODetail *_poDetail;
    
    NSMutableArray *_lists;
    FavDataController *_favDataController;
    
}

@property (nonatomic, retain) NSMutableArray *lists;

@property (nonatomic, assign) NSObject<DSMemberDelegate> *delegate;


@end


