//
//  NSDataCategories.h
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import <Foundation/Foundation.h>

typedef enum 
	{
		kAES256ECBMode = 0,
		kAES256CBCMode = 1
	} AES256ChainingMode;

//NSData category to implement AES256 encryption
@interface NSData (AES256)

- (NSData *)AES256EncryptWithKey:(NSString *)key;
- (NSData *)AES256DecryptWithKey:(NSString *)key;
- (NSData *)AES256EncryptWithKey:(NSString *)key andChainingMode:(AES256ChainingMode)chainingMode;
- (NSData *)AES256DecryptWithKey:(NSString *)key andChainingMode:(AES256ChainingMode)chainingMode;

@end

//NSData category to implement Base64 encoding/decoding
@interface NSData (Base64)
+ (NSData *) dataWithBase64EncodedString:(NSString *) string;
- (id) initWithBase64EncodedString:(NSString *) string;

- (NSString *) base64Encoding;
- (NSString *) base64EncodingWithLineLength:(unsigned int) lineLength;

@end


