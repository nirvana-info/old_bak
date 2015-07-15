//
//  AreaSetViewController.h
//  biyibi
//
//  Created by nirvana on 5/2/13.
//  Copyright (c) 2013 nirvana. All rights reserved.
//

#import "BaseViewController.h"
#import "SessionDataController.h"
#import "SteelTypeCell.h"
#import "Steels.h"
#import "AuthDataController.h"

@interface SteelTypeController : BaseViewController <
UITableViewDataSource,
UITableViewDelegate,
UIApplicationDelegate,
UITabBarControllerDelegate,
SteelTypeCellDelegate,
AuthDataControllerDelegate
>{
    NSMutableArray *_list;
    UITableView* _tableView;
    UIBarButtonItem *batchPassBtn;
    
    NSMutableArray *_checkList;
    AuthDataController *_authDataController;

}

@property (strong, nonatomic) UIWindow *window;

@property (strong, nonatomic) UITabBarController *tabBarController;

@property(nonatomic,assign) NSMutableArray *list;
@property(nonatomic,assign) NSMutableArray *checkList;

@end
