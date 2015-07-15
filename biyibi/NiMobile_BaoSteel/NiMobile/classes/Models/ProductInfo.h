//
//  MemberInfo.h
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface ProductInfo : NSObject{
    NSString *_photoUrl;
    NSString *_name;
    NSString *_weight;
    double _price;
    NSString *_qualityInfo;
    NSString *_service;
    NSString *_code;
    NSString *_origin;
    NSString *_place;
    NSString *_size;
    NSString *_sizeInfo;
    NSString *_comments;
    int _stock;
    NSString *_company;

}

@property(nonatomic, retain) NSString *photoUrl;
@property(nonatomic, retain) NSString *name;
@property(nonatomic, retain) NSString *weight;
@property(nonatomic, assign) double price;
@property(nonatomic, retain) NSString *qualityInfo;
@property(nonatomic, retain) NSString *service;
@property(nonatomic, retain) NSString *code;
@property(nonatomic, retain) NSString *origin;
@property(nonatomic, retain) NSString *place;
@property(nonatomic, retain) NSString *size;
@property(nonatomic, retain) NSString *sizeInfo;
@property(nonatomic, retain) NSString *comments;
@property(nonatomic, assign) int stock;
@property(nonatomic, retain) NSString *company;


- (void)fillFromDictionary:(NSDictionary *)dict;

@end
