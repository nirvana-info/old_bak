//
//  WSODLoadingView.m
//
//  Copyright 2009 Wall Street On Demand. All rights reserved.
//

#define kActivityIndicatorSize			24
//#define kDefaultLoadingMessage			NSLocalizedString(@"L_Loading",0)
#define kDefaultLoadingMessage			@"Loading"
#define kDefaultPanelCornerRadius		10
#define kDefaultPanelHorizPadding		10
#define kDefaultPanelVertPadding		5
#define kDefaultPanelHorizOffset        -37
#define kDefaultSpacing					5
#define kMinLabelWidth					140
#define kMaxLabelWidth					180

#define kDefaultBgColor             [UIColor blackColor]
#define kDefaultPanelBgColor        [UIColor whiteColor]
#define kDefaultPanelBorderColor        [UIColor clearColor]
#define kDefaultPanelTextColor      [UIColor blackColor]
#define kDefaultTopBorderColor      [UIColor grayColor]

#define kDefaultPanelFont           [UIFont fontWithName:@"Helvetica" size:12]


#import "WSODLoadingView.h"


@implementation WSODLoadingView
@synthesize panelCornerRadius = _panelCornerRadius, panelMinWidth = _panelMinWidth, panelHorizOffset = _panelHorizOffset,
activityIndicatorShouldAppear = _activityIndicatorShouldAppear, showTopBorder = _showTopBorder,
panelFont = _panelFont, panelBgColor = _panelBgColor, panelBorderColor = _panelBorderColor, panelTextColor = _panelTextColor,
topBorderColor = _topBorderColor;

- (void)setActivityPanelBgColor:(UIColor *)color {
    [self setPanelBgColor:color];
    [self setNeedsDisplay];
}

- (id)initWithFrame:(CGRect)frame message:(NSString *)message activityIndicator:(BOOL)yesNo {
	if (self = [super initWithFrame:frame]) {
		_activityIndicatorShouldAppear = yesNo;
		[self setBackgroundColor:kDefaultBgColor];
		_showTopBorder = NO;
        [self setTopBorderColor:kDefaultTopBorderColor];
        
		// Set panel properties to default
		_panelCornerRadius = kDefaultPanelCornerRadius;
        [self setPanelBgColor:kDefaultPanelBgColor];
        [self setPanelBorderColor:kDefaultPanelBorderColor];
        [self setPanelTextColor:kDefaultPanelTextColor];
        [self setPanelFont:kDefaultPanelFont];
        [self setPanelHorizOffset:kDefaultPanelHorizOffset];
		_message = [message retain];
    }
    return self;
}

- (id)initWithFrame:(CGRect)frame {
    return [self initWithFrame:frame message:kDefaultLoadingMessage activityIndicator:TRUE];
}


- (void)drawRect:(CGRect)rect {
    // Drawing code
	CGContextRef context = UIGraphicsGetCurrentContext();
	CGFloat radius = _panelCornerRadius;
	
	CGContextBeginPath(context);
	
	CGContextSetStrokeColorWithColor(context, [[self panelBorderColor] CGColor]);
	CGContextSetFillColorWithColor(context, [[self panelBgColor] CGColor]);
	CGContextMoveToPoint(context, CGRectGetMinX(_messagePanelFrame) + radius, CGRectGetMinY(_messagePanelFrame));
    CGContextAddArc(context, CGRectGetMaxX(_messagePanelFrame) - radius, CGRectGetMinY(_messagePanelFrame) + radius, radius, 3 * M_PI / 2, 0, 0);
    CGContextAddArc(context, CGRectGetMaxX(_messagePanelFrame) - radius, CGRectGetMaxY(_messagePanelFrame) - radius, radius, 0, M_PI / 2, 0);
    CGContextAddArc(context, CGRectGetMinX(_messagePanelFrame) + radius, CGRectGetMaxY(_messagePanelFrame) - radius, radius, M_PI / 2, M_PI, 0);
    CGContextAddArc(context, CGRectGetMinX(_messagePanelFrame) + radius, CGRectGetMinY(_messagePanelFrame) + radius, radius, M_PI, 3 * M_PI / 2, 0);	
    CGContextClosePath(context);
    CGContextDrawPath(context, kCGPathFillStroke);
	
	if(_showTopBorder) {
		CGContextBeginPath(context);
		CGContextSetStrokeColorWithColor(context, [[self topBorderColor] CGColor]);
		CGContextSetShadow(context, CGSizeMake(0,-1), 7);
		CGContextMoveToPoint(context, 0, 0);
		CGContextAddLineToPoint(context, rect.size.width, 0);
		CGContextStrokePath(context);
	}
}

- (void)layoutSubviews {
	if(_messagePanel) {
		[_messagePanel removeFromSuperview];
		[_messagePanel release];
	}
	
	// Figure out how much space the loading message will take up
	CGSize messageLabelSize = CGSizeZero;
	if(nil != _message)
	{
		messageLabelSize = [_message sizeWithFont:[self panelFont] 
								constrainedToSize:CGSizeMake(self.frame.size.width / 2, self.frame.size.height) 
									lineBreakMode:UILineBreakModeWordWrap];		
	}	
	if(messageLabelSize.width < kMinLabelWidth) {
		messageLabelSize.width = kMinLabelWidth;
	} else if(messageLabelSize.width > kMaxLabelWidth) {
		// Added to handle landscape mode
		messageLabelSize.width = kMaxLabelWidth;
	}
    
    // clude, below two var are added just for fixng an iOS5 archive issue, when we select "Optimization Level" 
    // to "Fastst, smallest" for archiving package, messageLabelSize's value will be changed  even if we do nothing on it,
    // here we just use these two temp var to store the value
    CGFloat msgLabelHeight = messageLabelSize.height;
    CGFloat msgLabelWidth = messageLabelSize.width;
	
	CGSize messagePanelSize;
	
	if(_activityIndicatorShouldAppear) {
		// Based on message label size, determine the size of the panel that will hold the message, indicator, and bg
		messagePanelSize = CGSizeMake((messageLabelSize.width) + (kDefaultPanelHorizPadding*2),
									  messageLabelSize.height + kActivityIndicatorSize + kDefaultSpacing + (kDefaultPanelVertPadding*2));
	} else {
		messagePanelSize = CGSizeMake((messageLabelSize.width) + (kDefaultPanelHorizPadding*2),
									  messageLabelSize.height + (kDefaultPanelVertPadding*2));
	}
	
	// Center messagePanel
    
	CGPoint messagePanelOrigin = CGPointMake((self.frame.size.width-messagePanelSize.width)/2, ((self.frame.size.height-messagePanelSize.height)/2)+_panelHorizOffset);
	
	// Create messagePanel using messagePanelOrigin and messagePanelSize
	_messagePanelFrame = CGRectMake(messagePanelOrigin.x, messagePanelOrigin.y, messagePanelSize.width, messagePanelSize.height);
	_messagePanel = [[UIView alloc] initWithFrame:_messagePanelFrame]; 
	
	
	
	if(_activityIndicatorShouldAppear) {
		// Create a loading activity indicator and add to messagePanel
		UIActivityIndicatorView *indicator = [[UIActivityIndicatorView alloc] initWithActivityIndicatorStyle:UIActivityIndicatorViewStyleWhite];
		[indicator setFrame:CGRectMake(((_messagePanelFrame.size.width - kActivityIndicatorSize) / 2), kDefaultPanelVertPadding, 
									   kActivityIndicatorSize, kActivityIndicatorSize)];
		
		[_messagePanel addSubview:indicator];
		[indicator startAnimating];
		[indicator release];
	}
	
	// Create messageLabel and add to messagePanel
	CGPoint messageLabelOrigin;
	if(_activityIndicatorShouldAppear) {
		messageLabelOrigin = CGPointMake(kDefaultPanelHorizPadding, kDefaultPanelVertPadding+kActivityIndicatorSize+kDefaultSpacing);
	} else {
		messageLabelOrigin = CGPointMake(kDefaultPanelHorizPadding, kDefaultPanelVertPadding);
	}
    
    if(_messageLabel) {
        [_messageLabel removeFromSuperview];
        [_messageLabel release];
    }
	
	//_messageLabel = [[UILabel alloc] initWithFrame:CGRectMake(messageLabelOrigin.x, messageLabelOrigin.y, messageLabelSize.width, messageLabelSize.height)];
    _messageLabel = [[UILabel alloc] initWithFrame:CGRectMake(messageLabelOrigin.x, messageLabelOrigin.y, msgLabelWidth, msgLabelHeight)];
	[_messageLabel setText:_message];
	[_messageLabel setTextAlignment:UITextAlignmentCenter];
	[_messageLabel setFont:[self panelFont]];
	[_messageLabel setTextColor:[self panelTextColor]];
	[_messageLabel setNumberOfLines:0];
	[_messageLabel setBackgroundColor:[UIColor clearColor]];
	[_messagePanel addSubview:_messageLabel];
	
	[self addSubview:_messagePanel];
	// (re)draw the message panel rectangle and the top border
	[self setNeedsDisplay];
}


- (void)dealloc {
    [_panelTextColor release];
    [_panelBgColor release];
    [_panelBorderColor release];
    [_panelFont release];
    [_topBorderColor release];
	[_message release];
	[_messagePanel release];
	[_messageLabel release];
    [super dealloc];
}

- (void)setMessage:(NSString *)newMessage {
    if(_message != newMessage) {
        [_message release];
        _message = [newMessage retain];
    }
	[_messageLabel setText:newMessage];
    [self setNeedsLayout];
}

@end
