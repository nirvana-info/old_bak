'''
Created on 2010-10-11

@author: christie.duan
'''

from TestBase import TestBase
import Selection
import AddCart
import FunctionCommon

class PlaceOders(TestBase):
    
# Place order by YMM+Category  script for "Tonneau Covers", "Nerf Bars"  & "Air Filters"   
 
    def test001_ymmCat_TonneauCovers(self):
        Selection.Year(self,"2010")
        Selection.Make(self,"GMC")
        Selection.Categories_QP(self,"Tonneau Covers")
        FunctionCommon.my_wait_element(self,"//img[@alt='View More Details About Snap Truck Bed Covers']")
        self.selenium.click("//img[@alt='View More Details About Snap Truck Bed Covers']")
        Selection.Products(self)
        AddCart.AddCart(self,"1")
        
    def test001_ymmCat_NerfBars(self):
        Selection.Year(self,"2010")
        Selection.Make(self,"GMC")
        Selection.Categories_QP(self,"Nerf Bars") 
        Selection.SubCategories_cust(self)
        Selection.Products(self)
        AddCart.AddCart(self,"1")
        
    def test001_ymmCat_AirFilter(self):
        Selection.Categories_QP(self,"Air Filter") 
        Selection.Year(self,"2010")
        Selection.Make(self,"GMC")
        Selection.SubCategories(self)
        Selection.Products(self)
        AddCart.AddCart(self,"1")
        
# Place order by Category script for "Tonneau Covers", "Nerf Bars"  & "Air Filters"  
               
    def test002_Cat_TonneauCovers(self):
        Selection.Categories_QP(self,"Tonneau Covers")
        FunctionCommon.my_wait_element(self,"//img[@alt='View More Details About Snap Truck Bed Covers']")
        self.selenium.click("//img[@alt='View More Details About Snap Truck Bed Covers']")
        Selection.Products(self)
        AddCart.AddCart(self,"1")
        
    def test002_Cat_NerfBars(self):
        Selection.Categories_QP(self,"Nerf Bars")
        Selection.SubCategories_cust(self)
        Selection.Products(self)
        AddCart.AddCart(self,"1")
        
    def test002_Cat_AirFilter(self):
        Selection.Categories_QP(self,"Air Filter")
        Selection.SubCategories(self)
        Selection.Products(self)
        AddCart.AddCart(self,"1")
        
        
# Place order by Brand script for "TruckChamp"  & "BestinAuto" 
        
    def test003_brand_TruckChamp(self):
        Selection.Brand(self,"Truck Champ")   
        Selection.Series(self)
        Selection.Products(self)
        AddCart.AddCart(self,"1")
        
    def test003_brand_BestinAuto(self):
        Selection.Brand(self,"BestInAUTO")   
        Selection.Series(self)
        Selection.Products(self)
        AddCart.AddCart(self,"1")
        
# Place order by YMM+Brand script for "TruckChamp"  & "BestinAuto" 
       
    def test004_ymmbrand_TruckChamp(self):
        Selection.Year(self,"2010")
        Selection.Brand(self,"Truck Champ")   
        Selection.Series(self)
        Selection.Products(self)
        AddCart.AddCart(self,"2") 
        AddCart.CheckOut(self)
        
    def test004_ymmbrand_BestinAuto(self):
        Selection.Year(self,"2010")
        Selection.Brand(self,"BestInAUTO")   
        Selection.Series(self)
        Selection.Products(self)
        AddCart.AddCart(self,"2") 
        AddCart.CheckOut(self)
        
