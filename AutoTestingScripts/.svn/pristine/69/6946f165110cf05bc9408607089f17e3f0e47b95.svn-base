'''
Created on 2010-11-3

@author: christieduan
'''
from TestBase import TestBase
import Selection
import AddCart
import FunctionCommon


class  PlaceMoreSubCateOrders(TestBase):
    
    
     def test001_ymmCat_TonneauCovers_AdvantageSnapTonneau(self):
         Selection.Year(self,"2010")
         Selection.Make(self,"GMC")
         Selection.Categories_QP(self,"Tonneau Covers")
         Selection.SubCategories_options(self,"Inverse Snap Tonneau") ##"Advantage Snap Tonneau")
         Selection.Products(self)
         AddCart.AddCart(self,"1")
    
     def test002_ymmCat_TonneauCovers_ExtangBlackMaxTonneauCovers(self):
         Selection.Year(self,"2010")
         Selection.Make(self,"GMC")
         Selection.Categories_QP(self,"Tonneau Covers")
         Selection.SubCategories_options(self,"Extang Black Max Tonneau")         
         Selection.Products(self)
         AddCart.AddCart(self,"1")
         
     def test003_ymmCat_BugShieldsBugDeflectors_SmokeBugShield(self):
##         Selection.Categories_QP(self,"Bug Shields - Bug Deflectors ")
         Selection.Year(self,"2010")
         Selection.Make(self,"TOYOTA")
         Selection.Categories_QP(self,"Bug Shields - Bug Deflectors ")
         FunctionCommon.my_wait_text_present(self, "Subcategories Found for")
         Selection.SubCategories_options(self,"Smoke Bug Shield")
         FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
         self.selenium.click("//img[@alt=\'View Products\']")
         
         Selection.Products(self)
         AddCart.AddCart(self,"1")

     def test004_ymmCat_BugShieldsBugDeflectors_ChromeBugShields(self):
##         Selection.Categories_QP(self,"Bug Shields - Bug Deflectors ")
         Selection.Year(self,"2010")
         Selection.Make(self,"TOYOTA")
         Selection.SubCategories_options(self,"Chrome Bug Shields")
         FunctionCommon.my_wait_text_present(self, "Subcategories Found for")
         FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
         self.selenium.click("//img[@alt=\'View Products\']")
         
         Selection.Products(self)
         AddCart.AddCart(self,"1")
         
     def test005_ymmCat_AirFilter_AirFilters(self):
         Selection.Categories_QP(self,"Air Filter") 
         Selection.Year(self,"2010")
         Selection.Make(self,"FORD")
         Selection.SubCategories_options(self,"Air-Filters")
##         FunctionCommon.my_wait_text_present(self, "Subcategories Found for")
         FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
         self.selenium.click("//img[@alt=\'View Products\']")
         
         Selection.Products(self)
         AddCart.AddCart(self,"1")
    
     def test006_ymmCat_AirFilter_UniversalAirFilterAccessories(self):
         Selection.Categories_QP(self,"Air Filter") 
         Selection.Year(self,"2010")
         Selection.Make(self,"FORD")
         Selection.SubCategories_options(self,"Universal Air Filter Accessories")
##         FunctionCommon.my_wait_text_present(self, "Subcategories Found for")
         FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
         self.selenium.click("//img[@alt=\'View Products\']")
         
         Selection.Products(self)
         AddCart.AddCart(self,"1")
         
    
