//
//  MemberDetailViewController.m
//  NiMobile
//
//  Copyright (c) 2013 Ni. All rights reserved.
//

#import "DetailInfoViewController.h"
#import "ProductInfo.h"

#define detailTextColor              @"182A39"
#define nameFontSize                 16
#define lbFontSize                   14

#define  paddingTop                  10
#define  photoWidth                  100
#define  photoHeight                 70
#define  nameWidth                   280
#define  nameHeight                  25
#define  paddingLeft                 20
#define  lbWidth                     65
#define  lbHeight                    20
#define  lbValueWidth                230
#define  lbValueHalfWidth           lbValueWidth / 2 - 30

#define  commentValueWidth           250
#define  commentValueHeight          80

#define  columWidth                  180

@interface DetailInfoViewController ()

@end

@implementation DetailInfoViewController


- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        self.title = @"资源详情";
		self.navigationItem.title = @"资源详情";
    }
    return self;
}

-(void)loadView{
    [super loadView];
    
    _photo = [[UIImageView alloc] initWithFrame:CGRectMake(paddingLeft, paddingTop, photoWidth, photoHeight)];
    
    _name = [[UILabel alloc] initWithFrame:CGRectMake(paddingLeft, photoHeight + 10, nameWidth, nameHeight)];
    _name.textColor = [NiConstants colorWithKey:detailTextColor];
    _name.backgroundColor = [UIColor clearColor];
    _name.font = [UIFont systemFontOfSize:nameFontSize];
    
    _weight = [[UILabel alloc] initWithFrame:CGRectMake(paddingLeft, [self getHeight:_name], lbWidth, lbHeight)];
    _weight.textColor = [NiConstants colorWithKey:detailTextColor];
    _weight.text = @"重  量 :";
    _weight.backgroundColor = [UIColor clearColor];
    _weight.font = [UIFont systemFontOfSize:lbFontSize];
    
    _weightValue = [[UILabel alloc] initWithFrame:CGRectMake([self getWidth:_weight], [self getHeight:_name], lbValueWidth, lbHeight)];
    _weightValue.textColor = [NiConstants colorWithKey:detailTextColor];
    _weightValue.backgroundColor = [UIColor clearColor];
    _weightValue.font = [UIFont systemFontOfSize:lbFontSize];
    
    _price = [[UILabel alloc] initWithFrame:CGRectMake(paddingLeft, [self getHeight:_weight], lbWidth, lbHeight)];
    _price.textColor = [NiConstants colorWithKey:detailTextColor];
    _price.text = @"现  价 :";
    _price.backgroundColor = [UIColor clearColor];
    _price.font = [UIFont systemFontOfSize:lbFontSize];
    
    _priceValue = [[UILabel alloc] initWithFrame:CGRectMake([self getWidth:_price], [self getHeight:_weight], lbValueWidth, lbHeight)];
    _priceValue.textColor = [NiConstants colorWithKey:detailTextColor];
    _priceValue.backgroundColor = [UIColor clearColor];
    _priceValue.font = [UIFont systemFontOfSize:lbFontSize];
    
    _qualityinfo = [[UILabel alloc] initWithFrame:CGRectMake(paddingLeft, [self getHeight:_price], lbWidth, lbHeight)];
    _qualityinfo.textColor = [NiConstants colorWithKey:detailTextColor];
    _qualityinfo.text = @"质量信息 :";
    _qualityinfo.backgroundColor = [UIColor clearColor];
    _qualityinfo.font = [UIFont systemFontOfSize:lbFontSize];
    
    _qualityinfoValue = [[UILabel alloc] initWithFrame:CGRectMake([self getWidth:_qualityinfo], [self getHeight:_price], lbValueWidth, lbHeight)];
    _qualityinfoValue.textColor = [NiConstants colorWithKey:detailTextColor];
    _qualityinfoValue.backgroundColor = [UIColor clearColor];
    _qualityinfoValue.font = [UIFont systemFontOfSize:lbFontSize];
    
    _service = [[UILabel alloc] initWithFrame:CGRectMake(paddingLeft, [self getHeight:_qualityinfo], lbWidth, lbHeight)];
    _service.textColor = [NiConstants colorWithKey:detailTextColor];
    _service.text = @"服  务 :";
    _service.backgroundColor = [UIColor clearColor];
    _service.font = [UIFont systemFontOfSize:lbFontSize];
    
    _serviceValue = [[UILabel alloc] initWithFrame:CGRectMake([self getWidth:_service], [self getHeight:_qualityinfo], lbValueWidth, lbHeight)];
    _serviceValue.textColor = [NiConstants colorWithKey:detailTextColor];
    _serviceValue.backgroundColor = [UIColor clearColor];
    _serviceValue.font = [UIFont systemFontOfSize:lbFontSize];
    
    _pinName = [[UILabel alloc] initWithFrame:CGRectMake(paddingLeft, [self getHeight:_service], lbWidth, lbHeight)];
    _pinName.textColor = [NiConstants colorWithKey:detailTextColor];
    _pinName.text = @"品  名 :";
    _pinName.backgroundColor = [UIColor clearColor];
    _pinName.font = [UIFont systemFontOfSize:lbFontSize];
    
    _pinNameValue = [[UILabel alloc] initWithFrame:CGRectMake([self getWidth:_pinName], [self getHeight:_service], lbValueHalfWidth, lbHeight)];
    _pinNameValue.textColor = [NiConstants colorWithKey:detailTextColor];
    _pinNameValue.backgroundColor = [UIColor clearColor];
   // _pinNameValue.backgroundColor = [UIColor redColor];
    _pinNameValue.font = [UIFont systemFontOfSize:lbFontSize];
    
    _code = [[UILabel alloc] initWithFrame:CGRectMake(columWidth, [self getHeight:_service], lbWidth, lbHeight)];
    _code.textColor = [NiConstants colorWithKey:detailTextColor];
    _code.text = @"牌  号 :";
    _code.backgroundColor = [UIColor clearColor];
    _code.font = [UIFont systemFontOfSize:lbFontSize];
    
    _codeValue = [[UILabel alloc] initWithFrame:CGRectMake([self getWidth:_code], [self getHeight:_service], lbValueHalfWidth, lbHeight)];
    _codeValue.textColor = [NiConstants colorWithKey:detailTextColor];
    _codeValue.backgroundColor = [UIColor clearColor];
    _codeValue.font = [UIFont systemFontOfSize:lbFontSize];
    
    
    _origin = [[UILabel alloc] initWithFrame:CGRectMake(paddingLeft, [self getHeight:_pinName], lbWidth, lbHeight)];
    _origin.textColor = [NiConstants colorWithKey:detailTextColor];
    _origin.text = @"产  地 :";
    _origin.backgroundColor = [UIColor clearColor];
    _origin.font = [UIFont systemFontOfSize:lbFontSize];
    
    _originValue = [[UILabel alloc] initWithFrame:CGRectMake([self getWidth:_origin], [self getHeight:_pinName], lbValueHalfWidth, lbHeight)];
    _originValue.textColor = [NiConstants colorWithKey:detailTextColor];
    _originValue.backgroundColor = [UIColor clearColor];
    _originValue.font = [UIFont systemFontOfSize:lbFontSize];
    
    _place = [[UILabel alloc] initWithFrame:CGRectMake(columWidth, [self getHeight:_pinName], lbWidth, lbHeight)];
    _place.textColor = [NiConstants colorWithKey:detailTextColor];
    _place.text = @"存放 地 :";
    _place.backgroundColor = [UIColor clearColor];
    _place.font = [UIFont systemFontOfSize:lbFontSize];
    
    _placeValue = [[UILabel alloc] initWithFrame:CGRectMake([self getWidth:_place], [self getHeight:_pinName], lbValueHalfWidth, lbHeight)];
    _placeValue.textColor = [NiConstants colorWithKey:detailTextColor];
    _placeValue.backgroundColor = [UIColor clearColor];
    _placeValue.font = [UIFont systemFontOfSize:lbFontSize];
    
    
    _size = [[UILabel alloc] initWithFrame:CGRectMake(paddingLeft, [self getHeight:_origin], lbWidth, lbHeight)];
    _size.textColor = [NiConstants colorWithKey:detailTextColor];
    _size.text = @"规  格 :";
    _size.backgroundColor = [UIColor clearColor];
    _size.font = [UIFont systemFontOfSize:lbFontSize];
    
    _sizeValue = [[UILabel alloc] initWithFrame:CGRectMake([self getWidth:_size], [self getHeight:_origin], lbValueHalfWidth, lbHeight)];
    _sizeValue.textColor = [NiConstants colorWithKey:detailTextColor];
    _sizeValue.backgroundColor = [UIColor clearColor];
    _sizeValue.font = [UIFont systemFontOfSize:lbFontSize];
    
    _sizeinfo = [[UILabel alloc] initWithFrame:CGRectMake(columWidth, [self getHeight:_origin], lbWidth, lbHeight)];
    _sizeinfo.textColor = [NiConstants colorWithKey:detailTextColor];
    _sizeinfo.text = @"规格详情 :";
    _sizeinfo.backgroundColor = [UIColor clearColor];
    _sizeinfo.font = [UIFont systemFontOfSize:lbFontSize];
    
    _sizeinfoValue = [[UILabel alloc] initWithFrame:CGRectMake([self getWidth:_sizeinfo], [self getHeight:_origin], lbValueHalfWidth, lbHeight)];
    _sizeinfoValue.textColor = [NiConstants colorWithKey:detailTextColor];
    _sizeinfoValue.backgroundColor = [UIColor clearColor];
    _sizeinfoValue.font = [UIFont systemFontOfSize:lbFontSize];
    
    _comment = [[UILabel alloc] initWithFrame:CGRectMake(paddingLeft,[self getHeight:_size], lbWidth, lbHeight)];
    _comment.textColor = [NiConstants colorWithKey:detailTextColor];
    _comment.text = @"说  明 :";
    _comment.backgroundColor = [UIColor clearColor];
    _comment.font = [UIFont systemFontOfSize:lbFontSize];
    
    _commentValue = [[UILabel alloc] initWithFrame:CGRectMake([self getWidth:_comment], [self getHeight:_size], commentValueWidth,commentValueHeight)];
    _commentValue.numberOfLines = 6;
    _commentValue.textAlignment = NSTextAlignmentLeft;
    _commentValue.textColor = [NiConstants colorWithKey:detailTextColor];
    _commentValue.backgroundColor = [UIColor clearColor];
    _commentValue.font = [UIFont systemFontOfSize:lbFontSize];
   // [_commentValue sizeToFit];
    
    
    [self.view addSubview:_photo];
    [self.view addSubview:_name];
    [self.view addSubview:_weight];
    [self.view addSubview:_weightValue];
    [self.view addSubview:_price];
    [self.view addSubview:_priceValue];
    [self.view addSubview:_qualityinfo];
    [self.view addSubview:_qualityinfoValue];
    [self.view addSubview:_service];
    [self.view addSubview:_serviceValue];
    [self.view addSubview:_pinName];
    [self.view addSubview:_pinNameValue];
    [self.view addSubview:_code];
    [self.view addSubview:_codeValue];
    [self.view addSubview:_origin];
    [self.view addSubview:_originValue];
    [self.view addSubview:_place];
    [self.view addSubview:_placeValue];
    [self.view addSubview:_size];
    [self.view addSubview:_sizeValue];
    [self.view addSubview:_sizeinfo];
    [self.view addSubview:_sizeinfoValue];
    [self.view addSubview:_comment];
    [self.view addSubview:_commentValue];

}

- (CGFloat)getHeight:(UILabel *)lb{
    CGFloat y;
    y = lb.frame.origin.y   +   lb.frame.size.height    +   2;
    return y;
}

- (CGFloat)getWidth:(UILabel *)lb{
    CGFloat x; 
    x = lb.frame.origin.x   +   lb.frame.size.width + 2;
    return x;
}

-(void)setProduct:(ProductInfo *)product{
    [_photo setImage:[UIImage imageNamed:@"person-icon.png"]];
    _name.text = product.name;
    _weightValue.text = [NSString stringWithFormat:@"%@ 吨",product.weight];
    _priceValue.text = [NSString stringWithFormat:@"￥ %.2f 元",product.price];
    _qualityinfoValue.text = product.qualityInfo;
    _serviceValue.text = product.service;
    _pinNameValue.text = product.name;
    _codeValue.text = product.code;
    _originValue.text = product.origin;
    _placeValue.text = product.place;
    _sizeValue.text = product.size;
    _sizeinfoValue.text = product.sizeInfo;
    _commentValue.text = product.comments;
    
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)dealloc
{
    [_photo release];
    [_name release];
    [_weight release];
    [_price release];
    [_qualityinfo release];
    [_service release];
    [_pinName release];
    [_code release];
    [_origin release];
    [_place release];
    [_size release];
    [_sizeinfo release];
    [_comment release];
    
    [_nameValue release];
    [_weightValue release];
    [_priceValue release];
    [_qualityinfoValue release];
    [_serviceValue release];
    [_pinNameValue release];
    [_codeValue release];
    [_originValue release];
    [_placeValue release];
    [_sizeValue release];
    [_sizeinfoValue release];
    [_commentValue release];
	[super dealloc];
}

@end
