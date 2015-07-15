'''
Created on 2011-02-02

@author: iris.chen
'''

import PublicFunctions

## Verify values in product detail page
def Verify_SKU(self,value):
    PublicFunctions.my_wait_element(self,"//input[@type='image' and @onclick='return chksubmit()']")
    self.assertEqual(self.selenium.get_text("//span[@class= 'VariationProductSKU']"),value)
    
def Verify_Brand(self,value):
    PublicFunctions.my_wait_element(self,"//input[@type='image' and @onclick='return chksubmit()']")
    self.assertEqual(self.selenium.get_text("//div[@id='ProductDetails']/div/form/div/dl[1]/dd[7]/a"),value) 

def Verify_Category(self,value):
    PublicFunctions.my_wait_element(self,"//input[@type='image' and @onclick='return chksubmit()']")
    self.assertEqual(self.selenium.get_text("//div[@id='ProductByCategory']/div/li[1]/a"),value) 
    

