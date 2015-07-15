//
//  ShakeWaitingViewController.m
//  NiMobile
//
//  Created by zhu clude on 5/3/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "ShakeWaitingViewController.h"


@interface ShakeWaitingViewController ()
-(void)showShakeWaiting:(BOOL)isShow;
@end

@implementation ShakeWaitingViewController

@synthesize
cats,
bestLocation,
locationStr;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"摇一摇";
		self.navigationItem.title = @"摇一摇";
    }
    return self;
}

// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView
{
	[super loadView];
    
    UIImageView *imgShaker = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"icon_y01.png"]];
    [imgShaker setFrame:CGRectMake(90, 80, 140, 173)];
    [self.view addSubview:imgShaker];
    [imgShaker release];
    
    // Initialization code.
    _activityIndicator = [[UIActivityIndicatorView alloc] initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleGray];
    _activityIndicator.frame = CGRectMake(55, 274, 12, 12);
    [self.view addSubview: _activityIndicator];
    
    _lblIndicatorMsg = [[UILabel alloc] initWithFrame:CGRectMake(75, 260, 210, 40)];
    [_lblIndicatorMsg setBackgroundColor:[UIColor clearColor]];
    _lblIndicatorMsg.text = @"正在搜索这段时间摇晃手机的人";
    [_lblIndicatorMsg setLineBreakMode:NSLineBreakByCharWrapping];
    //[_lblIndicatorMsg setNumberOfLines:2];
    _lblIndicatorMsg.font = [UIFont systemFontOfSize:14];
    
    [self.view addSubview:_lblIndicatorMsg];
    
    [self showShakeWaiting:NO];
	
    //    button.hidden = self.isBMMF;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

-(void)showShakeWaiting:(BOOL)isShow{
    if (isShow) {
        [_activityIndicator startAnimating];
        [_lblIndicatorMsg setHidden:NO];
    }else{
        [_activityIndicator stopAnimating];
        [_lblIndicatorMsg setHidden:YES];
    }
}

-(void)gotoResultsPage{
    if(_vcSearchResults == nil){
        _vcSearchResults =[[ShakeResultsViewController alloc] init];
    }
    
    [self.navigationController pushViewController:_vcSearchResults animated:YES];
    
    [self showShakeWaiting:NO];
}

#pragma shake action
-(BOOL)doSupportShakeActon{
    return YES;
}

- (void)didWhenShakeActionEnded{
    [self showShakeWaiting:YES];
    
    //TODO: load from api
    
    if (_locationManager == nil) {
        _locationManager = [[CLLocationManager alloc] init];
        _locationManager.delegate = self;
        _locationManager.desiredAccuracy = kCLLocationAccuracyBest;
    }
    
    if(!_isGettingLocation){
        _isGettingLocation = YES;
        [_locationManager startUpdatingLocation];
        [self performSelector:@selector(stopUpdatingLocation:) withObject:@"Timed Out" afterDelay:15];
    }
    
    
    
}

#pragma mark Location Manager Interactions
- (void)locationManager:(CLLocationManager *)manager didUpdateToLocation:(CLLocation *)newLocation fromLocation:(CLLocation *)oldLocation {

    self.bestLocation = newLocation;
    
    [self stopUpdatingLocation:@"Acquired Location"];
    // we can also cancel our previous performSelector:withObject:afterDelay: - it's no longer necessary
    [NSObject cancelPreviousPerformRequestsWithTarget:self selector:@selector(stopUpdatingLocation:) object:nil];
    // update the display with the new location data
    //[self.tableView reloadData];
    
    //TODO: call api to get members by location
    [self performSelector:@selector(gotoResultsPage) withObject:nil afterDelay:2];
    
}

- (void)locationManager:(CLLocationManager *)manager didFailWithError:(NSError *)error {
    if ([error code] != kCLErrorLocationUnknown) {
        [self stopUpdatingLocation:@"Error"];
    }
}

- (void)stopUpdatingLocation:(NSString *)state {
    [_locationManager stopUpdatingLocation];
    //_locationManager.delegate = nil;
    
    _isGettingLocation = NO;
}

-(void)dealloc{
    [_activityIndicator release];
    [_lblIndicatorMsg release];
    [super dealloc];
}
@end
