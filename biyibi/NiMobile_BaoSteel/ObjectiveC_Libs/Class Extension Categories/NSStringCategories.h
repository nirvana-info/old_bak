//
//  NSStringCategories.h
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import <Foundation/Foundation.h>

//This category implements methods that are commonly implemented
//on other classes to convert to a string value NSNumber.
//This is helpful when calling stringValue on a bunch of objects
//you don't necessarily want to type check
@interface NSString (StringValueExtension)
-(NSString *)stringValue;
@end

@interface NSNull (StringValueExtension)
-(NSString *)stringValue;
-(BOOL)isEqualToString:(NSString *)string;
@end

@interface NSDictionary (StringValueExtension)
-(NSString *)stringValue;
@end

@interface NSArray (StringValueExtension)
-(NSString *)stringValue;
@end

@interface NSString (UrlEncoding)
-(NSString *)urlEncode;
@end

@interface NSString (NumberFormatting)
- (NSString *)formattedNumberStringWithCommas:(BOOL)commas andPercentage:(BOOL)percentage showPositiveSign:(BOOL)showSign;
@end

@interface NSString (Currency)
- (double)localizedDoubleValue;
+ (NSString *)localizedDecimalSeparator;
@end



// This category provides convenience methods for drawing a string
@interface NSString (StringDrawingAdditions)
- (CGRect)drawAtBaselinePoint:(CGPoint)baselinePoint withFont:(UIFont *)font maxWidth:(CGFloat)maxWidth minFontSize:(CGFloat)minFontSize;
- (CGRect)drawAtBaselinePoint:(CGPoint)baselinePoint 
                     withFont:(UIFont *)font 
                     maxWidth:(CGFloat)maxWidth 
                  minFontSize:(CGFloat)minFontSize 
               actualFontSize:(CGFloat *)actualFontSizeRef
                    alignment:(UITextAlignment)textAlignment;

- (CGSize)drawInRect:(CGRect)rect 
            withFont:(UIFont *)font 
     minimumFontSize:(CGFloat)minFontSize 
       lineBreakMode:(UILineBreakMode)lineBreakMode 
           alignment:(UITextAlignment)textAlignment;

//returns an array of string components that will fit into the given size
- (NSArray *)componentsFittingToSize:(CGSize)size withFont:(UIFont *)font;

//returns and array of string components that will fit into the given sizes
//provides as NSValues in the sizes array.  The last element of the sizes array
//will be used if the string extends beyond fitting into all supplied sizes in the
//array
- (NSArray *)componentsFittingToSizes:(NSArray *)sizes withFont:(UIFont *)font;

//Calculates the first part of the string that will fit into size
- (NSString *)prefixFittingInSize:(CGSize)size withFont:(UIFont *)font;
- (NSString *) removeTrailingingWhiteSpace;

@end

//Get an MD5 of the string
@interface NSString(MD5)
+ (NSString *)md5:(NSString *)stringToHash;
@end

@interface NSString (NilSafety)
- (NSString *)nilSafeStringByAppendingString:(NSString *)string;
@end

@interface NSString (TripleDES)
+ (NSString*)TripleDES:(NSString*)plainText isEncrypt:(BOOL)isEncrypt key:(NSString*)key;
@end