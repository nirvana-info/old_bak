//
//  MainNearByViewController.h
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "BaseTabViewController.h"
#import "DSMembers.h"
#import "MemberDetailViewController.h"
#import <CoreLocation/CoreLocation.h>

@class DSMembers;


typedef enum
{
	ListTypeMember = 0,
	ListTypeCompany = 1
    
} MemberListType;


@interface MainNearByViewController : BaseTabViewController<DSMemberDelegate,CLLocationManagerDelegate>{
    UITableView *_tableView;
    
    
    DSMembers *_dsMembers;
    
    MemberDetailViewController *_detailVC;
    
    MemberListType _mType; // 0 member, 1 company
    
    CLLocationManager *_locationManager;
    BOOL _isGettingLocation;
}

@end
