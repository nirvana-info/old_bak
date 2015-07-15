//
//  FavSteelViewController.m
//  NiMobile
//
//  Created by nirvana on 5/15/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "FavSteelViewController.h"
#import "Steels.h"
#import "SessionDataController.h"


#define PAD_W 320
#define PADDING_L 30
#define PADDING_R 30
#define PADDING_T 20
#define ICON_W 50
#define ICON_H 40
#define LAB_W 90
#define LAB_ICON_PADDING 8
#define LAB_H 20

@interface FavSteelViewController ()
-(void)showShakeWaiting:(BOOL)isShow;
@end

@implementation FavSteelViewController

@synthesize parentVC;

-(id)initWithTabBar
{
 	if ([super initWithTabBar])
	{

       
	}
	
	return self;
}

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
      
        _favDataController = [[FavDataController alloc] init];
        [_favDataController setDelegate:self];
        
    //    [_favDataController getAuthUser];
         
        if (_catLists == nil) {
            _catLists = [[NSMutableArray alloc] init];
        }
 
    }
    return self;
}

-(void)showShakeWaiting:(BOOL)isShow{
}

- (void)loadView{
    [super loadView];
    
    [self showLoadingViewWithMessage:@""];
    NSString *username =  [SessionDataController authenticationName];
    [_favDataController getMyFollowTags:username];
    [self hideLoadingView];
}


- (void)viewDidLoad
{
    [super viewDidLoad];
    
    // Uncomment the following line to preserve selection between presentations.
    // self.clearsSelectionOnViewWillAppear = NO;
    
    // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
    // self.navigationItem.rightBarButtonItem = self.editButtonItem;
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//program mark delegate.
-(void) getUserInfo:(NSDictionary *)obj{
    if (obj != nil) {
        _username = [obj objectForKey:@"username"];
        
        if (_username != nil) {
            [_favDataController getMyFollowTags:_username];
        }
        
    }
}

-(void)return_follow_tags:(NSDictionary *)obj{
    if (obj != nil) {
        for (NSDictionary *item in obj) {
            Steels *s = [[Steels alloc] init];
            s.photoUrl = @"btn-add.png";
            s.name = [item objectForKey:@"name"];
            s.steelCode = [item objectForKey:@"objct_id"];
            [_catLists addObject:s];
        }
        
    }

        int i = 0;
        for (Steels *cat in _catLists) {
            i++;
            [self renderItem:i
                   withTitle: cat.name
                  andImgName: cat.photoUrl
                   withevent:@selector(categoryButtonAction:) ];
}

}

-(NSMutableArray *)getCategories{
    NSMutableArray *lists = [[NSMutableArray alloc] init];
    //[_favDataController getMyFollowTags:_username];
    
    Steels *s1 = [[Steels alloc] init];
    s1.photoUrl = @"btn-add.png";
    s1.name = @"热轧板卷";
    s1.steelCode = @"1";
    [lists addObject:s1];
    [s1 release];
    
    Steels *s2 = [[Steels alloc] init];
    s2.photoUrl = @"btn-add.png";
    s2.name = @"中厚板";
    s1.steelCode = @"2";
    [lists addObject:s2];
    [s2 release];
    
    Steels *s3 = [[Steels alloc] init];
    s3.photoUrl = @"btn-add.png";
    s3.name = @"普冷";
    s1.steelCode = @"3";
    [lists addObject:s3];
    [s3 release];
    
    Steels *s4 = [[Steels alloc] init];
    s4.photoUrl = @"btn-add.png";
    s4.name = @"热镀锌";
    s1.steelCode = @"4";
    [lists addObject:s4];
    [s4 release];
    
    Steels *s5 = [[Steels alloc] init];
    s5.photoUrl = @"btn-add.png";
    s5.name = @"酸洗";
    s1.steelCode = @"5";
    [lists addObject:s5];
    [s5 release];
    
    Steels *s6 = [[Steels alloc] init];
    s6.photoUrl = @"btn-add.png";
    s6.name = @"取向电工钢";
    s1.steelCode = @"6";
    [lists addObject:s6];
    [s6 release];
    
    Steels *s7 = [[Steels alloc] init];
    s7.photoUrl = @"btn-add.png";
    s7.name = @"镀铬";
    s1.steelCode = @"7";
    [lists addObject:s7];
    [s7 release];
    
    Steels *s8 = [[Steels alloc] init];
    s8.photoUrl = @"btn-add.png";
    s8.name = @"电镀锌";
    s1.steelCode = @"8";
    [lists addObject:s8];
    [s8 release];
    
    Steels *s9 = [[Steels alloc] init];
    s9.photoUrl = @"btn-add.png";
    s9.name = @"彩涂";
    s1.steelCode = @"9";
    [lists addObject:s9];
    [s9 release];
    
    Steels *s10 = [[Steels alloc] init];
    s10.photoUrl = @"btn-add.png";
    s10.name = @"镀锡";
    s1.steelCode = @"10";
    [lists addObject:s10];
    [s10 release];
    
    Steels *s11 = [[Steels alloc] init];
    s11.photoUrl = @"btn-add.png";
    s11.name = @"镀铝锌";
    s1.steelCode = @"11";
    [lists addObject:s11];
    [s2 release];
    
    Steels *s12 = [[Steels alloc] init];
    s12.photoUrl = @"btn-add.png";
    s12.name = @"轧硬卷";
    s1.steelCode = @"12";
    [lists addObject:s12];
    [s12 release];
    return lists;
    
}

-(void)categoryButtonAction:(id)sender{
    UIButton *btn = (UIButton *)sender;
    NSInteger tagIdx = btn.tag;
    
    //NSDictionary *cat = [_catLists objectAtIndex:tagIdx-1];
    //TODO: do we need to select multi buttons??
   // NSMutableArray *selectedCats = [NSMutableArray arrayWithObjects:cat, nil];
    
    // goto next page
    if(_vcSearch == nil){
        _vcSearch = [[SearchDetailViewController alloc]init];
    }
    [_vcSearch setKeyword:[[_catLists objectAtIndex:tagIdx-1] name]];
    
    [self.parentVC.navigationController pushViewController:_vcSearch animated:YES];
    
}


#pragma mark Public
- (void) renderItem:(NSInteger) index
          withTitle:(NSString*) name
         andImgName:(NSString*) imgName
          withevent:(SEL) event
{
    //Row 1-3
    int row = ceil((double)index /4);
    //Col 1-4
    int col = (index - 1) % 4 + 1;
    
    //Left and right all padding 20px
    CGFloat paddingX = (PAD_W - PADDING_L - PADDING_R - ICON_W * 4) / (4-1);
    CGFloat imgX = PADDING_L + (col - 1) * ICON_W + (col - 1) * paddingX;
    CGFloat labX = imgX + ICON_W / 2 - LAB_W / 2;
    //Top padding 30, bottom padding 40.
    CGFloat paddingY = PADDING_T; //(PAD_H - PADDING_T - PADDING_B - (ICON_H + LAB_ICON_PADDING + LAB_H) * 3) / 2;
    CGFloat imgY = PADDING_T + (row - 1) * ICON_H +
    (row - 1) * (LAB_ICON_PADDING) +
    (row - 1) * (LAB_H) +
    (row - 1) * paddingY;
    
    CGFloat labY = imgY + ICON_H + LAB_ICON_PADDING;
    
    //Button
    UIImage *img = [[UIImage imageNamed:imgName] stretchableImageWithLeftCapWidth:0 topCapHeight:0];
    UIButton *btn = [[UIButton alloc] initWithFrame:CGRectMake(imgX, imgY, ICON_W, ICON_H)];
    [btn setBackgroundImage:img forState:UIControlStateNormal];
    [btn setEnabled:YES];
    [btn setTag:index];
    [btn addTarget:self action:event forControlEvents:UIControlEventTouchUpInside];
    [self.view addSubview:btn];
    [btn release];
    
    //Label
    UILabel *lb = [[UILabel alloc] initWithFrame:CGRectMake(labX, labY, LAB_W, LAB_H)];
    [lb setTextAlignment:NSTextAlignmentCenter];
    [lb setFont:[UIFont systemFontOfSize:13]];
    [lb setText:name];
    [lb setTextColor:[NiConstants colorWithKey:@"FE5600"]];
    [lb setBackgroundColor:[UIColor clearColor]];
    [self.view addSubview:lb];
    [lb release];
}



-(void)dealloc{
    [_catLists release];
    [_lists release];
    [super dealloc];
}


@end
