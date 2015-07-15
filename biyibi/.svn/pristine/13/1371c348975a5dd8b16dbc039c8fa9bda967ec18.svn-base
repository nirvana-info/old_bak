//
//  MainSettingViewController.m
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "MainSettingViewController.h"

#define SYS_SET_USER_INFO 0
#define SYS_SET_LOGOUT 1

#define SYS_SET_VERSION 0
#define SYS_SET_ABOUTUS 1

@interface MainSettingViewController ()

@end

@implementation MainSettingViewController

-(id)initWithTabBar
{
 	if ([super initWithTabBar])
	{
        
		self.title = @"设置";
		self.navigationItem.title = @"设置";
        
	}
	
	return self;
}

// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView
{
	[super loadView];
    
    _tableView = [[UITableView alloc] initWithFrame:[[self view] bounds] style:UITableViewStyleGrouped];
    [_tableView setFrameHeight:self.view.frame.size.height - kNavigationBarHeight];
    [_tableView setBackgroundColor:[UIColor clearColor]];
    [_tableView setBackgroundView:nil];
    [_tableView setDelegate:self];
    [_tableView setDataSource:self];
    [_tableView setScrollEnabled:NO];
    [self.view addSubview:_tableView];
	
    //    button.hidden = self.isBMMF;
}



- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

#pragma mark - Table view data source
- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 2;
}

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return 44;
	
}

-(NSString *)tableView:(UITableView *)tableView titleForHeaderInSection:(NSInteger)section{
    if (section == 0) {
        return @"用户信息";
    }else{
        return @"系统信息";
    }
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    if (section == 0) {
        return 2;
    }else if(section == 1){
        return 2;
    }
    
    return 0;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    UITableViewCell *cell = nil;
    static NSString *s_SystemInfoCellIdentifier = @"s_SystemInfoCellIdentifier";
    
    cell = (UITableViewCell *)[tableView dequeueReusableCellWithIdentifier:s_SystemInfoCellIdentifier];
    if(nil == cell)
    {
        cell = [[[UITableViewCell alloc] initWithStyle:UITableViewCellStyleSubtitle reuseIdentifier:s_SystemInfoCellIdentifier] autorelease];
    }
    
    cell.accessoryType = UITableViewCellAccessoryNone;
    cell.textLabel.textColor = [NiConstants colorWithKey:@"182A39"];
    cell.textLabel.font = [UIFont systemFontOfSize:12];
    [cell setSelectionStyle:UITableViewCellSelectionStyleNone];
    if (indexPath.section == 0) {
        switch (indexPath.row) {
            case SYS_SET_USER_INFO:
                cell.textLabel.text = [NSString stringWithFormat:@"%@ - %@ ",  @"当前登录用户", @"TEST USER"];
                break;
            case SYS_SET_LOGOUT:
                cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
                //[cell setSelectionStyle:UITableViewCellSelectionStyleBlue];
                cell.textLabel.text = @"重新登录";
                break;
            default:
                cell.textLabel.text = @"";
                break;
        }
    }else if(indexPath.section == 1){
        switch (indexPath.row) {
            case SYS_SET_ABOUTUS:
                cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
                //[cell setSelectionStyle:UITableViewCellSelectionStyleBlue];
                cell.textLabel.text = @"关于我们";
                break;
            case SYS_SET_VERSION:
                cell.textLabel.text = [NSString stringWithFormat:@"应用程序版本 %@",[[[NSBundle mainBundle] infoDictionary] objectForKey:@"CFBundleVersion"]];
                break;
            default:
                cell.textLabel.text = @"";
                break;
        }
        
    }
    
    
    
    return cell;
    
}


- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    [_tableView deselectRowAtIndexPath:indexPath animated:YES];
    
    if (indexPath.section == 0) {
        if (indexPath.row == SYS_SET_LOGOUT) {
            //[self LogoutSystem];
        }
    }else if(indexPath.section == 1){
        if(indexPath.row == SYS_SET_ABOUTUS){
            UIAlertView *alertView = [[UIAlertView alloc]
                                      initWithTitle:@"关于我们"
                                      message:@"。。。。。。"
                                      delegate:self
                                      cancelButtonTitle:@"确认" otherButtonTitles:nil];
            [alertView show];
            [alertView release];
        }
        
    }
}



@end
