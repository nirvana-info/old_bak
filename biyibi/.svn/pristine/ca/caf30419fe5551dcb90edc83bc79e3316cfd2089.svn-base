//
//  DSMembers.h
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import <Foundation/Foundation.h>

@class ProductInfo;

@protocol DSProductDelegate <NSObject>

-(void)didSelectProduct: (ProductInfo *)product;

@end

@interface DSProduct : NSObject<UITableViewDataSource, UITableViewDelegate>{
    //PODetail *_poDetail;
    
    NSMutableArray *_lists;
    
}

@property (nonatomic, retain) NSMutableArray *lists;

@property (nonatomic, assign) NSObject<DSProductDelegate> *delegate;


@end


