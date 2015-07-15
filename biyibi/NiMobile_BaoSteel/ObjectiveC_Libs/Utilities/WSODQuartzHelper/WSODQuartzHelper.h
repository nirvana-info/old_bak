//
//  WSODQuartzHelper.h
//
//  Created by ryan.peterson on 12/7/09.
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import <Foundation/Foundation.h>


@interface WSODQuartzHelper : NSObject {

}

/*========================Clipping helpers========================*/
+ (void)clipCurrentContextWithRect:(CGRect)rect topLeftRadius:(CGFloat)tl topRightRadius:(CGFloat)tr bottomRightRadius:(CGFloat)br bottomLeftRadius:(CGFloat)bl;
+ (void)clipCurrentContextWithRect:(CGRect)rect radius:(CGFloat)radius;
+ (void)clipCurrentContextWithLowerCurveInRect:(CGRect)rect cornerRadius:(CGFloat)cornerRadius;

// (RIP Nov 17, 2010) - Meant to clip trapezoid with parallel top and bottom
// sides, and equal angles on the left and right sides. The top and bottom widths
// cannot be larger than the rect's width. If the top and/or bottom width is
// smaller than rect width, then that side is centered w/in the rect.
+ (void)clipCurrentContextAsTrapezoidWithRect:(CGRect)rect topWidth:(CGFloat)topWidth bottomWidth:(CGFloat)botWidth;

/*========================Gradient helpers========================
 * Notes:
 * Doesn't like [UIColor clearColor]. Pass solid color w/ 0 alpha instead.
 *================================================================*/
+ (UIImage *)gradientWithColors:(NSArray *)colors locations:(const CGFloat[])locations size:(CGSize)size startPoint:(CGPoint)startPoint endPoint:(CGPoint)endPoint;
+ (UIImage *)topDownGradientWithColors:(NSArray *)colors locations:(const CGFloat[])locations size:(CGSize)size;
+ (UIImage *)leftRightGradientWithColors:(NSArray *)colors locations:(const CGFloat[])locations size:(CGSize)size;

/*========================Dotted Line helpers=====================*/
+ (UIImage *)horizontalDottedLineWithWidth:(CGFloat)width;
+ (UIImage *)verticalDottedLineWithHeight:(CGFloat)height;

/*========================Solid Line helpers=====================*/
+ (UIImage *)horizontalSolidLineWithSize:(CGSize)size color:(UIColor *)color;
+ (UIImage *)horizontalSolidStackedLineWithWidth:(CGFloat)width colors:(NSArray *)colors heights:(NSArray *)heights;
+ (UIImage *)verticalSolidStackedLineWithHeight:(CGFloat)height colors:(NSArray *)colors widths:(NSArray *)widths;

@end