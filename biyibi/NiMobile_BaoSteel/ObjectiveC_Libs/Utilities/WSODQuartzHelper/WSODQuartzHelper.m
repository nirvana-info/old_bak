//
//  WSODQuartzHelper.m
//
//  Created by ryan.peterson on 12/7/09.
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import "WSODQuartzHelper.h"


@implementation WSODQuartzHelper


/*========================Clipping helpers========================*/

+ (void)clipCurrentContextWithRect:(CGRect)rect topLeftRadius:(CGFloat)tl topRightRadius:(CGFloat)tr bottomRightRadius:(CGFloat)br bottomLeftRadius:(CGFloat)bl
{
    CGFloat minX = CGRectGetMinX(rect);
    CGFloat minY = CGRectGetMinY(rect);
    CGFloat maxX = CGRectGetMaxX(rect);
    CGFloat maxY = CGRectGetMaxY(rect);
    
    CGContextRef context = UIGraphicsGetCurrentContext();
    CGContextMoveToPoint(context, minX, minY + tl);
    CGContextAddArcToPoint(context, minX, minY, minX+tl, minY, tl);
    CGContextAddLineToPoint(context, maxX-tr, minY);
    CGContextAddArcToPoint(context, maxX, minY, maxX, minY+tr, tr);
    CGContextAddLineToPoint(context, maxX, maxY-br);
    CGContextAddArcToPoint(context, maxX, maxY, maxX-br, maxY, br);
    CGContextAddLineToPoint(context, minX+bl, maxY);
    CGContextAddArcToPoint(context, minX, maxY, minX, maxY-bl, bl);
    CGContextClip(context);
}

+ (void)clipCurrentContextWithRect:(CGRect)rect radius:(CGFloat)radius
{
    [self clipCurrentContextWithRect:rect topLeftRadius:radius topRightRadius:radius bottomRightRadius:radius bottomLeftRadius:radius];
}

+ (void)clipCurrentContextWithLowerCurveInRect:(CGRect)rect cornerRadius:(CGFloat)cornerRadius
{
    CGFloat minX = CGRectGetMinX(rect);
    CGFloat minY = CGRectGetMinY(rect);
    CGFloat midX = CGRectGetMidX(rect);
    CGFloat midY = CGRectGetMidY(rect);
    CGFloat maxX = CGRectGetMaxX(rect);
    CGFloat maxY = CGRectGetMaxY(rect);
    
    // The curve should pass through three points - 
    CGPoint point1 = CGPointMake(minX, midY);
    CGPoint point2 = CGPointMake(midX, maxY);
    CGPoint point3 = CGPointMake(maxX, midY);
    // Equation of a circle from three points (from http://local.wasp.uwa.edu.au/~pbourke/geometry/circlefrom3/ )
    CGFloat slopeA = (point2.y - point1.y) / (point2.x - point1.x);
    CGFloat slopeB = (point3.y - point2.y) / (point3.x - point2.x);
    CGPoint circleCenter;
    circleCenter.x = ((slopeA * slopeB * (point1.y - point3.y)) + (slopeB * (point1.x + point2.x)) - (slopeA * (point2.x + point3.x))) / (2 * (slopeB - slopeA));
    circleCenter.y = -1 * (((1/slopeA) * (circleCenter.x - ((point1.x + point2.x)/2))) + ((point1.y + point2.y) / 2));
    // The curve's radius is the distance between the circle's center and one of the three points.
    CGFloat circleRadius = sqrt(pow(circleCenter.x - point1.x, 2) + pow(circleCenter.y - point1.y, 2));
    
    CGContextRef context = UIGraphicsGetCurrentContext();
    CGContextMoveToPoint(context, minX, minY + cornerRadius);
    CGContextAddArcToPoint(context, minX, minY, minX+cornerRadius, minY, cornerRadius);
    CGContextAddLineToPoint(context, maxX-cornerRadius, minY);
    CGContextAddArcToPoint(context, maxX, minY, maxX, minY+cornerRadius, cornerRadius);
    CGContextAddLineToPoint(context, point3.x, point3.y);
    CGFloat slopeC = (circleCenter.y - point3.y) / (circleCenter.x - point3.x);
    CGFloat slopeD = (circleCenter.y - point1.y) / (circleCenter.x - point1.x);
    CGContextAddArc(context, circleCenter.x, circleCenter.y, circleRadius, atanf(slopeC), atanf(slopeD), 0);
    CGContextAddLineToPoint(context, minX, minY + cornerRadius);
    CGContextClip(context);
}

// (RIP Nov 17, 2010) - Meant to clip trapezoid with parallel top and bottom
// sides, and equal angles on the left and right sides. The top and bottom widths
// cannot be larger than the rect's width. If the top and/or bottom width is
// smaller than rect width, then that side is centered w/in the rect.
+ (void)clipCurrentContextAsTrapezoidWithRect:(CGRect)rect topWidth:(CGFloat)topWidth bottomWidth:(CGFloat)botWidth
{
    // (RIP Nov 17, 2010) - Reduce topWidth if necessary
    if(topWidth > rect.size.width)
    {
        DLog(@"topWidth too large, reducing to fit within rect");
        topWidth = rect.size.width;
    }
    
    // (RIP Nov 17, 2010) - Reduce bottomWidth if necessary
    if(botWidth > rect.size.width)
    {
        DLog(@"bottomWidth too large, reducing to fit within rect");
        botWidth = rect.size.width;
    }
    
    CGFloat topMinX = rect.origin.x + floorf((rect.size.width - topWidth)/2);
    CGFloat botMinX = rect.origin.x + floorf((rect.size.width - botWidth)/2);
    CGFloat minY = rect.origin.y;
    CGFloat topMaxX = topMinX + topWidth;
    CGFloat botMaxX = botMinX + botWidth;
    CGFloat maxY = CGRectGetMaxY(rect);
    
    CGContextRef context = UIGraphicsGetCurrentContext();
    CGContextMoveToPoint(context, topMinX, minY);
    CGContextAddLineToPoint(context, topMaxX, minY);
    CGContextAddLineToPoint(context, botMaxX, maxY);
    CGContextAddLineToPoint(context, botMinX, maxY);
    CGContextClip(context);
}

/*========================Gradient helpers========================*/

+ (UIImage *)gradientWithColors:(NSArray *)colors locations:(const CGFloat[])locations size:(CGSize)size startPoint:(CGPoint)startPoint endPoint:(CGPoint)endPoint
{
    // Replace the NSArray of UIColors with a C array of CGColorRefs
    CGColorRef cfColors[[colors count]];
    for(int i = 0; i < [colors count]; i++)
    {
        CGColorRef color = [[colors objectAtIndex:i] CGColor];
        cfColors[i] = color;
    }   
    
    // Create the gradient
    CFArrayRef cfColorsArray = CFArrayCreate(NULL, (void*)cfColors, [colors count], NULL);
    CGColorSpaceRef colorSpace = CGColorSpaceCreateDeviceRGB();
    CGGradientRef shadeGradient = CGGradientCreateWithColors(colorSpace, cfColorsArray, locations);
    
    // Create an image from the gradient
    UIGraphicsBeginImageContext(size);
    CGContextRef imageContext = UIGraphicsGetCurrentContext();
    CGContextDrawLinearGradient(imageContext, shadeGradient, startPoint, endPoint, kCGGradientDrawsBeforeStartLocation);
    CGGradientRelease(shadeGradient);
    CGColorSpaceRelease(colorSpace);
    UIImage *gradientImage = UIGraphicsGetImageFromCurrentImageContext();
    UIGraphicsEndImageContext();
	
	CFRelease(cfColorsArray);
    
    return gradientImage;
}

+ (UIImage *)topDownGradientWithColors:(NSArray *)colors locations:(const CGFloat[])locations size:(CGSize)size
{
    return [self gradientWithColors:colors locations:locations size:size startPoint:CGPointZero endPoint:CGPointMake(0, size.height)];
}

+ (UIImage *)leftRightGradientWithColors:(NSArray *)colors locations:(const CGFloat[])locations size:(CGSize)size
{
    return [self gradientWithColors:colors locations:locations size:size startPoint:CGPointZero endPoint:CGPointMake(size.width, 0)];
}

+ (UIImage *)horizontalDottedLineWithWidth:(CGFloat)width
{
    UIGraphicsBeginImageContext(CGSizeMake(width, 1));
    CGContextRef ctx = UIGraphicsGetCurrentContext();
    CGContextSetLineWidth(ctx, 1);
    float dashPhase = 0.0;
    float dashLengths[] = { 1, 1 };
    CGContextSetLineDash(ctx, dashPhase, dashLengths, sizeof(dashLengths) / sizeof(float));
    CGContextMoveToPoint(ctx, 0, 0);
    CGContextAddLineToPoint(ctx, width, 0);
    [[UIColor colorWithHexString:@"B2B2B2"] set];
    CGContextStrokePath(ctx);
    UIImage *dottedLine = UIGraphicsGetImageFromCurrentImageContext();
    UIGraphicsEndImageContext();
    
    return dottedLine;
}

+ (UIImage *)verticalDottedLineWithHeight:(CGFloat)height
{
    UIGraphicsBeginImageContext(CGSizeMake(1, height));
    CGContextRef ctx = UIGraphicsGetCurrentContext();
    CGContextSetLineWidth(ctx, 1);
    float dashPhase = 0.0;
    float dashLengths[] = { 1, 1 };
    CGContextSetLineDash(ctx, dashPhase, dashLengths, sizeof(dashLengths) / sizeof(float));
    CGContextMoveToPoint(ctx, 0, 0);
    CGContextAddLineToPoint(ctx, 0, height);
    [[UIColor colorWithHexString:@"B2B2B2"] set];
    CGContextStrokePath(ctx);
    UIImage *dottedLine = UIGraphicsGetImageFromCurrentImageContext();
    UIGraphicsEndImageContext();
    
    return dottedLine;
}

/*========================Solid Line helpers=====================*/

+ (UIImage *)horizontalSolidLineWithSize:(CGSize)size color:(UIColor *)color
{
    UIGraphicsBeginImageContext(CGSizeMake(size.width, 1));
    [color set];
    CGContextFillRect(UIGraphicsGetCurrentContext(), CGRectMake(0, 0, size.width, size.height));
    UIImage *solidLine = UIGraphicsGetImageFromCurrentImageContext();
    UIGraphicsEndImageContext();
    
    return solidLine;
}

+ (UIImage *)horizontalSolidStackedLineWithWidth:(CGFloat)width colors:(NSArray *)colors heights:(NSArray *)heights
{
    if([colors count] != [heights count])
    {
        DLog(@"colors length must match heights length. Returning nil.");
        return nil;
    }
    
    CGFloat totalHeight = [[heights valueForKeyPath:@"@sum.floatValue"] floatValue];
    
    UIGraphicsBeginImageContext(CGSizeMake(width, totalHeight));
    
    totalHeight = 0;
    CGContextRef ctx = UIGraphicsGetCurrentContext();
    for(int lineIdx = 0; lineIdx < [colors count]; lineIdx++)
    {
        [(UIColor *)[colors objectAtIndex:lineIdx] set];
        CGFloat stackHeight = [[heights objectAtIndex:lineIdx] floatValue];
        CGContextFillRect(ctx, CGRectMake(0, totalHeight, width, stackHeight));
        totalHeight += stackHeight;
    }
    
    UIImage *stackedLine = UIGraphicsGetImageFromCurrentImageContext();
    UIGraphicsEndImageContext();
    
    return stackedLine;
}

+ (UIImage *)verticalSolidStackedLineWithHeight:(CGFloat)height colors:(NSArray *)colors widths:(NSArray *)widths
{
    if([colors count] != [widths count])
    {
        DLog(@"colors length must match widths length. Returning nil.");
        return nil;
    }
    
    CGFloat totalWidth = [[widths valueForKeyPath:@"@sum.floatValue"] floatValue];
    
    UIGraphicsBeginImageContext(CGSizeMake(totalWidth, height));
    
    totalWidth = 0;
    CGContextRef ctx = UIGraphicsGetCurrentContext();
    for(int lineIdx = 0; lineIdx < [colors count]; lineIdx++)
    {
        [(UIColor *)[colors objectAtIndex:lineIdx] set];
        CGFloat stackWidth = [[widths objectAtIndex:lineIdx] floatValue];
        CGContextFillRect(ctx, CGRectMake(totalWidth, 0, stackWidth, height));
        totalWidth += stackWidth;
    }
    
    UIImage *stackedLine = UIGraphicsGetImageFromCurrentImageContext();
    UIGraphicsEndImageContext();
    
    return stackedLine;
}


@end