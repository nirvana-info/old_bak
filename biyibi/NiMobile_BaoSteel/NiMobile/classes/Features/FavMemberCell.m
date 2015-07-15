//
//  MemberCell.m
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "FavMemberCell.h"
#import "MemberInfo.h"

@implementation FavMemberCell

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        _photo = [[UIImageView alloc] initWithFrame:CGRectMake(0, 0, 44, 44)];
        
        _mname = [[UILabel alloc] initWithFrame:CGRectMake(48, 0, 80, 22)];
        _mname.textColor = [NiConstants colorWithKey:@"182A39"];
        _mname.backgroundColor = [UIColor clearColor];
        _mname.font = [UIFont systemFontOfSize:14];
        
        _gender = [[UIImageView alloc] initWithFrame:CGRectMake(128, 0, 15, 22)];
        
        _distance = [[UILabel alloc] initWithFrame:CGRectMake(48, 22, 100, 22)];
        _distance.textColor = [NiConstants colorWithKey:@"B9A385"];
        _distance.backgroundColor = [UIColor clearColor];
        _distance.font = [UIFont systemFontOfSize:12];
        
        _comments = [[UILabel alloc] initWithFrame:CGRectMake(160, 0, 160, 44)];
        _comments.textColor = [NiConstants colorWithKey:@"B9A385"];
        _comments.backgroundColor = [UIColor clearColor];
        _comments.font = [UIFont systemFontOfSize:10];
        
        [self.contentView addSubview:_photo];
        [self.contentView addSubview:_mname];
        [self.contentView addSubview:_gender];
        [self.contentView addSubview:_distance];
        [self.contentView addSubview:_comments];
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

    // Configure the view for the selected state
}

-(void)setMember:(MemberInfo *)member{
    [_photo setImage:[UIImage imageNamed:@"person-icon.png"]];
    
    _mname.text = member.mname;
    
    _distance.text = [NSString stringWithFormat:@"%.0f米以内", member.distance];

    _comments.text = member.comments;
}

- (void)dealloc
{
	[_photo release];
	[_mname release];
    [_gender release];
    [_distance release];
	[_comments release];
	[super dealloc];
}

@end
