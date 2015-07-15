//
//  MemberDetailViewController.m
//  NiMobile
//
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "SearchDetailViewController.h"
#import "ProductInfo.h"
#import "DSProduct.h"
#import "ProductCell.h"


@interface SearchDetailViewController ()

@end

@implementation SearchDetailViewController
@synthesize keyword = _keyword;
@synthesize product = _product;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
       
        _product = [[DSProduct alloc] init];
       [_product setDelegate:self];
        
        _searchDataController = [[SearchDataController alloc] init];
        [_searchDataController setDelegate:self];
        
    }
    return self;
}

-(void)loadView{
    [super loadView];
   
    _searchField = [[UITextField alloc] initWithFrame:CGRectMake(20, 10, 280, 30)];
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
	
	
	[[self view] addSubview:_searchField];
    [[self view] addSubview: _activityIndicator];
    
  //  _tableView = [[UITableView alloc] initWithFrame:[[self view] bounds] style:UITableViewStylePlain ];
    _tableView = [[UITableView alloc] initWithFrame:CGRectMake(0, 50, 320, 320) style:UITableViewStylePlain];
	//[_tableView setAutoresizingMask:UIViewAutoresizingFlexibleWidth];
	[_tableView setSeparatorColor:[NiConstants colorWithKey:@"EFD4BB"]];
	[_tableView setBackgroundColor:[NiConstants colorWithKey:@"FCEFE0"]];
	[_tableView setScrollEnabled:YES];
   
    [_tableView setDelegate:_product];
    [_tableView setDataSource:_product];

    
    [[self view] addSubview:_tableView];
    
}

-(IBAction)userDoneEnteringText:(id)sender
{
    UITextField *theField = (UITextField*)sender;
    // do whatever you want with this text field
}

-(void) viewWillAppear:(BOOL)animated{
    [super viewWillAppear:animated];
    if (_keyword != nil) {
        // to do ...
    }
    
}

-(void) setKeyword:(NSString *)keyword{
    _keyword = keyword;
    self.title = keyword;
    self.navigationItem.title = keyword;
    [_searchDataController searchTags:keyword];
}

-(void) return_search_tags:(NSDictionary *)obj{
    NSMutableArray *lists = [[[NSMutableArray alloc] init] autorelease];
    
    if (obj != nil) {
        for (NSArray *item in obj) {
            for (NSDictionary *data in item) {
                ProductInfo *p = [[ProductInfo alloc] init];
                p.photoUrl = [data objectForKey:@"url"];
                p.name = [data objectForKey:@"store_name"];
                p.weight =[data objectForKey:@"weight"];
                p.price = [[data objectForKey:@"price"] doubleValue];
                p.qualityInfo = [data objectForKey:@"trademark"];  //Need to do
                p.service = [data objectForKey:@"trademark"];      //Need to do
                p.code = [data objectForKey:@"spider"];            //Need to do
                p.origin = [data objectForKey:@"producer"];
                p.place = [data objectForKey:@"stock_location"];
                p.size = [data objectForKey:@"spec"];
                p.sizeInfo = [data objectForKey:@"trademark"];    //Need to do
                p.comments = [data objectForKey:@"model"];        //Need to do
                p.stock = [[data objectForKey:@"id"] intValue];   //Need to do
                p.company = [data objectForKey:@"store_name"];    //Need to do
                
                [lists addObject:p];
            }
            

        }
        
    }
    _product.lists = lists;
    [_tableView reloadData];
    
    //        p.photoUrl = @"http://test.";
    //        p.name = @"酸洗热轧板卷";
    //        p.weight = @"9.47";
    //        p.price = 4120;
    //        p.qualityInfo = @"请在开盘时间查看";
    //        p.service = @"由BGGM开具发票并提供售后服务";
    //        p.code  = @"SPHC";
    //        p.origin = @"申江";
    //        p.place = @"杭州";
    //        p.size = @"3*1250*C";
    //        p.sizeInfo = @"**涂油**";
    //        p.comments  = @"在符合加工及运输存储要求的条件下，产品自出库之日起三个月内本公司将承担因产品本身缺陷（锈蚀除外）所产生的原料损伤。酸洗板极易锈蚀，其防绣质保期为一年。";
    //        p.stock = 2;
    //        p.company = @"上海龙治";
    
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
    //[_mainPanel release];
    [_activityIndicator release];
	[super dealloc];
}

-(void)didSelectProduct:(ProductInfo *)product{
    if(_detailInfoVC == nil){
        _detailInfoVC = [[DetailInfoViewController alloc] init];
    }
    [self.navigationController pushViewController:_detailInfoVC animated:YES];
    
    [_detailInfoVC setProduct:product];
    DLog(@"Did clicked!");
}

#pragma mark UITextFieldDelegate methods

- (BOOL)textField:(UITextField *)textField shouldChangeCharactersInRange:(NSRange)range replacementString:(NSString *)string
{
	NSString *searchString = [[textField text] stringByReplacingCharactersInRange:range withString:string];
	if ([searchString isEqualToString:@"^"]) //wait for more characters
	{
		return YES;
	}
	DLog(@"Search string:%@",string);
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


@end
