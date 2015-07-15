//
//  MainSearchViewController.m
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "MainSearchViewController.h"

@interface MainSearchViewController ()

@end

@implementation MainSearchViewController
@synthesize searchField = _searchField;
@synthesize searchString = _searchString;

#define PAD_W                       320
#define PAD_H                       460
#define PADDING_L                   10
#define PADDING_R                   10
#define PADDING_T                   100
#define PADDING_B                   20

#define ICON_H                      34
#define ICON_W                      90

#define LAB_H                       20
#define LAB_W                       220

#define LAB_ICON_PADDING            0


- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
        MenuItemList = [[NSMutableArray alloc] init];
        [MenuItemList addObject:@"冷卷"];
        [MenuItemList addObject:@"热卷"];
        [MenuItemList addObject:@"电工钢"];
        [MenuItemList addObject:@"酸洗"];
        [MenuItemList addObject:@"彩涂"];
        [MenuItemList addObject:@"镀锡"];
        [MenuItemList addObject:@"镀铝锡"];
        [MenuItemList addObject:@"镀铝"];
        
    }
    return self;
}

-(id)initWithTabBar
{
 	if ([super initWithTabBar])
	{
        
		self.title = @"搜索";
		self.navigationItem.title = @"搜索";
        
	}
	
	return self;
}

// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView
{
	[super loadView];
    CGRect f = self.view.frame;
    _mainPanel = [[UIScrollView alloc] initWithFrame:CGRectMake(f.origin.x, f.origin.y, f.size.width, f.size.height)];
    _mainPanel.contentSize = CGSizeMake(f.size.width, f.size.height);
    
    [self.view addSubview:_mainPanel];
    
    _searchField = [[UITextField alloc] initWithFrame:CGRectMake(20, 50, 280, 30)];
	[_searchField setAutocorrectionType:UITextAutocorrectionTypeNo];
	[_searchField setAutocapitalizationType:UITextAutocapitalizationTypeAllCharacters];
	[_searchField setClearButtonMode:UITextFieldViewModeWhileEditing];
	[_searchField setFont:[UIFont fontWithName:@"HelveticaNeue" size:14]];
	[_searchField setContentVerticalAlignment:UIControlContentVerticalAlignmentCenter];
	[_searchField setPlaceholder:@"品名/牌号"];
	[_searchField setBorderStyle:UITextBorderStyleRoundedRect];
	[_searchField setReturnKeyType:UIReturnKeySearch];
    [_searchField endEditing:YES];
	[_searchField setDelegate:self];
	
	UIImageView *searchGlassView = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"SearchFieldIcon.png"]];
    [_searchField setLeftView:searchGlassView];
	[searchGlassView release];
	
	[_searchField setLeftViewMode:UITextFieldViewModeAlways];
    
    _activityIndicator = [[UIActivityIndicatorView alloc] initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleGray];
	_activityIndicator.frame = CGRectMake(260.0, 21.0, 20.0, 20.0);
	
	
	[_mainPanel addSubview:_searchField];
    [_mainPanel addSubview: _activityIndicator];

}

- (void) viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    
}


-(void)StellSearch:(id)index
{
    _searchField.text = @"";
    NSString *str = [MenuItemList objectAtIndex:[index tag] -1];
    if(_searchDetailVC == nil){
        _searchDetailVC = [[SearchDetailViewController alloc] init];
    }
    [self.navigationController pushViewController:_searchDetailVC animated:YES];
    
    [_searchDetailVC setKeyword:str];
    DLog(@"Searche string was:%@", str);
    return;
}

-(void)keywordSearch:(NSString *)keyword{
    if(_searchDetailVC == nil){
        _searchDetailVC = [[SearchDetailViewController alloc] init];
    }
    [self.navigationController pushViewController:_searchDetailVC animated:YES];
    
    [_searchDetailVC setKeyword:keyword];
    DLog(@"keyword Searche string was:%@", keyword);
    return;
}


#pragma mark Private
- (void) setupMenuItems
{
    int count = [MenuItemList count];

    for (int i = 0; i< count; i++) {
        [self renderItem:i+1 withTitle:[MenuItemList objectAtIndex:i] andImgName:@"i_bg.png" withevent:@selector(StellSearch:) ];
        NSLog(@"I = %i",i);
        
    }

}

#pragma mark Public
- (void) renderItem:(NSInteger) index
          withTitle:(NSString*) name
         andImgName:(NSString*) imgName
          withevent:(SEL) event
{
    //Row 1-3
    int row = ceil((double)index /3);
    //Col 1-3
    int col = (index - 1) % 3 + 1;
    
    //Left and right all padding 20px
    CGFloat paddingX = (PAD_W - PADDING_L - PADDING_R - ICON_W * 3) / 2;
    CGFloat imgX = PADDING_L + (col - 1) * ICON_W + (col - 1) * paddingX;

    CGFloat paddingY = 20;

    CGFloat imgY = PADDING_T + (row - 1) * ICON_H +
    (row - 1) * paddingY;
    
    //Button
    UIImage *img = [[UIImage imageNamed:imgName] stretchableImageWithLeftCapWidth:0 topCapHeight:0];
    UIButton *btn = [[UIButton alloc] initWithFrame:CGRectMake(imgX, imgY, ICON_W, ICON_H)];
    [btn setBackgroundImage:img forState:UIControlStateNormal];
    [btn setEnabled:YES];
    [btn setTag:index];
    [btn setTitle:name forState:UIControlStateNormal];
    [btn setTitleColor:[NiConstants colorWithKey:@"333333"] forState:UIControlStateNormal];
    [btn setFont:[UIFont fontWithName:@"HelveticaNeue" size:14]];
	[btn setContentVerticalAlignment:UIControlContentVerticalAlignmentCenter];
    [btn addTarget:self action:event forControlEvents:UIControlEventTouchUpInside];
    [MenuItemList addObject:btn];
    [_mainPanel addSubview:btn];
    [btn release];
    

}




- (void)dealloc{
    [_searchField dealloc];
    [MenuItemList release];
    [_mainPanel release];
    [_searchString release];
    [super dealloc];
}


- (void)viewDidLoad
{
    [self setupMenuItems];
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}


#pragma mark UITextFieldDelegate methods

- (BOOL)textField:(UITextField *)textField shouldChangeCharactersInRange:(NSRange)range replacementString:(NSString *)string
{
	NSString *searchString = [[textField text] stringByReplacingCharactersInRange:range withString:string];
	if ([searchString isEqualToString:@"^"]) //wait for more characters
	{
		return YES;
	}

	if (![searchString isEqualToString:@""]) {
		[_activityIndicator startAnimating];
	}
	return YES;
}

- (BOOL)textFieldShouldReturn:(UITextField *)textField
{
	[textField resignFirstResponder];
	return YES;
}

- (BOOL)textFieldShouldClear:(UITextField *)textField
{
//	[[self searchResultsController] searchForString:@""];
	[_activityIndicator stopAnimating];
	return YES;
}

- (BOOL)textFieldShouldEndEditing:(UITextField *)textField{
    return YES;
}

-(void)textFieldDidEndEditing:(UITextField *)textField{
    if (textField.text != nil) {
        [self keywordSearch:textField.text];
        return;
    }
}



@end
