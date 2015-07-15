//
//  FavMemberViewController.m
//  NiMobile
//
//  Created by nirvana on 5/15/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//
#import "FavMemberViewController.h"
#import "DSMembers.h"
#import "MemberInfo.h"
#import "SessionDataController.h"

@interface FavMemberViewController ()

@end

@implementation FavMemberViewController
@synthesize parentVC;

-(id)initWithTabBar
{
 	if ([super initWithTabBar])
	{
        
//		self.title = @"关注的人";
//		self.navigationItem.title = @"关注的人";
        
	}
	
	return self;
}

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        _dsMembers = [[DSMembers alloc] init];
        [_dsMembers setDelegate:self];
        
        if(_favDataController   == nil){
            _favDataController = [[FavDataController alloc] init];
            [_favDataController setDelegate:self];
        }
    }
    return self;
}

// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView
{
	[super loadView];
    NSString *user = [SessionDataController authenticationName];
    [_favDataController getMyFollowUsers:user];
    
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

}

- (void) viewWillAppear:(BOOL)animated{
    [super viewWillAppear:animated];
   // _dsMembers.lists = [self getTestingList];
}

-(void)didSelectMember: (MemberInfo *)member{
    if(_detailVC == nil){
        _detailVC = [[MemberDetailViewController alloc] init];
    }
    [self.parentVC.navigationController pushViewController:_detailVC animated:YES];
    
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


-(NSMutableArray *)getTestingList{
    NSMutableArray *_lists = [[[NSMutableArray alloc] init] autorelease];
    
    MemberInfo *m = [[MemberInfo alloc] init];
    m.mname = @"Member test...";
    m.photoUrl = @"http://...";
    m.gender = 1;
    m.distance = 100;
    m.comments = @"this is member test";
    m.company = @"BaoStell";
    
//    if (lType == ListTypeCompany) {
//        m.mname = @"company T";
//        m.comments = @"this is BaoSteel test";
//    }
    
    [_lists addObject:m];
    [_lists addObject:m];
    [_lists addObject:m];
    [_lists addObject:m];
    [_lists addObject:m];
    [_lists addObject:m];
    
    [m release];
    return _lists;
    
}

//delegate
-(void)return_follow_users:(NSDictionary *)obj{
    NSMutableArray *_lists = [[[NSMutableArray alloc] init] autorelease];
    if (obj != nil) {
        for (NSDictionary *item in obj) {
            MemberInfo *m = [[MemberInfo alloc] init];
            m.mname = [item objectForKey:@"username"];
            m.photoUrl = @"http://...";
            m.gender = 1;
            m.distance = 100;
            m.comments = @"this is member test";
            m.company = @"BaoStell";
            [_lists addObject:m];
        }
        
    }
    _dsMembers.lists = _lists;
    [_tableView reloadData];
    
}

@end