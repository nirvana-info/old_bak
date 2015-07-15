

from selenium import selenium
import unittest
import PublicFunctions
import FunctionCommon
import time

class TestBase1(unittest.TestCase):
    def setUp(self):        
        self.verificationErrors = []
        self.selenium = selenium("localhost", 4444, "*firefox3 E:/Program Files/Mozilla Firefox/firefox.exe", "http://www.lofinc.net/login/account")
        sel=self.selenium
        sel.start()
        sel.set_timeout("0")        

       
##    def tearDown(self):
##        self.selenium.click("lang_Signout")
##        self.selenium.wait_for_page_to_load("5000")
##        self.selenium.stop()
##        self.assertEqual([], self.verificationErrors)
  

