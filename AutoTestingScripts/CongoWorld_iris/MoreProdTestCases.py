'''
Created on 2011-02-25

@author: iris chen
'''
from TestBase import TestBase
import AddCart
import FunctionCommon
import PublicFunctions
import Mutil_Selection
import Payment
import unittest
import time
import HTMLTestRunner




### Test cases

class  PlaceMoreProdOrders(TestBase):    
    def test010_MoreProd(self):
        Mutil_Selection.Year(self,"2010")
        Mutil_Selection.Categories_QP(self,"Tonneau Covers")     
        FunctionCommon.Browser(self)
        Mutil_Selection.SubCategories_Link(self,"category/4/subcategory/6/year/2010")
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        ## Go back homepage and clean all
        self.selenium.click("//div[@id='TopMenu']/ul/li[2]/a/span")
        PublicFunctions.my_wait_text_present(self, "Quick Search")
        FunctionCommon.Clear(self)
        ## Add another product
        Mutil_Selection.Year(self,"2010")
        Mutil_Selection.Brand(self,"Advantage")      
        FunctionCommon.Browser(self)
        Mutil_Selection.Series_options(self,"Advantage Sure-Fit")
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
##        PublicFunctions.my_wait_text_present(self,"Express Checkout")
##        Payment.Step1_ProceedCheckOut(self,False)
##        Payment.Step3_ShippingMethod(self)
##        Payment.Step4_OrderConfirm(self) 

    def test011_MoreProd(self):
        Mutil_Selection.Year(self,"2005")
        Mutil_Selection.Make(self,"CHEVROLET")
        Mutil_Selection.Brand(self,"AEM")              
        FunctionCommon.Browser(self)
        Mutil_Selection.Series_options(self,"AEM Analog Guage")        
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        ## Go back homepage and clean all
        self.selenium.click("//div[@id='TopMenu']/ul/li[2]/a/span")
        time.sleep(8)
        PublicFunctions.my_wait_text_present(self, "Quick Search")
        FunctionCommon.Clear(self)
        ## Add another product
        time.sleep(5)
        Mutil_Selection.Year(self,"2007")
        Mutil_Selection.Categories_QP(self,"Oil Filters")     
        FunctionCommon.Browser(self) 
        Mutil_Selection.SubCategories_Link(self,"category/19/subcategory/419/year/2007")
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
##        PublicFunctions.my_wait_text_present(self,"Express Checkout")
##        Payment.Step1_ProceedCheckOut(self,False)
##        Payment.Step3_ShippingMethod(self)
##        Payment.Step4_OrderConfirm(self) 
     
    def test012_MoreProd(self):
        Mutil_Selection.Year(self,"2007")
        Mutil_Selection.Make(self,"TOYOTA")
        Mutil_Selection.Categories_QP(self,"Bed Mats")     
        FunctionCommon.Browser(self)  
        Mutil_Selection.SubCategories_Link(self,"category/68/subcategory/675/year/2007/make/toyota")
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        ## Go back homepage and clean all
        self.selenium.click("//div[@id='TopMenu']/ul/li[2]/a/span")
        time.sleep(8)
        PublicFunctions.my_wait_text_present(self, "Quick Search")
        FunctionCommon.Clear(self)
        ## Add another product
        Mutil_Selection.Year(self,"2007")
        Mutil_Selection.Make(self,"NISSAN")
        Mutil_Selection.Brand(self,"Edge")              
        FunctionCommon.Browser(self)
        Mutil_Selection.Series_options(self,"Edge Plug-In") 
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
##        PublicFunctions.my_wait_text_present(self,"Express Checkout")
##        Payment.Step1_ProceedCheckOut(self,False)
##        Payment.Step3_ShippingMethod(self)
##        Payment.Step4_OrderConfirm(self) 
  
    def test020_MoreProd(self):
        Mutil_Selection.Make(self,"HONDA")
        Mutil_Selection.Categories_QP(self,"Mufflers")     
        FunctionCommon.Browser(self) 
        Mutil_Selection.SubCategories_Link(self,"category/224/subcategory/421/make/honda")
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.UpdateQty(self,"3")
        AddCart.CheckOut(self)
##        PublicFunctions.my_wait_text_present(self,"Express Checkout")
##        Payment.Step1_ProceedCheckOut(self,False)
##        Payment.Step3_ShippingMethod(self)
##        Payment.Step4_OrderConfirm(self)          
      
    def test021_MoreProd(self):
        Mutil_Selection.Year(self,"2009")
        Mutil_Selection.Brand(self,"K&N")              
        FunctionCommon.Browser(self)
        Mutil_Selection.Series_options(self,"Air Filter Accessories") 
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.UpdateQty(self,"3")
        AddCart.CheckOut(self)

    def test022_MoreProd(self):
        Mutil_Selection.Year(self,"2010")
        Mutil_Selection.Make(self,"JEEP")
        Mutil_Selection.Categories_QP(self,"Mufflers")     
        FunctionCommon.Browser(self) 
        Mutil_Selection.SubCategories_Link(self,"category/224/subcategory/422/year/2010/make/jeep")
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.UpdateQty(self,"3")
        AddCart.CheckOut(self)

    def test030_MoreProd(self):
        Mutil_Selection.Make(self,"FORD")
        Mutil_Selection.Categories_QP(self,"Bed Mats")     
        FunctionCommon.Browser(self)   
        Mutil_Selection.SubCategories_Link(self,"category/68/subcategory/636/make/ford")
        Mutil_Selection.ProdList_AddToCart(self, "1")
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)       

    def test031_MoreProd(self):
        Mutil_Selection.Year(self,"2006")
        Mutil_Selection.Make(self,"DODGE")
        Mutil_Selection.Categories_QP(self,"Nerf Bars")     
        FunctionCommon.Browser(self)   
        Mutil_Selection.SubCategories_Link(self,"category/57/subcategory/728/year/2006/make/dodge")
        Mutil_Selection.ProdList_AddToCart(self, "5")
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)

    def test032_MoreProd(self):
        Mutil_Selection.Year(self,"2005")
        Mutil_Selection.Brand(self,"Extang")              
        FunctionCommon.Browser(self)
        Mutil_Selection.Series_options(self,"Extang EXPRESS Universal Tailgate Seal")
        Mutil_Selection.ProdList_AddToCart(self, "4")
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
     
##Test Suite
def MoreProdTest():
    suite=unittest.TestSuite()
##    suite.addTest(PlaceMoreProdOrders("test010_MoreProd"))
    suite.addTest(PlaceMoreProdOrders("test011_MoreProd"))  
##    suite.addTest(PlaceMoreProdOrders("test012_MoreProd"))     
##    suite.addTest(PlaceMoreProdOrders("test020_MoreProd"))
##    suite.addTest(PlaceMoreProdOrders("test021_MoreProd"))
##    suite.addTest(PlaceMoreProdOrders("test022_MoreProd"))
##    suite.addTest(PlaceMoreProdOrders("test030_MoreProd"))
##    suite.addTest(PlaceMoreProdOrders("test031_MoreProd"))
    suite.addTest(PlaceMoreProdOrders("test032_MoreProd"))
    return suite

## Test Execute

if __name__ == "__main__":
    fp = file('CongoWorld Auto-Testing Result_CategoriesOrders_MoreSubcategories.html', 'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp, title='Quick Test', description='The test report of selenium')    
    runner.run(MoreProdTest())





