//
//  TrafficCopConnection.m
//
//  Copyright 2010 Wall Street On Demand, Inc.. All rights reserved.
//

#import "TrafficCopConnection.h"


@implementation TrafficCopConnection

@synthesize trafficCopKey = _trafficCopKey;
@synthesize returnObjectKey = _returnObjectKey;
@synthesize connectionRequest = _connectionRequest;
@synthesize connectionResponse = _connectionResponse;
@synthesize percentDownloaded = _percentDownloaded;
@synthesize queuePriority = _queuePriority;
@synthesize trustedHosts = _trustedHosts;

-(id)initWithRequest:(NSURLRequest *)request 
			delegate:(id<TrafficCopConnectionDelegate>)del 
	   trafficCopKey:(NSString *)trafficCopKey
	 returnObjectKey:(NSString*)returnObjectKey
{
	if(self = [self init])
	{
		delegate = del;
		_trafficCopKey = [trafficCopKey retain];
		_returnObjectKey = [returnObjectKey retain];
		_connectionRequest = [request retain];
		_returnData = [[NSMutableData alloc] init];
		_percentDownloaded = 0;
		_connectionSpeed = 0;
		
		_trustedHosts = nil;
	}
	
	return self;
}

- (void)start
{
	if(! _connection)
	{
		//only initialize a connection when we want to start it
		_requestStartTime = CFAbsoluteTimeGetCurrent();
		_connection = [[NSURLConnection alloc] initWithRequest:_connectionRequest delegate:self];
	}
}

- (void)cancel
{
	[_connection cancel];
}

- (double)connectionSpeed
{
	return _connectionSpeed;
}

- (double)totalRequestTime
{
	return _totalRequestTime;
}

-(void)dealloc
{
	[_connectionRequest release];
	_connectionRequest = nil;
	[_connectionResponse release];
	_connectionResponse = nil;
	[_connection cancel];
	[_connection release];
	_connection = nil;
	[_trafficCopKey release];
	_trafficCopKey = nil;
	[_returnObjectKey release];
	_returnObjectKey = nil;
	[_returnData release];
	_returnData = nil;
	[_trustedHosts release];
	_trustedHosts = nil;
		
	[super dealloc];
}

#pragma mark NSURLConnectionDelegate methods

- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response
{	
	if(_connectionResponse != response)
	{
		[_connectionResponse release];
		_connectionResponse = [response retain];
	}
	
    [_returnData setLength:0];
	_expectedContentLength = [response expectedContentLength];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data

{	
    [_returnData appendData:data];
	
	if(_expectedContentLength > 0)
	{
		_percentDownloaded = [_returnData length] / _expectedContentLength;
	}
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error

{
	_totalRequestTime = CFAbsoluteTimeGetCurrent() - _requestStartTime;
	[delegate connection:self returnedWithError:error];
}

#ifdef DEBUG
//*=====================================================================================*
//*-------------------------------------------------------------------------------------*
//* NOTE: The following two methods can introduce security vulnerabilities such as man-in-
//* the-middle style attacks. Please leave commented in the repository. Uncomment only for 
//* personal testing.
//*-------------------------------------------------------------------------------------*
//*=====================================================================================*
- (BOOL)connection:(NSURLConnection *)connection canAuthenticateAgainstProtectionSpace:(NSURLProtectionSpace *)protectionSpace 
{
	// If _trustedHosts is not defined, do not allow server-trust connections.
	if (nil == _trustedHosts) 
	{
		return FALSE;
	}
	// Otherwise, allow server-trust connections.
	else 
	{
		return [protectionSpace.authenticationMethod isEqualToString:NSURLAuthenticationMethodServerTrust];
	}
}

- (void)connection:(NSURLConnection *)connection didReceiveAuthenticationChallenge:(NSURLAuthenticationChallenge *)challenge 
{
	// Allow a server-trust credential to be used for connections to trusted hosts.
	if (nil != _trustedHosts) 
	{
		if ([challenge.protectionSpace.authenticationMethod isEqualToString:NSURLAuthenticationMethodServerTrust])
		{
			for (NSURL* trustedHost in _trustedHosts)
			{
				if ([trustedHost.host isEqualToString:challenge.protectionSpace.host]) 
				{
					[challenge.sender useCredential:[NSURLCredential credentialForTrust:challenge.protectionSpace.serverTrust] forAuthenticationChallenge:challenge];
				}
			}
		}
	}
	
	[challenge.sender continueWithoutCredentialForAuthenticationChallenge:challenge];
}
#endif

- (void)connectionDidFinishLoading:(NSURLConnection *)connection

{
	_totalRequestTime = CFAbsoluteTimeGetCurrent() - _requestStartTime;
	
	if([_returnData length] > 0)
	{
		_connectionSpeed =  [_returnData length] / _totalRequestTime;
	}
	
	[delegate connection:self returnedWithData:_returnData];
}

@end
