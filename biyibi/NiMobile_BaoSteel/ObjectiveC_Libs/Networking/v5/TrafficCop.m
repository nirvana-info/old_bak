//
//  TrafficCop.m
//
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import "TrafficCop.h" 
#import <objc/runtime.h>

#pragma mark TrafficCopCallerWrapper

//This is an internal structure that provides
//a wrapper around a traffic cop caller
//so that we can have a reference to the caller]
//in internal data structures without retaining it
@interface TrafficCopCallerWrapper : NSObject
{
	id<TrafficCopCaller> caller;
}

@property (assign) id<TrafficCopCaller> caller;

@end

@implementation TrafficCopCallerWrapper

@synthesize caller;

@end

#pragma mark TrafficCop

@interface TrafficCop (Private)

- (int)connectionCountForNetwork;
- (void)updateNetworkStatus;
- (NSUInteger)operationIndexForKey:(NSString *)key;
- (void)addOperationsToActiveQueue;
- (NSString *)keyForCaller:(id<TrafficCopCaller>)caller;
- (void)processReturnForConnection:(TrafficCopConnection *)connection withReturnData:(NSData *)data;
- (void)turnActivityIndicatorOffIfNecessary;


@end

#define kDuplicateRequestRejectionTime 2

@implementation TrafficCop

static BOOL firstTimeThrough = YES;

@synthesize verboseLoggingEnabled = _verboseLoggingEnabled;
@synthesize requestLoggingEnabled = _requestLoggingEnabled;
@synthesize successLoggingEnabled = _successLoggingEnabled;
@synthesize failureLoggingEnabled = _failureLoggingEnabled;
@synthesize allRequests = _requestStrings;
@synthesize successfulRequests = _successfulRequestStrings;
@synthesize failedRequests = _failureRequestStrings;
@synthesize trustedHosts = _trustedHosts;

static TrafficCop *singleton;

+ (TrafficCop *)sharedInstance
{
	@synchronized(self)
	{
		if(!singleton)
		{
			singleton = [[TrafficCop alloc] init];
		}
	}
	
	return singleton;
}

- (id)init
{
	if(self = [super init])
	{
		//construct the network operations queue
		_activeConnectionQueue = [[NSMutableArray alloc] init];
		
		//update the network status and register for status change notifications
		[[NSNotificationCenter defaultCenter] addObserver: self selector: @selector(reachabilityChanged:) 
													 name: kReachabilityChangedNotification object: nil];
		_physicalReachability = [[Reachability reachabilityForInternetConnection] retain];
		[_physicalReachability startNotifier];
		
		
		_keysToCallers = [[NSMutableDictionary alloc] init];
		
		_keysToRequestTimes = [[NSMutableDictionary alloc] init];
		
		_pendingConnectionQueue = [[NSMutableArray alloc] init];
		
		_networkSpeed = 0;
		
		_verboseLoggingEnabled = NO;
		_successLoggingEnabled = NO;
		_failureLoggingEnabled = YES;
		_requestLoggingEnabled = NO;
		
		_requestStrings = [[NSMutableArray alloc] init];
		_successfulRequestStrings = [[NSMutableArray alloc] init];
		_failureRequestStrings = [[NSMutableArray alloc] init];
		
		_isPaused = NO;
		
		_retryQueue = [[NSMutableArray alloc] init];
		
		_trustedHosts = nil;
        
        #ifdef DEBUG
        // Use only for personal DEBUG purposes:
        // In order to allow trusted hosts, uncomment the following method implementations:
//        _trustedHosts = [[NSArray alloc] initWithObjects:
//                         [NSURL URLWithString:kBaseURLDevelopment], 
//                         [NSURL URLWithString:kAPIBasePathAcc],nil];
        #endif
		
		[self updateNetworkStatus];
	}
	
	return self;
}

- (TrafficCopInternetAccess)currentNetworkConnection
{
	return _networkConnectionStatus;
}

- (int)connectionCountForNetwork
{
	int numberOfSimulaneousNetworkConnections;
	switch (_networkConnectionStatus) {
		case NoInternet:
			numberOfSimulaneousNetworkConnections = 0;
			break;
		case PacketNetwork:
			numberOfSimulaneousNetworkConnections = 2;
			break;
		case WiFi:
			numberOfSimulaneousNetworkConnections = 2;
			break;
		default:
			DLog(@"TrafficCop (connectionCountForNetwork): Received an unknown network status");
			numberOfSimulaneousNetworkConnections = 0;
			break;
	}
	return numberOfSimulaneousNetworkConnections;
}

+ (id)alloc
{
	@synchronized(self)
	{
		NSAssert(singleton == nil, @"Attempted to allocate a second instance of a TrafficCop.");
		singleton = [super alloc];
	}
	
	return singleton;
}

- (void)pause
{
	_isPaused = YES;
	if([UIApplication sharedApplication].networkActivityIndicatorVisible)
	{
		[UIApplication sharedApplication].networkActivityIndicatorVisible = NO;
	}
}

- (void)resume
{
	_isPaused = NO;
	[self addOperationsToActiveQueue];
}

- (double)networkSpeed
{
	return _networkSpeed;
}

- (double)downloadPercentageForKey:(NSString *)key
{
	for(TrafficCopConnection *operation in _activeConnectionQueue)
	{
		if([key isEqualToString:[operation trafficCopKey]])
		{
			return [operation percentDownloaded];
		}
	}
	
	return 0;
}

- (NSDictionary *)currentActiveDownloadPercentages
{
	NSMutableDictionary *returnDict = [NSMutableDictionary dictionaryWithCapacity:[_activeConnectionQueue count]];
	for(TrafficCopConnection *operation in _activeConnectionQueue)
	{
		[returnDict setObject:[NSNumber numberWithDouble:[operation percentDownloaded]]
						  forKey:[operation trafficCopKey]];
	}
	return returnDict;
}

- (NSArray *)pendingKeys
{
	NSMutableArray *keys = [NSMutableArray arrayWithCapacity:[_pendingConnectionQueue count]];
	for(TrafficCopConnection *operation in _pendingConnectionQueue)
	{
		[keys addObject:[operation trafficCopKey]];
	}
	
	return keys;
}

- (NSArray *)activeKeys
{
	NSMutableArray *returnArray = [NSMutableArray arrayWithCapacity:[_activeConnectionQueue count]];
	for(TrafficCopConnection *operation in _activeConnectionQueue)
	{
		[returnArray addObject:[operation trafficCopKey]];
	}
	return returnArray;
}

- (TrafficCopInternetAccess)physicalConnectionStatus
{
	TrafficCopInternetAccess access = NoInternet;
	switch ([_physicalReachability currentReachabilityStatus]) {
		case NotReachable:
			access = NoInternet;
			break;
		case ReachableViaWWAN:
			access = PacketNetwork;
			break;
		case ReachableViaWiFi:
			access = WiFi;
			break;
		default:
			access = NoInternet;
			break;
	}
	
	return access;
}

- (TrafficCopInternetAccess)hostReachability
{
	TrafficCopInternetAccess access = NoInternet;
	switch ([_hostReachability currentReachabilityStatus]) {
		case NotReachable:
			access = NoInternet;
			break;
		case ReachableViaWWAN:
			access = PacketNetwork;
			break;
		case ReachableViaWiFi:
			access = WiFi;
			break;
		default:
			access = NoInternet;
			break;
	}
	
	return access;
}

-(void)performRequest:(NSMutableURLRequest *)request withPriority:(TrafficCopPriority)priority 
   returnDataToObject:(id<TrafficCopCaller>)object withKey:(NSString *)key
{
	if(! key)
		return;
	
	NSOperationQueuePriority operationPriority = NSOperationQueuePriorityNormal;
	switch (priority) {
		case TrafficCopVeryLowPriority:
			operationPriority = NSOperationQueuePriorityVeryLow;
			break;
		case TrafficCopLowPriority:
			operationPriority = NSOperationQueuePriorityLow;
			break;
		case TrafficCopNormalPriority:
			operationPriority = NSOperationQueuePriorityNormal;
			break;
		case TrafficCopHighPriority:
			operationPriority = NSOperationQueuePriorityHigh;
			break;
		case TrafficCopVeryHighPriority:
			operationPriority = NSOperationQueuePriorityVeryHigh;
			break;
		default:
			operationPriority = NSOperationQueuePriorityNormal;
			break;
	}
	
	//if we still don't have a network connection even after waking up the hardware
	//show that we don't have an internet connection
	if([self currentNetworkConnection] == NoInternet && ! firstTimeThrough)
	{
		[object dataReturnedFromTrafficCop:nil withKey:key response:nil];
		return;
	}
	
	//check to see if it's in the active queue.  If it is just disregard the request
	if([[self activeKeys] containsObject:key])
	{
		return;
	}
	
	//Set some optimization headers.
	[request setValue:@"gzip" forHTTPHeaderField:@"Accept-Encoding"];
	
	//see if they have already requested data for this key
	//if so schedule the operation to be escalated in priority,
	//otherwise just schedule the operation as normal
	NSUInteger operationIndex = [self operationIndexForKey:key];
	if(NSNotFound != operationIndex)
	{	
		if(_verboseLoggingEnabled) {
			DLog(@"upgrading priority of key: %@",key);
		}
		
		//remove the operation from the queue and schedule it to the top with a very high priority
		TrafficCopConnection *operation = [[_pendingConnectionQueue objectAtIndex:operationIndex] retain];
		[operation setQueuePriority:NSOperationQueuePriorityVeryHigh];
		[_pendingConnectionQueue removeObjectAtIndex:operationIndex];
		[_pendingConnectionQueue insertObject:operation atIndex:0];
		[operation release];
		
	}
	else
	{
		
		NSString *returnObjectKey = [self keyForCaller:object];

		if(! [_keysToCallers objectForKey:returnObjectKey])
		{
			TrafficCopCallerWrapper *callerWrapper = [[TrafficCopCallerWrapper alloc] init];
			[callerWrapper setCaller:object];
			[_keysToCallers setObject:callerWrapper forKey:returnObjectKey];
			[callerWrapper release];
		}

		//Create the operation object
		TrafficCopConnection *operation = [[TrafficCopConnection alloc] initWithRequest:request delegate:self 
																		 trafficCopKey:key returnObjectKey:returnObjectKey];
		
		[operation setTrustedHosts:_trustedHosts];
		
		[operation setQueuePriority:operationPriority];
		
		//if the queue is empty just add it in
		if([_pendingConnectionQueue count] == 0)
		{
			[_pendingConnectionQueue addObject:operation];
		}
		else
		{
			//insert the operation into the pending queue in the right place
			for(NSUInteger operationIdx = 0; operationIdx < [_pendingConnectionQueue count] ; ++operationIdx)
			{
				if([[_pendingConnectionQueue objectAtIndex:operationIdx] queuePriority] < [operation queuePriority])
				{
					[_pendingConnectionQueue insertObject:operation atIndex:0];
					break;
				}
				
				//If we are at the end of the queue and still haven't been able to insert 
				//then just add the operation at the end
				if(operationIdx == [_pendingConnectionQueue count] - 1)
				{
					[_pendingConnectionQueue addObject:operation];
					break;
				}
			}
		}
		
		[operation release];
	}
	
	[self addOperationsToActiveQueue];
}


- (void)performRequest:(NSMutableURLRequest *)request withHighPriority:(BOOL)highPriority 
						returnDataToObject:(id<TrafficCopCaller>)object withKey:(NSString *)key
{
	if(highPriority)
	{
		[self performRequest:request withPriority:TrafficCopVeryHighPriority returnDataToObject:object withKey:key];
	}
	else {
		[self performRequest:request withPriority:TrafficCopNormalPriority returnDataToObject:object withKey:key];
	}

	
}

- (void)removeCaller:(id<TrafficCopCaller>)caller
{
	NSString *callerKey = [self keyForCaller:caller];
	TrafficCopCallerWrapper *mappedCaller = [_keysToCallers objectForKey:callerKey];
	if(mappedCaller && [mappedCaller caller] == caller)
	{
		//go through the active queue and see if there are any active
		//connections that we can remove/cancel
		for(NSUInteger operationIdx = 0; operationIdx < [_activeConnectionQueue count]; ++operationIdx)
		{
			TrafficCopConnection *operation = [_activeConnectionQueue objectAtIndex:operationIdx];
			if([[operation returnObjectKey] isEqualToString:callerKey])
			{
				if([self verboseLoggingEnabled])
				{
					DLog(@"canceling active connection with key: %@",[operation trafficCopKey]);
				}
				[_activeConnectionQueue removeObjectAtIndex:operationIdx];
				//back of the index since we've removed an object from the queue
				--operationIdx;
			}
		}
		
		[_keysToCallers removeObjectForKey:callerKey];
	}
	
	[self addOperationsToActiveQueue];
}

- (TrafficCopCallerWrapper *)callerForKey:(NSString *)key
{
	return [_keysToCallers objectForKey:key];
}

- (void)cancelKey:(NSString *)key
{
	for(NSUInteger operationIdx = 0; operationIdx < [_activeConnectionQueue count]; ++operationIdx)
	{
		TrafficCopConnection *operation = [_activeConnectionQueue objectAtIndex:operationIdx];
		if([key isEqualToString:[operation trafficCopKey]])
		{
			[_activeConnectionQueue removeObjectAtIndex:operationIdx];
			break;
		}
	}
	
	for(NSUInteger operationIdx = 0; operationIdx < [_pendingConnectionQueue count]; ++operationIdx)
	{
		TrafficCopConnection *operation = [_pendingConnectionQueue objectAtIndex:operationIdx];
		if([key isEqualToString:[operation trafficCopKey]])
		{
			[_pendingConnectionQueue removeObjectAtIndex:operationIdx];
			break;
		}
	}
	
	[self addOperationsToActiveQueue];
}

//deprioritize current operations in the queue in favor of
//newer requests
- (void)switchingContexts
{
	for(TrafficCopConnection *operation in _pendingConnectionQueue)
	{
		if([operation queuePriority] > NSOperationQueuePriorityVeryLow)
		{
			if(_verboseLoggingEnabled) {
				DLog(@"deprioritizing key: %@",[operation trafficCopKey]);
			}
				
			[operation setQueuePriority:([operation queuePriority] - 4)];
		}
	}
}

- (void)setHostName:(NSString *)hostName
{
	if(! _hostReachability)
	{
		_hostReachability = [[Reachability reachabilityWithHostName:hostName] retain];
		[_hostReachability startNotifier];
	}
}

- (void)registerForNetworkStatusNotificationWithReceiver:(id<TrafficCopCaller>)receiver
{
	if([(NSObject *)receiver respondsToSelector:@selector(networkStatusChanged:)])
	{
		[[NSNotificationCenter defaultCenter] addObserver:receiver selector:@selector(networkStatusChanged:) 
													 name:kTrafficCopNetworkStatusNotification object:nil];
	}
}

//Called by Reachability whenever status changes.
- (void) reachabilityChanged: (NSNotification* )note
{
	[self updateNetworkStatus];
}

-(void)dealloc
{
	[[NSNotificationCenter defaultCenter] removeObserver:self];
	[_activeConnectionQueue release];
	[_pendingConnectionQueue release];
	
	[_trustedHosts release];
	_trustedHosts = nil;
	
	[super dealloc];
}

#pragma mark TrafficCopConnectionDelegate methods

- (void)connection:(TrafficCopConnection *)connection returnedWithData:(NSData *)data
{
	
	if(nil == data && [self failureLoggingEnabled] && _networkConnectionStatus != NoInternet)
	{
		[_failureRequestStrings addObject:[NSString stringWithFormat:@"(%@) %@ (%f seconds) (Empty data returned)", [NSDate date],
											   [[[connection connectionRequest] URL] absoluteString],[connection totalRequestTime]]];
	}
	else if([self successLoggingEnabled])
	{
		[_successfulRequestStrings addObject:[NSString stringWithFormat:@"(%@) %@ (%f seconds)", [NSDate date],
											  [[[connection connectionRequest] URL] absoluteString],[connection totalRequestTime]]];
	}
	
	if([data length] > 0)
	{
		if(_networkSpeed > 0)
		{
			_networkSpeed = (_networkSpeed + [connection connectionSpeed]) / 2; //weight towards most recent connection results
		}
		else
		{
			_networkSpeed = [connection connectionSpeed];
		}
	}

	if([self verboseLoggingEnabled])
	{
		DLog(@"Traffic Cop: ended request for %@ with success", [connection trafficCopKey]);
	}
	
	[self processReturnForConnection:connection withReturnData:data];
}

- (void)connection:(TrafficCopConnection *)connection returnedWithError:(NSError *)error
{
	
	if([self failureLoggingEnabled] && _networkConnectionStatus != NoInternet)
	{
			[_failureRequestStrings addObject:[NSString stringWithFormat:@"(%@) %@ (%@) (%f)",
											   [NSDate date],
												[[[connection connectionRequest] URL] absoluteString],
											   [error localizedDescription],[connection totalRequestTime]]];
	}
					   
	if([self verboseLoggingEnabled])
	{
		DLog(@"Traffic Cop: ended request for %@ with error %@", [connection trafficCopKey],error);
	}
	[self processReturnForConnection:connection withReturnData:nil];
}

@end

@implementation TrafficCop (Private)

- (int)connectionCountForNetwork
{
	int numberOfSimulaneousNetworkConnections;
	switch (_networkConnectionStatus) {
		case NoInternet:
			numberOfSimulaneousNetworkConnections = 0;
			break;
		case PacketNetwork:
			numberOfSimulaneousNetworkConnections = 2;
			break;
		case WiFi:
			numberOfSimulaneousNetworkConnections = 2;
			break;
		default:
			DLog(@"TrafficCop (connectionCountForNetwork): Received an unknown network status");
			numberOfSimulaneousNetworkConnections = 0;
			break;
	}
	return numberOfSimulaneousNetworkConnections;
}

- (void)updateNetworkStatus
{
	NetworkStatus networkConnectionStatus = [_physicalReachability currentReachabilityStatus];
	NetworkStatus remoteHostStatus = ReachableViaWiFi;
	if(nil != _hostReachability)
	{
		remoteHostStatus = [_hostReachability currentReachabilityStatus];
	}
	
	if(remoteHostStatus != NotReachable)
	{
		switch (networkConnectionStatus) {
			case NotReachable:
				_networkConnectionStatus = NoInternet;
				break;
			case ReachableViaWWAN:
				_networkConnectionStatus = PacketNetwork;
				break;
			case ReachableViaWiFi:
				_networkConnectionStatus = WiFi;
				break;
			default:
				DLog(@"TrafficCop (updateNetworkStatus): Received an unknown network status");
				_networkConnectionStatus = NoInternet;
				break;
		}
	}
	else 
	{
		_networkConnectionStatus = NoInternet;
	}
	
	if(firstTimeThrough && _networkConnectionStatus == NoInternet)
	{
		_maxConcurrentConnections = 1;  //initialize to one connection thread to initialize network hardware
	}
	else {
		_maxConcurrentConnections = [self connectionCountForNetwork];
	}
	
	
	
	//add any pending operations to the active network queue
	[self addOperationsToActiveQueue];
	
	// Post a notification to notify the client that the network reachability changed.
    [[NSNotificationCenter defaultCenter] postNotificationName:kTrafficCopNetworkStatusNotification object:nil];
	
}

- (NSUInteger)operationIndexForKey:(NSString *)key
{
	
	for(NSUInteger operationIdx = 0; operationIdx < [_pendingConnectionQueue count]; ++ operationIdx)
	{
		if([[[_pendingConnectionQueue objectAtIndex:operationIdx] trafficCopKey] isEqualToString:key])
		{
			return operationIdx;
		}
	}
	
	return NSNotFound;
}

- (void)addOperationsToActiveQueue
{
	//if we are paused then don't add anything onto the active queue
	if(_isPaused)
	{
		return;
	}
	
	if([_pendingConnectionQueue count] == 0)
	{
		[self turnActivityIndicatorOffIfNecessary];
		return;
	}
	
	//add any operations from the pending queue to the active queue if we can
	NSUInteger numOperationsToAdd = 0;
	
	if(firstTimeThrough)
	{
		numOperationsToAdd = 1;  //force a network connection on the first time through
	}
	else {
		numOperationsToAdd = _maxConcurrentConnections - [_activeConnectionQueue count];
	}
	
	
	for(NSUInteger operationAddIdx = 0 ; operationAddIdx < numOperationsToAdd; ++operationAddIdx)
	{
		if([_pendingConnectionQueue count] == 0)
			break;
		
		
		TrafficCopConnection *operation = [[_pendingConnectionQueue objectAtIndex:0] retain];
		[_pendingConnectionQueue removeObjectAtIndex:0];
		
		//make sure this caller is still present before starting the network operation
		if([_keysToCallers objectForKey:[operation returnObjectKey]])
		{
			if(! [UIApplication sharedApplication].networkActivityIndicatorVisible)
			{
				[UIApplication sharedApplication].networkActivityIndicatorVisible = YES;
			}
			[_activeConnectionQueue addObject:operation];
			[operation start];
			if(_verboseLoggingEnabled) {
				DLog(@"Traffic Cop: starting %@ (%@)", [operation trafficCopKey] , [[[operation connectionRequest] URL] absoluteString]);
			}
			if([self requestLoggingEnabled])
			{
				[_requestStrings addObject:[[[operation connectionRequest] URL] absoluteString]];
			}
		}
		else 
		{
			//The caller is no longer present so just drop the operation
			//and keep our add index the same after increment and decrement
			//the request count we had updated
			
			if([self verboseLoggingEnabled])
			{
				DLog(@"removing stale request for key: %@ & caller: %@",[operation trafficCopKey], [operation returnObjectKey]);
			}
			
			--operationAddIdx;
		}
		
		[operation release];
	}
	
	[self turnActivityIndicatorOffIfNecessary];
	
	//reset the max current connection cout if it's our first time through as we only want
	//one internet connection to bootstrap and not have others fail right away if we have
	//no connection
	if(firstTimeThrough)
	{
		firstTimeThrough = NO;
		_maxConcurrentConnections = [self connectionCountForNetwork];
	}
	
}

- (NSString *)keyForCaller:(id<TrafficCopCaller>)caller
{
	return [NSString stringWithFormat:@"%i%@",[(NSObject *)caller hash],
			[NSString stringWithUTF8String:class_getName([(NSObject *)caller class])]];
}

- (void)processReturnForConnection:(TrafficCopConnection *)connection withReturnData:(NSData *)data
{
	
	[_activeConnectionQueue removeObject:connection];
	
	//add more onto the queue
	[self addOperationsToActiveQueue];
	
	//Update our caller with the results if the caller still exists
	TrafficCopCallerWrapper *callerWrapper = [self callerForKey:[connection returnObjectKey]];
	if(callerWrapper && [callerWrapper caller])
	{
		[[callerWrapper caller] dataReturnedFromTrafficCop:data withKey:[connection trafficCopKey] response:[connection connectionResponse]];
	}
}

- (void)turnActivityIndicatorOffIfNecessary
{
	if([UIApplication sharedApplication].networkActivityIndicatorVisible 
	   && [_activeConnectionQueue count] == 0 && [_pendingConnectionQueue count] == 0)
	{
		[UIApplication sharedApplication].networkActivityIndicatorVisible = NO;
	}
}


@end

