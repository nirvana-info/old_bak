//
//  TabBarButton.m
//  Zecco
//
//  Created by sirish.jetti on 9/13/10.
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import "TabBarButton.h"


@implementation TabBarButton

@synthesize name=_name;

-(id) initWithFrame:(CGRect)frame andName:(NSString *)name
{
	if(self = [super initWithFrame:frame])
	{
		_name = name;
		_isSelected = FALSE;
		//[self addTarget:self action:@selector(buttonSelected) forControlEvents:UIControlEventTouchUpInside];
		[self setImageNormal];
	}
	
	return self;
}

-(void) setImageNormal
{
	//[self setImage:[UIImage imageNamed:[NSString stringWithFormat:@"%@%@%@",@"TabIcon_",_name,@".png"]] forState:UIControlStateNormal];
    [self setImage:NULL forState:UIControlStateNormal];
}

-(void) setImageSelected
{
	[self setImage:[UIImage imageNamed:[NSString stringWithFormat:@"%@%@%@",@"TabIcon_",_name,@"_Selected.png"]] forState:UIControlStateNormal];
}
-(void) buttonSelected
{
	if (!_isSelected) {
		_isSelected = TRUE;
		[self setImageSelected];
	}
	//send notification
}

@end
