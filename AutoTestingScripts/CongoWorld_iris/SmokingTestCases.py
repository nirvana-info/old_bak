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

class  SmokingTestOrders(TestBase):    
    def test010_Cat_AirFilter_AirFilters(self):
        Mutil_Selection.Year(self,"2010")
        Mutil_Selection.Make(self,"FORD")
        Mutil_Selection.Categories_QP(self,"Air Filter")
        FunctionCommon.Browser(self)
        Mutil_Selection.SubCategories_Link(self,"category/15/subcategory/587/year/2010/make/ford")
        Mutil_Selection.Products_ViewDetail(self)
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
        PublicFunctions.my_wait_text_present(self,"Express Checkout")
        Payment.Step1_ProceedCheckOut(self,False)
        Payment.Step3_ShippingMethod(self)
        Payment.Step4_OrderConfirm(self)          
         
    def test011_Cat_AitFilter_UniversalAirFitlerCleaner(self):
        Mutil_Selection.Year(self,"2009")
        Mutil_Selection.Make(self,"GMC")
        Mutil_Selection.Categories_QP(self,"Air Filter")
##        time.sleep(3)
        FunctionCommon.Browser(self)
        Mutil_Selection.SubCategories_Link(self,"category/15/subcategory/380/year/2009/make/gmc")
        Mutil_Selection.Products_ViewDetail(self)         
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
        PublicFunctions.my_wait_text_present(self,"Express Checkout")
        Payment.Step1_ProceedCheckOut(self,False)
        Payment.Step3_ShippingMethod(self)
        Payment.Step4_OrderConfirm(self)

    def test020_Cat_NerfBars_DropStep(self):
        Mutil_Selection.Year(self,"2010")
        Mutil_Selection.Make(self,"FORD")
        Mutil_Selection.Categories_QP(self,"Nerf Bars")
        time.sleep(3)
        FunctionCommon.Browser(self)
        Mutil_Selection.SubCategories_Link(self,"category/57/subcategory/728/year/2010/make/ford")
        Mutil_Selection.Products_ViewDetail(self)         
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
        PublicFunctions.my_wait_text_present(self,"Express Checkout")
        Payment.Step1_ProceedCheckOut(self,False)
        Payment.Step3_ShippingMethod(self)
        Payment.Step4_OrderConfirm(self)
      
    def test021_Cat_NerfBars_3WWRoundTube(self):
        Mutil_Selection.Year(self,"2009")
        Mutil_Selection.Make(self,"FORD")
        Mutil_Selection.Categories_QP(self,"Nerf Bars")
        FunctionCommon.Browser(self)  
        Mutil_Selection.SubCategories_Link(self,"category/57/subcategory/257/year/2009/make/ford")
        Mutil_Selection.Products_ViewDetail(self)         
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
        PublicFunctions.my_wait_text_present(self,"Express Checkout")
        Payment.Step1_ProceedCheckOut(self,False)
        Payment.Step3_ShippingMethod(self)
        Payment.Step4_OrderConfirm(self)
    
    def test030_Cat_TonneauCovers_FoldingHard(self):
        Mutil_Selection.Year(self,"2010")
        Mutil_Selection.Make(self,"FORD")
        Mutil_Selection.Categories_QP(self,"Tonneau Covers")
        FunctionCommon.Browser(self)
        Mutil_Selection.SubCategories_Link(self,"category/4/subcategory/14/year/2010/make/ford")
        Mutil_Selection.Products_ViewDetail(self)         
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
        PublicFunctions.my_wait_text_present(self,"Express Checkout")
        Payment.Step1_ProceedCheckOut(self,False)
        Payment.Step3_ShippingMethod(self)
        Payment.Step4_OrderConfirm(self)
         
    def test031_Cat_TonneauCovers_ToolBox(self):
        Mutil_Selection.Year(self,"2009")
        Mutil_Selection.Make(self,"GMC")
        Mutil_Selection.Categories_QP(self,"Tonneau Covers")
        FunctionCommon.Browser(self)
        Mutil_Selection.SubCategories_Link(self,"category/4/subcategory/99/year/2009/make/gmc")
        Mutil_Selection.Products_ViewDetail(self)         
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
        PublicFunctions.my_wait_text_present(self,"Express Checkout")
        Payment.Step1_ProceedCheckOut(self,False)
        Payment.Step3_ShippingMethod(self)
        Payment.Step4_OrderConfirm(self)
         
    def test110_Brand_BestInAUTO_3rdBrakeLights(self):
        Mutil_Selection.Year(self,"2009")
        Mutil_Selection.Make(self,"GMC")
        Mutil_Selection.Brand(self,"BestInAUTO")
        FunctionCommon.Browser(self)
        Mutil_Selection.SubCategories_Link(self,"brand/83/series/555/year/2009/make/gmc")
        Mutil_Selection.Products_ViewDetail(self)         
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
        PublicFunctions.my_wait_text_present(self,"Express Checkout")
        Payment.Step1_ProceedCheckOut(self,False)
        Payment.Step3_ShippingMethod(self)
        Payment.Step4_OrderConfirm(self)

    def test111_Brand_BestInAUTO_ValveStemExtensions(self):
        Mutil_Selection.Year(self,"2010")
        Mutil_Selection.Make(self,"FORD")        
        Mutil_Selection.Brand(self,"BestInAUTO")
        time.sleep(3)
        FunctionCommon.Browser(self)
        Mutil_Selection.SubCategories_Link(self,"brand/83/series/531/year/2010/make/ford")
        Mutil_Selection.Products_ViewDetail(self)         
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
        PublicFunctions.my_wait_text_present(self,"Express Checkout")
        Payment.Step1_ProceedCheckOut(self,False)
        Payment.Step3_ShippingMethod(self)
        Payment.Step4_OrderConfirm(self)
     
    def test120_Brand_TruckChamp_StainlessSteelBullBars(self):
        Mutil_Selection.Year(self,"2009")
        Mutil_Selection.Make(self,"GMC")
        Mutil_Selection.Brand(self,"Truck Champ")
        time.sleep(3)
        FunctionCommon.Browser(self)
        Mutil_Selection.SubCategories_Link(self,"brand/7/series/42/year/2009/make/gmc")
        Mutil_Selection.Products_ViewDetail(self)         
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
        PublicFunctions.my_wait_text_present(self,"Express Checkout")
        Payment.Step1_ProceedCheckOut(self,False)
        Payment.Step3_ShippingMethod(self)
        Payment.Step4_OrderConfirm(self)   
               
    def test121_Brand_TruckChamp_TCDropSteps(self):
        Mutil_Selection.Year(self,"2008")
        Mutil_Selection.Make(self,"CHEVROLET")
        Mutil_Selection.Brand(self,"Truck Champ")
        time.sleep(3)
        FunctionCommon.Browser(self)
        Mutil_Selection.SubCategories_Link(self,"brand/7/series/535/year/2008/make/chevrolet")
        Mutil_Selection.Products_ViewDetail(self)         
        AddCart.AddCart(self)
        PublicFunctions.my_wait_text_present(self,"Your Shopping Cart")
        AddCart.CheckOut(self)
        PublicFunctions.my_wait_text_present(self,"Express Checkout")
        Payment.Step1_ProceedCheckOut(self,False)
        Payment.Step3_ShippingMethod(self)
        Payment.Step4_OrderConfirm(self)


    
              
##Test Suite
def SmokingTest():
    suite=unittest.TestSuite()
##    suite.addTest(SmokingTestOrders("test010_Cat_AirFilter_AirFilters")) 
##    suite.addTest(SmokingTestOrders("test011_Cat_AitFilter_UniversalAirFitlerCleaner")) 
##    suite.addTest(SmokingTestOrders("test020_Cat_NerfBars_DropStep"))
    suite.addTest(SmokingTestOrders("test021_Cat_NerfBars_3WWRoundTube"))  
##    suite.addTest(SmokingTestOrders("test030_Cat_TonneauCovers_FoldingHard"))  
##    suite.addTest(SmokingTestOrders("test031_Cat_TonneauCovers_ToolBox")) 
##    suite.addTest(SmokingTestOrders("test110_Brand_BestInAUTO_3rdBrakeLights"))
##    suite.addTest(SmokingTestOrders("test111_Brand_BestInAUTO_ValveStemExtensions"))  ## there are discount, so I have to add a step in cart page.
##    suite.addTest(SmokingTestOrders("test120_Brand_TruckChamp_StainlessSteelBullBars"))   
##    suite.addTest(SmokingTestOrders("test121_Brand_TruckChamp_TCDropSteps"))   ##there are discount, so I have to add a step in cart page.
    
    return suite

## Test Execute

if __name__ == "__main__":
    fp = file('CongoWorld Auto-Testing Result_CategoriesOrders_MoreSubcategories.html', 'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp, title='Quick Test', description='The test report of selenium')    
    runner.run(SmokingTest())
