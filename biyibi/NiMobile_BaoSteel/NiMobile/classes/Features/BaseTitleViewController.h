//
//  BaseTitleViewController.h
//  YHMobile
//
//  Created by zhu clude on 9/13/12.
//
//

#import "BaseViewController.h"

@interface BaseTitleViewController : BaseViewController{
    UIView  *_titleHeaderView;
    UILabel *_titleHeaderLabel;
    UIToolbar *_headerToolbar;
    NSMutableArray *_titleBarItems;
}

@property(nonatomic,retain) UIView  *titleHeaderView;

- (void)setHeaderTitle:(NSString *)title;
- (void)updateTititleBarButtonStatus;

@end
