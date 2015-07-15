'''
Created on 2010-11-3

@author: Administrator
'''

from TestBase import TestBase
import Selection
import AddCart
import FunctionCommon

class Place0or1CatesOrders(TestBase):

    def test001_ymmCat_BedLiners(self):
         Selection.Categories_QP(self,"Bed Liners")
         Selection.Year(self,"2010")
         Selection.Make(self,"GMC")
         Selection.SubCategories_options(self,"Bed Rug")
         FunctionCommon.my_wait_element(self,"//img[@alt=\'View Products\']")
         self.selenium.click("//img[@alt=\'View Products\']")
         Selection.Products(self)
         AddCart.AddCart(self,"1")

    def test002_ymmCat_DuHaUnderseatStorage(self):
         Selection.Categories_QP(self,"Du-Ha Underseat Storage")
         Selection.Year(self,"2010")
         Selection.Products(self)
         AddCart.AddCart(self,"1")
         
    def test003_ymmCat_EngineDressUp(self):
         Selection.Categories_QP(self,"Engine Dress Up")
         Selection.Year(self,"2010")
         Selection.Products(self)
         AddCart.AddCart(self,"1") 
               
    def test004_Cat_BedLiners(self):
         Selection.Categories_QP(self,"Bed Liners")
         Selection.SubCategories_options(self,"Chevrolet Logo")
         Selection.Products(self)
         AddCart.AddCart(self,"1")

    def test005_Cat_DuHaUnderseatStorage(self):
         Selection.Categories_QP(self,"Du-Ha Underseat Storage ")
         Selection.Products(self)
         AddCart.AddCart(self,"1")
         
    def test006_Cat_EngineDressUp(self):
         Selection.Categories_QP(self,"Engine Dress Up")
         Selection.Products(self)
         AddCart.AddCart(self,"1")
         
