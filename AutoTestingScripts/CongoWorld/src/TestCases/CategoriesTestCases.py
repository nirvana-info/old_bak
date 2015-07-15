'''
Created on 2010-11-3

@author: christieduan
'''
from Appobjects.TestBase import TestBase
import Appobjects.AddCart as AddCart
import Appobjects.FunctionCommon as FunctionCommon
import Appobjects.PublicFunctions as PublicFunctions
import Appobjects.Mutil_Selection as Mutil_Selection
import Appobjects.Selection as Selection
import Appobjects.Payment as Payment
import unittest
import time
import Appobjects.HTMLTestRunner as HTMLTestRunner




### Test cases

class  PlaceMoreSubCateOrders(TestBase):    
    def test010_ymmCat_TonneauCovers_SnapTonneauCover(self):
         Mutil_Selection.Year(self,"2010")
         Mutil_Selection.Categories_QP(self,"Tonneau Covers")
         FunctionCommon.Browser(self)
         Mutil_Selection.SubCategories_select(self,"Snap Tonneau Cover")
         Mutil_Selection.Products_ViewDetail(self)         
         Payment.addToCard(self,"2")
         Payment.Step1_ProceedCheckOut(self)
         Payment.Step2_ChooseBillingShipAddress(self)
         Payment.Step3_ShippingMethod(self)
         Payment.Step4_OrderConfirm(self)
         Payment.Step5_PaymentDetails(self)
         
    def test011_ymmCat_TonneauCovers_RollUpTonneauCover(self):
         Mutil_Selection.Categories_QP(self,"Tonneau Covers")
         time.sleep(3)
         FunctionCommon.Browser(self)
         Mutil_Selection.SubCategories_select(self,"Roll Up Tonneau Cover")
         Mutil_Selection.Products_ViewDetail(self)         
         Payment.addToCard(self,"2")
         Payment.Step1_ProceedCheckOut(self)
         Payment.Step2_ChooseBillingShipAddress(self)
         Payment.Step3_ShippingMethod(self)
         Payment.Step4_OrderConfirm(self)
         Payment.Step5_PaymentDetails(self)

    def test012_ymmCat_TonneauCovers_RollUpTonneauCover(self):
         Mutil_Selection.Year(self,"2010")
         Mutil_Selection.Make("GMC")
         Mutil_Selection.Categories_QP(self,"Tonneau Covers")
         time.sleep(3)
         FunctionCommon.Browser(self)
         Mutil_Selection.SubCategories_select(self,"Roll Up Tonneau Cover")
         Mutil_Selection.Products_ViewDetail(self)         
         Payment.addToCard(self,"2")
         Payment.Step1_ProceedCheckOut(self)
         Payment.Step2_ChooseBillingShipAddress(self)
         Payment.Step3_ShippingMethod(self)
         Payment.Step4_OrderConfirm(self)
         Payment.Step5_PaymentDetails(self)
      
    def test020_ymmCat_NerfBars_3RoundTubeNerfBars(self):
         Mutil_Selection.Year(self,"2009")
         Mutil_Selection.Categories_QP(self,"Nerf Bars")
         FunctionCommon.Browser(self)
         Mutil_Selection.SubCategories_select(self,'3" Round Tube Nerf Bars')
         Mutil_Selection.Products_ViewDetail(self)         
         Payment.addToCard(self,"3")
         Payment.Step1_ProceedCheckOut(self)
         Payment.Step2_ChooseBillingShipAddress(self)
         Payment.Step3_ShippingMethod(self)
         Payment.Step4_OrderConfirm(self)
         Payment.Step5_PaymentDetails(self)
    
    def test021_ymmCat_NerfBars_GMC_3RoundTubeNerfBars(self):
         Mutil_Selection.Year(self,"2009")
         Mutil_Selection.Categories_QP(self,"Nerf Bars")
         FunctionCommon.Browser(self)
         Mutil_Selection.SubCategories_select(self,'3" Round Tube Nerf Bars')
         Mutil_Selection.Products_ViewDetail(self)         
         Payment.addToCard(self,"3")
         Payment.Step1_ProceedCheckOut(self)
         Payment.Step2_ChooseBillingShipAddress(self)
         Payment.Step3_ShippingMethod(self)
         Payment.Step4_OrderConfirm(self)
         Payment.Step5_PaymentDetails(self)
         
    def test022_ymmCat_NerfBars_GMC_3RoundTubeNerfBars(self):
         Mutil_Selection.Year(self,"2009")
         Mutil_Selection.Make("GMC")
         Mutil_Selection.Categories_QP(self,"Nerf Bars")
         FunctionCommon.Browser(self)
         Mutil_Selection.SubCategories_select(self,'3" Round Tube Nerf Bars')
         Mutil_Selection.Products_ViewDetail(self)         
         Payment.addToCard(self,"3")
         Payment.Step1_ProceedCheckOut(self)
         Payment.Step2_ChooseBillingShipAddress(self)
         Payment.Step3_ShippingMethod(self)
         Payment.Step4_OrderConfirm(self)
         Payment.Step5_PaymentDetails(self)
         
    def test030_ymmCat_AirFilter_AirFilters(self):
         Mutil_Selection.Year(self,"2009")
         Mutil_Selection.Categories_QP(self,"Air Filter")
         FunctionCommon.Browser(self)
         Mutil_Selection.SubCategories_select(self,"Air-Filters")
         Mutil_Selection.Products_ViewDetail(self)         
         Payment.addToCard(self,"2")
         Payment.Step1_ProceedCheckOut(self)
         Payment.Step2_ChooseBillingShipAddress(self)
         Payment.Step3_ShippingMethod(self)
         Payment.Step4_OrderConfirm(self)
         Payment.Step5_PaymentDetails(self)

    def test031_ymmCat_AirFilter_UniversalAirFilterAccessories(self):
         Mutil_Selection.Categories_QP(self,"Air Filter")
         time.sleep(3)
         FunctionCommon.Browser(self)
         Mutil_Selection.SubCategories_select(self,"Universal Air Filter Accessories")
         Mutil_Selection.Products_ViewDetail(self)         
         Payment.addToCard(self,"1")
         Payment.Step1_ProceedCheckOut(self)
         Payment.Step2_ChooseBillingShipAddress(self)
         Payment.Step3_ShippingMethod(self)
         Payment.Step4_OrderConfirm(self)
         Payment.Step5_PaymentDetails(self)
     
    def test032_ymmCat_AirFilter_UniversalAirFilterAccessories(self):
         Mutil_Selection.Year(self,"2009")
         Mutil_Selection.Make("GMC")
         Mutil_Selection.Categories_QP(self,"Air Filter")
         time.sleep(3)
         FunctionCommon.Browser(self)
         Mutil_Selection.SubCategories_select(self,"Universal Air Filter Accessories")
         Mutil_Selection.Products_ViewDetail(self)         
         Payment.addToCard(self,"1")
         Payment.Step1_ProceedCheckOut(self)
         Payment.Step2_ChooseBillingShipAddress(self)
         Payment.Step3_ShippingMethod(self)
         Payment.Step4_OrderConfirm(self)
         Payment.Step5_PaymentDetails(self)    
               
    def test040_ymmCat_BedLiners_BedMat(self):
         Mutil_Selection.Year(self,"2008")
         Mutil_Selection.Make("CHEVROLET")
         Mutil_Selection.Categories_QP(self,"Bed Mats & Bed Liners")
         time.sleep(3)
         FunctionCommon.Browser(self)
         Mutil_Selection.SubCategories_select(self,"Bed Mat")
         Mutil_Selection.Products_ViewDetail(self)         
         Payment.addToCard(self,"1")
         Payment.Step1_ProceedCheckOut(self)
         Payment.Step2_ChooseBillingShipAddress(self)
         Payment.Step3_ShippingMethod(self)
         Payment.Step4_OrderConfirm(self)
         Payment.Step5_PaymentDetails(self) 
    
    def test041_ymmCat_BedLiners_BedMat(self):
         Mutil_Selection.Make("CHEVROLET")
         Mutil_Selection.Categories_QP(self,"Bed Mats & Bed Liners")
         time.sleep(3)
         FunctionCommon.Browser(self)
         Mutil_Selection.SubCategories_select(self,"Bed Mat")
         Mutil_Selection.Products_ViewDetail(self)         
         Payment.addToCard(self,"1")
         Payment.Step1_ProceedCheckOut(self)
         Payment.Step2_ChooseBillingShipAddress(self)
         Payment.Step3_ShippingMethod(self)
         Payment.Step4_OrderConfirm(self)
         Payment.Step5_PaymentDetails(self)
         
    def test042_ymmCat_BedLiners_BedMat(self):
         Mutil_Selection.Categories_QP(self,"Bed Mats & Bed Liners")
         time.sleep(3)
         FunctionCommon.Browser(self)
         Mutil_Selection.SubCategories_select(self,"Bed Mat")
         Mutil_Selection.Products_ViewDetail(self)         
         Payment.addToCard(self,"1")
         Payment.Step1_ProceedCheckOut(self)
         Payment.Step2_ChooseBillingShipAddress(self)
         Payment.Step3_ShippingMethod(self)
         Payment.Step4_OrderConfirm(self)
         Payment.Step5_PaymentDetails(self)
         
         
##Test Suite
def MoreSubCategoriesTest():
    suite=unittest.TestSuite()
    suite.addTest(PlaceMoreSubCateOrders("test010_ymmCat_TonneauCovers_SnapTonneauCover"))
#    suite.addTest(PlaceMoreSubCateOrders("test011_ymmCat_TonneauCovers_RollUpTonneauCover"))
#    suite.addTest(PlaceMoreSubCateOrders("test012_ymmCat_TonneauCovers_RollUpTonneauCover"))
#    suite.addTest(PlaceMoreSubCateOrders("test020_ymmCat_NerfBars_3RoundTubeNerfBars"))
#    suite.addTest(PlaceMoreSubCateOrders("test021_ymmCat_NerfBars_GMC_3RoundTubeNerfBars"))
#    suite.addTest(PlaceMoreSubCateOrders("test022_ymmCat_NerfBars_GMC_3RoundTubeNerfBars"))
#    suite.addTest(PlaceMoreSubCateOrders("test030_ymmCat_AirFilter_AirFilters"))
#    suite.addTest(PlaceMoreSubCateOrders("test031_ymmCat_AirFilter_UniversalAirFilterAccessories"))
#    suite.addTest(PlaceMoreSubCateOrders("test032_ymmCat_AirFilter_UniversalAirFilterAccessories"))
#    suite.addTest(PlaceMoreSubCateOrders("test040_ymmCat_BedLiners_BedMat"))
#    suite.addTest(PlaceMoreSubCateOrders("test041_ymmCat_BedLiners_BedMat"))
#    suite.addTest(PlaceMoreSubCateOrders("test042_ymmCat_BedLiners_BedMat"))
    return suite

## Test Execute

if __name__ == "__main__":
    fp = file('CongoWorld Auto-Testing Result_CategoriesOrders_MoreSubcategories.html', 'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp, title='Quick Test', description='The test report of selenium')    
    runner.run(MoreSubCategoriesTest())
