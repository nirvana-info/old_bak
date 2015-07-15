//
//  FavMemberViewController.h
//  NiMobile
//
//  Created by nirvana on 5/15/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "BaseTabViewController.h"
#import "DSMembers.h"
#import "MemberDetailViewController.h"
#import <CoreLocation/CoreLocation.h>
#import "FavDataController.h"

@class DSMembers;

@interface FavMemberViewController : BaseTabViewController<DSMemberDelegate,FavDataControllerDelegate>{
    UITableView *_tableView;
    
    
    DSMembers *_dsMembers;
    
    MemberDetailViewController *_detailVC;
    FavDataController *_favDataController;
}

@property(nonatomic,retain) UIViewController * parentVC;

@end