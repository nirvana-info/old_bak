//
//  AreaSetViewController.m
//  biyibi
//
//  Created by nirvana on 5/2/13.
//  Copyright (c) 2013 nirvana. All rights reserved.
//

#import "SteelTypeController.h"
#import "AppDelegate.h"

#import "JSON.h"


@interface SteelTypeController ()

@end

@implementation SteelTypeController
@synthesize list = _list;
@synthesize checkList = _checkList;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"兴趣品种";
		self.navigationItem.title = @"兴趣品种";
        
        // Custom initialization
        batchPassBtn = [[UIBarButtonItem alloc] initWithTitle:@"下一步"
                                                        style:UIBarButtonItemStyleDone
                                                       target:self
                                                       action:@selector(batchButtonClick)];
        self.navigationItem.rightBarButtonItem = batchPassBtn;
        
        _checkList = [[NSMutableArray alloc] init];
        _authDataController = [[AuthDataController alloc] init];
        [_authDataController setDelegate: self];
       

    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    //[self setHeaderTitle:@"兴趣品种"];
   
    _list = [[NSMutableArray alloc] init];
    Steels *item1 =[[Steels alloc] init];
    item1.steelCode = @"19";
    item1.name = @"热轧";
    [[self list] addObject:item1];
    
    Steels *item2 =[[Steels alloc] init];
    item2.steelCode = @"9";
    item2.name = @"冷轧";
    [[self list] addObject:item2];
    
    Steels *item3 =[[Steels alloc] init];
    item3.steelCode = @"8";
    item3.name = @"热镀锌";
    [[self list] addObject:item3];
    
    Steels *item4 =[[Steels alloc] init];
    item4.steelCode = @"66";
    item4.name = @"酸洗";
    [[self list] addObject:item4];
    
    Steels *item5 =[[Steels alloc] init];
    item5.steelCode = @"9999990";       //Need to modify
    item5.name = @"电工钢";
    [[self list] addObject:item5];
    
    Steels *item6 =[[Steels alloc] init];
    item6.steelCode = @"50";
    item6.name = @"电镀锌";
    [[self list] addObject:item6];
    
    Steels *item7 =[[Steels alloc] init];
    item7.steelCode = @"37";
    item7.name = @"彩涂";
    [[self list] addObject:item7];
    
    Steels *item8 =[[Steels alloc] init];
    item8.steelCode = @"160";
    item8.name = @"镀锡";
    [[self list] addObject:item8];
    
    Steels *item9 =[[Steels alloc] init];
    item9.steelCode = @"1643";
    item9.name = @"镀铝锡";
    [[self list] addObject:item9];
    
    Steels *item10 =[[Steels alloc] init];
    item10.steelCode = @"9999991";       //Need to modify
    item10.name = @"轧硬卷";
    [[self list] addObject:item10];
    
    Steels *item11 =[[Steels alloc] init];
    item11.steelCode = @"9999992";       //Need to modify
    item11.name = @"镀铬";
    [[self list] addObject:item11];
    
//    
//    [[self list] addObject:@"热轧"];
//    [[self list] addObject:@"冷轧"];
//    [[self list] addObject:@"热镀锌"];
//    [[self list] addObject:@"酸洗"];
//    [[self list] addObject:@"电工钢"];
//    [[self list] addObject:@"电镀锌"];
//    [[self list] addObject:@"彩涂"];
//    [[self list] addObject:@"镀锡"];
//    [[self list] addObject:@"镀铝锡"];
//    
//    [[self list] addObject:@"软硬卷"];
//    [[self list] addObject:@"镀铬"];
    
    
    _tableView = [[UITableView alloc] initWithFrame:CGRectMake(10, 10, 300, self.view.frame.size.height - 10)];
    [_tableView setBackgroundColor:[UIColor whiteColor]];
    [_tableView setDelegate:self];
    [_tableView setDataSource:self];
    [self.view addSubview:_tableView];
    
	// Do any additional setup after loading the view.
}

-(void)dealloc{
    [_list dealloc];
    [_checkList dealloc];
    [super dealloc];
}

-(void)viewWillAppear:(BOOL)animated{
    [super viewWillAppear:animated];
    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


-(void)batchButtonClick
{
    [self showLoadingViewWithMessage:@""];
    [_authDataController followStell:_checkList];
    return;
//[(AppDelegate *)[[UIApplication sharedApplication] delegate] setLoginViewHidden:YES];

}

-(void) followSuccessful{
    [self hideLoadingView];
    [(AppDelegate *)[[UIApplication sharedApplication] delegate] setLoginViewHidden:YES];
    
}

-(void)DidChangeCellCheckBoxValue:(BOOL)isChecked onIndexPath:(NSIndexPath *)indexPath{
      
    if (isChecked) {
        [_checkList addObject:[[_list objectAtIndex:indexPath.row] steelCode]];
    }else{
        if (_checkList != nil) {
            [_checkList removeObject:[[_list objectAtIndex:indexPath.row] steelCode]];
        }
    }

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
    // Return the number of rows in the section.
    if(_list != nil){
        return [_list count];
    }
    return 0;
}


- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *CellIdentifier = @"Cell";
    int count = indexPath.row;
    
    
    SteelTypeCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier];
    if (cell == nil) {
        cell = [[[SteelTypeCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:CellIdentifier] autorelease];
      //  cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
    }
        
    if (_list != nil) {
        cell.textLabel.text = [[_list objectAtIndex:count] name];
     
        [cell setPath:indexPath];
        [cell setVcDelegate:self];
       
    }
    

    return cell;
}


- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{

    return; 
    
}


@end
