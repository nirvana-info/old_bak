//
//  DSMembers.m
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "DSProduct.h"
#import "ProductInfo.h"
#import "ProductCell.h"

@implementation DSProduct

@synthesize lists = _lists;


-(id)init{
    if (self = [super init])
	{
        _lists = [[NSMutableArray alloc] init];
        
//       ProductInfo *p = [[ProductInfo alloc] init];
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
//        [_lists addObject:p];
//        [_lists addObject:p];
//        [_lists addObject:p];
//        [_lists addObject:p];
//        [_lists addObject:p];
//        [_lists addObject:p];
//        [_lists addObject:p];
//        [_lists addObject:p];
//        [p release];
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
    
    static NSString *s_MemberCellIdentifier = @"s_MemberCellIdentifierIdentifier";
    ProductCell *cell = (ProductCell *)[tableView dequeueReusableCellWithIdentifier:s_MemberCellIdentifier];
    if(nil == cell)
    {
        cell = [[[ProductCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:s_MemberCellIdentifier] autorelease];
        [cell setSelectionStyle:UITableViewCellSelectionStyleNone];
        //[cell setAccessoryType:UITableViewCellAccessoryDisclosureIndicator];
    }
    
    if (_lists != nil) {
        ProductInfo *mi = [_lists objectAtIndex:indexPath.row];
        [cell setProduct:mi];
    }
    
    return cell;
    
}


- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    ProductInfo *mi = [_lists objectAtIndex:indexPath.row];
    if (self.delegate) {
        [self.delegate didSelectProduct:mi];
    }
}

-(CGFloat)tableView:(UITableView *)tableView heightForHeaderInSection:(NSInteger)section{
    return 0;
}


@end
