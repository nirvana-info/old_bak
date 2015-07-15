//
//  UIView+Categories.h
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import <UIKit/UIKit.h>


@interface UIView (FrameConvenience)

- (void)setFrameSize:(CGSize)size;
- (void)setFrameHeight:(CGFloat)height;
- (void)setFrameWidth:(CGFloat)width;

- (void)setFrameOrigin:(CGPoint)origin;
- (void)setFrameXOrigin:(CGFloat)xOrigin;
- (void)setFrameYOrigin:(CGFloat)yOrigin;


- (void)setFrameRightBorderXValue:(CGFloat)xValue;
- (CGFloat)rightBorderXValue;
- (CGFloat)bottomBorderYValue;

- (CGRect)frameForBorderWithSize:(CGFloat)size;

- (void)centerVerticallyInSuperviewWithXOrigin:(CGFloat)xOrigin;
- (void)centerHorizontallyInSuperviewWithYOrigin:(CGFloat)yOrigin;
- (void)centerInSuperview;
- (void)centerInSuperviewWithOffset:(CGPoint)offset;

@end

@interface UIView (LogConvenience)

- (void)logSelfAndAncestors;
- (void)logSelfAndChildren;
- (void)logSelf;

@end

@interface UIView (Grid)

- (void)overlayGridWithLineSpace:(CGFloat)pixels color:(UIColor *)color;

@end

@interface UIView (Reflection)

- (UIImage *)bottomReflectedImageWithHeight:(NSUInteger)height;

@end

@interface UIView (responder)
- (UIView *)findFirstResponderUnder:(UIView *)root;
- (UITextField *)findFirstResponderTextField;
@end