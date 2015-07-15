//
//  BaseTitleViewController.m
//  YHMobile
//
//  Created by zhu clude on 9/13/12.
//
//

#import "BaseTitleViewController.h"

@interface BaseTitleViewController ()

@end

@implementation BaseTitleViewController

@synthesize titleHeaderView = _titleHeaderView;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)createTitleHeaderView{
    if (_titleHeaderView == nil) {
        CGFloat w = self.view.frame.size.width;

        
        _titleHeaderView = [[UIView alloc] initWithFrame:CGRectMake(0, 0, w, 41)];
        [_titleHeaderView setClipsToBounds:YES];
        _titleHeaderView.backgroundColor = [UIColor colorWithPatternImage:[[UIImage imageNamed:@"title_bg.png"] stretchableImageWithLeftCapWidth:0 topCapHeight:0]];
        
        _headerToolbar = [[UIToolbar alloc] initWithFrame:CGRectMake(0, 0, w, 41)];
        _headerToolbar.barStyle = UIBarStyleDefault;
        [_headerToolbar setBackgroundColor:[UIColor clearColor]];
        [_titleHeaderView addSubview:_headerToolbar];
        [_headerToolbar sizeToFit];
        
        NSMutableArray *barItems = [self getTitleBarItems];
        [_headerToolbar setItems:barItems animated:YES];


        
        _titleHeaderLabel = [[UILabel alloc] initWithFrame:CGRectMake(20, 0, 250, 41)];
        [_titleHeaderLabel setBackgroundColor:[UIColor clearColor]];
        [_titleHeaderLabel setFont:[UIFont boldSystemFontOfSize:18]];
        [_titleHeaderLabel setTextColor:[UIColor blackColor]];
        //[_titleHeaderLabel setText:@"DC采购需求查询"];
        [_titleHeaderView addSubview:_titleHeaderLabel];
        [self.view addSubview:_titleHeaderView];
    }
}

-(void)updateTititleBarButtonStatus{
    NSMutableArray *barItems = [self getTitleBarItems];
    [_headerToolbar setItems:barItems animated:YES];
}

-(NSMutableArray *)getTitleBarItems{

    NSMutableArray *barItems = [[NSMutableArray alloc] init];
    

    UIBarButtonItem *flexSpace = [[UIBarButtonItem alloc] initWithBarButtonSystemItem:UIBarButtonSystemItemFlexibleSpace target:self action:nil];
    [barItems addObject:flexSpace];
    [flexSpace release];
    
    return [barItems autorelease];

}


-(void)dealloc{
    [_titleHeaderLabel release];
    [_titleHeaderView release];
    [_titleBarItems release];
    [_headerToolbar release];
    [super dealloc];
}

- (void)setHeaderTitle:(NSString *)title{
    if (_titleHeaderView != nil) {
        _titleHeaderLabel.text = title;
    }
}




- (void)viewDidLoad
{
    [super viewDidLoad];
    [self createTitleHeaderView];
	// Do any additional setup after loading the view.
}

- (void)viewDidUnload
{
    [super viewDidUnload];
    // Release any retained subviews of the main view.
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

@end
