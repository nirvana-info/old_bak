//
//  TrafficCopDebugConsole.h
//
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MessageUI/MessageUI.h>

@interface TrafficCopDebugConsole : UIViewController <MFMailComposeViewControllerDelegate> {
	BOOL _consoleViewEnabled;
	NSTimeInterval _lastShakeTimeInterval;
	
	//the log views
	UITextView *_requestLogView;
	UITextView *_errorLogView;
	UITextView *_successLogView;
	
	//collected log string to display in the log views
	NSMutableString *_requestLog;
	NSMutableString *_errorLog;
	NSMutableString *_successLog;
	
	//keep track of where we are in the log arrays
	//so we only add what is new
	NSUInteger _requestIdx;
	NSUInteger _errorIdx;
	NSUInteger _successIdx;
	
	//update the display on a timer so we don't cause too much load
	NSTimer *_updateTimer;
	
	UIButton *_emailButton;

	//network info labels
	UILabel *_networkSpeedLabel;
	
	UILabel *_reachabilityLabel;

}

+ (void)initialize;

@end
