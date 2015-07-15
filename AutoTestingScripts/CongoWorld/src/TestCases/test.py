'''
Created on 2010-11-3

@author: Administrator
'''
import sys  
import unittest
import time
from Appobjects.selenium import selenium
import Appobjects.PublicFunctions as aa
import Appobjects.Selection as Selection 
import Appobjects.PublicFunctions as PublicFunctions
import Appobjects.Mutil_Selection as Mutil_Selection
import Appobjects.FunctionCommon as FunctionCommon

class Test(unittest.TestCase):


    def testName(self):
#        for i in range(10):
#            time.sleep(0.5)
#            print "Tick!"

        self.selenium = selenium("localhost", 4444, "*chrome", "http://dev.lofinc.net/")
        self.selenium.start()
        self.selenium.set_timeout("0")
        sel=self.selenium
        sel.open("/")
        for i in range(0, 30):
            if self.selenium.is_element_present("login_email") == True:
                self.selenium.type("login_email","ni@ni.com")
                self.selenium.type("login_pass","123456")
                self.selenium.click("LoginButton")
            else :
                time.sleep(1)
       
        PublicFunctions.my_wait_element(self,"//div[@id='LayoutColumn1']/div[2]/div[1]/div[1]/ul[1]/li[2]/img",10)
        if PublicFunctions.my_wait_element(self,"//input[@value='2010']",10) is False:
            self.selenium.click("//div[@id='LayoutColumn1']/div[2]/div[1]/div[1]/ul[1]/li[2]/img")   
            PublicFunctions.my_wait_element(self,"//input[@value='2010']",10)
        self.selenium.click("//input[@value='2010']" )
         
#        Mutil_Selection.Year(self,"2010")
#        Mutil_Selection.Make(self,"GMC")
#        Mutil_Selection.Brand(self,"Stampede")
#        FunctionCommon.Browser(self)
#        Mutil_Selection.Series_options(self,"Stampede Sunroof Wind Deflector Windtamers")

#        Mutil_Selection.Categories_QP(self,"Air Filter")
#        self.selenium.click("//input[@class='searchBtn']")
#        #Mutil_Selection.SubCategories_select(self,"Snap Tonneau Cover")   
#        PublicFunctions.my_wait_element(self,"side_selected_year")
#        a1=self.selenium.get_text("side_selected_year")
#        a2=self.selenium.get_text("side_selected_make")
#        a3=self.selenium.get_text("side_selected_brand")
#        a4=self.selenium.get_text("side_selected_category")
#        print a1,a2,a3,a4
#        if (a1 or a2 or a3 or a4) == "" :
#            return True
#        else:
#            FunctionCommon.Clear(self,"all")
#        

#        print self.selenium.get_text("//div[@id='LayoutColumn2']/div[1]/ul[1]li[2]/span")

#        PublicFunctions.my_wait_element(self,"//div[@id='LayoutColumn1']")   
#        PublicFunctions.my_wait_element(self,"//div[@id='LayoutColumn1']/div[2]/div[1]/div[1]/ul[1]/li[2]/img")
#        self.selenium.click("//div[@id='LayoutColumn1']/div[2]/div[1]/div[1]/ul[1]/li[2]/img")
#        self.selenium.click("//div[@id='LayoutColumn1']/div[2]/div[1]/div[2]/ul[1]/li[2]/img")

        #print PublicFunctions.my_wait_element(self,"SideYmmList")

#        #in_str = "ABC \'%s\' this is a test?" % "Jim"
#        #print in_str
#       
#        
#        
#        #value='6'
#        #print "//input[@name='brand[]' and @value=\'%s\']" % value
#        #print "//ul[@id='FavBrands']/li[%s]/a[1]/img" % value
#        print aa.Wait_element_appears(self,"lang_Signout", 60)
#        print  self.assertTrue(True)
##        aa.my_wait_element(self,"side_selected_brand")
##        print  self.selenium.get_text("side_selected_brand")
#        pass
#        
#        

if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()