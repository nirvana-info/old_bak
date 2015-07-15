//
//  AuthSelectCityViewController.m
//  NiMobile
//
//  Created by zhu clude on 5/5/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "AuthSelectCityViewController.h"
#import "SteelTypeController.h"

@interface AuthSelectCityViewController ()

@end

@implementation AuthSelectCityViewController

@synthesize lists = _lists;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"城市设置";
		self.navigationItem.title = @"城市设置";
        
        _authDataController = [[AuthDataController alloc] init];
        [_authDataController setDelegate:self];
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
    
    [_tableView setDelegate:self];
    [_tableView setDataSource:self];
    
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

-(void)dealloc{

    [_lists release];
    
    [super dealloc];
}



#pragma mark - Table view data source
- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return 44;
	
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    if (_lists != nil) {
        return _lists.count;
    }
    return 0;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    
    UITableViewCell *cell = nil;
    static NSString *s_AuthCityIdentifier = @"s_AuthCityIdentifier";
    
    cell = (UITableViewCell *)[tableView dequeueReusableCellWithIdentifier:s_AuthCityIdentifier];
    if(nil == cell)
    {
        cell = [[[UITableViewCell alloc] initWithStyle:UITableViewCellStyleSubtitle reuseIdentifier:s_AuthCityIdentifier] autorelease];
        
        [cell setSelectionStyle:UITableViewCellSelectionStyleGray];
        [cell setAccessoryType:UITableViewCellAccessoryDisclosureIndicator];
        cell.textLabel.textColor = [NiConstants colorWithKey:@"182A39"];
        cell.textLabel.font = [UIFont fontWithName:@"Helvetica-Bold" size:14];
    }
    
    
    if (_lists != nil) {
        cell.textLabel.text = [_lists objectAtIndex:indexPath.row];
    }
    
    return cell;
    
}


- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    [self showLoadingViewWithMessage:@""];
    [_authDataController setCity:[_lists objectAtIndex:indexPath.row]];
    return;

}

-(void)setCitySuccessful{
   [self hideLoadingView];
    SteelTypeController *vc = [[SteelTypeController  alloc] init];
    
    [self.navigationController pushViewController:vc animated:YES];
    return;
}

@end
