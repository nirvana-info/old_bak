//
//  MemberCell.m
//  NiMobile
//
//  Created by zhu clude on 4/29/13.
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "ProductCell.h"
#import "ProductInfo.h"

@implementation ProductCell

- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        
        UILabel *Yuan = [[UILabel alloc] initWithFrame:CGRectMake(5, 10, 12, 22)];
        Yuan.textColor = [NiConstants colorWithKey:@"606060"];
        Yuan.text = @"￥";
        Yuan.backgroundColor = [UIColor clearColor];
        Yuan.font = [UIFont systemFontOfSize:14];
        
               
        _price = [[UILabel alloc] initWithFrame:CGRectMake(20, 10, 70, 22)];
        _price.textColor = [NiConstants colorWithKey:@"FF5502"];
        _price.backgroundColor = [UIColor clearColor];
        _price.font = [UIFont systemFontOfSize:14];
        
        _code = [[UILabel alloc] initWithFrame:CGRectMake(90, 10, 40, 22)];
        _code.textColor = [NiConstants colorWithKey:@"606060"];
        _code.backgroundColor = [UIColor clearColor];
        _code.font = [UIFont systemFontOfSize:14];
        
        _size = [[UILabel alloc] initWithFrame:CGRectMake(140, 10, 70, 22)];
        _size.textColor = [NiConstants colorWithKey:@"606060"];
        _size.backgroundColor = [UIColor clearColor];
        _size.font = [UIFont systemFontOfSize:14];
        
        _company = [[UILabel alloc] initWithFrame:CGRectMake(210, 10, 60, 22)];
        _company.textColor = [NiConstants colorWithKey:@"606060"];
        _company.backgroundColor = [UIColor clearColor];
        _company.font = [UIFont systemFontOfSize:14];
        
        _stock = [[UILabel alloc] initWithFrame:CGRectMake(280,10, 10, 22)];
        _stock.textColor = [NiConstants colorWithKey:@"377A1D"];
        _stock.backgroundColor = [UIColor clearColor];
        _stock.font = [UIFont systemFontOfSize:16];
        
        UILabel *Jian = [[UILabel alloc] initWithFrame:CGRectMake(290, 10, 15, 22)];
        Jian.textColor = [NiConstants colorWithKey:@"606060"];
        Jian.text = @"件";
        Jian.backgroundColor = [UIColor clearColor];
        Jian.font = [UIFont systemFontOfSize:14];
        
        [self.contentView addSubview:Yuan];
        [self.contentView addSubview:_price];
        [self.contentView addSubview:_code];
        [self.contentView addSubview:_size];
        [self.contentView addSubview:_company];
        [self.contentView addSubview:_stock];
        [self.contentView addSubview:Jian];
        
        [Yuan release];
        [Jian release];
    }
    return self;
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

    // Configure the view for the selected state
}

-(void)setProduct:(ProductInfo *)product{
    _price.text = [NSString stringWithFormat:@"%.2f",product.price];
    _code.text = product.code;
    _size.text = product.size;
    _company.text = product.company;
    _stock.text = [NSString stringWithFormat:@"%i",product.stock];

}

- (void)dealloc
{
    [_price release];
    [_code release];
    [_size release];
    [_company release];
    [_stock release];
	[super dealloc];
}

@end
