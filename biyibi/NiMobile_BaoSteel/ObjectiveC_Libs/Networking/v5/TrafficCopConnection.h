//
//  TrafficCopConnection.h
//
//  Copyright 2009 Wall Street On Demand, Inc.. All rights reserved.
//

#import <Foundation/Foundation.h>

typedef enum {
	TrafficCopVeryHighPriority = 0,
	TrafficCopHighPriority = 1,
	TrafficCopNormalPriority = 2,
	TrafficCopLowPriority = 3,
	TrafficCopVeryLowPriority = 4
} TrafficCopPriority;

@protocol TrafficCopConnectionDelegate;

@interface TrafficCopConnection : NSObject {
	NSURLConnection *_connection;
	NSURLRequest *_connectionRequest;
	NSURLResponse *_connectionResponse;
	NSMutableData *_returnData;
	id<TrafficCopConnectionDelegate> delegate;
	NSString *_trafficCopKey;
	NSString *_returnObjectKey;
	
	TrafficCopPriority _queuePriority;
	
	double _percentDownloaded;
	double _expectedContentLength;
	
	double _connectionSpeed; //in bytes/second
	NSTimeInterval _requestStartTime;
	NSTimeInterval _totalRequestTime;
	
	// Use only for personal DEBUG purposes:
	// In order to allow trusted hosts, uncomment the following method implementations:
	//	connection:canAuthenticateAgainstProtectionSpace:
	//	connection:didReceiveAuthenticationChallenge:
	NSArray* _trustedHosts;
}

@property (nonatomic, retain) NSString *trafficCopKey;
@property (nonatomic, retain) NSString *returnObjectKey;
@property (nonatomic, retain) NSURLRequest *connectionRequest;
@property (readonly) NSURLResponse *connectionResponse;
@property (readonly) double percentDownloaded;
@property (assign) TrafficCopPriority queuePriority;
@property (nonatomic, retain) NSArray* trustedHosts;

-(id)initWithRequest:(NSURLRequest *)request 
			delegate:(id<TrafficCopConnectionDelegate>)del 
			trafficCopKey:(NSString *)trafficCopKey
			returnObjectKey:(NSString*)returnObjectKey;

- (void)start;
- (void)cancel;
- (double)connectionSpeed; //in bytes/second
- (double)totalRequestTime; //in seconds

@end

@protocol TrafficCopConnectionDelegate

- (void)connection:(TrafficCopConnection *)connection returnedWithData:(NSData *)data;
- (void)connection:(TrafficCopConnection *)connection returnedWithError:(NSError *)error;

@end