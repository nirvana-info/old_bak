//
//  CustomizeCheckbox.h
//  ZeccoMobile
//
//  Created by clude on 5/6/11.
//  Copyright 2011 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>


@interface CustomizeCheckbox : UIButton {
	BOOL _isChecked;
}
@property (nonatomic,assign) BOOL isChecked;

-(IBAction) checkBoxClicked;

@end
