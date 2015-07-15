//
//  FavSteelViewController.h
//  NiMobile
//
//  Created by nirvana on 5/15/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "BaseTabViewController.h"
#import "SearchDetailViewController.h"
#import "FavDataController.h"


@interface FavSteelViewController : BaseTabViewController<FavDataControllerDelegate>{
    NSMutableArray *_catLists;
    NSMutableArray *_lists;
    
    
    SearchDetailViewController *_vcSearch;
    
    FavDataController *_favDataController;
    NSString *_username;
   
}

@property(nonatomic, assign) UIViewController *parentVC;

@end