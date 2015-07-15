//
//  MemberInfo.h
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface MemberInfo : NSObject{
    NSString *_mname;
    int _gender;
    double _distance;
    NSString *_photoUrl;
    NSString *_comments;
    
    NSString *_company;
    NSString *_mobile;
    
    NSString *_province;
    NSString *_provinceCode;
    NSString *_city;
    NSString *_cityCode;
    
    NSArray *_categories;
}

@property(nonatomic, copy) NSString *mname;
@property(nonatomic, assign) int gender;
@property(nonatomic, assign) double distance;
@property(nonatomic, copy) NSString *photoUrl;
@property(nonatomic, copy) NSString *comments;
@property(nonatomic, copy) NSString *company;
@property(nonatomic, copy) NSString *mobile;
@property(nonatomic, copy) NSString *province;
@property(nonatomic, copy) NSString *proviceCode;
@property(nonatomic, copy) NSString *city;
@property(nonatomic, copy) NSString *cityCode;
@property(nonatomic, retain) NSArray *categories;

- (void)fillFromDictionary:(NSDictionary *)dict;

@end
