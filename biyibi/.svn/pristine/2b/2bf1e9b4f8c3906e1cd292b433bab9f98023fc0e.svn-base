//
//  TrafficCop.h
//
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//
// The TrafficCop class is responsible for marshalling and controlling ALL
// HTTP network traffic in the application.  A client can get a pointer to the 
// global shared traffic cop through the classes sharedInstance method. From there
// a client would call the performRequest:withHighPriority:returnDataToObject:withKey: method
// to schedule a network job.  The data is then returned to the passed in object
// via a dataReturnedFromTrafficCop:withKey: method defined in the TrafficCopCaller
// protocol.  See details on these method for more detail on how to use them.

#import <Foundation/Foundation.h>
#import "Reachability.h"
#import "TrafficCopConnection.h"

@protocol TrafficCopCaller;

typedef enum {
	NoInternet = 0,
	PacketNetwork = 1,
	WiFi = 2
} TrafficCopInternetAccess;

#define kTrafficCopNetworkStatusNotification @"TrafficCopNetworkStatusNotification"

@interface TrafficCop : NSObject <TrafficCopConnectionDelegate> {
	
	TrafficCopInternetAccess _networkConnectionStatus;  //The current internet connection status
	NSMutableArray *_activeConnectionQueue;
	
	NSMutableArray *_pendingConnectionQueue;
	
	NSUInteger _maxConcurrentConnections;
	
	//maintain a set of the active callers indexed by their unique keys
	NSMutableDictionary *_keysToCallers;
	
	//store the keys requested that are under our duplicate request threshold
	NSMutableDictionary *_keysToRequestTimes;
	
	BOOL _verboseLoggingEnabled;
	
	BOOL _isPaused;
	
	NSMutableArray *_retryQueue;
	
	//reachability routes for host access and physical network connection
	Reachability *_hostReachability;
	Reachability *_physicalReachability;
	
	double _networkSpeed;
	
	
	//logging
	BOOL _requestLoggingEnabled;
	BOOL _successLoggingEnabled;
	BOOL _failureLoggingEnabled;
	
	NSMutableArray *_requestStrings;
	NSMutableArray *_successfulRequestStrings;
	NSMutableArray *_failureRequestStrings;
	
	NSArray* _trustedHosts;
}

@property (assign) BOOL requestLoggingEnabled;
@property (assign) BOOL successLoggingEnabled;
@property (assign) BOOL failureLoggingEnabled;
@property (nonatomic, readonly) NSArray *allRequests;
@property (nonatomic, readonly) NSArray *successfulRequests;
@property (nonatomic, readonly) NSArray *failedRequests;
@property (nonatomic, retain) NSArray* trustedHosts;

+(TrafficCop *)sharedInstance;

/// Execute the URL request on a background thread and then returns the resulting data
/// from the request to the passed in object (conforming to the TrafficCopCaller protocol).  The key is used to uniquely
/// identify the request, so that the object can match the request to the return data.
-(void)performRequest:(NSMutableURLRequest *)request withHighPriority:(BOOL)highPriority 
											returnDataToObject:(id<TrafficCopCaller>)object withKey:(NSString *)key;


-(void)performRequest:(NSMutableURLRequest *)request withPriority:(TrafficCopPriority)priority 
   returnDataToObject:(id<TrafficCopCaller>)object withKey:(NSString *)key;

// IMPORTANT: Similar to notification centers the TrafficCop requires a caller to tell it when it will be dealloced.
// It is suggested that you call this method in your callers dealloc method
-(void)removeCaller:(id<TrafficCopCaller>)caller;

-(void)cancelKey:(NSString *)key;

//A call to switchingContexts should be used to notify the traffic cop that you are switching to a new section
//or tab.  This call will prioritize new requests over requests that are currently in the queue.
-(void)switchingContexts;

-(void)registerForNetworkStatusNotificationWithReceiver:(id<TrafficCopCaller>)receiver;

-(TrafficCopInternetAccess)currentNetworkConnection;
-(void)setHostName:(NSString *)hostName;

//property to turn verbose logging on and off (defaults to off)
@property (assign) BOOL verboseLoggingEnabled;

//allow to pause sending out network requests, and then resume
-(void)pause;
-(void)resume;

//returns the weighted average network speed in bytes/second
- (double)networkSpeed;

//get the download percentage for a given key. The percentage 
//is given as a double between (and including) 0 and 1
- (double)downloadPercentageForKey:(NSString *)key;

//returns a dictionary keyed by the section and the download percentages
- (NSDictionary *)currentActiveDownloadPercentages;

- (NSArray *)pendingKeys;
- (NSArray *)activeKeys;

- (TrafficCopInternetAccess)physicalConnectionStatus;
- (TrafficCopInternetAccess)hostReachability;

//activity logging




@end

/// All objects that want to receive data back from the TrafficCop must conform
/// to the TrafficCopCaller protocol.
@protocol TrafficCopCaller
	/// Returns the data returned from the network request 
	/// to the object passed into the performRequest:returnDataToObject:withKey:response: .
	/// The key matches the key passed into the initial request.
	-(void)dataReturnedFromTrafficCop:(NSData *)data withKey:(NSString *)key response:(NSURLResponse *)response;
@optional
	-(void)networkStatusChanged:(NSNotification *)notification;
@end


