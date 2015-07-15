//
//  UITableView+Categories.m
//  YHMobile
//
//  Created by zhu clude on 9/25/12.
//
//

#import "UITableView+Categories.h"

@implementation UITableView (nireload)

-(void)reloadRowAtIndexPath:(NSIndexPath *)indexPath withRowAnimation:(UITableViewRowAnimation)animation{
    if (indexPath != nil) {
        NSArray *arr = [NSArray arrayWithObject:indexPath];
        [self reloadRowsAtIndexPaths:arr withRowAnimation:animation];
    }
    
}

-(void)reloadSectionAtIndexPath:(NSIndexPath *)indexPath withRowAnimation:(UITableViewRowAnimation)animation{
    NSIndexSet *iset = [[NSIndexSet alloc] initWithIndex:indexPath.section];
    [self reloadSections:iset withRowAnimation:animation];
    [iset release];
}

@end
