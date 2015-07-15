//
//  UIImage+Categories.m
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import "UIImage+Categories.h"


@implementation UIImage (Resizing)

+ (UIImage*)imageWithImage:(UIImage*)image scaledToSize:(CGSize)newSize;
{
    CGSize originalSize = [image size];
    if(originalSize.width > originalSize.height)
    {
        // reduce newSize.height
        newSize.height = newSize.width * (originalSize.height/originalSize.width);
    }
    else if(originalSize.width < originalSize.height)
    {
        // reduce newSize.width
        newSize.width = newSize.height * (originalSize.width/originalSize.height);
    }
    
    UIGraphicsBeginImageContext( newSize );
    [image drawInRect:CGRectMake(0,0,newSize.width,newSize.height)];
    UIImage* newImage = UIGraphicsGetImageFromCurrentImageContext();
    UIGraphicsEndImageContext();
    
    return newImage;
}

- (UIImage*)scaleImageToSize:(CGSize)newSize
{
    return [UIImage imageWithImage:self scaledToSize:newSize];
}

@end

@implementation UIImage (Convenience)

+ (UIImage*) imageFromMainBundleFile:(NSString*) fileName;
{
    NSString* bundlePath = [[NSBundle mainBundle] bundlePath];
    return [UIImage imageWithContentsOfFile:[NSString stringWithFormat:@"%@/%@", bundlePath, fileName]];
}

@end
