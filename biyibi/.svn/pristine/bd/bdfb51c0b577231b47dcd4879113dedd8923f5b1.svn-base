//
//  UILabel+Categories.h
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import <UIKit/UIKit.h>


@interface UILabel (DynamicResize)
// First increased width, then increases height, and finally decreases size.
// If text still doesn't fit, truncate.
// Label should already have text and font set, Returns NO otherwise.
- (BOOL)sizeToFitTextWithMaxRectSize:(CGSize)maxRectSize minFontSize:(CGFloat)minFontSize;
- (void)resizeFontWithMin:(CGFloat)minFontSize;
@end
