//
//  MainSettingViewController.h
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "BaseTabViewController.h"

@interface MainSettingViewController : BaseTabViewController<UITableViewDataSource, UITableViewDelegate, UIAlertViewDelegate>{
    UITableView *_tableView;
}

@end
