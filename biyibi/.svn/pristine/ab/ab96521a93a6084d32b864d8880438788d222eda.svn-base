//
//  MainNearByViewController.m
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "MainNearByViewController.h"
#import "DSMembers.h"
#import "MemberInfo.h"

@interface MainNearByViewController ()

@end

@implementation MainNearByViewController

-(id)initWithTabBar
{
 	if ([super initWithTabBar])
	{
        
		self.title = @"周边";
		self.navigationItem.title = @"周边";
        
        _dsMembers = [[DSMembers alloc] init];
        [_dsMembers setDelegate:self];
        
	}
	
	return self;
}

// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView
{
	[super loadView];
    
    _tableView = [[UITableView alloc] initWithFrame:[[self view] bounds] style:UITableViewStylePlain ];
    [_tableView setFrameHeight:self.view.frame.size.height - kNavigationBarHeight];

	[_tableView setAutoresizingMask:UIViewAutoresizingFlexibleWidth];
	[_tableView setSeparatorColor:[NiConstants colorWithKey:@"EFD4BB"]];
	[_tableView setBackgroundColor:[NiConstants colorWithKey:@"FCEFE0"]];
	[_tableView setScrollEnabled:YES];
	[[self view] addSubview:_tableView];
    
    [_tableView setDelegate:_dsMembers];
    [_tableView setDataSource:_dsMembers];
    
    [self setTableFooterView];
    
    
    // add segmeng control on nav bar
    NSArray *buttonNames = [NSArray arrayWithObjects:@"附近的人", @"附近公司", nil];
    UISegmentedControl* segmentedControl = [[UISegmentedControl alloc] initWithItems:buttonNames];
    segmentedControl.momentary = YES;
    //segmentedControl.segmentedControlStyle = UISegmentedControlStyleBordered;
    segmentedControl.autoresizingMask = UIViewAutoresizingFlexibleWidth;
    segmentedControl.segmentedControlStyle = UISegmentedControlStyleBar;
    segmentedControl.frame = CGRectMake(220, 0, 80, 30);
    [segmentedControl addTarget:self action:@selector(segmentAction:) forControlEvents:UIControlEventValueChanged];
    self.navigationItem.titleView = segmentedControl;
    [segmentedControl release];
	
    //    button.hidden = self.isBMMF;
}

-(void)segmentAction:(id)sender{
    UISegmentedControl* sg = (UISegmentedControl* )sender;
    NSInteger idx = sg.selectedSegmentIndex;
    if (idx == 0) {
        _mType = ListTypeMember;
    }else{
        _mType = ListTypeCompany;
    }
    
    [self apiGetNearbyLists];
    //_dsMembers.lists = [self getTestingList:_mType];
    //[_tableView reloadData];
    
}

-(void)didSelectMember: (MemberInfo *)member{
    if(_detailVC == nil){
        _detailVC = [[MemberDetailViewController alloc] init];
    }
    [self.navigationController pushViewController:_detailVC animated:YES];
    
    [_detailVC setMember:member];
}


- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)dealloc
{
	[_tableView release];
	[_dsMembers release];
	[super dealloc];
}

-(void)apiGetNearbyLists{
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
    
    //self.bestLocation = newLocation;
    
    [self stopUpdatingLocation:@"Acquired Location"];
    // we can also cancel our previous performSelector:withObject:afterDelay: - it's no longer necessary
    [NSObject cancelPreviousPerformRequestsWithTarget:self selector:@selector(stopUpdatingLocation:) object:nil];
    // update the display with the new location data
    //[self.tableView reloadData];
    
    //TODO: call api to get members by location
    _dsMembers.lists = [self getTestingList:_mType];
    [_tableView reloadData];
    
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

#pragma table footer-view
-(void)setTableFooterView{
    UIView *vFooter = [[UIView alloc] initWithFrame:CGRectMake(0, 0, 320, 35)];
    
    UILabel *lblMsg = [[UILabel alloc] initWithFrame:CGRectMake(0, 0, 320, 35)];
    [lblMsg setTextAlignment:NSTextAlignmentCenter];
    [lblMsg setFont:[UIFont systemFontOfSize:13]];
    [lblMsg setText:@"点击获得更多..."];
    [lblMsg setTextColor:[NiConstants colorWithKey:@"FE5600"]];
    [lblMsg setBackgroundColor:[UIColor clearColor]];
    [lblMsg setUserInteractionEnabled:YES];
    
    
    UITapGestureRecognizer *tapRecognizer = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(footerTaped)];
    [lblMsg addGestureRecognizer:tapRecognizer];
    [tapRecognizer release];
    
    [vFooter addSubview:lblMsg];
    [lblMsg release];
    
    _tableView.tableFooterView = vFooter;
    [vFooter release];

}

-(void)footerTaped
{
    DLog(@"TODO: footer taped action...");
}


-(NSMutableArray *)getTestingList: (MemberListType)lType{
    NSMutableArray *_lists = [[[NSMutableArray alloc] init] autorelease];
    
    MemberInfo *m = [[MemberInfo alloc] init];
    m.mname = @"test 1";
    m.photoUrl = @"http://...";
    m.gender = 1;
    m.distance = 100;
    m.comments = @"this is fucking test";
    m.company = @"BaoStell";
    
    if (lType == ListTypeCompany) {
        m.mname = @"company T";
        m.comments = @"this is BaoSteel test";
    }
    
    [_lists addObject:m];
    [_lists addObject:m];
    [_lists addObject:m];
    [_lists addObject:m];
    [_lists addObject:m];
    [_lists addObject:m];

    [m release];
    return _lists;
    
}

@end
