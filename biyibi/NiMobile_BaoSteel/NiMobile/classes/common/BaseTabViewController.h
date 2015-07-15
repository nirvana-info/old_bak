//
//  BaseTabViewController.h
//  Zecco
//
//  Created by bryce.hammond on 9/27/10.
//  Copyright 2010 Wall Street On Demand, Inc. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "BaseViewController.h"

@interface BaseTabViewController : BaseViewController {

}

-(id) initWithTabBar;

//Subclasses should override these methods if they support
//streaming of data.  The base class will handle turning the
//streaming on/off at the appropriate times
- (BOOL)supportsStreaming;
- (void)startStreaming;
- (void)stopStreaming;

@end
