//
//  WSODLoadingView.h
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface WSODLoadingView : UIView {
	CGRect _messagePanelFrame;
    UIColor *_panelBgColor;
    UIColor *_panelBorderColor;
    UIColor *_panelTextColor;
    UIFont *_panelFont;
	CGFloat _panelCornerRadius;
	CGFloat _panelMinWidth;
	BOOL _activityIndicatorShouldAppear;
	UILabel *_messageLabel;
	UIView *_messagePanel;
	BOOL _showTopBorder;
	NSString *_message;
    UIColor *_topBorderColor;
    CGFloat _panelHorizOffset; // from center
}

@property (nonatomic, retain) UIColor *panelBgColor;
@property (nonatomic, retain) UIColor *panelBorderColor;
@property (nonatomic, retain) UIColor *panelTextColor;
@property (nonatomic, retain) UIFont *panelFont;
@property (nonatomic, assign) CGFloat panelCornerRadius;
@property (nonatomic, assign) CGFloat panelMinWidth;
@property (nonatomic, assign) BOOL activityIndicatorShouldAppear;
@property (nonatomic, assign) BOOL showTopBorder;
@property (nonatomic, retain) UIColor *topBorderColor;
@property (nonatomic, assign) CGFloat panelHorizOffset;

- (id)initWithFrame:(CGRect)frame message:(NSString *)message activityIndicator:(BOOL)yesNo;
- (void)setMessage:(NSString *)newMessage;
- (void)setActivityPanelBgColor:(UIColor *)color;
@end
