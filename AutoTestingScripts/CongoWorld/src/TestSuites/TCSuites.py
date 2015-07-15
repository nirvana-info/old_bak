'''
Created on 2010-11-3

@author: ChristieDuan
'''

import unittest
#from TestCases.MoreSubcategoriesTestCases import PlaceMoreSubCateOrders
from TestCases.MoreSubcategoriesTestCases import PlaceMoreSubCateOrders


def MoreSubCategoriesTest():
    suite=unittest.TestSuite()
    suite.addTest(PlaceMoreSubCateOrders("test001_ymmCat_TonneauCovers_SnapTonneauCover"))
    return suite



    
