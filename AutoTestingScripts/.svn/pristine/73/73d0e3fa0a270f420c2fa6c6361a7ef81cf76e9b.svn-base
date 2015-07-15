'''
Created on 2010-11-3

@author: ChristieDuan
'''

import unittest
from SmokeTestCases import PlaceOders
from MoreSubcategoriesTestCases import PlaceMoreSubCateOrders
from MoreSeriesTestCases import PlaceSeriesOrders
from ZeroOrOneSeriesTestCases import Place0or1SeriesOrders
from ZeroOrOneSubcategoryTestCases import Place0or1CatesOrders
from DiscountTestCases import DiscountTestCases


def SmokingTest():
    suite = unittest.TestSuite()
    suite.addTest(PlaceOders("test001_ymmCat_TonneauCovers"))
    suite.addTest(PlaceOders("test001_ymmCat_NerfBars"))
    suite.addTest(PlaceOders("test001_ymmCat_AirFilter"))
    suite.addTest(PlaceOders("test002_Cat_TonneauCovers"))
    suite.addTest(PlaceOders("test002_Cat_NerfBars"))
    suite.addTest(PlaceOders("test002_Cat_AirFilter"))  
    suite.addTest(PlaceOders("test003_brand_TruckChamp"))
    suite.addTest(PlaceOders("test003_brand_BestinAuto"))
    suite.addTest(PlaceOders("test004_ymmbrand_TruckChamp"))
    suite.addTest(PlaceOders("test004_ymmbrand_BestinAuto"))
    return suite

def MoreSubCategoriesTest():
    suite=unittest.TestSuite()
    suite.addTest(PlaceMoreSubCateOrders("test001_ymmCat_TonneauCovers_AdvantageSnapTonneau"))
    suite.addTest(PlaceMoreSubCateOrders("test002_ymmCat_TonneauCovers_ExtangBlackMaxTonneauCovers"))
##    suite.addTest(PlaceMoreSubCateOrders("test003_ymmCat_BugShieldsBugDeflectors_SmokeBugShield"))
##    suite.addTest(PlaceMoreSubCateOrders("test004_ymmCat_BugShieldsBugDeflectors_ChromeBugShields"))
    suite.addTest(PlaceMoreSubCateOrders("test005_ymmCat_AirFilter_AirFilters"))
    suite.addTest(PlaceMoreSubCateOrders("test006_ymmCat_AirFilter_UniversalAirFilterAccessories"))
    return suite

def MoreSeriesTest():
    suite=unittest.TestSuite()
    suite.addTest(PlaceSeriesOrders("test001_ymmbrand_BestinAuto_AvengerProLiteNonGlareSideMirrorReplacementGlass"))
    suite.addTest(PlaceSeriesOrders("test002_ymmbrand_Stampede_VigilanteLowProfileBugShield"))
    suite.addTest(PlaceSeriesOrders("test003_ymmbrand_Stampede_StampedeTapeOnzSidewindDeflectorWindowVisors"))
    suite.addTest(PlaceSeriesOrders("test004_ymmbrand_Husky_FloorCargoandTruckLiners"))
    suite.addTest(PlaceSeriesOrders("test005_ymmbrand_Magnaflow_MagnaflowDirectFitCatalyticConverters"))
    suite.addTest(PlaceSeriesOrders("test006_ymmbrand_Magnaflow_MagnaflowGasExhaustSystems"))
    
    return suite

def ZeroOrOneSeriesTest():
    suite=unittest.TestSuite()
    suite.addTest(Place0or1SeriesOrders("test001_ymmbrand_DuHa"))
    suite.addTest(Place0or1SeriesOrders("test002_ymmbrand_LoadHandler"))
    suite.addTest(Place0or1SeriesOrders("test003_ymmbrand_LoadingZone"))
    suite.addTest(Place0or1SeriesOrders("test004_ymmbrand_Lund"))
    return suite

def ZeroOrOneCatesTest():
    suite=unittest.TestSuite() 
##    suite.addTest(Place0or1CatesOrders("test001_ymmCat_BedLiners"))
##    suite.addTest(Place0or1CatesOrders("test002_ymmCat_DuHaUnderseatStorage"))
##    suite.addTest(Place0or1CatesOrders("test003_ymmCat_EngineDressUp"))
##    suite.addTest(Place0or1CatesOrders("test004_Cat_BedLiners"))
    suite.addTest(Place0or1CatesOrders("test005_Cat_DuHaUnderseatStorage"))
##    suite.addTest(Place0or1CatesOrders("test006_Cat_EngineDressUp"))
    return suite


def DiscountOrderTest():
    suite=unittest.TestSuite()
##    suite.addTest(DiscountTestCases("test022_CouponCodesProductsOrder"))
    suite.addTest(DiscountTestCases("test001_CouponCodesCatesOrder"))
    suite.addTest(DiscountTestCases("test002_CouponCodesProductsOrder"))
    suite.addTest(DiscountTestCases("test003_DiscountRulesBrandsOrder"))
    suite.addTest(DiscountTestCases("test004_CompanyGiftCertificatesCatesOrder"))
    suite.addTest(DiscountTestCases("test005_CompanyGiftCertificatesProductsOrder"))
    
    return suite
