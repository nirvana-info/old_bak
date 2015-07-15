//
//  ShakeWaitingViewController.h
//  NiMobile
//
//  Created by zhu clude on 5/3/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "BaseViewController.h"
#import "ShakeResultsViewController.h"
#import <CoreLocation/CoreLocation.h>

@interface ShakeWaitingViewController : BaseViewController<CLLocationManagerDelegate>{
    UIActivityIndicatorView *_activityIndicator;
    UILabel *_lblIndicatorMsg;
    
    ShakeResultsViewController *_vcSearchResults;
    
    CLLocationManager *_locationManager;
    BOOL _isGettingLocation;
    
}

@property (nonatomic, retain) NSMutableArray *cats;

@property (nonatomic, retain) CLLocation *bestLocation;
@property (nonatomic, retain) NSString *locationStr;

@end
