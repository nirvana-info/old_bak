//
//  MemberDetailViewController.h
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "BaseTabViewController.h"
#import "DSProduct.h"
#import "DetailInfoViewController.h"
#import "SearchDataController.h"

@class DSProduct;

@interface SearchDetailViewController : BaseViewController<DSProductDelegate,UITextFieldDelegate,SearchDataControllerDelegate>{
    UIImageView *_imgPhoto;
    UILabel *_lblName;
    UILabel *_lblCompany;
    UILabel *_lblCategories;
    NSString *_keyword;
    //UIScrollView* _mainPanel;
    
    UITableView *_tableView;
    DSProduct *_product;
    
    UITextField *_searchField;
    UIActivityIndicatorView *_activityIndicator;
    
    DetailInfoViewController *_detailInfoVC;
    
    SearchDataController *_searchDataController;

}

@property (nonatomic, retain) DSProduct *product;
@property (nonatomic, assign) NSString * keyword;
-(void) setKeyword:(NSString *) keyword;

@end
