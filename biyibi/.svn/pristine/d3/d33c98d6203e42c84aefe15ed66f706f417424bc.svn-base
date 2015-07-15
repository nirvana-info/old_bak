//
//  UIImage+Categories.h
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import <Foundation/Foundation.h>


@interface UIImage (Resizing)
// Stole from http://ofcodeandmen.poltras.com/2008/10/30/undocumented-uiimage-resizing/
+ (UIImage*)imageWithImage:(UIImage*)image scaledToSize:(CGSize)newSize;
- (UIImage*)scaleImageToSize:(CGSize)newSize;
@end

@interface UIImage (Convenience)

// stolen from http://stackoverflow.com/questions/924740/dispelling-the-uiimage-imagenamed-fud
// this will load an image from the app bundle just like imageNamed, but doesn't cache it
+ (UIImage*)imageFromMainBundleFile:(NSString*)aFileName;

@end
