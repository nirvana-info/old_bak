//
//  MainSearchViewController.h
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "BaseTabViewController.h"
#import "SearchDetailViewController.h"

@interface MainSearchViewController : BaseTabViewController<
UITextFieldDelegate,
UITableViewDelegate,
UITableViewDataSource>{
    
    UITextField *_searchField;
    UIActivityIndicatorView *_activityIndicator;
    
    NSString* _menuType;
    NSMutableArray* MenuItemList;
    
    UIScrollView* _mainPanel;
    NSString *_searchString;
    SearchDetailViewController *_searchDetailVC;
}

@property (nonatomic, retain) NSString* menuType;
@property(nonatomic,assign) UITextField *searchField;
@property(nonatomic,assign) NSString *searchString;

- (void) setupMenuItems;
- (void) renderItem:(NSInteger) index
          withTitle:(NSString*) name
         andImgName:(NSString*) imgName
          withevent:(SEL) event;


@end
