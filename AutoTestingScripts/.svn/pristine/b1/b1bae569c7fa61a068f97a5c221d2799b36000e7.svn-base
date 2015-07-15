

from selenium import selenium
import unittest
import PublicFunctions
import FunctionCommon
import time

class TestBase(unittest.TestCase):
    def setUp(self):        
        self.verificationErrors = []
        self.selenium = selenium("localhost", 4444, "*firefox3 E:/Program Files/Mozilla Firefox/firefox.exe", "http://www.lofinc.net/login/account")
        sel=self.selenium
        sel.start()
        sel.set_timeout("0")        
        sel.open("/")

        # Login
        for i in range(0, 30):
            if sel.is_element_present("login_email") == True:
                sel.type("login_email","ni@ni.com")
                sel.type("login_pass","123456")
                sel.click("LoginButton")
                break
            else :
                time.sleep(1)

        PublicFunctions.my_wait_text_present(self, "Quick Search")  

        # If YMM have values, clean them.
        IsClean = True
        if sel.is_element_present("//span[@id='side_selected_year']/label") == True:
            IsClean = False 
        elif sel.is_element_present("//span[@id='side_selected_make']/label") == True:
            IsClean = False
        elif sel.is_element_present("//span[@id='side_selected_model']/label") == True:
            IsClean = False

        if IsClean == False:
            FunctionCommon.Clear(self,"all")
            
##        a1=self.selenium.get_text("side_selected_year")
##        a2=self.selenium.get_text("side_selected_make")
##        a3=self.selenium.get_text("side_selected_brand")
##        a4=self.selenium.get_text("side_selected_category")
##        if (a1 or a2 or a3 or a4) == "" :
##            return True
##        else:
##            FunctionCommon.Clear(self,"all")
            
    def tearDown(self):
        self.selenium.click("lang_Signout")
        self.selenium.wait_for_page_to_load("10000")
        self.selenium.stop()
        self.assertEqual([], self.verificationErrors)
  

