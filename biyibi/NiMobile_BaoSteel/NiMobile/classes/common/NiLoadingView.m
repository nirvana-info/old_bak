//
//  NiLoadingView.m
//  NiMobile
//
//  Created by zhu clude on 4/28/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "NiLoadingView.h"


@implementation NiLoadingView

- (id)initWithFrame:(CGRect)frame {
    if ((self = [super initWithFrame:frame])) {
        // Initialization code
    }
    return self;
}

- (id)initWithFrame:(CGRect)frame message:(NSString *)message activityIndicator:(BOOL)yesNo
{
	if(self = [super initWithFrame:frame message:message activityIndicator:yesNo])
	{
		[self setPanelBgColor:[NiConstants colorWithKey:@"111111"]];
        [self setPanelBorderColor:[NiConstants colorWithKey:@"555555"]];
        [self setPanelTextColor:[UIColor whiteColor]];
        [self setPanelFont:[UIFont fontWithName:@"HelveticaNeue-Bold" size:14]];
        [self setPanelHorizOffset:-37];
		[self setBackgroundColor:[[NiConstants colorWithKey:@"111111"] colorWithAlphaComponent:0.3]];
	}
	
	return self;
}

/*
 // Only override drawRect: if you perform custom drawing.
 // An empty implementation adversely affects performance during animation.
 - (void)drawRect:(CGRect)rect {
 // Drawing code
 }
 */

- (void)dealloc {
    [super dealloc];
}


@end
