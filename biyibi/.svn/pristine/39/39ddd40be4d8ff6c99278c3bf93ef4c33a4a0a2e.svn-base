//
//  ShakeResultsViewController.m
//  NiMobile
//
//  Created by zhu clude on 5/3/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "ShakeResultsViewController.h"
#import "MemberInfo.h"

@interface ShakeResultsViewController ()

@end

@implementation ShakeResultsViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
        self.title = @"摇一摇";
		self.navigationItem.title = @"摇一摇";
        
        _dsMembers = [[DSMembers alloc] init];
        [_dsMembers setDelegate:self];
        
    }
    return self;
}

- (void)loadView
{
	[super loadView];
    
    _tableView = [[UITableView alloc] initWithFrame:[[self view] bounds] style:UITableViewStylePlain ];
	[_tableView setAutoresizingMask:UIViewAutoresizingFlexibleWidth];
	[_tableView setSeparatorColor:[NiConstants colorWithKey:@"EFD4BB"]];
	[_tableView setBackgroundColor:[NiConstants colorWithKey:@"FCEFE0"]];
	[_tableView setScrollEnabled:YES];
	[[self view] addSubview:_tableView];
    
    [_tableView setDelegate:_dsMembers];
    [_tableView setDataSource:_dsMembers];

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


@end
