//
//  NiUrlRequest.h
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface NiUrlRequest : NSMutableURLRequest {
	
}

+ (NiUrlRequest *)NiURLRequestWithURL:(NSURL *)url arguments:(NSMutableDictionary *)arguments;

+ (NiUrlRequest *)NiURLRequestWithURL:(NSURL *)url;

@end
