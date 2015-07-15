//
//  MemberDetailViewController.m
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "MemberDetailViewController.h"
#import "MemberInfo.h"

@interface MemberDetailViewController ()

@end

@implementation MemberDetailViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

-(void)loadView{
    [super loadView];
    
    _imgPhoto = [[UIImageView alloc] initWithFrame:CGRectMake(120, 40, 80, 80)];
    
    _lblName = [[UILabel alloc] initWithFrame:CGRectMake(120, 130, 80, 25)];
    _lblName.textColor = [NiConstants colorWithKey:@"182A39"];
    _lblName.backgroundColor = [UIColor clearColor];
    _lblName.font = [UIFont systemFontOfSize:14];
    
    _lblCompany = [[UILabel alloc] initWithFrame:CGRectMake(60, 180, 200, 22)];
    _lblCompany.textColor = [UIColor blackColor];
    _lblCompany.backgroundColor = [UIColor clearColor];
    _lblCompany.font = [UIFont systemFontOfSize:14];
    
    _lblCategories = [[UILabel alloc] initWithFrame:CGRectMake(60, 220, 200, 22)];
    _lblCategories.textColor = [UIColor blackColor];
    _lblCategories.backgroundColor = [UIColor clearColor];
    _lblCategories.font = [UIFont systemFontOfSize:14];
    
    UIButton *btCall = [UIButton buttonWithType:UIButtonTypeCustom];
    [btCall setImage:[UIImage imageNamed:@"btn_tel.png"] forState:UIControlStateNormal];
    [btCall setFrame:CGRectMake(100, 260, 120, 36)];
    [btCall addTarget:self action:@selector(callAction:event:) forControlEvents:UIControlEventTouchUpInside]; 
    
    
    
    [self.view addSubview:_imgPhoto];
    [self.view addSubview:_lblName];
    [self.view addSubview:_lblCompany];
    [self.view addSubview:_lblCategories];
    
    [self.view addSubview:btCall];

}

-(void)setMember:(MemberInfo *)member{
    [_imgPhoto setImage:[UIImage imageNamed:@"person-icon.png"]];
    
    _lblName.text = member.mname;
    
    _lblCompany.text =  [NSString stringWithFormat:   @"公   司： %@", member.company];
    _lblCategories.text =  [NSString stringWithFormat:@"关注品种： %@", @"品1, 品2"];
    //TODO:
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

- (void)dealloc
{
	[_imgPhoto release];
	[_lblName release];
    [_lblCompany release];
    [_lblCategories release];
	[super dealloc];
}

#pragma mark delegate phone.
- (void)callAction:(id)sender event:(id)event{
   
    NSString *num = [[NSString alloc] initWithFormat:@"tel://%@",@"12333"]; //number为号码字符串
    [[UIApplication sharedApplication] openURL:[NSURL URLWithString:num]]; //拨号

}

@end
