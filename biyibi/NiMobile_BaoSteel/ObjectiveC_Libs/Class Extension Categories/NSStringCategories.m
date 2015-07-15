//
//  NSStringCategories.m
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import "NSStringCategories.h"
#import <CommonCrypto/CommonDigest.h>
#import <UIKit/UIKit.h>
#import <CommonCrypto/CommonCryptor.h>
#import "NSDataCategories.h"

@implementation NSString (StringValueExtension)
-(NSString *)stringValue
{
	return self;
}
@end

@implementation NSNull (StringValueExtension)

-(NSString *)stringValue
{
	return @"";
}

-(BOOL)isEqualToString:(NSString *)string
{
	return NO;
}

@end

@implementation NSDictionary (StringValueExtension)

-(NSString *)stringValue
{
	return [self description];
}

@end

@implementation NSArray (StringValueExtension)

-(NSString *)stringValue
{
	return [self description];
}

@end


@implementation NSString (UrlEncoding)

-(NSString *)urlEncode;
{
	
	return [(NSString *)CFURLCreateStringByAddingPercentEscapes(NULL,  
			(CFStringRef)self,  NULL,  (CFStringRef)@"!*'();:@&=+$,/?%#[]",  kCFStringEncodingUTF8) autorelease];
	
}

@end

@implementation NSString (NumberFormatting)

- (NSString *)formattedNumberStringWithCommas:(BOOL)commas andPercentage:(BOOL)percentage showPositiveSign:(BOOL)showSign
{
	NSString *outputString = [NSString stringWithString:self];
	
	outputString = [NSString stringWithFormat:@"%0.2f",[outputString doubleValue]];
		
	if(commas)
	{
		NSArray *stringSplitAtDecimal = [self componentsSeparatedByString:@"."];
	
		// Make sure there is at least one object in the array
		if([stringSplitAtDecimal count] > 0) {
			// determine the number of commas needed
			// Only the portion of the number before the decimal point will need commas
			NSInteger numberOfCommasNeeded;
			NSString *leftString = [stringSplitAtDecimal objectAtIndex:0];
			if([leftString length] > 0) {
				int checkOffset = 1;
				//If there is a negative sign then increase the offset
				if([leftString hasPrefix:@"-"] || [leftString hasPrefix:@"+"])
				{
					++checkOffset;
				}
				numberOfCommasNeeded = ([leftString length]-checkOffset)/3;
			} else {
				numberOfCommasNeeded = 0;
			}
			
			
			NSString *stringWithoutCommas = [stringSplitAtDecimal objectAtIndex:0];
			NSString *stringWithCommas = @"";
			for(int i = 0; i < numberOfCommasNeeded; i++) {
				// Work backwards, removing the last three digits from stringWithoutCommas 
				NSString *nextPortion = [stringWithoutCommas substringFromIndex:[stringWithoutCommas length]-3];
				stringWithoutCommas = [stringWithoutCommas substringToIndex:[stringWithoutCommas length]-3];
				//and adding them to the front of stringWithCommas, including a leading comma.
				stringWithCommas = [NSString stringWithFormat:@",%@",[nextPortion stringByAppendingString:stringWithCommas]];
			}
			
			// Add the rest of stringWithoutCommas to the beginning of stringWithCommas.
			stringWithCommas = [stringWithoutCommas stringByAppendingString:stringWithCommas];
			
			// If there was a decimal, add the characters after the decimal to stringWithCommas
			if([stringSplitAtDecimal count] > 1) {
				NSString *decimalNumber = [stringSplitAtDecimal objectAtIndex:1];
				if([decimalNumber length] < 2)
				{
					stringWithCommas = [stringWithCommas stringByAppendingFormat:@".%@0",decimalNumber];
				}
				else
				{
					stringWithCommas = [stringWithCommas stringByAppendingFormat:@".%@",[decimalNumber substringToIndex:2]];
				}
				
			}
			else
			{
				stringWithCommas = [stringWithCommas stringByAppendingString:@".00"];
			}
			
			outputString = stringWithCommas;
		  }
	}
	
	if(percentage)
	{
		outputString = [outputString stringByAppendingString:@"%"];
	}
	
	if(showSign && ! [outputString hasPrefix:@"-"])
	{
		outputString = [@"+" stringByAppendingString:outputString];
	}
	 
	
	return outputString;
}

@end

@implementation NSString (Currency)

static NSNumberFormatter *s_currencyFormatter = nil;

+ (NSString *)localizedDecimalSeparator
{
    if(nil == s_currencyFormatter)
	{
		s_currencyFormatter = [[NSNumberFormatter alloc] init];
        [s_currencyFormatter setFormatterBehavior:NSNumberFormatterBehavior10_4];
	}
    
	return [s_currencyFormatter decimalSeparator];
}

- (double)localizedDoubleValue
{
	if(nil == s_currencyFormatter)
	{
		s_currencyFormatter = [[NSNumberFormatter alloc] init];
        [s_currencyFormatter setFormatterBehavior:NSNumberFormatterBehavior10_4];
        [s_currencyFormatter setNumberStyle:NSNumberFormatterDecimalStyle];
    }
    
    NSCharacterSet *nonNumberSet = [[NSCharacterSet characterSetWithCharactersInString:@"-0123456789.,"] invertedSet];
    NSString *selfAsNumber = [self stringByTrimmingCharactersInSet:nonNumberSet];
    NSNumber *numberFromString = [s_currencyFormatter numberFromString:selfAsNumber];
    return [numberFromString doubleValue];
}

@end

@implementation NSString (StringDrawingAdditions)

- (CGRect)drawAtBaselinePoint:(CGPoint)baselinePoint 
                     withFont:(UIFont *)font 
                     maxWidth:(CGFloat)maxWidth 
                  minFontSize:(CGFloat)minFontSize 
               actualFontSize:(CGFloat *)actualFontSizeRef
                    alignment:(UITextAlignment)textAlignment
{
    CGFloat actualFontSize;
    // Use this method to get actualFontSize and width
    CGSize size = [self sizeWithFont:font minFontSize:minFontSize actualFontSize:&actualFontSize forWidth:maxWidth lineBreakMode:UILineBreakModeTailTruncation];
    UIFont *actualFont = [font fontWithSize:actualFontSize];
    if(actualFontSizeRef)
    { 
        *actualFontSizeRef = actualFontSize;
    }
    
    // The previous method assumes multiple lines. We only want one.
    size.height = [self sizeWithFont:actualFont].height; 
    
    CGFloat newX = 0;
    switch (textAlignment) {
        case UITextAlignmentRight:
            newX = baselinePoint.x + maxWidth - size.width;
            break;
        case UITextAlignmentLeft:
            newX = baselinePoint.x;
            break;
		default:
			break;
    }

    CGFloat newY = baselinePoint.y - size.height - [actualFont descender]; // descender is negative    
    
    CGRect rect = CGRectMake(newX, newY, size.width, size.height);
    
    [self drawInRect:rect withFont:[font fontWithSize:actualFontSize] lineBreakMode:UILineBreakModeTailTruncation];
    return rect;
}


// Draws a single line using lineBreakModeTailTruncation
- (CGRect)drawAtBaselinePoint:(CGPoint)baselinePoint withFont:(UIFont *)font maxWidth:(CGFloat)maxWidth minFontSize:(CGFloat)minFontSize
{
    return [self drawAtBaselinePoint:baselinePoint withFont:font maxWidth:maxWidth minFontSize:minFontSize actualFontSize:nil alignment:UITextAlignmentLeft];
}

- (CGSize)drawInRect:(CGRect)rect withFont:(UIFont *)font minimumFontSize:(CGFloat)minFontSize lineBreakMode:(UILineBreakMode)lineBreakMode alignment:(UITextAlignment)textAlignment
{
    CGFloat actualFontSize;
    [self sizeWithFont:font minFontSize:minFontSize actualFontSize:&actualFontSize forWidth:rect.size.width lineBreakMode:lineBreakMode];
    return [self drawInRect:rect withFont:[font fontWithSize:actualFontSize] lineBreakMode:lineBreakMode alignment:textAlignment];
}

- (NSString *) removeLeadingWhiteSpace//:(NSString*) string
{
	NSString* inputString = [NSString stringWithString:self];
	
	// try to remove any white space at the beggining of the text
	NSCharacterSet* noWhiteSpaceSet = [[NSCharacterSet whitespaceCharacterSet] invertedSet];
	NSRange range = [inputString rangeOfCharacterFromSet:noWhiteSpaceSet];
	
	if(range.location != NSNotFound)
	{
		return [inputString substringFromIndex:range.location];
	}
	
	return inputString;

}

- (NSString *) removeTrailingingWhiteSpace
{
	NSString* inputString = [NSString stringWithString:self];
	
	// try to remove any white space at the beggining of the text
	NSCharacterSet* noWhiteSpaceSet = [[NSCharacterSet whitespaceCharacterSet] invertedSet];
	NSRange range = [inputString rangeOfCharacterFromSet:noWhiteSpaceSet options:NSBackwardsSearch];
	
	if(range.location != NSNotFound)
	{
		return [inputString substringToIndex:range.location+1];
	}
	
	return inputString;
	
}

- (NSArray *)componentsFittingToSize:(CGSize)size withFont:(UIFont *)font
{
	NSString *inputString = self;
	NSMutableArray *returnArray = [NSMutableArray array];
	
	while([inputString length] > 0)
	{
		// try to remove any white space at the beggining of the text
		inputString = [inputString removeLeadingWhiteSpace];
		
		if([inputString length] == 0)
		{
			break;
		}
		
		NSString *prefix = [inputString prefixFittingInSize:size withFont:font];
		[returnArray addObject:[prefix stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceCharacterSet]]];
		if([prefix length] == [inputString length]) //we consumed the last of the input string so get out of here
		{
			break;
		}
		inputString = [inputString substringFromIndex:[prefix length]];
	}
	
	return returnArray;
}

- (NSArray *)componentsFittingToSizes:(NSArray *)sizes withFont:(UIFont *)font
{
	NSMutableArray *components = [NSMutableArray array];
	NSString *inputString = self;
	for(NSValue *size in sizes)
	{
		CGSize sizeValue = [size CGSizeValue];
		NSString *prefix = [inputString prefixFittingInSize:sizeValue withFont:font];
		[components addObject:[prefix stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceCharacterSet]]];
		inputString = [inputString substringFromIndex:[prefix length]];
		
		if([inputString length] == 0)
		{
			break;
		}
		
		// try to remove any white space at the beggining of the text before we calculate the prefixFittingInSize:withFont:
		inputString = [inputString removeLeadingWhiteSpace];
	}
	
	if([inputString length] > 0)
	{
		CGSize lastSize = [[sizes objectAtIndex:[sizes count] - 1] CGSizeValue];
		[components addObjectsFromArray:[inputString componentsFittingToSize:lastSize withFont:font]];
	}
	
	return components;
	
}

- (NSString *)prefixFittingInSize:(CGSize)size withFont:(UIFont *)font
{
	//do a binary divide and conquer search to quickly find the prefix
	//substring that will fit in size
	
	//first check to see if we can fit the whole string in the size
	CGSize checkSize = [self sizeWithFont:font constrainedToSize:CGSizeMake(size.width, INT_MAX)  
						   lineBreakMode:UILineBreakModeWordWrap];
	
	if(checkSize.height <= size.height)
	{
		return self;
	}
	
	BOOL prefixFound = NO;
	NSUInteger leftBoundIndex = 0;
	NSUInteger rightBoundIndex = [self length];
	NSUInteger checkIndex = [self length] / 2;
	NSString *prefixToCheck = nil;
	while(prefixFound == NO)
	{
		prefixToCheck = [self substringToIndex:checkIndex];
		checkSize = [prefixToCheck sizeWithFont:font constrainedToSize:CGSizeMake(size.width, INT_MAX) 
						 lineBreakMode:UILineBreakModeWordWrap];
		
//		NSLog(@"left bound: %i right bound: %i check: %i size %f x %f",
//			  leftBoundIndex, rightBoundIndex, checkIndex,checkSize.width, checkSize.height);
		
		if(checkSize.height <= size.height)
		{
			//If the right boundary is the next index
			//then just return the prefix
			if(rightBoundIndex == checkIndex + 1 || rightBoundIndex == checkIndex)
			{
				prefixFound = YES;			
			}
			else {
				//set the left boundary as the current index
				leftBoundIndex = checkIndex;
			}

		}
		else {
			//If the left boundary is the next index
			//then just return the prefix to that left boundary
			if(leftBoundIndex == checkIndex - 1 || leftBoundIndex == checkIndex)
			{
				prefixFound = YES;
				prefixToCheck = [self substringToIndex:leftBoundIndex];
			}
			else {
				//set the right boundary as the current index
				rightBoundIndex = checkIndex;
			}
		}
		
		checkIndex = (rightBoundIndex + leftBoundIndex) / 2;
	}
	
	//If the next character is a space after the prefix
	//then return the prefix
	NSString *characterAfter = [self substringWithRange:NSMakeRange([prefixToCheck length], 1)];
	if([self length] > [prefixToCheck length] && 
	   ([characterAfter isEqualToString:@" "] || [characterAfter isEqualToString:@"\n"]))
	{
		//we are fine, and don't need to do anything
	}
	else 
	{
		//backtrack to the most recent space or endline from the end
		NSRange lastEmpty = [prefixToCheck rangeOfCharacterFromSet:[NSCharacterSet whitespaceAndNewlineCharacterSet]
														   options:NSBackwardsSearch];
		if(lastEmpty.location != NSNotFound)
		{
			prefixToCheck = [prefixToCheck substringToIndex:lastEmpty.location];
		}
	}
	
	return prefixToCheck;
}

@end

//Get an MD5 of the string
@implementation NSString(MD5)

+ (NSString *)md5:(NSString *)stringToHash
{
	const char *cStr = [stringToHash UTF8String];
	unsigned char result[16];
	CC_MD5( cStr, strlen(cStr), result );
	return [NSString stringWithFormat:
			@"%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X%02X",
			result[0], result[1], result[2], result[3], 
			result[4], result[5], result[6], result[7],
			result[8], result[9], result[10], result[11],
			result[12], result[13], result[14], result[15]
			];
}

@end

@implementation NSString (NilSafety)

- (NSString *)nilSafeStringByAppendingString:(NSString *)string
{
    if(nil == string)
    {
        string = @"";
    }
    
    return [self stringByAppendingString:string];
}

@end

//Get an MD5 of the string
@implementation NSString(TripleDES)

+ (NSString*)TripleDES:(NSString*)plainText isEncrypt:(BOOL)isEncrypt key:(NSString*)key {

    const void *vplainText;
    size_t plainTextBufferSize;
    CCOperation encryptOrDecrypt = (isEncrypt? kCCEncrypt : kCCDecrypt);
    
    if (encryptOrDecrypt == kCCDecrypt)
    {
        NSData *EncryptData = [NSData dataWithBase64EncodedString:plainText];
        //NSData *EncryptData = [GTMBase64 decodeData:[plainText dataUsingEncoding:NSUTF8StringEncoding]];
        plainTextBufferSize = [EncryptData length];
        vplainText = [EncryptData bytes];
    }
    else
    {
        NSData* data = [plainText dataUsingEncoding:NSUTF8StringEncoding];
        plainTextBufferSize = [data length];
        vplainText = (const void *)[data bytes];
    }
    
    CCCryptorStatus ccStatus;
    uint8_t *bufferPtr = NULL;
    size_t bufferPtrSize = 0;
    size_t movedBytes = 0;
    // uint8_t ivkCCBlockSize3DES;
    
    bufferPtrSize = (plainTextBufferSize + kCCBlockSize3DES) & ~(kCCBlockSize3DES - 1);
    bufferPtr = malloc( bufferPtrSize * sizeof(uint8_t));
    memset((void *)bufferPtr, 0x0, bufferPtrSize);
    // memset((void *) iv, 0x0, (size_t) sizeof(iv));
    
    //    NSString *key = @"123456789012345678901234";
    NSString *initVec = @"00000000"; // @"init Vec";
    const void *vkey = (const void *) [key UTF8String];
    const void *vinitVec = (const void *) [initVec UTF8String];
    
    ccStatus = CCCrypt(encryptOrDecrypt,
                       kCCAlgorithm3DES,
                       kCCOptionPKCS7Padding|kCCOptionECBMode,//clude: we need to use this CCOption, otherwise the result will be incorrect
                       vkey, //"123456789012345678901234", //key
                       kCCKeySize3DES,
                       vinitVec, //vinitVec, //"init Vec", //iv,
                       vplainText, //"Your Name", //plainText,
                       plainTextBufferSize,
                       (void *)bufferPtr,
                       bufferPtrSize,
                       &movedBytes);
    //if (ccStatus == kCCSuccess) NSLog(@"SUCCESS");
    /*else if (ccStatus == kCC ParamError) return @"PARAM ERROR";
     else if (ccStatus == kCCBufferTooSmall) return @"BUFFER TOO SMALL";
     else if (ccStatus == kCCMemoryFailure) return @"MEMORY FAILURE";
     else if (ccStatus == kCCAlignmentError) return @"ALIGNMENT";
     else if (ccStatus == kCCDecodeError) return @"DECODE ERROR";
     else if (ccStatus == kCCUnimplemented) return @"UNIMPLEMENTED"; */
    
    NSString *result;
    
    if (encryptOrDecrypt == kCCDecrypt)
    {
        result = [[[NSString alloc] initWithData:[NSData dataWithBytes:(const void *)bufferPtr 
                                                                length:(NSUInteger)movedBytes] 
                                        encoding:NSUTF8StringEncoding] 
                  autorelease];
    }
    else
    {
        NSData *myData = [NSData dataWithBytes:(const void *)bufferPtr length:(NSUInteger)movedBytes];
        //result = [GTMBase64 stringByEncodingData:myData];
        result = [myData base64Encoding];
    }
    
    return result;
    
} 
@end


