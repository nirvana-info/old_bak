//
//  UIView+Categories.m
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import "UIView+Categories.h"
#import <QuartzCore/QuartzCore.h>

@implementation UIView (FrameConvenience)

- (void)setFrameOrigin:(CGPoint)origin
{
	CGRect viewFrame = [self frame];
	viewFrame.origin = origin;
	[self setFrame:viewFrame];
}

- (void)setFrameXOrigin:(CGFloat)xOrigin {
    CGRect viewFrame = [self frame];
    viewFrame.origin.x = xOrigin;
    [self setFrame:viewFrame];
}

- (void)setFrameYOrigin:(CGFloat)yOrigin {
    CGRect viewFrame = [self frame];
    viewFrame.origin.y = yOrigin;
    [self setFrame:viewFrame];
}

- (void)setFrameSize:(CGSize)size
{
	CGRect viewFrame = [self frame];
	viewFrame.size = size;
	[self setFrame:viewFrame];
}

- (void)setFrameHeight:(CGFloat)height {
    CGRect viewFrame = [self frame];
    viewFrame.size.height = height;
    [self setFrame:viewFrame];
}

- (void)setFrameWidth:(CGFloat)width {
    CGRect viewFrame = [self frame];
    viewFrame.size.width = width;
    [self setFrame:viewFrame];
}

- (void)setFrameRightBorderXValue:(CGFloat)xValue {
    CGRect viewFrame = [self frame];
    viewFrame.origin.x = xValue - viewFrame.size.width;
    [self setFrame:viewFrame];
}

- (CGFloat)rightBorderXValue {
    CGFloat xOrigin = [self frame].origin.x;
    CGFloat width = [self frame].size.width;
    return (xOrigin + width);
}

- (CGFloat)bottomBorderYValue {
    CGFloat yOrigin = [self frame].origin.y;
    CGFloat height = [self frame].size.height;
    return (yOrigin + height);
}

- (CGRect)frameForBorderWithSize:(CGFloat)size {
    CGFloat x = [self frame].origin.x - size;
    CGFloat y = [self frame].origin.y - size;
    CGFloat width = [self frame].size.width + (size * 2);
    CGFloat height =  [self frame].size.height + (size * 2);
    return CGRectMake(x, y, width, height);
}

- (void)centerVerticallyInSuperviewWithXOrigin:(CGFloat)xOrigin
{
    if(nil == [self superview])
    {
        return;
    }
    
    CGRect superviewBounds = [[self superview] bounds];
    CGRect selfFrame = [self frame];
    selfFrame.origin.x = xOrigin;
    selfFrame.origin.y = floor((superviewBounds.size.height - selfFrame.size.height)/2);
    [self setFrame:selfFrame];
}
- (void)centerHorizontallyInSuperviewWithYOrigin:(CGFloat)yOrigin
{
    if(nil == [self superview])
    {
        return;
    }
    
    CGRect superviewBounds = [[self superview] bounds];
    CGRect selfFrame = [self frame];
    selfFrame.origin.x = floor((superviewBounds.size.width - selfFrame.size.width)/2);
    selfFrame.origin.y = yOrigin;
    [self setFrame:selfFrame];
}

- (void)centerInSuperview
{
    if(nil == [self superview])
    {
        return;
    }
    
    CGRect superviewBounds = [[self superview] bounds];
    CGRect selfFrame = [self frame];
    selfFrame.origin.x = floor((superviewBounds.size.width - selfFrame.size.width)/2);
    selfFrame.origin.y = floor((superviewBounds.size.height - selfFrame.size.height)/2);
    [self setFrame:selfFrame];
}

- (void)centerInSuperviewWithOffset:(CGPoint)offset
{
    if(nil == [self superview])
    {
        return;
    }
    CGRect superviewBounds = [[self superview] bounds];
    CGRect selfFrame = [self frame];
    selfFrame.origin.x = floor((superviewBounds.size.width - selfFrame.size.width)/2) + offset.x;
    selfFrame.origin.y = floor((superviewBounds.size.height - selfFrame.size.height)/2) + offset.y;
    [self setFrame:selfFrame];
}

@end

@interface UIView (LogConveniencePrivate)

- (void)logSelfWithoutHeader;
- (void)logSelfWithoutHeaderAndLeadingString:(NSString *)leading;
- (void)logHeader;
- (NSMutableString *)appendPaddedString:(NSString *)string toString:(NSMutableString *)original;
- (void)logSelfAndChildrenWithLeadingSpace:(NSString *)leading;

@end

@implementation UIView (LogConvenience)

/*** public ***/

- (void)logSelfAndAncestors {
    [self logHeader];
    
    UIView *viewToPrint = self;
    do {
        [viewToPrint logSelfWithoutHeader];
    }
    while((viewToPrint = [viewToPrint superview]) != nil);
}

- (void)logSelfAndChildren {
    [self logHeader];
    [self logSelfAndChildrenWithLeadingSpace:@""];
}

- (void)logSelf {
    [self logHeader];
    [self logSelfWithoutHeader];
}

/*** private ***/

- (void)logHeader {
    
    NSMutableString *header = [[NSMutableString alloc] init];
    [self appendPaddedString:@"class" toString:header];
    [self appendPaddedString:@"mem" toString:header];
    
    [self appendPaddedString:@"framex" toString:header];
    [self appendPaddedString:@"framey" toString:header];
    [self appendPaddedString:@"framew" toString:header];
    [self appendPaddedString:@"frameh" toString:header];
    
    [self appendPaddedString:@"contentw" toString:header];
    [self appendPaddedString:@"contenth" toString:header];
    
    NSLog(@"%@", header);
}

- (void)logSelfWithoutHeader {
    
    NSMutableString *viewInfo = [[NSMutableString alloc] init];
    [self appendPaddedString:[NSString stringWithFormat:@"%@", [self class]] toString:viewInfo];
    [self appendPaddedString:[NSString stringWithFormat:@"%p", self] toString:viewInfo];
    [self appendPaddedString:[NSString stringWithFormat:@"%.0f", [self frame].origin.x] toString:viewInfo];
    [self appendPaddedString:[NSString stringWithFormat:@"%.0f", [self frame].origin.y] toString:viewInfo];
    [self appendPaddedString:[NSString stringWithFormat:@"%.0f", [self frame].size.width] toString:viewInfo];
    [self appendPaddedString:[NSString stringWithFormat:@"%.0f", [self frame].size.height] toString:viewInfo];
    
    if([self isKindOfClass:[UIScrollView class]]) {
        CGSize viewContentSize = [(UIScrollView *)self contentSize];
        [self appendPaddedString:[NSString stringWithFormat:@"%.0f", viewContentSize.width] toString:viewInfo];
        [self appendPaddedString:[NSString stringWithFormat:@"%.0f", viewContentSize.height] toString:viewInfo];
    }
    
    NSLog(@"%@", viewInfo);
}

- (void)logSelfWithoutHeaderAndLeadingString:(NSString *)leading {
    
    NSMutableString *viewInfo = [[NSMutableString alloc] initWithString:leading];
    [self appendPaddedString:[NSString stringWithFormat:@"%@", [self class]] toString:viewInfo];
    [self appendPaddedString:[NSString stringWithFormat:@"%p", self] toString:viewInfo];
    [self appendPaddedString:[NSString stringWithFormat:@"%.0f", [self frame].origin.x] toString:viewInfo];
    [self appendPaddedString:[NSString stringWithFormat:@"%.0f", [self frame].origin.y] toString:viewInfo];
    [self appendPaddedString:[NSString stringWithFormat:@"%.0f", [self frame].size.width] toString:viewInfo];
    [self appendPaddedString:[NSString stringWithFormat:@"%.0f", [self frame].size.height] toString:viewInfo];
    
    if([self isKindOfClass:[UIScrollView class]]) {
        CGSize viewContentSize = [(UIScrollView *)self contentSize];
        [self appendPaddedString:[NSString stringWithFormat:@"%.0f", viewContentSize.width] toString:viewInfo];
        [self appendPaddedString:[NSString stringWithFormat:@"%.0f", viewContentSize.height] toString:viewInfo];
    }
    
    NSLog(@"%@", viewInfo);
}

- (void)logSelfAndChildrenWithLeadingSpace:(NSString *)leading {
    [self logSelfWithoutHeaderAndLeadingString:leading];
    for(UIView *subview in [self subviews]) {
        [subview logSelfAndChildrenWithLeadingSpace:[NSString stringWithFormat:@"%@-", leading]];
    }
}

- (NSMutableString *)appendPaddedString:(NSString *)string toString:(NSMutableString *)original {
    NSInteger columnWidth = 10.0;
    NSInteger lengthOfString = [string length];
    NSMutableString *newString;
    if(lengthOfString < columnWidth) {
        newString = [NSMutableString stringWithString:string];
        while([newString length] < columnWidth) {
            [newString appendString:@" "];
        }
    } else if(lengthOfString > columnWidth) {
        newString = [NSMutableString stringWithString:[string substringToIndex:columnWidth]];
    } else {
        newString = [NSMutableString stringWithString:string];
    }
    
    [newString appendString:@" | "];
    
    [original appendString:newString];
    return original;
}

@end

@implementation UIView (Grid)

- (void)overlayGridWithLineSpace:(CGFloat)pixels color:(UIColor *)color {
    NSInteger countAcross = [self frame].size.width / pixels;
    NSInteger countDown = [self frame].size.height / pixels;
    
    for(int i = 0; i <= countAcross; i++) {
        UIView *verticalLine = [[UIView alloc] initWithFrame:CGRectMake(i * pixels, 0, 1, [self frame].size.height)];
        [verticalLine setBackgroundColor:color];
        [self addSubview:verticalLine];
        [verticalLine release];
    }

    for(int i = 0; i <= countDown; i++) {
        UIView *horizontalLine = [[UIView alloc] initWithFrame:CGRectMake(0, i * pixels, [self frame].size.width, 1)];
        [horizontalLine setBackgroundColor:color];
        [self addSubview:horizontalLine];
        [horizontalLine release];
    }
}

@end

@implementation UIView (Reflection)

CGImageRef createGradientImage(int pixelsWide, int pixelsHigh)
{
	CGImageRef theCGImage = NULL;
	
	// gradient is always black-white and the mask must be in the gray colorspace
    CGColorSpaceRef colorSpace = CGColorSpaceCreateDeviceGray();
	
	// create the bitmap context
	CGContextRef gradientBitmapContext = CGBitmapContextCreate(NULL, pixelsWide, pixelsHigh,
															   8, 0, colorSpace, kCGImageAlphaNone);
	
	// define the start and end grayscale values (with the alpha, even though
	// our bitmap context doesn't support alpha the gradient requires it)
	CGFloat colors[] = {0.0, 1.0, 1.0, 1.0};
	
	// create the CGGradient and then release the gray color space
	CGGradientRef grayScaleGradient = CGGradientCreateWithColorComponents(colorSpace, colors, NULL, 2);
	CGColorSpaceRelease(colorSpace);
	
	// create the start and end points for the gradient vector (straight down)
	CGPoint gradientStartPoint = CGPointZero;
	CGPoint gradientEndPoint = CGPointMake(0, pixelsHigh);
	
	// draw the gradient into the gray bitmap context
	CGContextDrawLinearGradient(gradientBitmapContext, grayScaleGradient, gradientStartPoint,
								gradientEndPoint, kCGGradientDrawsAfterEndLocation);
	CGGradientRelease(grayScaleGradient);
	
	// convert the context into a CGImageRef and release the context
	theCGImage = CGBitmapContextCreateImage(gradientBitmapContext);
	CGContextRelease(gradientBitmapContext);
	
	// return the imageref containing the gradient
    return theCGImage;
}

CGContextRef createBitmapContext(int pixelsWide, int pixelsHigh)
{
    CGColorSpaceRef colorSpace = CGColorSpaceCreateDeviceRGB();
	
	// create the bitmap context
	CGContextRef bitmapContext = CGBitmapContextCreate (NULL, pixelsWide, pixelsHigh, 8,
														0, colorSpace,
														// this will give us an optimal BGRA format for the device:
														(kCGBitmapByteOrder32Little | kCGImageAlphaPremultipliedFirst));
	CGColorSpaceRelease(colorSpace);
	
    return bitmapContext;
}

- (UIImage *)bottomReflectedImageWithHeight:(NSUInteger)height
{
    if(height == 0)
		return nil;
	
	UIGraphicsBeginImageContext(self.bounds.size);
	[self.layer renderInContext:UIGraphicsGetCurrentContext()];
	UIImage *viewImage = UIGraphicsGetImageFromCurrentImageContext();
	UIGraphicsEndImageContext();
    
	// create a bitmap graphics context the size of the view
	CGContextRef mainViewContentContext = createBitmapContext(self.bounds.size.width, height);
	
	// create a 2 bit CGImage containing a gradient that will be used for masking the 
	// main view content to create the 'fade' of the reflection.  The CGImageCreateWithMask
	// function will stretch the bitmap image as required, so we can create a 1 pixel wide gradient
	CGImageRef gradientMaskImage = createGradientImage(1, height);
	
	// create an image by masking the bitmap of the mainView content with the gradient view
	// then release the  pre-masked content bitmap and the gradient bitmap
	CGContextClipToMask(mainViewContentContext, CGRectMake(0.0, 0.0, self.bounds.size.width, height), gradientMaskImage);
	CGImageRelease(gradientMaskImage);
	
	// In order to grab the part of the image that we want to render, we move the context origin to the
	// height of the image that we want to capture, then we flip the context so that the image draws upside down.
	CGContextTranslateCTM(mainViewContentContext, 0.0, height);
	CGContextScaleCTM(mainViewContentContext, 1.0, -1.0);
	
	// draw the image into the bitmap context
	CGContextDrawImage(mainViewContentContext, self.bounds, [viewImage CGImage]);
	
	// create CGImageRef of the main view bitmap content, and then release that bitmap context
	CGImageRef reflectionImage = CGBitmapContextCreateImage(mainViewContentContext);
	CGContextRelease(mainViewContentContext);
	
	// convert the finished reflection image to a UIImage 
	UIImage *theImage = [UIImage imageWithCGImage:reflectionImage];
	
	// image is retained by the property setting above, so we can release the original
	CGImageRelease(reflectionImage);
	
	return theImage;
}

@end


@implementation UIView (responder)

- (UIView *)findFirstResponderUnder:(UIView *)root {
    if (root.isFirstResponder)
        return root;    
    for (UIView *subView in root.subviews) {
        UIView *firstResponder = [self findFirstResponderUnder:subView];        
        if (firstResponder != nil)
            return firstResponder;
    }
    return nil;
}

- (UITextField *)findFirstResponderTextField {
    UIResponder *firstResponder = [self findFirstResponderUnder:[self window]];
    if (![firstResponder isKindOfClass:[UITextField class]])
        return nil;
    return (UITextField *)firstResponder;
}

@end

