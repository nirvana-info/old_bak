//
//  MainMyFavViewController.m
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "MainMyFavViewController.h"

@interface MainMyFavViewController ()

@end

@implementation MainMyFavViewController

-(id)initWithTabBar
{
 	if ([super initWithTabBar])
	{
        self.title = @"我的关注";
		self.navigationItem.title = @"我的关注";
	}
	
	return self;
}



- (void)loadView{
    [super loadView];
    _mainWindow = [[UIView alloc] initWithFrame:[[self view] bounds]];
    [_mainWindow setFrameHeight:self.view.frame.size.height - kNavigationBarHeight];
        
    _btnView = [[UIView alloc] initWithFrame:CGRectMake(0,5,320,30)];
    _contentView = [[UIView alloc] initWithFrame:CGRectMake(
                                                            0,
                                                            CGRectGetMaxY(_btnView.frame),
                                                            320,
                                                            _mainWindow.frame.size.height - CGRectGetMaxY(_btnView.frame)
                                                            )];
      
    _steelBtn = [UIButton buttonWithType:UIButtonTypeCustom];
    _steelBtn.frame = CGRectMake(10, 10, 100, 20);
    [_steelBtn setTitleColor:[NiConstants colorWithKey:@"606060"] forState:UIControlStateNormal];
    [_steelBtn setTitle:@"关注品类" forState:UIControlStateNormal];
    [_steelBtn setTag:1];
    [_steelBtn.titleLabel setFont:[UIFont systemFontOfSize:14]];
    [_steelBtn addTarget:self action:@selector(btnClicked:) forControlEvents:UIControlEventTouchUpInside];
    _steelBtn.contentMode = UIViewContentModeScaleToFill;
    
    _memberBtn = [UIButton buttonWithType:UIButtonTypeCustom];
   _memberBtn.frame = CGRectMake(110, 10, 100, 20);
    [_memberBtn setTitleColor:[NiConstants colorWithKey:@"606060"] forState:UIControlStateNormal];
    [_memberBtn setTitle:@"关注的人" forState:UIControlStateNormal];
    [_memberBtn setTag:2];
    [_memberBtn.titleLabel setFont:[UIFont systemFontOfSize:14]];
    [_memberBtn addTarget:self action:@selector(btnClicked:) forControlEvents:UIControlEventTouchUpInside];
    _memberBtn.contentMode = UIViewContentModeScaleToFill;
    
    _companyBtn = [UIButton buttonWithType:UIButtonTypeCustom];
    _companyBtn.frame = CGRectMake(210, 10, 100, 20);
    [_companyBtn setTitleColor:[NiConstants colorWithKey:@"606060"] forState:UIControlStateNormal];
    [_companyBtn setTitle:@"关注店铺" forState:UIControlStateNormal];
    [_companyBtn setTag:3];
    [_companyBtn.titleLabel setFont:[UIFont systemFontOfSize:14]];
    [_companyBtn addTarget:self action:@selector(btnClicked:) forControlEvents:UIControlEventTouchUpInside];
    _companyBtn.contentMode = UIViewContentModeScaleToFill;
    
    UIView *line = [self getCellLine:_btnView];
        
    [_btnView addSubview:_steelBtn];
    [_btnView addSubview:_memberBtn];
    [_btnView addSubview:_companyBtn];
    
    [_mainWindow addSubview:_btnView];
    [_mainWindow addSubview:line];

    [_mainWindow addSubview:_contentView];
    
    [[self view] addSubview:_mainWindow];
    [self btnClicked:_steelBtn];

}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
}

- (UIView *)getCellLine:(UIView *)v{
    CGFloat y;
    y = v.frame.origin.y   +   v.frame.size.height    +   19;
    UIView *view = [[[UIView alloc] initWithFrame:CGRectMake(0, y, 320, 1)] autorelease];
    view.backgroundColor = [NiConstants colorWithKey:@"000000"];
    return view;
}

- (void)btnClicked:(id)sender{
    NSInteger tag = [sender tag];
    if (_currentVC != nil) {
        [_currentVC.view removeFromSuperview];
    }
    
    if (tag == 1) {
        if (_FavStellVC == nil) {
            _FavStellVC = [[FavSteelViewController alloc] init];
            _FavStellVC.parentVC = self;
        }
        _currentVC = _FavStellVC;
        [_contentView addSubview:_currentVC.view];
        [_currentVC viewWillAppear:YES];
    }else if(tag == 2){
        if(_FavMemberVC ==  nil){
            _FavMemberVC = [[FavMemberViewController alloc] init];
            _FavMemberVC.parentVC = self;
        }
        _currentVC = _FavMemberVC;
        [_contentView addSubview:_currentVC.view];
    }else if(tag == 3){
        if(_FavCompanyVC ==  nil){
            _FavCompanyVC = [[FavCompanyViewController alloc] init];
            _FavCompanyVC.parentVC = self;
        }
        _currentVC = _FavCompanyVC;
        [_contentView addSubview:_currentVC.view];
    }
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


//-(void)categoryButtonAction:(id)sender{
//    UIButton *btn = (UIButton *)sender;
//    NSInteger tagIdx = btn.tag;
//    
//    NSDictionary *cat = [_catLists objectAtIndex:tagIdx-1];
//    //TODO: do we need to select multi buttons??
//    NSMutableArray *selectedCats = [NSMutableArray arrayWithObjects:cat, nil];
//    
//    // goto next page
//    if(_vcWaiting == nil){
//        _vcWaiting = [[ShakeWaitingViewController alloc]init];
//    }
//    [_vcWaiting setCats:selectedCats];
//    
//    [self.navigationController pushViewController:_vcWaiting animated:YES];
//    
//}



-(void)dealloc{
    [_FavStellVC release];
    [_FavCompanyVC release];
    [_FavStellVC release];
      
    [_steelBtn release];
    [_companyBtn release];
    [_memberBtn release];
    [super dealloc];
}


@end
