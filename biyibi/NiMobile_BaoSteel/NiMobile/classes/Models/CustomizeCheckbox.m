//
//  CustomizeCheckbox.m
//  ZeccoMobile
//
//  Created by clude on 5/6/11.
//  Copyright 2011 __MyCompanyName__. All rights reserved.
//

#import "CustomizeCheckbox.h"

@interface CustomizeCheckbox()
// private methods
- (void)initCommon;
-(void)setCheckBoxStatus:(BOOL)ischecked;
@end

@implementation CustomizeCheckbox
@synthesize isChecked =_isChecked;

- (void)initCommon
{
	//self.frame =frame;
    self.contentHorizontalAlignment  = UIControlContentHorizontalAlignmentLeft;
    
    [self setCheckBoxStatus:_isChecked];
    // [self setImage:[UIImage imageNamed:@"checkbox_not_ticked.png"] forState:UIControlStateNormal];
    [self setContentVerticalAlignment:UIControlContentVerticalAlignmentCenter];
    [self setContentHorizontalAlignment:UIControlContentHorizontalAlignmentLeft];
    [self addTarget:self action:@selector(checkBoxClicked) forControlEvents:UIControlEventTouchUpInside];
}

- (id)initWithFrame:(CGRect)frame {
    self = [super initWithFrame:frame];
    if (self) {
        [self initCommon];
	}
    return self;
}

- (id)initWithCoder:(NSCoder *)aDecoder
{
	if((self = [super initWithCoder:aDecoder])){
		[self initCommon];
	}
	return self;
}

-(void)setCheckBoxStatus:(BOOL)ischecked{
    if(ischecked){
        [self setImage:[UIImage imageNamed:@"checkbox_ticked.png"] forState:UIControlStateNormal];
    }else{
        [self setImage:[UIImage imageNamed:@"checkbox_not_ticked.png"] forState:UIControlStateNormal];
    }
}

-(IBAction) checkBoxClicked{
    _isChecked = !_isChecked;
    [self setCheckBoxStatus:_isChecked];
}

- (void)setIsChecked:(BOOL)turnOn
{
    _isChecked = turnOn;
    [self setCheckBoxStatus:turnOn];
}



- (void)dealloc {
    [super dealloc];
}


@end
