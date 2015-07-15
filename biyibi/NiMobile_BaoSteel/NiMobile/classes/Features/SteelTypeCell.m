//
//  MRCatInputTableViewCell.m
//  YHMobile
//
//  Created by nirvana on 9/11/12.
//
//

#import "SteelTypeCell.h"

@implementation SteelTypeCell

@synthesize Path = _Path;
@synthesize vcDelegate = _vcDelegate;

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        [self setSelectionStyle:UITableViewCellEditingStyleNone];

        // Initialization code
        lbTitle = [[UILabel alloc] initWithFrame:CGRectMake(0, 10, 100, 20)];
        [lbTitle setBackgroundColor:[UIColor clearColor]];
        lbTitle.textColor = [NiConstants colorWithKey:@"182A39"];
        lbTitle.font = [UIFont fontWithName:@"Helvetica" size:13];
        [self.contentView addSubview:lbTitle];
        [lbTitle release];
        
        
        ckBtn = [[CustomizeCheckbox alloc] initWithFrame:CGRectMake(250, 7, 30, 30)];
       //ckBtn.hidden = !hasCheckBox;
        [ckBtn addTarget:self action:@selector(checkBoxClicked) forControlEvents:UIControlEventTouchUpInside];

        [self addSubview:ckBtn];
        
        
//        lbValue= [[UITextField alloc] initWithFrame:CGRectMake(120, 10, 100, 30)];
//        [lbValue setFont:[UIFont systemFontOfSize:15]];
//        [lbValue setBackgroundColor:[UIColor clearColor]];
//        
//        [lbValue setDelegate:self];
//        
//        [[NSNotificationCenter defaultCenter] addObserver:self
//												 selector:@selector(textFieldTextDidChange:)
//													 name:UITextFieldTextDidChangeNotification
//												   object:lbValue];
//        [self.contentView addSubview:lbValue];
//
//        [lbValue release];
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

    // Configure the view for the selected state
}

- (void)setTitle:(NSString *)title andValue:(NSString *)value andEnable:(BOOL)flag{
  
    [lbTitle setText:title];
    [lbValue setText:value];
    [lbValue setEnabled:flag];
    
}

- (void)setTitle:(NSString *)title{
    [lbTitle setText:title];
}

-(void)showCheckBox{
    ckBtn = [[CustomizeCheckbox alloc] initWithFrame:CGRectMake(0, 7, 30, 20)];
    [self.contentView addSubview:ckBtn];
    
}

-(IBAction) checkBoxClicked{
    if (_vcDelegate != nil) {
        [_vcDelegate DidChangeCellCheckBoxValue:ckBtn.isChecked onIndexPath:self.Path];
    }
}


-(BOOL) isChecked
{
    return ckBtn.isChecked;
}

-(void) setChecked:(BOOL) isChecked
{
    [ckBtn setIsChecked:isChecked];
}

-(void)dealloc{
    [lbTitle release];
    [lbValue release];
    [super dealloc];
}

- (BOOL)textFieldShouldReturn:(UITextField *)textField
{
	[textField resignFirstResponder];
	return YES;
}

- (void)textFieldDidBeginEditing:(UITextField  *)textField
{
}
- (void)textFieldDidEndEditing:(UITextField  *)textField
{
    
	[self didEditTextField];
}

- (void)didEditTextField{
//    if (self.Delegate != nil) {
//        [self.Delegate orderEditChanged:lbValue.text atIndexPath:_Path];
//    }
}

#pragma mark - text field notification


- (void)textFieldTextDidChange:(NSNotification*)note
{
    [self didEditTextField];
}

@end
