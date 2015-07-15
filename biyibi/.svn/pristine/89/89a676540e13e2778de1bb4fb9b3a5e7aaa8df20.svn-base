//
//  DSMembers.m
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "DSMembers.h"
#import "MemberCell.h"
#import "MemberInfo.h"
#import "SessionDataController.h"

@implementation DSMembers

@synthesize lists = _lists;


-(id)init{
    if (self = [super init])
	{
         _lists = [[NSMutableArray alloc] init];
//        _favDataController = [[FavDataController alloc] init];
//        [_favDataController setDelegate:self];
//        
//        NSString *username =  [SessionDataController authenticationName];
//       [_favDataController getMyFollowUsers:username];
        
       
        
        
        
//        MemberInfo *m = [[MemberInfo alloc] init];
//        m.mname = @"test 1";
//        m.photoUrl = @"http://...";
//        m.gender = 1;
//        m.distance = 100;
//        m.comments = @"this is fucking test";
//        m.company = @"BaoStell";
//        
//        [_lists addObject:m];
//        [_lists addObject:m];
//        [_lists addObject:m];
//        [_lists addObject:m];
//        [_lists addObject:m];
//        [_lists addObject:m];
//        [_lists addObject:m];
//        [_lists addObject:m];
        
	}
	return self;
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
    
    static NSString *s_MemberCellIdentifier = @"s_POFeeEditCellIdentifier";
    MemberCell *cell = (MemberCell *)[tableView dequeueReusableCellWithIdentifier:s_MemberCellIdentifier];
    if(nil == cell)
    {
        cell = [[[MemberCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:s_MemberCellIdentifier] autorelease];
        [cell setSelectionStyle:UITableViewCellSelectionStyleNone];
        [cell setAccessoryType:UITableViewCellAccessoryDisclosureIndicator];
    }
    
    if (_lists != nil) {
        MemberInfo *mi = [_lists objectAtIndex:indexPath.row];
        [cell setMember:mi];
    }
    
    return cell;
    
}


- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    MemberInfo *mi = [_lists objectAtIndex:indexPath.row];
    if (self.delegate) {
        [self.delegate didSelectMember:mi];
    }
}

//-(CGFloat)tableView:(UITableView *)tableView heightForFooterInSection:(NSInteger)section{
//    return 44;
//}
//
//-(UIView *)tableView:(UITableView *)tableView viewForFooterInSection:(NSInteger)section{
//    UIView *vFooter = [[[UIView alloc] initWithFrame:CGRectMake(0, 0, 320, 44)] autorelease];
//    
//    UILabel *lblMsg = [[UILabel alloc] initWithFrame:CGRectMake(0, 0, 320, 44)];
//    [lblMsg setTextAlignment:NSTextAlignmentCenter];
//    [lblMsg setFont:[UIFont systemFontOfSize:13]];
//    [lblMsg setText:@"点击获得更多..."];
//    [lblMsg setTextColor:[NiConstants colorWithKey:@"FE5600"]];
//    [lblMsg setBackgroundColor:[UIColor clearColor]];
//    
//    
//    UITapGestureRecognizer *tapRecognizer = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(footerTaped)];
//    [lblMsg addGestureRecognizer:tapRecognizer];
//    [tapRecognizer release];
//    
//    [vFooter addSubview:lblMsg];
//    [lblMsg release];
//    
//    return vFooter;
//}
//
//-(void)footerTaped
//{
//    DLog(@"TODO: footer taped action...");
//}




@end
