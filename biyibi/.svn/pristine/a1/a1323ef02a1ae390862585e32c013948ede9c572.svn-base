//
//  MRCatInputTableViewCell.h
//  YHMobile
//
//  Created by nirvana on 9/11/12.
//
//

#import <UIKit/UIKit.h>
#import "CustomizeCheckbox.h"

@protocol SteelTypeCellDelegate <NSObject>

-(void)DidChangeCellCheckBoxValue:(BOOL)isChecked onIndexPath:(NSIndexPath *)indexPath;

@end

@interface SteelTypeCell : UITableViewCell<UITextFieldDelegate,SteelTypeCellDelegate>{
    UILabel *lbTitle;
    UITextField *lbValue;
     NSIndexPath* _Path;
    CustomizeCheckbox* ckBtn;
}

@property (nonatomic,retain) NSIndexPath* Path;

@property (nonatomic, assign) NSObject<SteelTypeCellDelegate> *vcDelegate;

- (void)setTitle:(NSString *)title andValue:(NSString *)value andEnable:(BOOL)flag;
- (void)setTitle:(NSString *)title;

-(BOOL) isChecked;
-(void) setChecked:(BOOL) isChecked;
-(void)showCheckBox;
@end
