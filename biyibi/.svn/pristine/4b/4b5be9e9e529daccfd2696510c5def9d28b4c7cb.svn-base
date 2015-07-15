//
//  AreaSetViewController.h
//  biyibi
//
//  Created by nirvana on 5/2/13.
//  Copyright (c) 2013 nirvana. All rights reserved.
//

#import "BaseViewController.h"
#import "SessionDataController.h"
#import "AuthSelectStateViewController.h"
#import "AuthDataController.h"

@interface AuthSelectMobile : BaseViewController<
SessionDataControllerDelegate,
AuthDataControllerDelegate,
UITextFieldDelegate,
UIAlertViewDelegate
> {
    UITextField *_txtUserName;
    UITextField *_txtPassword;
    NSMutableArray *_list;
    UITableView* _tableView;
    AuthDataController *_authDataController;

}

@property (strong, nonatomic) UIWindow *window;

@property(nonatomic,assign) NSMutableArray *list;

@end
