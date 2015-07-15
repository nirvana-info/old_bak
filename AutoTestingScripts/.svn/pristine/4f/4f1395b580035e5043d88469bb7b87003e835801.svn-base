'''
Created on 2010-11-11

@author: christieduan
'''
from TestBase import TestBase
import Selection
import AddCart
import FunctionCommon


class  DiscountTestCases(TestBase):
    
    def test001_CouponCodesCatesOrder(self):
        Selection.Year(self,"2010")
        Selection.Make(self,"GMC")
        Selection.Categories_QP(self,"Tonneau Covers")
        Selection.SubCategories_options(self,"Inverse Snap Tonneau")
        Selection.Products(self)
        AddCart.AddCart(self,"1")
        Selection.couponcode(self,"UE9A62C227T")
        ##AddCart.CheckOut(self)
        
    def test002_CouponCodesProductsOrder(self):
        Selection.Categories_QP(self,"Air Filter")         
        Selection.SubCategories_options(self,"Air-Filters")
        FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
        self.selenium.click("//img[@alt=\'View Products\']")
        Selection.Products(self)
        AddCart.AddCart(self,"1")
        Selection.couponcode(self,"EN7XQ9WF9HV")
        
    def test003_DiscountRulesBrandsOrder(self):
        Selection.Categories_QP(self,"Nerf Bars")
        Selection.SubCategories_options(self,"Truck Champ Drop Steps")  
        Selection.Products(self)
        AddCart.AddCart(self,"10")
                      
    def test004_CompanyGiftCertificatesCatesOrder(self):
        Selection.Categories_QP(self,"Air Intakes")
        FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
        self.selenium.click("//img[@alt=\'View Products\']")
        ##Selection.SubCategories(self)
        
        Selection.Products(self)
        AddCart.AddCart(self,"1")
    
    def test005_CompanyGiftCertificatesProductsOrder(self):
        Selection.Year(self,"2010")
        Selection.Brand(self,"BestInAUTO")   
        Selection.Series_options(self,"Avenger Pro Lite Non-Glare Side Mirror Replacement Glass")
        FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
        self.selenium.click("//img[@alt=\'View Products\']")
        
        Selection.Products(self)
        AddCart.AddCart(self,"2") 
        AddCart.CheckOut(self)
        
##    def test022_CouponCodesProductsOrder(self):        
##        FunctionCommon.my_wait_element(self,"link=Air Filter")      
##        self.selenium.click("link=Air Filter")
##        FunctionCommon.my_wait_title(self,"Air Filter")
##        
##        FunctionCommon.my_wait_element(self,"//img[@alt=\'Air-Filters\']")
##        self.selenium.click("//img[@alt=\'Air-Filters\']")
##        FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
##        self.selenium.click("//img[@alt=\'View Products\']")
##        
##        Selection.Products(self)
##        AddCart.AddCart(self,"1")
##        Selection.couponcode(self,"EN7XQ9WF9HV")
  
        
        
