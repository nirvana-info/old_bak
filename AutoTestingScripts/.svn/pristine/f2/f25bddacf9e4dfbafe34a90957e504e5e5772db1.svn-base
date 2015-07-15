

from selenium import selenium
import unittest
import PublicFunctions
import FunctionCommon
import time

class TestBase(unittest.TestCase):
    def setUp(self):
        self.verificationErrors = []
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
        PublicFunctions.my_wait_element(self,"side_selected_year")
        a1=self.selenium.get_text("side_selected_year")
        a2=self.selenium.get_text("side_selected_make")
        a3=self.selenium.get_text("side_selected_brand")
        a4=self.selenium.get_text("side_selected_category")
        if (a1 or a2 or a3 or a4) == "" :
            return True
        else:
            FunctionCommon.Clear(self,"all")
#    def tearDown(self):
#        self.selenium.stop()
#        self.assertEqual([], self.verificationErrors)
  

