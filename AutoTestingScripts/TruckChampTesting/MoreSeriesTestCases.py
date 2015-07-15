'''
Created on 2010-11-3

@author: ChristieDuan
'''
from TestBase import TestBase
import Selection
import AddCart
import FunctionCommon

class PlaceSeriesOrders(TestBase):

    def test001_ymmbrand_BestinAuto_AvengerProLiteNonGlareSideMirrorReplacementGlass(self):
        Selection.Year(self,"2010")
        Selection.Brand(self,"BestInAUTO")   
        Selection.Series_options(self,"Avenger Pro Lite Non-Glare Side Mirror Replacement Glass")
        FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
        self.selenium.click("//img[@alt=\'View Products\']")
        
        Selection.Products(self)
        AddCart.AddCart(self,"2") 
        AddCart.CheckOut(self)
    
    def test002_ymmbrand_Stampede_VigilanteLowProfileBugShield(self):
        Selection.Brand(self,"Stampede")
        Selection.Year(self,"2010")
        Selection.Make(self,"FORD")
        Selection.Series_options(self,"Vigilante Low Profile Bug Shield")
        FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
        self.selenium.click("//img[@alt=\'View Products\']")
        
        Selection.Products(self)
        AddCart.AddCart(self,"2") 
        AddCart.CheckOut(self)

    def test003_ymmbrand_Stampede_StampedeTapeOnzSidewindDeflectorWindowVisors(self):
        Selection.Brand(self,"Stampede") 
        Selection.Year(self,"2010")
        Selection.Make(self,"FORD")
        Selection.Series_options(self,"Stampede Tape-Onz Sidewind Deflector Window Visors")
        FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
        self.selenium.click("//img[@alt=\'View Products\']")
        
        Selection.Products(self)
        AddCart.AddCart(self,"2") 
        AddCart.CheckOut(self)
        
    def test004_ymmbrand_Husky_FloorCargoandTruckLiners(self):
        Selection.Brand(self,"Husky")
        Selection.Year(self,"2010")
        Selection.Make(self,"FORD")
        Selection.Series_options(self,"Husky Shield Paint Protection")
        FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
        self.selenium.click("//img[@alt=\'View Products\']")
        
        Selection.Products(self)
        AddCart.AddCart(self,"2") 
        AddCart.CheckOut(self)
    
    def test005_ymmbrand_Magnaflow_MagnaflowDirectFitCatalyticConverters(self):
        Selection.Brand(self,"Magnaflow") 
        Selection.Year(self,"2010")
        Selection.Make(self,"FORD")
        Selection.Series_options(self,"Magnaflow Direct Fit Catalytic Converters")
        FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
        self.selenium.click("//img[@alt=\'View Products\']")
        
        Selection.Products(self)
        AddCart.AddCart(self,"2") 
        AddCart.CheckOut(self)
        
    def test006_ymmbrand_Magnaflow_MagnaflowGasExhaustSystems(self):
        Selection.Brand(self,"Magnaflow") 
        Selection.Year(self,"2010")
        Selection.Make(self,"FORD")
        Selection.Series_options(self,"Magnaflow Gas Exhaust Systems")
        FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
        self.selenium.click("//img[@alt=\'View Products\']")
        
        Selection.Products(self)
        AddCart.AddCart(self,"2")
        AddCart.CheckOut(self)

    def test022_ymmbrand_Stampede_VigilanteLowProfileBugShield(self):
        FunctionCommon.my_wait_element(self,"brand_more")
        self.selenium.click("brand_more")
        
        FunctionCommon.my_wait_element(self,"link=Stampede")
        self.selenium.click("link=Stampede")
        FunctionCommon.my_wait_text_prsesent(self, "Series Found for")
        
        Selection.Year(self,"2010")
        Selection.Make(self,"FORD")
        Selection.Series_options(self,"Vigilante Low Profile Bug Shield")
        FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
        self.selenium.click("//img[@alt=\'View Products\']")
        
        Selection.Products(self)
        AddCart.AddCart(self,"2") 
        AddCart.CheckOut(self)

