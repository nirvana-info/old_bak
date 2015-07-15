'''
Created on 2011-02-25

@author: iris chen
'''
from TestBase1 import TestBase1
import AddCart
import FunctionCommon
import PublicFunctions
import Mutil_Selection
import Payment
import unittest
import time
import HTMLTestRunner


### Test cases

class  OpenSite(TestBase1):
    def test010_OpenSite(self):
        sel = self.selenium
        sel.open("/admin/")

        #Login
        for i in range(0,30):
            if sel.is_element_present("SubmitButton") == True:
                sel.type("username","nirvana")
                sel.type("password","Nv0803")
                sel.click("SubmitButton")
                break
            else:
                time.sleep(1)

        PublicFunctions.my_wait_element(self,"link=Home")
        sel.click("link=Home")   
              
##Test Suite
def OpenSiteTest():
    suite=unittest.TestSuite()
    suite.addTest(OpenSite("test010_OpenSite")) 
  
    return suite

## Test Execute

if __name__ == "__main__":
    fp = file('CongoWorld Auto-Testing Result_CategoriesOrders_MoreSubcategories.html', 'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp, title='Quick Test', description='The test report of selenium')    
    runner.run(OpenSiteTest())
