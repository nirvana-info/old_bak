//
//  UILabel+Categories.m
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import "UILabel+Categories.h"


@implementation UILabel (DynamicResize)

- (BOOL)sizeToFitTextWithMaxRectSize:(CGSize)maxRectSize minFontSize:(CGFloat)minFontSize {
    
    if(minFontSize > [[self font] pointSize])
        [self setFont:[[self font] fontWithSize:minFontSize]];
    
    CGSize labelSize = CGSizeZero;
	if(nil != [self text])
	{
		labelSize = [[self text] sizeWithFont:[self font] constrainedToSize:CGSizeMake(maxRectSize.width, 1000)];
	}
    CGFloat fontSize = [[self font] pointSize];

    while(labelSize.height > maxRectSize.height && fontSize >= minFontSize) {
        fontSize--;
        [self setFont:[[self font] fontWithSize:fontSize]];
		if(nil != [self text])
		{
			labelSize = [[self text] sizeWithFont:[self font] constrainedToSize:CGSizeMake(maxRectSize.width, 1000)];
		}
    }
    
    if(labelSize.height > maxRectSize.height)
	{
        labelSize.height = maxRectSize.height;
    }
	
    CGRect selfFrame = [self frame];
    selfFrame.size = labelSize;
    [self setFrame:selfFrame];
        
    return YES;
    
         
}

- (void)resizeFontWithMin:(CGFloat)minFontSize {
    CGSize maxSize = [self frame].size;
    maxSize.height = 1000; // arbitrary large height
	
	CGSize labelSize = CGSizeZero;
	if(nil != [self text])
	{
		labelSize = [[self text] sizeWithFont:[self font] constrainedToSize:maxSize];
	}
    
	while((labelSize.height > [self frame].size.height) && ([[self font] pointSize] > minFontSize)) {
        [self setFont:[[self font] fontWithSize:[[self font] pointSize]-1]];
		if(nil != [self text])
		{
			labelSize = [[self text] sizeWithFont:[self font] constrainedToSize:maxSize];
		}
    }
}

@end
