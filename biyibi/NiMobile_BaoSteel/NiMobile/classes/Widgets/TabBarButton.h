//
//  TabBarButton.h
//  Zecco
//
//  Created by sirish.jetti on 9/13/10.
//  Copyright 2010 Wall Street On Demand. All rights reserved.
//

#import <Foundation/Foundation.h>


@interface TabBarButton : UIButton {
	NSString *_name;
	bool _isSelected;
}
@property (nonatomic,retain) NSString *name;
-(id) initWithFrame:(CGRect)frame andName:(NSString *)name;
-(void) setImageNormal;
-(void) setImageSelected;
-(void) buttonSelected;
@end
