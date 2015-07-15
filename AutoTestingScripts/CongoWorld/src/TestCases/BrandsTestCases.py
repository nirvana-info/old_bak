'''
Created on 2010-11-29

@author: Administrator
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


class  PlaceBrandsOrders(TestBase):
    
     def test001_ymmbrand(self):
         Mutil_Selection.Year(self,"2010")
         Mutil_Selection.Make(self,"GMC")
         Mutil_Selection.Brand(self,"Stampede")
         FunctionCommon.Browser(self)
         Mutil_Selection.Series_options(self,"Stampede Sunroof Wind Deflector Windtamers")
          
         #print PublicFunctions.my_wait_element(self,"SearchPage")
         #print PublicFunctions.my_wait_element(self,"Stampede Sunroof Wind Deflector Windtamers")
         #print PublicFunctions.my_wait_element(self,"//a[@text='Stampede Sunroof Wind Deflector Windtamers']")         
         #Mutil_Selection.Series_options("Stampede Sunroof Wind Deflector Windtamers")
         #self.selenium.click("//a[@text='Stampede Sunroof Wind Deflector Windtamers']")
        
def MoreBrandsTest():
    suite=unittest.TestSuite()
    suite.addTest(PlaceBrandsOrders("test001_ymmbrand"))
#    suite.addTest(PlaceMoreSubCateOrders("test002_ymmCat_TonneauCovers_RollUpTonneauCover"))
#    suite.addTest(PlaceMoreSubCateOrders("test003_ymmCat_NerfBars_3RoundTubeNerfBars"))
#    suite.addTest(PlaceMoreSubCateOrders("test004_ymmCat_NerfBars_GMC_3RoundTubeNerfBars"))
#    suite.addTest(PlaceMoreSubCateOrders("test005_ymmCat_AirFilter_AirFilters"))
#    suite.addTest(PlaceMoreSubCateOrders("test006_ymmCat_AirFilter_UniversalAirFilterAccessories"))
    return suite

if __name__ == "__main__":
    fp = file('CongoWorld Auto-Testing Result_CategoriesOrders_NosubCategory.html', 'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp, title='Quick Test', description='The test report of selenium')    
    runner.run(MoreBrandsTest())
    
